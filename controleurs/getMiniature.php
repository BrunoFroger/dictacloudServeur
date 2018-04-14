<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// cette procedure n'est utilisable que pour des photos
// pas utilisee pour le moment lors de la requete de lite dans l'application android

$Path="/var/www/html/dictacloud/downloads/";

// Définit le contenu de l'en-tête - dans ce cas, image/jpeg
header('Content-Type: image/jpeg');

$vide = " ";

if (isset($_GET['FILENAME'])){
    $Filename = $_GET['FILENAME'];
    //error_log("getMiniature.php : (GET) recupere FILENAME " . $Filename);
}else if (isset($_SESSION['FILENAME'])) {
    $Filename = $_SESSION['FILENAME'];
    //error_log("getMiniature.php : (SESSION) recupere FILENAME " . $Filename);
} else {
    $Filename = $vide;
    error_log("ERREUR : (getMiniature.php) il faut imperativement donner un nom de fichier");
    exit;
}


$Filename = $Path . $Filename;

// calcul de la miniature
$source = imagecreatefromjpeg($Filename); // La photo est la source
if ($source != false){
    error_log("ERREUR : fichier : " . $Filename . " va etre miniaturisee");
    //$destination = imagecreatetruecolor(300, 200); // On crée la miniature vide
    $largeur_source = imagesx($source);
    $hauteur_source = imagesy($source);
    $largeur_destination = imagesx($source)/10;
    $hauteur_destination = imagesy($source)/10;
    $destination = imagecreatetruecolor($largeur_destination, $hauteur_destination); // On crée la miniature vide
    //error_log("taille de l'image originale = (" . $largeur_source . "," . $hauteur_source . ")");
    //error_log("taille de l'image finale = (" . $largeur_destination . "," . $hauteur_destination . ")");
    //$largeur_destination = imagesx($destination);
    //$hauteur_destination = imagesy($destination);

    // On crée la miniature
    imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

    imagejpeg($destination, null, 50);

    // Libération de la mémoire
    imagedestroy($destination);
}else{
    error_log("ERREUR : impossible de trouver le fichier : " . $Filename);
}

