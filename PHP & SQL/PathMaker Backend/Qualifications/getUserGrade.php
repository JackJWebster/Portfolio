<?php

include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");

if($verified){

	$getUserGrades = mysqli_stmt_init($link);
	mysqli_stmt_prepare($getUserGrades, "SELECT userqualifications.UserQID , userqualifications.Course,userqualifications.Level,userqualifications.Grade FROM userqualifications");   
	mysqli_stmt_execute($getUserGrades); 

	$gradeslist = mysqli_stmt_get_result($getUserGrades);

	$gradearray = array();

	while($row = mysqli_fetch_assoc($gradeslist)){
		$gradearray[] = array('id'=>$row["UserQID"], 'course' => $row["Course"], 'level'=> $row["Level"], 'Grade'=> $row["Grade"]);
	}
				echo json_encode($gradearray);

}







mysqli_close($link);
?>