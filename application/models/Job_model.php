<?php
class Job_model extends CI_Model {
	public function __construct()
    {
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
    }
    public $table = "job";
    public $table_details = "job_details";
    public $table_customer = "customer";
	
	public function insert_job($data) {
		$data['created'] = date('Y-m-d H:i:s');
		$status = $this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	
	public function update_job($job_id=null,$data=array()) {
		if($job_id) {
			$data['modified'] = date('Y-m-d H:i:s');
			$this->db->where('id',$job_id);
			return $this->db->update($this->table,$data);
		}
		return false;
	}
	
	public function update_job_details($jobdetails_id=null,$data=array()) {
		if($jobdetails_id) {
			$data['modified'] = date('Y-m-d H:i:s');
			$this->db->where('id',$jobdetails_id);
			return $this->db->update($this->table_details,$data);
		}
		return false;
	}
	
	public function insert_jobdetails($data,$flag=null) {
		if($flag) {
			return $this->db->insert($this->table_details,$data);
		}
		$status = $this->db->insert_batch($this->table_details,$data);
		return true;
	}
	
	public function get_job_data($job_id=null) {
		if($job_id) {
			$this->db->select('*')
					->from($this->table)
					->where('id ='.$job_id);
			$query = $this->db->get();
			return $query->row();
		}
		$sql = "SELECT *,job.id as job_id FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 order by job.id DESC
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_job_details($job_id) {
		$this->db->select('*')
				->from($this->table_details)
				->where('job_id ='.$job_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_customer_details($customer_id) {
		$this->db->select('*')
				->from($this->table_customer)
				->where('id ='.$customer_id);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function get_today_details($param=null,$value=null) {
		if(empty($param)) {
			$param = 'job.jdate';	
			$value = date('Y-m-d');
		}
		$sql = "SELECT *,job.id as job_id FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 WHERE $param= '$value'
				 order by job.id DESC
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
