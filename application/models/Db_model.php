<?php
class Db_model extends CI_Model {
	public function __construct()
	{
		$this->load->database();
	}

	public function afficher_pdt()
	{
		$query = $this->db->query("SELECT * FROM t_produit_pdt;");
		return $query->result_array();
	}
	public function pdt($id_pdt)
	{
		$query = $this->db->query("SELECT * FROM t_produit_pdt where pdt_id = $id_pdt;");
		return $query->result_array();
	}
}
