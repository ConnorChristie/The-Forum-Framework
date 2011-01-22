##Quick Warning
TFFW is currently in an unstable state. I have just begun developing, so it is likely to change dramatically.

##About TFFW
The Forum Framework (TFFW) is a php framework aimed towards creating internet forums and bulletin boards. 
Like the popular forum content management systems (CMS), such as phpbb and mybb, TFFW lets you make your very own forum. 
Unlike these TFFW is not a cms. Instead it is a php framework that allows you to write a brand new forum CMS quickly and easily. 
This allows you to create your forum exactly the way you want. 
If you can't, or don't want to create a new forum CMS from scratch, you can use one of our great templates. This provides a more familiar, user friendly CMS. 
TFFW is not limited towards just forums. You can easily modify it to create other CMS programs, such as a blog or something more ambitious

##How it works
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

##License 
TFFW is licenced under the GNU General Public License, version 3 (GPLv3)
