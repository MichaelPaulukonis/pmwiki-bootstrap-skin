<?php if (!defined('PmWiki')) exit();
/*  Copyright 2013 Michael Paulukonis
    This file is bootstrap-fluid.php; part of the bootstrap skin for pmwiki 2
    you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
*/


/* Dropdowns
   Used in menu sections (navbar, etc). To use, insert:

   (:bgroups title=Groups pattern=pattern exclude=glob:)

   where title is the setting for the dropdown group.

   ganked from https://github.com/tamouse/pmwiki-bootstrap-skin/blob/dropdowns/bootstrap.php
*/
Markup("bdropdown",">links","/\\(:bdropdown\s*(.*?)\s*:\\)/e",
       "BDropdownMenu('$1')");

function BDropdownMenu($inp) {

    $defaults = array('title'=>'Dropdown');
    $args = array_merge($defaults, ParseArgs($inp));

    $inline_code_begin = "<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>".$args['title']."<b class='caret'></b></a><ul class='dropdown-menu'>";
    $inline_code_end = "</ul></li>";

    // if we're using MakePageList, we have to pass ALL the opts along...
    // in this case, named $args
    $group_list = BGetWikiPages($args);
    $formatted_list = BBuildGroupList($group_list);

    return Keep($inline_code_begin.$formatted_list.$inline_code_end);

}

// $args is the entire opts string pagges along to MakePageList, generally
// there's a handful of extras that we use for other purposes.
// MakePageList will ignore them (if we don't use its param-list)
function BGetWikiPages($args) {

    $pl = MakePageList('', $args);
    $gl = array();
    foreach($pl as $page) {
        list ($group, $name) = explode('.',$page['name']);
        $gl[] = "($group.)$name";
    }

    sort($gl);
    return $gl;

}


/*
  HTML based on code from http://scottgalloway.blogspot.com/2012/08/twitter-bootstrap-nested-nav-lists.html
  MakeLink is a core pmwiki function defined in pmwiki.php
 */
function BBuildGroupList($list) {
    $out = '';

    $group = '';
    foreach($list as $page) {
        # if group name is empty or != previous group name, capture it and start new unordered list
        # TODO: if only one group is present (or some param indicated to do so)
        # menu will be flat
        preg_match('/\((.*?).\)/', $page, $matches);
        if ($group == '' || $group != $matches[1]) {

            # only close if a group has been set
            if ($group != '') {
                $out .= "</ul></li>";
            }

            $group = $matches[1];

            $out .= "<li class='nav nav-list'>$group<b class='caret'></b>";
            $out .= "<ul class='dropdown-menu'>";
        }

        $out .= '<li>';
        $out .= MakeLink($pagename, $page);
        $out .= '</li>';
    }

    $out .= "</ul></li>";

    return $out;
}
