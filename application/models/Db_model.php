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
	public function select_pdt($id_pdt,$size, $color) {
		$query = $this->db->query("SELECT * from t_couleur_col 
								where pdt_id = ".$id_pdt." and tal_size = ".$size." and col_clr = ".$color.";");
		return $query->row();
	}
	public function get_color($id_pdt) {
		$query = $this->db->query("SELECT col_clr from t_couleur_col where pdt_id = ".$id_pdt." group by col_clr;");
		return $query->row();
	}
}

