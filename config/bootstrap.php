<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Configure paths required to find CakePHP + general filepath
 * constants
 */
require __DIR__ . '/paths.php';

// Use composer to load the autoloader.
require ROOT . DS . 'vendor' . DS . 'autoload.php';

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

// You can remove this if you are confident you have intl installed.
if (!extension_loaded('intl')) {
    trigger_error('You must enable the intl extension to use CakePHP.', E_USER_ERROR);
}

use Cake\Cache\Cache;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Log\Log;
use Cake\Network\Email\Email;
use Cake\Network\Request;
use Cake\Routing\DispatcherFactory;
use Cake\Utility\Inflector;
use Cake\Utility\Security;

/**
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
    die($e->getMessage() . "\n");
}

// Load an environment local configuration file.
// You can use a file like app_local.php to provide local overrides to your
// shared configuration.
//Configure::load('app_local', 'default');

// When debug = false the metadata cache should last
// for a very very long time, as we don't want
// to refresh the cache while users are doing requests.
if (!Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+1 years');
    Configure::write('Cache._cake_core_.duration', '+1 years');
}

/**
 * Set server timezone to UTC. You can change it to another timezone of your
 * choice but using UTC makes time calculations / conversions easier.
 */
date_default_timezone_set('UTC');

/**
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/**
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set('intl.default_locale', 'en_US');

/**
 * Register application error and exception handlers.
 */
