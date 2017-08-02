<?php 

// Converts an SQL database containing movie information into a custom JSON format for importing into MongoDB

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username="jw242";
$password="abcjw242354";
$database="movielens";
$server = "mysql-server-1";

    $connect = mysqli_connect($server, $username, $password, $database) 
    or die("Error " . mysqli_error($connection));
   
    if (mysqli_set_charset($connect, "UTF8")) {
        mysqli_character_set_name($connect);
    }
    
    set_time_limit(0);

    $p1 = '../Documents/MongoImport1.json';
    $p2 = '../Documents/MongoImport2.json';
   
    $query11 = "SELECT `id` FROM `genres`";
    $result11=mysqli_query($connect, $query11)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows11 = array();
    
    if ($result11 = $connect->query($query11)) {
    
    while ($row11=$result11->fetch_array(MYSQL_ASSOC)) 
    {
        $rows11[] = $row11["id"];
    }
}

    $query12 = "SELECT `genre` FROM `genres`";
    $result12=mysqli_query($connect, $query12)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows12 = array();
    
    if ($result12 = $connect->query($query12)) {
    
    while ($row12=$result12->fetch_array(MYSQL_ASSOC)) 
    {
        $rows12[] = $row12["genre"];
    }
}

$result11->close();
$result12->close();

    $query21 = "SELECT `id` FROM `movies`";
    $result21=mysqli_query($connect, $query21)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows21 = array();
    
    if ($result21 = $connect->query($query21)) {
    
    while ($row21=$result21->fetch_array(MYSQL_ASSOC)) 
    {
        $rows21[] = $row21["id"];
    }
}

    $query22 = "SELECT `title` FROM `movies`";
    $result22=mysqli_query($connect, $query22)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows22 = array();
    
    if ($result22 = $connect->query($query22)) {
    
    while ($row22=$result22->fetch_array(MYSQL_ASSOC)) 
    {
        $rows22[] = $row22["title"];
    }
}

    $query23 = "SELECT `release_date` FROM `movies`";
    $result23=mysqli_query($connect, $query23)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows23 = array();
    
    if ($result23 = $connect->query($query23)) {
    
    while ($row23=$result23->fetch_array(MYSQL_ASSOC)) 
    {
        $rows23[] = $row23["release_date"];
    }
}

    $query24 = "SELECT `video` FROM `movies`";
    $result24=mysqli_query($connect, $query24)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows24 = array();
    
    if ($result24 = $connect->query($query24)) {
    
    while ($row24=$result24->fetch_array(MYSQL_ASSOC)) 
    {
        $rows24[] = $row24["video"];
    }
}

    $query25 = "SELECT `IMDBURL` FROM `movies`";
    $result25=mysqli_query($connect, $query25)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows25 = array();
    
    if ($result25 = $connect->query($query25)) {
    
    while ($row25=$result25->fetch_array(MYSQL_ASSOC)) 
    {
        $rows25[] = $row25["IMDBURL"];
    }
}

    

$result21->close();
$result22->close();
$result23->close();
$result24->close();
$result25->close();

$query31 = "SELECT `movie` FROM `movie_genres`";
    $result31=mysqli_query($connect, $query31)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows31 = array();
    
    if ($result31 = $connect->query($query31)) {
    
    while ($row31=$result31->fetch_array(MYSQL_ASSOC)) 
    {
        $rows31[] = $row31["movie"];
    }
}

    $query32 = "SELECT `genre` FROM `movie_genres`";
    $result32=mysqli_query($connect, $query32)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows32 = array();
    
    if ($result32 = $connect->query($query32)) {
    
    while ($row32=$result32->fetch_array(MYSQL_ASSOC)) 
    {
        $rows32[] = $row32["genre"];
    }
}

$result31->close();
$result32->close();;

    $query41 = "SELECT `user` FROM `ratings`";
    $result41=mysqli_query($connect, $query41)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows41 = array();
    
    if ($result41 = $connect->query($query41)) {
    
    while ($row41=$result41->fetch_array(MYSQL_ASSOC)) 
    {
        $rows41[] = $row41["user"];
    }
}

    $query42 = "SELECT `movie` FROM `ratings`";
    $result42=mysqli_query($connect, $query42)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows42 = array();
    
    if ($result42 = $connect->query($query42)) {
    
    while ($row42=$result42->fetch_array(MYSQL_ASSOC)) 
    {
        $rows42[] = $row42["movie"];
    }
}

    $query43 = "SELECT `rating` FROM `ratings`";
    $result43=mysqli_query($connect, $query43)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows43 = array();
    
    if ($result43 = $connect->query($query43)) {
    
    while ($row43=$result43->fetch_array(MYSQL_ASSOC)) 
    {
        $rows43[] = $row43["rating"];
    }
}

    $query44 = "SELECT `timestamp` FROM `ratings`";
    $result44=mysqli_query($connect, $query44)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows44 = array();
    
    if ($result44 = $connect->query($query44)) {
    
    while ($row44=$result44->fetch_array(MYSQL_ASSOC)) 
    {
        $rows44[] = $row44["timestamp"];
    }
}

