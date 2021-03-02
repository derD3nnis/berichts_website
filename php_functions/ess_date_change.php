<?php
require_once "..". DIRECTORY_SEPARATOR ."config.php";
session_start();
if ($_GET['add']) {
    $user = $_SESSION["username"];
    $date = $_GET['date'];

    $isFound = false;


    $sql = "SELECT * FROM arbeitszeiten WHERE date = '$date' AND user = '$user'";
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()){
            echo $row["home1_starttime"];
            echo "$";
            echo $row["home1_traveltime"];
            echo "$";
            echo $row["work_starttime"];
            echo "$";
            echo $row["work_endtime"];
            echo "$";
            echo $row["work_traveltime"];
            echo "$";
            echo $row["home2_end"];
            echo "$";
            echo $row["ess_startkm"];
            echo "$";
            echo $row["ess_endkm"];
            echo "$";
            echo $row["ess_kontakt"];
            echo "$";
            echo $row["ess_orte"];
            echo "$";
            echo $row["ess_taten"];

        }
    } else {
        echo "No entry";
    }
    $link->close();



}