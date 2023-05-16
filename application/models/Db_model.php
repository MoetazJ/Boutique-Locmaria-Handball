<?php
class Db_model extends CI_Model {
	public function __construct()
	{
		$this->load->database();
	}

	public function afficher_pdt() {
		$query = $this->db->query("SELECT * FROM t_produit_pdt;");
		return $query->result_array();
	}
	public function pdt($id_pdt) {
		$query = $this->db->query("SELECT * FROM t_produit_pdt where pdt_id = ".$id_pdt.";");
		return $query->row();
	}

	
	
	public function ajout_panier($id_pdt,$size,$color) {
		$query = $this->db->query("INSERT INTO cart VALUES(".$id_pdt.",".$id_pdt.");
		
			INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `variant_id`, `quantity`) VALUES (NULL, '1', '4', '1');");
		return $query->row();
	}

	
	public function get_pdt_type($id_pdt) {
	    $query = $this->db->query("SELECT pdt_type FROM t_produit_pdt WHERE pdt_id = '".$id_pdt."'");
	    $result = $query->row();
	    if ($result) {
	        return $result->pdt_type;
	    }
	    return false;
	}


	public function get_color($id_pdt) {
		$query = $this->db->query("SELECT color_name from colors");
		return $query->result_array();
	}

	public function get_size($id_pdt, $type_pdt) {
	    $query = $this->db->query("SELECT size_name FROM sizes WHERE type_pdt = '".$type_pdt."'");
	    return $query->result_array();
	}


