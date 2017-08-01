<?php

include "Core/connection.php";

$url = "//Project/html/tester.php";

if (!empty($_POST['username']) && !empty($_POST['pass1']) && isset($_POST['pass2']) && isset($_POST['firstname']) && !empty($_POST['surname']) && !empty($_POST['DoB'])  && !empty(['email1']) && !empty(['email2']) ) {
	

	$user = $_POST['username'];
	$pass =  $_POST['pass1'];
	$pass2 =  $_POST['pass2'];
	$first =  $_POST['firstname'];
	$surname = $_POST['surname'];
	$occupation =  $_POST['occupation'];
	$dob =  $_POST['DoB'];
	$email =  $_POST['email1'];
	$confemail =  $_POST['email2'];
	$number =  $_POST['number'];
	$street =  $_POST['street'];
	$postcode =  $_POST['postcode'];
	$city =  $_POST['city'];
	$accessname = "user";


	$checkusername = mysqli_stmt_init($link);
	mysqli_stmt_prepare($checkusername, 'Select count(*) from userlogin where UserName= ? ');
	mysqli_stmt_bind_param($checkusername, 's', $user);   
	mysqli_stmt_execute($checkusername); 

	$result = mysqli_stmt_get_result($checkusername);
	$count = $result -> fetch_row();

	if ($count[0] == 0) {

		if (strcmp($pass, $pass2) == 0){
			$uppercase = preg_match('@[A-Z]@', $pass);
			$lowercase = preg_match('@[a-z]@', $pass);
			$numbercheck    = preg_match('@[0-9]@', $pass);
			if($uppercase || $lowercase || $numbercheck || strlen($password) >= 8) {

				if(strcmp($email, $confemail) == 0){




					$getOccupationId = mysqli_stmt_init($link);
					mysqli_stmt_prepare($getOccupationId, 'Select OccupationID from occupations where OccupationName= ? ');
					mysqli_stmt_bind_param($getOccupationId, 's', $occupation);   
					mysqli_stmt_execute($getOccupationId); 
					$result = mysqli_stmt_get_result($getOccupationId);
					$occupationresult = $result -> fetch_row();
					$occupation = $occupationresult[0];

				// echo $occupationresult[0];

					$getAccessID = mysqli_stmt_init($link);
					mysqli_stmt_prepare($getAccessID, 'Select AccessID from useraccess where AccessName= ? ');
					mysqli_stmt_bind_param($getAccessID, 's', $accessname);   
					mysqli_stmt_execute($getAccessID); 
					$result = mysqli_stmt_get_result($getAccessID);
					$accessresult = $result -> fetch_row();
					$access = $accessresult[0];

					$date = date('Y-m-d');
					$cryptpass = crypt($pass,"Ba24JDAkfjerio892pp309lE");

					$newlogin = mysqli_stmt_init($link);
					mysqli_stmt_prepare($newlogin, 'INSERT INTO userlogin (Username, Password, DateJoined, EmailAddress, AccessLevel ) VALUES (?, ?, ?, ?, ?)');
					mysqli_stmt_bind_param($newlogin, 'ssssi', $user, $cryptpass, $date, $email, $access);   
					$successful = mysqli_stmt_execute($newlogin);


					$user_id = mysqli_insert_id($link);
					echo $user_id;
					echo $successful;
					if ($successful && $user_id != 0)
					{
						$newuserinfo = mysqli_stmt_init($link);
						mysqli_stmt_prepare($newuserinfo, 'INSERT INTO userdetails (User, FirstName, Surname, DateOfBirth, Occupation) VALUES (?, ?, ?, ?, ?)');
						mysqli_stmt_bind_param($newuserinfo, 'isssi', $user_id, $first, $surname, $dob, $occupation);   
						$addresssuccessful = mysqli_stmt_execute($newuserinfo);

						$address_id = mysqli_insert_id($link);
						echo " ".$address_id;
						echo $addresssuccessful;
						echo "Occupation number".$occupation;

						if($addresssuccessful & $address_id != 0)
						{
							$newaddress = mysqli_stmt_init($link);
							mysqli_stmt_prepare($newaddress, 'INSERT INTO useraddress (AddressID, HouseNumberName, StreetName, PostCode , City) VALUES (?, ?, ?, ?, ?)');
							mysqli_stmt_bind_param($newaddress, 'issss', $address_id, $number, $street, $postcode, $city);   
							$successful = mysqli_stmt_execute($newaddress);

							if($successful)
								header('Location: ../../HTML/login.php');
							else
								echo "Failed to insert address";
						}
						else
						{
							echo "address unsuccessful";
							deleteuser($link, $user_id);
						}
					}
					else
					{
						echo "details unsuccessful";
						deleteuser($link, $user_id);
					}
				}
				else
				{
					header('Location: ../../HTML/register.php');
				}
			}
			else
			{
				header('Location: ../../HTML/register.php');
			}
		}
	}
	else
	{
		echo "User already exists";
	}
}
else
{
	header('Location: ../../HTML/register.php');
}


function deleteuser($link, $deleteid){

	$delete = mysqli_stmt_init($link);
	mysqli_stmt_prepare($delete, "delete userlogin from userlogin where UserId = ?");
	mysqli_stmt_bind_param($delete, 'i', $deleteid);
	mysqli_stmt_execute($delete);
	mysqli_close($link);

	header('Location: ../../HTML/register.php');

}

mysqli_close($link);
?>