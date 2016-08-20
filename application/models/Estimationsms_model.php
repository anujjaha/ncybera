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
	public function get_all_estimations() {
		$this->db->select('estimation_sms.*, estimation_sms.id as sms_id,user_meta.nickname,customer.name,customer.companyname,prospects.name as prospectname')
				 ->from($this->table)
				 ->join('customer','estimation_sms.customer_id = customer.id','left')
				 ->join('prospects','estimation_sms.prospect_id = prospects.id','left')
				 ->join('user_meta','estimation_sms.user_id = user_meta.user_id','left')
				 ->order_by('estimation_sms.id','desc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
}
