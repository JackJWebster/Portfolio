<?php

include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");

if($verified){

	if(isset($_POST['QID'])){
		$QID = mysqli_real_escape_string($link, $_POST['QID']);

		$selectQualification = mysqli_stmt_init($link);
		mysqli_stmt_prepare($selectQualification, "SELECT userqualifications.Level, userqualifications.Grade FROM userqualifications 
			INNER JOIN userlogin ON userqualifications.User = userlogin.UserID
			where userqualifications.UserQID= ? and userlogin.UserName= ? and userlogin.Password= ?");
		mysqli_stmt_bind_param($selectQualification, 'iss', $QID, $temp['user'], $temp['pass']);
		mysqli_stmt_execute($selectQualification);
		$result = mysqli_stmt_get_result($selectQualification);
		$qualif = $result -> fetch_row();






		$deleteQualification = mysqli_stmt_init($link);
		mysqli_stmt_prepare($deleteQualification, "DELETE userqualifications FROM userqualifications 
			INNER JOIN userlogin ON userqualifications.User = userlogin.UserID
			where userqualifications.UserQID= ? and userlogin.UserName= ? and userlogin.Password= ?");
		mysqli_stmt_bind_param($deleteQualification, 'iss', $QID, $temp['user'], $temp['pass']);
		$successful = mysqli_stmt_execute($deleteQualification);

		

		if($successful)
		{
			$getUCASValue = mysqli_stmt_init($link);
			mysqli_stmt_prepare($getUCASValue, "SELECT count(*), ucaspoints.UCASValue FROM ucaspoints
				WHERE ucaspoints.Level = ? AND ucaspoints.Grade = ?");
			mysqli_stmt_bind_param($getUCASValue, 'ii', $qualif[0], $qualif[1]);   
			mysqli_stmt_execute($getUCASValue); 
			$result = mysqli_stmt_get_result($getUCASValue);
			$UCAS = $result -> fetch_row();

			if($UCAS[0] == 1)
				$points= $UCAS[1];
			else
				$points= 0;


			$getPoints = mysqli_stmt_init($link);
			mysqli_stmt_prepare($getPoints, "SELECT UCASPoints FROM userdetails 
				INNER JOIN userlogin ON userdetails.User = userlogin.UserID
				where userlogin.UserName= ? and userlogin.Password = ?");
			mysqli_stmt_bind_param($getPoints, 'ss', $temp['user'], $temp['pass']);   
			mysqli_stmt_execute($getPoints); 
			$result = mysqli_stmt_get_result($getPoints);
			$curpoints = $result -> fetch_row();

			$totalpoints = ($curpoints[0] - $points);

			$updateUCAS = mysqli_stmt_init($link);
			mysqli_stmt_prepare($updateUCAS, 'UPDATE userdetails, userlogin SET UCASPoints = ?
				where userdetails.User = userlogin.UserID and userlogin.UserName= ? and userlogin.Password = ?');
			mysqli_stmt_bind_param($updateUCAS, 'iss', $totalpoints, $temp['user'], $temp['pass']);   
			mysqli_stmt_execute($updateUCAS);
		}






		echo json_encode(array("completed"=>true,"total"=>$totalpoints));
	}

}


?>