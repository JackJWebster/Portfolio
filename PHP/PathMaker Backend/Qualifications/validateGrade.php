<?php

$validqualification = true;
$validcourse = true;
$validlevel = true;
$validgrade = true;
$validgradeset = true;

$fullinput = true;
$setcourse = true;
$setlevel = true;
$setgrade = true;

include(dirname(__FILE__)."/../Core/connection.php");


if ( isset($_POST['course']) && isset($_POST['level']) && isset($_POST['grade']) ) {
	
	$course = mysqli_real_escape_string($link, $_POST['course']);
	$level = mysqli_real_escape_string($link, $_POST['level']);
	$grade = mysqli_real_escape_string($link, $_POST['grade']);

	$checkCourse = mysqli_stmt_init($link);
	mysqli_stmt_prepare($checkCourse, "SELECT count(*) FROM courses WHERE Course = ?");
	mysqli_stmt_bind_param($checkCourse, 's', $course);   
	mysqli_stmt_execute($checkCourse); 
	$result = mysqli_stmt_get_result($checkCourse);
	$courseresult = $result -> fetch_row();


	$checkLevel = mysqli_stmt_init($link);
	mysqli_stmt_prepare($checkLevel, "SELECT count(*) FROM levels WHERE Level = ?");
	mysqli_stmt_bind_param($checkLevel, 's', $level);   
	mysqli_stmt_execute($checkLevel); 
	$result = mysqli_stmt_get_result($checkLevel);
	$levelresult = $result -> fetch_row();


	$checkGrade = mysqli_stmt_init($link);
	mysqli_stmt_prepare($checkGrade, "SELECT count(*) FROM grades WHERE Grade = ?");
	mysqli_stmt_bind_param($checkGrade, 's', $grade);   
	mysqli_stmt_execute($checkGrade);
	$result = mysqli_stmt_get_result($checkGrade);
	$graderesult = $result -> fetch_row();


	$checkGrade = mysqli_stmt_init($link);
	mysqli_stmt_prepare($checkGrade, "SELECT count(*) FROM grades INNER JOIN levels ON grades.GradeSetID = levels.GradeSet
		WHERE levels.Level = ? and grades.Grade = ?");
	mysqli_stmt_bind_param($checkGrade, 'ss', $level, $grade);   
	mysqli_stmt_execute($checkGrade);
	$result = mysqli_stmt_get_result($checkGrade);
	$gradesetresult = $result -> fetch_row();


	if ($courseresult[0] == 0){
		$validcourse = false;
		$validqualification = false;
	}

	if ($levelresult[0] == 0){
		$validlevel = false;
		$validqualification = false;
	}

	if ($graderesult[0] == 0){
		$validgrade = false;
		$validqualification = false;
	}

	if ($gradesetresult[0] == 0){
		$validgradeset = false;
		$validqualification = false;
	}

	echo json_encode(array("completeinput"=>$fullinput, "qualificationvalid"=>$validqualification, "coursevalid"=>$validcourse, "levelvalid"=>$validlevel, 
		"gradevalid"=>$validgrade, "gradesetvalid"=>$validgradeset));


}
else
{
	if (!isset($_POST['course'])){
		$setcourse = false;
		$validqualification = false;
	}

	if (!isset($_POST['level'])){
		$setlevel = false;
		$validqualification = false;
	}

	if (!isset($_POST['grade'])){
		$setgrade = false;
		$validqualification = false;
	}

	$fullinput= false;

	echo json_encode(array("completeinput"=>$fullinput, "qualificationvalid"=>$validqualification, "courseSet"=>$setcourse, "levelSet"=>$setlevel, 
		"gradeSet"=>$setgrade));
	
}




mysqli_close($link);
?>