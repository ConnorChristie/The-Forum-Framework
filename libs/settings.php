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


DON'T EDIT THIS FILE!!!
TO ADD AND MODIFY SETTINGS, EDIT CONGIF.INI
*/
/**
 * Controls and processes ini files in the config directory.
 * @author Jack Scott <jack@ttocskcaj.com>
 * @copyright Copyright 2011 Jack Scott
 * @license GPLv3
 * @version alpha
 */
class settings {
  public function __construct(){

    /*
		 You can define new config variables in config/config.ini
		 They will automatically be store in the settings object at runtime.
		 You can call them by using $settings_object->setting_key
		 This will return the value of the assosiated key.
		 */
  	//Create an array from the config file.
  	$this->config_ini = parse_ini_file ( '../config/config.ini' );
  	//Set each setting to it's own parameter.
    foreach ( array_keys ( $this->config_ini ) as $setting ) {
      $this->$setting = $this->config_ini [$setting];
    }

  }
  /**
   *
   * This method is used to define a tempory setting in your scripts.\r\n
   * For example
   * $settings_object->define('my_name','jack')
   * $settings_object->my_name will then return "jack"
   * They will not be saved in the config.ini
   * @param String $setting
   * @param Mixed $value
   */
  function define($setting, $value){
    $this->$setting = $value;
  }
  /**
   * Universal getter for settings.
   * eg $settings->get("mysql_server"); would return the value of mysql_server in config.ini
   * @param String $variable
   * @return Mixed
   */
  function get($variable){
	return $this->$variable;
  }
}