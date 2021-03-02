<?php
session_start();
if ($_GET['generate']){
    $user = $_SESSION["username"];
    $name = $_GET['name'];
    $start = $_GET['start'];
    $end = $_GET['end'];
    $year = $_GET['year'];
    $vorlage = "Vorlage.pdf";
    $csvFileName = 'sample.csv';
    if(file_exists(".." .DIRECTORY_SEPARATOR ."users". DIRECTORY_SEPARATOR . $_SESSION["username"] . DIRECTORY_SEPARATOR . "berichte")){
        echo "Dir Exists";
    }
    else{
        mkdir(".." .DIRECTORY_SEPARATOR ."users". DIRECTORY_SEPARATOR . $_SESSION["username"] . DIRECTORY_SEPARATOR . "berichte");
        echo "dir Created";
    }
    $target = ".." .DIRECTORY_SEPARATOR ."users". DIRECTORY_SEPARATOR . $_SESSION["username"] . DIRECTORY_SEPARATOR . "berichte" . DIRECTORY_SEPARATOR;
    $cmd = "java -jar pdfCreator.jar ". $target." Vorlage.pdf " . $name . " 3 " . $start ." " . $end ." 2020 ";
    exec("java -jar pdfCreator.jar ". $target." Vorlage.pdf " . $name . " 3 " . $start ." " . $end ." ". $year ." " .$user, $result);
    echo $cmd;
}