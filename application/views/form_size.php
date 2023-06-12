<?php echo validation_errors(); ?>
<?php echo form_open('products/ajout_taille'); ?>
<br>
<br>
<h4>Saisissez les nouvelleas tailles que vous voulez ajouter pour ce type de produit. SI vous voulez creer un nouveau <a href="<?php echo base_url()?>index.php/products/form_type">ajouter.</a>
</h4>
	<p> </p>
	 <div class="form-group">
    <input type="text" class="form-control" id="mail" name="nouv_taille" placeholder="Nouvelle Taille">
  </div>

  <div class="form-group">
        <label for="exampleFormControlSelect1">Type du produit :</label>
        <select class="form-control" name="type">
            <?php foreach ($types as $type) { ?>
                <option value="<?php echo $type['type_name']; ?>"><?php echo $type['type_name']; ?></option>
            <?php } ?>
        </select>
    </div>

  <button type="submit" class="btn btn-success">Submit</button>
</form>