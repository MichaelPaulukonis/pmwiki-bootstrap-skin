<?php

include 'test.config.php';
require_once($simpletestPath."/autorun.php");
$EnableActions = 0; /* prohibit pmwiki output */
require_once($pmwikiPath); /* the trouble is... the wiki-engine wants things wihtin itself. and our skin is not there.... */
require_once(dirname(__FILE__).'/../skin.php');


# TODO: names
class TestOfWiki extends UnitTestCase {
    function testWikiStyleAppliedToLinks() {

        global $WikiStyleApply;

        /* print_r($WikiStyleApply); */
        # in PmWikiKit this was provided within the blogit module
        # we should make it available independently
        $this->assertEqual($WikiStyleApply['link'], 'a');

    }

    function testBuildGroupList() {

        /*
           to generate the extract below
           print_r(GetWikiPages("PmWiki*", ""));
        */
        $group_list = [
            "(PmWiki.)AccessKeys",
            "(PmWiki.)Audiences",
            "(PmWiki.)AuthUser",
            "(PmWiki.)AvailableActions",
            "(PmWiki.)BackupAndRestore",
            "(PmWiki.)BasicEditing"
        ];

        /*
          to generagte the extract below
          echo(BuildGroupList($group_list));
        */
        $builtlist = "<li class='nav nav-list'>PmWiki<b class='caret'></b><ul class='dropdown-menu'>";
        $builtlist .= "<li><a class='wikilink' href='http://./test/test.php?n=PmWiki.AccessKeys'>AccessKeys</a></li>";
        $builtlist .= "<li><a class='wikilink' href='http://./test/test.php?n=PmWiki.Audiences'>Audiences</a></li>";
        $builtlist .= "<li><a class='wikilink' href='http://./test/test.php?n=PmWiki.AuthUser'>AuthUser</a></li>";
        $builtlist .= "<li><a class='wikilink' href='http://./test/test.php?n=PmWiki.AvailableActions'>AvailableActions</a></li>";
        $builtlist .= "<li><a class='wikilink' href='http://./test/test.php?n=PmWiki.BackupAndRestore'>BackupAndRestore</a></li>";
        $builtlist .= "<li><a class='wikilink' href='http://./test/test.php?n=PmWiki.BasicEditing'>BasicEditing</a></li></ul></li>";

        // a potential problem is this is dependent upon certain pages existing
        // this is slightly mitigated by those particular pages being part of a default install
        $this->assertEqual(BuildGroupList($group_list), $builtlist);

    }
}

?>