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
		//Connexion
		$color = $this->input->post('color');
		$sizejr = $this->input->post('sizejr');
		$size = $this->input->post('size'); 
		$qte = $this->input->post('quantity'); 
		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'A'){//profil admin 	
				$this->load->view('templates/menu_administrateur');//navbar admin
				$this->load->view('profil_info');
				$this->load->view('templates/bas');
			}
			else{// profil utilisateur 
				if(strcmp($size, 'NULL') and  strcmp($sizejr, 'NULL')) { // choix invalide du variant
					$this->load->view('templates/haut');
					$this->load->view('echec_choixvariant');
					$this->load->view('templates/bas');
					
				}else{ 
					$data['variant'] = $this->db_model->verif_variant($pdt_id,$color,$size, $sizejr,$qte);
					if ($data['variant'] != null) {
					    $cpt_id = $this->session->userdata('id');
					    $this->db_model->insert_panier($cpt_id, $data['variant']->variant_id, $qte);
					    $this->load->view('templates/haut');
					    $this->load->view('succes_choixvariant');
					    $this->load->view('templates/bas');
					} else {
					    $this->load->view('templates/haut');
					    $this->load->view('echec_variant');
					    //$this->load->view('templates/bas');
					}
				}
			}
		}
		else{// si l'utilisateur n'est pas connecte et veux ajouter un produit au panier. Il est redirige vers la page de connexion 
			redirect('compte/connecter');
		}
		
	}

	public function Panier (){
		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'A'){//profil admin 	
				$this->load->view('templates/menu_administrateur');//navbar admin
				$this->load->view('profil_info');
				$this->load->view('templates/bas');
			}
			else{
				$this->session->userdata('role') ;
				$cpt_id = $this->session->get_id();
				$cart_items = $this->db_model->affiche_pan();
			}
		}
	}
			/*$dispo = $this->input->post('dispo');
		$noms = $this->input->post('nom');
	    $prix = $this->input->post('prix');
	    $prixjr = $this->input->post('prixjr');
	    $types = $this->input->post('type');
	    $imgs = $this->input->post('img');    

	    foreach($noms as $i => $nom) {
	        $pdt_id = $this->input->post('pdt_id')[$i];
	        $data = array(
	            'pdt_nom' => $nom,
	            'pdt_prix' => $prix[$i],
	            'pdt_prixjr' => $prixjr[$i],
	            'pdt_type' => $types[$i],
	            'pdt_img' => $imgs[$i],
	            'pdt_dispo' => $dispos[$i],
	        );
	        $this->db_model->modifier_pdt($pdt_id, $data);
	    }
		*/
	public function modifier_pdt ($pdt_id){
		$nom = $this->input->post('nom');
	    $type = $this->input->post('type');
	    $img = $this->input->post('img'); 
	    $dispo = $this->input->post('dispo'); 
		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'A'){
				$this->db_model->modif_pdt($pdt_id, $nom,  $type, $img, $dispo);
				redirect('compte/produits');
			}
			else
			{
				$this->load->view('templates/haut');
				$this->load->view('compte_connecter');
				$this->load->view('templates/bas');
			}
		}
	}

	//Voir les variant d'un certain produit
	public function voir_variants ($pdt_id){
		
		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'A'){
				$data['variant'] = $this->db_model->variant($pdt_id);
				$data['pdt_id'] = $pdt_id;
				$data['pdt_nom'] = $this->db_model->get_pdt_nom($pdt_id);
				$this->load->view('templates/menu_administrateur');
				$this->load->view('product_variant', $data);
				$this->load->view('templates/bas');
			}

			else
			{
				$this->load->view('templates/haut');
				$this->load->view('compte_connecter');
				$this->load->view('templates/bas');
			}
		}
	}

	public function modifier_variant($pdt_id, $variant_id){
	    $couleur = $this->input->post('couleur');
	    $taille = $this->input->post('taille');
	    $taillejr = $this->input->post('taillejr'); 
	    $stock = $this->input->post('stock'); 
	    $price = $this->input->post('price'); 

	    if($this->session->userdata('connecter')){
	        if($this->session->userdata('role') == 'A'){
	            $this->db_model->modifier_variant($pdt_id, $variant_id, $couleur, $taille, $taillejr, $price, $stock);
	            redirect('products/voir_variants/'.$pdt_id);
	        }
	        else{
	            $this->load->view('templates/haut');
	            $this->load->view('compte_connecter');
	            $this->load->view('templates/bas');
	        }
	    }
	}

	public function ajout_variant($pdt_id){
	    $couleur = $this->input->post('couleur');
	    $taille = $this->input->post('taille');
	    $choix = $this->input->post('choix'); 
	    $stock = $this->input->post('stock'); 
	    $price = $this->input->post('price'); 

	    if($this->session->userdata('connecter')){
	        if($this->session->userdata('role') == 'A'){
	            $this->db_model->ajout_variant($pdt_id, $couleur, $taille, $choix, $price, $stock);
	            redirect('products/voir_variants/'.$pdt_id);
	        }
	        else{
	            $this->load->view('templates/haut');
	            $this->load->view('compte_connecter');
	            $this->load->view('templates/bas');
	        }
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