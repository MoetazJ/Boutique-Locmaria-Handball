<h2>Détails de la commande numéro <?php echo $order_id; ?></h2>
<p><br></p>
<?php
$prix = 0;
$total = 0;
if ($details_commande != NULL):
?>
    <table style="border-collapse: collapse; width: 100%; margin-top: 20px; margin-bottom: 20px;">
        <thead>
            <tr>
                <th>Variant</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Prix total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($details_commande as $details): ?>
                <tr>
                    <td>
                        <?php
                        $data['variant'] = $this->db_model->get_variant_details($details['variant_id']);
                        $data['autre'] = $this->db_model->get_autre_variants_details($details['autre_id']);
                        if ($data['variant'] != NULL) {
                            echo $data['variant']->pdt_nom;
                            $prix = $data['variant']->price;
                        } elseif ($data['autre'] != NULL) {
                            echo $data['autre']->pdt_nom;
                            $prix = $data['autre']->prix;
                        }
                        ?>
                    </td>
                    <td><?php echo $details['quantity']; ?></td>
                    <td><?php echo $prix; ?></td>
                    <td><?php
                        $prix_total = $prix * $details['quantity'];
                        echo $prix_total; echo "€";
                        $total += $prix_total;
                        ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p>Prix total de la commande : <?php echo $total; ?> €</p>
<?php else: ?>
    <p>Aucun variant n'a été trouvé.</p>
<?php endif; ?>
