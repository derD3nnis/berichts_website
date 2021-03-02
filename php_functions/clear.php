<?php

if ($_GET['clear']){
    session_start();
    $user = $_SESSION["username"];
    echo $user;
}