<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$myIncludePath = '/var/www/html/dictacloud';
set_include_path(get_include_path() . PATH_SEPARATOR . $myIncludePath); 

include_once ('modeles/Users/ClassUsers.php');

error_log("sendFileByEmail : debut");


$content = trim(file_get_contents("php://input"));


header( 'content-type: text/html; charset=utf-8' );
if (isset($_SESSION['REQUETE'])) {
        $Requete = $_SESSION['REQUETE'];
        error_log("sendFileByEmail.php : recupere REQUETE " . $Requete);
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
        error_log("sendFileByEmail.php : recupere PSEUDO " . $Pseudo);
} else {
	$Pseudo = " ";
}

$user = new User($Pseudo, "", "");
$user->checkPseudo($Pseudo);
$Email = $user->getEmail();

$result="OK";

$message = "fichier traité dans sendFileByEmail\n";

// TODO procedure d'envoi de mail

error_log("envoi par mail a " . $Email . " du fichier " . $Filename);
$subject = "[Dictacloud] Votre photo : " . $Filename;
$message = "Bonjour $Pseudo<br><br>"
        . "Voici, en pièce jointe, la photo que vous venez de prendre<br><br>"
        . "Cordialement<br><br>"
        . "Le serveur Dictacloud<br><br>"
        . "PS : Mail envoyé par un robot, ne pas repondre à ce mail";
file_put_contents("/tmp/mail.txt", "to: $Email\n");
file_put_contents("/tmp/mail.txt", "from: Dictacloud <Dictacloud.froger@wanadoo.fr>\n", FILE_APPEND);
file_put_contents("/tmp/mail.txt", "subject: $subject\n", FILE_APPEND);
file_put_contents("/tmp/mail.txt", "$message\n", FILE_APPEND);

//. " -e 'set smtp_url=\"smtp.orange.fr::465\"'"
//. " -e 'set smtp_url=\"199.59.243.120::465\"'"
        //. " -e 'set ssl_starttls=yes'"
        //. " -e 'set smtp_url=\"smtp.orange.fr::465\"'"
        //. " -e 'set smtp_user=\"bruno.froger2\"'"
        //. " -e 'set smtp_pass=\"3paul2fan\"'"
        //. " -e 'set hostname=\"wanadoo.fr\"'"
$cmd = "mutt -H - -n "
        . " -e 'set content_type=\"text/html\"'"
        . " -e 'set copy=no'"
        . " -a downloads/$Filename"
        . " < /tmp/mail.txt ";
//error_log("commande executee : $cmd");
$ficMail = shell_exec("more /tmp/mail.txt");
//error_log("fichier mail : " . $ficMail);

exec($cmd . " > /dev/null &");
//error_log("fin envoi du mail");

$Filename = "downloads/" . $Filename;
exec("./clearFichier.sh " . $Filename . " > /dev/null &");



echo $Requete . ":";
echo $result . ":";
echo $Pseudo . ":";
echo $message . ":";


exit;

