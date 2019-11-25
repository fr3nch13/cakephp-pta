<?php
/**
 * Test suite bootstrap for ContactManager.
 *
 * This function is used to find the location of CakePHP whether CakePHP
 * has been installed as a dependency of the plugin, or the plugin is itself
 * installed as a dependency of an application.
 */

use Cake\Cache\Cache;
use Cake\Chronos\Chronos;
use Cake\Chronos\Date;
use Cake\Chronos\MutableDate;
use Cake\Chronos\MutableDateTime;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;

$findRoot = function ($root) {
    do {
        $lastRoot = $root;
        $root = dirname($root);
        if (is_dir($root . '/vendor/cakephp/cakephp')) {
            return $root;
        }
    } while ($root !== $lastRoot);

    throw new Exception("Cannot find the root of the application, unable to run tests");
};
$root = $findRoot(__FILE__);
unset($findRoot);

chdir($root);

require_once $root . '/vendor/autoload.php';
require_once $root . '/vendor/cakephp/cakephp/src/basics.php';

if (is_file('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
} else {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
}

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
    define('ROOT', getcwd());
}
if (!defined('APP_DIR')) {
    define('APP_DIR', 'TestApp');
}

if (!defined('TMP')) {
    define('TMP', sys_get_temp_dir() . DS);
}
if (!defined('LOGS')) {
    define('LOGS', TMP . 'logs' . DS);
}
if (!defined('CACHE')) {
    define('CACHE', TMP . 'cache' . DS);
}
if (!defined('SESSIONS')) {
    define('SESSIONS', TMP . 'sessions' . DS);
}

if (!defined('CAKE_CORE_INCLUDE_PATH')) {
    define('CAKE_CORE_INCLUDE_PATH', ROOT);
}
if (!defined('CORE_PATH')) {
    define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
}
if (!defined('CAKE')) {
    define('CAKE', CORE_PATH . 'src' . DS);
}
if (!defined('CORE_TESTS')) {
    define('CORE_TESTS', CORE_PATH . 'tests' . DS);
}
if (!defined('CORE_TEST_CASES')) {
    define('CORE_TEST_CASES', CORE_TESTS . 'TestCase');
}
if (!defined('TEST_APP')) {
    define('TEST_APP', CORE_TESTS . 'test_app' . DS);
}

// Point app constants to the test app.
if (!defined('APP')) {
    define('APP', TEST_APP . 'TestApp' . DS);
}
if (!defined('WWW_ROOT')) {
    define('WWW_ROOT', TEST_APP . 'webroot' . DS);
}
if (!defined('CONFIG')) {
    define('CONFIG', TEST_APP . 'config' . DS);
}

//@codingStandardsIgnoreStart
@mkdir(LOGS);
@mkdir(SESSIONS);
@mkdir(CACHE);
@mkdir(CACHE . 'views');
@mkdir(CACHE . 'models');
//@codingStandardsIgnoreEnd

if (file_exists(CORE_PATH . 'config/bootstrap.php')) {
    require_once CORE_PATH . 'config/bootstrap.php';
}

date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

Configure::write('debug', true);
Configure::write('App', [
    'namespace' => 'App',
    'encoding' => 'UTF-8',
    'base' => false,
    'baseUrl' => false,
    'dir' => APP_DIR,
    'webroot' => 'webroot',
    'wwwRoot' => WWW_ROOT,
    'fullBaseUrl' => 'http://localhost',
    'imageBaseUrl' => 'img/',
    'jsBaseUrl' => 'js/',
    'cssBaseUrl' => 'css/',
    'paths' => [
        'plugins' => [TEST_APP . 'Plugin' . DS],
        'templates' => [APP . 'Template' . DS],
        'locales' => [APP . 'Locale' . DS],
    ]
]);

Cache::setConfig([
    '_cake_core_' => [
        'engine' => 'File',
        'prefix' => 'cake_core_',
        'serialize' => true
    ],
    '_cake_model_' => [
        'engine' => 'File',
        'prefix' => 'cake_model_',
        'serialize' => true
    ]
]);

// Ensure default test connection is defined
if (!getenv('db_dsn')) {
    putenv('db_dsn=sqlite:///:memory:');
}

ConnectionManager::setConfig('test', ['url' => getenv('db_dsn')]);
ConnectionManager::setConfig('test_custom_i18n_datasource', ['url' => getenv('db_dsn')]);

Configure::write('Session', [
    'defaults' => 'php'
]);

Log::setConfig([
    // 'queries' => [
    //     'className' => 'Console',
    //     'stream' => 'php://stderr',
    //     'scopes' => ['queriesLog']
    // ],
    'debug' => [
        'engine' => 'Cake\Log\Engine\FileLog',
        'levels' => ['notice', 'info', 'debug'],
        'file' => 'debug',
        'path' => LOGS,
    ],
    'error' => [
        'engine' => 'Cake\Log\Engine\FileLog',
        'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
        'file' => 'error',
        'path' => LOGS,
    ]
]);

Chronos::setTestNow(Chronos::now());

ini_set('intl.default_locale', 'en_US');
ini_set('session.gc_divisor', '1');

loadPHPUnitAliases();

// Fixate sessionid early on, as php7.2+
// does not allow the sessionid to be set after stdout
// has been written to.
session_id('cli');
