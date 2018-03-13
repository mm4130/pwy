<div class="divText">
    <h1>Profile</h1>
    <p><a href="<?php echo BASE_URL?>index.php/profil/ranks">Watch ranks</a></p>
    <p>Pseudo : <?php echo $_SESSION['pseudo']; ?></p>
    <p>Level : <?php echo $_SESSION['lvl']; ?></p>
    <p>xp : <?php echo $_SESSION['xp']; ?></p>
    <div style="text-align: center">
        <p style="display: inline;">Referral link :</p><p style="color : #d9534f; display: inline-block" >http://www.play-with-yourself.fr/index.php/account/createAccount/<?php echo $_SESSION['pseudo']; ?></p>
        <p>You'll have a boost of 10 levels and tickets if your sponsored friend reach lvl 10</p>
    </div>
    <?php
        if ($_SESSION['xp'] == 100){ ?>
            <form style="text-align: center" action="<?php echo BASE_URL?>index.php/account/gagnerUnNiveau" METHOD="post">
                <input type="submit" value="Level up !"/>
            </form>
        <?php }
    ?>
</div>

<!-- <?php echo BASE_URL?>index.php/account/prepareGagnerUnNiveau