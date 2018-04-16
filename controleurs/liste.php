<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$myIncludePath = '/var/www/html/dictacloud';
set_include_path(get_include_path() . PATH_SEPARATOR . $myIncludePath); 

include_once ('modeles/Users/ClassUsers.php');

//error_log("liste : debut");


$content = trim(file_get_contents("php://input"));


header( 'content-type: text/html; charset=utf-8' );
if (isset($_SESSION['REQUETE'])) {
     $Requete = $_SESSION['REQUETE'];
     //error_log("liste.php : recupere REQUETE " . $Requete);
} else {
	$Requete = " ";
}

if (isset($_SESSION['PSEUDO'])) {
     $Pseudo = $_SESSION['PSEUDO'];
     //error_log("storePhoto2.php : recupere PSEUDO " . $Pseudo);
} else {
	$Pseudo = " ";
}

$user = new User($Pseudo, "", "");
$user->checkPseudo($Pseudo);
// reponse OK vers application android 

$result="OK";

$message = "liste traitée dans storePhoto2\n";

//error_log("storePhoto2.php : fin OK");

echo $Requete . ":";
echo $result . ":";
echo $Pseudo . ":";

//exit ;

$Filename = "dictacloud." . $Pseudo . ".*";
//$tmp = exec("ls -l downloads/" . $Filename . " | cut -d '/' -f2", $ListeFichiers);
$tmp = exec("du --apparent-size downloads/" . $Filename, $ListeFichiers);
//$tmp = str_replace('\t','?',$tmp);

//error_log("liste : resultat commande externe ($Filename)");

$index = 0;
//error_log("nombre de fichier : " . count($ListeFichiers));

foreach ($ListeFichiers as $fichier){
        //error_log("liste : " . $fichier);
        echo $fichier . ":";
}
//echo $ListeFichiers;
exit;

