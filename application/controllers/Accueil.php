<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accueil extends CI_Controller {
	public function __construct(){
		 parent::__construct();
		 $this->load->model('db_model');
		 $this->load->helper('url');
	 }
	 public function afficher()
	 {
	 	$data['produits'] = $this->db_model->afficher_pdt();
	 	$data['types'] = $this->db_model->get_types(); 
		if($this->session->userdata('connecter')){
		
			$this->load->view('templates/menu_utilisateur');
		}
		else{		
			$this->load->view('templates/haut');
		}
		//Chargement de la view du milieu : page_accueil.php
		$this->load->view('page_accueil',$data);
		//Chargement de la view bas.php
		$this->load->view('templates/bas');
	 }
}
?>