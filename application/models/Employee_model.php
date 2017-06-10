<?php
class Employee_model extends CI_Model
{
	public function __construct()
    {
		parent::__construct();
    }
    
    public $table = "employees";
    
    public function getAllEmployees() {
		$this->db->select('*')
				->from($this->table);
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function createEmployee($data=array())
	{
		if(is_array($data) && count($data))
		{
			$status = $this->db->insert($this->table,$data);
			return $this->db->insert_id();
		}
		
		return false;
	}
	
	public function getEmployeeById($employeeId = null)
	{
		if($employeeId)
		{
			$this->db->select('*')
				->from($this->table)
				->where('id', $employeeId);
			
			$query = $this->db->get();
			
			return $query->row(); 
		}
		
		return false;
	}
	
	public function deleteEmployee($id=null) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->delete($this->table);
			return true;
		}
		return false;
	}
	
	public function updateEmployee($id=null, $data) {
		if($id)
		{
			$this->db->where('id',$id);
			$this->db->update($this->table,$data);
			return true;
		}
		return false;
	}
}
