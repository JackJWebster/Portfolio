<?php

include(dirname(__FILE__)."/../Core/connection.php");
include(dirname(__FILE__)."/../Core/validCookie.php");

$getInstitutes = mysqli_stmt_init($link);

$testInsts = ["University Of Abertay Dundee", "Edinburgh Napier University", "University Of The Highlands And Islands", "Scotland's Rural College", "University Of The West Of Scotland"];

$testPrefs = ["Engineering","Accountancy","Sport"];

$checkedInsts = array();
$checkedPrefs = array();
//$_GET['checkInst']
foreach($testInsts as $checkInst){
    $checkedInsts[] = $checkInst;
}

$checkedPref = array();
//$_GET['checkPref']
foreach($testPrefs as $checkPref){
    $checkedPrefs[] = $checkPref;
}

//print_r($checkedPrefs)

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
  
  if (in_array($row["Name"], $checkedInsts)){ 
    
    $institutearray[] = array("institute" => $row["Name"], "coursetitle" => $row['Title']);
    } else{}
  }
}

$prefCourses = array();
$longcourselist = array();

foreach($checkedPrefs as $pref){
  
  foreach($institutearray as $course){ 

      if (strpos($course['coursetitle'], $pref) !== false && !(in_array($course['coursetitle'], $longcourselist))) {
        
        $longcourselist[] = $course['coursetitle'];
        $prefCourses[] = array("institute" => $course["institute"], "preference" => $pref, "coursetitle" => $course["coursetitle"]);
      }
  }
}

echo json_encode($prefCourses);

mysqli_close($link);

?>