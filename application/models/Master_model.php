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
	
	
	public function get_all_verified_jobs() {
		$this->db->select("*,job.id as job_id, job.created as created")
				->from($this->job_table)
				->join($this->customer_table,"customer.id = job.customer_id", 'left' )
				->where('verify_id != ',0)
				->order_by('job.id','DESC');
		$query = $this->db->get();
		
		$sql = "SELECT *,job.id as job_id,job.created as 'created',
				(select count(id) from job_views where job_views.j_id =job.id AND department = '$department') 
				as j_view,
				(select  group_concat(bill_number separator ',') as 'ref_bill_number'
				from user_transactions where user_transactions.job_id = job.id) as 't_bill_number',
				(select  group_concat(receipt separator ',') as 'ref_receipt'
				from user_transactions where user_transactions.job_id = job.id) as 't_reciept',
				
				(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus
				FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 WHERE 
				 job.verify_id != 0 
				 order by job.id DESC
				";
		
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_all_unverify_jobs() {
		$sql = "SELECT *,job.id as job_id,job.created as 'created',
				(select count(id) from job_views where job_views.j_id =job.id AND department = '$department') 
				as j_view,
				(select  group_concat(bill_number separator ',') as 'ref_bill_number'
				from user_transactions where user_transactions.job_id = job.id) as 't_bill_number',
				(select  group_concat(receipt separator ',') as 'ref_receipt'
				from user_transactions where user_transactions.job_id = job.id) as 't_reciept',
				
				(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus
				FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 WHERE 
				 job.verify_id = 0 
				 order by job.id DESC
				";
		$this->db->select("*,job.id as job_id, job.created as created")
				->from($this->job_table)
				->join($this->customer_table,"customer.id = job.customer_id", 'left' )
				->where('verify_id',0)
				->order_by('job.id','DESC');
		$query = $this->db->get();
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_dealercustomer_jobs_master()
	{
		$sql = "SELECT *,job.id as job_id,job.created as 'created',
				(select count(id) from job_views where job_views.j_id =job.id ) 
				as j_view,
				(select  group_concat(bill_number separator ',') as 'ref_bill_number'
				from user_transactions where user_transactions.job_id = job.id) as 't_bill_number',
				(select  group_concat(receipt separator ',') as 'ref_receipt'
				from user_transactions where user_transactions.job_id = job.id) as 't_reciept',
				
				(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus
				FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 WHERE 
				 job.verify_id = 0 
				 AND 
				 ( customer.ctype = 0 OR customer.ctype = 1 )
				 order by job.id DESC
				";
				
		$query = $this->db->query($sql);
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
	
	public function get_jobs_master() {
		$sql = "SELECT *,job.id as job_id FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 LEFT JOIN job_verify jv ON
				 jv.job_id = job.id
				 
				 order by job.id DESC
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_customer_jobs_master() {
		
		$sql = "SELECT *,job.id as job_id,job.created as 'created',
				(select count(id) from job_views where job_views.j_id =job.id ) 
				as j_view,
				(select  group_concat(bill_number separator ',') as 'ref_bill_number'
				from user_transactions where user_transactions.job_id = job.id) as 't_bill_number',
				
				(select  group_concat(receipt separator ',') as 'ref_receipt'
				from user_transactions where user_transactions.job_id = job.id) as 't_reciept',
				
				(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus,
				
				(select group_concat(other separator ',')  from user_transactions where user_transactions.job_id = job.id) as other_pay_ref
				
				FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 WHERE 
				 job.verify_id = 0 
				 AND customer.ctype = 0
				 order by job.id DESC
				";
				
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_dealer_jobs_master() {
		$sql = "SELECT *,job.id as job_id,job.created as 'created',
				(select count(id) from job_views where job_views.j_id =job.id ) 
				as j_view,
				(select  group_concat(bill_number separator ',') as 'ref_bill_number'
				from user_transactions where user_transactions.job_id = job.id) as 't_bill_number',
				(select  group_concat(receipt separator ',') as 'ref_receipt'
				from user_transactions where user_transactions.job_id = job.id) as 't_reciept',
				
				(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus
				FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 WHERE 
				 job.verify_id = 0 
				 AND customer.ctype = 1
				 order by job.id DESC
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_voucher_jobs_master() {
		$sql = "SELECT *,job.id as job_id,job.created as 'created',
				(select count(id) from job_views where job_views.j_id =job.id ) 
				as j_view,
				(select  group_concat(bill_number separator ',') as 'ref_bill_number'
				from user_transactions where user_transactions.job_id = job.id) as 't_bill_number',
				(select  group_concat(receipt separator ',') as 'ref_receipt'
				from user_transactions where user_transactions.job_id = job.id) as 't_reciept',
				
				(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus
				FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 WHERE 
				 job.verify_id = 0 
				 AND customer.ctype = 2
				 order by job.id DESC
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	
	public function get_today_details_master($param=null,$value=null) {
		$condition = "";
		if(!empty($param)) {
			$condition = "WHERE $param = '$value'";
		}
		$sql = "SELECT *,job.id as job_id,job.created as 'created'
				FROM job
				LEFT JOIN customer
				ON job.customer_id = customer.id
				$condition
				order by job.id DESC
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function job_categories_master() {
		$this->db->select('*')
				->from('job_details')
				->join('job','job.id=job_details.job_id','left')
				->join('customer','customer.id=job.customer_id','left')
				->order_by('job_id');
		$query = $this->db->get();
		return $query->result_array();
	}
}
