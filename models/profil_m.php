<?php
session_start();

class profil_m{

    private $db;

    public function __construct(){
        //connecte à la bdd
        //include("../connexion_bdd.php");
        $MaConnexion = new Connexion();
        $this->db = $MaConnexion->connect();
    }

    function getRankByLevel($pseudo){
        $this->db->exec("SET @numero:=0;");
        $requete="SELECT @numero:=@numero+1 AS numero,pseudo,lvl
        FROM account
        ORDER BY lvl DESC;";
        try {
            $prep=$this->db->prepare($requete);
            $prep->bindParam(':pseudo',$pseudo,PDO::PARAM_INT);
            $prep->execute();
            $result = $prep->fetchAll();
            return $result;
        }
        catch ( Exception $e ) {
            echo "Erreur methode getRankByLevel : ", $e->getMessage();
        }
    }

    function getBestFapper(){
        $requete="SELECT pseudo,lvl
        FROM account
        ORDER BY lvl DESC
        LIMIT 1;";
        try {
            $prep=$this->db->prepare($requete);
            $prep->execute();
            $result = $prep->fetchAll();
            return $result;
        }
        catch ( Exception $e ) {
            echo "Erreur methode getBestFapper : ", $e->getMessage();
        }
    }

    function getRankByWIS(){
        $requete="SELECT pseudo, pointWIS
        FROM account
        ORDER BY pointWIS DESC;";
        try {
            $prep=$this->db->prepare($requete);
            $prep->execute();
            $result = $prep->fetchAll();
            return $result;
        }
        catch ( Exception $e ) {
            echo "Erreur methode getRankByLevel : ", $e->getMessage();
        }
    }



    function updateUnProduit($id,$donnees){
        $requete="UPDATE produits SET typeProduit_id=".$donnees['typeProduit_id']." ,
        nom='".$donnees['nom']."', prix='".$donnees['prix']."' ,
        photo='".$donnees['photo']."' WHERE id=".$id.";";
        try {
            $nbRes = $this->db->exec($requete);
        }
        catch ( Exception $e ) {
            echo "Erreur methode updateUnProduit : ", $e->getMessage();
        }
    }

    function gagneUnNiveau(){
        //verifie que le pseudo donné en post est le bon pseudo du $_SESSION
        //ca vérifie qu'il est bien passé par le adfly
        //verifie aussi que xp == 100

        if ($_SESSION['xp']==100&&$_SESSION['pseudo']==$_POST['pseudo']) {
            $_SESSION['xp'] = 0;
            $_SESSION['lvl'] += 1;

            //save dans la bdd
            $requete = "UPDATE account SET lvl=" . $_SESSION['lvl']
                . ", xp=" . $_SESSION['xp'] . ", mission='" . $_SESSION['mission']
                . "', missionRecompense=" . $_SESSION['missionRecompense']
                . " WHERE pseudo='" . $_SESSION['pseudo'] . "';";
            $result = $this->db->exec($requete);

            //genere new mission
            include("models/mission_m.php");
            $instanceModelMission = new Mission_m();
            $_SESSION['mission'] = $instanceModelMission->generateMission();
            $_SESSION['missionRecompense'] = $instanceModelMission->generateMissionRecompense();

            header('Location: '.BASE_URL.'index.php/profil/');
        }
        else{
            //genere new mission
            include("models/mission_m.php");
            $instanceModelMission = new Mission_m();
            $_SESSION['mission'] = $instanceModelMission->generateMission();
            $_SESSION['missionRecompense'] = $instanceModelMission->generateMissionRecompense();

            header('Location: '.BASE_URL.'index.php/profil/');
        }
    }


}
