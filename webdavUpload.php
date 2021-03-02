<?php
include 'vendor/autoload.php';
if ($_GET['add']){
    session_start();
    $settings = array(
        'baseUri' => 'https://cloud.g-key.de/remote.php/dav/files/'. DIRECTORY_SEPARATOR. $_GET['username']."/",
        'userName' => $_GET['username'],
        'password' => $_GET['password']
    );
    $year = $_GET['year'];
    $target = $_GET['year'] . DIRECTORY_SEPARATOR . $_GET['month'];

    $client = new Sabre\DAV\Client($settings);
    $webFolder = $_GET['webFolder'];
    if(strlen($webFolder)==0){
        $structure ="berichte";
        $client->request('MKCOL', $structure);
    }else{
        if(strpos($webFolder, DIRECTORY_SEPARATOR)){
            $folders = explode(DIRECTORY_SEPARATOR, $webFolder);
            $structure =$folders[0];
            $client->request('MKCOL', $structure);
            for ($i = 1; $i < sizeof($folders); $i++){
                $structure = $structure . DIRECTORY_SEPARATOR . $folders[$i];
                $client->request('MKCOL', $structure);
            }
            echo "in if";
        }else{
            $structure =$webFolder;
            $client->request('MKCOL', $structure);
        }
    }


    echo $structure;
    $client->request('MKCOL', $structure. DIRECTORY_SEPARATOR.$year);
    $client->request('MKCOL', $structure. DIRECTORY_SEPARATOR.$target);
    $files = scandir("users". DIRECTORY_SEPARATOR .$_SESSION["username"] . DIRECTORY_SEPARATOR . "berichte". DIRECTORY_SEPARATOR .$target);

    for ($i = 2; $i < sizeof($files); $i++ ){
        $link = "users". DIRECTORY_SEPARATOR .$_SESSION["username"] . DIRECTORY_SEPARATOR . "berichte". DIRECTORY_SEPARATOR .$target . DIRECTORY_SEPARATOR .$files[$i];
        $upload_result = $client->request('PUT', $structure. DIRECTORY_SEPARATOR . $target. DIRECTORY_SEPARATOR. $files[$i], file_get_contents($link));
    }


}

