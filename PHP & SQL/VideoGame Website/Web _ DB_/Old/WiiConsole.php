<!-- Wii Page -->
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<!DOCTYPE html
      PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html                                                    lang="en"> 
<head><title>Games for Wii</title>
<p style="float: right;">
<a href="index.php"?> Home</a>
<p/></head>
<body>
<h1>Games available for Wii</h1>
<p1> Here are the available games for the Wii console, each game purchased comes with loyalty points <br/>
that can be used to save money on future purchases</p1>
<h2> Available Games </h2>
<?php
$con=mysqli_connect("localhost","root","af6fa99278","webdesign");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


$result = mysqli_query($con,"SELECT * FROM GameList WHERE ConsoleName='Wii'");


echo "<table border='1'>
<tr>
<th>Games</th>
<th>Loyalty Points</th>
</tr>";


while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['gameName'] . "</td>";
  echo "<td>" . $row['pointsValue'] . "</td>";
  echo "</tr>";
  }
echo "</table>";


mysqli_close($con);
?>
<br/>
<p2> For each loyalty point, £0.02 of voucher is given!

</html>
