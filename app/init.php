<?php

require_once 'core/App.php';
require_once 'core/Controller.php';
require_once '../vendor/autoload.php'; // require autoload.php to give loading duties to Composer

session_start(); // must come AFTER autoloader for classes to be known to SESSION variable

// create php CONSTANT (INC_ROOT) to be = root directory (e.g. domain.com/)
define('INC_ROOT', dirname(__DIR__));

/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
define('ENVIRONMENT', 'development');
if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

// define — Defines a named constant
// two params: (1) constant name; (2) it's value
// define('ASSET_ROOT',
//   'http://' . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', dirname(__DIR__)) . '/public')
// );
define('ASSET_ROOT',
  'http://' . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', dirname(__DIR__)))
);
// See parts
// echo '$_SERVER[\'HTTP_HOST\'] => ' . $_SERVER['HTTP_HOST'];
// echo '<br>';
// echo '$_SERVER[\'DOCUMENT_ROOT\'] => ' . $_SERVER['DOCUMENT_ROOT'];
// echo '<br>';
// echo 'dirname(__DIR__) => ' . dirname(__DIR__);

// define domain constant (e.g. = /attorneywes.com or /templatemvc01)
define('DOMAIN_ROOT',
  str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', dirname(__DIR__)))
);

/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 */
// local settings
define('DB_TYPE', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'attorneywes');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8');

// live server settings
// define('DB_TYPE', 'mysql');
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'pamska5_attorneywes');
// define('DB_USER', 'pamska5_jburns14');
// define('DB_PASS', 'Hopehope1!');
// define('DB_CHARSET', 'utf8');
