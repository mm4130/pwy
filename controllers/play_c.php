<?php session_start();
class play
{
    private $instanceModelPlay;

    public function __construct(){
        include("models/play_m.php");
        $this->instanceModelPlay = new play_m();

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
        include("views/play/v_playAccueil.php");
        include("views/v_foot.php");
    }

    public function whoIsShe()
    {
        //vérifie que l'user peut jouer au jeu : si a pas deja joué ajd et si il est pas lvl 10
        $return = $this->instanceModelPlay->getTicketWhosIsShe($_SESSION['pseudo']);
        if ($return['ticketWhoIsShe'] <= 0) {
            header("Location: " . BASE_URL . "index.php/play");
        } else {
            include("views/v_head.php");
            include('views/v_menu.php');
            include("views/play/v_whoIsSheAccueil.php");
            include("views/v_foot.php");
        }
    }

    public function whoIsShePlay(){
        $tocken=1;
        //si le tocken est fun : debut de la partie donc met tout en place
        if ($_POST['tockenFun']=="fun"){
            //met en place le tocken pour le jeu
            $tocken = 0;
            //-1 au ticket
            $this->instanceModelPlay->decrementTicketWhoIsShe($_SESSION['pseudo']);
            //garde en mémoire l'heure du début
            $_SESSION['whoIsSheHeureANePasDepasser'] = mktime(date("H"), date("i"), date("s")+30);
        }

        if ((isset($_POST['tocken']) && ($_POST['tocken'] >= 1 && $_POST['tocken']<9)) || $tocken == 0){
            //---verifie que ce soit la bonne reponse sauf si tocken ==0 puisque pas encore de reponse
            if($tocken != 0 && $_POST['juste']=="false"){
                header("Location: " . BASE_URL . "index.php/play/perduWISFail");
            }
            else {
                //---prepare la prochaine question
                if (isset($_POST['tocken']) && ($_POST['tocken'] >= 1 && $_POST['tocken']<=9)){
                    $token = $_POST['tocken']+1;
                }
                else{
                    $token = 1;
                }

                $toutesStars = $this->instanceModelPlay->getAllStars();
                $nbAlea = rand(0, count($toutesStars) - 1);
                $starChoisi = $toutesStars[$nbAlea];

                //initialise un tableau de nom faux
                for ($i = 0; $i < 3; $i++) {
                    $starTab[$i] = $toutesStars[rand(0, count($toutesStars) - 1)]['nomStar'];
                    while ($starChoisi['nomStar'] == $starTab[$i] || count($starTab)<($i+1)) {
                        $starTab[$i] = $toutesStars[rand(0, count($toutesStars) - 1)]['nomStar'];
                        array_unique($starTab);
                    }
                }

                $starTab[3] = $starChoisi['nomStar'];
                shuffle($starTab);


                include("views/v_head.php");
                include('views/v_menu.php');
                $template = $this->instanceVueTwig->loadTemplate('play/v_whoIsShePlay.twig');
                echo $template->render(array('nomImage' => $starChoisi['nomImage'],
                    'starChoisi' => $starChoisi['nomStar'], 'starTab' => $starTab, 'tocken' => $token, 'path' => BASE_URL));
                include("views/v_foot.php");
            }
        }
        elseif ($_POST['tocken'] == 9){
            //si il arrive a la derniere question :
            //verifie que ce soit la bonne réponse
            if($_POST['juste']!=true){
                header("Location: " . BASE_URL . "index.php/play/perduWISFail");
            }
            else {
                //verifie qu'il n'a pas depassé le temps
                $tempsFin = date('H:i:s');
                if ($_SESSION['whoIsSheHeureANePasDepasser'] <= $tempsFin){
                    header("Location: " . BASE_URL . "index.php/play/perduWISTemps");
                }
                else {
                    //affiche felicitation + incremente de un peu dans le classement de WIS
                    $this->instanceModelPlay->incrementPointRankWIS($_SESSION['pseudo']);

                    include("views/v_head.php");
                    include('views/v_menu.php');
                    include("views/play/v_gagnerWIS.php");
                    include("views/v_foot.php");
                }
            }
        }
        else{
            header("Location: " . BASE_URL . "index.php/play");
        }
    }

    public function perduWISFail(){
        include("views/v_head.php");
        include('views/v_menu.php');
        include("views/play/v_perduWISFail.php");
        include("views/v_foot.php");
    }
    public function perduWISTemps(){
        include("views/v_head.php");
        include('views/v_menu.php');
        include("views/play/v_perduWISTemps.php");
        include("views/v_foot.php");
    }
}

