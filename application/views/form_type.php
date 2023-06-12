<?php echo validation_errors(); ?>
<?php echo form_open('products/ajout_type'); ?>
<br>
<br>
<h4>Saisissez le nouveau type que vous voulez ajouter
</h4>
	<p> </p>
	 <div class="form-group">
    <input type="text" class="form-control" id="mail" name="type" placeholder="Nouvelle Taille">
  </div>


  <button type="submit" class="btn btn-success">Submit</button>
</form>