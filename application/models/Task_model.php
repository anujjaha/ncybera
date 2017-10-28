<?php
class Task_model extends CI_Model {
	public function __construct()
    {
                parent::__construct();
    }
    public $table = "cyb_tasks";
    public $table_sc = "cyb_schedule";
    
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

	public function update_schedule($id,$data) 
	{
		$this->db->where('id',$id);
		$this->db->update($this->table_sc, $data);
		
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
		$snoozeId = 0;
		foreach($result as $data) {

			$snoozeId = $data['master_id'];
			$reminder_time = strtotime($data['reminder_time']);
			$now = time();//new DateTime( date('Y-m-d H:i:s'));
			$interval  = $reminder_time - $now;
			$diff_minutes   = round($interval / 60);
			if($diff_minutes < 0) {
				
				if($data['is_sms']) {
					$sms_text = "Dear ".$data['first_name'].", Please check ".$data['title'].". Reminder Time ".$data['reminder_time'];
					$user_id = $data['id'];
					$mobile = $data['mobile'];
					send_sms($user_id,0,$mobile,$sms_text,0);
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

		$nextSchedule = date('Y/m/d H:i', strtotime('now +1 hour'));
		$task .= "</table>";
		$task .= '<div class="row"><div class="col-md-3"><span id="setSnooze" data-id="'.$snoozeId.'"  class="btn btn-primary">Snooze</span></div><div class="col-md-6"><input type="text" name="re_reminder_time"  id="re_reminder_time" value="'.$nextSchedule.'"  class="form-control datepicker" required="required"> </div></div>';

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
