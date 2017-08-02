<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<!DOCTYPE html
      PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      
	<?php
	session_start();
	if (isset($_SESSION['username'])) {
	?>
	
   <html                                                    lang="en"> 
<head> 
  <title>Logged In</title>
  <p style="float: right;">
<a href="index.php"?> Home</a>
<p/>
</head>
<body>
	<p>Already logged in.<br/>
	 Click <a href="index.php">here</a> to return to Home.</p>

</body>
</html>

	<?php
	} else {
	?>
	
   <html                                                    lang="en"> 
<head> 
  <title>Log In</title>
  <p style="float: right;">
<a href="index.php"?> Home</a>
<p/>
</head>
<body>
	<h1>Log In</h1>
<form action = "AfterLogin.php"  method = "POST"  >
<table>
  <tr><td> Username </td><td><input type = "text"   name = "username"  size = "20"  /> </td></tr>
  <tr><td> Password </td><td><input type = "password"   name = "password"  size = "20"  /> </td></tr>
</table>
<p><input type="submit" value="Log In" /></p>
</form>
</body>
</html>

	<?php
	}
	?>
