<?php //echo "le produit a etait efface.";
foreach ($variant_id as $variant) {
	$this->db_model->supprimer_pdt($variant['variant_id']);

}
?>
<h4>Produits supprime</h4>
<button onclick="window.location='<?php echo base_url(); ?>index.php/compte/produits'" class="btn btn-success">Page des produits</button>
