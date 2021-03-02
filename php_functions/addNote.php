<?php
if ($_GET['add']){
    session_start();

    $betrieb = $_GET['betrieb'];
    $unterweisung = $_GET['unterweisungen'];
    $schule = $_GET['schule'];
    $betrieb = umlauteumwandeln($betrieb);
    $unterweisung = umlauteumwandeln($unterweisung);
    $schule = umlauteumwandeln($schule);
    $kw = $_GET['kw'];
    $mode = $_GET['mode'];
    $year = $_GET['year'];

    $ddate = date("Y-m-d");
    $duedt = explode("-", $ddate);
    $date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
    if($kw == 'current'){
        $week  = (int)date('W', $date);
    }
    else{
        $week = $kw;
    }

    $username = $_SESSION["username"];
    if(file_exists("..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$username . DIRECTORY_SEPARATOR ."notizen")){
        echo "Dir Exists";
    }
    else{
        mkdir("..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$username . DIRECTORY_SEPARATOR ."notizen");
        echo "dir Created";
    }

    if(file_exists("..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$username . DIRECTORY_SEPARATOR ."notizen" . DIRECTORY_SEPARATOR . $year)){

        echo "year dir Exists";
    }
    else{
        mkdir("..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$username . DIRECTORY_SEPARATOR ."notizen" . DIRECTORY_SEPARATOR . $year);
        echo "year dir created";
    }
    if(file_exists("..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$username . DIRECTORY_SEPARATOR ."notizen" . DIRECTORY_SEPARATOR . $year. DIRECTORY_SEPARATOR ."kw" . $week)){

        echo "File Exists";
    }
    else{
        mkdir("..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$username . DIRECTORY_SEPARATOR ."notizen" . DIRECTORY_SEPARATOR . $year. DIRECTORY_SEPARATOR ."kw" . $week);
        echo "Kw dir created";
    }
    $betriebFile = fopen("..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$username . DIRECTORY_SEPARATOR ."notizen" . DIRECTORY_SEPARATOR . $year. DIRECTORY_SEPARATOR ."kw" . $week . DIRECTORY_SEPARATOR . "betrieb.txt", $mode);
    fwrite($betriebFile,$betrieb. "\r\n");
    fclose($betriebFile);
    $unterweisungFile = fopen("..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$username . DIRECTORY_SEPARATOR ."notizen" . DIRECTORY_SEPARATOR . $year. DIRECTORY_SEPARATOR ."kw" . $week . DIRECTORY_SEPARATOR . "unterweisung.txt", $mode);
    fwrite($unterweisungFile, $unterweisung ."\r\n");
    fclose($unterweisungFile);
    $schuleFile = fopen("..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$username . DIRECTORY_SEPARATOR ."notizen" . DIRECTORY_SEPARATOR . $year. DIRECTORY_SEPARATOR ."kw" . $week . DIRECTORY_SEPARATOR . "schule.txt", $mode);
    fwrite($schuleFile, $schule."\r\n");
    fclose($schuleFile);

    echo $betrieb;
    echo $year;



}

function umlauteumwandeln($str){
    $tempstr = Array("Ä" => "_AE", "Ö" => "_OE", "Ü" => "_UE", "ä" => "_ae", "ö" => "_oe", "ü" => "_ue", "ß" => "_sz");
    return strtr($str, $tempstr);
}
