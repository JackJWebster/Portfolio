<?php

include "validAdmin.php";
# Use the Curl extension to query Google and get back a page of results
$url = "http://www.sqa.org.uk/pastpapers/findpastpaper.htm";
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$html = curl_exec($ch);
curl_close($ch);

# Create a DOM parser object
$dom = new DOMDocument();

# Parse the HTML from Google.
# The @ before the method call suppresses any warnings that
# loadHTML might throw because of invalid HTML in the page.
@$dom->loadHTML($html);

# Iterate over all the <option> tags
$count=0;
$subjects = array();

foreach($dom->getElementsByTagName('option') as $link) {

	$subject = $link->getAttribute('value');

	if (empty($subject)){
		$count = $count +  1;
	}
	else
	{
		$subjects[] = $subject;
	}

	if($count == 2)
		break;
}


include(dirname(__FILE__)."/../Core/connection.php");

for ($i = 0; $i < count($subjects); ++$i) {
	
	$arraysubject = $subjects[$i];
	
	$checkCourse = mysqli_stmt_init($link);
	mysqli_stmt_prepare($checkCourse, "select count(*) FROM courses WHERE Course= ?");
	mysqli_stmt_bind_param($checkCourse, 's', $arraysubject);
	mysqli_stmt_execute($checkCourse);

	$result = mysqli_stmt_get_result($checkCourse);
	$count = $result -> fetch_row();
	
	if ($count[0] == 0) {
		$addCourse = mysqli_stmt_init($link);
		mysqli_stmt_prepare($addCourse, 'INSERT INTO courses (Course) VALUES (?)');
		mysqli_stmt_bind_param($addCourse, 's', $arraysubject);   
		mysqli_stmt_execute($addCourse);
	}

}


mysqli_close($link);
?>