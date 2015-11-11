<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
	}

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
		
		$this->load->helper(array('form'));
		$this->load->view('login_view');
		
	}
	
	public function dashboard() {
		/*$today = date("Y-m-d");
		$condition = array('condition'=>array('jdate'=>$today))	;
		$result = $this->user_model->get_jobs('',$condition);
		$data['title']="Dashboard";
		$data['heading']="Dashboard";
		$data['jobs']= $result;*/
		$this->load->model('job_model');
		$data = array();
		$data['jobs'] = $this->job_model->get_today_details();
		/*foreach($jobs as $job) {
			$jd = $this->job_model->get_job_details($job['job_id']);	
		}*/
		$data['title']="Job - Cybera Print Art";
		$data['heading']="Jobs";
		$this->template->load('user', 'index', $data);
	}
	public function admin()
	{
		$today = date("Y-m-d");
		$condition = array('condition'=>array('jdate'=>$today))	;
		$result = $this->user_model->get_jobs('',$condition);
		$data['title']="Dashboard";
		$data['heading']="Dashboard";
		$data['today_jobs']="15";
		$data['today_counter']="100";
		$data['total_dealers']="12";
		$data['total_customers']="100";
		$data['jobs']= $result;
		$this->template->load('user', 'index', $data);
	}
	
	public function get_leftbar_status() {
		$data = $this->user_model->get_leftbar_status();
		echo json_encode($data,true);
		die;
	}
	
	public function search() {
		$data=array();
		$data['title']="Search Result";
		$data['heading']="Search Result";
		$data['search']="";
		if($this->input->post('q')) {
			$search = $this->input->post('q');
			$data['dealers'] = $data['customers'] = $this->user_model->search_customers($search);
			$data['job_data'] = $this->user_model->search_job($search);
			$data['job_details'] = $this->user_model->search_jobdetails($search);
			$data['search']=$search;
		}
		$this->template->load('user', 'search', $data);
	}
	
	function login($username, $password) {
	   $this -> db -> select('id, username, password');
	   $this -> db -> from('user');
	   $this -> db -> where('username', $username);
	   $this -> db -> where('password', MD5($password));
	   $this -> db -> limit(1);
	 
	   $query = $this->db->get();
	 
	   if($query->num_rows() == 1)
	   {
		 return $query->result();
	   }
	   else
	   {
		 return false;
	   }
	 }
}
