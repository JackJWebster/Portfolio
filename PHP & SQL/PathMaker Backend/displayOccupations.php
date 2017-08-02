<?php

include "Core/connection.php";


$occupations = mysqli_stmt_init($link);
mysqli_stmt_prepare($occupations, "select OccupationName from occupations");
mysqli_stmt_execute($occupations);


$result = mysqli_stmt_get_result($occupations);

while($row = mysqli_fetch_assoc($result)){
	echo "<option value='".$row["OccupationName"]."'>".$row["OccupationName"]."</option>";

}




mysqli_close($link);
?>