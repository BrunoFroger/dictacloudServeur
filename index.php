<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
$myIncludePath = '/var/www/html/dictacloud';
set_include_path(get_include_path() . PATH_SEPARATOR . $myIncludePath); 

//header( 'content-type: text/html; charset=utf-8' );
header( 'Content-type: application/json; charset=utf-8' );

//echo "debut index.php\n";


//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    throw new Exception('Request method must be POST!');
    //echo "Request method must be POST!\n";
}
 
//echo "etape 1 index.php\n";

//Make sure that the content type of the POST request has been set to application/json
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if(strcasecmp($contentType, 'application/json') != 0){
    if (strcasecmp($contentType, 'application/octet-stream') == 0){
        if (isset($_POST['PSEUDO'])) {
             $Pseudo = $_SESSION['PSEUDO'];
             echo "index.php : init PSEUDO " . $Pseudo;
        } else {
            $Pseudo = " ";
        }
        if (isset($_POST['FILENAME'])) {
             $Filename = $_SESSION['FILENAME'];
             echo "index.php : init FILENAME " . $Filename;
        } else {
            $Filename = " ";
        }
        include_once 'controleurs/storePhoto2.php';
    }else{
        throw new Exception('Content type must be: application/json');
        //echo "Content type must be: application/json\n";
    }
}
 
//echo "etape 2 index.php\n";

//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));
//echo $content;
 
//Attempt to decode the incoming RAW post data from JSON.
$decoded = json_decode($content, true);
 
//If json_decode failed, the JSON is invalid.
if(!is_array($decoded)){
    throw new Exception('Received content contained invalid JSON!');
    //echo "Received content contained invalid JSON!\n";
}


//echo "JSON OK\n";
//echo print_r($decoded);
$decoded = json_decode($content);

$vide=" ";
if (array_key_exists("REQUETE",$decoded)){
    $Requete = $decoded->{"REQUETE"};
    $_SESSION['REQUETE'] = $Requete;
}else{
    $Requete = $vide;
}
if (array_key_exists("PSEUDO",$decoded)){
    $Pseudo = $decoded->{"PSEUDO"};
    $_SESSION['PSEUDO'] = $Pseudo;
}else{
    $Pseudo = $vide;
}
if (array_key_exists("EMAIL",$decoded)){
    $Email = $decoded->{"EMAIL"};
    $_SESSION['EMAIL'] = $Email;
}else{
    $Email = $vide;
}
if (array_key_exists("PASSWD",$decoded)){
    $Passwd = $decoded->{"PASSWD"};
    $_SESSION['PASSWD'] = $Passwd;
}else{
    $Passwd = $vide;
}
if (array_key_exists("FILENAME",$decoded)){
    $Filename = $decoded->{"FILENAME"};
    $_SESSION['FILENAME'] = $Filename;
}else{
    $Filename = $vide;
}


echo "requete  = ". $Requete . "\n";
echo "pseudo   = ". $Pseudo . "\n";
echo "email    = ". $Email . "\n";
echo "passwd   = ". $Passwd . "\n";
echo "filename = ". $Filename . "\n";

//echo "====================\n";
//echo "serveur Dictacloud\n";
//echo "--------------------\n";
//echo "Analyse parametres :\n";

include_once ('modeles/Users/ClassUsers.php');
/*
if (isset($_POST['REQUETE'])) {
     if ($_POST['REQUETE'] != "") {
         $Requete = $_POST['REQUETE'];
         $_SESSION['REQUETE'] = $Requete;
         //echo ("Requete=" . $Requete . "; ");
     }
} else {
     $Requete = $vide;
     unset($_SESSION['REQUETE']);
}

if (isset($_POST['PSEUDO'])) {
     if ($_POST['PSEUDO'] != "") {
         $Pseudo = $_POST['PSEUDO'];
         $_SESSION['PSEUDO'] = $Pseudo;
         //echo ("Pseudo=" . $Pseudo . "; ");
     } 
} else {
     $Pseudo = $vide;
     unset($_SESSION['PSEUDO']);
}

if (isset($_POST['EMAIL'])) {
    if ($_POST['EMAIL'] != "") {
        $Email = $_POST['EMAIL'];
        $_SESSION['EMAIL'] = $Email;
        //echo ("Email=" . $Email . "; ");
    } 
} else {
    $Email = $vide;
    unset($_SESSION['EMAIL']);
}    

if (isset($_POST['PASSWD'])) {
    if ($_POST['PASSWD'] != "") {
        $Passwd = $_POST['PASSWD'];
        $_SESSION['PASSWD'] = $Passwd;
        //echo ("Passwd=" . $Passwd);
    } 
} else {
    $Passwd = $vide;
    unset($_SESSION['PASSWD']);
}
*/

//echo ("[" . $Requete . ":" . $Pseudo . ":" . $Email . ":" . $Passwd . "]\n");
//echo "\n--------------------\n";

// contruction de la reponse

//echo "traitement des commandes\n";

$user =  new User($Pseudo, $Email, $Passwd);

if ($Requete != ""){
    // analyse de la requete
    switch ($Requete){
        //*********************    
        //**    register
        //*********************    
        case "register":
            if ($Pseudo == ""  || $Passwd == ""){
                $result="Erreur => register => manque parametre"; 
            }else{
                //echo ("register => " . $Pseudo . "\n");
                if ( ! $user->checkPseudo($Pseudo)){
                    $result="Erreur => register => pseudo inconnu";
                } else if ( ! $user->checkPasswd($Pseudo,$Passwd)){
                    $result="Erreur => register => mot de passe invalide";
                } else {
                    //echo ("submit register\n");
                    $result="OK";
                }            
            }
            $user->result($Requete,$result);
            break; 
        //*********************    
        //**    subscribe
        //*********************    
        case 'subsribe':
            if ($Pseudo == "" || $Email == "" || $Passwd == ""){
                $result="Erreur => subscribe => manque parametre";
            }else{
                //echo ("subscribe => " . $Pseudo . "\n");
                //$user->display();
                if ($user->checkEmail($Email)){
                    $result="Erreur => subscribe => l'email " . $Email . " existe deja";
                } else if ($user->checkPseudo($Pseudo)){
                    $result="Erreur => subscribe => le pseudo " . $Pseudo . " existe deja";
                } else {
                    //echo ("subsribe new user\n");
                    //$user->display();
                    $user->create();
                    $result="OK";
                }            
            }
            $user->result($Requete,$result);
            break; 
        //*********************    
        //**    unsubscribe
        //*********************    
        case 'unsubsribe':
            if ($Pseudo == ""){
                $result="Erreur => unsubscribe => manque parametre";
            }else if (!$user->checkPseudo($Pseudo)){
                $result="Erreur => unsubscribe => le pseudo " . $Pseudo . " n'existe pas";
            } else {
                $result="OK";
            }
            $user->delete();
            $user->result($Requete,$result);
            break; 
        //*********************    
        //**    send Photo
        //*********************    
        case 'sendPhoto':
            include_once 'controleurs/storePhoto2






            .php';
            break;
        //*********************    
        //**    default
        //*********************    
        default:
            $result="Error => requete [" . $Requete . "] inconnue";
            $user->result($Requete,$result);
            break;
    }
}
