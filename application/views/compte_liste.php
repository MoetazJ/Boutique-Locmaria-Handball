<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 120vh;">
    <h1><?php echo $titre;?></h1>
    <div style="margin-top: 30px;">
        <?php if($cpts != NULL) {?>
            <table style="border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid black; padding: 10px;">ID comptes</th>
                        <th style="border: 1px solid black; padding: 10px;">Emails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($cpts as $login) {?>
                    	<tr>
                            <td style="border: 1px solid black; padding: 10px;"><?php echo $login["cpt_id"]; ?></td>
                            <td style="border: 1px solid black; padding: 10px;"><?php echo $login["cpt_mail"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else {?>
            <p>Aucun compte !</p>
        <?php }?>
    </div>
</div>
