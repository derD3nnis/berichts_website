<?php
require_once "..". DIRECTORY_SEPARATOR ."config.php";
session_start();
if ($_GET['clear']) {
    $user = $_SESSION["username"];
    $sql = "SELECT kommen FROM users WHERE username = '$user'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo $row["kommen"];
        }
    } else {
        echo $user . " Not available!";
    }
    $link->close();
}

