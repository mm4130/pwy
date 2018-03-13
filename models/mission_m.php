<?php
session_start();

class mission_m
{
    private $instanceModelProduit;
    private $db;

    public function __construct()
    {
        //include("models/search_m.php");
        //$this->instanceModelProduit = new Produit_m();
        $MaConnexion = new Connexion();
        $this->db = $MaConnexion->connect();
    }

    public function generateMission()
    {
        //get embeded videos
        $raw = file_get_contents("nameStars.txt", FILE_USE_INCLUDE_PATH);
        $embededVideo = json_decode($raw, true);

        $nombreStar = count($embededVideo['stars']);
        $nbAleaSearchStar = rand(0, $nombreStar - 1);
        $nameStar = $embededVideo['stars'][$nbAleaSearchStar]['star']['star_name'];

        return ucwords($nameStar);
    }

    public function generateMissionRecompense()
    {
        $nbAleaRecompense = rand(5, 50);
        return $nbAleaRecompense;
    }

    public function valideMission(){
        $_SESSION['xp'] += $_SESSION['missionRecompense'];
        //si depasse les 100%
        if ($_SESSION['xp']>=100){
            $_SESSION['xp'] = 100;
            //genere new mission
            $_SESSION['mission'] = null;
            $_SESSION['missionRecompense'] = null;
        }
            //genere new mission
            $_SESSION['mission'] = $this->generateMission();
            $_SESSION['missionRecompense'] = $this->generateMissionRecompense();


        //save dans la bdd
        $requete="UPDATE account SET lvl=".$_SESSION['lvl']
            .", xp=".$_SESSION['xp'].", mission='".$_SESSION['mission']
            ."', missionRecompense=".$_SESSION['missionRecompense']
            ." WHERE pseudo='".$_SESSION['pseudo']."';";
        $result = $this->db->exec($requete);

        $_SESSION['missionVientDetreValide'] = true;
    }
}