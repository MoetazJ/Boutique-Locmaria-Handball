<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	public function __construct()
	 {
		parent::__construct();
		$this->load->model('db_model');
		$this->load->helper('url');
	 }
	 public function afficher($id_pdt, $color, $size)
	 {
	 	$data['produit'] = $this->db_model->select_pdt($id_pdt, $color, $size);
	 	
		//Chargement de la view haut.php
		$this->load->view('templates/haut');
		//Chargement de la view du milieu : page_accueil.php
		$this->load->view('pan',$data);
		//Chargement de la view bas.php
		$this->load->view('templates/bas');
	 }
}
?>