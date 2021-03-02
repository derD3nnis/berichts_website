<?php
require_once "..". DIRECTORY_SEPARATOR ."config.php";
if ($_GET['add']){
    session_start();
    $username = $_SESSION["username"];
    $vorname = $_GET['vorname'];
    $nachname = $_GET['nachname'];
    $gerade = $_GET['gerade'];
    $ungerade = $_GET['ungerade'];
    $wegZurArbeit = $_GET["defaultWorkWay"];

    $sql = "UPDATE users SET vorname = '$vorname', nachname = '$nachname', geradeWochen = '$gerade', ungeradeWochen = '$ungerade', wegZurArbeit = '$wegZurArbeit' WHERE username = '$username'";
    if ($link->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $link->error;
    }
    $link->close();
}


