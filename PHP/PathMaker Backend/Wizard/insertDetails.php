<?php

include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");


if(isset($_POST['first']) && isset($_POST['surname']) && isset($_POST['dob']) && isset($_POST['occupation'])){

	$firstname =$_POST['first'];
	$surname = $_POST['surname'];
	$dob = $_POST['dob'];
	$occupation = $_POST['occupation']; 

	$insertDetails = mysqli_stmt_init($link);
	mysqli_stmt_prepare($insertDetails, 'INSERT INTO userdetails (User, FirstName, Surname, DateOfBirth, Occupation) VALUES (?, ?, ?, ?, ?)');
	mysqli_stmt_bind_param($insertDetails, 'issss', $user[1], $firstname, $surname, $dob, $occupation);   
	mysqli_stmt_execute($insertDetails);

	$occupationID = mysqli_stmt_init($link);
	mysqli_stmt_prepare($occupationID, 'SELECT OccupationID from occupations WHERE OccupationName = ?');
	mysqli_stmt_bind_param($occupationID, 's', $occupation);   
	mysqli_stmt_execute($occupationID);
	$result = mysqli_stmt_get_result($occupationID);
	$ID = $result -> fetch_row();
	$occupation = $ID[0];

	$checkDetails = mysqli_stmt_init($link);
	mysqli_stmt_prepare($checkDetails, 'SELECT count(*) from userdetails WHERE User = ?');
	mysqli_stmt_bind_param($checkDetails, '', $user[1]);   
	mysqli_stmt_execute($checkDetails);
	$result = mysqli_stmt_get_result($checkDetails);
	$check = $result -> fetch_row();

	if($check[0] === 0)
	{
		echo "insert";
		$insertDetails = mysqli_stmt_init($link);
		mysqli_stmt_prepare($insertDetails, 'INSERT INTO userdetails (User, FirstName, Surname, DateOfBirth, Occupation) VALUES (?, ?, ?, ?, ?)');
		mysqli_stmt_bind_param($insertDetails, 'issss', $user[1], $firstname, $surname, $dob, $occupation);   
		mysqli_stmt_execute($insertDetails);
	}
	else
	{
		echo "update:".$firstname." ".$surname." ".$dob." ".$occupation;
		$updateDetails = mysqli_stmt_init($link);
		mysqli_stmt_prepare($updateDetails, 'UPDATE userdetails SET FirstName = ?, Surname = ?, DateOfBirth = ?, Occupation = ? WHERE User = ?');
		mysqli_stmt_bind_param($updateDetails, 'ssssi',$firstname, $surname, $dob, $occupation, $user[1]);
		mysqli_stmt_execute($updateDetails);
	}

	include"incrementWizard.php";

}

?>