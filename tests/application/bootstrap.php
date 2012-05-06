
<?php
//echo __DIR__ . '../../../../PEAR/PHPUnit/Framework.php';
//require_once _DIR_ . '../../../../PEAR/PHPUnit/Framework.php';
// Define path to application directory
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application'));
echo APPLICATION_PATH;
// Define application environment
define('APPLICATION_ENV', 'testing');

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();