<?php echo validation_errors(); ?>
<?php echo form_open('compte/utilisateur'); ?>
<br>
<br>
<h4>Saisissez vos identifiants</h4>
	<p> </p>
	 <div class="form-group">
    <input type="text" class="form-control" id="mail" name="mail" placeholder="Mail">
  </div>
  	 <div class="form-group">
    <input type="password" class="form-control" id="mdp" name="mdp" aria-describedby="emailHelp" placeholder="Mot de passe">
  </div>
  <p>
    <a href="<?php echo base_url()?>index.php/compte/creer">Vous n'avez pas de compte encore</a>
  </p>
  <button type="submit" class="btn btn-success">Submit</button>
</form>