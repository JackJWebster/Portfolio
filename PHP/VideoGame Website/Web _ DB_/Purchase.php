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
	$myusername = $_SESSION['username'];
	$con=mysqli_connect('localhost',$username,$password,$database);
		
	$customercode=mysqli_query($con,"SELECT customerCode FROM Customer WHERE userName = '$myusername'");
	$code=mysqli_fetch_assoc($customercode);
	$custcode=$code["customerCode"];

	$sql = "INSERT INTO CustomerHistory (custCode,gameCode)
	VALUES('$custcode','$gamebought')";
	
	mysqli_query($con,$sql);
	
	
	mysqli_query($con,"UPDATE CustomerHistory x LEFT JOIN GameList y
				 ON y.gameCodes=x.gameCode
				 SET x.points=y.pointsValue;");

	mysqli_query($con,"UPDATE Customer x LEFT JOIN(
				 SELECT custCode, SUM(points) pointSum
				 FROM CustomerHistory
				 GROUP BY custCode)
				 y ON x.customerCode = y.custCode
				 SET x.pointsTotal = y.pointSum;");
				 
	mysqli_close($con);
	?>

<p>Game Purchased!</p>
</body>
</html>
