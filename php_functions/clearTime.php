<?php
require_once "..". DIRECTORY_SEPARATOR ."config.php";
session_start();
if ($_GET['add']) {
    $user = $_SESSION["username"];

    $sql = "UPDATE users SET kommen='nix' WHERE username = '$user'";
    if ($link->query($sql) == TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $link->error;
    }
    $link->close();
}
