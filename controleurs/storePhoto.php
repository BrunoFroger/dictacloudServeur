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
     $Pseudo = $_SESSION['PSEUDO'];
} else {
	$Pseudo = " ";
}
if (isset($_SESSION['FILENAME'])) {
     $Filename = $_SESSION['FILENAME'];
} else {
	$Filename = " ";
}
$result="KO";

$message = "debut de storePhoto\n";

//if (isset($_SESSION['FILENAME'])){
	//if ($_FILES['file']['uploadFile'] === UPLOAD_ERR_OK) { 
	/**
	* Do the upload process mentioned above
	**/
		$target_dir = "uploads/";
		$target_dir = $target_dir . basename( $_FILES["uploadFile"]["name"]);
		$uploadOk=1;

		if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_dir)) {
		    $message = "The file ". basename( $_FILES["uploadFile"]["name"]). " has been uploaded.";
		$result="OK";
		} else {
		    $message = "Sorry, there was an error uploading your file.";
		}
	//} //else { 
	/**
	* There were an error
	**/ 
	    //$message = "Sorry, file " . $Filename . " not found to upload.";
	//} 	
//} else {
//	$message = "Sorry, there was no file to upload.";
//}


$requete="sendPhoto";
echo $requete . ":";
echo $result . ":";
echo $Pseudo . ":";
echo $message;