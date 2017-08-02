<?php

include "Core/connection.php";
include "Core/validCookie.php";

if($verified){

	$getUserGrades = mysqli_stmt_init($link);
	mysqli_stmt_prepare($getUserGrades, "SELECT userqualifications.UserQID , courses.Course,levels.Level,grades.Grade FROM userqualifications");
	mysqli_stmt_bind_param($getUserGrades, 'ss', $temp['user'], $temp['pass']);   
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