$isCli = php_sapi_name() === 'cli';
if ($isCli) {
    (new ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
    (new ErrorHandler(Configure::read('Error')))->register();
}

// Include the CLI bootstrap overrides.
if ($isCli) {
    require __DIR__ . '/bootstrap_cli.php';
}

/**
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 *
 * If you define fullBaseUrl in your config file you can remove this.
 */
if (!Configure::read('App.fullBaseUrl')) {
    $s = null;
    if (env('HTTPS')) {
        $s = 's';
    }

    $httpHost = env('HTTP_HOST');
    if (isset($httpHost)) {
        Configure::write('App.fullBaseUrl', 'http' . $s . '://' . $httpHost);
    }


    unset($httpHost, $s);
}

Cache::config(Configure::consume('Cache'));
ConnectionManager::config(Configure::consume('Datasources'));
Email::configTransport(Configure::consume('EmailTransport'));
Email::config(Configure::consume('Email'));
Log::config(Configure::consume('Log'));
Security::salt(Configure::consume('Security.salt'));

/**
 * The default crypto extension in 3.0 is OpenSSL.
 * If you are migrating from 2.x uncomment this code to
 * use a more compatible Mcrypt based implementation
 */
// Security::engine(new \Cake\Utility\Crypto\Mcrypt());

/**
 * Setup detectors for mobile and tablet.
 */
Request::addDetector('mobile', function ($request) {
    $detector = new \Detection\MobileDetect();
    return $detector->isMobile();
});
Request::addDetector('tablet', function ($request) {
    $detector = new \Detection\MobileDetect();
    return $detector->isTablet();
});

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 *
 * Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
 * Inflector::rules('irregular', ['red' => 'redlings']);
 * Inflector::rules('uninflected', ['dontinflectme']);
 * Inflector::rules('transliteration', ['/å/' => 'aa']);
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on Plugin to use more
 * advanced ways of loading plugins
 *
 * Plugin::loadAll(); // Loads all plugins at once
 * Plugin::load('Migrations'); //Loads a single plugin named Migrations
 *
 */


// Only try to load DebugKit in development mode
// Debug Kit should not be installed on a production system
//if (Configure::read('debug')) {
//    Plugin::load('DebugKit', ['bootstrap' => true]);
//}

/**
 * Connect middleware/dispatcher filters.
 */
DispatcherFactory::add('Asset');
DispatcherFactory::add('Routing');
DispatcherFactory::add('ControllerFactory');

/**
 * Enable default locale format parsing.
 * This is needed for matching the auto-localized string output of Time() class when parsing dates.
 */
Type::build('datetime')->useLocaleParser();

Plugin::load('Admin', ['bootstrap' => false, 'routes' => true]);

// configure languages
Configure::write('Config.languageList',
	[
		'vi_VN' => ['code' => 'vi', 'text' => 'Vietnam'],
		//'nl_BE' => ['code' => 'nl', 'text' => 'Dutch'],
		//'fr_BE' => ['code' => 'fr', 'text' => 'French']
	]
);
Configure::write('Config.defaultLanguage', '');
DispatcherFactory::add('LocaleSelector');
/*if(empty(Configure::read('Config.defaultLanguage')))
{
	$allow_Locales = array_keys(Configure::read('Config.languageList'));
	DispatcherFactory::add('LocaleSelector', ['locales' => $allow_Locales]);
}
//echo ini_get('intl.default_locale');
*/


// configurations by domain
$domain_name =  !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
if (empty($domain_name) && !empty($_SERVER['SERVER_NAME'])){
    $domain_name =  $_SERVER['SERVER_NAME'];
}
$domain_name = explode(':',$domain_name)[0];
Configure::write('domainName', $domain_name);
//Configure::write('DebugKit.forceEnable', true);

if ($domain_name == "" || $domain_name == "localhost" || $domain_name == "localhost.com" || $domain_name == "mynivea.vn" || strpos($domain_name, "192.168.1") !== FALSE) {
	date_default_timezone_set('Asia/Ho_Chi_Minh');
    Configure::write('debug',1);
    if (Configure::read('debug')) {
        Plugin::load('DebugKit', ['bootstrap' => true]);
    }
	Configure::write('environment', 'local');
    ConnectionManager::config('default', [
        'className' => 'Cake\Database\Connection',
        'driver' => 'Cake\Database\Driver\Mysql',
        'persistent' => false,
         'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'lenhatlong',
        'encoding' => 'utf8',
        'timezone' => 'UTC',
        'cacheMetadata' => true,
        'quoteIdentifiers' => false,
    ]);
    Email::setConfigTransport('smtp', [
        'className' => 'Smtp',
        'host' => 'ssl://smtp.gmail.com',
        'port' => 465,
        'username' => 'thong.hhm0624@gmail.com',
        'password' => 'a0906070937'
    ]);
	/*
	SMTP GMAIL
		host : ssl://smtp.gmail.com
		username : groupmail.bliss@gmail.com
		password : 180street40
	SMTP MAILGUN
		host : ssl://smtp.mailgun.org
	SMTP MAILJET
		host : ssl://in-v3.mailjet.com
		username : 877662218b181bad327b4396c83ef05f
		password : 4bcd4204dbcfbb55bdf305c215033a09
	*/
    Configure::write('SMTP_fromEmail', "tri@bliss-interactive.com");
	Configure::write('app_settings', array(
        'gtm_settings' => [
            'gdpr' => false,
            'ga_clientID' => null,
            'ga_account' => 'UA-142761376-1'  //thong.hhm0624@gmail.com
        ]
    ));
}
else {
	date_default_timezone_set("Asia/Ho_Chi_Minh");
    Configure::write('debug',0);
    if (Configure::read('debug')) {
        Plugin::load('DebugKit', ['bootstrap' => false]);
    }

	Configure::write('environment', 'live');

    ConnectionManager::config('default', [
        'className' => 'Cake\Database\Connection',
        'driver' => 'Cake\Database\Driver\Mysql',
        'persistent' => false,
        'host' => 'localhost',
        'username' => 'u420077601_root',
        'password' => '0365240695',
        'database' => 'u420077601_kdcvanphat',
        'encoding' => 'utf8',
        'timezone' => 'UTC',
        'cacheMetadata' => true,
        'quoteIdentifiers' => false,
    ]);
    Email::setConfigTransport('smtp', [
        'className' => 'Smtp',
        'host' => 'ssl://smtp.gmail.com',
        'port' => 465,
        'username' => 'thong.hhm0624@gmail.com',
        'password' => 'a0906070937'
    ]);
	Configure::write('app_settings', array(
        'gtm_settings' => [
            'gdpr' => false,
            'ga_clientID' => null,
            'ga_account' => 'UA-143272693-1' //huahoangminhthong@gmail.com
        ]
    ));

    /*$valid_passwords = array ("sorry" => "23s54v48x8f5o");
    $valid_users = array_keys($valid_passwords);

    $user = !empty($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
    $pass = !empty($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';

    $validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

    if (!$validated) {
        header('WWW-Authenticate: Basic realm="My Realm"');
        header('HTTP/1.0 401 Unauthorized');
        die ("Not authorized");
    }*/
}
//Configure::write('Translations', [
//    'sheet_id' => '1-P7atbbata4Z52z1O4tX2DPkOhKxbkLPLnWNlK04owQ',
//    'gid' => '806953753'
//]);
