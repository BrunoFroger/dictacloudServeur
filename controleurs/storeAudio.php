<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$myIncludePath = '/var/www/html/dictacloud';
set_include_path(get_include_path() . PATH_SEPARATOR . $myIncludePath); 

include_once ('modeles/Users/ClassUsers.php');

error_log("storeAudio : debut");


$content = trim(file_get_contents("php://input"));


header( 'content-type: text/html; charset=utf-8' );
if (isset($_SESSION['REQUETE'])) {
        $Requete = $_SESSION['REQUETE'];
        error_log("storePhoto2.php : recupere REQUETE " . $Requete);
} else {
	$Requete = " ";
}

if (isset($_SESSION['TREATMENT'])) {
        $treatment = $_SESSION['TREATMENT'];
        error_log("storeAudio.php : recupere TREATMENT " . $treatment);
   } else {
           $treatment = " ";
   }
   
if (isset($_SESSION['PSEUDO'])) {
        $Pseudo = $_SESSION['PSEUDO'];
        error_log("storeAudio.php : recupere PSEUDO " . $Pseudo);
} else {
	$Pseudo = " ";
}
if (isset($_SESSION['FILENAME'])) {
        $Filename = $_SESSION['FILENAME'];
        error_log("storeAudio.php : recupere FILENAME " . $Filename);
} else {
	$Filename = " ";
}

// TODO envoyer par mail si flag envoi positionné
// recuperation de l'adresse mail du user
$user = new User($Pseudo, "", "");
$user->checkPseudo($Pseudo);

// calcul du port pour l'envoi des flux audio


// reponse OK vers application android 

$result="OK";

$message = "photo traitée dans storeAudio\n";

$reponse = $Requete . ":" .
        $result . ":" .
        $message . ":" .
        $port;

error_log("storeAudio.php : message de retour : " . $reponse);
echo $reponse;

flush();
//exit ;
