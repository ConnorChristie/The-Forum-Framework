<?php
/*
DON'T EDIT THIS FILE!!!
TO ADD NEW CONFIGS EDIT CONGIF.INI
*/
/**
 * Controls and processes ini files in the config directory.
 * @author Jack Scott
 * @version 1.0
 */
class settings {
	public function __construct() {
		//if(is_file('config/basic_config.php')) die("Please remove the basic_config.php file from \\config.");
		$handle = opendir ( ROOT . DS . 'config' ) or die ( 'Config folder missing or can\'t be read!' );
		while ( false !== ($file = readdir ( $handle )) ) {
			if ($file != '.' && $file != '..' && $file != 'readme.txt') {
				$var = str_replace ( '.', '_', $file );
				$var = str_replace ( ' ', '_', $var );
				$this->$var = parse_ini_file ( ROOT . DS . 'config' . DS . $file );
			}
		}
		closedir ( $handle );

		/*
		 You can define new config variables in config/config.ini
		 They will automatically be store in the settings object at runtime.
		 You can call them by using $settings_object->setting_key
		 This will return the value of the assosiated key.
		 */
		foreach ( array_keys ( $this->config_ini ) as $setting ) {
			$this->$setting = $this->config_ini [$setting];
		}

	}
	/**
	 *
	 * This method is used to define a tempory setting in your scripts.\r\n
	 * For example
	 * $settings_object->define('my_name','jack')
	 * $settings_object->my_name will then return "jack"
	 * @param String $setting
	 * @param Mixed $value
	 */
	function define($setting, $value) {
		$this->$setting = $value;
	}
}