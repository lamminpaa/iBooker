<?php

//Defining path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__). '/../application'));

// Define application environment
defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV'):'testing' ));

// Adding library to include path
set_include_path(implode(PATH_SEPARATOR, array(
                realpath(APPLICATION_PATH . '/../library'),
                 get_include_path(),
)));

// Zend application
require_once 'Zend/Application.php';

//Creating application, bootstrap and the run
$application = new Zend_Application(
        APPLICATION_ENV,
        APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();