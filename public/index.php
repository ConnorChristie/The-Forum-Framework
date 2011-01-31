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

if (version_compare ( PHP_VERSION, '5.0' ) < 0) {
	$php_version ['text'] = '<strong style="color:red;">' . PHP_VERSION . "</strong>";
	$php_version [2] = false;
} else {
	$php_version ['text'] = '<strong style="color:lightgreen;">' . PHP_VERSION . "</strong>";
	$php_version [2] = true;
}
if (@ini_get ( 'register_globals' ) == '1' || strtolower ( @ini_get ( 'register_globals' ) ) == 'on') {
	$register_globals ['text'] = '<strong style="color:red;">On</strong>';
	$register_globals [2] = false;
} else {
	$register_globals ['text'] = '<strong style="color:lightgreen;">Off</strong>';
	$register_globals [2] = true;
}
if (file_exists ( "../config/config.ini" )) {
	$config_file ['text'] = '<strong style="color:lightgreen;">Found</strong>';
	$config_file [2] = true;
} else {

	$config_file ['text'] = '<strong style="color:red;">Not Found</strong>';
	$config_file [2] = false;
}
if (is_dir ( "../libs" )) {
	opendir ( "../libs" );
	if (readdir ()) {
		$libs_dir ['text'] = '<strong style="color:lightgreen;">Readable</strong>';
		$libs_dir [2] = false;
	} else {
		$libs_dir ['text'] = '<strong style="color:red;">Not Readable</strong>';
		$libs_dir [2] = true;
	}
} else {
	$libs_dir ['text'] = '<strong style="color:red;">Not Found</strong>';
	$libs_dir [2] = true;
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TFFW - Welcome</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>


<div id="header">
<h1><img src="images/logo.png" width="64" height="64" alt="logo"
	longdesc="Sourcey Logo" /> TFFW <img src="images/logo.png" width="64"
	height="64" alt="logo" longdesc="Sourcey Logo" /></h1>
<p>The Forum Framework</p>
</div>
<div id="content">
<h2>Compatiblilty Check</h2>
<p>Welcome to the forum framework. This page will test your system to
make sure it's compatable with TFFW</p>

<p>PHP Version: <?php
echo $php_version ['text'];
?></p>
<p>Register Globals: <?php
echo $register_globals ['text'];
?></p>
<p>Config File: <?php
echo $config_file ['text'];
?></p>
<p>Library Files: <?php
echo $libs_dir ['text'];
?></p>
  <?php
		if (! $php_version [2])
			echo '<p style="color:red;">You must have php version 5.0 or higher to run TFFW</p>';
		if (! $config_file [2])
			echo '<p style="color:red;">Your config file could not be found. Please see /config/readme.txt</p>';
		if (! $register_globals [2])
			echo '<p style="color:red;">It is recommened that register_globals is off. TFFW will still run.</p>';
		if ($php_version && $config_file && $register_globals)
			echo '<p style="color:lightgreen;">Your system is ready to run TFFW</p>';

		?>

</div>
<div id="content">
<h2>License Info</h2>
<p>
Copyright (C) 2011  Jack Scott
</p>
<p>
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
</p>
<p>
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
</p>
<p>
You should have received a copy of the GNU General Public License
along with this program.  If not, see <a href="http://www.gnu.org/licenses/">http://www.gnu.org/licenses/</a>.
</p>
<br /><br />
</div>
<div id="footer">
<p>&copy; 2010 <a href="http://www.ttocskcaj.com">ttocskcaj</a><br />
Original CSS Template by <a href="http://www.spyka.net">spyka</a></p>
</div>

</body>
</html>


