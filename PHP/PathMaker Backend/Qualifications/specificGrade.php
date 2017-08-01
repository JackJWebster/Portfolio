<?php

include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");

if(isset($_POST["QID"])){
	if($verified){



		$QID = $_POST["QID"];
		$levelSelections = "";
		$gradeSelections = "";


		$getQualification = mysqli_stmt_init($link);
		mysqli_stmt_prepare($getQualification, "SELECT grades.Grade, courses.Course,levels.Level FROM userqualifications 
			INNER JOIN userlogin ON userqualifications.User = userlogin.UserID
			INNER JOIN courses ON userqualifications.Course = courses.CourseID
			INNER JOIN levels ON userqualifications.Level = levels.LevelID
			INNER JOIN grades ON userqualifications.Grade = grades.GradeID
			WHERE userlogin.UserName= ? AND userlogin.Password = ? and userqualifications.UserQID = ?");
		mysqli_stmt_bind_param($getQualification, 'ssi', $temp['user'], $temp['pass'], $QID);   
		mysqli_stmt_execute($getQualification); 
		$result = mysqli_stmt_get_result($getQualification);
		$currentgrade = mysqli_fetch_assoc($result);

		$course = $currentgrade["Course"];
		$curlevel = $currentgrade["Level"];
		$curgrade = $currentgrade["Grade"];

		$htmledit = "<div col-sm-12><div id='info'> ".$course."</div><br>";

		$getCourses = mysqli_stmt_init($link);
		mysqli_stmt_prepare($getCourses, "SELECT Level FROM levels");  
		mysqli_stmt_execute($getCourses); 
		$result = mysqli_stmt_get_result($getCourses);

		$levelSelections = "<select id='levelselect' name='level' class='form-control' onchange='javascript: gradeselected();'>";
		while($row = mysqli_fetch_assoc($result))
		{
			if ($curlevel === $row["Level"])
			{
				$selection = "<option value='".$row["Level"]."' selected>".$row["Level"]."</option>";
			}
			else
			{
				$selection = "<option value='".$row["Level"]."'>".$row["Level"]."</option>";
			}
			$levelSelections = $levelSelections.$selection;
		}
		$levelSelections = $levelSelections."</select><br>";



		$getGrades = mysqli_stmt_init($link);
		mysqli_stmt_prepare($getGrades, "SELECT Grade FROM grades INNER JOIN levels ON grades.GradeSetID = levels.GradeSet
			WHERE levels.Level = ?");
		mysqli_stmt_bind_param($getGrades, 's', $currentgrade["Level"]);   
		mysqli_stmt_execute($getGrades); 
		$result = mysqli_stmt_get_result($getGrades);

		$gradeSelections = "<div id='gradediv'><select id='gradeselect' name='grade' class='form-control'>";
		while($row = mysqli_fetch_assoc($result))
		{
			if( $curgrade === $row["Grade"])
			{
				$selection = "<option value='".$row["Grade"]."' selected>".$row["Grade"]."</option>";
			}
			else
			{
				$selection = "<option value='".$row["Grade"]."'>".$row["Grade"]."</option>";
			}
			$gradeSelections = $gradeSelections.$selection;
		}
		$gradeSelections = $gradeSelections."</select></div><br>";

		$button = "<button onclick=updatequalification($QID) class='btn-info btn-lg'> Save </button></div>";


		$htmledit = $htmledit.$levelSelections.$gradeSelections.$button;


		// echo  $htmledit;
		echo json_encode(array('html'=>$htmledit));

	}
}







mysqli_close($link);
?>