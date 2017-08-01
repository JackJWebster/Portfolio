<?php

include 'Core/connection.php';
include 'Core/validCookie.php';


//$getUserGrades = mysqli_stmt_init($link);
//	mysqli_stmt_prepare($getUserGrades, "SELECT courses.Course,levels.Level,grades.Grade FROM userqualifications 
//		INNER JOIN userlogin ON userqualifications.User = userlogin.UserID
//		INNER JOIN courses ON userqualifications.Course = courses.CourseID
//		INNER JOIN levels ON userqualifications.Level = levels.LevelID
//		INNER JOIN grades ON userqualifications.Grade = grades.GradeID
//		where userlogin.UserName= ? and userlogin.Password = ? ORDER BY levels.Level");
//	mysqli_stmt_bind_param($getUserGrades, 'ss', $temp['user'], $temp['pass']);   
//	mysqli_stmt_execute($getUserGrades);

$getHistory = mysqli_stmt_init($link);

mysqli_stmt_prepare($getHistory, "SELECT courses.Course,levels.Level,grades.Grade FROM userqualifications 
		INNER JOIN userlogin ON userqualifications.User = userlogin.UserID
		INNER JOIN courses ON userqualifications.Course = courses.CourseID
		INNER JOIN levels ON userqualifications.Level = levels.LevelID
		INNER JOIN grades ON userqualifications.Grade = grades.GradeID
		where userlogin.UserName= ? and userlogin.Password = ?");  
	mysqli_stmt_bind_param($getHistory, 'ss', $temp['user'], $temp['pass']);
mysqli_stmt_execute($getHistory); 

while($row = mysqli_fetch_assoc($result)){
		echo json_encode(array("user"=>$row['UserName'],"joined"=>$row['Joined'],"firstname"=>$row['FirstName'],
			"surname"=>$row['Surname'],"dobcorrected"=>$row['DoB'],"dobnormal"=>$row['DateOfBirth'],"email"=>$row['EmailAddress'],
			"number"=>$row['HouseNumberName'], "street"=>$row['StreetName'], "postcode"=>$row['PostCode'],
			"city"=>$row['City'],"occupation"=>$row['OccupationName'], "error"=>0));
	}


$result = mysqli_stmt_get_result($getHistory);

?>