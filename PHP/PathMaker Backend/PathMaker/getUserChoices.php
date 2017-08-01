<?php

include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");

$variable = "Engineering";
$variable = "%".$variable."%";


$getChoices = mysqli_stmt_init($link);

mysqli_stmt_prepare($getChoices, "SELECT Title, unistatsinstitutes.Name, userlogin.UserName, userdetails.UCASPoints FROM unistatscourses
                                  INNER JOIN unistatsinstitutes ON unistatscourses.PUBUKPRN = unistatsinstitutes.PUBUKPRN
                                  INNER JOIN userlogin ON userlogin.UserName = ? and userlogin.Password = ?
                                  INNER JOIN userdetails ON userlogin.UserID = userdetails.User
                                  WHERE userdetails.UCASPoints >= unistatscourses.UCASTariff
                                  AND unistatscourses.UCASTariff != 0
                                  AND Title LIKE ?
                                  "); 

mysqli_stmt_bind_param($getChoices, 'sss', $temp['user'], $temp['pass'], $variable); 
mysqli_stmt_execute($getChoices); 

$result = mysqli_stmt_get_result($getChoices);

	$choicearray = array();

while($row = mysqli_fetch_assoc($result)){
	$choicearray[] = array("institute" => $row["Name"], "coursetitle"=> $row["Title"]);
}

echo json_encode($choicearray);

mysqli_close($link);

?>