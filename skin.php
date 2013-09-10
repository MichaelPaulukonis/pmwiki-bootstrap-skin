<?php if (!defined('PmWiki')) exit();
/*  Copyright 2013 Michael Paulukonis
    This file is bootstrap-fluid.php; part of the bootstrap skin for pmwiki 2
    you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
*/



global $RecipeInfo, $SkinName, $SkinRecipeName, $WikiStyleApply, $PageLogoUrl,
        $HTMLHeaderFmt, $PageHeaderFmt, $PageNavStyle, $UseDarkstrapTheme, $UseFlatUI,
$PageEditForm, $PageTextStartFmt, $BodySpan;
# Some Skin-specific values
$RecipeInfo['BootstrapSkin']['Version'] = '2013-05-20';
$SkinName = 'bootstrap-fluid';
$SkinRecipeName = "BootstrapSkin";

# for use in conditional markup  (:if enabled TriadSkin:)
global $BootstrapSkin; $BootstrapSkin = 1;

SDV($PageEditForm, "Bootstrap.EditForm");

$PageLogoUrl = "$SkinDirUrl/images/ico/favicon.png";


## from Hans Bracker's Triad skin (version 2008-07-10)
## automatic loading of skin default config pages
global $WikiLibDirs, $SkinDir;
$where = count($WikiLibDirs);
if ($where>1) $where--;
array_splice($WikiLibDirs, $where, 0,
             array(new PageStore("$SkinDir/wikilib.d/\$FullName")));

# no code to enable/disable
# not necessary?
include_once("$SkinDir/themechange.php");

## required for apply-actions
$WikiStyleApply['link'] = 'a';  #allows A to be labelled with class attributes


Markup('button', 'links',
       '/\\(:button(\\s+.*?)?:\\)/ei',
       "Keep(BootstrapButton(PSS('$1 ')), 'L')");

function BootstrapButton($args) {

        $opt = ParseArgs($args);

        // expect link, class

        // TODO: test for options
        // TODO: handle alt params
        // TODO: handle rel=nofollow per pmwiki settings
        // what about other PmWiki shortcut-type things?
        // like... [[PmWiki/basic editing|+]]%apply=link class="btn"%

        $target = $opt['link'];
        $text = $opt['text'] ? $opt['text'] : $target; // if text not provided, default to the link
        $class = $opt['class'];

        $l = '<a href="%s" class="%s">%s</a>';
        $linkf = sprintf($l, $target, $class, $text);

        return $linkf;

}

# the markup seems to work -- it's just that the CSS isn't finding the icon set...

Markup('icon', 'inline',
       '/\\(:icon(\\s+.*?)?:\\)/ei',
       "BootstrapIcon(PSS('$1 '))");

function BootstrapIcon($args) {

       $icon = sprintf('<i class=%s ></i>', $args);

       Keep($icon);
}

# if (:noleft:) markup is present, mainbody will be span12
# otherwise, default to span9 (ie sidebar is span3)
if (! isset($BodySpan)) {
   $BodySpan = "span9";
}

Markup('noleft', 'directives',
       '/\\(:noleft:\\)/ei',
       "HideLeftBoot()");

function HideLeftBoot() {

    global $BodySpan;
    $BodySpan = "span12";

    SetTmplDisplay('PageLeftFmt',0);

}




/* Dropdowns
Used in menu sections (navbar, etc). To use, insert:

(:bgroups title="Groups":)

where title is the setting for the dropdown group.

ganked from https://github.com/tamouse/pmwiki-bootstrap-skin/blob/dropdowns/bootstrap.php




*/
Markup("bgroups",">links","/\\(:bgroupdropdown\s*(.*?)\s*:\\)/e",
       "GroupDropdownMenu('$1')");

function GroupDropdownMenu($args) {
    $args = ParseArgs($args); /* get them in a form we can use */

// TODO: if title not present, default to "Dropdown"

    $inline_code_begin = "<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>".$args['title']."<b class='caret'></b></a><ul class='dropdown-menu'>";
    $inline_code_end = "</ul></li>";

    /* For groups, we want the list of group names from the wiki.d working directory */

    $group_list = GetListOfWikiGroups();
    $formatted_list = BuildGroupList($group_list);

    /* return Keep($inline_code_begin.$formatted_list.$inline_code_end); */
    return Keep(GetBlob());
}

function GetListOfWikiGroups() {
    $pagelist = ListPages('*.RecentChanges');
    $grouplist = array();
    foreach($pagelist as $page) {
        list ($group, $name) = explode('.',$page);
        if (PageExists("$group.$group")) {
            $grouplist[]= "$group(.$group)";
        } elseif (PageExists("$group.HomePage")) {
            $grouplist[]= "$group(.HomePage)";
        }
    }
    sort($grouplist);
    return $grouplist;
}

function GetBlob() {

$blob = '<li class="dropdown">   <a class="dropdown-toggle" data-toggle="dropdown" href="http://www.blogger.com/blogger.g?blogID=7873061242057331104#">Nested Lists<b class="caret"></b></a>  <ul class="dropdown-menu"><li class="nav-header">Top Stuff</li>
<li class="nav nav-list">Nested List<b class="caret"></b>  <ul class="dropdown-menu"><li><a href="http://www.blogger.com/blogger.g?blogID=7873061242057331104#">Foo</a></li>
<li><a href="http://www.blogger.com/blogger.g?blogID=7873061242057331104#">Bar</a></li>
<li><a href="http://www.blogger.com/blogger.g?blogID=7873061242057331104#">Bat</a></li>
</ul></li>
<li class="nav nav-list">Nested List<b class="caret"></b>  <ul class="dropdown-menu"><li><a href="http://www.blogger.com/blogger.g?blogID=7873061242057331104#">Foo</a></li>
<li><a href="http://www.blogger.com/blogger.g?blogID=7873061242057331104#">Bar</a></li>
</ul></li>
<li><a href="http://www.blogger.com/blogger.g?blogID=7873061242057331104#">Sit</a></li>
<li><a href="http://www.blogger.com/blogger.g?blogID=7873061242057331104#">Amet</a></li>
<li><a href="http://www.blogger.com/blogger.g?blogID=7873061242057331104#">Dolor</a></li>
<li class="divider"></li>
<li class="nav-header">Other Stuff</li>
<li><a href="http://www.blogger.com/blogger.g?blogID=7873061242057331104#">Foo</a></li>
<li><a href="http://www.blogger.com/blogger.g?blogID=7873061242057331104#">Bar</a></li>
<li><a href="http://www.blogger.com/blogger.g?blogID=7873061242057331104#">Bat</a></li>
</ul></li>';

return $blob;

}

// TODO: make nested dropdowns possible...
// hard-code some for a test?

function BuildGroupList($grouplist) {
    $out = '';
    foreach($grouplist as $grouppage) {
        $out .= '<li>';
        $out .= MakeLink($pagename,$grouppage);
        /* $out .= '</li>'; */

        $out .= "<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>".$args['title']."<b class='caret'></b></a><ul class='dropdown-menu'>";
        $out .= '<li>';
        $out .= MakeLink($pagename,$grouppage);
        $out .= '</li>';
        $out .= "</ul></li>";

    }
    return $out;
}

Markup("bgroupbegin",">links","/\\(:bgroupbegin (\\w+):\\)/e",
       "Keep('<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">$1<b class=\"caret\"></b></a><ul class=\"dropdown-menu\">')");
Markup("bgroupend",">links","/\\(:bgroupend:\\)/",
       Keep('</ul></li>'));