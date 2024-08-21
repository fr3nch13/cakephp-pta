<?php
declare(strict_types=1);
/**
 * use if !defined to allow the plugin that's using this to overwrite what it needs to.
 * mainly it would overwrite the TESTS to point to it's tests directory.
 */

/**
 * Use the DS to separate the directories in other defines
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */

/**
 * If this is somehow included without the plugin_bootstrap.php
 * We need to throw an error
 */
if (!defined('PLUGIN_BOOTSTRAP')) {
    $this_relative_path = str_replace(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR, '', __FILE__);
    throw new \Exception('This file shouldn\'t be included by anything other than the plugin_bootstrap.php File: ' . $this_relative_path);
}

/**
 * The full path to the directory which holds "src", WITHOUT a trailing DS.
 */
if (!defined('ROOT')) {
    if (is_dir(PLUGIN_ROOT . DS . 'tests' . DS . 'test_app')) {
        // their test app
        define('ROOT', PLUGIN_ROOT . DS . 'tests' . DS . 'test_app');
    } else {
        // our test app.
        define('ROOT', dirname(__DIR__) . DS . 'tests' . DS . 'test_app');
    }
}

/**
 * The actual directory name for the application directory. Normally
 * named 'src'.
 */
if (!defined('APP_DIR')) {
    define('APP_DIR', 'src');
}

/**
 * Path to the application's directory.
 */
if (!defined('APP')) {
    define('APP', ROOT . DS . APP_DIR . DS);
}

/**
 * Path to the config directory.
 */
if (!defined('CONFIG')) {
    define('CONFIG', ROOT . DS . 'config' . DS);
}

/**
 * File path to the webroot directory.
 */
if (!defined('WWW_ROOT')) {
    define('WWW_ROOT', ROOT . DS . 'webroot' . DS);
}

/**
 * Path to the tests directory.
 */
if (!defined('TESTS')) {
    define('TESTS', PLUGIN_ROOT . DS . 'tests' . DS);
}

/**
 * Path to the temporary files directory.
 */
if (!defined('TMP')) {
    define('TMP', ROOT . DS . 'tmp' . DS);
}

/**
 * Path to the logs directory.
 */
if (!defined('LOGS')) {
    define('LOGS', ROOT . DS . 'logs' . DS);
}

/**
 * Path to the cache files directory. It can be shared between hosts in a multi-server setup.
 */
if (!defined('CACHE')) {
    define('CACHE', TMP . 'cache' . DS);
}

/**
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 *
 * CakePHP should always be installed with composer, so look there.
 */
define('CAKE_CORE_INCLUDE_PATH', PLUGIN_ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp');

/**
 * Path to the cake directory.
 */
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);
