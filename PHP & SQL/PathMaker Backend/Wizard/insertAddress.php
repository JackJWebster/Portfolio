<?php
include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");

if(isset($_POST['number']) && isset($_POST['street']) && isset($_POST['postcode']) && isset($_POST['city'])){

	$number = $_POST['number'];
	$street = $_POST['street'];
	$pc = $_POST['postcode'];
	$city = $_POST['city']; 

	$getAddressID = mysqli_stmt_init($link);
	mysqli_stmt_prepare($getAddressID, "SELECT userdetails.Address FROM userdetails INNER JOIN userlogin ON userlogin.UserID = userdetails.User
		WHERE userlogin.UserName = ? and userlogin.Password = ?");
	mysqli_stmt_bind_param($getAddressID, 'ss', $temp['user'], $temp['pass']);   
	mysqli_stmt_execute($getAddressID); 
	$result = mysqli_stmt_get_result($getAddressID);
	$num_row = mysqli_num_rows($result);
	$row = mysqli_fetch_assoc($result);
	$addressID = $row["Address"];


	if($num_row === 1)
	{

		$checkAddress = mysqli_stmt_init($link);
		mysqli_stmt_prepare($checkAddress, 'SELECT count(*) from useraddress WHERE AddressID = ?');
		mysqli_stmt_bind_param($checkAddress, 'i', $addressID);   
		mysqli_stmt_execute($checkAddress);
		$result = mysqli_stmt_get_result($checkAddress);
		$check = $result -> fetch_row();

		if($check === 0)
		{
			$insertAddress = mysqli_stmt_init($link);
			mysqli_stmt_prepare($insertAddress, 'INSERT INTO useraddress (AddressID, HouseNumberName, StreetName, PostCode, City) VALUES (?, ?, ?, ?, ?)');
			mysqli_stmt_bind_param($insertAddress, 'issss', $addressID, $number, $street, $pc, $city);   
			mysqli_stmt_execute($insertAddress);
		}
		else
		{
			$updateAddress = mysqli_stmt_init($link);
			mysqli_stmt_prepare($updateAddress, 'UPDATE useraddress SET HouseNumberName = ?, StreetName = ?, PostCode = ?, City = ? WHERE AddressID = ?');
			mysqli_stmt_bind_param($updateAddress, 'ssssi', $number, $street, $pc, $city, $addressID);
			mysqli_stmt_execute($updateAddress);
		}

		include"incrementWizard.php";
	}
}

?>