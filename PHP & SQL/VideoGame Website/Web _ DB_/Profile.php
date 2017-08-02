<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<!DOCTYPE html
      PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      
      <?php
      session_start();
      ?>
      
<html                                                    lang="en"> 
<head><title>Profile</title>
<p style="float: right;">
<a href="index.php"?> Home</a>
<p/></head>
<body>
<h1>Purchase History</h1>
<p>Here are a list of games you have purchased!</p>


	<?php
	$server='localhost';
	$username="root";
	$password="af6fa99278";
	$database="webdesign";
	$user=$_SESSION['username'];
	
	$con=mysqli_connect($server,$username,$password,$database);
	
	if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
	}
	
	$sql="SELECT * FROM CustomerHistory 
		  INNER JOIN Customer ON Customer.userName = '$user' 
		  INNER JOIN GameList ON CustomerHistory.gameCode = GameList.gameCodes
		  WHERE CustomerHistory.custCode = Customer.customerCode";
	
	$result=mysqli_query($con,$sql);

	echo "<table border='1'>
	<tr>
	<th>Games</th>
	<th>Console</th>
	<th>Loyalty Points</th>
	</tr>";


	while($row = mysqli_fetch_array($result))
	{
	echo "<tr>";
	echo "<td>" . $row['gameName'] . "</td>";
	echo "<td>" . $row['consoleName'] . "</td>";
	echo "<td>" . $row['points'] . "</td>";
	echo "</tr>";
	}
	echo "</table>";

	mysqli_free_result($result);
	?>

<br></br>

	<?php
	$count=mysqli_query($con,"SELECT COUNT(*) FROM CustomerHistory 
						INNER JOIN Customer ON Customer.userName = '$user' 
						WHERE CustomerHistory.custCode = Customer.customerCode");
	
	$countTotal=mysqli_fetch_assoc($count);
	$printCount=$countTotal["COUNT(*)"];
	echo "You have purchased $printCount games!";
	?>

<br></br>

	<?php
	$totalPoints=mysqli_query($con,"SELECT pointsTotal FROM Customer WHERE userName='$user'");
	$pointsTotal=mysqli_fetch_assoc($totalPoints);
	$printTotal=$pointsTotal["pointsTotal"];
	
	$totalvoucher=0.02*$printTotal;
	echo "You have $printTotal points which is equal to $totalvoucher GBP!";
	?>
	
</html>
