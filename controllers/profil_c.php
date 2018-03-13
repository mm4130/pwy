<?php
session_start();

class profil
{
    private $instanceModelProfil;

    public function __construct(){
        include("models/profil_m.php");
        $this->instanceModelProfil = new profil_m();
    }

    public function index()
    {
        if ($_SESSION['connected'] == false){
            header("Location: ".BASE_URL."index.php/account/createAccount");
        }

        include("views/v_head.php");
        include('views/v_menu.php');


        $nbAlea = rand(1,100);
        $searchName = array('teen', 'asian', 'hardcore', 'milf', 'babe');
        $nbAleaSearchName = rand(0, count($searchName)-1);
        //search videos
        $url = "http://www.pornhub.com/webmasters/search?page=".$nbAlea."&search=".$searchName[$nbAleaSearchName]
            ."&thumbsize=large";
        $raw = file_get_contents($url);
        $infoVideos = json_decode($raw, true);


        $boolVideoRandom = true;

        include("views/v_profil.php");
        include("views/v_foot.php");
    }

    public function ranks(){
        include("views/v_head.php");
        include('views/v_menu.php');

        include("views/v_ranks.php");
        include("views/v_foot.php");
    }

    public function rankLevel(){
        $titreRank = "Rank by level";

        $donnees=$this->instanceModelProfil->getRankByLevel($_SESSION['pseudo']);


        include("views/v_head.php");
        include('views/v_menu.php');

        include("views/v_showRank.php");
        include("views/v_foot.php");
    }

    public function ranksWIS(){
        $titreRank = "Rank by the game \"Who is she\"";

        $donnees=$this->instanceModelProfil->getRankByWIS();

        include("views/v_head.php");
        include('views/v_menu.php');

        include("views/v_showRank.php");
        include("views/v_foot.php");
    }
}

