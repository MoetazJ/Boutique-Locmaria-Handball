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
				echo "Votre compte a ete creez avec succes";
				$this->load->view('templates/haut');
				$this->load->view('compte_connect',$data);
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
					'id' => $id->cpt_id,
					'prenom' => $prenom,
					'nom' => $nom, 
					'role' => $role->role_uti,
					'connecter' => TRUE);	 		
					$this->session->set_userdata($session_data);

			}
			else
			{
				echo "Vos informations sont invalides";
				$this->load->view('templates/haut');
				$this->load->view('compte_connecter');
				$this->load->view('templates/bas');
			}
	 	}
		
	}

	public function utilisateur(){
		
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
			$validite = $this->db_model->get_validite($mail);

			$session_data = array('mail' => $mail,
				'id' => $id->cpt_id,
				'prenom' => $prenom,
				'nom' => $nom, 
				'role' => $role->role_uti,
				'validite' => $validite->compte_actif,
				'connecter' => TRUE);	 		
				$this->session->set_userdata($session_data);
		
			
			if($this->session->userdata('role') == 'A'){ 	//administrateur 
				$this->load->view('templates/menu_administrateur');
				$this->load->view('accueil_admin');
			}
			else{// si non un utilisaateur connecte qui est redirige vers la page d'accueil
				$this->load->view('templates/menu_utilisateur');
				$this->load->view('accueil_admin');
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



	public function form_changemdp(){
		//$data['cpt_id'] = $cpt_id;
		if($this->session->userdata('connecter')){// verif de la connexion 
			if($this->session->userdata('role') == 'A'){ //v verif que c un administrateur	
				$this->load->view('templates/menu_administrateur');
				$this->load->view('form_changemdp');
			} 
			else{
				$this->load->view('templates/menu_administrateur');
				$this->load->view('form_changemdp');
			} 	
		}

	}

	public function mdp(){
		
		$this->form_validation->set_rules('new_mdp', 'new_mdp', 'required');
		$this->form_validation->set_rules('old_mdp', 'old_mdp', 'required');
		$id = $this->session->userdata('id');

		$old = $this->db_model->get_mdp($id);
		$old_mdp = $this->input->post('old_mdp');
		$new_mdp = $this->input->post('new_mdp');
		if($this->session->userdata('connecter')){// verif de la connexion 
			if(strcmp($old_mdp,$old->cpt_mdp) == 0 && strcmp($old_mdp,$new_mdp)!=0 ){
				$this->db_model->update_mdp($id,$new_mdp); 
				echo "Votre mot de passe a etait change."; 
				redirect('compte/connecter');
			}

			else{
				echo "Les donnees que vous avez rentrer ne sont pas valides";
				redirect('form_changemdp');
			}
		}	
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

	public function voir_commandes($order_id){
		if($this->session->userdata('connecter')){ 	
			if($this->session->userdata('role') == 'A'){ 	
			$data['order_id'] = $order_id;
			$data['details_commande'] = $this->db_model->get_order_details($order_id);
			/*$data['variant'] = $this->db_model->get_variant_details($data['details_commande']->variant_id);
						$data['autre'] = $this->db_model->get_autre_details($data['details_commande']->autre_id);*/

			$this->load->view('templates/menu_administrateur');
			$this->load->view('voir_commande',$data);
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

	
	


	public function modif_compte($cpt_id){
		$actif = $this->input->post('actif');	
		$role = $this->input->post('role');	

		if($this->session->userdata('connecter')){// verid de la conneion 
			if($this->session->userdata('role') == 'A'){ //v verif que c un administrateur	
				$this->db_model->update_cpt($cpt_id, $actif,$role);
				redirect('compte/lister_profils');
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