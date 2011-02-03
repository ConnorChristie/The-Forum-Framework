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
 * MySQL Class, for modifying database.
 * @author Jack
 * @version 1.0
 * @license GPLv3
 */
class mysql {
  /**
   * MySQL server host address.
   * Set in config.ini
   * @var String
   */
  public $server;
  /**
   * MySQL server username.
   * Set in config.ini
   * @var String
   */
  public $username;
  /**
   * MySQL server password.
   * Set in config.ini
   * @var String
   */
  public $password;
  /**
   * MySQL database.
   * Set in config.ini
   * @var String
   */
  public $database;

  /**
   *
   * Class Constructor. Sets local properties from a settings object.
   */
  function __construct(){

//    $this->server = $this->settings->mysql_server;
//    $this->username = $this->settings->mysql_username;
//    $this->password = $this->settings->mysql_password;
//    $this->database = $this->settings->mysql_database;
  }
  /**
   * Wrapper for the normal query() function, no need to connect or select db first.
   * @param String $query
   */
  static function connect(){
  	$settings = new settings ();
    //Try and connect to MySQL server and select database.
    if (! mysql_connect ( $settings->mysql_server, $settings->mysql_username, $settings->mysql_password )) {
    	throw new tffw_exception ( "MySQL Query Failed.", "Fatal Error.", mysql_error () );
    	return false;
    }
    if (! mysql_select_db ( $settings->mysql_database )) {
    	throw new tffw_exception ( "MySQL Query Failed.", "Fatal Error.", mysql_error () );
    	return false;
    }

  }
  static function disconnect(){
  	mysql_close();
  }
}