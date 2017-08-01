<?php

include(dirname(__FILE__)."/../Core/connection.php");

$getCourses = mysqli_stmt_init($link);

mysqli_stmt_prepare($getCourses, "SELECT Course FROM courses");  
mysqli_stmt_execute($getCourses); 


$result = mysqli_stmt_get_result($getCourses);

while($row = mysqli_fetch_assoc($result)){
	echo "<option name='".$row["Course"]."'>".$row["Course"]."</option>";

}

mysqli_close($link);
?>