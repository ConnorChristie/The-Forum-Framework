<?php

/**
 * Takes a String and sanatizes it for MySQL
 * @param String $str
 * @return String
 */

function clean($str) {
    if (!get_magic_quotes_gpc()) {
        $str = addslashes($str);
    }
    $str = strip_tags(htmlspecialchars($str));
    return $str;
}
function array_dump($array){
		echo "<pre>".print_r($array, true)."</pre>";
	}

/**
 * Takes an object and turns the parameters into an array.
 * @param Object $object
 * @return Array
 */
function objectToArray($object) {
    $array = array();
    foreach ($object as $member => $data) {
        $array[$member] = $data;
    }
    return $array;
}

/**
 * Handles sessions, cookies, templates and debugging.
 */
function bootstrap() {
    session_start();
    global $smarty;
    global $settings;
    global $user_status;
    global $user;
    $smarty = new Smarty();
    $settings = new settings();
    //If debug mode is enabled,
    if ($settings->debug) {
        //Change background to red and print warning message
        echo '<div style="background:red;">';
        echo '<h1>WARNING! DEBUG MODE!</h1>';
        echo 'Processing Cookies..';
        //Start timing cookie check
        $page_start = microtime();
        $start = microtime();
    }

//If a cookie is set,
    if (isset($_COOKIE['mbadmin'])) {
        if ($settings->debug) {
            echo "<p>Cookie found... Testing..</p>";
        }
        //Take cookie data and try use it to log in.
        $cookie = explode(',', $_COOKIE['mbadmin']);
        $user = new user();
        $user->setUsername($cookie[0]);
        $user->setPassword($cookie[1]);
        //Check users data by trying to login()
        if ($user->login()) {
            //If un pw where correct, load the rest of the user object from db
            $user->load($user->id);
            //Set the session object, and unset the temp $user object
            $_SESSION['user'] = $user;
            if ($settings->debug) {
                if ($user->type!=3) die("<h1>Permission Error!</h1><p>You have to be an administrator to use the site in debug mode.</p>");
                echo "<p>Cookie correct. Log in successfull.</p>";
            }
            unset($user);
        } else {
            if ($settings->debug) {
                echo "<p>Cookie error.</p>";
            }
            //The cookie could not be used to log in. Most likely a fake/corrupt cookie.
            die("<h1>COOKIE ERROR!</h1><p>Please clear you browsers cookies and login again.</p>");
        }
    } else {
        if ($settings->debug) {
            echo "<p>Cookie not found. Looking for session...</p>";
        }
    }
    //If a session exists,
    if (isset($_SESSION['user'])) {
        if ($settings->debug) {
            echo "<p>Session found... Testing..</p>";
        }
        //Assign user data to array for smarty to use.
        $smarty->assign('user', objectToArray($_SESSION['user']));
        $smarty->assign('user_status', 'logged_in');
    } else {
        if ($settings->debug) {
            echo "<p>Session not found... Proceding without logging it..</p>";
            die("<h1>Permission Error!</h1><p>You have to be an administrator to use the site in debug mode.</p>");
        }
        $smarty->assign('user', array('type' => 0));
        $smarty->assign('user_status', 'logged_out');

    }
}
/**
 * Takes a userid and gets the matching username from database. Useful for forum posters etc.
 * @param int $id
 * @return String
 */
function useridToUsername($id){
    mysql::connect();
    $result = mysql_query("SELECT * FROM `users` WHERE `id` = '$id'");
    $row = mysql_fetch_assoc($result);
    mysql::disconnect();
    return $row['username'];

}
//Connects to user list site and converts the page to arrays.
function load_user_list($url) {
    $mods = array();
    $regs = array();
    $vips = array();
    $admins = array();
    error_reporting(0);
    $file_handle = fopen($url, "r");
    error_reporting(E_ALL);
    if (!$file_handle) {
        return false;
    } else {
        while (!feof($file_handle)) {
            $line = fgets($file_handle);
            $user = explode(':', $line);
            if (strstr($user[1], "Reg")) {
                $regs[] = $user[0];
            }
            if (strstr($user[1], "Mod")) {
                $mods[] = $user[0];
            }
            if (strstr($user[1], "VIP")) {
                $vips[] = $user[0];
            }
            if (strstr($user[1], "Admin")) {
                $admins[] = $user[0];
            }
        }
        fclose($file_handle);
        $array = array('mods' => $mods, 'regs' => $regs, 'vips' => $vips, 'admins' => $admins);
        return $array;
    }
}

?>
