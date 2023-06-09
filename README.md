# CakePHP Test App Plugin

[![Build Status](https://travis-ci.org/fr3nch13/cakephp-pta.svg?branch=master)](https://travis-ci.org/fr3nch13/cakephp-pta)
[![Coverage](https://codecov.io/gh/fr3nch13/cakephp-pta/branch/master/graph/badge.svg)](https://codecov.io/gh/fr3nch13/cakephp-pta)
[![Total Downloads](https://img.shields.io/packagist/dt/fr3nch13/cakephp-pta.svg?style=flat-square)](https://packagist.org/packages/fr3nch13/cakephp-pta)
[![Latest Stable Version](https://img.shields.io/packagist/v/fr3nch13/cakephp-pta.svg?style=flat-square)](https://packagist.org/packages/fr3nch13/cakephp-pta)
[![GitHub release](https://img.shields.io/github/release/fr3nch13/cakephp-pta.svg)](https://GitHub.com/fr3nch13/cakephp-pta/releases/)

This CakePHP Plugin is used to emulate a generic App when testing your CakePHP Plugins.

I am using the cakephp/app as that is the up-to-date skeleton app, and many of my plugins
share many of the same things. This plugin is meant to keep them dry.

As an example: the `test/bootstrap.php` file. When I need to change/add something to that, I have to do
it in over 10 CakePHP plugins. It's easier to just put the common stuff in here, and include the `tests/plugin_bootstrap.php` from here. Similar to how baked plugins do with the core `test/bootstrap.php`.

## Installation

To use this plugin's bootstrap for other plugins, add the below lines to your `tests/bootstrap.php` near the bottom.

```php
// define any constants you need to overwrite above these lines.
$root = dirname(__DIR__);
chdir($root);
require_once $root . '/vendor/fr3nch13/cakephp-pta/tests/plugin_bootstrap.php';
```

## Usage

You no longer need to copy the `tests/test_app` from this project to yours.
Instead there are other ways to inject you settings/plugin/etc into this plugin's test application:

### Adding your plugin

To add your plugin to the test application, you need to update your `test/bootstrap.php` like so:

```php
# test/bootstrap.php

// ... code ...

Configure::write('Tests.Plugins', [
    'Namespace/PluginName', // the name of your plugin
    'Fr3nch13/Jira', // Using one of my plusins as an example
]);

// plugins just for the command line
Configure::write('Tests.PluginsCli', [
    'Namespace/PluginName', // the name of your plugin
]);

// ... code ...

require_once $root . '/vendor/fr3nch13/cakephp-pta/tests/plugin_bootstrap.php';

```

### Adding your variables from a .env

In this plugin's `tests/plugin_bootstrap.php` file, it will look for your `.env` or `.env.test` files in 2 places within your plugin:
- At: `tests/.env` or `tests/.env.test`
- At: `config/.env` or `config/.env.test`

See the file [`tests/.env.example`](tests/.env.example) as an example.

If you need to import your variables before including the `plugin_bootstrap.php` like above, then you can do this:

```php
# test/bootstrap.php

// ... code ...

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(TESTS . '.env');

// ... code ...

require_once $root . '/vendor/fr3nch13/cakephp-pta/tests/plugin_bootstrap.php';

```

### Database settings.

This plugin uses sqlite in memory be default, but if you want to define your own database setting you can do so in your `tests/bootstrap.php` file, before including the `plugin_bootstrap.php` file as the database connection is setup in the `plugin_bootstrap.php` file.

```php
# test/bootstrap.php

// ... code ...

Configure::write('Tests.DbConfig', [
    'className' => 'Cake\Database\Connection',
    'driver' => 'Cake\Database\Driver\Mysql',
    'persistent' => false,
    'host' => 'database_hostname',
    'port' => 'non_standard_port_number',
    'username' => 'database_username',
    'password' => 'database_password',
    'database' => 'database_schema',
    'encoding' => 'utf8',
    'timezone' => 'UTC',
    'flags' => [],
    'cacheMetadata' => true,
    'log' => false,
    'quoteIdentifiers' => true,
]);

// ... code ...

require_once $root . '/vendor/fr3nch13/cakephp-pta/tests/plugin_bootstrap.php';

```

### Adding Migrations.

You can also define your migrations in your `bootstrap.php` file. This uses the `Migrations\TestSuite\Migrator` tool from [`cakephp/migrations`](https://github.com/cakephp/migrations).
The migrations get ran in the [`tests/plugin_bootstrap.php`](tests/plugin_bootstrap.php) file near the bottom.

```php
# test/bootstrap.php

// ... code ...

Configure::write('Tests.Migrations', [
    ['plugin' => 'Namespace/PluginName'],
    // just using some of my plugins as an example
    ['plugin' => 'Fr3nch13/Jira'],
    ['plugin' => 'Fr3nch13/Utilities'],
    ['plugin' => 'Fr3nch13/Excel'],
]);


// ... code ...

require_once $root . '/vendor/fr3nch13/cakephp-pta/tests/plugin_bootstrap.php';

```

### Adding Html Helpers

If you have View/Helpers that you would also like to include, you can define them in your `bootstrap.php` file as well.
These get included in [`tests/test_app/src/View/AppView.php`](tests/test_app/src/View/AppView.php)

```php
# test/bootstrap.php

// ... code ...

Configure::write('Tests.Helpers', [
    'HelperName' => ['className' => 'Namespace/PluginName.HelperName'],
    // loads the jira helper as an example.
    'Jira' => ['className' => 'Fr3nch13/Jira.Jira'],
]);


// ... code ...

require_once $root . '/vendor/fr3nch13/cakephp-pta/tests/plugin_bootstrap.php';

```

### Adding Middleware

You can also define which middlewhere you would like to include.
These get included in [`tests/test_app/src/Application.php`](tests/test_app/src/Application.php) in the `middleware()` method.

```php
# test/bootstrap.php

// ... code ...

Configure::write('Tests.Middleware', [
    'MiddlewhereName' => [
        'config_key' => 'config_value',
    ],
]);


// ... code ...

require_once $root . '/vendor/fr3nch13/cakephp-pta/tests/plugin_bootstrap.php';

```

### Full `tests/bootstrap.php` example for your plugin:

```php
#tests/bootstrap.php

<?php
declare(strict_types=1);

/**
 * Test suite bootstrap.
 *
 * These are the specific settings for this plugin.
 * This uses fr3nch13/cakephp-pta to provide a generic application for testing.
 * Setting passed to cakephp-pta's bootstrap and application are defined here.
 */

use Cake\Core\Configure;

// Configure your stuff here for the plugin_bootstrap.php below.
define('TESTS', __DIR__ . DS);

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(TESTS . '.env');

Configure::write('Tests.DbConfig', [
    'className' => 'Cake\Database\Connection',
    'driver' => 'Cake\Database\Driver\Mysql',
    'persistent' => false,
    'host' => env('CI_HOST', null),
    'username' => env('CI_USERNAME', null),
    'password' => env('CI_PASSWORD', null),
    'database' => env('CI_DATABASE', null),
    'encoding' => 'utf8',
    'timezone' => 'UTC',
    'flags' => [],
    'cacheMetadata' => true,
    'log' => false,
    'quoteIdentifiers' => true,
    'url' => env('DATABASE_URL', null),
]);

Configure::write('Tests.Plugins', [
    'Namespace/PluginName',
]);

Configure::write('Tests.Migrations', [
    ['plugin' => 'Namespace/PluginName'],
]);

Configure::write('Tests.Helpers', [
    'HelperName' => ['className' => 'Namespace/PluginName.HelperName'],
]);

////// Ensure we can setup an environment for the Test Application instance.
$root = dirname(__DIR__);
chdir($root);
require_once $root . '/vendor/fr3nch13/cakephp-pta/tests/plugin_bootstrap.php';


```

## Version compatibility

The major versions are locked to the major versions of CakePHP.
- PTA 1.x is locked to CakePHP ^3.8
- PTA 2.x is locked to CakePHP ^4.0 and requires php 7.3 or higher.
