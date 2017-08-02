<?php

include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");

$getEmployment = mysqli_stmt_init($link);

mysqli_stmt_prepare($getEmployment, "SELECT StartMonth.MonthName StartMonth, useremployment.StartYear, EndMonth.MonthName EndMonth, useremployment.EndYear, useremployment.Employer, useremployment.JobTitle FROM useremployment 
	INNER JOIN userlogin ON useremployment.UserID = userlogin.UserID
    INNER JOIN months StartMonth ON useremployment.StartMonth = StartMonth.MonthID
    INNER JOIN months EndMonth ON useremployment.EndMonth = EndMonth.MonthID
	where userlogin.UserName= ? and userlogin.Password = ? ORDER BY Employer");
mysqli_stmt_bind_param($getEmployment, 'ss', $temp['user'], $temp['pass']);   
mysqli_stmt_execute($getEmployment); 


$result = mysqli_stmt_get_result($getEmployment);

	$employmentarray = array();

while($row = mysqli_fetch_assoc($result)){
	$employmentarray[] = array("employer"=> $row["Employer"], "jobtitle"=> $row["JobTitle"], "startmonth"=> $row["StartMonth"], "startyear"=> $row["StartYear"], "endmonth"=> $row["EndMonth"], "endyear"=> $row["EndYear"]);
}

echo json_encode($employmentarray);

mysqli_close($link);

?>