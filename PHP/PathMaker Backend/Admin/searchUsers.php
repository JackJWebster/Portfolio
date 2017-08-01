<?php


include "validAdmin.php";
include(dirname(__FILE__)."/../Core/connection.php");


if(isset($_POST['namesearch'])){

	$search = "%".mysqli_real_escape_string($link, $_POST['namesearch'])."%";

	$searchUsers = mysqli_stmt_init($link);
	mysqli_stmt_prepare($searchUsers, "SELECT userlogin.UserID, userlogin.UserName,userlogin.EmailAddress,userlogin.DateJoined, userdetails.FirstName,userdetails.Surname 
		FROM userlogin INNER JOIN userdetails ON userlogin.UserID = userdetails.User
		WHERE CONCAT( userdetails.FirstName, ' ', userdetails.Surname) LIKE ?
		ORDER BY userdetails.FirstName, userdetails.Surname LIMIT 100");

	mysqli_stmt_bind_param($searchUsers, 's', $search); 
	mysqli_stmt_execute($searchUsers); 
	$result = mysqli_stmt_get_result($searchUsers);

	$userarray = array();


	$countUsers = mysqli_stmt_init($link);
	mysqli_stmt_prepare($countUsers, "SELECT count(*) as usercount 
		FROM userlogin INNER JOIN userdetails ON userlogin.UserID = userdetails.User
		WHERE CONCAT( userdetails.FirstName, ' ', userdetails.Surname) LIKE ?
		ORDER BY userdetails.FirstName, userdetails.Surname");

	mysqli_stmt_bind_param($countUsers, 's', $search); 
	mysqli_stmt_execute($countUsers); 
	$numberresult = mysqli_stmt_get_result($countUsers);
	$numrow = mysqli_fetch_assoc($numberresult);




	while($row = mysqli_fetch_assoc($result)){
		$userarray[] = array('userid' => $row["UserID"], 'username' => $row["UserName"], 'first' => $row["FirstName"], 'surname' => $row["Surname"], 
			'email' => $row["EmailAddress"], 'dj' => $row["DateJoined"], 'numberofusers' =>$numrow['usercount']);
	}

	echo json_encode($userarray);
}


mysqli_close($link);

?>