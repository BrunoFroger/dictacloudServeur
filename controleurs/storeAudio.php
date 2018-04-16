<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$myIncludePath = '/var/www/html/dictacloud';
set_include_path(get_include_path() . PATH_SEPARATOR . $myIncludePath); 

include_once ('modeles/Users/ClassUsers.php');

//error_log("storeAudio : debut");


$content = trim(file_get_contents("php://input"));


header( 'content-type: text/html; charset=utf-8' );
if (isset($_SESSION['REQUETE'])) {
        $Requete = $_SESSION['REQUETE'];
        //error_log("storePhoto2.php : recupere REQUETE " . $Requete);
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
        //error_log("storeAudio.php : recupere PSEUDO " . $Pseudo);
} else {
	$Pseudo = " ";
}
if (isset($_SESSION['FILENAME'])) {
        $Filename = $_SESSION['FILENAME'];
        //error_log("storeAudio.php : recupere FILENAME " . $Filename);
} else {
	$Filename = " ";
}

// TODO envoyer par mail si flag envoi positionné
// recuperation de l'adresse mail du user
$user = new User($Pseudo, "", "");
$user->checkPseudo($Pseudo);
//$user->display();

// calcul du port pour l'envoi des flux audio
$port = $user->getPort();


if ($treatment == "startAudio"){
        // lancement du process d'acquisition des fluxs audio
        $cmd = "php controleurs/recordMedia.php FILENAME=" . $Filename . " PORT=" . $port;
        error_log("storeAudio.php : start : execution de la commande : " . $cmd);
        //exec($cmd);
        //exec($cmd . "&");
        exec($cmd . " > /dev/null &");
        error_log("storeAudio.php : start : commande lancee ");
}else{
        //$cmd = "ps -aef | grep -v grep | grep PORT=" + $port + " | cut -d '\t' -f1";
        $cmd = "ps -aef | grep -v grep | grep PORT=" . $port;
        error_log("storeAudio.php : stop : execution de la commande : " . $cmd);
        exec ($cmd, $resultatExec);
        error_log("storeAudio.php : stop : resultat execution de la commande : " . print_r($resultatExec));
        //exec($cmd);
}

// reponse OK vers application android 


$result="OK";

$message = "demande traitee dans storeAudio";

$reponse = $Requete . ":" .
        $result . ":" .
        $port . ":" .
        $treatment . ":" .
        $message . ":";

error_log("storeAudio.php : message de retour : " . $reponse);
echo $reponse;

flush();
//exit ;
