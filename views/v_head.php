<?php
session_start();

if (!isset($_SESSION['connected']) && $_SESSION['guestConnected'] == false){
  $_SESSION['guestConnected'] = true;
  $_SESSION['pseudo'] = "Guest";
  $_SESSION['lvl'] = 0;
  $_SESSION['xp'] = 0;

  include("models/mission_m.php");
  $instanceControlMission = new mission_m();
  //mission
  $_SESSION['mission'] = $instanceControlMission->generateMission();
  $_SESSION['missionRecompense'] = $instanceControlMission->generateMissionRecompense();
}
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/x-icon" href="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Play With Yourself</title>
    <link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/foundation.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL?>assets/css/style.css">
    <script src="<?php echo BASE_URL?>assets/js/vendor/modernizr.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>


        <!-- tableau responsive -->
      <link type="text/css" media="screen" rel="stylesheet" href="responsive-tables.css" />
      <script type="text/javascript" src="responsive-tables.js"></script>


      <script>
      $( function() {
        $( "#progressbar" ).progressbar({
          value: 37
        });
      } );
    </script>
  </head>
  <body>

<?php //include("v_session_connexion.php"); ?>

