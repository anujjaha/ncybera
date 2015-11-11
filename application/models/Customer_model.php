<?php
class Customer_model extends CI_Model {
	public function __construct()
    {
                parent::__construct();
                date_default_timezone_set('Asia/Kolkata');
    }
    public $table = "customer";
	
	public function get_customer_details($param=null,$value=null) {
		if(!empty($param)) {
			$sql = "SELECT * FROM $this->table WHERE $param = $value";
			$query = $this->db->query($sql);
			return $query->row();
		}
		$sql = "SELECT *, 
				(SELECT SUM(total) from job WHERE job.customer_id = $this->table.id)  as 'total_amount' ,
				(SELECT SUM(due) from job WHERE job.customer_id = $this->table.id)  as 'due' 
				FROM $this->table 
				order by name";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function insert_customer($data) {
		$data['created'] = date('Y-m-d H:i:s');
		$status = $this->db->insert($this->table,$data);
		$customer_id = $this->db->insert_id();
		$update_data['username'] = 'customer'.$customer_id;
		$update_data['password'] = 'customer'.$customer_id;
		$status = $this->update_customer($customer_id,$update_data);
		if($status) { return $customer_id;}
		return false;
	}
	
	public function update_customer($customer_id=null,$data) {
		if($customer_id) {
		$data['modified'] = date('Y-m-d H:i:s');
		$this->db->where('id = '.$customer_id);
		return $this->db->update($this->table,$data);
		}
		return false;
	}
}
