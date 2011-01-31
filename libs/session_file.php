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
z
*/
/**
 * Controls and processes session files in the session directory.
 *
 * Session files are used to keep track of online users.
 * A new session file is created when a session object is created. And destroyed when it's unset.
 *
 * @author Jack Scott <jack@ttocskcaj.com>
 * @copyright Copyright 2011 Jack Scott
 * @license GNU General Public License Version 3
 * @version alpha
 */
class session_file {
	public $file;
	/**
	 * Creates session file
	 */
	function createFile() {
		$data = "id = " . $this->id . "
username = " . $this->username;

		$filename = "../sessions/" . $this->id . ".ses";

		//Open or make the file in write mode.
		$file = fopen ( $filename, "w+" );
		if (! $file)
			throw new tffw_exception ( "Session file could not be created!", "Warning" );

		//Write the session template to file
		fwrite ( $file, $data );
	}
	/**
	 * Checks if a file exists with the current session ID
	 * @return Boolean
	 */
	function fileExists() {
		$filename = "../sessions/" . $this->id . ".ses";
		if (file_exists ( $filename ))
			return true;
		else
			return false;
	}
	/**
	 * Deletes session file
	 */
	function deleteFile() {
		$filename = "../sessions/" . $this->id . ".ses";
		if (is_file ( $filename ))
			unlink ( $filename );

	}
}

?>