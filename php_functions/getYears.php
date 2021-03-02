<?php
if ($_GET['add']){
    session_start();
    $username = $_SESSION["username"];
    $files = scandir("..". DIRECTORY_SEPARATOR. "users". DIRECTORY_SEPARATOR .$_SESSION["username"] . DIRECTORY_SEPARATOR . "berichte");
    unset($files[0]);
    unset($files[1]);
    echo implode(",", $files);
}
