<?php 
header('Content-Type: application/json');


include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");

if ($verified){
	if (isset($_POST['course']) && isset($_POST['level']) && isset($_POST['grade'])){

		$course = mysqli_real_escape_string($link, $_POST['course']);
		$level = mysqli_real_escape_string($link, $_POST['level']);
		$grade = mysqli_real_escape_string($link, $_POST['grade']);

		$checkCourse = mysqli_stmt_init($link);
		mysqli_stmt_prepare($checkCourse, "SELECT count(*), CourseID FROM courses WHERE Course = ?");
		mysqli_stmt_bind_param($checkCourse, 's', $course);   
		mysqli_stmt_execute($checkCourse); 

		$result = mysqli_stmt_get_result($checkCourse);
		$validcourse = $result -> fetch_row();


		if($validcourse[0] == 1){

			$checkGradeLevel = mysqli_stmt_init($link);
			mysqli_stmt_prepare($checkGradeLevel, "SELECT count(*),levels.LevelID, grades.GradeID FROM grades INNER JOIN levels ON grades.GradeSetID = levels.GradeSet
				WHERE levels.Level = ? and grades.Grade = ?");
			mysqli_stmt_bind_param($checkGradeLevel, 'ss', $level, $grade);   
			mysqli_stmt_execute($checkGradeLevel); 

			$result = mysqli_stmt_get_result($checkGradeLevel);
			$validgrade = $result -> fetch_row();


			$getUCASValue = mysqli_stmt_init($link);
			mysqli_stmt_prepare($getUCASValue, "SELECT count(*), ucaspoints.UCASValue FROM ucaspoints
				WHERE ucaspoints.Level = ? AND ucaspoints.Grade = ?");
			mysqli_stmt_bind_param($getUCASValue, 'ii', $validgrade[1], $validgrade[2]);   
			mysqli_stmt_execute($getUCASValue); 
			$result = mysqli_stmt_get_result($getUCASValue);
			$UCAS = $result -> fetch_row();

			if($UCAS[0] == 1)
				$UCASPoints = $UCAS[1];
			else
				$UCASPoints = 0;


			if ($validgrade[0] == 1) {

				$insertUserGrade = mysqli_stmt_init($link);
				mysqli_stmt_prepare($insertUserGrade, 'INSERT INTO userqualifications (User, Course, Level, Grade ) VALUES (?, ?, ?, ?)');
				mysqli_stmt_bind_param($insertUserGrade, 'iiii', $user[1], $validcourse[1], $validgrade[1], $validgrade[2]);   
				mysqli_stmt_execute($insertUserGrade);

				echo json_encode(array("completed"=>true,"UCASPoints"=>$UCASPoints));

			}
			else
			{
				echo json_encode(array("completed"=>false));
			}

		}




	}
}


mysqli_close($link);
?>