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
 *
 */
class mysql {
  /**
   * MySQL server host address.
   * Set in config.ini
   * @var String
   */
  public $mysql_server;
  /**
   * MySQL server username.
   * Set in config.ini
   * @var String
   */
  public $mysql_username;
  /**
   * MySQL server password.
   * Set in config.ini
   * @var String
   */
  public $mysql_password;
  /**
   * MySQL database.
   * Set in config.ini
   * @var String
   */
  public $mysql_database;

  /**
   *
   * Class Constructor. Sets local variables from the config.ini file.
   */
  function __construct(){
    //Set variables from config.ini
    $this->settings = new settings ();
    $this->mysql_server = $this->settings->mysql_server;
    $this->mysql_username = $this->settings->mysql_username;
    $this->mysql_password = $this->settings->mysql_password;
    $this->mysql_database = $this->settings->mysql_database;
  }
  /**
   * Wrapper for the normal mysql_query() function, no need to connect or select db first.
   * @param String $query
   */
  function query($query){
    //Try and connect to MySQL server and select database.
    if (! mysql_connect ( $this->mysql_server, $this->mysql_username, $this->mysql_password )) throw new tffw_exception ( "MySQL Query Failed.", "Fatal Error.", mysql_error () );
    if (! mysql_select_db ( $this->settings->mysql_database )) throw new tffw_exception ( "MySQL Query Failed.", "Fatal Error.", mysql_error () );
    $sql = mysql_query ( $query );
    if (! $sql) {
      throw new tffw_exception ( "MySQL Query Failed.", "Fatal Error.", mysql_error () );
      return false;
    }

    else {
      mysql_close ();
      return $sql;
    }

  }
}