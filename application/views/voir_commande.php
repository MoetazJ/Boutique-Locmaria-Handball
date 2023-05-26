<h2>Details de la commande numero <?php echo $order_id?> </h2>
<p><br></p>
<?php if($details_commande != NULL): ?>
    <table style="border-collapse: collapse; width: 100%; margin-top: 20px; margin-bottom: 20px;">
        <thead>
            <tr>
                <th>Variant ID</th>
                <th>Plat id</th>
                <th>Quantite</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach($details_commande as $details): ?>
                <tr>
                    <td><?php echo $details['variant_id'] ?></td>
                    <td><?php echo $details['autre_id']; ?></td>
                    <td><?php echo $details['quantity']; ?></td>
                <!--<td><a href="<?php// echo base_url('commande/supprimer/'.$cmd['cmd_id']); ?>">Supprimer</a></td> -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>Aucun variant n'a été trouvée.</p>
<?php endif; ?>
