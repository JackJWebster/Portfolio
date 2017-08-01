<?php


include "validAdmin.php";
include(dirname(__FILE__)."/../Core/connection.php");

$getAllUsers = mysqli_stmt_init($link);

mysqli_stmt_prepare($getAllUsers, "SELECT userlogin.UserID, userlogin.UserName,userlogin.EmailAddress,userlogin.DateJoined, userdetails.FirstName, userdetails.Surname 
	FROM userlogin INNER JOIN userdetails ON userlogin.UserID = userdetails.User
	ORDER BY userdetails.FirstName, userdetails.Surname LIMIT 100");
mysqli_stmt_execute($getAllUsers); 

$result = mysqli_stmt_get_result($getAllUsers);

while($row = mysqli_fetch_assoc($result)){

	echo "<tr  onclick='userselected(".$row["UserID"].")'><td>".$row["UserID"]."</td>
	<td>".$row["UserName"]."</td>
	<td>".$row["FirstName"]."</td>
	<td>".$row["Surname"]."</td>
	<td>".$row["EmailAddress"]."</td>
	<td>".$row["DateJoined"]."</td>
	</tr>";

}


mysqli_close($link);

?>