# CakePHP Test App Plugin

[![Build Status](https://travis-ci.org/fr3nch13/cakephp-pta.svg?branch=master)](https://travis-ci.org/fr3nch13/cakephp-pta)
[![Coverage](https://codecov.io/gh/fr3nch13/cakephp-pta/branch/master/graph/badge.svg)](https://codecov.io/gh/fr3nch13/cakephp-pta)
[![Total Downloads](https://img.shields.io/packagist/dt/fr3nch13/cakephp-pta.svg?style=flat-square)](https://packagist.org/packages/fr3nch13/cakephp-pta)
[![Latest Stable Version](https://img.shields.io/packagist/v/fr3nch13/cakephp-pta.svg?style=flat-square)](https://packagist.org/packages/fr3nch13/cakephp-pta)

This CakePHP Plugin is used to emulate a generic App when testing your CakePHP Plugins.

I am using the cakephp/app as that is the up-to-date skeleton app, and many of my plugins
share many of the same things. This plugin is meant to keep them dry.

As an example: the `test/bootstrap.php` file. When I need to change/add something to that, I have to do
it in over 10 CakePHP plugins. It's easier to just put the common stuff in here, and include the `tests/plugin_bootstrap.php` from here. Similar to how baked plugins do with the core `test/bootstrap.php`.

### Installation

To use this plugin's bootstrap for other plugins, add the below lines to your `tests/bootstrap.php` near the top.

```php
// define any constants you need to overwrite above these lines.
$root = dirname(__DIR__);
chdir($root);
require_once $root . '/vendor/fr3nch13/cakephp-pta/tests/plugin_bootstrap.php';
```

Then copy the folder from here: `tests/test_app_example` to your plugin's `tests` folder as `test_app`.

Once you've copied over that folder, edit your `test/test_app/src/Application.php`'s `bootstrap()` method to include your plugin. There is an example in that file.

### Version compatibility

The major versions are locked to the major versions of CakePHP.
- PTA 1.x is locked to CakePHP ^3.8
- PTA 2.x is locked to CakePHP ^4.0
