<?php
/**
 * Created by PhpStorm.
 * User: sakalypse
 * Date: 30/12/16
 * Time: 23:48
 */
?>

<div class="divText">
    <h1>Who is she ?</h1>
    <p>You will have 30 seconds to tell who are the 10 girls in the following pictures</p>
    <p><em>Ready ?</em></p>
    <form style="text-align: center" method="post" action="<?php echo BASE_URL; ?>index.php/play/whoIsShePlay">
        <input name="tockenFun"  type="hidden" value="fun"/>

        <input id="submit" type="submit" name="ready" value="GO !" />

    </form>
</div>