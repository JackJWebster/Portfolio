<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<!DOCTYPE html
      PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html                                                    lang="en"> 
<head> 
  <title>Log In</title>
  <p style="float: right;">
<a href="index.php"?> Home</a>
<p/>
</head>
<body>
	
<?php
$username="root";
$password="af6fa99278";
$database="webdesign";
$usernamelogin=$_POST['username'];
$passwordlogin=$_POST['password'];
mysql_connect('localhost',$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$sql="SELECT * FROM Customer WHERE username='$usernamelogin' and password='$passwordlogin'";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count==1){
	
  session_start();
  $_SESSION['username'] = $myusername;
  $_SESSION['password'] = $mypassword; 
  header("location: index.html");
} 
    else {
        echo "Wrong Username or Password";
}
?>
</body>
</html>
