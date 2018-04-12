<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$myIncludePath = '/var/www/html/dictacloud';
set_include_path(get_include_path() . PATH_SEPARATOR . $myIncludePath); 

include_once ('modeles/Users/ClassUsers.php');

error_log("recordMedia : debut");

$vide = " ";

header( 'content-type: text/html; charset=utf-8' );

if (isset($_SESSION['PSEUDO'])) {
    $Pseudo = $_SESSION['PSEUDO'];
    error_log("recordMedia.php : recupere PSEUDO " . $Pseudo);
} else {
    $Pseudo = $vide;
}


if (isset($_SESSION['FILENAME'])) {
    $Filename = $_SESSION['FILENAME'];
    error_log("recordMedia.php : recupere FILENAME " . $Filename);
} else {
    $Filename = $vide;
}

if (isset($_SESSION['PORT'])) {
    $Port = $_SESSION['PORT'];
    error_log("recordMedia.php : recupere PORT " . $Port);
} else {
    $Port = $vide;
}


$file = fopen($Filename , "wb");
error_log("recordMedia.php : fichier de sortie cree " + $Filename);

$mySocket = socket_create_listen($port);
socket_accept ($mySocket);
error_log("recordMedia.php : socket ouvert sur port " . $Port);

$data = socket_read($mySocket, 1000);
while ($data != false){
    error_log("recordMedia.php : ecriture d'un bloc de données");
    fwrite($file, $data);
    $data = socket_read($mySocket, 1000);
}

fclose($file);