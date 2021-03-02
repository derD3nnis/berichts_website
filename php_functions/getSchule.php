<?php
if ($_GET['betrieb']){
    session_start();
    $kw = $_GET['kw'];
    $year = $_GET['year'];
    $username = $_SESSION["username"];
    $ddate = date("Y-m-d");
    $duedt = explode("-", $ddate);
    $date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
    $week  = (int)date('W', $date);
    $text = "";

    if($kw == 'current'){
        $week  = (int)date('W', $date);
    }
    else{
        $week = $kw;
    }


    if(file_exists("..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$username . DIRECTORY_SEPARATOR ."notizen" . DIRECTORY_SEPARATOR . $year. DIRECTORY_SEPARATOR ."kw" . $week . DIRECTORY_SEPARATOR . "schule.txt")){
        $file = fopen("..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$username . DIRECTORY_SEPARATOR ."notizen" . DIRECTORY_SEPARATOR . $year. DIRECTORY_SEPARATOR ."kw" . $week . DIRECTORY_SEPARATOR . "schule.txt", "r");
        while ($line = fgets($file)) {
            $text = $text . $line;
        }
        fclose($file);
    }else


    $text = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $text);
    $text = umlauteumwandeln($text);
    echo $text;
}

function umlauteumwandeln($str){
    $tempstr = Array("_AE" => "Ä", "_OE" => "Ö", "_UE" => "Ü", "_ae" => "ä", "_oe" => "ö", "_ue" => "ü", "_sz" => "ß");
    return strtr($str, $tempstr);
}