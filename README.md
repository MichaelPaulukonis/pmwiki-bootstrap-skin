Pmwiki Bootstrap Skin
=====================

A [Bootstrap](http://twitter.github.com/bootstrap/) skin for [PmWiki](http://www.pmwiki.org/) based on the original skin in [Pmwiki Kit](https://github.com/gambhiro/pmwiki-kit-bootstrap-compass).

Follow development at the [Trello board](https://trello.com/board/pmwiki-bootstrap-skin/5197cef04b5cafe37e00d1ed)

Notes also at [PmWiki Skins](http://www.pmwiki.org/wiki/Skins/TwitterBootstrap)

Can be seen live  http://michaelpaulukonis.com/wikimain/Bootstrap (URL subject to change)


# Installation
Copy just about everything (excluding: `jakefile.js`, `readme.md`, `package.json`, `.gitignore`) to `/path/to/pwmiki/pub/skins/bootstrap-fluid`

Add the following to config.php:

    $Skin = 'bootstrap-fluid';

# Theme selection and configuration
Use the query-params `theme` and `settheme` to temporarily or permanently change bootstrap themes for yourself. Included themes are `darkstrap`, `flatui` and the default `bootstrap`. If you upload a custom theme, set it via this method.

Use the query-params `core` and `setcore` to temporarily or permanently change bootstrap core css for yourself. Setting core to `compass` will use the Compass stylesheet originally found in [Pmwiki Kit](https://github.com/gambhiro/pmwiki-kit-bootstrap-compass). All other values will use the default bootstrap css.

Use the query-params `navbar` and `setnavbar` to temporarily or permanently change the navbar for yourself. Setting the value to `inverse` will apply the `navbar-inverse` class to the navbar. All other values will not. Default bootstrap and Darkstrap themes use inverse by default.

All of the above values can be set for all users in `config.php` with the following values: `$BootstrapTheme`, `$BootstrapCore`, `$BootstrapNav`.

# Markup
See the included pages `Bootstrap.Boostrap`, `Bootstrap.Markup` and `Bootstrap.Sandbox` pages for markup examples. 

# Screenshots

## Default theme
![default screenshot](https://raw.github.com/wiki/MichaelPaulukonis/pmwiki-bootstrap-skin/images/pmwiki.bootstrap.default.00.png)

## Darkstrap theme
![darkstrap screenshot](https://raw.github.com/wiki/MichaelPaulukonis/pmwiki-bootstrap-skin/images/pmwiki.bootstrap.darkstrap.00.png)

# Roadmap

* zip-file for installation
* Improved handling of top-menu components
* Bootstrap dropdowns (nested)
* More markup documentation.
* Better markup support for Bootstrap components.
* Documentation on how to add new Bootstrap themes.
* Better theme-switcher.
* Live demo!
