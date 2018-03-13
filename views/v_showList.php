<?php
if ($infoVideos['message']=="No Videos found!"){
    echo"<p>Sorry, No videos founds</p>";
}
$j=0;
foreach($infoVideos['videos'] as $msg) { ?>
<?php $j++; ?>
<form id="watchit<?php echo $j; ?>" method="post" action="<?php echo BASE_URL; ?>index.php/search/watch/<?php echo $msg['video_id'];?>">
    <input type="hidden" name="name" value="<?php echo $name; ?>"/>
    <input type="hidden" name="page" value="<?php echo $page; ?>"/>
</form>
<div class='divPostVideo'><a href="#" onclick="document.getElementById('watchit<?php echo $j; ?>').submit()">
        <div id="divImage">
            <img src=" <?= $msg['default_thumb'] ?> " alt = "thumb"
                 onmouseover="this.src='<?= $msg['thumbs'][2]['src'] ?>';"
                 onmouseover="this.src='<?= $msg['thumbs'][3]['src'] ?>';"
                 onmouseout="this.src='<?= $msg['default_thumb'] ?>';">
        </div>
        <?php echo "" . $msg['title'] . "</br>" . $msg['duration'] . " min";
    echo "</a></div>";
}

if ($boolSearch == true){
    if ($page>1) {
        $pagePrev = $page - 1;
    }
    else{
        $pagePrev = $page;
    }
    $pageNext = $page+1; ?>
    
<div class="divContainerButtonPrevNext" style="margin-top: 10px; margin-bottom: 10px;">
    <form style="width: 330px;" action="<?= BASE_URL ?>index.php/search/searchName/<?= $pagePrev ?>" method="post">
        <input name="name" type="hidden" value="<?= $name ?>">
        <input class="buttonPrev" type="image" border="0" value="submit"
               heigth="100" width="100" align="middle" alt="prev" src="<?php echo BASE_URL?>images/prev.png">
    </form>

    <form style="width: 330px;" action="<?= BASE_URL ?>index.php/search/searchName/<?= $pageNext ?>" method="post">
        <input name="name" type="hidden" value="<?= $name ?>">
        <input class="buttonNext" type="image" border="0" value="submit"
               heigth="100" width="100" align="middle" alt="next" src="<?php echo BASE_URL?>images/next.png">
    </form>
</div>
    
<?php }
else if ($boolVideoRandom==true){ ?>
    <div class="divContainerButtonPrevNext">
        <form style="width: 330px;" action="<?= BASE_URL ?>index.php/search/index/" method="post">
            <input class="buttonNext" style="margin-left:45%;" type="image" border="0" value="submit"
                   heigth="100" width="100" align="middle" alt="next" src="<?php echo BASE_URL?>images/next.png">
        </form>
    </div>
<?php } ?>


