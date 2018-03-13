<?php
//bouton retour
$lien = BASE_URL."index.php";
if (empty($_POST['page']) or empty($_POST['name'])){
    $lien = BASE_URL."index.php/search/";
}
else{
    $lien = BASE_URL."index.php/search/searchName/".$_POST['page'];
}
?>

    <form id="name" method="post" action="<?php echo $lien; ?>">
        <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>"/>
    </form>
    <a style="text-align: center;
     color:white;
     margin:10px;" href='#' onclick='document.getElementById("name").submit()'>
        <img src="<?php echo BASE_URL?>images/prev.png" heigth="50" width="50" alt="previous">Back</a>

<?php

//afficher la video
//echo $embededVideo['embed']['code'];
$lol = "" . $embededVideo['embed']['code'] . "";
$mdr = htmlentities($lol);
$ptdr = str_replace('&quot;', '"', $lol);
$ptdr = str_replace('&lt;', '<', $ptdr);
$ptdr = str_replace('&gt;', '>', $ptdr);
echo '<p style="text-align : center; padding-top: 10px;">'.$ptdr.'</p>';
echo '<p style="text-align : center;">If the video freeze after skipping it : press "space"</p>';
?>