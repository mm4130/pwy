<div class="divText">
    <table align="center">
        <?php if ($titreRank=="Rank by level"){?>
        <caption><?php echo $titreRank; ?></caption>
        <thead>
            <tr><th>Number</th><th>Username</th><th>Level</th>
        </thead>
        <tbody>

        <?php foreach($donnees as $user) { ?>
        <tr>
            <td><?php echo $user['numero'] ?></td>
            <td><?php echo $user['pseudo'] ?></td>
            <td><?php echo $user['lvl'] ?></td>
        </tr>
        <?php } ?>
        </tbody>
        <?php }

        elseif ($titreRank=="Rank by the game \"Who is she\""){?>
            <caption><?php echo $titreRank; ?></caption>
            <thead>
            <tr><th>Point</th><th>Username</th>
            </thead>
            <tbody>

            <?php foreach($donnees as $user) { ?>
                <tr>
                    <td><?php echo $user['pointWIS'] ?></td>
                    <td><?php echo $user['pseudo'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        <?php } ?>

    </table>

</div>