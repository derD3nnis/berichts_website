<?php
if ($_GET['get']){

    $user = $_GET['user'];
    $folder = ".." .DIRECTORY_SEPARATOR ."users". DIRECTORY_SEPARATOR .$user . DIRECTORY_SEPARATOR . "berichte";
    $files = scandir($folder,1);
    $files = array_diff($files, array('.', '..'));
    $json = json_encode($files);
    echo $json;

}