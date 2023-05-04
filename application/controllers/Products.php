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
		$data['size'] = $this->db_model->get_size($id_pdt);
		//Chargement de la view haut.php
		$this->load->view('templates/haut');
		//Chargement de la view du milieu : page_accueil.php
		$this->load->view('produit',$data);
		//Chargement de la view bas.php
		$this->load->view('templates/bas');
	}

	public function choix_variants($pdt_id){

		$this->form_validation->set_rules('color', 'color', 'required');
		$this->form_validation->set_rules('sizejr', 'sizejr', 'required');	
		$this->form_validation->set_rules('size', 'size', 'required');		
	
		$this->form_validation->set_rules('qte', 'qte', 'required');		
		$this->form_validation->set_rules('qte', 'qte', 'required');		
		var_dump($pdt_id);
		//Connexion
		$color = $this->input->post('color');
		$sizejr = $this->input->post('sizejr');
		$size = $this->input->post('size'); 
		$qte = $this->input->post('quantity'); 
				var_dump($size, $sizejr);
		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'A'){//profil admin 	
				$this->load->view('templates/menu_administrateur');//navbar admin
				$this->load->view('profil_info');
				$this->load->view('templates/bas');//navbar admin
			}
			else{// profil utilisateur 
				if($size != NULL and  $sizejr != NULL) {
					$this->load->view('templates/haut');
					$this->load->view('echec_choixvariant');
					$this->load->view('templates/bas');
					
				}else{
					$exist = $this->db_model->verif_variant($pdt_id,$color,$size, $sizejr,$qte);
					if($exist){
						$this->load->view('templates/haut');
						$this->load->view('succes_choixvariant');
						$this->load->view('templates/bas');
					}
					else {
						echo "Stock insuffisant";
					}
				}
			}
		}
		else{// si l'utilisateur n'est pas connecte et veux ajouter un produit au panier. Il est redirige vers la page de connexion 
			redirect('compte/connecter');
		}
		
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