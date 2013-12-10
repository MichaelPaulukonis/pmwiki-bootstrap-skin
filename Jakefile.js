/*
  jakefile.js for pmwiki-bootstrap-skin

  TODO: project-path should come from an external config file
  only default path-values should be committed to repo
  TODO: alternate paths should be available, so changes can be pushed to test installs

  */

var open = require('open');
var config = require('./config');


// task('default', ['push']); // if I could figure out a way to pass a parameter here, I would

desc('dump');
task('dump', [], function() {
    console.log(config);
});

desc('Push the project (no ignore) to the config location passed in..');
task('push', [], function (location) {

    if (! config.target.hasOwnProperty(location)) {
        console.error(location + ' is not a valid location. Try one of the following:');
        console.log(config.target);
        return;
    }
    console.log(config.target[location]);
    push(config.target[location]);
    });



var push = function(target) {
    // TODO: this is more complicated
    // we want to ignore things. or only hit certain things. :::sigh:::
    jake.mkdirP(target);
    jake.cpR("./", target);
    };


// TODO: zip

desc('Open remote repo in browser');
task('openweb', [], function() {
    open(config.remote);
});



// TODO:
// delete temp if already exists
// create temp folder
// copy included files to temp
// zip temp
// allow temp folder to remain
desc('Zip up the project.');
task('zip', [], function() {

    var name = 'bootstrap-skin';

    var version = getDateFormatted();

    var AdmZip = require('adm-zip');
    var zip = new AdmZip();


    var addFile = function(file) {

        // UGH. this is system-dependent. is there another way to do this?
        // say, from fs?
        var path = file.substring(0, file.lastIndexOf('/') + 1);

        // console.log('path: ' + path + ' file: ' + file);
        console.log('addLocalFile(' + file + ', ' + path + ');');

        zip.addLocalFile(file, path);

    };

    // as it stands, everything is added, hooray!
    // only in a flat structure, no sub-folders. boo.
    // getProjectFiles().toArray().map(function(file) { zip.addLocalFile(file);});

    getProjectFiles().toArray().map(addFile);

    zip.writeZip(name + '.' + version + '.zip');


    // isn't working. not sure what I'm doing wrong
    // var t = new jake.PackageTask(name, version, function() {

    //     // this.packageFiles.items = getProjectFiles();
    //     var files = [ 'd:/temp/WebText/001.html', 'd:/temp/WebText/002.html'];
    //     this.packageFiles.items = files;

    //     console.log(this.packageFiles.items);

    //     this.needZip = true;

    // });

});


var getProjectFiles = function() {

    var list = new jake.FileList();

    list.exclude(/.*bak.*/);

    list.include('*.php');
    list.include('bootstrap-fluid.tmpl');
    list.include('wikilib.d/*.*');
    list.include('images/*.*');
    list.include('javascripts/*.*');
    list.include('css/screen.css');
    list.include('css/bootstrap.css');
    list.include('css/bootstrap-responsive.css');
    list.include('css/flat-ui.css');
    list.include('css/darkstrap.css');
    list.include('css/pmwiki.css');

    // console.log(list);

    return list;
};


var getDateFormatted = function() {
    var d = new Date();
    var df = d.getFullYear() + '.' + pad((d.getMonth() + 1), 2) + '.' + pad(d.getDate(), 2);
    return df;
};

var pad = function(nbr, width, fill) {
    fill = fill || '0';
    nbr = nbr + '';
    return nbr.length >= width ? nbr : new Array(width - nbr.length + 1).join(fill) + nbr;
};

var tempname = function() {
    return "build"; // that will do for now....
};
