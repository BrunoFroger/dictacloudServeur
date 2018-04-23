<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'librairies/configuration/BDD_conf.php';

class User {

    private $Id;
    private $Pseudo;
    private $Email;
    private $Passwd;
    private $Port;

    public function User($myPseudo, $myEmail, $myPasswd){
        $this->Pseudo = $myPseudo;
        $this->Email = $myEmail;
        $this->Passwd = $myPasswd;
    }

    private function getNewPort(){
        // todo scanner les ports utilises et 
        // donner le plus petit au dessus de 50505
        /*
        $requete="select port from users order by port";
        $lastPort = intval("50505");
        $listPort = $this->getRequeteList($requete);
        print_r($listPort);
        if ($listPort){
            foreach ($listPort as $item){
                $portItem=intval($item);
                if ($lastPort = 0){
                    $lastPort = $portItem;
                }
                $newport=$lastPort + 1;
                if ($portItem > $newport){
                    return $newPort;
                }
            }
        }
        */
        $newPort = 50507;
        return $newPort;
    }

    public function getEmail(){
        return $this->Email;
    }

    public function getPort(){
        //error_log("ClassUsers.php : getPort : " . $this->Port);
        return $this->Port;
    }

    public function display(){
        error_log("Objet User :");
        error_log("Pseudo   = " . $this->Pseudo);
        error_log("Email    = " . $this->Email);
        error_log("Passwd   = " . $this->Passwd);
        error_log("Port     = " . $this->Port);
    }

    public function result($requete, $result){
        //error_log("User->result : ");
        echo "{";
        echo '"REQUETE":"' . $requete . "\"";
        echo ',"RESULT":"' . $result . "\"";
        echo ',"PSEUDO":"' . $this->Pseudo . "\"";
        echo ',"EMAIL":"' . $this->Email . "\"";
        echo ',"PORT":"' . $this->Port . "\"";
        echo "}";
        //echo "\n";
    }

    public function resultWithPasswd($requete, $result){
        result($requete, $result);
        echo $this->Passwd . ":";

    }

    private function clear(){
        $this->Pseudo="";
        $this->Email = "";
        $this->Passwd = "";
        $this->Port = 0;
    }

    public function getUserByPseudo($pseudo){

    }

    public function checkPseudo($pseudo){
        //error_log("check Pseudo (" . $pseudo . ")\n");
        $requete = "select * from users where (pseudo='" . $pseudo . "') ";
        //error_log("check Pseudo requete = (" . $requete . ")\n");
        if ($this->getRequete($requete)){
            //$this->display();
            if ($this->Pseudo == $pseudo){
                //error_log("ClassUsers.php : checkPseudo : OK");
                return true;
            }
        }
        error_log("ClassUsers.php : checkPseudo : KO");
        return false;
    }

    public function checkPasswd($pseudo, $passwd){
        //error_log("check Passwd (" . $passwd . ")\n");
        $requete = "select * from users where (pseudo='" . $pseudo . "') ";
        //error_log("check Passwd requete = (" . $requete . ")\n");
        if ($this->getRequete($requete)){
            //$this->display();
            if ($this->Passwd == $passwd){
                return true;
            }
        }
        return false;
    }

    public function checkEmail($email){
        //error_log("check email (" . $email . ")\n");
        $requete = "select * from users where (Email='" . $email . "') ";
        //error_log("check email requete = (" . $requete . ")\n");
        if ($this->getRequete($requete)){
            //$this->display();
            if ($this->Email == $email){
                return true;
            }
        }
        return false;
    }

    private function getRequete($requete) {
        //error_log("<p>requete = $requete </p>");
        try {
            $dbh = new PDO(SERVEUR, USER, PWD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $mesItems = $dbh->query($requete);
            $dbh = null;
            //error_log("ClassUsers.php : getRequete : requete executee = " . $requete);
            $mesItems->setFetchMode(PDO::FETCH_ASSOC);
            if ($mesItems->rowCount() > 0) {
                foreach ($mesItems as $monItem) {
                    $this->Id = $monItem['id'];
                    $this->Pseudo = $monItem['pseudo'];
                    $this->Email = $monItem['email'];
                    $this->Passwd = $monItem['password'];
                    $this->Port = $monItem['port'];
                }
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("ClassUsers.php : getRequete : une erreur est survenue : " . $e->getMessage());
            return false;
        }
    }

    public function getRequeteList($requete) {
        $listItems = array();
        try {
            $dbh = new PDO(SERVEUR, USER, PWD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $mesItems = $dbh->query($requete);
            $dbh = null;
            //echo ("<p>requete executee</p>");
            //print_r($mesItems);
            $mesItems->setFetchMode(PDO::FETCH_ASSOC);
            if ($mesItems->rowCount() > 0) {
                foreach ($mesItems as $monItem) {
                    array_push($listItems, $monItem);
                }
                //print_r($listItems);
                return $listItems;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("ClassUsers.php : getRequeteList : une erreur est survenue : " . $e->getMessage());
            return false;
        }
    }

    public function create() {
        $this->Port = $this->getNewPort();
        $requete = "insert into users (pseudo, email, password, port) "
                . "values ('$this->Pseudo', '$this->Email', "
                . "'$this->Passwd', '$this->Port')";
        //$this->display();
        //echo ("requete = $requete \n");
        try {
            $dbh = new PDO(SERVEUR, USER, PWD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo ("<p>cnx base OK</p>");
            $mesItems = $dbh->query($requete);
            if ($mesItems != false) {
                $dbh = null;
                //echo ("<p>requete executee</p>");
                $mesItems->setFetchMode(PDO::FETCH_ASSOC);
                return true;
            } else {
                $dbh = null;
                //echo ("<p>erreur sur requete</p>");
                return false;
            }
        } catch (PDOException $e) {
            error_log("ClassUsers.php : create : une erreur est survenue : " . $e->getMessage());
            return false;
        }
        return false;
    }

    public function delete() {
        $requete = "delete from users "
                . "where (Pseudo='" . $this->Pseudo . "') ";
        //$this->display();
        //echo ("requete = $requete \n");
        try {
            $dbh = new PDO(SERVEUR, USER, PWD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo ("<p>cnx base OK</p>");
            $mesItems = $dbh->query($requete);
            if ($mesItems != false) {
                $dbh = null;
                //echo ("<p>requete executee</p>");
                $mesItems->setFetchMode(PDO::FETCH_ASSOC);
                return true;
            } else {
                $dbh = null;
                //echo ("<p>erreur sur requete</p>");
                return false;
            }
        } catch (PDOException $e) {
            error_log("ClassUsers.php : delete : une erreur est survenue : " . $e->getMessage());
            return false;
        }
        return false;
    }

    function updateBase() {
        $requete = "update users set pseudo='$this->Pseudo', "
                . "Email='$this->Email' "
                . "Passwd='$this->Password'"
                . "Port='$this->Port'";
        //echo ("<p>requete = $requete </p>");
        try {
            $dbh = new PDO(SERVEUR, USER, PWD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo ("<p>cnx base OK</p>");
            $mesItems = $dbh->query($requete);
            if ($mesItems != false) {
                $dbh = null;
                //echo ("<p>requete executee</p>");
                $mesItems->setFetchMode(PDO::FETCH_ASSOC);
                $this->getById($this->Id);
                return true;
            } else {
                $dbh = null;
                //echo ("<p>erreur sur requete</p>");
                return false;
            }
        } catch (PDOException $e) {
            error_log("ClassUsers.php : update : une erreur est survenue : " . $e->getMessage());
            return false;
        }
        return false;
    }

}
