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
          if($this->session->userdata['login']) {
              $this->dashboard();
          }
        }
        
        public function logout() {
            $set_data = array('user_id'=>null,'login'=>"0",'department'=>null,'username'=>null,'mobile'=>null);
            $this->session->unset_userdata($array_items);
            $this->session->sess_destroy(); 
            session_destroy();
            $this->session->set_userdata($set_data);
            redirect("user/login/",'refresh');
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
	
	function login() {
            $this->load->helper(array('form'));
            $data=array();
            if($this->input->post()) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $result = $this->user_model->login_user($username,$password);
                if($result) {
                    $set_data = array('login'=>true,'user_id'=>$result->id,'department'=>$result->department,
                                       'username'=>$result->nickname,'mobile'=>$result->mobile,
                                       'profile_pic'=>$result->profile_pic
                                       );
                $this->session->set_userdata($set_data);
                redirect("user/dashboard/",'refresh');
                } else {
                    $this->session->set_flashdata('msg', 'Invalid Credentials');
                }
            } else {
               $this->session->sess_destroy(); 
            }
            $data['title'] = $data['heading']="Login";
            $this->load->view('login_view',$data);
	 }
         
         
}
