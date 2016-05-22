<?php
class Directory_model extends CI_Model {
	public function __construct()
    {
                parent::__construct();
    }
    public $table = "cyb_directory";
    
    public function get_all() {
		$this->db->select('*')
				->from($this->table)
				->order_by("name");
		$query = $this->db->get();
		return $query->result_array();
	}
	public function insert_data($data) {
		$data['created'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table, $data);
		return true;
	}
	
	public function del_data($id) {
		$this->db->where('id',$id);
		$this->db->delete($this->table);
	}
	
	public function get_single($id) {
		$this->db->select('*')
			->from($this->table)
			->where('id',$id);
		$query = $this->db->get();
		return $query->row(); 
	}
	
	public function update_data($id,$data) {
		$data['modified'] = date('Y-m-d H:i:s');
		$this->db->where('id',$id);
		$this->db->update($this->table,$data);
		return true;
	}
}
