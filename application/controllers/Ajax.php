<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
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
}
