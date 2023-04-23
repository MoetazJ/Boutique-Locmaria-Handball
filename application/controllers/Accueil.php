<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accueil extends CI_Controller {
	public function __construct()
	 {
		 parent::__construct();
		 $this->load->helper('url');
	 }
	 public function afficher()
	 {
	 //Chargement de la view haut.php
	 $this->load->view('templates/haut');
	 //Chargement de la view du milieu : page_accueil.php
	 $this->load->view('page_accueil');
	 //Chargement de la view bas.php
	 $this->load->view('templates/bas');
	 }
}
?>