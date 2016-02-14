<?php
class Estimationsms_model extends CI_Model {
	public function __construct()
    {
		parent::__construct();
	}
    public $table = "estimation_sms";
    
	public function insert_estimation($data) {
		$data['created'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	
}
