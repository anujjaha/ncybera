<?php
class Dealer_model extends CI_Model {
	public function __construct()
    {
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
    }
    public $table = "customer";
	
	public function get_dealer_details($param=null,$value=null) {
		if(!empty($param)) {
			$sql = "SELECT * FROM $this->table WHERE $param = $value";
			$query = $this->db->query($sql);
			return $query->row();
		}
		$sql = "SELECT *, 
				(SELECT SUM(total) from job WHERE job.customer_id = $this->table.id)  as 'total_amount' ,
				(SELECT SUM(due) from job WHERE job.customer_id = $this->table.id)  as 'due' 
				FROM $this->table WHERE ctype=1
				order by name";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_voucher_customer_details($param=null,$value=null) {
		if(!empty($param)) {
			$sql = "SELECT * FROM $this->table WHERE $param = $value";
			$query = $this->db->query($sql);
			return $query->row();
		}
		$sql = "SELECT *, 
				(SELECT SUM(total) from job WHERE job.customer_id = $this->table.id)  as 'total_amount' ,
				(SELECT SUM(due) from job WHERE job.customer_id = $this->table.id)  as 'due' 
				FROM $this->table WHERE ctype=2
				order by name";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function get_outstation_customer_details($param=null,$value=null) {
		if(!empty($param)) {
			$sql = "SELECT * FROM $this->table WHERE $param = $value";
			$query = $this->db->query($sql);
			return $query->row();
		}
		$sql = "SELECT *, 
				(SELECT SUM(total) from job WHERE job.customer_id = $this->table.id)  as 'total_amount' ,
				(SELECT SUM(due) from job WHERE job.customer_id = $this->table.id)  as 'due' 
				FROM $this->table WHERE ctype=3
				order by name";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function insert_dealer($data) {
		$status = $this->db->insert($this->table,$data);
		$dealer_id = $this->db->insert_id();
		$update_data['ctype'] 	= 1;
		$update_data['username'] = 'dealer'.$dealer_id;
		$update_data['password'] = 'dealer'.$dealer_id;
		$update_data['dealercode'] = 'D-'.$dealer_id;
		$update_data['created'] = date('Y-m-d H:i:s');
		$status = $this->update_dealer($dealer_id,$update_data);
		if($status) { return $dealer_id;}
	}
	
	public function update_dealer($dealer_id=null,$data) {
		if($dealer_id) {
		$data['modified'] = date('Y-m-d H:i:s');
		$this->db->where('id = '.$dealer_id);
		return $this->db->update($this->table,$data);
		}
		return false;
	}
}
