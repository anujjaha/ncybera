<?php
class User_model extends CI_Model {
	public function __construct()
    {
                parent::__construct();
    }
    public $table = "job";
    public $table_users = "users";
	
    public function login_user($username=null,$password=null) {
        if(!empty($username) && !empty($password)) {
            $query = "SELECT * FROM users u
                     LEFT JOIN user_meta um ON u.id = um.user_id
                     WHERE u.username = '$username'
                     AND u.password = '$password' 
                     AND u.active = 1";
            $result = $this->db->query($query);
            return $result->row();
        }
        return false;
    }
	public function get_jobs($job_id=null,$extra = array()) {
		if($job_id) {
			$sql = "SELECT * FROM job jb 
					  LEFT JOIN customer cs ON 
					  cs.id = jb.customer_id
					  LEFT JOIN user u ON
					  u.id = jb.user_id
					  WHERE jb.id = $job_id;";
			$query = $this->db->query($sql);
			return $query->row();
		} else {
			$where = "WHERE ";
			if(!empty($extra['condition'])) {
				$sr=0;
				$and = "";
				foreach($extra['condition'] as $key => $con) {
					if(!empty($key)) {
						if($sr>0) { $and = " AND ";}
						$where = $where.$and.$this->table.".".$key."='".$con."'";	
							$sr++;
						}
				}
			}
			$sql = "SELECT *,job.id as job_id, job.created as job_created FROM job 
					  LEFT JOIN customer cs ON 
					  cs.id = job.customer_id
					  LEFT JOIN user u ON
					  u.id = job.user_id
					  $where order by job.id DESC";
			$query = $this->db->query($sql);
			return $query->result();
		}
	}
	
	public function get_leftbar_status() {
		$sql_job = "SELECT count(id) as total_jobs from job";
		$sql_dealer = "SELECT count(id) as total_dealers from customer WHERE ctype=1 AND status=1";
		$sql_customer = "SELECT count(id) as total_customers from customer WHERE ctype=0 AND status=1";
		$sql_prospect = "SELECT count(id) as total_customers from prospects ";
		
		$query_job = $this->db->query($sql_job);
		$jobcount = $query_job->row();
		
		$query_dealer = $this->db->query($sql_dealer);
		$dealercount = $query_dealer->row();
		
		$query_customer = $this->db->query($sql_customer);
		$customercount = $query_customer->row();
		
		$query_prospects = $this->db->query($sql_prospect);
		$prospectscount = $query_prospects->row();
		$data = array();
		
		$data['jobs'] = $jobcount->total_jobs;
		$data['dealers'] = $dealercount->total_dealers;
		$data['customers'] = $customercount->total_customers;
		$data['prospects'] = $prospectscount->total_customers;
		return $data;
	}
	
	public function search_customers($param=null,$flag=null) {
		$sql = "SELECT * from customer 
						WHERE  
						username LIKE '%$param%' OR
						name LIKE '%$param%' OR
						companyname LIKE '%$param%' OR
						mobile LIKE '%$param%' OR
						officecontact LIKE '%$param%' OR
						emailid LIKE '%$param%' OR
						add1 LIKE '%$param%' OR
						add2 LIKE '%$param%' OR
						city LIKE '%$param%' 
						order by id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function old_search_jobdetails($param=null,$flag=null) {
		$sql = "SELECT * from old_job_details 
						WHERE  
						cusname LIKE '%$param%' OR
						j_id LIKE '%$param%' OR
						jname LIKE '%$param%' OR
						jone LIKE '%$param%' OR
						mob LIKE '%$param%' OR
						jtwo LIKE '%$param%' OR
						jthree LIKE '%$param%' OR
						jfour LIKE '%$param%' OR
						date LIKE '%$param%' 
						order by j_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_old_job($id) {
		$this->db->select('*')
				->from('old_job_details')
				->where('j_id',$id);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function search_job($param=null) {
		$sql = "SELECT *,job.id as job_id FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 WHERE 
				 job.jobname LIKE '%$param%' OR
				 job.receipt LIKE '%$param%' OR
				 job.voucher_number LIKE '%$param%' OR
				 job.bill_number LIKE '%$param%' OR
				 job.jstatus LIKE '%$param%' OR
				 job.notes LIKE '%$param%' OR
				 job.jmonth LIKE '%$param%' OR
				 customer.username LIKE '%$param%' OR
				 customer.name LIKE '%$param%' OR
				 customer.companyname LIKE '%$param%' OR
				 customer.mobile LIKE '%$param%' OR
				 customer.officecontact LIKE '%$param%' OR
				 customer.emailid LIKE '%$param%' OR
				 customer.add1 LIKE '%$param%' OR
				 customer.add2 LIKE '%$param%' OR
				 customer.city LIKE '%$param%' 
				 order by job.id DESC
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function search_jobdetails($param=null) {
		$sql = "SELECT * from job_details jd 
						WHERE
						jd.jtype LIKE '%$param%' OR
						jd.jdetails LIKE '%$param%' 
						order by jd.job_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function save_courier($j_id,$data=array()) {
		if($j_id) {
			$this->db->select('id')
						->from('courier_services')
						->where('j_id',$j_id);
			$o_query = $this->db->get();
			$result = $o_query->result_array();
			if(count($result) > 0 ) {
				$this->db->where('j_id',$j_id);
				$this->db->update('courier_services',$data);
				return true;
			}
			$query = $this->db->insert('courier_services',$data);
			return true;
		}
	}
	
	public function get_courier($j_id) {
		$this->db->select('*')
					->from('courier_services')
					->where('j_id',$j_id);
		$o_query = $this->db->get();
		if($o_query->row()) {
			return $o_query->row();
		}
		return false;
	}
	
	public function search_print($term=null) {
		$result = array();
		if($term) {
			
		}
		return $result;
	}
	
	public function get_all_users() {
		$this->db->select('*')
				->from($this->table_users)
				->join('user_meta','user_meta.user_id=users.id','left')
				->order_by('user_meta.nickname');
		$query = $this->db->get();
		return 	$query->result_array();
	}
	
	public function update_user($user_id=null,$data=array()) {
		if($user_id) {
			$this->db->where('id',$user_id);
			$data['modified'] = date('Y-m-d H:i:s');
			$this->db->update('users',$data);
			return true;
		}
		return false;
	}
	
	public function create_user($data=array()) {
		if($data) {
			$this->db->insert('users',$data);
			return $this->db->insert_id();
		}
		return false;
	}
	public function create_user_meta($data=array()) {
		if($data) {
			$this->db->insert('user_meta',$data);
			return $this->db->insert_id();
		}
		return false;
	}
	
	public function mydb() {
		$sql = "select id,customer_id,total from job order by id";
		$query = $this->db->query($sql);
		$i = 0;
		foreach($query->result_array() as $jdata ) {
				//print_r($jdata);die;
			$up_query = "Update user_transactions ut 
							SET ut.amount = ".$jdata['total']."
							WHERE
							ut.customer_id = ".$jdata['customer_id']."
							AND
							ut.job_id = ".$jdata['id']."
							AND
							ut.t_type = 'debit'
						";
			//echo $up_query;die;
			$this->db->query($up_query);
			$i++;
		}
		return $i;
	}
}
