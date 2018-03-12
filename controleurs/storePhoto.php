<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$myIncludePath = '/var/www/html/dictacloud';
set_include_path(get_include_path() . PATH_SEPARATOR . $myIncludePath); 

header( 'content-type: text/html; charset=utf-8' );
if (isset($_SESSION['PSEUDO'])) {
     $Pseudo = $_POST['PSEUDO'];
} else {
	$pseudo = " ";
}


$result="OK";


echo "sendPhoto" . ":";
echo $result . ":";
echo $pseudo;