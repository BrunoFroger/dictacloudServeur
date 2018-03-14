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

    public function User($myPseudo, $myEmail, $myPasswd){
        $this->Pseudo=$myPseudo;
        $this->Email = $myEmail;
        $this->Passwd = $myPasswd;
    }

    public function display(){
        echo "Objet User :\n";
        echo "Pseudo   = " . $this->Pseudo . "\n";
        echo "Email    = " . $this->Email . "\n";
        echo "Passwd   = " . $this->Passwd . "\n";
    }

    public function result($requete, $result){
        echo "{"
        echo "\"REQUETE\":\"" . $requete . "\":\"";
        echo "\"RESULT\":\"" . $result . "\":\"";
        echo "\"PSEUDO\":\"" . $this->Pseudo . "\":\"";
        echo "}";
        //echo "\n";
    }

    private function clear(){
        $this->Pseudo="";
        $this->Email = "";
        $this->Passwd = "";
    }

    public function checkPseudo($pseudo){
        //echo ("check Pseudo (" . $pseudo . ")\n");
        $requete = "select * from users where (Pseudo='" . $pseudo . "') ";
        //echo ("check Pseudo requete = (" . $requete . ")\n");
        if ($this->getRequete($requete)){
            //$this->display();
            if ($this->Pseudo == $pseudo){
                return true;
            }
        }
        return false;
    }

    public function checkPasswd($pseudo, $passwd){
        //echo ("check Passwd (" . $passwd . ")\n");
        $requete = "select * from users where (Pseudo='" . $pseudo . "') ";
        //echo ("check Passwd requete = (" . $requete . ")\n");
        if ($this->getRequete($requete)){
            //$this->display();
            if ($this->Passwd == $passwd){
                return true;
            }
        }
        return false;
    }

    public function checkEmail($email){
        //echo ("check email (" . $email . ")\n");
        $requete = "select * from users where (Email='" . $email . "') ";
        //echo ("check email requete = (" . $requete . ")\n");
        if ($this->getRequete($requete)){
            //$this->display();
            if ($this->Email == $email){
                return true;
            }
        }
        return false;
    }

    private function getRequete($requete) {
        //echo ("<p>requete = $requete </p>");
        try {
            $dbh = new PDO(SERVEUR, USER, PWD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $mesItems = $dbh->query($requete);
            $dbh = null;
            //echo ("requete executee = " . $requete . "</p>\n");
            $mesItems->setFetchMode(PDO::FETCH_ASSOC);
            if ($mesItems->rowCount() > 0) {
                foreach ($mesItems as $monItem) {
                    $this->Id = $monItem['id'];
                    $this->Pseudo = $monItem['pseudo'];
                    $this->Email = $monItem['email'];
                    $this->Passwd = $monItem['password'];
                }
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "une erreur est survenue : " . $e->getMessage();
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
            echo "une erreur est survenue : " . $e->getMessage();
            return false;
        }
    }

    public function create() {
        $requete = "insert into users (pseudo, email, password) "
                . "values ('$this->Pseudo', '$this->Email', "
                . "'$this->Passwd')";
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
            echo "<p>une erreur est survenue lors de la creation du user : " . $e->getMessage();
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
            echo "<p>une erreur est survenue lors de la creation du user : " . $e->getMessage();
            return false;
        }
        return false;
    }

    function updateBase() {
        $requete = "update users set pseudo='$this->Pseudo', "
                . "Email='$this->email' "
                . "Passwd='$this->password'";
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
            echo "<p>une erreur est survenue lors de la mise a jour du user : " . $e->getMessage();
            return false;
        }
        return false;
    }

}
