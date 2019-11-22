# CakePHP Test App Plugin

[![Build Status](https://travis-ci.com/fr3nch13/cakephp-pta.svg?branch=master)](https://travis-ci.com/fr3nch13/cakephp-pta)
[![Coverage Status](https://img.shields.io/codecov/c/github/fr3nch13/cakephp-pta.svg?style=flat-square)](https://codecov.io/github/fr3nch13/cakephp-pta)
[![Total Downloads](https://img.shields.io/packagist/dt/fr3nch13/cakephp-pta.svg?style=flat-square)](https://packagist.org/packages/fr3nch13/cakephp-pta)
[![Latest Stable Version](https://img.shields.io/packagist/v/fr3nch13/cakephp-pta.svg?style=flat-square)](https://packagist.org/packages/fr3nch13/cakephp-pta)

This CakePHP Plugin is used to emulate a generic App when testing your CakePHP Plugins.

I was originally using the cakephp/app as that is the up to date skeleton app, but many of my plugins
share many of the same things, and this plugin is meant to keep them dry.

As an example: the `test/bootstrap.php` file. When I need to change/add something to that, I have to do
it in over 10 CakePHP plugins. It's easier to just put the common stuff in here, and include the `tests/bootstrap.php` from here. Similar to how baked plugins do with the core test/bootstrap.php.
