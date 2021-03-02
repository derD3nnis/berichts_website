<?php
require_once "..". DIRECTORY_SEPARATOR ."config.php";
session_start();
if ($_GET['add']) {
    $user = $_SESSION["username"];
    $time = $_GET["time"];
    $come= "Error";


    $sql = "SELECT kommen FROM users WHERE username = '$user'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $come = $row["kommen"];
        }
    } else {
        $come= "Error";
    }
    mysqli_close($link);


    $list = array (
        array("[" . date("Y/m/d") . "]", $come ,$time)
    );

    $file = fopen("..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$user . DIRECTORY_SEPARATOR . "zeiten.csv","a");
    foreach ($list as $line) {
        fputcsv($file, $line);
    }
    fclose($file);


    $sql = "UPDATE users SET kommen='nix' WHERE username = '$user'";
    if ($link->query($sql) == TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $link->error;
    }
    $link->close();
}