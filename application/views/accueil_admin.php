<h2>Bienvenue 
<?php
	$mail = $this->session->userdata('mail');
	$role = $this->session->userdata('role');
    $nom = $this->session->userdata('nom');

    $prenom = $this->session->userdata('prenom');

    $validite = $this->session->userdata('validite');
		
		echo $prenom->prenom;
		echo " ";		echo $nom->nom;

		echo "<br>";

		for ($i=0; $i <5 ; $i++) { 
			echo "<br>";
		} 	
	?>
</h2>