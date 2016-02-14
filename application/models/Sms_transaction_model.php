<?php
class Sms_transaction_model extends CI_Model {
	public function __construct()
    {
		parent::__construct();
	}
    public $table = "sms_transaction";
    
	public function insert_sms($data) {
		$data['created'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	
}
