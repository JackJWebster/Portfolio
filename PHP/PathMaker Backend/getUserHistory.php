<?php

include 'Core/connection.php';
include 'Core/validCookie.php';


$getHistory = mysqli_stmt_init($link);

mysqli_stmt_prepare($getHistory, "SELECT courses.Course,levels.Level,grades.Grade FROM userqualifications 
		INNER JOIN userlogin ON userqualifications.User = userlogin.UserID
		INNER JOIN courses ON userqualifications.Course = courses.CourseID
		INNER JOIN levels ON userqualifications.Level = levels.LevelID
		INNER JOIN grades ON userqualifications.Grade = grades.GradeID
		where userlogin.UserName= ? and userlogin.Password = ? ORDER BY levels.Level");  
	mysqli_stmt_bind_param($getHistory, 'ss', $temp['user'], $temp['pass']);
mysqli_stmt_execute($getHistory); 

$result = mysqli_stmt_get_result($getHistory);

while($row = mysqli_fetch_assoc($result)){
		echo json_encode(array("Level"=>$row['Level'],"Course"=>$row['Course'],"Grade"=>$row['Grade'],
                               "error"=>0));
	}




?>