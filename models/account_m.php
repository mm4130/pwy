<?php
session_start();

class account_m{

    private $db;


    public function __construct(){
        //connecte à la bdd
        //include("../connexion_bdd.php");
        $MaConnexion = new Connexion();
        $this->db = $MaConnexion->connect();
    }

    function getAllAccount(){
        $requete="SELECT *
        FROM account
        ORDER BY pseudo;";
        $select = $this->db->query($requete);
        $results = $select->fetchAll();
        return $results;
    }

    function insertAccount($donnees){
        $requete="INSERT INTO account (pseudo,mdp,mission,missionRecompense,lvl, sponsor) 
                  VALUES (:pseudo,:mdp,:mission,:missionRecompense,:lvl,:sponsor);";
        $lvlRequete = 1;
        try {
            $prep=$this->db->prepare($requete);
            $prep->bindParam(':pseudo',$donnees['pseudo'],PDO::PARAM_STR,25);
            $prep->bindParam(':mdp',$donnees['mdp'],PDO::PARAM_STR);
            $prep->bindParam(':mission',$donnees['mission'],PDO::PARAM_STR);
            $prep->bindParam(':missionRecompense',$donnees['missionRecompense'],PDO::PARAM_INT);
            $prep->bindParam(':lvl',$lvlRequete,PDO::PARAM_INT);
            $prep->bindParam(':sponsor',$donnees['s'],PDO::PARAM_INT);

            $prep->execute();

        }
        catch (Exception $e) {
            echo "Erreur methode insertUnCompte : ", $e->getMessage();
        }
    }

    function readUnPseudo($pseudo){
        $requete="SELECT *
        FROM account WHERE pseudo=:pseudo LIMIT 1;";
        try {
            $prep=$this->db->prepare($requete);
            $prep->bindParam(':pseudo',$pseudo,PDO::PARAM_INT);
            $prep->execute();
            $result = $prep->fetch();
            return $result;
        }
        catch ( Exception $e ) {
            echo "Erreur methode readUnPseudo : ", $e->getMessage();
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
        //doit vérifier que le token est bien là
        //ca vérifie qu'il est bien passé par le adfly
        //verifie aussi que xp == 100

        if ($_SESSION['xp']==100) {
            //initialise la session
            $_SESSION['xp'] = 0;
            $_SESSION['lvl'] += 1;

            //save dans la bdd le gain de niveau
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


            //--gère les événements lors d'un gain de niveau
            //Tout les niveaux, l'user gagne un ticket pour les jeux
            $requete = "UPDATE account SET ticketWhoIsShe = ticketWhoIsShe + 1 WHERE pseudo='"
                    . $_SESSION['pseudo'] . "';";
            $result = $this->db->exec($requete);

            if ($_SESSION['lvl']==10){
                //recupere le parrain et lui donne +10 lvl et +10 ticket
                $requete="SELECT sponsor
                FROM account
                WHERE pseudo = '".$_SESSION['pseudo']."';";
                $select = $this->db->query($requete);
                $resultSponsor = $select->fetch();

                if (!empty($resultSponsor['sponsor'])) {
                    $requete = "UPDATE account SET ticketWhoIsShe = ticketWhoIsShe + 10, lvl = lvl + 10 WHERE pseudo='"
                        . $resultSponsor['sponsor'] . "';";
                    $result = $this->db->exec($requete);
                }
            }


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

        //enleve le token
        $_SESSION['token']=false;
    }


}
