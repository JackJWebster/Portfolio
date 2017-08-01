<?php

$section = 0;
$newsection = "*";
$handle = @fopen("../Database/levelgrade.txt", "r"); //read line one by one

include "Core/connection.php";

while (!feof($handle)) // Loop til end of file.
{
	 $buffer = fgets($handle); // Read a line.

	 if( strcmp($buffer, $newsection) != 2 ){


	 	if($section==0){
	 		$buffer = str_replace("\r\n","",$buffer);
	 		$checkOccupation = mysqli_stmt_init($link);
	 		mysqli_stmt_prepare($checkOccupation, "select count(*) from occupations where OccupationName= ?");
	 		mysqli_stmt_bind_param($checkOccupation, 's',$buffer);
	 		mysqli_stmt_execute($checkOccupation);

	 		$result = mysqli_stmt_get_result($checkOccupation);
	 		$count = $result -> fetch_row();

	 		if ($count[0] == 0) {
	 			$newOccupation = mysqli_stmt_init($link);
	 			mysqli_stmt_prepare($newOccupation, 'INSERT INTO occupations (OccupationName) VALUES (?)');
	 			mysqli_stmt_bind_param($newOccupation, 's', $buffer);   
	 			mysqli_stmt_execute($newOccupation);
	 		}


	 	}


	 	if($section==1){
	 		list($level,$levelset)=explode("|",$buffer);
	 		$levelset = intval($levelset);

	 		$checkLevel = mysqli_stmt_init($link);
	 		mysqli_stmt_prepare($checkLevel, "select count(*) from levels where Level= ? and Gradeset = ?");
	 		mysqli_stmt_bind_param($checkLevel, 'si',$level, $levelset);
	 		mysqli_stmt_execute($checkLevel);

	 		$result = mysqli_stmt_get_result($checkLevel);
	 		$count = $result -> fetch_row();

	 		if ($count[0] == 0){

	 			$newLevel = mysqli_stmt_init($link);
	 			mysqli_stmt_prepare($newLevel, 'INSERT INTO levels (Level, Gradeset) VALUES (?, ?)');
	 			mysqli_stmt_bind_param($newLevel, 'si', $level, $levelset);   
	 			mysqli_stmt_execute($newLevel);

	 		}
	 	}


	 	if($section==2){

	 		list($grade,$gradeset)=explode("|",$buffer);
	 		$gradeset = intval($gradeset);


	 		$checkGrade = mysqli_stmt_init($link);
	 		mysqli_stmt_prepare($checkGrade, "select count(*) from grades where Grade= ? and GradeSetID = ?");
	 		mysqli_stmt_bind_param($checkGrade, 'si',$grade, $gradeset);
	 		mysqli_stmt_execute($checkGrade);

	 		$result = mysqli_stmt_get_result($checkGrade);
	 		$count = $result -> fetch_row();

	 		if ($count[0] == 0){

	 			$newGrade = mysqli_stmt_init($link);
	 			mysqli_stmt_prepare($newGrade, 'INSERT INTO grades (Grade, GradesetID) VALUES (?, ?)');
	 			mysqli_stmt_bind_param($newGrade, 'si', $grade, $gradeset);   
	 			mysqli_stmt_execute($newGrade);

	 		}

	 	}

	 	if($section==3){
	 		list($name,$access)=explode("|",$buffer);

	 		$buffer = str_replace("\r\n","",$buffer);
	 		$checkAccess = mysqli_stmt_init($link);
	 		mysqli_stmt_prepare($checkAccess, "select count(*) from useraccess where AccessName= ? and AccessLevel = ?");
	 		mysqli_stmt_bind_param($checkAccess, 'si',$name, $access);
	 		mysqli_stmt_execute($checkAccess);

	 		$result = mysqli_stmt_get_result($checkAccess);
	 		$count = $result -> fetch_row();

	 		if ($count[0] == 0) {
	 			$newAccess = mysqli_stmt_init($link);
	 			mysqli_stmt_prepare($newAccess, 'INSERT INTO useraccess (AccessName, AccessLevel) VALUES (?, ?)');
	 			mysqli_stmt_bind_param($newAccess, 'si', $name, $access);   
	 			mysqli_stmt_execute($newAccess);
	 		}


	 	}

	 	if($section==4){

	 		$buffer = str_replace("\r\n","",$buffer);

	 		$checkMonth = mysqli_stmt_init($link);
	 		mysqli_stmt_prepare($checkMonth, "select count(*) from months where MonthName= ? ");
	 		mysqli_stmt_bind_param($checkMonth, 's',$buffer);
	 		mysqli_stmt_execute($checkMonth);

	 		$result = mysqli_stmt_get_result($checkMonth);
	 		$count = $result -> fetch_row();

	 		if ($count[0] == 0) {
	 			$newMonth = mysqli_stmt_init($link);
	 			mysqli_stmt_prepare($newMonth, 'INSERT INTO months (MonthName) VALUES (?)');
	 			mysqli_stmt_bind_param($newMonth, 's', $buffer);   
	 			mysqli_stmt_execute($newMonth);
	 		}
	 	}


	 	if($section===5){
	 		list($level,$grade,$ucas)=explode("|",$buffer);

	 		$getID = mysqli_stmt_init($link);
	 		mysqli_stmt_prepare($getID, "SELECT count(*), grades.GradeID, levels.LevelID FROM levels
	 			INNER JOIN grades ON levels.Gradeset = grades.GradeSetID
	 			where levels.Level= ? AND grades.Grade = ? ");
	 		mysqli_stmt_bind_param($getID, 'ss',$level,$grade);
	 		mysqli_stmt_execute($getID);

	 		$result = mysqli_stmt_get_result($getID);
	 		$count = $result -> fetch_row();
	 		echo "check";
	 		if($count[0] == 1)
	 		{
	 			$levelid = $count[2];
	 			$gradeid = $count[1];
	 			echo "valid {".$levelid.", ".$gradeid."}";

	 			$checkUCAS = mysqli_stmt_init($link);
	 			mysqli_stmt_prepare($checkUCAS, "SELECT count(*) FROM ucaspoints where Level= ? AND Grade = ? ");
	 			mysqli_stmt_bind_param($checkUCAS, 'ii',$levelid,$gradeid);
	 			mysqli_stmt_execute($checkUCAS);
	 			$result = mysqli_stmt_get_result($checkUCAS);
	 			$count = $result -> fetch_row();
	 			
	 			if($count[0] == 0)
	 			{
	 				echo "insert ";
	 				$newUCAS = mysqli_stmt_init($link);
	 				mysqli_stmt_prepare($newUCAS, 'INSERT INTO ucaspoints (Level, Grade, UCASValue) VALUES (?, ?, ?)');
	 				mysqli_stmt_bind_param($newUCAS, 'iii', $levelid, $gradeid, $ucas);   
	 				mysqli_stmt_execute($newUCAS);
	 			}

	 		}
	 	}


	 }
	 else
	 {
	 	$section = $section + 1;
	 }



	}
	mysqli_close($link);
	?>