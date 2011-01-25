<?php
/*
Copyright (C) 2011  Jack Scott

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/
/**
 * This file handles all the requests from the url and passes them on the the correct library file.
 * @author Jack Scott <jack@ttocskcaj.com>
 * @copyright Copyright 2011 Jack Scott
 * @license GNU General Public License Version 3
 * @version alpha
 */

//Set constants.

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
//Autoload the library files
function __autoload($class_name){
  include ROOT . DS . 'libs' . DS . $class_name . '.php';
}
$settings = new settings();
define('ADDRESS' , $settings->address);


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
    throw new tffw_exception ("Controller not found for $model", 'Fatal error');
}
catch ( tffw_exception $e ) {
	include ( ROOT . DS . "templates".DS."404.html");
}
