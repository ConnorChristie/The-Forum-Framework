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
 * Controls and processes session files in the session directory.
 * @author Jack Scott <jack@ttocskcaj.com>
 * @copyright Copyright 2011 Jack Scott
 * @license GNU General Public License Version 3
 * @version alpha
 */
class session_file {
	/**
	 * Creates session file
	 */
  function createFile(){
    define ( SESSION_PATH, ROOT . DS . "sessions" . DS );
    $data =
"id = " . $this->session_id . "
username = " . $this->session_username . "
expires = " . $this->session_expires;

    $filename = SESSION_PATH . $this->session_id . ".ses";

    //Open or make the file in write mode.
    $session_file = fopen ( $filename, "w+" );

    //Write the session template to file
    fwrite ( $session_file, $data );
  }
  /**
   * Checks if a file exists with the current session ID
   * @return Boolean
   */
  function fileExists(){
    define ( SESSION_PATH, ROOT . DS . "sessions" . DS );
    $filename = SESSION_PATH . $this->session_id . ".ses";
    if (file_exists ( $filename ))
      return true;
    else
      return false;
  }
  /**
   * Deletes session file
   */
  function deleteFile(){
    define ( SESSION_PATH, ROOT . DS . "sessions" . DS );
    $filename = SESSION_PATH . $this->session_id . ".ses";
	unlink($filename);
  }
}

?>