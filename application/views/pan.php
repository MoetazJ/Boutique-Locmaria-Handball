<h1>Panier </h1>

<?php if ($panier != NULL): ?>
    <table style="border-collapse: collapse; width: 100%; margin-top: 20px; margin-bottom: 20px;">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Taille</th>
                <th>Couleur</th>
                <th>Taille</th>
                <th>Prix unitaire</th>
                <th>Quantite</th>
                <th>Prix total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $total = 0;
                foreach ($panier as $item): 
                    $prix_total = $item['price'] * $item['quantity'];
                    $total += $prix_total;
            ?>
                <tr>
                    <td><?php echo $item['cart_id']; ?></td>
                    <td><?php echo $item['variant_id']; ?></td>
                    <td><?php echo $item['color_name']; ?></td>
                    <td><?php echo $item['size_name'] ? $item['size_name'] : $item['sizejr_name']; ?></td>
                    <td><?php echo $item['price']; ?>€</td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $prix_total; ?>€</td>
                    <td>
                        <form action="<?php echo base_url('index.php/products/remove_item'); ?>" method="post">
                            <input type="hidden" name="item_id" value="<?php echo $item['cart_item_id']; ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="5" style="text-align: right;"><strong>Total :</strong></td>
                <td><?php echo $total; ?>€</td>
            </tr>
        </tbody>
    </table>
<?php else: ?>
    <p>Votre panier est vide.</p>
<?php endif; ?>

<style>
    .center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 20vh;
    }
</style>

<div class="center">
    <button onclick="window.location.href = '<?php echo base_url(); ?>index.php/compte/commande';">Commander</button>
</div>

