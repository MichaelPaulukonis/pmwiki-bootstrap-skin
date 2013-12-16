<?php

require_once('simpletest/autorun.php');
$EnableActions = 0;
global $WikiStyleApply;
require_once('c:/dev/xampp/htdocs/projects/pmwikitest/pmwiki.php');
require_once('./skin.php');


# TODO: names
class TestOfWiki extends UnitTestCase {
    function testWikiStyleAppliedToLinks() {

        global $WikiStyleApply;

        # in PmWikiKit this was provided within the blogit module
        # we should make it available independently
        $this->assertEqual($WikiStyleApply['link'], 'a');

    }
}

?>