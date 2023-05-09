<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Compte extends CI_Controller {


	 public function __construct()
	 {
		parent::__construct();
		$this->load->model('db_model');
		$this->load->helper('url_helper');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
	 }

	
	public function creer()
	 {
	 	$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('email');

		 //$this->load->helper(array('compte_creer', 'url'));
		$this->form_validation->set_rules('mail', 'mail', 'required');
		$this->form_validation->set_rules('mdp', 'mdp', 'required');
		$data['mail']=$this->input->post('mail');



		if ($this->form_validation->run() == FALSE)
		{// le formulair n;est pas valide 
			//echo "creation du compte";
			$this->load->view('templates/haut');
			$this->load->view('compte_creer');
			$this->load->view('templates/bas');
		}
		else {// Le formulaire est valide
			
			$result = $this->db_model->set_compte(); //si l'insertion se passe bien alors : 
			if($result){
				$this->load->view('templates/haut');
				$this->load->view('compte_succes',$data);
				$this->load->view('templates/bas');
			}
			else{
				// Account creation failed because email already exists
            		echo "L'adresse email existe déjà. Veuillez choisir une autre adresse email.";
	            $this->load->view('templates/haut');
	            $this->load->view('compte_creer', $data);
	            $this->load->view('templates/bas');
			}	
	            
       	}
	}

	public function connecter()
	{
				$this->load->library('session');

		$this->load->helper('form');
		$this->load->library('form_validation');
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('templates/haut');
			$this->load->view('compte_connect');
			$this->load->view('templates/bas');
	 	}
	 	else{
			$mail = $this->input->post('mail');
			$password = $this->input->post('mdp');
			if($this->db_model->connect_compte($mail,$password))
			{
				$role = $this->db_model->get_role($mail);	
				$prenom = $this->db_model->get_prenom($mail);
				$nom= $this->db_model->get_nom($mail);
				$id = $this->db_model->get_id($mail);


				$session_data = array('mail' => $mail,
					'id' => $id,
					'prenom' => $prenom,
					'nom' => $nom, 
					'role' => $role->role_uti,
					'connecter' => TRUE);	 		
					$this->session->set_userdata($session_data);

			}
			else
			{
				$this->load->view('templates/haut');
				$this->load->view('compte_connecter');
				$this->load->view('templates/bas');
			}
	 	}
		
	}

	public function admin_backOffice(){
		
		$this->load->library('session');

		$this->form_validation->set_rules('mail', 'mail', 'required');
		$this->form_validation->set_rules('mdp', 'mdp', 'required');

		//Connexion
		$mail = $this->input->post('mail');
		$password = $this->input->post('mdp');
		if($this->db_model->connect_compte($mail,$password))
		{
			$role = $this->db_model->get_role($mail);	
			$prenom = $this->db_model->get_prenom($mail);
			$nom= $this->db_model->get_nom($mail);
			$id = $this->db_model->get_id($mail);

			$session_data = array('mail' => $mail,
				'id' => $id,
				'prenom' => $prenom,
				'nom' => $nom, 
				'role' => $role->role_uti,
				'connecter' => TRUE);	 		
				$this->session->set_userdata($session_data);
		}
		else
		{
			$this->load->view('templates/haut');
			$this->load->view('compte_connecter');
			$this->load->view('templates/bas');
		}


		if($this->session->userdata('connecter')){ 	
			
			if($this->session->userdata('role') == 'A'){ 	//administrateur 
				$this->load->view('templates/menu_administrateur');

				$this->load->view('accueil_admin');
				$this->load->view('templates/bas');
			}
			else{// si non un utilisaateur connecte qui est redirige vers la page d'accueil
				$this->load->view('templates/menu_utilisateur');
				$this->load->view('accueil_admin');
				$this->load->view('templates/bas');
			}
		}
			else{
				$this->session->sess_destroy();
				redirect('compte/connecter');
				echo "Vous eties deconnnecter";
			}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('compte/connecter');
		
	}
	public function profil_admin(){
		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'A'){ 	
				$this->load->view('templates/menu_administrateur');//navbar admin
				$this->load->view('profil_info');
				$this->load->view('templates/bas');
			}
			else{
				$this->load->view('templates/menu_formateur');//navbar admin
				$this->load->view('profil_info');
				$this->load->view('templates/bas');//navbar admin

			}

		}
		else{ 
			$this->session->sess_destroy();
			redirect('compte/connecter');
		}

	}

	public function lister_profils()
	{
	 	
		if($this->session->userdata('connecter')){ 	
			if($this->session->userdata('role') == 'A'){ 	


			$data['titre'] = 'Liste des comptes :';
			$data['cpts'] = $this->db_model->get_allcpt();
			$data['nb_cpt'] = $this->db_model->get_nbcpt();

			$this->load->view('templates/menu_administrateur');
			$this->load->view('compte_liste',$data);
			$this->load->view('templates/bas');
			}
			else{
				$this->session->sess_destroy();
				redirect('compte/connecter');
				echo "Vous etiez deconnnecter";
			}
		}		 
		else{			
			$this->session->sess_destroy();
			redirect('compte/connecter');
			echo "Vous etiez deconnnecter";
		}
	}

	public function commandes(){
			if($this->session->userdata('connecter')){ 	
			if($this->session->userdata('role') == 'A'){ 	

			$data['cmds'] = $this->db_model->get_cmds();

			$this->load->view('templates/menu_administrateur');
			$this->load->view('cmds',$data);
			$this->load->view('templates/bas');
			}
			else{
				$this->session->sess_destroy();
				redirect('compte/connecter');
				echo "Vous etiez deconnnecter";
			}
		}		 
		else{			
			$this->session->sess_destroy();
			redirect('compte/connecter');
			echo "Vous etiez deconnnecter";
		}
	}
	public function produits(){
		if($this->session->userdata('connecter')){ 	
			if($this->session->userdata('role') == 'A'){ 	

			$data['pdts'] = $this->db_model->get_allpdt();

			$this->load->view('templates/menu_administrateur');
			$this->load->view('produits_lister',$data);
			$this->load->view('templates/bas');
			}
			else{
				$this->session->sess_destroy();
				redirect('compte/connecter');
				echo "Vous etiez deconnnecter";
			}
		}		 
		else{			
			$this->session->sess_destroy();
			redirect('compte/connecter');
			echo "Vous etiez deconnnecter";
		}
	}

	public function supprimer_pdt($id_pdt){
		if($this->session->userdata('connecter')){ 	
			if($this->session->userdata('role') == 'A'){ 	
				$data['variant_id'] = $this->db_model->get_variant($id_pdt);
				$this->load->view('templates/menu_administrateur');
				$this->load->view('effacer_produit',$data);
								$this->load->view('templates/bas');

				$this->db_model->supprimer_produits($id_pdt); 
				$this->db_model->sup($id_pdt); 


			}
			else{
				$this->session->sess_destroy();
				redirect('compte/connecter');
				echo "Vous etiez deconnnecter";
			}
		}		 
		else{			
			$this->session->sess_destroy();
			redirect('compte/connecter');
			echo "Vous etiez deconnnecter";
		}
	}

	

	public function ajout()
	{
		$this->form_validation->set_rules('prix', 'prix', 'required');
		$this->form_validation->set_rules('prixjr', 'prixjr', 'required');
		$this->form_validation->set_rules('stock', 'stock', 'required');
		$this->form_validation->set_rules('type', 'type', 'required');
		$this->form_validation->set_rules('nom', 'nom', 'required');
		$this->form_validation->set_rules('description', 'description', 'required');	

		
		$description = $this->input->post('description');
		$stock = $this->input->post('stock');	
		$nom = $this->input->post('nom');	
		$img = $this->input->post('img');	
		$dispo = $this->input->post('dispo');	
		$type = $this->input->post('type');	
		$data['pdts'] = $this->db_model->get_allpdt();

		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'A'){ 	
				$this->db_model->ajout_pdt($stock,$nom, $description, $img, $dispo, $type);
				$this->load->view('templates/menu_administrateur');
				$this->load->view('produits_lister', $data);
				$this->load->view('templates/bas');
			}
			else{
				$this->session->sess_destroy();
				redirect('accueil/afficher');
			}
		}
		else{
			$this->session->sess_destroy();
			redirect('accueil/afficher');
		}
	}


}