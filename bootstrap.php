<?php 

ini_set('display_errors', 1 );
ini_set('display_startup_errors', 1 );
error_reporting(E_ERROR);


define("HOST", 'localhost');
define("DB", 'api_balder');
define("USER", 'admin');
define("PASSWORD", 'admin');

define("DS", DIRECTORY_SEPARATOR);
define("DIR_APP", dirname(__FILE__));
define("DIR_PROJECT", 'balderAPI');


if (!file_exists(filename:"autoload.php")){
     echo 'Error to include bootstrap ! ';
     exit;
}

include "autoload.php";