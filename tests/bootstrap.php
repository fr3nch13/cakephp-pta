<?php
/**
 * Test suite bootstrap.
 *
 * This function is used to find the location of CakePHP whether CakePHP
 * has been installed as a dependency of the plugin, or the plugin is itself
 * installed as a dependency of an application.
 */
//
$root = dirname(__DIR__);
chdir($root);
require_once __DIR__ . DS . 'plugin_bootstrap.php';
