<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

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
	public function index() {
		$this->load->model('master_model');
		$data = array();
		$data['heading'] = $data['title']="Master Admin";
		$data['statstics'] = get_master_statistics();
		$data['unverify_jobs'] = $this->master_model->get_all_unverify_jobs();
		$this->template->load('master', 'index', $data);
	}
	
	public function unverifyjobs() {
		$this->load->model('master_model');
		$data = array();
		$data['heading'] = $data['title']="Unverified Job List";
		$data['unverify_jobs'] = $this->master_model->get_all_unverify_jobs();
		$this->template->load('master', 'unverifyjobs', $data);
	}
	
	public function verifyjobs() {
		$this->load->model('master_model');
		$data = array();
		$data['heading'] = $data['title']="Verified Job List";
		$data['unverify_jobs'] = $this->master_model->get_all_verified_jobs();
		$this->template->load('master', 'verifiedjobs', $data);
	}
	
	public function all() {
		$this->load->model('master_model');
		$data = array();
		$data['heading'] = $data['title']="Master Admin - All Jobs";
		$data['all_jobs'] = $this->master_model->get_jobs_master();
		$this->template->load('master', 'all_jobs', $data);
	}
	
	public function manage_users() {
		$this->load->model('user_model');
		$data['heading'] = $data['title']="Master Admin - Manage Users";
		$data['users'] = $this->user_model->get_all_users();
		$this->template->load('master', 'users', $data);
	}
	
	public function add() {
		if($this->input->post()) {
			$this->load->model('user_model');
			$udata['username'] = $this->input->post('username');
			$udata['password'] = $this->input->post('password');
			$udata['department'] = $this->input->post('department');
			$user_id = $this->user_model->create_user($udata);
			
			$mdata['user_id'] = $user_id;
			$mdata['first_name'] = $this->input->post('first_name');
			$mdata['last_name'] = $this->input->post('last_name');
			$mdata['nickname'] = $this->input->post('first_name')." ".$this->input->post('last_name');
			$mdata['mobile'] = $this->input->post('mobile');
			$mdata['emailid'] = $this->input->post('emailid');
			$mdata['address'] = $this->input->post('address');
			$meta_user_id = $this->user_model->create_user_meta($mdata);
			$this->manage_users();
		}
		$data['heading'] = $data['title']="Master Admin - Create User";
		$this->template->load('master', 'add', $data);
	}
	
	public function today_orders() {
		$this->load->model('master_model');
		$jdate = date('Y-m-d');
		$data['heading'] = $data['title']="Master Admin - Today Orders - ".$jdate;
		$data['jobs'] = $this->master_model->get_today_details_master('jdate',$jdate);
		$data['statstics'] = get_master_statistics();
		$this->template->load('master', 'orders', $data);
	}
	public function monthly_orders() {
		$this->load->model('master_model');
		$jmonth = date('M-Y');
		$data['heading'] = $data['title']="Master Admin - Monthly Orders - ".$jmonth;
		$data['jobs'] = $this->master_model->get_today_details_master('jmonth',$jmonth);
		$data['statstics'] = get_master_statistics();
		$this->template->load('master', 'orders', $data);
	}
	public function search_master() {
		$data=array();
		$this->load->model('user_model');
		$data['heading'] = $data['title']="Search Result";
		$data['search']="";
		if($this->input->post('q')) {
			$search = $this->input->post('q');
			$data['dealers'] = $data['customers'] = $this->user_model->search_customers($search);
			$data['job_data'] = $this->user_model->search_job($search);
			$data['job_details'] = $this->user_model->search_jobdetails($search);
			$data['search']=$search;
		}
		$this->template->load('master', 'search_master', $data);
	}
	
	public function job_category() {
		$this->load->model('master_model');
		$data = array();
		$data['job_categories'] = $this->master_model->job_categories_master();
		$data['heading'] = $data['title']="Master - Job Categories";
		$this->template->load('master', 'job_categories', $data);
	}
	public function migration() {
			$this->load->model('master_model');
			$this->master_model->user_migration();
	}
}
