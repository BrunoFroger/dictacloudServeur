<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'librairies/configuration/BDD_conf.php';

class Photos {

    private $Id;
    private $Filename;
    private $User;

    public function User($myFilename, $myUser){
        $this->Filename=$myFilename;
        $this->User = $myUser;
    }

    public function display(){
        echo "Objet Photo :\n";
        echo "Filename   = " . $this->Filename . "\n";
        echo "User       = " . $this->User . "\n";
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
                    $this->Filename = $monItem['filename'];
                    $this->User = $monItem['user'];
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
        $requete = "insert into photos (filename, user) "
                . "values ('$this->Filename, $this->User')";
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
        $requete = "delete from photos "
                . "where (filename='" . $this->Filename . "') ";
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
        $requete = "update photos set pseudo='$this->Pseudo', "
                . "filename='$this->Filename' ";
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
