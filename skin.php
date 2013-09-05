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






