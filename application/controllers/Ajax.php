<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function ajax_job_view() {
		if($this->input->post()) {
			$this->load->model('jobview_model');
			$data=array();
			$data['department'] = $this->input->post('department');
			$data['j_id'] = $this->input->post('id');
			$data['user_id'] = $this->session->userdata['user_id'];
			$data['view_time'] = date('h:i');
			$data['view_date'] = date('Y-m-d');
			$this->jobview_model->insert_jobview($data);
			return true;
		}
		
	}
	public function ajax_job_details($job_id=null) {
		if(! $job_id) {
			return true;
		}
		$this->load->model('job_model');
		$job_data = $this->job_model->get_job_data($job_id);
		$job_details = $this->job_model->get_job_details($job_id);
		$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
		$data['customer_details']=$customer_details;
		$data['job_details']=$job_details;
		$data['job_data']=$job_data;
		$data['heading'] = $data['title']='View Job';
		$this->load->view('ajax/view_job', $data);
	}
	
	public function ajax_cutting_details($job_id=null) {
		if(! $job_id) {
			return true;
		}
		$this->load->model('job_model');
		$job_data = $this->job_model->get_job_data($job_id);
		$job_details = $this->job_model->get_job_details($job_id);
		$cutting_details = $this->job_model->get_cutting_details($job_id);
		$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
		$data['customer_details']=$customer_details;
		$data['cutting_details']=$cutting_details;
		$data['job_details']=$job_details;
		$data['job_data']=$job_data;
		$data['heading'] = $data['title']='View Job';
		$this->load->view('ajax/view_cutting', $data);
	}
	
	public function ajax_job_datatable($param='jstatus',$value='Pending') {
		$this->load->model('job_model');
		$data = array();
		$data['jobs'] = $this->job_model->get_today_details();
		$this->load->view('ajax/job_datatable', $data);
	}
	public function ajax_cutting_datatable($param='jstatus',$value='Pending') {
		$this->load->model('job_model');
		$data = array();
		$data['jobs'] = $this->job_model->get_today_cutting_details();
		$this->load->view('ajax/cutting_datatable', $data);
	}
	
	public function ajax_job_count($param='jstatus',$value='Pending') {
		$this->load->model('job_model');
		$data = array();
		$data['jobs'] = count($this->job_model->get_today_details("job.$param","$value"));
		echo $data['jobs'];return true;
	}
	public function ajax_cutting_count($param='jstatus',$value='Pending') {
		$this->load->model('job_model');
		$data = array();
		$data['jobs'] = count($this->job_model->get_today_cutting_details());
		echo $data['jobs'];return true;
	}
	
	public function ajax_jobstatus_history($job_id=null) {
		if($job_id) {
			$this->load->model('job_model');
			$data['job_data'] = $this->job_model->get_job_data($job_id);
			$data['job_history'] = $this->job_model->job_status_history($job_id);
			$this->load->view('ajax/job_history', $data);
		}
	}
}
