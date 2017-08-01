<?php

include "Core/connection.php";

if(isset($_POST['password'])){

	$password = mysqli_real_escape_string($link, $_POST['password']);

	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);

	if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
		echo json_encode(array('valid'=>false));
	}
	else
	{
		echo json_encode(array('valid'=>true));
	}
}


mysqli_close($link);
?>