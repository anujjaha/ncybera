<?php
class Master_model extends CI_Model {
	public function __construct()
    {
		parent::__construct();
	}
    public $job_table = "job";
    public $customer_table = "customer";
    public function get_master_statistics() {
		$today_date = date('Y-m-d');
		$current_month = date('M-Y');
		$result = array();
		$this->db->select('count(id) as total_job')
				->from($this->job_table)
				->where('jdate',$today_date);
		$today_job = $this->db->get();
		$result['today_job_count'] = $today_job->row()->total_job;
		
		$this->db->select('sum(total) as total_collection')
				->from($this->job_table)
				->where('jdate',$today_date);
		$today_collection = $this->db->get();
		$result['today_total_collection'] = $today_collection->row()->total_collection;
		
		$this->db->select('count(id) as month_job')
				->from($this->job_table)
				->where('jmonth',$current_month);
		$month_job = $this->db->get();
		$result['total_month_job'] = $month_job->row()->month_job;
		
		$this->db->select('sum(total) as month_collection')
				->from($this->job_table)
				->where('jmonth',$current_month);
		$month_collection = $this->db->get();
		$result['total_month_collection'] = $month_collection->row()->month_collection;
		return $result;
	}
	
	public function get_all_unverify_jobs() {
		$this->db->select("*,job.id as job_id")
				->from($this->job_table)
				->join($this->customer_table,"customer.id = job.customer_id", 'left' )
				->where('verify_id',0)
				->order_by('job.id','DESC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function user_migration() {
		$this->db->select('*')
				->from('nportal_customers')
				->order_by('cusname');
		$query = $this->db->get();
		
		foreach($query->result_array() as $data ) {
			$cusdata = array();
			$cusdata['companyname'] = $cusdata['name'] = $data['cusname'];
			$cusdata['mobile'] = $data['mob'];
			$cusdata['created'] = date('Y-m-d H:i:s');
			$this->db->insert('bk_customer',$cusdata);
			$cus_id = $this->db->insert_id();
			$updata = array();
			$updata['username']= $updata['password'] = "customer".$cus_id;
			$this->db->where('id',$cus_id);
			$this->db->update('bk_customer',$updata);
		}
	}
}
