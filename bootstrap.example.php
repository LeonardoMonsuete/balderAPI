<?php 

// ini_set('display_errors', 0 ); // change for 1 if you are in dev env to see errors
// ini_set('display_startup_errors', 0 ); // change for 1 if you are in dev env to see errors
// error_reporting(E_ERROR);


define("HOST", 'yourhost');
define("DB", 'yordbschemaname');
define("USER", 'yourdbuser');
define("PASSWORD", 'yourdbpass');

define("DS", DIRECTORY_SEPARATOR);
define("DIR_APP", dirname(__FILE__));
define("DIR_PROJECT", 'yourdirectoryprojectname');


if (!file_exists(filename:"autoload.php")){
     echo 'Error to include bootstrap ! ';
     exit;
}

include "autoload.php";