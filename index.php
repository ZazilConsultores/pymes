<?php
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));
// Define path of application modules
defined('MODULES_PATH')
        || define('MODULES_PATH', realpath(dirname(__FILE__) . '/application/modules'));
// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
// Define application pdf directory
defined('PDF_PATH')
    || define('PDF_PATH', realpath(dirname(__FILE__) .'/public/pdf' ));
// Define application images directory
defined('IMAGES_PATH')
    || define('IMAGES_PATH', realpath(dirname(__FILE__) .'/images' ));
// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';
require_once 'MainConfig.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$config = new MainConfig();
$application->bootstrap()->run();

