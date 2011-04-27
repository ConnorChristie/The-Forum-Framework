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
 * Controller for users. Handles logins, logouts, registration, permissionsvar etc.
 * @author Jack Scott <jack@ttocskcaj.com>
 * @copyright Copyright 2011 Jack Scott
 * @license GPLv3
 * @version alpha
 */
class user {

        public $bio;
        public $server;
	/**
	 * Weather or not the user is banned.
	 * @var Boolean
	 */
	public $banned;
	/**
	 * User type. Eg "admin"
	 * @var String or Integer
	 */
	public $type;
	/**
	 * Username
	 * @var String
	 */
	public $username;
	/**
	 * Password.
	 * Note: Setter automatically encrypts.
	 * @var String
	 */
	public $password;
	/**
	 * Users email address.
	 * @var String
	 */
	public $email;
	/**
	 * Users first name.
	 * @var String
	 */
	public $city;
	/**
	 * Users country.
	 * @var String
	 */
	public $ip;
	/**
	 * Weather or not the user is logged in.
	 * @var Boolean
	 */
	public $logged_in = false;
	/**
	 *
	 *Returns a string incase the object is echoed or something.
	 *Something like "ttocskcaj's user object"
	 *@return String
	 */
	function __construct() {
		$this->mysql = new mysql ();
		$this->settings = new settings ();
	}

	public function getArray(){
		return array (  'username'=>$this->username,
						'email'=>$this->email,
						'city'=>$this->city,
						'ip'=>$this->ip,
                                                'type'=>$this->type,
                                                'bio' =>$this->bio,
		);
	}
	/**
	 * Checks if user has permission to register, then inserts all user data into database.
	 * Virutally the same as the save function on other controllers.
	 * @return bool
	 */
	function register() {
		//Make sure user can register. ie not banned etc
		//Connect to database and insert data.
		$ip = $_SERVER ['REMOTE_ADDR'];
		if ($this->canRegister ()) {
			try {
                                mysql::connect();
				mysql_query ( "
					INSERT INTO users(
					`username`,
					`password`,
					`email`,
					`city`,
                                        `server`,
                                        `bio`,
					`registration_ip`)
					VALUES(
					'$this->username',
					'$this->password',
					'$this->email',
					'$this->city',
                                        '$this->server',
                                        '$this->bio',
					'$this->ip')
					" );
                                mysql::disconnect();
			} catch ( tffw_exception $e ) {
				throw new tffw_exception ( "User could not be inserted into database", 'Fatal MySQL Error' );
				$e->reportError ();
			}
		}
	}

	/**
	 * Checks if user has permission to login, then checks password in database and logs in if correct. Returns true if log in successful.
	 *@return bool
	 */
	function login() {
		//Make sure the user has permission to login
		if ($this->canLogin ()) {
			//Set IP address var
			$ip = $_SERVER ['REMOTE_ADDR'];
			//Check username and password
                        mysql::connect();
			$sql = mysql_query ( "
						SELECT *
						FROM users
						WHERE `username` = '$this->username'
						AND `password` = '$this->password'
			" ) or die ( mysql_error () );
			$rows = mysql_num_rows ( $sql );
			$row = mysql_fetch_array ( $sql );
			$this->id = $row ['id'];
			//If un pw right
			if ($rows > 0) {
				//Create a session
//				$session = new session ( $this->getid (), $this->username, 3600 );
				//Update IP in database
//				try {
//					mysql_query ( "
//						UPDATE `users`
//						SET `last_ip`='$ip'
//						WHERE username = '$this->username'
//				" );
                                mysql::disconnect();
//				} catch ( tffw_exception $e ) {
//					throw new tffw_exception ( "Users IP could not be updated in database", 'Fatal MySQL Error' );
//					$e->reportError ();
//					return false;
//				}
				//Return true
				return true;
			}
		} else
			return $this->canLogin();
	}
	/**
	 * Loads user from MySQL database. Must login() first.
	 * @param Integer $user_id
	 */
	public function load($user_id) {
                mysql::connect();
		$sql = mysql_query ( "
	  		SELECT *
	  		FROM `users`
	  		WHERE `id` = '$user_id'
	  		" );
		if (! $sql)
			throw new tffw_exception ( "Could not load user!", "Major Error" );
		$row = mysql_fetch_array ( $sql );
		$this->username = $row ['username'];
		$this->password = $row ['password'];
		$this->email = $row ['email'];
                $this->type = $row ['type'];
		$this->city = $row ['city'];
                $this->server = $row['server'];
                $this->bio = $row['bio'];
		$this->ip = $row ['last_ip'];
                mysql::disconnect();
	}
	public function getID() {
		return $this->id;
	}

	/**
	 * Checks the ban list for the user, returns true if user is banned.
	 */
	public function isBanned() {
            mysql::connect();
		$this->ip = $_SERVER ['REMOTE_ADDR'];
		$sql = mysql_query ( "
			SELECT *
			FROM `ban_list`
			WHERE `username` = '$this->username'
			OR `ip` = '$this->ip'
		" );
		if (0 < mysql_num_rows ( $sql )) {
			return true;
		} else
			return false;
	}

	/**
	 * Returns true if user is logged in.
	 * @return bool
	 */
	public function isLoggedIn() {
		if ($this->logged_in)
			return true;
		else
			return false;
	}
	/**
	 * Returns true if user has permission to change their password or other user data.
	 * @return bool
	 */
	public function canChangePassword() {
		return true;
	}
	/**
	 * Returns true if user has permission to register.
	 * *@return bool
	 */
	public function canRegister() {
		if (! $this->isBanned ()) {
			return true;
		}
	}

	/**
	 * Returns true if user has permission to login.
	 * @return bool
	 */
	public function canLogin() {
		if (! $this->isBanned ()) {
			return true;
		}
                else {
                    die("That account has been banned");
                    return "Banned";
                }
	}
	/**
	 * Bans the user.
	 * @return void
	 */
        public function canPostNews(){
            if($user->type=='3') return true;
            else return false;
        }
	public function ban() {
		mysql::connect();
		$this->ip = $_SERVER ['REMOTE_ADDR'];
		mysql_query ( "
				INSERT INTO ban_list
				(`username`,`ip`)
				VALUES
				('$this->username','$this->ip')
		" ) or die ( mysql_error () );
                mysql::disconnect();
	}
	/**
	 * @return the $banned
	 */
	public function getBanned() {
		return $this->banned;
	}

	/**
	 * @param Boolean $banned
	 */
	public function setBanned($banned) {
		$this->banned = $banned;
	}

	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param String $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @return the $username
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param String $username
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * @return the $password
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param String $password
	 */
	public function setPassword($password) {
		$this->password = md5($password);
	}

	/**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param String $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @return the $city
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * @param String $city
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * @return the $ip
	 */
	public function getIp() {
		return $this->ip;
	}

	/**
	 * Automaticaly sets the IP property to the users IP
	 */
	public function setIp() {
		$this->ip = $_SERVER ['REMOTE_ADDR'];
	}

	/**
	 * @return the $logged_in
	 */
	public function getLogged_in() {
		return $this->logged_in;
	}

	/**
	 * @param Boolean $logged_in
	 */
	public function setLogged_in($logged_in) {
		$this->logged_in = $logged_in;
	}
        public function getServer() {
            return $this->server;
        }
        public function setServer($server) {
            $this->server = $server;
        }
        public function getBio(){
            return $this->bio;
        }
        public function setBio($bio){
            $this->bio = $bio;
        }

}