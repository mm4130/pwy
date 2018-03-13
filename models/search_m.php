<?php

class search_m{

    private $db;

    public function __construct(){
        $MaConnexion = new Connexion();
        $this->db = $MaConnexion->connect();
    }

    function getAllProduits(){
        $requete="SELECT p.id, t.libelle, p.nom, p.prix, p.photo
        FROM produits as p,typeProduits as t
        WHERE p.typeProduit_id=t.id ORDER BY p.nom;";
        $select = $this->db->query($requete);
        $results = $select->fetchAll();
        return $results;
    }

    function insertUnProduit($donnees){
        // $requete="INSERT INTO produits (id,nom,typeProduit_id,prix,photo) VALUES
        // (NULL,'".$donnees['nom']."',".$donnees['typeProduit_id'].",'".$donnees['prix']."','".$donnees['photo']."');";
        // $nbRes = $this->db->exec($requete);

        $requete="INSERT INTO produits (typeProduit_id,nom,prix,photo) VALUES (:idType,:nom,:prix,:photo);";
        try {
            $prep=$this->db->prepare($requete);
            $prep->bindParam(':idType',$donnees['typeProduit_id'],PDO::PARAM_INT);
            $prep->bindParam(':nom',$donnees['nom'],PDO::PARAM_STR,25);
            $prep->bindParam(':prix',$donnees['prix'],PDO::PARAM_STR);
            $prep->bindParam(':photo',$donnees['photo'],PDO::PARAM_STR);
            $prep->execute();

        }
        catch ( Exception $e ) {
            echo "Erreur methode insertUnProduit : ", $e->getMessage();
        }
    }

    function deleteUnProduit($id){
        $requete="DELETE
        FROM produits WHERE id=".$id." LIMIT 1;";
        try {
            $nbRes = $this->db->exec($requete);
            return $nbRes;
        }
        catch ( Exception $e ) {
            echo "Erreur methode readUnProduit : ", $e->getMessage();
        }
    }

    function readUnProduit($id){
        /*$requete="SELECT id,typeProduit_id,nom,prix,photo
        FROM produits WHERE id=".$id." LIMIT 1;";*/
        $requete="SELECT id,typeProduit_id,nom,prix,photo
        FROM produits WHERE id=:id LIMIT 1;";
        try {
            /*$select = $this->db->query($requete);
            $result = $select->fetchAll();
            return $result[0];*/
            $prep=$this->db->prepare($requete);
            $prep->bindParam(':id',$id,PDO::PARAM_INT);
            $prep->execute();
            $result = $prep->fetch();
            return $result;
        }
        catch ( Exception $e ) {
            echo "Erreur methode readUnProduit : ", $e->getMessage();
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
}
