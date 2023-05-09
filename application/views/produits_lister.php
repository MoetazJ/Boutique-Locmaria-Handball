<h1>Liste des produits</h1>
<br />

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

                    <td><input type="text" name="type" value="<?php echo $pdt['pdt_type']; ?>"></td>
                    <td><input type="text" name="img" value="<?php echo $pdt['pdt_img']; ?>"></td>
                    <td>
                            <select name="dispo">
                                <option value="D" <?php if ($pdt['pdt_dispo'] == 'D') echo 'selected'; ?>>Disponible</option>
                                <option value="N" <?php if ($pdt['pdt_dispo'] == 'N') echo 'selected'; ?>>Non disponible</option>
                            </select>
                            <button type="submit"  class="btn btn-modifier">Modifier</button>
                        </form>
                    </td>

					<!--<td><a href="<?php //echo base_url('index.php/compte/supprimer_pdt/'.$pdt['pdt_id']); ?> ">Supprimer</a></td> -->
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<p>Aucun produits n'a été trouvée.</p>
<?php endif; ?>

<?php
  	echo validation_errors();      

  	echo form_open('compte/ajout');
        
?>
<br>
<h4>Ajouter un produit</h4>
<br>
<div class="form-group">
        
        <input type="text" name="nom" class="form-control" placeholder="Nom du produit" required>
    </div>
    <div class="form-group">
        <textarea name="description" class="form-control"  placeholder="Description" required></textarea>
    </div>
    <br>
    
    <div class="form-group">
        <input type="text" class="form-control" min="0" name="type" placeholder="Type du produit" required>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" min="0" name="img" placeholder="Image" required>
    </div>
    
    <div class="form-group">
    	<label for="exampleFormControlSelect1">Disponibilite(D pour disponible et N pour non disponible)</label>
    <select class="form-control" id="exampleFormControlSelect1">
      <option>D</option>
      <option>N</option>
    
    </select>
  </div>
    <div>
  <button type="submit" class="btn btn-success">Ajouter le produit</button>
    </div>
</form>

