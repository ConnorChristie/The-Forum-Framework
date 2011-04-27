##Quick Warning
TFFW is currently in an unstable state. I have just begun developing, so it is likely to change dramatically.

##What TFFW can do
 - Quickly create a news feed on your homepage.
 - Create a full fledged web forum.
 - Manage users and sessions for your site.

##A quick example
TFFW is more a collection of php classes than a traditional framework like Zend, Cake and CodeIgniter. 
Rather than force you to use architecture like MVC, it lets you design your application however you want.
When you first extract the package you will be presented with a structure that is easy to adapt to use in any style you like.
The idea is that you have an object for each object on the site. A forum is full of objects; posts, users, emails, messages, forums, threads and much more.
For example when you want to register a new user, you can simply create a new user object, set the variables you want using the classes setters. When your user object is populated with a username, email address etc. then you can use the register method to insert it into your database, all in one line of code.
The same goes for a login; you make a new user, set the variables from an HTML form and then when the username/email and password are set on the object, you use the login function, to check the username and password where right and to make a new session.
Example:

    <?php
	    $user = new user();
	    $user->setUsername($_POST['username']);
	    $user->setPassword($_POST['password']);
	    $user->login();
            $user->setSetUserSession();
    ?>

For the full documentation, see http://tffw.ttocskcaj.com/docs/ (soon to come...)
	
##License Info
Copyright (C) 2011 Jack Scott
 
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
 
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with this program (license.txt).  If not, see http://www.gnu.org/licenses/
