<h1>Listes des produits</h1>
<br />

<?php if($pdts != NULL): ?>
	<table style="border-collapse: collapse; width: 100%; margin-top: 20px; margin-bottom: 20px;">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nom</th>
				<th>Prix adulte</th>
				<th>Prix junior</th>
				<th>Type du produit</th>
				<th>Image</th>

				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($pdts as $pdt): ?>
				<tr>
					<td><?php echo $pdt['pdt_id']; ?></td>
					<td><?php echo $pdt['pdt_nom']; ?></td>
					<td><?php echo $pdt['pdt_prix']; ?></td>
					<td><?php echo $pdt['pdt_prixjr']; ?></td>
					<td><?php echo $pdt['pdt_type']; ?></td>
					<td><?php echo $pdt['pdt_img']; ?></td>

					<td><a href="<?php echo base_url('index.php/compte/supprimer_pdt/'.$pdt['pdt_id']); ?>">Supprimer</a></td> 
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
        <input type="number" class="form-control" step="1" min="0" name="prix" placeholder="Prix adulte" required>
    </div>
        <div class="form-group">
        <input type="number" class="form-control" step="1" min="0" name="prixjr" placeholder="Prix Junior" required>
    </div>
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

