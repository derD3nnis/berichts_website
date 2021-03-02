<?php
require_once "..". DIRECTORY_SEPARATOR ."config.php";
session_start();
if ($_GET['add']) {
    $user = $_SESSION["username"];
    $date = $_GET['date'];
    $home1_starttime = $_GET['home1_starttime'];
    $home1_traveltime = $_GET['home1_traveltime'];
    $work_starttime = $_GET['work_starttime'];
    $work_endtime = $_GET['work_endtime'];
    $work_traveltime = $_GET['work_traveltime'];
    $home2_end = $_GET['home2_end'];

    $ess_startkm = $_GET['ess_startkm'];
    $ess_endkm = $_GET['ess_endkm'];
    $ess_kontakt = $_GET['ess_kontakte'];
    $ess_orte = $_GET['ess_orte'];
    $ess_taten = $_GET['ess_taten'];

    $isFound = false;


    $sql = "SELECT id FROM arbeitszeiten WHERE date = '$date' AND user = '$user'";
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);

            if(mysqli_stmt_num_rows($stmt) == 1){
                $isFound = true;
            } else{
                $isFound = false;
            }
        } else{
            echo "Da lief etwas schief. Versuch es später erneut 1.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    if(!$isFound){
        $sql = "INSERT INTO arbeitszeiten (user, date, home1_starttime, home1_traveltime, work_starttime, work_endtime, work_traveltime, home2_end, ess_startkm, ess_endkm, ess_kontakt, ess_orte, ess_taten) VALUES ('$user', '$date', '$home1_starttime', '$home1_traveltime', '$work_starttime', '$work_endtime', '$work_traveltime', '$home2_end', '$ess_startkm', '$ess_endkm', '$ess_kontakt', '$ess_orte', '$ess_taten')";
        if ($link->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $link->error;
        }
        $link->close();
    } else{
        echo "There is already an entry";
        $sql = "UPDATE arbeitszeiten SET home1_starttime = '$home1_starttime', home1_traveltime = '$home1_traveltime', work_starttime = '$work_starttime', work_endtime = '$work_endtime', work_traveltime = '$work_traveltime', home2_end = '$home2_end', ess_startkm = '$ess_startkm', ess_endkm = '$ess_endkm', ess_kontakt = '$ess_kontakt', ess_orte = '$ess_orte', ess_taten = '$ess_taten' WHERE date = '$date' AND user = '$user'";
        if ($link->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $link->error;
        }
        $link->close();
    }

}