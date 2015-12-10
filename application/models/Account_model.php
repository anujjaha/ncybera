<?php
class Account_model extends CI_Model {
	public function __construct()
    {
                parent::__construct();
    }
		public $table = "user_transactions";
	
	public function get_account_details($user_id) {
		$sql = "SELECT *,(
				select due from job where job.id=ut.job_id) as 'due',
				(select jobname from job where job.id=ut.job_id) as 'jobname',
				(select nickname from user_meta um where um.user_id=ut.creditedby) as 'receivedby'
				FROM user_transactions ut where ut.customer_id = $user_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function credit_amount($customer_id,$data) {
		$data['created']=date('Y-m-d H:i:s');
		return $this->db->insert($this->table,$data);
	}
}
