<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<!DOCTYPE html
      PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	
	<?php
	session_start()
	?>
	
<html                                                    lang="en"> 
<head><title>Games for DSi</title>
<p style="float: right;">
<a href="index.php"?> Home</a>
<p/></head>
<body>
<h1>Games available for DSi</h1>
<p1> Here are the available games for the DSi console, each game purchased comes with loyalty points <br/>
that can be used to save money on future purchases.</p1>
<h2> Available Games </h2>

	<?php
	$con=mysqli_connect("localhost","root","af6fa99278","webdesign");

	if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}


	$result = mysqli_query($con,"SELECT * FROM GameList WHERE ConsoleName='DSi'");


	echo "<table border='1'>
	<tr>
	<th>Games</th>
	<th>Loyalty Points</th>
	<th>Buy link</th>	
	</tr>";


	while($row = mysqli_fetch_array($result))
	{
	echo "<tr>";
	echo "<td>" . $row['gameName'] . "</td>";
	echo "<td>" . $row['pointsValue'] . "</td>";
	echo "<td>" . '<a href="Purchase.php?gameCodes='. $row['gameCodes'] .'">Purchase!</a>' .  "</td>";
	echo "</tr>";
	}
	echo "</table>";


	mysqli_close($con);
	?>

<br/>
<p> For each loyalty point, 0.02GBP of voucher is given!</p>
</body>
</html>
