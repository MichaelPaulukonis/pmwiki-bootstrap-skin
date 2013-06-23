/*
  jakefile.js for pmwiki-bootstrap-skin

  TODO: project-path should come from an external config file
  only default path-values should be committed to repo
  TODO: alternate paths should be available, so changes can be pushed to test installs
  
  */

desc('This is a simple complete-project copy.');
task('default', [], function () {
    jake.cpR("./", "D:/projects/pmwiki-bootstrap-skin");
    });