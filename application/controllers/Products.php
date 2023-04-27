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
		var_dump($data);
		//Chargement de la view haut.php
		$this->load->view('templates/haut');
		//Chargement de la view du milieu : page_accueil.php
		$this->load->view('produit',$data);
		//Chargement de la view bas.php
		$this->load->view('templates/bas');
	}

	public function ajout_panier()
	{
		$data['panier'] = $this->db_model->select_pdt($id_pdt);
		$size = $this->input->post('size');
		$color = $this->input->post('color');
		$size_jr = $this->input->post('size_jr');
		
		$this->load->view('pan',$data);

	}
}
?>