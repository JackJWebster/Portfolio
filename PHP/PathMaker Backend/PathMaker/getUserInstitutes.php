<?php

include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");

$getInstitutes = mysqli_stmt_init($link);

mysqli_stmt_prepare($getInstitutes, "SELECT Title, unistatsinstitutes.Name, userlogin.UserName, userdetails.UCASPoints FROM unistatscourses
                                  INNER JOIN unistatsinstitutes ON unistatscourses.PUBUKPRN = unistatsinstitutes.PUBUKPRN
                                  INNER JOIN userlogin ON userlogin.UserName = ? and userlogin.Password = ?
                                  INNER JOIN userdetails ON userlogin.UserID = userdetails.User
                                  WHERE userdetails.UCASPoints >= unistatscourses.UCASTariff
                                  AND unistatscourses.UCASTariff != 0
                                  ");

mysqli_stmt_bind_param($getInstitutes, 'ss', $temp['user'], $temp['pass']); 
mysqli_stmt_execute($getInstitutes);

$result = mysqli_stmt_get_result($getInstitutes);
$count = 0;

while($row = mysqli_fetch_assoc($result)){
  $count = $count + 1;
}

mysqli_data_seek($result,0);

$institutearray = array();

if($count === 0) {

  $institutejsonstring = '[{"institute":"No Institutes Found"}]';
  echo $institutejsonstring;
  
}else{

while($row = mysqli_fetch_assoc($result)){
	$institutearray[] = array("institute" => $row["Name"]);
}
  echo json_encode($institutearray);
}

mysqli_close($link);

?>