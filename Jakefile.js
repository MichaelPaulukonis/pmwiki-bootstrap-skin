/*
  jakefile.js for pmwiki-bootstrap-skin

  TODO: project-path should come from an external config file
  only default path-values should be committed to repo
  TODO: alternate paths should be available, so changes can be pushed to test installs

  */

var open = require('open'),
    pkgjson = require('./package.json'),
    releaseTools = require('releasetools');


// task('default', ['push']); // if I could figure out a way to pass a parameter here, I would

desc('dump');
task('dump', [], function() {
    var config = require('./config');
    console.log(config);
});

desc('Push the project (no ignore) to the config location passed in..');
task('push', [], function (location) {

	var config = require('./config');
    if (! config.target.hasOwnProperty(location)) {
        console.error(location + ' is not a valid location. Try one of the following:');
        console.log(config.target);
        return;
    }
    console.log(config.target[location]);
    push(config.target[location]);
    });


var push = function(target) {

    var path = require("path"),
        fs = require("fs");

    var copy = function(file) {
        var dest = path.join(target, path.dirname(file));
        jake.mkdirP(dest);
        jake.cpR(file, dest); // although this is recursive, if the directory doesn't exist... creates a file of the same name. hunh.
    };

    getProjectFiles().toArray().map(copy);

    };


desc('Open remote repo in browser');
task('openweb', [], function() {
	var config = require('./config');
    open(config.remote);
});



desc('Zip up the project.');
task('zip', [], function() {

    var name = 'bootstrap-skin';

    var version = pkgjson.version;

    var AdmZip = require('adm-zip'),
        path = require('path');
    var zip = new AdmZip();


    var addFile = function(file) {

        var dir = path.dirname(file);
        if (dir === '.') { dir = ''; } // addLocalFile doesn't resolve '.'

        console.log('addLocalFile(' + file + ', ' + dir + ');');

        zip.addLocalFile(file, dir);

    };

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

    return list;
};

// switching to semantic-versioning, from the package.json file?
// or not. who knows.
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

// NOTE: fails if you have uncommitted changes. SO DO THIS FIRST. 
// WTF?!??!
desc('Bump version in package.json');
task('bump', function(releaseType) {
    releaseType = releaseType || 'patch';
    console.log('Bumping version in package.json...');
    releaseTools.updateVersionInPackageJson(releaseType, function(err, oldVersion, newVersion) {
        if (err) {
            fail('Error while updating version in package.json: ' + err);
        }
        console.log(oldVersion + ' --> ' + newVersion);
        console.log('Done!');
        complete();
    });
}, true);
