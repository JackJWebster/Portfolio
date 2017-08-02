<?php

include "Core/connection.php";
include 'Core/validCookie.php';

if (!empty($_POST['employer']) && !empty($_POST['title']) && isset($_POST['startmonth']) && isset($_POST['endmonth']) && !empty($_POST['startyear']) && !empty($_POST['endyear'])  && !empty(['description'])) {

	$employer = mysqli_real_escape_string($link, $_POST['employer']);
	$title = mysqli_real_escape_string($link, $_POST['title']);
	$startmonth = mysqli_real_escape_string($link, $_POST['startmonth']);
	$startyear = mysqli_real_escape_string($link, $_POST['startyear']);
	$endmonth = mysqli_real_escape_string($link, $_POST['endmonth']);
	$endyear = mysqli_real_escape_string($link, $_POST['endyear']);
	$description = mysqli_real_escape_string($link, $_POST['description']);
	$curyear = date("Y");
	$curmonth = date("M");

	if ((($startyear <= $endyear && $startyear > 1970) && $startyear <= $curyear) && !($startmonth > $curmonth && $startyear === $curyear)){


			$newjob = mysqli_stmt_init($link);
			mysqli_stmt_prepare($newjob, 'INSERT INTO useremployment (UserID, StartMonth, StartYear, EndMonth, EndYear, Employer, JobTitle, JobDescription ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
			mysqli_stmt_bind_param($newjob, 'siiiisss', $user[1], $startmonth, $startyear, $endmonth, $endyear, $employer, $title, $description);   
			mysqli_stmt_execute($newjob);
		
	}
}


?>