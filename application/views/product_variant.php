<h2>Variants du <?php echo $pdt_nom->pdt_nom ?></h2>
<br />

<!--  Search form 
<form method="get" action="<?php //echo base_url('index.php/products/searchVariant'); ?>">
    <div class="form-group">
        <input type="text" name="search" class="form-control" placeholder="Rechercher une couleur, taille, sexe(H/F), ou prix du variant de ce produit">
    </div>
    <button type="submit" class="btn btn-primary">Rechercher</button>
</form> -->

<?php if($variant != NULL): ?>
    <table style="border-collapse: collapse; width: 100%; margin-top: 20px; margin-bottom: 20px;">
        <thead>
            <tr>
                <th>Variant ID</th>
                <th>Couleur</th>
                <?php if($type->type_name == 'Vetements'){ ?>
                <th>Taille Adulte</th>
                <th>Taille Junior</th>
                <th>Sexe</th>

                <?php }else { ?>
                    <th>Taille</th>
                <?php }?>

                <th>Stock</th>
                <th>Prix</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($variant as $vrt): ?>
                <tr>
                    <form method="post" action="<?php echo base_url('index.php/products/modifier_variant/'.$vrt['pdt_id'].'/'.$vrt['variant_id']); ?>">
                        <td><?php echo $vrt['variant_id']; ?></td>
                        <td>
                            <select name="couleur">
                                <?php foreach($couleurs as $clr) : ?>
                                    <option value="<?php echo $clr['color_name'];?>" <?php if ($vrt['color_name'] == $clr['color_name']) echo "selected"; ?>><?php echo $clr['color_name'];?></option>
                                <?php endforeach;?>
                                <option value="Produit sans couleur" <?php if ($vrt['color_name'] === 'Produit sans couleur') echo "selected"; ?>>Produit sans couleur</option>
                            </select>
                        </td>
                        <?php if ($type->type_name == 'Vetements'){?>
                        <td>
                            <select class="form-control" name="taille" <?php if(empty($vrt['size_name'])) echo 'disabled="disabled"';?>>
                                <?php foreach($sizes as $size) : ?> 
                                    <?php if ($size['size_name'] == $vrt['size_name']) : ?>
                                        <option value="<?php echo $size['size_name'];?>" selected="selected"><?php echo $vrt['size_name'];?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $size['size_name'];?>"><?php echo $size['size_name'];?></option>
                                    <?php endif; ?>
                                <?php endforeach;?>
                                <?php if(empty($vrt['size_name'])) : ?>
                                    <option value="" selected="selected">--</option>
                                <?php endif; ?>
                            </select>
                        </td>
                         <td>

                            <select class="form-control" name="taillejr" <?php if($vrt['sizejr_name'] =="" || $vrt['sizejr_name'] == 'NULL') echo 'disabled="disabled"'; ?>>
                                <?php foreach($sizes as $size) : ?> 
                                    <?php if ($size['size_name'] == $vrt['sizejr_name']) : ?>
                                        <option value="<?php echo $size['size_name'];?>" selected="selected"><?php echo $size['size_name'];?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $size['size_name'];?>"><?php echo $size['size_name'];?></option>
                                    <?php endif; ?>
                                <?php endforeach;?>
                                <?php if($vrt['sizejr_name'] =="" || $vrt['sizejr_name'] == 'NULL') : ?>
                                    <option value="" selected="selected">--</option>
                                <?php endif; ?>
                            </select>
                        </td>

                     <td>
                            <select name="sexe">
                                <option value="H" <?php if ($vrt['sexe'] === 'H') echo 'selected'; ?>>Homme</option>
                                <option value="F" <?php if ($vrt['sexe'] === 'F') echo 'selected'; ?>>Femme</option>
                                <option value="F" <?php if ($vrt['sexe'] === 'H/F') echo 'selected'; ?>>H/F</option>

                            </select>
                    </td>
                    <?php }else{?>
                        <td>

                            <select class="form-control" name="taillejr" <?php if($vrt['sizejr_name'] =="" || $vrt['sizejr_name'] == 'NULL') echo 'disabled="disabled"'; ?>>
                                <?php foreach($sizes as $size) : ?> 
                                    <?php if ($size['size_name'] == $vrt['sizejr_name']) : ?>
                                        <option value="<?php echo $size['size_name'];?>" selected="selected"><?php echo $size['size_name'];?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $size['size_name'];?>"><?php echo $size['size_name'];?></option>
                                    <?php endif; ?>
                                <?php endforeach;?>
                                <?php if($vrt['sizejr_name'] =="" || $vrt['sizejr_name'] == 'NULL') : ?>
                                    <option value="" selected="selected">--</option>
                                <?php endif; ?>
                            </select>
                        </td>

                    <?php }?>
                        

                    <td><input type="text" name="stock" value="<?php echo $vrt['stock']; ?>"></td>
                    <td><input type="text" name="price" value="<?php echo $vrt['price']; ?>"></td>


                        <td><button type="submit" class="btn btn-modifier">Modifier</button>
                            <!-- <a href="<?php //echo base_url('index.php/products/supprimer_variant/'.$vrt['variant_id']); ?>" class="btn btn-supprimer">Supprimer</a> -->
                        </td>
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
    <label>Couleur :</label>
    <select class="form-control" name="couleur">
        <?php foreach($couleurs as $clr) : ?>
            <option value="<?php echo $clr['color_name'];?>"><?php echo $clr['color_name'];?></option>
        <?php endforeach;?>
        <option value="Produit sans couleur">Produit sans couleur</option>
    </select>
</div>
<?php if ($type->type_name == 'Vetements'){


?>
<div class="form-group">
    <label>Produit enfants ou adultes : </label>
    <select class="form-control" name="choix">
        <option value="adulte">Taille Adulte</option>
        <option value="junior">Taille Junior</option>
    </select>
</div>

<div class="form-group">
    <label>Sexe :</label>
    <select class="form-control" name="sexe">
        <option value="H">Homme</option>
        <option value="F">Femme</option>
        <option value="HF">HF</option>
    </select>
</div>
<?php } ?>

<div class="form-group">
    <label>Taille</label>
    <select class="form-control" name="taille">
        <?php foreach($sizes as $size) : ?>
            <option value="<?php echo $size['size_name'];?>"><?php echo $size['size_name'];?></option>
        <?php endforeach;?>
        <option value="Produit sans taille">Produit sans taille</option>
    </select>
</div>



<div class="form-group">
    <label>Stock : </label>
    <input type="number" class="form-control" name="stock" placeholder="Stock" required>
</div>
<div class="form-group">
    <label>Prix du nouveau variant : </label>
    <input type="number" class="form-control" name="price" placeholder="Price" required>
</div>

<div>
    <button type="submit" class="btn btn-success">Ajouter le produit</button>
</div>
</form>
