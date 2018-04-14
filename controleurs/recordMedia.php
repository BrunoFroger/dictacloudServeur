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

parse_str(implode('&', array_slice($argv, 1)), $_GET);

header( 'content-type: text/html; charset=utf-8' );

if (isset($_GET['FILENAME'])){
    $Filename = $_GET['FILENAME'];
    error_log("recordMedia.php : (GET) recupere FILENAME " . $Filename);
}else if (isset($_SESSION['FILENAME'])) {
    $Filename = $_SESSION['FILENAME'];
    error_log("recordMedia.php : (SESSION) recupere FILENAME " . $Filename);
} else {
    $Filename = $vide;
    error_log("ERREUR : (recordMedia.php) il faut imperativement donner un nom de fichier");
    exit;
}

if (isset($_GET['PORT'])){
    $Port = $_GET['PORT'];
    error_log("recordMedia.php : (GET) recupere PORT " . $Port);
}else if (isset($_SESSION['PORT'])) {
    $Port = $_SESSION['PORT'];
    error_log("recordMedia.php : (SESSION) recupere PORT " . $Port);
} else {
    $Port = $vide;
    error_log("ERREUR : (recordMedia.php) il faut imperativement donner un port");
    exit;
}

error_log("recordMedia.php : Filename   = " . $Filename);
error_log("recordMedia.php : Port       = " . $Port);

$file = fopen($Filename , "wb");
error_log("recordMedia.php : fichier de sortie cree " . $Filename);

$mySocket = socket_create_listen($Port);
socket_accept ($mySocket);
error_log("recordMedia.php : socket ouvert sur port " . $Port);

$data = socket_read($mySocket, 1000);
while ($data != false){
    error_log("recordMedia.php : ecriture d'un bloc de données");
    fwrite($file, $data);
    $data = socket_read($mySocket, 1000);
}

fclose($file);