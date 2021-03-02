<?php
include 'vendor/autoload.php';

    $settings = array(
        'baseUri' => 'https://cloud.g-key.de/remote.php/dav/files/'. DIRECTORY_SEPARATOR. "Dennis"."/",
        'userName' => "Dennis",
        'password' => "DreiserMedium1997"
    );
    $year = "2021";
    $target = "2021" . DIRECTORY_SEPARATOR . "JANUARY";
    echo "Checkpoint 1";
    $client = new Sabre\DAV\Client($settings);
    echo "Checkpoint 2";
    $webFolder = "berichteTest";
    if(strlen($webFolder)==0){
        echo "webfolder==0";
        $structure ="berichte";
        $client->request('MKCOL', $structure);
    }else{
        echo "Checkpoint 3";
        if(strpos($webFolder, DIRECTORY_SEPARATOR)){
            echo "Checkpoint 4.1";
            $folders = explode(DIRECTORY_SEPARATOR, $webFolder);
            $structure =$folders[0];
            $client->request('MKCOL', $structure);
            for ($i = 1; $i < sizeof($folders); $i++){
                $structure = $structure . DIRECTORY_SEPARATOR . $folders[$i];
                $client->request('MKCOL', $structure);
            }
            echo "in if";
        }else{
            echo "Checkpoint 4.2";
            $structure =$webFolder;
            $client->request('MKCOL', $structure);
        }
    }


    echo $structure;
$client->request('MKCOL', $structure. DIRECTORY_SEPARATOR.$year);
    $client->request('MKCOL', $structure. DIRECTORY_SEPARATOR.$target);
    $files = scandir("users". DIRECTORY_SEPARATOR ."Dennis" . DIRECTORY_SEPARATOR . "berichte". DIRECTORY_SEPARATOR .$target);
    print_r($files);
    echo "files printed";

    for ($i = 2; $i < sizeof($files); $i++ ){
        echo "Upload Round: " . $i;
        $link = "users". DIRECTORY_SEPARATOR ."Dennis" . DIRECTORY_SEPARATOR . "berichte". DIRECTORY_SEPARATOR .$target . DIRECTORY_SEPARATOR .$files[$i];
        $upload_result = $client->request('PUT', $structure. DIRECTORY_SEPARATOR . $target. DIRECTORY_SEPARATOR. $files[$i], file_get_contents($link));
    }




