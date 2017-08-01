<?php
$checkedInsts = array();
$checkedPrefs = array();
//$_GET['checkInst']
foreach($_GET['instChoice'] as $checkInst){
    $checkedInsts[] = $checkInst;
}
print_r($checkedInsts);
    
    
$checkedPref = array();
//$_GET['checkPref']
foreach($_GET['courseChoice'] as $checkPref){
    $checkedPrefs[] = $checkPref;
}
print_r($checkedPrefs);
?>
