<?php

include"Core/connection.php";
include"Core/validCookie.php";

if($verified){

	if(isset($_POST['jobid'])){

		$JobID = mysqli_real_escape_string($link, $_POST['jobid']);
		
		$deleteEmployment = mysqli_stmt_init($link);
		mysqli_stmt_prepare($deleteEmployment, "DELETE useremployment FROM useremployment 
			INNER JOIN userlogin ON useremployment.UserID = userlogin.UserID
			where useremployment.EmploymentID= ? and userlogin.UserName= ? and userlogin.Password= ?");
		mysqli_stmt_bind_param($deleteEmployment, 'iss', $JobID, $temp['user'], $temp['pass']);
		mysqli_stmt_execute($deleteEmployment);

		echo json_encode(array("completed"=>true));
	}


}


?>