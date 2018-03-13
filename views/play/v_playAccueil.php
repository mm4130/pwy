<?php
/**
 * Created by PhpStorm.
 * User: sakalypse
 * Date: 30/12/16
 * Time: 21:01
 */
?>
<div class="divText">
    <h1>Play</h1>
    <p><a href="<?php echo BASE_URL;?>index.php/play/whoIsShe">Play "who is she"</a>
        <br>Ticket : <?php echo $this->instanceModelPlay->getTicketWhosIsShe($_SESSION['pseudo'])['ticketWhoIsShe']; ?>
        <br>(You gain 1 ticket every time you pass a level)</p>
</div>