<?php
/**
 * User Class. Handles everything user related. Registration, Login, Sessions etc.
 * @author Jack Scott <jack@ttocskcaj.com>
 * @version 1.0
 */
class user {

  public $banned, $user_type, $username, $user_password, $user_email, $user_first_name, $user_last_name, $user_city, $user_country, $user_ip, $settings;
  public $logged_in = 0;
  /**
   * Checks if user has permission to register, then inserts all user data into database.
   * @return bool
   */
  function __construct(){
  	$this->mysql = new mysql();
    $this->settings = new settings ();
  }
  function register(){
    //Make sure user can register. ie not banned etc
    if ($this->canRegister ()) {
      //Connect to database and insert data.
      if (! mysql_connect ( $this->settings->mysql_server, $this->settings->mysql_username, $this->settings->mysql_password )) throw new Exception ( "<h1>Fatal Error!</h1>Could not connect to user database table!<br />" . mysql_error () );
      if (! mysql_select_db ( $this->settings->mysql_database )) throw new Exception ( "<h1>Fatal Error!</h1>Could not connect to user database table!<br />" . mysql_error () );
      $ip = $_SERVER ['REMOTE_ADDR'];
      if (! mysql_query (
          "
					INSERT INTO users(
					`username`,
					`password`,
					`email`,
					`first_name`,
					`last_name`,
					`city`,
					`country`,
					`registration_ip`)
					VALUES(
					'$this->username',
					'$this->user_password',
					'$this->user_email',
					'$this->user_first_name',
					'$this->user_last_name',
					'$this->user_city',
					'$this->user_country',
					'$this->user_ip')
					" )) throw new mysql_exception ( "User could not be inserted into database", mysql_error (), 'Fatal MySQL Error' );
      mysql_close ();
    }

  }

  /**
   * Checks if user has permission to login, then checks password in database and logs in if correct. Returns true if log in successful.
   *@return bool
   */
  function login(){
    //Make sure the user has permission to login
    if ($this->canLogin ()) {
      //Set IP address var
      $ip = $_SERVER ['REMOTE_ADDR'];
      //Validate form data
      if (empty($this->username)) {throw new tffw_error(900, 'Username not defined for login'); return false;}
      if (empty($this->user_password)) {throw new tffw_error(901, 'Password not defined for login'); return false;}
      //Check username and password
      $sql = $this->mysql->query ( "
						SELECT *
						FROM users
						WHERE `username` = '$this->username'
						AND `password` = '$this->user_password'
			" ) or die ( mysql_error () );
      $rows = mysql_num_rows ( $sql );
      //If un pw right
      if ($rows > 0) {
        //Set logged_in var
        $this->logged_in = 1;
        //Update IP in database
        mysql_query ( "
						UPDATE `users`
						SET `last_ip`='$ip'
						WHERE username = '$this->username'
				" ) or die ( mysql_error () );
        //Return true
        return true;
      }
    }
    else
      return false;
  }
  public function setUserSession(){
    $_SESSION [$this->username] = $this;
  }
  public function setUser_ip($user_ip){
    $this->user_ip = $user_ip;
  }
  /*Set users City.*/
  public function setUser_city($user_city){
    $this->user_city = $user_city;
  }

  public function setUser_country($user_country){
    $this->user_country = $user_country;
  }

  public function setUser_type($user_type){
    $this->user_type = $user_type;
  }

  public function setUsername($username){
    $this->username = $username;
  }

  public function setUser_password($user_password){
    $this->user_password = md5 ( $user_password );
  }

  public function setUser_email($user_email){
    $this->user_email = $user_email;
  }

  public function setUser_first_name($user_first_name){
    $this->user_first_name = $user_first_name;
  }

  public function setUser_last_name($user_last_name){
    $this->user_last_name = $user_last_name;
  }
  /**
   * Returns an array of all the users data.
   * @return array
   */
  public function getUserData(){
    $array = array ();
    $array ['username'] = $this->username;
    $array ['email'] = $this->user_email;
    $array ['password'] = $this->user_password;
    $array ['type'] = $this->user_type;
    $array ['first_name'] = $this->user_first_name;
    $array ['last_name'] = $this->user_last_name;
    $array ['city'] = $this->user_city;
    $array ['country'] = $this->user_country;
    $array ['ip'] = $this->user_ip;
    return $array;
  }

  /**
   * Checks the ban list for the user, returns true if user is banned.
   */
  public function isBanned(){
    mysql_connect ( $this->settings->mysql_server, $this->settings->mysql_username, $this->settings->mysql_password );
    mysql_select_db ( $this->settings->mysql_database );
    $this->user_ip = $_SERVER ['REMOTE_ADDR'];
    $sql = mysql_query ( "
			SELECT *
			FROM `ban_list`
			WHERE `username` = '$this->username'
			OR `ip` = '$this->user_ip'
		" );
    if (0 < mysql_num_rows ( $sql )) {
      return true;
    }
    else
      return false;
  }

  /**
   * Returns true if user is logged in.
   * @return bool
   */
  public function isLoggedIn(){
    if ($this->logged_in)
      return true;
    else
      return false;
  }
  /**
   * Returns true if user has permission to change their password or other user data.
   * @return bool
   */
  public function canChangePassword(){
    return true;
  }
  /**
   * Returns true if user has permission to register.
   * *@return bool
   */
  public function canRegister(){
    if (! $this->isBanned ()) {return true;}
  }

  /**
   * Returns true if user has permission to login.
   * @return bool
   */
  public function canLogin(){
    if (! $this->isBanned ()) {return true;}
  }
  /**
   * Bans the user.
   * @return void
   */
  public function ban(){
    mysql_connect ( $this->settings->mysql_server, $this->settings->mysql_username, $this->settings->mysql_password );
    mysql_select_db ( $this->settings->mysql_database );
    $this->user_ip = $_SERVER ['REMOTE_ADDR'];
    mysql_query ( "
				INSERT INTO ban_list
				(`username`,`ip`)
				VALUES
				('$this->username','$this->user_ip')
		" ) or die ( mysql_error () );
  }
}