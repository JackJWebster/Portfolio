<?php 

include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");

if ($verified){
	if (isset($_POST['QID']) && isset($_POST['level']) && isset($_POST['grade'])){

		$QID = $_POST['QID'];
		$level =  $_POST['level'];
		$grade = $_POST['grade'];

		$checkQID = mysqli_stmt_init($link);
		mysqli_stmt_prepare($checkQID, "SELECT count(*), userqualifications.Level, userqualifications.Grade FROM userqualifications 
			INNER JOIN userlogin ON userqualifications.User = userlogin.UserID
			WHERE userlogin.UserName = ? AND userlogin.Password = ? AND userqualifications.UserQID = ?");
		mysqli_stmt_bind_param($checkQID, 'ssi',$temp['user'],$temp['pass'], $QID);   
		mysqli_stmt_execute($checkQID); 

		$result = mysqli_stmt_get_result($checkQID);
		$validcourse = $result -> fetch_row();

		if($validcourse[0] == 1){

			$oldUCASValue =getValue($link, $validcourse[1], $validcourse[2]);


				$checkGradeLevel = mysqli_stmt_init($link);
				mysqli_stmt_prepare($checkGradeLevel, "SELECT count(*),levels.LevelID, grades.GradeID FROM grades INNER JOIN levels ON grades.GradeSetID = levels.GradeSet
					WHERE levels.Level = ? and grades.Grade = ?");
				mysqli_stmt_bind_param($checkGradeLevel, 'ss', $level, $grade);   
				mysqli_stmt_execute($checkGradeLevel); 

				$result = mysqli_stmt_get_result($checkGradeLevel);
				$validgrade = $result -> fetch_row();


				$newUCASValue = getValue($link, $validgrade[1], $validgrade[2]);
				$difValue = $newUCASValue - $oldUCASValue;

				if ($validgrade[0] == 1) {

					$updateGrade = mysqli_stmt_init($link);
					mysqli_stmt_prepare($updateGrade, 'UPDATE userqualifications SET Level = ?, Grade = ? where UserQID =?');
					mysqli_stmt_bind_param($updateGrade, 'iii', $validgrade[1],$validgrade[2], $QID);   
					mysqli_stmt_execute($updateGrade); 


					$getPoints = mysqli_stmt_init($link);
					mysqli_stmt_prepare($getPoints, "SELECT UCASPoints FROM userdetails 
						INNER JOIN userlogin ON userdetails.User = userlogin.UserID
						where userlogin.UserName= ? and userlogin.Password = ?");
					mysqli_stmt_bind_param($getPoints, 'ss', $temp['user'], $temp['pass']);   
					mysqli_stmt_execute($getPoints); 
					$result = mysqli_stmt_get_result($getPoints);
					$points = $result -> fetch_row();

					$totalpoints = $points[0] + $difValue;

					$updateUCAS = mysqli_stmt_init($link);
					mysqli_stmt_prepare($updateUCAS, 'UPDATE userdetails, userlogin SET UCASPoints = ?
						where userdetails.User = userlogin.UserID and userlogin.UserName= ? and userlogin.Password = ?');
					mysqli_stmt_bind_param($updateUCAS, 'iss', $totalpoints, $temp['user'], $temp['pass']);   
					mysqli_stmt_execute($updateUCAS);

					echo json_encode($difValue);

				}
			// else
				// echo "Not Valid Update";
			}
		// else
			// echo "Not your QID";
		}
	}


	function getValue($link,$checklevel, $checkgrade)
	{
		$getUCASValue = mysqli_stmt_init($link);
		mysqli_stmt_prepare($getUCASValue, "SELECT count(*), ucaspoints.UCASValue FROM ucaspoints
			WHERE ucaspoints.Level = ? AND ucaspoints.Grade = ?");
		mysqli_stmt_bind_param($getUCASValue, 'ii', $checklevel, $checkgrade);   
		mysqli_stmt_execute($getUCASValue); 
		$result = mysqli_stmt_get_result($getUCASValue);
		$UCAS = $result -> fetch_row();

		if($UCAS[0] == 1)
			return $UCAS[1];
		else
			return 0;
	}


	mysqli_close($link);

	?>