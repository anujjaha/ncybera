<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('task_model');
		$data['heading'] =$data['title']="List of Tasks";
		$data['tasks'] = $this->task_model->get_my_tasks();            
		$this->template->load('task', 'index', $data);
	}
		
	public function mytask() {
		$data['heading'] = $data['title'] = "Add of Task";
		$this->load->model('task_model');
		$id = $this->session->userdata['user_id'];	
		$data['tasks'] = $this->task_model->load_tasks($id);
		$this->template->load('task', 'view', $data);
	}
	public function add() {
	$data['heading'] = $data['title'] = "Add of Task";
		
	if($this->input->post()) {
			$sdata['receiver'] = implode(",",$this->input->post('receiver'));
			$sdata['user_id'] = $this->session->userdata['user_id'];
			$sdata['title'] = $this->input->post('title');
			$sdata['details'] = $this->input->post('details');
			$sdata['status'] = TASK_CREATED;
			
			$this->load->model('task_model');
			$this->task_model->save_task($sdata);
			redirect("task/index",'refresh');
		}
		$this->template->load('task', 'add', $data);
	}
	
	
}
