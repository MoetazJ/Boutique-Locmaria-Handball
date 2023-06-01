<h1>Liste des produits</h1>
<br />

<!-- Search form -->
<form method="get" action="<?php echo base_url('index.php/products/search'); ?>">
    <div class="form-group">
        <input type="text" name="search" class="form-control" placeholder="Rechercher un produit ou un type de produit">
    </div>
    <button type="submit" class="btn btn-primary">Rechercher</button>
</form>

<?php if($pdts != NULL): ?>
    <table style="border-collapse: collapse; width: 100%; margin-top: 20px; margin-bottom: 20px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Type du produit</th>
                <th>Image</th>
                <th>Disponibilite</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($pdts as $pdt): ?>
                <tr>
                    <td><a href="<?php echo base_url('index.php/products/voir_variants/'.$pdt['pdt_id']); ?>"><?php echo $pdt['pdt_id']; ?></a></td>
                    <form method="post" action="<?php echo base_url('index.php/products/modifier_pdt/'.$pdt['pdt_id']); ?>">
                        <td><input type="text" name="nom" value="<?php echo $pdt['pdt_nom']; ?>"></td>
                        <td>
                            <select name="type">
                                <?php foreach ($product_types as $product_type) { ?>
                                    <option value="<?php echo $product_type['type_name']; ?>" <?php if ($pdt['type_name'] == $product_type['type_name']) echo 'selected'; ?>>
                                        <?php echo $product_type['type_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input type="text" name="img" value="<?php echo $pdt['pdt_img']; ?>"></td>
                        <td>
                            <select name="dispo">
                                <option value="D" <?php if ($pdt['pdt_dispo'] == 'D') echo 'selected'; ?>>Disponible</option>
                                <option value="N" <?php if ($pdt['pdt_dispo'] == 'N') echo 'selected'; ?>>Non disponible</option>
                            </select>
                            <button type="submit" class="btn btn-modifier">Modifier</button>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucun produit n'a été trouvé.</p>
<?php endif; ?>

<?php
    echo validation_errors();
    echo form_open('products/ajout');
?>

<br>
<h4>Ajouter un produit</h4>
<br>
<div class="form-group">
    <label>Nom du produit :</label>
    <input type="text" name="nom" class="form-control" placeholder="Exemple : Survetement Hummel H/F" required>
</div>
<div class="form-group">
    <label>Description : </label>
    <textarea name="description" class="form-control" placeholder="Decrivez le produit en quelques phrases" required></textarea>
</div>
<br>
<div class="form-group">
        <label for="exampleFormControlSelect1">Type du produit :</label>

    <select class="form-control" name="type">
        <?php foreach ($product_types as $product_type) { ?>
            <option value="<?php echo $product_type['type_name']; ?>"><?php echo $product_type['type_name']; ?></option>
        <?php } ?>
    </select>
</div>
<div class="form-group">
    <label>Nom de l'image :</label>
    <input type="text" class="form-control" name="img" placeholder="Exemple : survetement.png" required>
</div>
<div class="form-group">
    <label for="exampleFormControlSelect1">Disponibilite (D pour disponible et N pour non disponible)</label>
    <select class="form-control" name="dispo">
        <option value="D">Disponible</option>
        <option value="N">Non disponible</option>
    </select>
</div>
<div>
    <button type="submit" class="btn btn-success">Ajouter le produit</button>
</div>
</form>
