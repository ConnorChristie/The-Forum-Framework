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
 * Controls and processes sessions.
 * @author Jack Scott <jack@ttocskcaj.com>
 * @copyright Copyright 2011 Jack Scott
 * @license GPLv3
 * @version alpha
 */
class session extends session_file {

  public $id;
  public $username;
  public $expires;

  function __construct($id, $username, $expires){
    $this->id = $id;
    $this->username = $username;
    $this->expires = $expires;
    if (! $this->sessionExists ()) {
      $this->createSession ();
    }

  }
  function createSession(){
    $this->createFile ();
    $_SESSION [$this->id] = array ("id" => $this->id, "username" => $this->username, "expires" => $this->expires );
  }
  function sessionExists(){
    if ($this->fileExists () && (isset ( $_SESSION [$this->id] ))) {
    	/*TODO: Write session expirery check */
    	//A complete session was found. It has not expired.
      return true;
    }
    else {
    	//Session data is missing or not complete. Delete any incomplete data.
      if(isset($_SESSION)) unset ( $_SESSION [$this->id] );
      $this->deleteFile ();
      return false;
    }
  }

}

?>