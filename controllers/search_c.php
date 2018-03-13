<?php
session_start();

class search
{
    private $instanceModelSearch;

    public function __construct(){
        include("models/search_m.php");
        $this->instanceModelSearch = new search_m();
    }
    
    public function index()
    {
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

        include("views/v_showList.php");
        include("views/v_foot.php");
    }
    public function watch($url='')
    {
        //get embeded videos
        $url = htmlentities($url);

        $urlInfoVideo = "http://www.pornhub.com/webmasters/video_by_id?thumbsize=large&id=".$url;
        $urlVideoEmbeded = "http://www.pornhub.com/webmasters/video_embed_code?id=".$url;

        $raw = file_get_contents($urlInfoVideo);
        $infoVideo = json_decode($raw, true);

        $raw = file_get_contents($urlVideoEmbeded);
        $embededVideo = json_decode($raw, true);


        //Gère validation de mission
        $missionValide = false;
        //verifie dans -> title
        if (strpos($infoVideo['video']['title'], $_SESSION['mission']) !== false){
            $missionValide = true;
        }
        foreach ($infoVideo['video']['tags'] as $tag){
            if (strpos($tag['tag_name'], $_SESSION['mission']) != false){
                $missionValide = true;
            }
        }
        foreach ($infoVideo['video']['pornstars'] as $star){
            if (strpos($star['pornstar_name'], $_SESSION['mission']) != false){
                $missionValide = true;
            }
        }

        if ($missionValide == true){
            include("models/mission_m.php");
            $instanceControlMission = new mission_m();

            $instanceControlMission->valideMission();
        }


        include("views/v_head.php");
        include('views/v_menu.php');
        include('views/v_watch.php');
        include("views/v_foot.php");
    }

    public function searchName($page=''){
        $boolSearch = true;

        $name = htmlentities($_POST['name']);

        if (!preg_match("/[A-Za-z]{2,}/",$name))
            $erreurs['nom']='La recherche doit être composée au minimum de 2 lettres';

        $name = str_replace(' ', '+', $name);

        include("views/v_head.php");
        include('views/v_menu.php');

        //search videos
        $url = "http://www.pornhub.com/webmasters/search?thumbsize=large&page=".$page."&search=".$name;
        $raw = file_get_contents($url);
        $infoVideos = json_decode($raw, true);

        include("views/v_showList.php");
        include("views/v_foot.php");
    }
}

