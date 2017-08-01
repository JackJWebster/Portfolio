<?php

include(dirname(__FILE__)."/../Core/connection.php");

if(isset($_POST['level'])){

	$CourseLevel = mysqli_real_escape_string($link, $_POST['level']);

	$getGrades = mysqli_stmt_init($link);
	mysqli_stmt_prepare($getGrades, "SELECT Grade FROM grades INNER JOIN levels ON grades.GradeSetID = levels.GradeSet
		WHERE levels.Level = ?");
	mysqli_stmt_bind_param($getGrades, 's', $CourseLevel);   
	mysqli_stmt_execute($getGrades); 

	$result = mysqli_stmt_get_result($getGrades);

	$gradearray = array();

	while($row = mysqli_fetch_assoc($result)){
		$gradearray[] = array('grade' => $row["Grade"]);
	}

	echo json_encode($gradearray);
}
else
{
	$gradearray = array();
	$gradearray[] = array('grade' => "Level is not set");
	echo json_encode($gradearray);
}

mysqli_close($link);
?>