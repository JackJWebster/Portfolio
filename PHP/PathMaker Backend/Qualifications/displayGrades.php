<?php

include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");

if($verified){


	$getUserGrades = mysqli_stmt_init($link);
	mysqli_stmt_prepare($getUserGrades, "SELECT userqualifications.UserQID, courses.Course,levels.Level,grades.Grade FROM userqualifications 
		INNER JOIN userlogin ON userqualifications.User = userlogin.UserID
		INNER JOIN courses ON userqualifications.Course = courses.CourseID
		INNER JOIN levels ON userqualifications.Level = levels.LevelID
		INNER JOIN grades ON userqualifications.Grade = grades.GradeID
		where userlogin.UserName= ? and userlogin.Password = ? ORDER BY levels.Level, grades.Grade");
	mysqli_stmt_bind_param($getUserGrades, 'ss', $temp['user'], $temp['pass']);   
	mysqli_stmt_execute($getUserGrades); 

	$gradeslist = mysqli_stmt_get_result($getUserGrades);

	while($row = mysqli_fetch_assoc($gradeslist)){
		
		echo "<tr id='".$row["UserQID"]."' onclick='qualificationclicked(".$row["UserQID"].")'><td id='course'>".$row["Course"]."</td><td id='level'>".$row["Level"]."</td><td id='grade'>".$row["Grade"]."</td></tr>";
	} 


}


mysqli_close($link);

?>