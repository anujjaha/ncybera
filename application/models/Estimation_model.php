<?php
class Estimation_model  extends CI_Model 
{
	public function __construct()
    {
                parent::__construct();
    }

    public $table = "estimations";
	
	public function getAllEtimations()
	{
		$this->db->select("*")
			->from($this->table)
			->order_by("id", "DESC");
		
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function createNewEstimation($data)
	{
		$this->db->insert($this->table, $data);
		
		return $this->db->insert_id();
	}
}
