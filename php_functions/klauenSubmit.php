<?php
if ($_GET['add']){
    session_start();
    $username = $_SESSION["username"];
    $targetUser = $_GET['user'];
    $targetWeek = $_GET['week'];
    $targetYear = $_GET['year'];
    $style = $_GET['type'];
    $type = '';

    if ($style == 'Betrieb') {
        $type = "betrieb.txt";
    } elseif ($style == 'Unterweisung') {
        $type = "unterweisung.txt";
    } elseif ($style == 'Schule') {
        $type = "schule.txt";
    }

    $source = "..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$targetUser . DIRECTORY_SEPARATOR ."notizen" . DIRECTORY_SEPARATOR . $targetYear. DIRECTORY_SEPARATOR ."kw" . $targetWeek . DIRECTORY_SEPARATOR . $type;
    $target = "..". DIRECTORY_SEPARATOR . "users". DIRECTORY_SEPARATOR .$username . DIRECTORY_SEPARATOR ."notizen" . DIRECTORY_SEPARATOR . $targetYear. DIRECTORY_SEPARATOR ."kw" . $targetWeek . DIRECTORY_SEPARATOR . $type;
    echo $source;
    echo $target;
    echo copy($source, $target);
}
