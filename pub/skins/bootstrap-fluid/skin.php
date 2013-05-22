 <?php if (!defined('PmWiki')) exit();
/*  Copyright 2013 Michael Paulukonis
    based on the work by gambiro
    This file is bootstrap-fluid.php; part of the bootstrap skin for pmwiki 2
    you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
*/

global $RecipeInfo, $SkinName, $SkinRecipeName, $WikiStyleApply, $PageLogoUrl;
# Some Skin-specific values
$RecipeInfo['BootstrapSkin']['Version'] = '2013-05-20';
$SkinName = 'bootstrap-fluid';
$SkinRecipeName = "BootstrapSkin";

# for use in conditional markup  (:if enabled TriadSkin:)
global $BootstrapSkin; $BootstrapSkin = 1;


$PageLogoUrl = "$SkinDirUrl/images/ico/favicon.png";

## required for apply-actions
$WikiStyleApply['link'] = 'a';  #allows A to be labelled with class attributes


Markup('button', '>markupend',
       '/\\(:button(\\s+.*?)?:\\)/ei',
  "SourceBlock(PSS('$1 '))");

function SourceBlock($args) {

  $opt = ParseArgs($args);

  // expect link, class, text
  // newwin is optional; if not provided, or anything but "true" open in current window (default behavior)
  $newwin = '';
  if ($opt['newwin'] == 'true') {
          $newwin = 'newwin';
  }

  $link = '[[%s|%s]]%%apply=link %s class=%s%%';
  $linkf = sprintf($link, $opt['link'], $opt['text'], $newwin, $opt['class']);

  return $linkf;

}