/*
  jakefile.js for pmwiki-bootstrap-skin

  TODO: project-path should come from an external config file
  only default path-values should be committed to repo
  TODO: alternate paths should be available, so changes can be pushed to test installs
  
  */

// TODO: should be working in project folder, and push changes back to test targer
// oh well. will get this right one of these days....

// c:\dev\xampp\htdocs\projects\pmwikitest\pub\skins\bootstrap-fluid\Jakefile.js

var target = {
    wikitest: 'c:/dev/xampp/htdocs/projects/pmwikitest/pub/skins/bootstrap-fluid/',
    freelance: 'C:/dev/xampp/htdocs/freelance/shahjahan/wikidocs/pub/skins/bootstrap-fluid/'
    };

desc('This is a simple complete-project copy.');
task('default', [], function () {
    push(target.wikitest);
    });

desc('This is a simple complete-project copy.');
task('freelance', [], function () {
    push(target.freelance);
    });

var push = function(target) {
    jake.cpR("./", target);
    };


// TODO: zip
// TODO: package.json for adm-zip etc.