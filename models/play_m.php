<?php
session_start();
/**
 * Created by PhpStorm.
 * User: sakalypse
 * Date: 30/12/16
 * Time: 21:08
 */
class play_m
{
    private $db;

    public function __construct(){
        //connecte à la bdd
        //include("../connexion_bdd.php");
        $MaConnexion = new Connexion();
        $this->db = $MaConnexion->connect();
    }

    function getTicketWhosIsShe($pseudo){
        $requete="SELECT ticketWhoIsShe
        FROM account
        WHERE pseudo = '".$pseudo."';";
        $select = $this->db->query($requete);
        $results = $select->fetch();
        return $results;
    }

    function getAllStars(){
        $requete="SELECT *
        FROM whoIsShe;";
        $select = $this->db->query($requete);
        $results = $select->fetchAll();
        return $results;
    }

    function decrementTicketWhoIsShe($pseudo){
        $requete="UPDATE account SET ticketWhoIsShe = ticketWhoIsShe-1 WHERE pseudo='".$pseudo."';";
        try {
            $nbRes = $this->db->exec($requete);
        }
        catch ( Exception $e ) {
            echo "Erreur methode decrementTicketWhoIsShe : ", $e->getMessage();
        }
    }

    function incrementPointRankWIS($pseudo){
        $requete="UPDATE account SET pointWIS = pointWIS+1 WHERE pseudo='".$pseudo."';";
        try {
            $nbRes = $this->db->exec($requete);
        }
        catch ( Exception $e ) {
            echo "Erreur methode incrementPointRankWIS : ", $e->getMessage();
        }
    }

}