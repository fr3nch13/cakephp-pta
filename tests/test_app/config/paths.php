<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Use the DS to separate the directories in other defines
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

$findRoot = function ($pluginRoot) {
    do {
        $lastRoot = $pluginRoot;
        $pluginRoot = dirname($pluginRoot);
        if (is_dir($pluginRoot . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp')) {
            return $pluginRoot;
        }
    } while ($pluginRoot !== $lastRoot);

    throw new Exception("Cannot find the root of the application, unable to run tests");
};
define('PLUGIN_ROOT', $findRoot(__FILE__));
unset($findRoot);

/**
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */

/**
 * The full path to the directory which holds "App", WITHOUT a trailing DS.
 */
define('ROOT', PLUGIN_ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'app');

/**
 * Location of the tests space.
 */
define('TEST_ROOT', PLUGIN_ROOT . DS . 'tests' . DS . 'test_app');

/**
 * The actual directory name for the "App".
 */
define('APP_DIR', 'src');

/**
 * Path to the application's directory.
 */
define('APP', ROOT . DS . APP_DIR . DS);

/**
 * Path to the config directory.
 */
define('CONFIG', TEST_ROOT . DS . 'config' . DS);
define('APP_CONFIG', ROOT . DS . 'config' . DS);

/**
 * File path to the webroot directory.
 */
define('WWW_ROOT', ROOT . DS . 'webroot' . DS);

/**
 * Path to the tests directory.
 */
define('TESTS', ROOT . DS . 'tests' . DS);

/**
 * Path to the temporary files directory.
 */
define('TMP', PLUGIN_ROOT . DS . 'tmp' . DS);
if (!is_dir(TMP)) {
    mkdir(TMP);
}

/**
 * Path to the logs directory.
 */
define('LOGS', PLUGIN_ROOT . DS . 'logs' . DS);
if (!is_dir(LOGS)) {
    mkdir(LOGS);
}

/**
 * Path to the cache files directory. It can be shared between hosts in a multi-server setup.
 */
define('CACHE', TMP . 'cache' . DS);
if (!is_dir(CACHE)) {
    mkdir(CACHE);
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

file_put_contents(LOGS . 'exec.log', date('Y-m-d H:i:s') . ' Info: config/paths' . "\n", FILE_APPEND);
