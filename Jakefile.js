/*
  jakefile.js for pmwiki-bootstrap-skin

  TODO: project-path should come from an external config file
  only default path-values should be committed to repo
  TODO: alternate paths should be available, so changes can be pushed to test installs
  
  */

var open = require('open');
var config = require('./config');

desc('dump');
task('dump', [], function() {
    console.log(config);
});

desc('This is a simple complete-project copy.');
task('default', [], function () {
    push(config.target.wikitest);
    });

desc('This is a simple complete-project copy.');
task('freelance', [], function () {
    push(config.target.freelance);
    });

var push = function(target) {
    // TODO: this is more complicated
    // we want to ignore things. or only hit certain things. :::sigh:::
    jake.cpR("./", target);
    };


// TODO: zip

desc('Open remote repo in browser');
task('openweb', [], function() {
    open(config.remote);
});