<?php session_start();
class mission
{
    private $instanceModelMission;

    public function __construct(){
        include("models/mission_m.php");
        $this->instanceModelMission = new mission_m();

        //twig
        require_once('vendor/autoload.php');
        $path = dirname(__FILE__).'/../views/';
        $loader = new Twig_Loader_Filesystem($path);
        $this->instanceVueTwig = new Twig_Environment($loader, array('cache' => false));
    }

    public function index()
    {
        include("views/v_head.php");
        include('views/v_menu.php');
        include("views/v_profil.php");
        include("views/v_foot.php");
    }

    public function createAccount()
    {
        include("views/v_head.php");
        include('views/v_menu.php');
        $template = $this->instanceVueTwig->loadTemplate('v_form_create_account.twig');
        echo $template->render(array('donnees'=>null,'erreurs'=>null,  'path'=>BASE_URL));
        include("views/v_foot.php");
    }

    public function validFormCreateAccount()
    {
        $donnees['pseudo']=htmlentities($_POST['pseudo']);
        $donnees['mdp']=htmlentities($_POST['mdp']);
        $donnees['mdpConfirm']=htmlentities($_POST['mdpConfirm']);

        if (!preg_match("/[A-Za-z0-9]{2,}/",$donnees['pseudo']))
            $erreurs['pseudo']='The pseudo must be composed with at least 2 letters or numbers.';
        if (!preg_match("/[A-Za-z0-9]{2,}/",$donnees['mdp']))
            $erreurs['mdp']='The password must be composed with at least 6 letters or numbers.';
        if($donnees['mdp']!=$donnees['mdpConfirm']){
            $erreurs['mdpConfirm']='The password must be the same.';
        }

        //verifie que le pseudo est libre
        //fais une recherche sql du pseudo -> si retourne rien, pseudo libre
        $donneesBdd = $this->instanceModelAccount->readUnPseudo($donnees['pseudo']);
        if ($donneesBdd!=null) {
            $erreurs['pseudo'] = "This pseudo is already used, please choose another one.";
        }

        if (!empty($erreurs)) {
            include("views/v_head.php");
            include('views/v_menu.php');

            $template = $this->instanceVueTwig->loadTemplate('v_form_create_account.twig');
            echo $template->render(array('donnees' => $donnees, 'erreurs' => $erreurs, 'path' => BASE_URL));
            include("views/v_foot.php");
        } else {
            //hachage du mdp
            $donnees['mdp'] = sha1($donnees['mdp']);

            $this->instanceModelAccount->insertAccount($donnees);
            header("Location: " . BASE_URL . "index.php/");
        }
    }

    public function login()
    {
        include("views/v_head.php");
        include('views/v_menu.php');
        $template = $this->instanceVueTwig->loadTemplate('v_form_login_account.twig');
        echo $template->render(array('donnees'=>null,'erreurs'=>null,'path'=>BASE_URL));
        include("views/v_foot.php");
    }

    public function validFormLogin()
    {
        $donnees['pseudo']=htmlentities($_POST['pseudo']);
        $donnees['mdp']=htmlentities($_POST['mdp']);
        //recherche dans la bdd le pseudo
        $donneesBdd = $this->instanceModelAccount->readUnPseudo($donnees['pseudo']);

        if ($donneesBdd!=null){
            //hachage du mdp
            $donnees['mdp'] = sha1($donnees['mdp']);

            if ($donneesBdd['mdp'] == $donnees['mdp']) {
                //lance la session de l'utilisateur
                $_SESSION['pseudo'] = $donneesBdd['pseudo'];
                $_SESSION['lvl'] = $donneesBdd['lvl'];
                $_SESSION['xp'] = $donneesBdd['xp'];

                $_SESSION['connected'] = true;
            }
            else{
                $erreurLogin['mdp'] = "Wrong password";
            }
        }
        else{
            $erreurLogin['pseudo'] = "Login does not exist";
        }

        if (!empty($erreurLogin)){
            include("views/v_head.php");
            include('views/v_menu.php');
            $template = $this->instanceVueTwig->loadTemplate('v_form_login_account.twig');
            echo $template->render(array('donnees'=>$donnees,'erreurs'=>$erreurLogin,'path'=>BASE_URL));;
            include("views/v_foot.php");
        }
        else {
            header("Location: " . BASE_URL . "index.php/");
        }
    }


    public function supprimerProduit($id='')
    {
        $this->instanceModelAccount->deleteUnProduit($id);
        header("Location: ".BASE_URL."index.php/Produit/afficherProduits");
    }

    public function destroySession(){
        session_destroy();
        header("Location: ".BASE_URL."index.php/");
    }

}

