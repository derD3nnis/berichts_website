<?php
require_once "..". DIRECTORY_SEPARATOR ."config.php";
if ($_GET['add']){
    session_start();
    $username = $_SESSION["username"];


    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()){
            echo $row["vorname"];
            echo "$";
            echo $row["nachname"];
            echo "$";
            echo $row["geradeWochen"];
            echo "$";
            echo $row["ungeradeWochen"];
            echo "$";
            echo $row["wegZurArbeit"];

        }
    } else {
        echo "No entry";
    }
    $link->close();
}
