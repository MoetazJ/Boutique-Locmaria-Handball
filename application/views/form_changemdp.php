
	
	<h4>Saissisez vos identifiants pour changer votre mot de passe</h4>

	<br>
	<br>

<?php echo validation_errors()?>
<?php echo form_open('compte/mdp'); ?>
	
    <div class="form-group">
    <input type="text" class="form-control form-control-sm" id="old_mdp" name="old_mdp"  placeholder="Ancien Mot de Passe">
  	</div>
  	    <br>

    <div class="form-group">
    <input type="text" class="form-control form-control-sm" id="mew_mdp" name="new_mdp" placeholder="Nouveau mot de passe">
    <br>
    </div>
    <br>



  <br>
  <br>
<button type="submit" class="btn btn-success">Valider</button>     
  </form>


   
