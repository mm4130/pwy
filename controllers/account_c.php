<?php session_start();
class account
{
    private $instanceModelAccount;

    public function __construct(){
        include("models/account_m.php");
        $this->instanceModelAccount = new account_m();

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
        include("views/v_foot.php");
    }


    public function isRecaptchaValid($code, $ip = NULL)
    {
        if (empty($code)) {
            return false; // Si aucun code n'est entré, on ne cherche pas plus loin
        }
        $params = [
            'secret'    => '6Ldv8kwUAAAAALgagGacxyy9B4iUZdD2D1NisMDd',
            'response'  => $code
        ];
        if( $ip ){
            $params['remoteip'] = $ip;
        }
        $url = "https://www.google.com/recaptcha/api/siteverify?" . http_build_query($params);
        if (function_exists('curl_version')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Evite les problèmes, si le ser
            $response = curl_exec($curl);
        } else {
            // Si curl n'est pas dispo, un bon vieux file_get_contents
            $response = file_get_contents($url);
        }

        if (empty($response) || is_null($response)) {
            return false;
        }

        $json = json_decode($response);
        return $json->success;
    }

    
    public function createAccount($s='')
    {
        include("views/v_head.php");
        include('views/v_menu.php');

        $donnees['s'] = htmlentities($s);

        $template = $this->instanceVueTwig->loadTemplate('v_form_create_account.twig');
        echo $template->render(array('donnees'=>$donnees,'erreurs'=>null, 'path'=>BASE_URL));
        include("views/v_foot.php");
    }

    public function validFormCreateAccount()
    {
        $donnees['pseudo']=htmlentities($_POST['pseudo']);
        $donnees['mdp']=htmlentities($_POST['mdp']);
        $donnees['mdpConfirm']=htmlentities($_POST['mdpConfirm']);
        //if sponsor
        $donnees['s']=htmlentities($_POST['s']);

        if (!preg_match("/[A-Za-z0-9]{2,}/",$donnees['pseudo']))
            $erreurs['pseudo']='The pseudo must be composed with at least 2 letters or numbers.';
        if (!preg_match("/[A-Za-z0-9]{2,}/",$donnees['mdp']))
            $erreurs['mdp']='The password must be composed with at least 6 letters or numbers.';
        if($donnees['mdp']!=$donnees['mdpConfirm']){
            $erreurs['mdpConfirm']='The password must be the same.';
        }

        //verifie que le pseudo est libre
        //fais une recherche sql du pseudo -> si retourne rien, pseudo libre
        $donneesBdd = "";
        $donneesBdd = $this->instanceModelAccount->readUnPseudo($donnees['pseudo']);
        if ($donneesBdd!="") {
            $erreurs['pseudo'] = "This pseudo is already used, please choose another one.";
        }

        if (!empty($erreurs) || !$this->isRecaptchaValid($_POST['g-recaptcha-response'])) {
            include("views/v_head.php");
            include('views/v_menu.php');

            $template = $this->instanceVueTwig->loadTemplate('v_form_create_account.twig');
            echo $template->render(array('donnees' => $donnees, 'erreurs' => $erreurs, 'path' => BASE_URL));
            include("views/v_foot.php");
        } else {
            //on créer le compte

            //hachage du mdp
            $donnees['mdp'] = sha1($donnees['mdp']);


            //include
            include("models/mission_m.php");
            $instanceControlMission = new mission_m();
            //Genere la premiere mission
            $donnees['mission'] = $instanceControlMission->generateMission();
            $donnees['missionRecompense'] = $instanceControlMission->generateMissionRecompense();
            
            $this->instanceModelAccount->insertAccount($donnees);

            //on login tout de suite
                //on recupere les infos de la bdd
            $donneesBdd = $this->instanceModelAccount->readUnPseudo($donnees['pseudo']);

            $_SESSION['pseudo'] = $donneesBdd['pseudo'];
            $_SESSION['lvl'] = $donneesBdd['lvl'];
            $_SESSION['xp'] = $donneesBdd['xp'];
            $_SESSION['mission'] = $donneesBdd['mission'];
            $_SESSION['missionRecompense'] = $donneesBdd['missionRecompense'];
            $_SESSION['connected'] = true;

            //et on redirige vers l'index
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
                $_SESSION['mission'] = $donneesBdd['mission'];
                $_SESSION['missionRecompense'] = $donneesBdd['missionRecompense'];

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
            header("Location: " . BASE_URL . "index.php/search/index");
        }
    }

    public function gagnerUnNiveau(){
        if ($_SESSION['xp'] == 100 && $_SESSION['pseudo'] != "Guest") {
            $this->instanceModelAccount->gagneUnNiveau();
        }
        else{
            header('Location: '.BASE_URL.'index.php/profil/');
        }
    }

    public function destroySession(){
        session_destroy();
        header("Location: ".BASE_URL."index.php/search/index");
    }
}

