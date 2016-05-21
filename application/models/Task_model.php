<?php
class Task_model extends CI_Model {
	public function __construct()
    {
                parent::__construct();
    }
    public $table = "cyb_tasks";
    
    public function get_my_tasks() {
		$this->db->select('*,cyb_tasks.created as c_time,cyb_tasks.modified as m_time,  cyb_tasks.id as task_id , ( select nickname from user_meta where cyb_tasks.reply_from = user_id ) as task_reply_by ,(select group_concat(first_name," ",last_name) from user_meta where find_in_set(user_id,cyb_tasks.receiver )  ) as taskies')
				->from($this->table)
				->join('user_meta','user_meta.user_id = cyb_tasks.user_id','left')
				->where('cyb_tasks.user_id',$this->session->userdata['user_id']);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function save_task($data) {
		$data['created'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table,$data);
		return true;
	}
	
	public function load_tasks($id) {
		/*$this->db->select('*')
				->from($this->table)
				->where('receiver IN ', "(".$id.")" )
				->order_by('id','DESC');*/
		$sql = "SELECT ct.*,user_meta.nickname FROM cyb_tasks ct
			LEFT JOIN user_meta ON user_meta.id = ct.user_id
			WHERE
			find_in_set($id, ct.receiver )
			 order by ct.id DESC
			 ";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
	
	
	public function update_task($id,$data) {
		$this->db->where('id',$id);
		$this->db->update($this->table,$data);
		
	}
	
	public function delete_task($id) {
		$this->db->where('id',$id);
		$this->db->delete($this->table);
		return true;
	}
}