	public function verif_variant($id_pdt,$color,$size,$qte,$sexe){
				
		$query = $this->db->query("SELECT variant_id, stock FROM product_variants
										WHERE pdt_id = ".$id_pdt."
										AND color_name = '".$color."'
										AND size_name = '".$size."'
										AND sexe = '".$sexe."'

										AND ('".$qte."' <= stock);"); 
		if ($query->num_rows() <= 0){
		        return false;
		    }
		    
		    $row = $query->row();
		    if (!$row) {
		        return false;
		    }

		    return $row;
	}

	public function verif_variantjr($id_pdt, $color, $sizejr, $qte, $sexe){
		$query = $this->db->query("SELECT variant_id,stock FROM product_variants
                           WHERE pdt_id = ".$id_pdt."
                           AND color_name = '".$color."'
                           AND sizejr_name = '".$sizejr."'
                           AND sexe = '".$sexe."'
                           AND ('".$qte."' <= stock);");
		if ($query->num_rows() <= 0){
        return false;
	    }
	    
	    $row = $query->row();
	    if (!$row) {
	        return false;
	    }

	    return $row;
	}

	public function get_id($mail){
		$query = $this->db->query("SELECT cpt_id from t_compte_cpt where cpt_mail ='".$mail."' ");
		return $query->row();
	}

	public function insert_panier($cpt_id,$variant,$qte){
		$query = $this->db->query("INSERT into cart_items values(NULL, '".$cpt_id->cpt_id."', '".$variant."', '".$qte."' );");
		return ($query);
	}

	public function set_compte()
	{	
	    $this->load->helper('url');
	    $mail = $this->input->post('mail');
	    $mdp = $this->input->post('mdp');
	    $prenom = $this->input->post('prenom'); 
	    $nom = $this->input->post('nom');
		/*$salt = "OnRajouteDuSelPourAllongerleMDP123!!45678__Test";
	    $password = hash('sha256', $salt.$mdp);*/

	    $query = "SELECT * from t_compte_cpt where cpt_mail = '".$mail."';";
        $result = $this->db->query($query);

	    if($result->num_rows() <= 0)
	    {		
		 	$sql1 = "INSERT INTO t_compte_cpt (cpt_mdp, cpt_mail) VALUES ('".$mdp."', '".$mail."')";
		    $this->db->query($sql1);
		    
		    // Get the inserted id from t_compte_cpt
		    $sql2 = "SELECT LAST_INSERT_ID() as id";
		    $query = $this->db->query($sql2);
		    $row = $query->row();
		    $id = $row->id;
		    
		    $sql4 = "INSERt into cart VALUES(".$id.",".$id.");";
		    $this->db->query($sql4);
		    // Insert into t_profil_pfl table
		    $sql3 = "INSERT INTO t_profil_pfl (pfl_prenom, pfl_nom, pfl_role, cpt_id, cart_id) VALUES ('".$prenom."','".$nom."','U',".$id.",".$id.")";
		    $this->db->query($sql3);
		    return true;
		}
		else
		{
		 	return false;
		}
	}



	public function connect_compte($mail, $password)// est ce que le compte est connecte ?
	{
		/*$salt = "OnRajouteDuSelPourAllongerleMDP123!!45678__Test";
		$hashed_password = hash('sha256', $salt.$password);*/
		$query =$this->db->query("SELECT cpt_mail,cpt_mdp
		FROM t_compte_cpt
		WHERE cpt_mail='".$mail."'
		AND cpt_mdp='".$password."';");
		if($query->num_rows() > 0)
		 {
		 	return true;
		 }
		else
		 {
		 	return false;
		 }
	}

	public function get_role($mail){//recup le role d'un certain compte
			$query = $this->db-> query("SELECT pfl_role as role_uti FROM t_profil_pfl
										JOIN t_compte_cpt USING(cpt_id) 
										WHERE cpt_mail = '".$mail."' ;");
			return $query->row();
		}
	
	public function get_prenom($mail){//recuoere ke prenom
		$query = $this->db-> query("SELECT pfl_prenom as prenom FROM t_profil_pfl
									JOIN t_compte_cpt USING(cpt_id) 
									WHERE cpt_mail ='".$mail."';");
		return $query->row();
	}
	public function get_nom($mail){//recuoere ke nom
		$query = $this->db-> query("SELECT pfl_nom as nom FROM t_profil_pfl 	
									JOIN t_compte_cpt USING(cpt_id) 
									WHERE cpt_mail ='".$mail."';");
		return $query->row();
	}

			 public function get_all_mails()//recupere tous les comptes
		{
			$query = $this->db->query("SELECT cpt_mail FROM t_compte_cpt;");
			return $query->result_array();
		}

		public function get_nbcpt() //recupere le nb comptes
		{
			$query = $this->db->query("SELECT count(cpt_id) as nbc from t_compte_cpt;");
			return $query->row();
			// Quand ya un row on fait une fleche
		}

		public function get_cmds(){
			$query = $this->db->query("SELECT * FROM orders;");
			return $query->result_array();
		}
		public function get_cpt($id){
		    $query = $this->db->query("SELECT cpt_mail FROM t_compte_cpt WHERE cpt_id = '".$id."' ;");
		    return $query->row();
		}


		public function get_allcpt(){
			$query = $this->db->query("SELECT * FROM t_compte_cpt LEFT join t_profil_pfl USING(cpt_id);");
			return $query->result_array();
		}

		public function get_allpdt(){
			$query = $this->db->query("SELECT * from t_produit_pdt;");
			return $query->result_array();
		}
		public function get_variant($id){
			$query = $this->db->query("SELECT variant_id from product_variants where pdt_id ='".$id."' ;");
			return $query->result_array();
		}

		public function get_pdt_nom($id){
			$query = $this->db->query("SELECT pdt_nom from t_produit_pdt where pdt_id ='".$id."' ;");
			return $query->row();
		}
		public function supprimer_pdt($variant_id){
			$sql1 = "DELETE FROM cart_items where variant_id = '".$variant_id."'";
			$this->db->query($sql1);
			/**/
			return true;
		}

		public function supprimer_produits($id){
			$sql2 = "DELETE FROM product_variants where pdt_id = '".$id."'";

	    	$this->db->query($sql2);
			
		}

		public function sup($id){
			$query ="DELETE FROM t_produit_pdt WHERE pdt_id = '".$id."';";
			$this->db->query($query);			
			return true;
		}

		public function ajout_pdt( $prix, $prixjr, $stock, $nom, $description, $img, $dispo, $type){
		    $query = "INSERT INTO `t_produit_pdt` (`pdt_id`, `pdt_nom`, `pdt_description`,  `pdt_dispo`, `pdt_img`, `pdt_type`) VALUES
		    (NULL, '".$nom."', '".$description."',  '".$dispo."', '".$img."', '".$type."')";
		    $this->db->query($query);          
		    return true;
		}

		public function affiche_pan($cpt_id){
		    $query = $this->db->query("SELECT ci.cart_item_id,ci.cart_id, ci.variant_id, ci.quantity, pv.color_name, pv.size_name, pv.sizejr_name, pv.price,ci.quantity
		              FROM cart_items ci
		              JOIN product_variants pv ON ci.variant_id = pv.variant_id
		              WHERE cart_id = '".$cpt_id->cpt_id."';");
					
		    $result = $query->result_array();

		    /*foreach ($result as &$item) {
		        if ($item['size_name'] == '') {
		            $item['size'] = $item['sizejr_name'];
		        } else {
		            $item['size'] = $item['size_name'];
		        }
		        unset($item['size_name']);
		        unset($item['sizejr_name']);
		    }*/

		    return $result;
		}


		public function modif_pdt($pdt_id, $nom , $type, $img, $dispo){
		    $query = "UPDATE `t_produit_pdt` SET `pdt_nom` = '".$nom."', `pdt_type` = '".$type."', `pdt_img` = '".$img."', `pdt_dispo` = '".$dispo."' WHERE `t_produit_pdt`.`pdt_id` = '".$pdt_id."';";
		    $this->db->query($query);
	    	return ($query);
		}

		public function modifier_variant($pdt_id, $variant_id,  $couleur,$taille, $taillejr, $price, $stock, $sexe){
			if($taille == ""){

		    $query = "UPDATE `product_variants` SET `color_name` = '".$couleur."', `sizejr_name` = '".$taillejr."', `stock` = '".$stock."', `sexe` = '".$sexe."', price = '".$price."' WHERE  `pdt_id` = '".$pdt_id."' AND variant_id = '".$variant_id."';";
		}
		else{
			$query = "UPDATE `product_variants` SET `color_name` = '".$couleur."', `size_name` = '".$taille."', `stock` = '".$stock."', `sexe` = '".$sexe."', price = '".$price."' WHERE  `pdt_id` = '".$pdt_id."' AND variant_id = '".$variant_id."';";

		}
		    $this->db->query($query);
	    	return ($query);
		}

		public function variant($id_pdt) {
			$query = $this->db->query("SELECT * FROM `product_variants` where pdt_id = '".$id_pdt."';");
			return $query->result_array();
		}


		public function ajout_variant($pdt_id, $couleur, $taille, $choix, $price, $stock, $sexe){
			if(strcmp($choix, "adulte") == 0){
				$query = "INSERT INTO `product_variants`  VALUES
		    		(NULL,'".$pdt_id."', '".$couleur."', '".$taille."',  NULL, '".$stock."', '".$price."', '".$sexe."')";
			}
			else{
				$query = "INSERT INTO `product_variants`  VALUES
		    		(NULL,'".$pdt_id."', '".$couleur."', NULL, '".$taille."',   '".$stock."', '".$price."', '".$sexe."')";

			}
		    
		    $this->db->query($query);          
		    return true;
		}

		public function get_pfls($cpt_id){
			$query = $this->db->query("SELECT * FROM `t_profil_pfl` where cpt_id = '".$cpt_id."';");
			return $query->result_array(); 
		
		}

		public function update_cpt($cpt_id,$actif,$role){
			$query = $this->db->query("UPDATE t_profil_pfl SET pfl_role = '".$role."', compte_actif = '".$actif."' where cpt_id = '".$cpt_id."';");
			return ($query);
		}

		public function remove_from_cart($item_id)
		{
		    $query = $this->db->query("DELETE from cart_items where cart_item_id = '".$item_id."' ;");
			return ($query);
		}

		public function sizes(){
			$query = $this->db->query("SELECT * from sizes");
			return $query->result_array();
		}

		public function couleurs(){ 
			$query = $this->db->query("SELECT * from colors"); 
			return $query->result_array();
		}

		public function order(){ 
			$query = $this->db->query("SELECT * FROM `order_items` GROUP by order_id"); 
			return $query->result_array();
		}

		public function searchProducts($searchTerm){ 
			$query = $this->db->query("SELECT * FROM `t_produit_pdt` where pdt_nom LIKE '%".$searchTerm."%' OR pdt_type LIKE '%".$searchTerm."%'"); 
			if($query->num_rows() > 0)
			{
			 	return $query->result_array();
			}
			
			return false;
		}

		public function searchVariant($searchTerm){ 
			$query = $this->db->query("SELECT * FROM `product_variants` where color_name LIKE '%".$searchTerm."%' OR size_name LIKE '%".$searchTerm."%' OR sizejr_name LIKE '%".$searchTerm."%' OR stock LIKE '%".$searchTerm."%' OR price LIKE '%".$searchTerm."%' OR sexe LIKE '%".$searchTerm."%'"); 
			if($query->num_rows() > 0)
			{
			 	return $query->result_array();
			}
			
			return false;
		}
		
}


