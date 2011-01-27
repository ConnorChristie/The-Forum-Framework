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
 * Controls and processes sessions.
 * @author Jack Scott <jack@ttocskcaj.com>
 * @copyright Copyright 2011 Jack Scott
 * @license GNU General Public License Version 3
 * @version alpha
 */
class session extends session_file{

	public $session_id;
	public $session_username;
	public $session_expires;

  function __construct($session_id,$session_username,$session_length){
	$this->session_id = $session_id;
	$this->session_username = $session_username;
	$this->session_length = $session_length;

  }
  function sessionExists(){
  	if ($this->fileExists()){
  		return true;
  	}
  	else return false;
  }

}

?>