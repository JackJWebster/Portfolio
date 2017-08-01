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
  <title>Log Out</title>
  <p style="float: right;">
<a href="index.php"?> Home</a>
<p/>
</head>
<body>
	
	<?php
	session_destroy();
	?>
	
<p>Logged Out<br/>
Click <a href="index.php">here</a> to return to Home.</p>
</body>
</html>
 
	<?php
	} else {
    ?>
    
<html                                                    lang="en"> 
<head> 
  <title>Log Out</title>
  <p style="float: right;">
<a href="index.php"?> Home</a>
<p/>
</head>
<body>
<p>Not logged in. <br/>
Click <a href="LogIn.php">here</a> to log in.</p>
</body>
</html>
	
	<?php
	}
	?>
