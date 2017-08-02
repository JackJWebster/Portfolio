<?php

include "validAdmin.php";
include(dirname(__FILE__)."/../Core/connection.php");

if($verified){

	$userid = $_GET['userid'];

	$checkadminlevel = mysqli_stmt_init($link);
	mysqli_stmt_prepare($checkadminlevel, "SELECT useraccess.AccessLevel FROM userlogin
		INNER JOIN useraccess on userlogin.AccessLevel = useraccess.AccessID
		WHERE UserName= ? AND Password = ?");
	mysqli_stmt_bind_param($checkadminlevel, 'ss', $temp['user'], $temp['pass']);
	mysqli_stmt_execute($checkadminlevel);

	$result = mysqli_stmt_get_result($checkadminlevel);

	$row = mysqli_fetch_assoc($result);
	$adminlevel = $row["AccessLevel"];


	if ($adminlevel >= 20)
	{

		$checkuserlevel = mysqli_stmt_init($link);
		mysqli_stmt_prepare($checkuserlevel, "SELECT useraccess.AccessLevel FROM userlogin
			INNER JOIN useraccess on userlogin.AccessLevel = useraccess.AccessID
			WHERE UserID = ?");
		mysqli_stmt_bind_param($checkuserlevel, 'i',$userid);
		mysqli_stmt_execute($checkuserlevel);
		$result = mysqli_stmt_get_result($checkuserlevel);

		$row = mysqli_fetch_assoc($result);
		$userlevel = $row["AccessLevel"];

		$width = 3;
		$offset = 1;

		if($userlevel < 10)
		{
			$levelset = "<div class='col-sm-".$width." col-sm-offset-".$offset."'> 
			<button class='btn-warning btn-lg' onclick='accesschange('admin')'>Make Admin</button>
			</div>";
		}
		else
		{
			$levelset = "<div class='col-sm-".$width." col-sm-offset-".$offset."'> 
			<button class='btn-warning btn-lg' onclick='accesschange('user')'>Make User</button>
			</div>";
		}

	}
	else
	{
		$levelset = "";
		$width = 5;
		$offset = 1;
	}



	$userControls = mysqli_stmt_init($link);
	mysqli_stmt_prepare($userControls, "SELECT * 
		FROM userlogin INNER JOIN userdetails ON userlogin.UserID = userdetails.User
		INNER JOIN useraddress ON userdetails.Address = useraddress.AddressID
		INNER JOIN useraccess ON userlogin.AccessLevel = useraccess.AccessID
		WHERE userlogin.UserID = ? ");
	mysqli_stmt_bind_param($userControls, 'i', $userid);   
	mysqli_stmt_execute($userControls); 

	$result = mysqli_stmt_get_result($userControls);
	

	$user = mysqli_fetch_assoc($result);
	if(!empty($user))
	{
		echo "<ul><li class='list-group-item text-right'><span class='pull-left'><strong>User ID</strong></span> <div id='userid'>".$user["UserID"]."</div></li>
		<li class='list-group-item text-right'><span class='pull-left'><strong>Username</strong></span> <div id='username'>".$user["UserName"]."</div></li>
		<li class='list-group-item text-right'><span class='pull-left'><strong>Firstname</strong></span> <div id='joined'>".$user["FirstName"]."</div></li>
		<li class='list-group-item text-right'><span class='pull-left'><strong>Surname</strong></span> <div id='joined'>".$user["Surname"]."</div></li>
		<li class='list-group-item text-right'><span class='pull-left'><strong>Email</strong></span> <div id='joined'>".$user["EmailAddress"]."</div></li>
		<li class='list-group-item text-right'><span class='pull-left'><strong>User Access</strong></span> <div id='joined'>".$user["AccessName"]."</div></li>
		<li class='list-group-item text-right'><span class='pull-left'><strong>Joined</strong></span> <div id='joined'>".$user["DateJoined"]."</div></li>
		</ul>";

		echo "<div style='padding-top: 20px' class='col-sm-10'>
		<div class='col-sm-".$width." col-sm-offset-".$offset."'>
		<button class='btn-primary btn-lg'>Reset Password</button>
		</div>
		<div class ='col-sm-".$width." col-sm-offset-".$offset."'> 
		<button class='btn-warning btn-lg' onclick='deleteUser()'>Delete Account</button>
		</div>".$levelset."
		</div>";
	}


}
mysqli_close($link);
?>