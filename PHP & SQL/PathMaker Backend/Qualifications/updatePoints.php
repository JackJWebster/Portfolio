<?php

include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");

if($verified){

	if(isset($_POST['points'])){

		$totalpoints = $_POST['points'];

		$getPoints = mysqli_stmt_init($link);
		mysqli_stmt_prepare($getPoints, "SELECT UCASPoints FROM userdetails 
			INNER JOIN userlogin ON userdetails.User = userlogin.UserID
			where userlogin.UserName= ? and userlogin.Password = ?");
		mysqli_stmt_bind_param($getPoints, 'ss', $temp['user'], $temp['pass']);   
		mysqli_stmt_execute($getPoints); 
		$result = mysqli_stmt_get_result($getPoints);
		$points = $result -> fetch_row();

		$totalpoints = $totalpoints + $points[0];

		$updateUCAS = mysqli_stmt_init($link);
		mysqli_stmt_prepare($updateUCAS, 'UPDATE userdetails, userlogin SET UCASPoints = ?
			where userdetails.User = userlogin.UserID and userlogin.UserName= ? and userlogin.Password = ?');
		mysqli_stmt_bind_param($updateUCAS, 'iss', $totalpoints, $temp['user'], $temp['pass']);   
		mysqli_stmt_execute($updateUCAS); 

	}


}


mysqli_close($link);

?>