<?php

include "validAdmin.php";
include "Core/connection.php";
include 'Core/validCookie.php';

if($verified){

	$getUser = mysqli_stmt_init($link);

	mysqli_stmt_prepare($getUser, "SELECT *, DATE_FORMAT(DateJoined,'%d/%m/%Y') as Joined, DATE_FORMAT(DateOfBirth,'%d/%m/%Y') as DoB 
		FROM userlogin INNER JOIN userdetails ON userlogin.UserID = userdetails.User
		INNER JOIN useraddress ON userdetails.Address = useraddress.AddressID
		INNER JOIN occupations ON userdetails.Occupation = occupations.OccupationID
		WHERE userlogin.UserName = ? and userlogin.Password = ?");
	mysqli_stmt_bind_param($getUser, 'ss', $temp['user'], $temp['pass']);   
	mysqli_stmt_execute($getUser); 


?>