$result41->close();
$result42->close();
$result43->close();
$result44->close();

    $query51 = "SELECT `id` FROM `users`";
    $result51=mysqli_query($connect, $query51)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows51 = array();
    
    if ($result51 = $connect->query($query51)) {
    
    while ($row51=$result51->fetch_array(MYSQL_ASSOC)) 
    {
        $rows51[] = $row51["id"];
    }
}

    $query52 = "SELECT `age` FROM `users`";
    $result52=mysqli_query($connect, $query52)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows52 = array();
    
    if ($result52 = $connect->query($query52)) {
    
    while ($row52=$result52->fetch_array(MYSQL_ASSOC)) 
    {
        $rows52[] = $row52["age"];
    }
}

    $query53 = "SELECT `gender` FROM `users`";
    $result53=mysqli_query($connect, $query53)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows53 = array();
    
    if ($result53 = $connect->query($query53)) {
    
    while ($row53=$result53->fetch_array(MYSQL_ASSOC)) 
    {
        $rows53[] = $row53["gender"];
    }
}

    $query54 = "SELECT `occupation` FROM `users`";
    $result54=mysqli_query($connect, $query54)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows54 = array();
    
    if ($result54 = $connect->query($query54)) {
    
    while ($row54=$result54->fetch_array(MYSQL_ASSOC)) 
    {
        $rows54[] = $row54["occupation"];
    }
}

    $query55 = "SELECT `zip_code` FROM `users`";
    $result55=mysqli_query($connect, $query55)
    or die("Error in Selecting " . mysqli_error($connect));
    
        $rows55 = array();
    
    if ($result55 = $connect->query($query55)) {
    
    while ($row55=$result55->fetch_array(MYSQL_ASSOC)) 
    {
        $rows55[] = $row55["zip_code"];
    }
}

$result51->close();
$result52->close();
$result53->close();
$result54->close();
$result55->close();

$connect->close();

print "Begin writing to files... <br>";
    
$f1 = fopen($p1, "w");
print "Writing to MongoImport1.json <br>";

    for ($x = 0; $x < sizeOf($rows21); $x++){
        $genres = array();
        $ratings1 = array();
        $ratings2 = array();
        $ratings3 = array();
        
        fwrite( $f1,'{id: "');
        fwrite( $f1, $rows21[$x]);
        fwrite( $f1, '", title: "');
        fwrite( $f1, $rows22[$x]);
        fwrite( $f1, '", release_date: "');
        fwrite( $f1, $rows23[$x]);
        fwrite( $f1, '", genre: [');
        for ($y = 0; $y < sizeOf($rows31); $y++) {
            if ($rows31[$y] == $rows21[$x]) {
                for ($z = 0; $z < sizeOf($rows11); $z++) {
                    if ($rows11[$z] == $rows32[$y]) {
                        $genres[] = $rows12[$z];
                    }
                }
            }
        }
        for ($y = 0; $y < sizeOf($genres); $y++) {
            fwrite( $f1, '"');
            fwrite( $f1, $genres[$y]);
            fwrite( $f1, '"');
            if (next($genres)) {
                fwrite( $f1, ', ');
            }
        }
        fwrite( $f1, '], video: "');
        fwrite( $f1, $rows24[$x]);
        fwrite( $f1, '", IMDBURL: "');
        fwrite( $f1, $rows25[$x]);
        fwrite( $f1, '", ratings: [');
        for ($y = 0; $y < sizeOf($rows42); $y++){
            if ($rows21[$x] == $rows42[$y]){
                $ratings1[] = $rows41[$y];
                $ratings2[] = $rows43[$y];
                $ratings3[] = $rows44[$y];
            }
        }
        for ($y = 0; $y < sizeOf($ratings1); $y++) {
            fwrite( $f1,'{user: "');
                fwrite( $f1, $ratings1[$y]);
                fwrite( $f1, '", rating: "');
                fwrite( $f1, $ratings2[$y]);
                fwrite( $f1, '", timestamp: "');
                fwrite( $f1, $ratings3[$y]);
                fwrite( $f1, '"}');
            if (next($ratings1)) {
                fwrite( $f1, ', ');
            }
        }
        fwrite( $f1, ']}');
    }

    fclose($f1);

    print "Writing Complete! <br>";

    $f2 = fopen($p2, "w");

    print "Writing to MongoImport2 <br>";

    for ($x = 0; $x < sizeOf($rows51); $x++){
        fwrite( $f2,'{id: "');
        fwrite( $f2, $rows51[$x]);
        fwrite( $f2, '", age: "');
        fwrite( $f2, $rows52[$x]);
        fwrite( $f2, '", gender: "');
        fwrite( $f2, $rows53[$x]);
        fwrite( $f2, '", occupation: "');
        fwrite( $f2, $rows54[$x]);
        fwrite( $f2, '", zip_code: "');
        fwrite( $f2, $rows55[$x]);
        fwrite( $f2, '"}');
    }

    fclose($f2);

    print "Writing Complete! <br>";
    ?>
