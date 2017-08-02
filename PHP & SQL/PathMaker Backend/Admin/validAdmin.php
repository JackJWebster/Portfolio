<?php

include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");
$valid = false;



if ($verified) {

	$validAdmin = mysqli_stmt_init($link);
	mysqli_stmt_prepare($validAdmin, "SELECT useraccess.AccessLevel FROM userlogin 
		INNER JOIN useraccess ON userlogin.AccessLevel = useraccess.AccessID
		WHERE userlogin.UserName= ? AND userlogin.Password = ? ");
	mysqli_stmt_bind_param($validAdmin, 'ss', $temp['user'], $temp['pass']);
	mysqli_stmt_execute($validAdmin);

	$result = mysqli_stmt_get_result($validAdmin);
	$access = mysqli_fetch_assoc($result);

	//If user exists the count will be 1
	if ($access["AccessLevel"] >= 10) {
		$valid = true;
	}
}

if (!$valid){
	mysqli_close($link);
	header("Location:http://badapple/HTML/profile.php");
	exit();
}

mysqli_close($link);

?>