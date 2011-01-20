<?php
/**
 * This file handles all the requests from the url and passes them on the the correct library file.
 */
//Set constants.
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

//Autoload the library files
function __autoload($class_name){
  include '../libs/' . $class_name . '.php';
}
//Set arrays for the url data
$url_array = explode ( '/', $url );
$model = $url_array [0];
$action = $url_array [1];
unset ( $url_array [0] );
unset ( $url_array [1] );
$query_array = $url_array;
unset ( $url_array );

//Try and include the controller from the url.
try {
  if (is_file ( ROOT.DS."application".DS.$model.DS.$model.".php" )) {
    include ROOT.DS."application".DS.$model.DS.$model.".php";
  }
  else
    throw new tffw_error ( 100, "Controller not found for $model" );
}
catch ( tffw_error $e ) {
	exit($e->getMessage());;
}
