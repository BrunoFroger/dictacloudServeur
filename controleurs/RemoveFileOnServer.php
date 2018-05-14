<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$myIncludePath = '/var/www/html/dictacloud';
set_include_path(get_include_path() . PATH_SEPARATOR . $myIncludePath); 

include_once ('modeles/Users/ClassUsers.php');

//error_log("RemoveFileOnServer.php : debut");


$content = trim(file_get_contents("php://input"));


header( 'content-type: text/html; charset=utf-8' );
if (isset($_SESSION['REQUETE'])) {
        $Requete = $_SESSION['REQUETE'];
        //error_log("RemoveFileOnServer.php : recupere REQUETE " . $Requete);
} else {
	$Requete = " ";
}

if (isset($_SESSION['FILENAME'])) {
        $Filename = $_SESSION['FILENAME'];
        //error_log("RemoveFileOnServer.php : recupere FILENAME " . $Filename);
} else {
        $Filename = " ";
}

if (isset($_SESSION['PSEUDO'])) {
        $Pseudo = $_SESSION['PSEUDO'];
        //error_log("storePhoto2.php : recupere PSEUDO " . $Pseudo);
} else {
        $Pseudo = " ";
}
   
$result="OK";

$message = "fichier effacé\n";

error_log("RemoveFileOnServer.php : " . $Requete . ":" . $Pseudo . ":" . $Filename);
$commande = "rm -f " . $Filename;
$tmp = exec($commande);
//$tmp = "message de retour de rm";
error_log("RemoveFileOnServer.php : resultat commande <$commande> = <$tmp>");
$message = "Fichier effacé sur le serveur";

echo $Requete . ":";
echo $result . ":";
echo $Pseudo . ":";
echo $message . ":";
exit;

