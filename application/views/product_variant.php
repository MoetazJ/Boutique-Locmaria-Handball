<h2>Variants du <?php echo $pdt_nom->pdt_nom ?></h2>
<br />

<?php if($variant != NULL): ?>
	<table style="border-collapse: collapse; width: 100%; margin-top: 20px; margin-bottom: 20px;">
		<thead>
			<tr>
				<th>Variant ID</th>
				<th>Couleur             </th>
				<th>Taille Adulte</th>
				<th>Taille Junior</th>

                <th>Stock</th>
                <th>Prix</th>
                <th>Action</th>

			</tr>
		</thead>
		<tbody>
			<?php foreach($variant as $vrt): ?>

				<tr>
					<form method="post" action="<?php echo base_url('index.php/products/modifier_variant/'.$vrt['pdt_id'].'/'.$vrt['variant_id']); ?>">


                    <td><?php echo $vrt['variant_id']; ?></a></td>
                    <td><input type="text" name="couleur" value="<?php echo $vrt['color_name']; ?>"></td>

                    <td><input type="text" name="taille" value="<?php echo $vrt['size_name']; ?>" <?php if(!empty($vrt['sizejr_name'])) echo "readonly"; ?>></td>

                    <td><input type="text" name="taillejr" value="<?php echo $vrt['sizejr_name']; ?>" <?php if(!empty($vrt['size_name'])) echo "readonly"; ?>></td>
                    <td><input type="text" name="stock" value="<?php echo $vrt['stock']; ?>"></td>
                    <td><input type="text" name="price" value="<?php echo $vrt['price']; ?>"></td>
                    <td><button type="submit"  class="btn btn-modifier">Modifier</button></td>                         
                    </form>
				</tr>
			<?php endforeach; ?>

		</tbody>
	</table>
<?php else: ?>
	<p>Aucun variant pour ce produit n'a été trouvée.</p>
<?php endif; ?>

<?php
//  	echo validation_errors();      
  	echo form_open('products/ajout_variant/'.$pdt_id);
        
?>
<br>
<h4>Ajouter un variant pour <?php echo $pdt_nom->pdt_nom ?> </h4>
<br>
	<div class="form-group">
        
        <input type="text" name="couleur" class="form-control" placeholder="Couleur" required>
    </div>
   
    <div class="form-group">
    <select class="form-control" name="choix">
      <option value="adulte">Taille Adulte</option>
      <option value="junior">Taille Junior</option>
    </select>
  	</div>

  	<div class="form-group">
  		    <select class="form-control" name="taille">
  		        <option value="S">S</option>
		      	<option value="M">M</option>
		      	<option value="L">L</option>

		    </select>
    </div>

    <div class="form-group">
        <input type="number" class="form-control" name="stock" placeholder="Stock" required>
    </div>
     <div class="form-group">
        <input type="number" class="form-control" name="price" placeholder="Price" required>
    </div>
   
    <div>
  	<button type="submit" class="btn btn-success">Ajouter le produit</button>
    </div>
</form>
