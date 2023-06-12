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

	
	public function get_type_name($id_pdt) {
	    $query = $this->db->query("SELECT type_name FROM t_produit_pdt WHERE pdt_id = '".$id_pdt."'");
	    $result = $query->row();
	    if ($result) {
	        return $result->type_name;
	    }
	    return false;
	}


	public function get_color($id_pdt) {
		$query = $this->db->query("SELECT color_name from colors");
		return $query->result_array();
	}

	public function get_validite($mail){
		$query = $this->db->query("SELECT compte_actif from t_compte_cpt join t_profil_pfl USING(cpt_id)  where cpt_mail ='".$mail."' ");
		return $query->row();
	}

	public function get_types(){
		$query = $this->db->query("SELECT type_name from types_pdt ;");
		return $query->result_array();
	}

	public function get_types_pdts(){
		$query = $this->db->query("SELECT type_name from types_pdt ;");
		return $query->result_array();
	}
	public function get_size($id_pdt, $type_pdt) {
	    $query = $this->db->query("SELECT size_name FROM sizes WHERE type_name = '".$type_pdt->type_name."'");
	    return $query->result_array();
	}

	// pour l'instant je peux verifier que avec la taille et l'id du produit parce que je sais pas les caracteres de la nourritures qu'il y a
	public function verif_variant_food($id_pdt,$taille){
				
		$query = $this->db->query("SELECT autre_id FROM autre_variants
										WHERE pdt_id = ".$id_pdt."
										AND size_name = '".$taille."' ;"); 
		if ($query->num_rows() <= 0){
        return false;
	    }
	    
	    $row = $query->row();
	    if (!$row) {
	        return false;
	    }

	    return $row;
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
                           
                           AND ('".$qte."' <= stock);");
		if ($query->num_rows() <= 0){
        	return false;
	    }
	    
	   	return $query->row();
	}

	public function get_id($mail){
		$query = $this->db->query("SELECT cpt_id from t_compte_cpt where cpt_mail ='".$mail."' ");
		return $query->row();
	}

	public function get_mdp($cpt_id){
		$query = $this->db->query("SELECT cpt_mdp from t_compte_cpt where cpt_id ='".$cpt_id."' ");
		return $query->row();
	}

	public function update_mdp($cpt_id, $mdp){
		$query = $this->db->query("UPDATE `t_compte_cpt` SET `cpt_mdp` = '".$mdp."' WHERE `t_compte_cpt`.`cpt_id` = '".$cpt_id."';");
		return ($query);

	}

	public function insert_panier($cpt_id,$variant,$qte){
		$query = $this->db->query("INSERT into cart_items values(NULL, '".$cpt_id."', '".$variant."','".$qte."' ,NULL);");
		return ($query);
	}

	public function set_compte()
	{	
	    $this->load->helper('url');
	    $mail = $this->input->post('mail');
	    $mdp = $this->input->post('mdp');
	    $prenom = $this->input->post('prenom'); 
	    $nom = $this->input->post('nom');

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
	public function get_pdt_type($id_pdt){
		$query = $this->db->query("select type_name FROM t_produit_pdt where pdt_id = '".$id_pdt."' ;");	
		return $query->row();
	}

	public function sup($id){
		$query ="DELETE FROM t_produit_pdt WHERE pdt_id = '".$id."';";
		$this->db->query($query);			
		return true;
	}

	public function ajout_pdt( $stock, $nom, $description, $img, $dispo, $type){
	    $query = "INSERT INTO `t_produit_pdt` (`pdt_id`, `pdt_nom`, `pdt_description`,  `pdt_dispo`, `pdt_img`, `type_name`) VALUES
	    (NULL, '".$nom."', '".$description."',  '".$dispo."', '".$img."', '".$type."')";
	    $this->db->query($query);          
	    return true;
	}

	public function affiche_pan($cpt_id){
	    $query = $this->db->query("SELECT ci.cart_item_id,ci.cart_id, ci.variant_id, ci.quantity, pv.color_name, pv.size_name, pv.sizejr_name, pv.price,ci.quantity
	              FROM cart_items ci
	              JOIN product_variants pv ON ci.variant_id = pv.variant_id
	              WHERE cart_id = '".$cpt_id."';");
				
	    $result = $query->result_array();
	    return $result;
	}


	public function modif_pdt($pdt_id, $nom , $type, $img, $dispo){
	    $query = "UPDATE `t_produit_pdt` SET `pdt_nom` = '".$nom."', `type_name` = '".$type."', `pdt_img` = '".$img."', `pdt_dispo` = '".$dispo."' WHERE `t_produit_pdt`.`pdt_id` = '".$pdt_id."';";
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

	public function modifier_variant_food($pdt_id,$variant_id, $choix, $price, $carac1, $carac2,$carac3, $type){


	    $query = "UPDATE `autre_variants` SET size_name = '".$choix."' ,`car1` = '".$carac1."', `car2` = '".$carac2."', `car3` = '".$carac3."', prix = '".$price."' WHERE  `pdt_id` = '".$pdt_id."' ;";
	    $this->db->query($query);
    	return ($query);
	}

	public function supprimer_variant($variant_id){
		$query = $this->db->query("DELETE FROM `product_variants` WHERE `product_variants`.`variant_id` = '".$variant_id."';");
		return ($query);
	}

	public function variant_food($id_pdt) {
		$query = $this->db->query("SELECT * FROM `autre_variants` where pdt_id = '".$id_pdt."';");
		return $query->result_array();
	}


	public function variant($id_pdt) {
		$query = $this->db->query("SELECT * FROM `product_variants` where pdt_id = '".$id_pdt."';");
		return $query->result_array();
	}


	public function ajout_variant($pdt_id, $couleur, $taille, $choix, $price, $stock, $sexe) {
	    // Vérifier si le variant existe déjà
	    $query = "SELECT COUNT(*) AS count FROM `product_variants` WHERE `pdt_id` = '".$pdt_id."' and  `color_name` = '".$couleur."' and sexe = '".$sexe."' ";

	    if (strcmp($choix, "adulte") == 0) {
	        $query .= " AND `size_name` = '".$taille."'";
	    } else {
	        $query .= " AND `sizejr_name` = '".$taille."'";
	    }

	    $result = $this->db->query($query);
	    $row = $result->row();

	    if ($row->count > 0) {
	        // Le variant existe déjà, ne pas l'ajouter
	        return false;
	    }

	    // Le variant n'existe pas, on peut l'ajouter à la base de données
	    if (strcmp($choix, "adulte") == 0) {
	        $query = "INSERT INTO `product_variants` VALUES (NULL, '".$pdt_id."', '".$couleur."', '".$taille."', NULL, '".$stock."', '".$price."', '".$sexe."')";
	    } else {
	        $query = "INSERT INTO `product_variants` VALUES (NULL, '".$pdt_id."', '".$couleur."', NULL, '".$taille."', '".$stock."', '".$price."', '".$sexe."')";
	    }

	    $this->db->query($query);

	    return true;
}

	public function ajout_variant_food($pdt_id,  $choix, $price, $carac1, $carac2,$carac3, $type){
		
		$query = "INSERT INTO `autre_variants`  VALUES
    		(NULL, '".$pdt_id."', '".$carac1."', '".$carac2."', '".$carac3."', '".$type->type_name."', '".$choix."', '".$price."')";
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

	public function sizes($type){

		$query = $this->db->query("SELECT * from sizes ;");
		return $query->result_array();
	}
	//where type_name = '".$type->type_name."' 
	public function couleurs(){ 
		$query = $this->db->query("SELECT * from colors"); 
		return $query->result_array();
	}

	public function order(){ 
		$query = $this->db->query("SELECT * FROM `order_items` GROUP by order_id"); 
		return $query->result_array();
	}

	public function searchProducts($searchTerm){ 
		$query = $this->db->query("SELECT * FROM `t_produit_pdt` where pdt_nom LIKE '%".$searchTerm."%' OR type_name LIKE '%".$searchTerm."%'"); 
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

	public function get_order_details($order_id){ 
		$query = $this->db->query("SELECT * FROM `order_items` WHERE order_id = '".$order_id."' ");
		return $query->result_array(); 
	}

	
	public function get_variant_details($variant_id){
		$query = $this->db->query("SELECT * from product_variants left join t_produit_pdt using(pdt_id) where variant_id ='".$variant_id."' ;");
		return $query->row();
	}
	public function get_autre_variants_details($autre_id){
		$query = $this->db->query("SELECT * from autre_variants left join t_produit_pdt using(pdt_id) where autre_id ='".$autre_id."' ;");
		return $query->row();
	}

	public function get_pdt_nom_from_vi($variant_id){
		$query = $this->db->query("SELECT pdt_nom from t_produit_pdt join product_variants USING(pdt_id) where variant_id = '".$variant_id."'; "); 
		return $query->row();
	}
	public function ajout_taille($nouv_taille,$type){
		$query = $this->db->query("INSERT INTO `sizes` (`size_name`, `type_name`) VALUES ('".$nouv_taille."', '".$type."'); ");
			return ($query);
	}

	public function ajout_type($type){
		$query = $this->db->query("INSERT INTO types_pdt VALUES ('".$type."');");
		return ($query);
	}
	public function get_prix($pdt_id){
		$query = $this->db->query("select price from product_variants where pdt_id = '".$pdt_id."' group by price"); 
		return $query->row();
	}
}


