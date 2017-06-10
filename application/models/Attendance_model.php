<?php
class Attendance_model extends CI_Model
{
	public function __construct()
    {
		parent::__construct();
    }
    
    public $table = "attendance";
    
    public function getAllAttendance() 
    {
		$lastMonth  = date('F', strtotime('last month'));
		$curretYear = date('Y', strtotime('last month'));
		
		$this->db->select('*, attendance.id as id')
				->from($this->table)
				->join('employees', 'employees.id = attendance.emp_id', 'left')
				->where('month', $lastMonth)
				->where('year', $curretYear);
				
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function createAttendance($data=array())
	{
		if(is_array($data) && count($data))
		{
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
