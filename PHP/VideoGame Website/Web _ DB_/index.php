<!--Making a website-->
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<!DOCTYPE html
      PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
 session_start();
 ?>
 
<html                                                    lang="en"> 
<head>
	<title>Games for days</title>
	
	<?php
 if (isset($_SESSION['username'])) {
 ?>
 
   <p style="float: right;">
<a href="LogOut.php"?> Log Out</a>
<a href="Profile.php"?>Profile</a>
<p/></head>
 
 <?php

 } else {
   ?>
   
   <p style="float: right;">
<a href="LogIn.php"?> Login</a>
<a href="SignUp.html"?> Sign Up</a>
<p/></head>
   
   <?php
 }
 ?>
 
<body>
<h1>Purchase Games</h1>
<p> Welcome to Games For Days, on the site you will find a range of video games for purchase.</p>
<h2> Available Platforms </h2>
<p> At Games For Days we have a fruitful list of consoles to choose from:</p>
<p><ul>
<li><a href="WiiConsole.php"?> Wii </a></li>
<li><a href="DSiConsole.php"?> DSi </a></li>
</ul></p>

</html>
