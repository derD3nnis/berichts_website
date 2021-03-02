<?php
if ($_GET['add']){
    $year = $_GET['year'];
    session_start();
    $username = $_SESSION["username"];
    $files = scandir("..". DIRECTORY_SEPARATOR. "users". DIRECTORY_SEPARATOR .$_SESSION["username"] . DIRECTORY_SEPARATOR . "berichte" . DIRECTORY_SEPARATOR . $year);
    unset($files[0]);
    unset($files[1]);
    echo implode(",", $files);
}