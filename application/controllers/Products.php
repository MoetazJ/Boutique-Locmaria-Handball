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
		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'U'){//profil admin 	
				$this->load->view('templates/menu_utilisateur');
				if($data['type']->type_name == 'Nourriture'){
					$this->load->view('produit_food',$data);
				}
				else {
					$this->load->view('produit',$data);
				}
				//Chargement de la view bas.php
				$this->load->view('templates/bas');
			}
		}
		else {
			$this->load->view('templates/haut');
			if($data['type']->type_name == 'Nourriture'){
					$this->load->view('produit_food',$data);
				}
				else {
					$this->load->view('produit',$data);
				}
			$this->load->view('templates/bas');
		}
	}



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

		$data['type'] = $this->db_model->get_pdt_type($pdt_id);
		$data['produit'] = $this->db_model->pdt($pdt_id);
		$data['color'] = $this->db_model->get_color($pdt_id);
		$data['size'] = $this->db_model->get_size($pdt_id,$data['type']);

		if($this->session->userdata('connecter')){
			if($this->session->userdata('role') == 'A' || $this->session->userdata('role') == 'U'){//profil admin 	
				// profil utilisateur 
				 
				if ($choix == 'adulte') {
					$data['variant'] = $this->db_model->verif_variant($pdt_id,$color,$size, $qte,$sexe);
				}
				else{
					$data['variant'] = $this->db_model->verif_variant($pdt_id,$color,$sizejr, $qte,$sexe);
				}
				//var_dump($data['variant']);
				if ($data['variant'] !== false) {
				    $cpt_id = $this->session->userdata('id');
				    $this->db_model->insert_panier($cpt_id, $data['variant']->variant_id, $qte);
				    echo "Votre commande a etait ajoute dans le panier";
				    $this->load->view('templates/menu_utilisateur');
				    $this->load->view('produit',$data);
				    $this->load->view('templates/bas');
				} else {
				    echo "La taille ou la couleur du produit que vous avez choisi n'est pas disponible. Désolé !";
				    $this->load->view('templates/menu_utilisateur');
					//Chargement de la view du milieu : page_accueil.php
					$this->load->view('produit',$data);
					$this->load->view('templates/bas');

				}
			}
		}
		
		else{// si l'utilisateur n'est pas connecte et veux ajouter un produit au panier. Il est redirige vers la page de connexion 
			redirect('compte/connecter');
		}
		
	}

	public function produits(){

		if($this->session->userdata('connecter')){ 	
			if($this->session->userdata('role') == 'A'){ 	

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
				$this->session->userdata('role') ;
				$cpt_id = $this->session->userdata('id');
				//var_dump($cpt_id);
				$data['panier'] = $this->db_model->affiche_pan($cpt_id);

				$this->load->view('templates/menu_utilisateur'); 
				$this->load->view('pan',$data);
			}
		}
	}

	//effacer un variant du panier
	public function remove_item()
	{
	    $item_id = $this->input->post('item_id');
	    $this->db_model->remove_from_cart($item_id);
	    redirect('products/panier');
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
				redirect('products/produits');
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
				$data['variant'] = $this->db_model->variant($pdt_id); //variant de vetements
				$data['variant_food'] = $this->db_model->variant_food($pdt_id);

				$data['pdt_id'] = $pdt_id;
				$data['pdt_nom'] = $this->db_model->get_pdt_nom($pdt_id);
				$data['type'] = $this->db_model->get_pdt_type($pdt_id);

				$data['sizes'] = $this->db_model->sizes($data['type']);
				$data['couleurs'] = $this->db_model->couleurs();
				//verifiacation du tyope du produit 
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

			else
			{
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
	        		$this->db_model->ajout_variant($pdt_id, $couleur, $taille, $choix, $price, $stock, $sexe);

	        	}
	            redirect('products/voir_variants/'.$pdt_id);
	        }
	        else{
	            $this->load->view('templates/haut');
	            $this->load->view('compte_connecter');
	            $this->load->view('templates/bas');
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

	public function modifier_variant($pdt_id, $variant_id){

	    $couleur = $this->input->post('couleur');
	    $taille = $this->input->post('taille');
	    $taillejr = $this->input->post('taillejr'); 
	    $stock = $this->input->post('stock'); 
	    $price = $this->input->post('price'); 
	    $sexe = $this->input->post('sexe');
	    
	    $data['type'] = $this->db_model->get_pdt_type($pdt_id);
	    $choix = $this->input->post('choix');
	    var_dump($choix);

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
            $this->load->view('templates/haut');
            $this->load->view('compte_connecter');
            $this->load->view('templates/bas');
	    }
	}




	public function search()
	{
	    // Get the search term from the query parameter
	    $searchTerm = $this->input->get('search');

	    // Call a model method to fetch the filtered products based on the search term
	    $data['pdts'] = $this->db_model->searchProducts($searchTerm);


	    $this->load->view('templates/menu_administrateur');
	    $this->load->view('produits_lister', $data);
	    $this->load->view('templates/bas');
	}

	/*public function searchVariant()
	{
	    // Get the search term from the query parameter
	    $searchTerm = $this->input->get('search');

	    // Call a model method to fetch the filtered products based on the search term
	   	$data['pdts'] = $this->db_model->searchVariant($searchTerm);

	    $this->load->view('templates/menu_administrateur');
	    $this->load->view('product_variant',$data);
	    $this->load->view('templates/bas');
	}*/
}
?>