<?php
class Produit
{
    private $instanceModelProduit;

    public function __construct(){
        include("models/account_m.php");
        //$this->instanceModelProduit = new account_m();

    }

    public function index()  
    {
        include("views/v_head.php");
        include('views/v_menu.php');
        include("views/v_foot.php");
    }
    public function afficherProduits()  
    {

        include("views/v_head.php");
        include('views/v_menu.php');
        $data=$this->instanceModelProduit->getAllProduits();
        include("views/v_table_produit.php");
        include("views/v_foot.php");
    }
    public function creerAccount()  
    {
        include("views/v_head.php");
        include('views/v_menu.php');
        include('views/v_form_create_account.twig');
        include("views/v_foot.php");
    }

    public function validFormCreerAccount()
    {
        $donnees['pseudo']=htmlentities($_POST['pseudo']);
        $donnees['mdp']=htmlentities($_POST['mdp']);
        $this->instanceModelProduit->insertUnCompte($donnees);
        header("Location: ".BASE_URL."index.php/");
    }

    public function supprimerProduit($id='')  
    {
        $this->instanceModelProduit->deleteUnProduit($id);
        header("Location: ".BASE_URL."index.php/Produit/afficherProduits");
    }


    public function modifierProduit($id='')
    {
        include("views/v_head.php");
        include("views/v_menu.php");
        $donnees=$this->instanceModelProduit->readUnProduit($id);
        include("views/v_form_update_produit.twig");
        include("views/v_foot.php");
    }
    public function validFormModifierProduit()  
    {
        $id=htmlentities($_POST['id']); // htmlentities
        $donnees['nom']=htmlentities($_POST['nom']); // evite injection js ...
        $donnees['typeProduit_id']=htmlentities($_POST['typeProduit_id']);
        $donnees['prix']=htmlentities($_POST['prix']);
        $donnees['photo']=htmlentities($_POST['photo']);

        $donnees=$this->instanceModelProduit->updateUnProduit($id,$donnees);
        header("Location: ".BASE_URL."index.php/Produit/afficherProduits");
    }

} 

