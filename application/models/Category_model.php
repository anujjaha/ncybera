<?php
class Category_model extends CI_Model 
{
	public function __construct()
    {
                parent::__construct();
    }
    public $table = "data_categories";
    
    public function getAll() {
		$this->db->select('*')
				->from($this->table)
				->where('status', 1);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function create($data = array())
	{
		$data['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table,$data);
		return true;
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
	
	public function save_scheduler($data) {
		$data['created'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table_sc,$data);
		return true;
	}
	
	public function get_all_schedules($user_id) {
		$sql = "SELECT *,cs.id as master_id FROM cyb_schedule cs
			LEFT JOIN user_meta ON user_meta.id = cs.user_for
			WHERE
			find_in_set($user_id, cs.user_for )
			AND
			cs.status = 0 
			 order by cs.id DESC
			 ";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$return = array();
		$task = '<table border="2" align="center" width="100%">
					<tr>
						<td>Sr</td>
						<td>Title</td>
						<td>Description</td>
						<td>Reminder Time</td>
					</tr>';
		$count = 0;
		foreach($result as $data) {
			$reminder_time = strtotime($data['reminder_time']);
			$now = time();//new DateTime( date('Y-m-d H:i:s'));
			$interval  = $reminder_time - $now;
			$diff_minutes   = round($interval / 60);
			if($diff_minutes < 0) {
				
				if($data['is_sms']) {
					$sms_text = "Dear ".$data['first_name'].", Please check ".$data['title'].". Reminder Time ".$data['reminder_time'];
					$user_id = $data['id'];
					$mobile = $data['mobile'];
					send_sms($user_id=null,'',$mobile,$sms_text,0);
				}
				$count++;
				$this->task_completed($data['master_id']);
				$task .= '<tr>
							<td>'.$count.'</td>
							<td class="red">'.$data['title'].'</td>
							<td>'.$data['description'].'</td>
							<td>'.$data['reminder_time'].'</td>
							</tr>';
			} else if($diff_minutes == 0 && $diff_minutes < 2){
				
				if($data['is_sms']) {
					$sms_text = "Dear ".$data['first_name'].", Please check Task ".$data['title'].". Reminder Time ".$data['reminder_time'];
					$user_id = $data['id'];
					$mobile = $data['mobile'];
					send_sms($user_id=null,'',$mobile,$sms_text,0);
				}
				$count++;	
				$this->task_completed($data['master_id']);
				$task .= '<tr>
							<td>'.$count.'</td>
							<td class="green">'.$data['title'].'</td>
							<td>'.$data['description'].'</td>
							<td>'.$data['reminder_time'].'</td>
							</tr>';
			} else {
				continue;
			}
		}
		$task .= "</table>";
		$return['task'] = $task;
		$return['count'] = $count;
		return $return;	
	}
	
	public function task_completed($id) {
		$this->db->where('id',$id);
		$data['status'] = 1;
		$this->db->update($this->table_sc,$data);
	}

}
