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
	//afficher un produit avec un id x
	public function afficher($id_pdt)
	{
		
		$data['type'] = $this->db_model->get_pdt_type($id_pdt);
		$data['produit'] = $this->db_model->pdt($id_pdt);
		$data['color'] = $this->db_model->get_color($id_pdt);
		$data['size'] = $this->db_model->get_size($id_pdt,$data['type']);
		$data['prix'] =$this->db_model->get_prix($id_pdt);
		//On determine si c'est un utilisateur connecte ou pas et en fonction de ca on afficher la bar de navigation
		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'U'){//profil utilisateur 	
				$this->load->view('templates/menu_utilisateur');
			}
			else { //Si c'est un admin 
				$this->load->view('templates/haut');
			}
		}
		else { //Si l'le visiteur n'est pas connecte : 
			$this->load->view('templates/haut');
		}
		
		//Utilisateur connecte ou pas connecte : Il peut visualiser la fiche de produit 
		if($data['type']->type_name == 'Nourriture'){ // affichage pour la nourriture
			$this->load->view('produit_food',$data);
		}
		else { // affichage pour le reste des produits
			$this->load->view('produit',$data);
		}
		//Chargement de la view bas.php
		$this->load->view('templates/bas');
	}
	
	public function evenements(){
		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'U'){//profil utilisateur 	
				$this->load->view('templates/menu_utilisateur');
			}
			else { //Si c'est un admin 
				$this->load->view('templates/haut');
			}
		}
		else { //Si l'le visiteur n'est pas connecte : 
			$this->load->view('templates/haut');
		}
		$this->load->view('evenements');

	}

	//Choix de la taille, couleurs, qte
	public function choix_variants($pdt_id){

		$this->form_validation->set_rules('color', 'color', 'required');
		$this->form_validation->set_rules('sizejr', 'sizejr', 'required');	
		$this->form_validation->set_rules('size', 'size', 'required');		
		$this->form_validation->set_rules('qte', 'qte', 'required');		
		$choix = $this->input->post('choix'); 

		$color = $this->input->post('color');
		$sizejr = $this->input->post('sizejr');
		$size = $this->input->post('size'); 
		$qte = $this->input->post('quantity'); 
		$sexe = $this->input->post('sexe');
		$taille = $this->input->post('taille');

		$data['type'] = $this->db_model->get_pdt_type($pdt_id);
		$data['produit'] = $this->db_model->pdt($pdt_id);
		$data['color'] = $this->db_model->get_color($pdt_id);
		$data['size'] = $this->db_model->get_size($pdt_id,$data['type']);
				$data['prix'] =$this->db_model->get_prix($pdt_id);

		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'A' || $this->session->userdata('role') == 'U'){//profil admin 	
				//verif si le variant choisi cexiste ou pas dans la base de donnnees et si le stock est suffisant 		 
				if ($choix == 'adulte' && $data['produit']->type_name == 'Vetements') {
					//echo "jeeeee";
					$data['variant'] = $this->db_model->verif_variant($pdt_id,$color,$size, $qte,$sexe);
				}
				else{
					//echo "je suis la";

					$data['variant'] = $this->db_model->verif_variantjr($pdt_id,$color,$size, $qte,$sexe);
				}

				if($data['produit']->type_name != 'Nourriture'){
					if ($data['variant'] !== false ) { //au cas ou le variant choisi existe, on l'ajoute au panier s
						//var_dump($data['variant']);
					    $cpt_id = $this->session->userdata('id');
					    $this->db_model->insert_panier($cpt_id, $data['variant']->variant_id, $qte);
					    echo "Votre commande a etait ajoute dans le panier";
					    $this->load->view('templates/menu_utilisateur');
					    $this->load->view('produit',$data);
					    $this->load->view('templates/bas');
					} else { // si non on affiche un message d'erreur et on reaffiche la fiche du produit
					    echo "Le variant du produit que vous avez choisi n'est pas disponible. Désolé !";
					    $this->load->view('templates/menu_utilisateur');
						//Chargement de la view du milieu : page_accueil.php
						$this->load->view('produit',$data);
						$this->load->view('templates/bas');

					}
				}
				else {
					$data['variant_food'] = $this->db_model->verif_variant_food($pdt_id,$taille);
					if ($data['variant_food'] !== false ) { //au cas ou le variant choisi existe, on l'ajoute au panier 
					    $cpt_id = $this->session->userdata('id');
					    $this->db_model->insert_panier($cpt_id, $data['variant']->variant_id, $qte);
					    echo "Votre commande a etait ajoute dans le panier";
					    $this->load->view('templates/menu_utilisateur');
					    $this->load->view('produit',$data);
					    $this->load->view('templates/bas');
					} else { // si non on affiche un message d'erreur et on reaffiche la fiche du produit
					    echo "La taille ou la couleur du produit que vous avez choisi n'est pas disponible. Désolé !";
					    $this->load->view('templates/menu_utilisateur');
						//Chargement de la view du milieu : page_accueil.php
						$this->load->view('produit',$data);
						$this->load->view('templates/bas');

					}
				}
				
			}

		}
		
		// si l'utilisateur n'est pas connecte et veux ajouter un produit au panier. Il est redirige vers la page de connexion pour se connecter avant de devoit ajoute un produit a son panier 
        else{
        	redirect('compte/logout');

    	}	
		
	}

	public function produits(){

		if($this->session->userdata('connecter') && $this->session->userdata('role') == 'A'){ 	
			$data['pdts'] = $this->db_model->get_allpdt();
			$data['product_types'] = $this->db_model->get_types_pdts();	
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



	//afficher panier
	public function Panier(){
		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'A'){//profil admin 	
				$this->load->view('templates/menu_administrateur');//navbar admin
				$this->load->view('profil_info');
				$this->load->view('templates/bas');
			}
			else{
				$cpt_id = $this->session->userdata('id');

				$data['panier'] = $this->db_model->affiche_pan($cpt_id);

				$this->load->view('templates/menu_utilisateur'); 
				$this->load->view('pan',$data);
			}
		}
		else{
	        redirect('compte/logout');
	    }
	}

	//effacer un variant du panier
	public function remove_item()
	{
	    $item_id = $this->input->post('item_id');
	    $this->db_model->remove_from_cart($item_id);
	    redirect('products/panier');
	}


	public function modifier_pdt ($pdt_id){
		$nom = $this->input->post('nom');
	    $type = $this->input->post('type');
	    $img = $this->input->post('img'); 
	    $dispo = $this->input->post('dispo'); 
		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'A'){
				$this->db_model->modif_pdt($pdt_id, $nom,  $type, $img, $dispo);
				redirect('products/produits');
			}
	        else{
	           redirect('compte/logout');
	        }
		}
		else{
	           redirect('compte/logout');
	    }
	}

	//Voir les variant d'un certain produit
	public function voir_variants ($pdt_id){
		
		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'A'){
				$data['variant'] = $this->db_model->variant($pdt_id); //variant de vetements
				$data['variant_food'] = $this->db_model->variant_food($pdt_id);
				
				$data['pdt_id'] = $pdt_id;
				$data['pdt_nom'] = $this->db_model->get_pdt_nom($pdt_id);
				$data['type'] = $this->db_model->get_pdt_type($pdt_id);

				$data['sizes'] = $this->db_model->sizes($data['type']);
				$data['couleurs'] = $this->db_model->couleurs();

				//verifiacation du type du produit 
				if($data['type']->type_name == 'Nourriture'){
					$this->load->view('templates/menu_administrateur');
					$this->load->view('product_variant_food', $data);
					$this->load->view('templates/bas');
				}
				else{
					$this->load->view('templates/menu_administrateur');
					$this->load->view('product_variant', $data);
					$this->load->view('templates/bas');
				}	
			}

	        else{
	            redirect('compte/logout');

	        }
		}
	}

	public function ajout_variant($pdt_id){

	    $couleur = $this->input->post('couleur');
	    $taille = $this->input->post('taille');
	    $choix = $this->input->post('choix'); 
	    $stock = $this->input->post('stock'); 
	    $price = $this->input->post('price'); 
	    $sexe = $this->input->post('sexe');
	    $data['type'] = $this->db_model->get_pdt_type($pdt_id);

	    $data['type'] = $this->db_model->get_pdt_type($pdt_id);
	    $choix = $this->input->post('choix');;
	    $price = $this->input->post('price');
	    $carac1 = $this->input->post('car1');
	    $carac2 = $this->input->post('car2');
	    if($this->session->userdata('connecter')){
	        if($this->session->userdata('role') == 'A'){
	        	if($data['type']->type_name == 'Nourriture'){
	        		$this->db_model->ajout_variant_food($pdt_id,  $choix, $price, $carac1, $carac2,$carac3, $$data['type']);
	        	}
	        	else {
	        		$res = $this->db_model->ajout_variant($pdt_id, $couleur, $taille, $choix, $price, $stock, $sexe);
	        		if(!$res){
	        			echo "Le variant que vosu souhaotez ajouter existe deja."; 

	        		}
	        		else{
	        			echo "Variant ajoute ";
	        		}
	        	}
	            redirect('products/voir_variants/'.$pdt_id);
	        }
	        else{
	            redirect('compte/logout');

	        }
	    }
	}

	//ajout d'un pdt
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
				redirect('products/produits');
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

	public function supprimer_variant($variant_id){
		if($this->session->userdata('connecter') && $this->session->userdata('role') == 'A'){
	            	$this->db_model->supprimer_variant($variant_id);
	    }
	    
	    else {
	    	redirect('compte/logout');
	    }
	}


	public function modifier_variant($pdt_id, $variant_id){

	    $couleur = $this->input->post('couleur');
	    $taille = $this->input->post('taille');
	    $taillejr = $this->input->post('taillejr'); 
	    $stock = $this->input->post('stock'); 
	    $price = $this->input->post('price'); 
	    $sexe = $this->input->post('sexe');
	    
	    $data['type'] = $this->db_model->get_pdt_type($pdt_id);
	    $choix = $this->input->post('choix');

	    $price = $this->input->post('price');
	    $carac1 = $this->input->post('car1');
	    $carac2 = $this->input->post('car2');
	    $carac3 = $this->input->post('car3');
	    if($this->session->userdata('connecter')){
	        if($this->session->userdata('role') == 'A'){
	        	if($data['type']->type_name != 'Nourriture'){
	            	$this->db_model->modifier_variant($pdt_id, $variant_id, $couleur, $taille, $taillejr, $price, $stock,$sexe);
	       		}
		        else {
		        	$this->db_model->modifier_variant_food($pdt_id,$variant_id,  $choix, $price, $carac1, $carac2,$carac3, $data['type']->type_name);
		        }
	        redirect('products/voir_variants/'.$pdt_id);
	        } 
	    }

	    else {
           	redirect('compte/logout');
	    }
	}

	public function search()
	{
		if($this->session->userdata('connecter') && $this->session->userdata('role') == 'A'){

		    // Get the search term from the query parameter
		    $searchTerm = $this->input->get('search');

		    // Call a model method to fetch the filtered products based on the search term
		    $data['pdts'] = $this->db_model->searchProducts($searchTerm);
		    $data['product_types'] = $this->db_model->get_types_pdts();	

		    $this->load->view('templates/menu_administrateur');
		    $this->load->view('produits_lister', $data);
		    $this->load->view('templates/bas');
		}
		else{
			redirect('compte/logout');
		}
	}

	public function form_size(){
		if($this->session->userdata('connecter') && $this->session->userdata('role') == 'A'){ 
			$data['types'] = $this->db_model->get_types_pdts();
			$this->load->view('templates/menu_administrateur');
			$this->load->view('form_size',$data);
		}				 
		else{			
			$this->session->sess_destroy();
			redirect('compte/connecter');
			echo "Vous etiez deconnnecter";
		}
	}

	public function form_type(){
		if($this->session->userdata('connecter') && $this->session->userdata('role') == 'A'){ 
			$this->load->view('templates/menu_administrateur');
			$this->load->view('form_type');
		}				 
		else{			
			$this->session->sess_destroy();
			redirect('compte/connecter');
			echo "Vous etiez deconnnecter";
		}
	}
	public function ajout_taille(){
		if($this->session->userdata('connecter') && $this->session->userdata('role') == 'A'){
			$nouv_taille = $this->input->post('nouv_taille');
			$type =$this->input->post('type');
			$this->db_model->ajout_taille($nouv_taille,$type);
			redirect('products/produits');

		}
		else{
			redirect('compte/logout');
		}
	}
		public function ajout_type(){
		if($this->session->userdata('connecter') && $this->session->userdata('role') == 'A'){
			$type =$this->input->post('type');
			$this->db_model->ajout_type($type);
			redirect('products/form_size');

		}
		else{
			redirect('compte/logout');
		}
	}


}
?>