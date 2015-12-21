<?php
class Jobview_model extends CI_Model {
	public function __construct()
    {
                parent::__construct();
    }
    public $table = "job_views";
    
    public function insert_jobview($data=array()) {
		if($data) {
			$data['created_date']=date('Y-m-d h:i:s');
			$this->db->insert($this->table,$data);
			return $this->db->insert_id();
		}
		return true;
    }
}
