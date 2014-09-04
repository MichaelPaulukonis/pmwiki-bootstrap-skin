<?php if (!defined('PmWiki')) exit();
/*  Copyright 2014 Michael Paulukonis
    This file is dropdown.php; part of the bootstrap skin for pmwiki 2
    you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
*/


/* Dropdowns
   Used in menu sections (navbar, etc). To use, insert:

   (:bdropdown title=Groups <other params> :)

   where title is the setting for the dropdown group, and <other params> are standard pagelist parameters

   NOTE: proper display requires the containing list (ul or ol) to have the class "nav" applied
         this must be applied to the first item on the list, if it is not the dropdown
         AFAIK, this cannot be done programmatically from within this markup code

   NOTE: use of multiple link= targets requires the PageListMultiTargets recipe
         http://www.pmwiki.org/wiki/Cookbook/PageListMultiTargets
         currently this is included via config.php
         Should include it here w/in recipe

   Inspired by code from https://github.com/tamouse/pmwiki-bootstrap-skin/blob/dropdowns/bootstrap.php
*/
Markup("bdropdown",">links","/\\(:bdropdown\s*(.*?)\s*:\\)/e",
       "BDropdownMenu('$1')");

/* NOTE: the "B" prefix is temporary, as previous markup uses the same names (without "B" prefix)
         Once that code is removed, this should be updated to remove the "B"
*/
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

/* $args is the entire opts string passed along to \scripts\pageslist.php->MakePageList, 
   generally there's a handful of extras that we use for other purposes.
   MakePageList will ignore them (if we don't use its param-list)
   TODO if only one group is returned, or a parameter indicating "FLAT" is provided
        the list should be built "flat" => one list, without sub-lists
*/
function BGetWikiPages($args) {

    $pages = MakePageList('', $args);
    $grouplist = array();
    foreach($pages as $page) {
        list ($group, $name) = explode('.',$page['name']);
        $grouplist[] = "($group.)$name";
    }

    sort($grouplist);
    return $grouplist;

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
