<?php

$link = mysqli_connect('localhost', 'jw242','kandersteg');    //Change to your mysql password
if (!$link) { 
	die('Could not connect to MySQL: ' . mysqli_connect_error()); 
} 

mysqli_select_db($link,"pathmaker"); //Selects the Database


?>
