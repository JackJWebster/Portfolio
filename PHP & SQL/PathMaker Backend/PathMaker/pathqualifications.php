<?php

include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");

$getQualifications = mysqli_stmt_init($link);

mysqli_stmt_prepare($getQualifications, "SELECT grades.Grade, courses.Course, levels.Level FROM userqualifications 
	INNER JOIN userlogin ON userqualifications.User = userlogin.UserID
	INNER JOIN courses ON userqualifications.Course = courses.CourseID
	INNER JOIN levels ON userqualifications.Level = levels.LevelID
	INNER JOIN grades ON userqualifications.Grade = grades.GradeID
	where userlogin.UserName= ? and userlogin.Password = ? ORDER BY levels.Level");
mysqli_stmt_bind_param($getQualifications, 'ss', $temp['user'], $temp['pass']);   
mysqli_stmt_execute($getQualifications); 


$result = mysqli_stmt_get_result($getQualifications);

	$gradearray = array();

while($row = mysqli_fetch_assoc($result)){
	$gradearray[] = array("level"=> $row["Level"], "course"=> $row["Course"], "grade"=> $row["Grade"]);
}

echo json_encode($gradearray);

mysqli_close($link);

?>