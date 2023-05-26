<h2>Bienvenue 
<?php
	$mail = $this->session->userdata('mail');
	$role = $this->session->userdata('role');
    $nom = $this->session->userdata('nom');
    $id = $this->session->userdata('id');
    $prenom = $this->session->userdata('prenom');

    $validite = $this->session->userdata('validite');
		
	echo $prenom->prenom; echo " ";echo $nom->nom; echo " a votre profil ";if ($role == "U") {
		echo "utilisateur.";
	} else{
		echo "admin.";
	}
	echo "<br>";	
	?>

</h2>
<br>
<h4>Votre profil est <?php if($validite == "A"){ echo "valide.";} ?> </h4>

<style>
    .center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
</style>
<div class="center">
    <button class="btn btn-success" onclick="window.location.href = '<?php echo base_url('index.php/compte/form_changemdp/'.$id)?>'">Changer votre mot de passe</button>
</div>