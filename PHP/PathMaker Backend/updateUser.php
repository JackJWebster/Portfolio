<?php

include "Core/connection.php";

if (isset($_COOKIE['confirmation'])) {
	if ( !empty($_POST['firstname']) && !empty($_POST['surname']) && !empty($_POST['DoB'])  && !empty(['email']) && !empty(['number']) && !empty(['street']) && !empty(['city']) && !empty(['postcode'])) {

		$temp = unserialize($_COOKIE['confirmation']);

		//Retreives users ID from the database
		$getId = mysqli_stmt_init($link);
		mysqli_stmt_prepare($getId, "select UserID from userlogin where UserName= ? and Password = ?");
		mysqli_stmt_bind_param($getId, 'ss', $temp['user'], $temp['pass']);
		mysqli_stmt_execute($getId);

		$result = mysqli_stmt_get_result($getId);

		while($row = mysqli_fetch_assoc($result)){
			$id = $row['UserID'];
		}

		/*Sanitizes the inputs from the form to prevent SQL Injection*/
		$first = mysqli_real_escape_string($link, $_POST['firstname']);
		$surname = mysqli_real_escape_string($link, $_POST['surname']);
		$dob = mysqli_real_escape_string($link, $_POST['DoB']);
		$email = mysqli_real_escape_string($link, $_POST['email']);
		$housenumber = mysqli_real_escape_string($link, $_POST['number']);
		$streetname = mysqli_real_escape_string($link, $_POST['street']);
		$city = mysqli_real_escape_string($link, $_POST['city']);
		$postcode = mysqli_real_escape_string($link, $_POST['postcode']);


		/*Updates the users Email Address with what was in the form */
		$updateLogin = mysqli_stmt_init($link);
		mysqli_stmt_prepare($updateLogin, 'UPDATE userlogin SET EmailAddress = ? where UserID =?');
		mysqli_stmt_bind_param($updateLogin, 'si', $email, $id);   
		mysqli_stmt_execute($updateLogin); 

		/*Updates userdetails table; Firstname, Surname & DoB of User with the specific UserID */
		$updateDetails = mysqli_stmt_init($link);
		mysqli_stmt_prepare($updateDetails, 'UPDATE userdetails SET Firstname=?, Surname=?, DateOfBirth=? where User =?');
		mysqli_stmt_bind_param($updateDetails, 'sssi', $first, $surname, $dob, $id);   
		mysqli_stmt_execute($updateDetails); 

		/*Updates useraddress table; HouseNumberName, StreetName, City & Postcode of User with the specific AddressID*/
		$updateAddress = mysqli_stmt_init($link);
		mysqli_stmt_prepare($updateAddress, 'UPDATE useraddress SET HouseNumberName=?, StreetName=?, City=?, PostCode=? where AddressID =?');
		mysqli_stmt_bind_param($updateAddress, 'ssssi', $housenumber, $streetname, $city, $postcode, $id);   
		mysqli_stmt_execute($updateAddress);


		header('Location: http://badapple/HTML/profile.php'); //Once complete redirects the browser to the profile page
	}
}

mysqli_close($link);
?>