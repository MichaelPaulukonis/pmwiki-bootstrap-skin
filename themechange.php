<?php if (!defined('PmWiki')) exit();
/*  Copyright 2013 Michael Paulukonis
    This file is themechange.php; part of the bootstrap skin for pmwiki 2
    you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
*/

# set configs via actions....
/* TODO: say, it would be interesting (if not downright useful for my own website)
   to be able to have a single-page theme markup
   as in -- use on THIS PAGE ONLY
   hrm.....

 */

global $Now, $CookiePrefix, $BootstrapThemeCookie, $BootstrapCoreCookie, $BootstrapNavbarCookie,
        $BootstrapTheme, $BootstrapCore, $BootstrapNav;

# set cookie expire time (default 1 year)
SDV($BootstrapCookieExpires,$Now+60*60*24*365);

$prefix = $CookiePrefix.$SkinName.'_';

SDV($SkinCookie, $prefix.'settheme');

# bootstrap cookie routine
# settheme changes the skin "permanently" (until cookie expires)
# theme temporarily changes the theme, but will revert to the cookie-settings next time
# setcore/core permanently/temporarily changes the core Bootstrapp
SDV($BootstrapThemeCookie, $prefix.'settheme');
SDV($BootstrapCoreCookie, $prefix.'setcore');

if (isset($_GET['clearbootcookies'])) {
    $expired = time()-3600;
    setcookie($BootstrapThemeCookie, '', $expired);
    setcookie($BootstrapCoreCookie, '',$expired);
    setcookie($BootstrapNavbarCookie, '', $expired);
    $ignorecookies = true;
}

if (!$ignorecookies && isset($_COOKIE[$BootstrapThemeCookie])) {
        $theme = $_COOKIE[$BootstrapThemeCookie];
}
if (isset($_GET['settheme'])) {
        $theme = $_GET['settheme'];
        setcookie($BootstrapThemeCookie, $theme, $BootstrapCookieExpires, '/');
}
if (isset($_GET['theme'])) {
        $theme = $_GET['theme'];
}
if (! isset($theme)) {
        $theme = $BootstrapTheme;
}


if (!$ignorecookies && isset($_COOKIE[$BootstrapCoreCookie])) {
        $core = $_COOKIE[$BootstrapCoreCookie];
}
if (isset($_GET['setcore'])) {
        $core = $_GET['setcore'];
        setcookie($BootstrapCoreCookie, $core, $BootstrapCookieExpires, '/');
}
if (isset($_GET['core'])) {
        $core = $_GET['core'];
}
if (! isset($core)) {
        $core = $BootstrapCore;
}

# presence of navbar cookie will over-ride any defaults that may be set per theme
# ie, darkstrap and default bootstrap use inverse. because I think it looks better
if (!$ignorecookies && isset($_COOKIE[$BootstrapNavbarCookie])) {
        $navbar = $_COOKIE[$BootstrapNavbarCookie];
}
if (isset($_GET['setnavbar'])) {
        $navbar = $_GET['setnavbar'];
        setcookie($BootstrapNavbarCookie, $navbar, $BootstrapCookieExpires, '/');
}
if (isset($_GET['navbar'])) {
        $navbar = $_GET['navbar'];
        $navbar = ($navbar == 'inverse' ? 'navbar-inverse' : '');
}
if (! isset($navbar)) {
        $navbar = $BootstrapNavbar;
        $navbar = ($navbar == 'inverse' ? 'navbar-inverse' : '');
}



### end cookies

if ($core == 'compass') {
        $HTMLHeaderFmt['core-css'] =
                "<link href='$SkinDirUrl/css/screen.css' rel='stylesheet'>";
} else {
        $HTMLHeaderFmt['core-css'] =
                "<link href='$SkinDirUrl/css/bootstrap.css' rel='stylesheet'>
         <link href='$SkinDirUrl/css/bootstrap-responsive.css' rel='stylesheet'>";
}

if ($theme == 'flatui') {
        $HTMLHeaderFmt['option-css'] =
                "<link href='$SkinDirUrl/css/flat-ui.css' rel='stylesheet'>";

        if (! isset($navbar)) $navbar = 'navbar-inverse';

} else if ($theme =='bootstrap') {

        $HTMLHeaderFmt['option-css'] = "";

        if (! isset($navbar)) $navbar = '';

} else {

        ## check for existence of file $theme.cs and pmwiki.$theme.css
        ## use if the first one exists
        ## otherwise use the default bootstrap

        if (file_exists("$SkinDir/css/$theme.css")) {

            $HTMLHeaderFmt['option-css'] =
                "<link href='$SkinDirUrl/css/$theme.css' rel='stylesheet'>";

        } else {

            $HTMLHeaderFmt['option-css'] = "";
        }

        if (file_exists("$SkinDir/css/pmwiki.$theme.css")) {

            $HTMLHeaderFmt['option-css2'] =
                "<link href='$SkinDirUrl/css/pmwiki.$theme.css' rel='stylesheet'>";

        } else {

            $HTMLHeaderFmt['option-css2'] = "";
        }

        if (! isset($navbar)) $navbar = '';

}


$PageNavStyle =
        "<div id='wikihead' class='navbar $navbar navbar-fixed-top'>";

$HTMLHeaderFmt['end-css'] =
        "<link href='$SkinDirUrl/css/pmwiki.css' rel='stylesheet' />";
