<?php echo "le produit a etait efface.";
foreach ($variant_id as $variant) {
	$this->db_model->supprimer_pdt($variant);

}
redirect('compte/produits');
?>