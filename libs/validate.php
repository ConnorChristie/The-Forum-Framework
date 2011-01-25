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
 * Validates form data. Checks for SQL injection etc.
 * @author Jack Scott <jack@ttocskcaj.com>
 * @copyright Copyright 2011 Jack Scott
 * @license GNU General Public License Version 3
 * @version alpha
 */
class validate {
  function validateUsername($username){
		if (isset($username) && !preg_match("/^[^a-z]{1}|[^a-z0-9_.-]+/i", $username) ){
			return true;
		}
		else return false;
  }
  function validateUser_password($user_password){

  }
}

?>