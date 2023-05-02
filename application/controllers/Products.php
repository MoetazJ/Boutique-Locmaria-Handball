<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('db_model');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}
	public function afficher($id_pdt =FALSE)
	{
		$data['produit'] = $this->db_model->pdt($id_pdt);
		$data['color'] = $this->db_model->get_color($id_pdt);
		//Chargement de la view haut.php
		$this->load->view('templates/haut');
		//Chargement de la view du milieu : page_accueil.php
		$this->load->view('produit',$data);
		//Chargement de la view bas.php
		$this->load->view('templates/bas');
	}

/*	public function ajout_panier($cpt_id)
	{
		$size = $this->input->post('size');
		$color = $this->input->post('color');
		$size_jr = $this->input->post('size_jr');
		$qte = $this->input->post('quantity');
		$data['panier'] = $this->db_model->ajout_panier($id_pdt,$size,$color,$qte);
		// association du panier au compte de l'utilisateur 
		$req = $this->db_model->association_panier($cpt_id)
		//$this->load->view('pan',$data);

	}*/
}
?>