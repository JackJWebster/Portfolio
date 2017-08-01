<?php

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

	$result = mysqli_stmt_get_result($getUser);

	while($row = mysqli_fetch_assoc($result)){
		echo json_encode(array("user"=>$row['UserName'],"joined"=>$row['Joined'],"firstname"=>$row['FirstName'],"surname"=>$row['Surname'],"dobcorrected"=>$row['DoB'],"dobnormal"=>$row['DateOfBirth'],"email"=>$row['EmailAddress'],
			"number"=>$row['HouseNumberName'], "street"=>$row['StreetName'], "postcode"=>$row['PostCode'],
			"city"=>$row['City'],"occupation"=>$row['OccupationName'], "error"=>0));
	}
}
else
{
	echo json_encode(array("error"=>1));
}

mysqli_close($link);
?>