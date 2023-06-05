<h2>Variants du <?php echo $pdt_nom->pdt_nom ?></h2>
<br />

<!--  Search form 
<form method="get" action="<?php //echo base_url('index.php/products/searchVariant'); ?>">
    <div class="form-group">
        <input type="text" name="search" class="form-control" placeholder="Rechercher une couleur, taille, sexe(H/F), ou prix du variant de ce produit">
    </div>
    <button type="submit" class="btn btn-primary">Rechercher</button>
</form> -->

<?php if($variant_food != NULL): ?>
    <table style="border-collapse: collapse; width: 100%; margin-top: 20px; margin-bottom: 20px;">
        <thead>
            <tr>
                <th>Variant ID</th>
                <th>Taille</th>
                <th>Caractere 1</th>
                <th>Caractere 2</th>
                <th>Caractere 3</th>
                <th>Prix</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($variant_food as $vrt): ?>
                <tr>
                    <form method="post" action="<?php echo base_url('index.php/products/modifier_variant/'.$vrt['pdt_id'].'/'.$vrt['autre_id']); ?>">
                        <td><?php echo $vrt['autre_id']; ?></td>
                        <td>
                            <select class="form-control" name="choix">
                                <?php foreach ($sizes as $size): ?>
                                    <?php if ($size['size_name'] == $vrt['size_name']): ?>
                                        <option value="<?php echo $size['size_name']; ?>" selected="selected"><?php echo $size['size_name']; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $size['size_name']; ?>"><?php echo $size['size_name']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </td>

                    <td><input type="text" name="car1" value="<?php echo $vrt['car1']; ?>"></td>
                    <td><input type="text" name="car2" value="<?php echo $vrt['car2']; ?>"></td>
                    <td><input type="text" name="car3" value="<?php echo $vrt['car3']; ?>"></td>
                    <td><input type="number" name="price" value="<?php echo $vrt['prix']; ?>"></td> 

                    <td><button type="submit" class="btn btn-modifier">Modifier</button></td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucun variant pour ce produit n'a été trouvée.</p>
<?php endif; ?>

<?php
echo form_open('products/ajout_variant/'.$pdt_id);
?>
<br>
<h4>Ajouter un variant pour <?php echo $pdt_nom->pdt_nom ?></h4>
<br>



<div class="form-group">
    <select class="form-control" name="choix">

        <option value="G">Grand</option>
        <option value="P">Petit</option>
    </select>
</div>


<div class="form-group">
    <input type="text" class="form-control" name="car1" placeholder="Caractere 1" required>
</div>
<div class="form-group">
    <input type="text" class="form-control" name="car2" placeholder="Caractere 2" required>
</div>

<div class="form-group">
    <input type="text" class="form-control" name="car3" placeholder="Caractere 3" required>
</div>

<div class="form-group">
    <input type="text" class="form-control" name="price" placeholder="Prix" required>
</div>

    <button type="submit" class="btn btn-success">Ajouter le produit</button>
</div>
</form>
