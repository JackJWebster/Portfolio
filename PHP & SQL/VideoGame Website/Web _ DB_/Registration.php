<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<!DOCTYPE html
      PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html                                                    lang="en"> 
<head>  
  <title>Registration</title>
  <p style="float: right;">
<a href="index.php"?> Home</a>
<p/>
</head>
<body>
	
	<?php
	$username="root";
	$password="af6fa99278";
	$database="webdesign";
	$firstName=$_POST['first_name'];
	$lastName=$_POST['last_name'];
	$usernamelogin=$_POST['username'];
	$passwordlogin=$_POST['password'];
	
	mysql_connect('localhost',$username,$password);
	@mysql_select_db($database) or die( "Unable to select database");

	$query = "INSERT INTO Customer (firstName,lastName,userName,password,pointsTotal) 
			  VALUES('$firstName','$lastName','$usernamelogin','$passwordlogin',0)";
	
	mysql_query($query);
	mysql_close();
	?>

<p>Registration Successful</p>
</body>
</html>
