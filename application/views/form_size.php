<?php echo validation_errors(); ?>
<?php echo form_open('products/ajout_taille'); ?>
<br>
<br>
<h4>Saisissez les nouvelleas tailles que vous voulez ajouter pour ce type de produit</h4>
	<p> </p>
	 <div class="form-group">
    <input type="text" class="form-control" id="mail" name="nouv_taille" placeholder="Nouvelle Taille">
  </div>
  
  <button type="submit" class="btn btn-success">Submit</button>
</form>