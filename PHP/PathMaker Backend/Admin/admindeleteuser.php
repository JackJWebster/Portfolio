<?php

include "validAdmin.php";
include(dirname(__FILE__)."/../Core/connection.php");


if (isset($_POST['username']) && isset($_POST['userid']))
{

	$name = $_POST['username'];
	$id = $_POST['userid'];

	$checklevel = mysqli_stmt_init($link);
	mysqli_stmt_prepare($checklevel, "SELECT useraccess.AccessLevel FROM userlogin
		INNER JOIN useraccess on userlogin.AccessLevel = useraccess.AccessID
		WHERE UserName= ? AND UserID = ?");
	mysqli_stmt_bind_param($checklevel, 'si', $name, $id);
	mysqli_stmt_execute($checklevel);

	$result = mysqli_stmt_get_result($checklevel);

	$row = mysqli_fetch_assoc($result);
	$level = $row["AccessLevel"];



	if ((strcmp($name, $temp['user']) != 0) && $level == 0 )
	{
		$admindelete = mysqli_stmt_init($link);
		mysqli_stmt_prepare($admindelete, "DELETE userlogin FROM userlogin WHERE UserName= ? AND UserID = ?");
		mysqli_stmt_bind_param($admindelete, 'si', $name, $id);
		mysqli_stmt_execute($admindelete);
		// echo "User Deleted";
	}

}

mysqli_close($link);
?>
