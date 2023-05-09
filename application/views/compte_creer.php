
	
	<h4>Saissisez vos identifiants pour creer un compte</h4>

	<br>
	<br>

<?php echo validation_errors(); ?>
<?php echo form_open('compte_creer'); ?>
	
    <div class="form-group">
    <input type="mail" class="form-control form-control-sm" id="mail" name="mail" aria-describedby="emailHelp" placeholder="Mail">
  	</div>
  	    <br>

    <div class="form-group">
    <input type="password" class="form-control form-control-sm" id="mdp" name="mdp" aria-describedby="emailHelp" placeholder="Mot de passe">
    <br>
    </div>
        <div class="form-group">
    <input type="text" class="form-control form-control-sm" id="prenom" name="prenom" placeholder="Prenom">
    </div>
        <br>

        <div class="form-group">
    <input type="text" class="form-control form-control-sm" id="nom" name="nom" placeholder="Nom">
    </div>

  <br>
  <br>
<button type="submit" class="btn btn-success">Valider</button>     
  </form>


   
