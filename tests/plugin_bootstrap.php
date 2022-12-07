<?php
// @codingStandardsIgnoreFile

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorTrap;
use Cake\Error\ExceptionTrap;
use Cake\Http\ServerRequest;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;
use Cake\Routing\DispatcherFactory;
use Cake\Filesystem\Folder;
use Cake\Utility\Security;

$findRoot = function ($root) {
    if (is_dir($root . '/vendor/cakephp/cakephp')) {
        return $root;
    }
    do {
        $lastRoot = $root;
        $root = dirname($root);
        if (is_dir($root . '/vendor/cakephp/cakephp')) {
            return $root;
        }
    } while ($root !== $lastRoot);
    throw new Exception("Cannot find the root of the application, unable to run tests");
};

if (!defined('PLUGIN_ROOT')) {
    define('PLUGIN_ROOT', $findRoot(getcwd()));
}

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * Configure paths required to find CakePHP + general filepath
 * constants
 */
require PLUGIN_ROOT . DS . 'tests' . DS . 'test_app' . DS . 'config' . DS . '/paths.php';

/**
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

// Use composer to load the autoloader.
require PLUGIN_ROOT . DS . 'vendor' . DS . 'autoload.php';

/*
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

/*
 * When debug = true the metadata cache should only last
 * for a short time.
 */
if (Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+2 minutes');
    Configure::write('Cache._cake_core_.duration', '+2 minutes');
}

date_default_timezone_set('UTC');

/*
 * Register application error and exception handlers.
 */
(new ErrorTrap(Configure::read('Error')))->register();
(new ExceptionTrap(Configure::read('Error')))->register();


/*
 * Include the CLI bootstrap overrides.
 */
if (PHP_SAPI === 'cli') {
    /**
     * Additional bootstrapping and configuration for CLI environments should
     * be put here.
     */

    // Commented out as it is set above this.
    // Set the fullBaseUrl to allow URLs to be generated in shell tasks.
    // This is useful when sending email from shells.
    //Configure::write('App.fullBaseUrl', php_uname('n'));

    // Set logs to different files so they don't have permission conflicts.
    Configure::write('Log.debug.file', 'cli-debug');
    Configure::write('Log.error.file', 'cli-error');
}

Configure::write('debug', true);

$tmpDirectory = new Folder(TMP);
$tmpDirectory->delete(TMP . 'cache');
$tmpDirectory->create(TMP . 'cache/models', 0777);
$tmpDirectory->create(TMP . 'cache/persistent', 0777);
$tmpDirectory->create(TMP . 'cache/views', 0777);

Cache::setConfig(Configure::consume('Cache'));

//ConnectionManager::setConfig(Configure::consume('Datasources'));
TransportFactory::setConfig(Configure::consume('EmailTransport'));
Email::setConfig(Configure::consume('Email'));
Log::setConfig(Configure::consume('Log'));
/** @var string $salt */
$salt = Configure::consume('Security.salt');
Security::setSalt($salt);

/*
 * Setup detectors for mobile and tablet.
 */
ServerRequest::addDetector('mobile', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isMobile();
});
ServerRequest::addDetector('tablet', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isTablet();
});

// There is no time-specific type in Cake
\Cake\Database\TypeFactory::map('time', \Cake\Database\Type\TimeType::class);
\Cake\Database\TypeFactory::map('date', \Cake\Database\Type\DateType::class);
\Cake\Database\TypeFactory::map('datetime', \Cake\Database\Type\DateTimeType::class);
\Cake\Database\TypeFactory::map('timestamp', \Cake\Database\Type\DateTimeType::class);

/*
 * Enable immutable time objects in the ORM.
 *
 * You can enable default locale format parsing by adding calls
 * to `useLocaleParser()`. This enables the automatic conversion of
 * locale specific date formats. For details see
 * @link https://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html#parsing-localized-datetime-data
 */

/** @var \Cake\Database\Type\TimeType $timeType */
$timeType = \Cake\Database\TypeFactory::build('time');
$timeType->useLocaleParser();
/** @var \Cake\Database\Type\DateType $dateType */
$dateType = \Cake\Database\TypeFactory::build('date');
$dateType->useLocaleParser();
/** @var \Cake\Database\Type\DateTimeType $dateTimeType */
$dateTimeType = \Cake\Database\TypeFactory::build('datetime');
$dateTimeType->useLocaleParser();
/** @var \Cake\Database\Type\DateTimeType $timestampType */
$timestampType = \Cake\Database\TypeFactory::build('timestamp');
$timestampType->useLocaleParser();

// Ensure default test connection is defined
if (!getenv('db_class')) {
    putenv('db_class=Cake\Database\Driver\Sqlite');
    putenv('db_dsn=sqlite::memory:');
    putenv('db_database=test');
}
ConnectionManager::setConfig('test', [
    'className' => 'Cake\Database\Connection',
    'driver' => getenv('db_class'),
    'dsn' => getenv('db_dsn'),
    'database' => getenv('db_database'),
    'username' => getenv('db_login'),
    'password' => getenv('db_password'),
    'timezone' => 'UTC'
]);
ConnectionManager::setConfig('test_migrations', [
    'className' => 'Cake\Database\Connection',
    'driver' => getenv('db_class'),
    'dsn' => getenv('db_dsn'),
    'database' => getenv('db_database'),
    'username' => getenv('db_login'),
    'password' => getenv('db_password'),
    'timezone' => 'UTC'
]);

ConnectionManager::alias('test', 'default');
