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
    // push(config.target[location]);
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