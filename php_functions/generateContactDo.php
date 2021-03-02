<?php
require_once "..". DIRECTORY_SEPARATOR ."config.php";
session_start();
if ($_GET['add']) {
    $user = $_SESSION["username"];
    $list = array();
    $rowValue = array();



    $sql = "SELECT * FROM arbeitszeiten WHERE user = '$user'";
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()){

            $rowValue = array ($row["date"], $row["ess_kontakt"] ,$row["ess_taten"]);

            array_push($list, $rowValue);

        }
    } else {
        echo "No entry";
    }
    $link->close();



    $file = fopen("..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$user . DIRECTORY_SEPARATOR . "kontakte.csv","w");
    foreach ($list as $fields) {
        fputcsv($file, $fields);
    }
    fclose($file);



}