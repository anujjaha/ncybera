<?php
class Account_model extends CI_Model {
	public function __construct()
    {
                parent::__construct();
    }
		public $table = "user_transactions";
	
	public function get_account_details($user_id) {
		$sql = "SELECT *,
				(select due from job where job.id=ut.job_id) as 'due',
				(select receipt from job where job.id=ut.job_id) as 'j_receipt',
				(select bill_number from job where job.id=ut.job_id) as 'j_bill_number',
				(select jobname from job where job.id=ut.job_id) as 'jobname',
				(select nickname from user_meta um where um.user_id=ut.creditedby) as 'receivedby'
				FROM user_transactions ut where ut.customer_id = $user_id
				ORDER by ut.id ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function credit_amount($customer_id,$data,$type=null) {
		$data['created']=date('Y-m-d H:i:s');
		$data['t_type']= CREDIT;
		if(isset($type)) {
			$data['t_type']= $type;
		}
		$data['date']=date('Y-m-d');
		$data['cmonth']=date('M-Y');
		return $this->db->insert($this->table,$data);
	}
	
	public function update_transaction($condition=null,$data=array()) {
		if($condition ) {
			$this->db->where($condition);
			$this->db->update($this->table,$data);
			return true;
		}
		return false;
	}
	
	public function get_job_transactions($job_id=null) {
		if($job_id) {
			$this->db->select('*')
					->from($this->table)
					->where('job_id',$job_id)
					->order_by('id');
			$query = $this->db->get();
			return $query->result_array();
		}
		return false;
	}
	public function update_job_transactions($job_id,$customer_id) {
		$this->db->where('job_id',$job_id);
		$this->db->update($this->table,array('customer_id'=>$customer_id));
		return true;
	}
	
	public function delete_entry($id) {
		$details = "Transaction Deleted by userid-".$this->session->userdata['user_id']." on ".date('d-m-Y h:i:s');
		$sql = "insert into user_transactions_deletion SELECT *,'".$details."' as details FROM user_transactions WHERE id =$id ";
		$query = $this->db->query($sql);
		
		$this->db->where('id',$id);
		$this->db->delete($this->table);
		
	}
	
	
}
