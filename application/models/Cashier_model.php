<?php
class Cashier_model extends CI_Model
{
	public function __construct()
    {
		parent::__construct();
    }
    
    public $table = "cashier";
    
    public function getAllCashier() 
    {
		$this->db->select('*')
				->from($this->table);
				
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function getLastRecord() 
    {
		$this->db->select('*')
				->from($this->table)
				->order_by('id', 'DESC')
				->limit(1);
				
		return $this->db->get()->row();
	}
	
	public function createCashier($data=array())
	{
		if(is_array($data) && count($data))
		{
			$data['today'] 		= date('Y-m-d');
			$data['created_by'] = $this->session->userdata['user_id'];
			$data['created_at'] = date('Y-m-d H:i:s');
			
			$status = $this->db->insert($this->table, $data);
			return $this->db->insert_id();
		}
		
		return false;
	}
	
	public function getAttendanceById($employeeId = null)
	{
		if($employeeId)
		{
			$this->db->select('*')
				->from($this->table)
				->where('emp_id', $employeeId);
			
			$query = $this->db->get();
			
			return $query->row(); 
		}
		
		return false;
	}
	
	public function getAllAttendanceById($employeeId = null)
	{
		if($employeeId)
		{
			$this->db->select('*')
				->from($this->table)
				->where('emp_id', $employeeId);
			
			$query = $this->db->get();
			
			return $query->result_array(); 
		}
		
		return false;
	}
	
	
	
	/*public function deleteEmployee($id=null) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->delete($this->table);
			return true;
		}
		return false;
	}*/
	
	/*public function updateEmployee($id=null, $data) {
		if($id)
		{
			$this->db->where('id',$id);
			$this->db->update($this->table,$data);
			return true;
		}
		return false;
	}*/
}
