<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
session_start()
?>
<html                                                    lang="en"> 
<head>  
 <title>Purchase</title>
 <p style="float: right;">
<a href="index.php"?> Home</a>
<p/>
</head>
<body>

<?php
$username="root";
$password="af6fa99278";
$database="webdesign";
$gamebought=$_GET['gameCodes'];

$_SESSION['username'] = $myusername;
$_SESSION['password'] = $mypassword;

$customercode="SELECT * FROM Customer 
		  INNER JOIN Customer ON Customer.userName = '$myusername' 
		  WHERE CustomerHistory.custCode = Customer.customerCode";

mysql_connect('localhost',$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query = "INSERT INTO CustomerHistory (custCode,purchaseDate,gameCode)
VALUES('$customercode', 555 ,'$gamebought')";mysql_query($query);mysql_close();
?>

</body>
</html>