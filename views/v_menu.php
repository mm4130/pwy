<?php
$MaConnexion = new Connexion();
$db = $MaConnexion->connect();
$requete="SELECT pseudo,lvl
        FROM account
        ORDER BY lvl DESC
        LIMIT 1;";
try {
    $prep=$db->prepare($requete);
    $prep->execute();
    $donneesBestFapper = $prep->fetchAll();
}
catch ( Exception $e ) {
    echo "Erreur methode getBestFapper : ", $e->getMessage();
}
?>
<nav class="top-bar" data-topbar role="navigation">
    <ul class="title-area"> 
      <li class="name"> 
        <h1> <a href="<?php echo BASE_URL;?>index.php/search/index">Play With Yourself</a></h1>
      </li> 
      <li class="toggle-topbar menu-icon">
        <a href="#"><span>Menu</span></a>
      </li> 
    </ul> 
    <section class="top-bar-section"> 
      <ul class="left">
        <li class="active"><a href="<?php echo BASE_URL;?>index.php/search/index">Random Videos</a></li>
        <li><form action="<?php echo BASE_URL?>index.php/search/searchName/1" METHOD="post">
              <input name="name" type="text"/></li>
          <li><input type="submit" value="Search"/></form></li>
      </ul> 
      <ul class="right">
          <li><a href="<?php echo BASE_URL;?>index.php/profil/rankLevel" style="color:white;">Best Fapper : <?php
                  echo $donneesBestFapper[0]['pseudo']; ?></a></li>
          <li class="divider"></li>


          <?php
                $lienVersProfil = BASE_URL."index.php/account/createAccount";
                if ($_SESSION['connected'] == true) {
                    $lienVersProfil = BASE_URL."index.php/profil/";
                }
                else{
                    $lienVersProfil =  BASE_URL."index.php/account/createAccount";
                }
          ?>
          <li><a href="<?php echo $lienVersProfil; ?>"><?php echo $_SESSION['pseudo']; ?> lvl <?php echo $_SESSION['lvl']; ?> :
              <div id="myProgress">
                  <div id="myBar" style="width: <?php echo $_SESSION['xp']; ?>%;"></div>
              </div></a>
          </li>

          <?php //si l'user n'est pas connecté -> on affiche les liens d'inscription et de connexion
            if ($_SESSION['connected'] == false){ ?>
                <li class="divider"></li>
                <li><a href="<?php echo BASE_URL; ?>index.php/account/createAccount"
                      >Sign up</a></li>
                  <li class="divider"></li>
                  <li><a href="<?php echo BASE_URL; ?>index.php/account/login"
                      >Login</a></li>

          <?php
            }
            else{ //Sinon on Affiche le lien de deconnexion et les liens de profil?>
                <!-- PLAY -->
                <li class="divider"></li>
                <li class="has-dropdown"><a href="<?php echo BASE_URL?>index.php/play">Play</a>
                    <ul class="dropdown">
                        <li><a href="<?php echo BASE_URL;?>index.php/play/whoIsShe">Who is she ?</a></li>
                        <li><a style="font-style: italic" href="#">More cuming soon !</a></li>
                    </ul>
                </li>
                <!-- MORE -->
                <li class="divider"></li>
                <li class="has-dropdown"><a href="#">More</a>
                    <ul class="dropdown">
                        <li><a href="<?php echo BASE_URL;?>index.php/profil/">Profile</a></li>
                        <li class="has-dropdown"><a href="<?php echo BASE_URL?>index.php/profil/ranks">Ranks</a>
                            <ul class="dropdown">
                                <li><a href="<?php echo BASE_URL;?>index.php/profil/rankLevel">Rank by level</a></li>
                                <li><a href="<?php echo BASE_URL;?>index.php/profil/ranksWIS">Rank by "who is she"</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li><a href="<?php echo BASE_URL; ?>index.php/account/destroySession">Disconnect</a></li>
          <?php } ?>
      </ul>
    </section> 
</nav>

<?php
if ($_SESSION['xp'] == 100){?>
    <a href='<?php echo $lienVersProfil;?>'>
        <div class="barMission">
            <p>Level up !</p>
        </div>
    </a>
<?php }
else if ($_SESSION['mission']!=null) {
    ?>
    <form id="nameMission" method="post" action="<?php echo BASE_URL; ?>index.php/search/searchName/1">
        <input type="hidden" name="name" value="<?php echo $_SESSION['mission']; ?>"/>
    </form>
    <a href='#' onclick='document.getElementById("nameMission").submit()'>
        <div class="barMission"><p>
                <?php
                if (isset($_SESSION['missionVientDetreValide']) && $_SESSION['missionVientDetreValide'] == true) {
                    echo "Congrats ! Now your mission is : ";
                    $_SESSION['missionVientDetreValide'] = false;
                }
                ?>Watch a video with "<?php echo $_SESSION['mission'] ?>" : gain <?= $_SESSION['missionRecompense'] ?>
                xp</p>
        </div>
    </a>
    <?php
}
?>


<?php //TODO : adfly link : http://zo.ee/15071459/iciLeLienDuSite?>