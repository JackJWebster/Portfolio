<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html                                                    lang="en"> 
<head>  
 <title>Game Added</title>
 <p style="float: right;">
<a href="index.php"?> Home</a>
<p/>
</head>
<body>

<?php
$username="root";
$password="af6fa99278";
$database="webdesign";
$gamename=$_POST['game_name'];
$consolename=$_POST['console_name'];
$pointsvalue=$_POST['points_value'];
mysql_connect('localhost',$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query = "INSERT INTO GameList (gameName,consoleName,pointsValue) 
VALUES('$gamename','$consolename','$pointsvalue')";mysql_query($query);mysql_close();?>

<p>Game Added</p>
</body>
</html>