<?php
/*
 * This class is used to retrieve different date formats, quickly and easily.
 * Say for example you want to show dates in different formats on your site.
 */
class my_time{
	function __construct(){
		parent::__construct();
	}
	/*
	 * Let's assume that the $timezone is comming from a database...
	 * Here are some basic ones using the date function.
	 */
	function getUserTime() {
		return date ( 'H:i:s' );
	}
	function getUserDate() {
		return date ( 'd-m-Y' );
	}
	function getDateLong() {
			return date('l jS \of F Y');
	}

}

?>