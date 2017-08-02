<?php

include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");

$checkAdmin = mysqli_stmt_init($link);

mysqli_stmt_prepare($checkAdmin, "SELECT useraccess.AccessLevel FROM userlogin 
	INNER JOIN useraccess ON userlogin.AccessLevel = useraccess.AccessID
	where userlogin.UserName= ? and userlogin.Password = ? ");  
mysqli_stmt_bind_param($checkAdmin, 'ss', $temp['user'], $temp['pass']);
mysqli_stmt_execute($checkAdmin); 

$result = mysqli_stmt_get_result($checkAdmin);

$access = mysqli_fetch_assoc($result);

if($access['AccessLevel'] > 0 )
	echo '<li class="nav-item"><a href="admin/admin.php" class="littlestuff-hover"> Admin Section </a></li>';



mysqli_close($link);

?>