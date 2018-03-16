<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$myIncludePath = '/var/www/html/dictacloud';
set_include_path(get_include_path() . PATH_SEPARATOR . $myIncludePath); 

echo "storePhoto2 : debut\n";


$content = trim(file_get_contents("php://input"));


header( 'content-type: text/html; charset=utf-8' );
if (isset($_SESSION['REQUETE'])) {
     $Requete = $_SESSION['REQUETE'];
     echo "storePhoto2.php : recupere REQUETE " . $Requete . "\n";
} else {
	$Requete = " ";
}
if (isset($_SESSION['PSEUDO'])) {
     $Pseudo = $_SESSION['PSEUDO'];
     echo "storePhoto2.php : recupere PSEUDO " . $Pseudo . "\n";
} else {
	$Pseudo = " ";
}
if (isset($_SESSION['FILENAME'])) {
     $Filename = $_SESSION['FILENAME'];
     echo "storePhoto2.php : recupere FILENAME " . $Filename . "\n";
} else {
	$Filename = " ";
}
$result="KO";

$message = "debut traitement dans storePhoto2\n";

echo $Requete . ":";
echo $result . ":";
echo $Pseudo . ":";
echo $Filename . ":";
echo $message;
exit;