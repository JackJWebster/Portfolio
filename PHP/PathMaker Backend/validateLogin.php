<?php

include "Core/connection.php";

if(isset($_POST['username']) && isset($_POST['password']) ){

	$user = mysqli_real_escape_string($link, $_POST['username']);
	$pass = mysqli_real_escape_string($link, $_POST['password']);

		$encrypt_pass = crypt($pass,"Ba24JDAkfjerio892pp309lE"); //Encrypts pass and stores it as another variable 

		$checkLogin = mysqli_stmt_init($link);
	mysqli_stmt_prepare($checkLogin, "select count(*) from userlogin where UserName= ? and Password = ?");	//Counts how many users exist with the password and username in the cookie
	mysqli_stmt_bind_param($checkLogin, 'ss', $user, $encrypt_pass);
	mysqli_stmt_execute($checkLogin);

	$result = mysqli_stmt_get_result($checkLogin);
	$count = $result -> fetch_row();

	if ($count[0] == 1) {
		echo json_encode(array("valid"=>true));
	}
	else
	{
		echo json_encode(array("valid"=>false));
	}

}


mysqli_close($link);
?>