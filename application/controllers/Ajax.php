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
		$this->load->model('user_model');
		$job_data = $this->job_model->get_job_data($job_id);
		$job_details = $this->job_model->get_job_details($job_id);
		$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
		$data['customer_details']=$customer_details;
		$data['job_details']=$job_details;
		$data['job_data']=$job_data;
		$data['heading'] = $data['title']='View Job';
		$data['courier'] = $this->user_model->get_courier($job_id);
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
	
	public function ajax_job_datatable($param='jdate',$value) {
		$this->load->model('job_model');
		$data = array();
		if(! $value) {
			$value = "'".date('Y-m-d')."'";
		}
		$data['jobs'] = $this->job_model->get_today_details("job.$param","$value");
		$this->load->view('ajax/job_datatable', $data);
	}
	public function ajax_cutting_datatable($param='jstatus',$value='Pending') {
		$this->load->model('job_model');
		$data = array();
		$data['jobs'] = $this->job_model->get_today_cutting_details();
		$this->load->view('ajax/cutting_datatable', $data);
	}
	
	public function ajax_job_count($param='jdate',$value) {
		$this->load->model('job_model');
		if(! $value) {
			$value = "'".date('Y-m-d')."'";
		}
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
	
	public function save_courier($job_id=null){ 
		if($job_id) {
			$this->load->model('user_model');
			$data['j_id'] = $job_id;
			$data['courier_name'] = $this->input->post('courier_name');
			$data['docket_number'] = $this->input->post('docket_number');
			$data['user_id'] = $this->session->userdata['user_id'];
			$data['created'] = date('Y-m-d H:i:s');
			$this->user_model->save_courier($job_id,$data);
		}
		return true;
	}
	
	public function create_estimation() {
		if($this->input->post()) {
			$this->load->model('estimationsms_model'); 	
			$customer_id = $this->input->post('customer_id');
			$customer_email = $this->input->post('customer_email');
			$sms_message = $this->input->post('sms_message');
			$sms_mobile = $this->input->post('sms_mobile');
			$sms_customer_name = $this->input->post('sms_customer_name');
			$prospect_id = 0;	
			if($this->input->post('prospect') && $this->input->post('prospect') == 1) {
				$this->load->model('customer_model');
				$pdata['name']= $sms_customer_name;
				$pdata['mobile']= $sms_mobile;
				$pdata['ccategory']= 'General-Estimation';
				$prospect_id = $this->customer_model->insert_prospect($pdata);
			}
			
			$quote_data['customer_id'] = $customer_id;
			$quote_data['prospect_id'] = $prospect_id;
			$quote_data['sms_message'] = $sms_message;
			$quote_data['mobile'] = $mobile = $sms_mobile;
			$quote_data['user_id'] = $user_id =  $this->session->userdata['user_id'];
			$quote_id = $this->estimationsms_model->insert_estimation($quote_data);
			$sms_text = "Dear ".$sms_customer_name.", ".$sms_message." 5% VAT Extra.Quote No. ".$quote_id." valid for 7 days.";
			send_sms($user_id,$customer_id,$mobile,$sms_text,$prospect_id);
			if($customer_email) {
					send_mail($customer_email,'er.anujjaha@gmail.com','Estimation - Cybera',$sms_text);
			}
			echo $sms_text;
		}
		return true;
	}
	
	public function get_cutting_details_by_job_detail($id,$job_id) {
		$this->load->model('job_model');
		$jdetails = $this->job_model->get_job_details_by_param('id',$id);
		$cutting_details = $this->job_model->get_cutting_details_by_job_detail($job_id,$jdetails->jdetails);
		echo json_encode($cutting_details);
		die();
	}
	
	public function ajax_update_cutting_details($job_details_id,$job_id,$sr) {
		
		$this->load->model('job_model');
		$jdetails = $this->job_model->get_job_details_by_param('id',$job_details_id);
		$data['cutting_details'] = $this->job_model->get_cutting_details_by_job_detail($job_id,$jdetails->jdetails);
		$data['jdetails'] = $jdetails;
		$data['j_id'] = $job_id;
		$data['sr'] = $sr;
		$this->load->view('ajax/update_cutting',$data);
	}
	
	public function save_edit_cutting_details() {
		if($this->input->post()) {
			$this->load->model('job_model');
			$data = $this->input->post();
			unset($data['update']);
			unset($data['cutting_id']);
			$id = $this->input->post('cutting_id');
			$data['j_id'] = $this->input->post('j_id');
			if(!$id) {
				$this->job_model->insert_cuttingdetails($data,true);
			}
			$this->job_model->update_cutting_details($id,$data);
			return true;
		}
	}
	
	public function pay_job($job_id=null) {
		if($job_id) {
			$this->load->model('job_model');
			$data = array();
			$data['settlement_amount'] = $this->input->post('settlement_amount');
			$data['due'] = 0;
			$data['jpaid'] = 1;
			$this->job_model->update_job($job_id,$data);
			return true;
		}
	}
	
	public function ajax_get_customer($customer_id=null) {
		if($customer_id) {
			$this->load->model('job_model');
			$data = $this->job_model->get_customer_details($customer_id);
			echo json_encode($data);
		die();
		}
		return false;
	}
	
	public function ajax_customer_details_by_param($param=null,$value=null) {
		if($param && $value) {
			$this->load->model('customer_model');
			$data = $this->customer_model->get_customer_details($param,$value);
			if( count($data) > 0 ) {
				echo $data->companyname ? $data->companyname : $data->name;
			}
		}
		return true;
	}
	
	public function ajax_job_short_details($job_id=null) {
		if(! $job_id) {
			return true;
		}
		$this->load->model('job_model');
		$this->load->model('user_model');
		$job_data = $this->job_model->get_job_data($job_id);
		$job_details = $this->job_model->get_job_details($job_id);
		$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
		$data['customer_details']=$customer_details;
		$data['job_details']=$job_details;
		$data['job_data']=$job_data;
		$data['heading'] = $data['title']='View Job';
		$data['courier'] = $this->user_model->get_courier($job_id);
		$this->load->view('ajax/view_short_job', $data);
	}
	
	public function ajax_job_verify($job_id=null) {
		if($this->input->post()) {
			$this->load->model('job_model');
			$jdata['job_id'] = $job_id;
			$jdata['user_id'] = $this->session->userdata['user_id'];
			$jdata['notes'] = $this->input->post('notes');
			$verify_id = $this->job_model->verify_job_by_user($jdata);
			$data['bill_number'] = $this->input->post('bill_number');
			$data['receipt'] = $this->input->post('receipt');
			$data['voucher_number'] = $this->input->post('voucher_number');
			$data['verify_id'] = $verify_id;
			$this->job_model->update_job($job_id,$data);
			print_r($data);
			return true;
		}
	}
	
	public function update_user_status($user_id=null,$status) {
		if($user_id) {
			$data['active'] = 1;
			if($status == 1 ) {
				$data['active'] = 0;
			}
			$this->load->model('user_model');
			return $this->user_model->update_user($user_id,$data);
		}
		return false;
	}
	
	public function ajax_switch_customer($id=null,$roll=0) {
		if($id) {
			$this->load->model('customer_model');
			$customer_info = $this->customer_model->get_customer_details('id',$id);
			$update_customer = array();
			//Convert to Customer
			if($roll == 0 ) {
				$update_customer['username'] = $update_customer['password'] = 	"customer".$customer_info->id;
				$update_customer['ctype'] = 0;
				$update_customer['dealercode'] = "";
			}
			//Convert to Dealer
			if($roll == 1 ) {
				$update_customer['username'] = $update_customer['password'] = 	"dealer".$customer_info->id;
				$update_customer['ctype'] = 1;
				$update_customer['dealercode'] = "D-".$customer_info->id;
			}
			$this->customer_model->update_customer($id,$update_customer);
				return true;
		}
		return false;
	}
	
	public function ajax_delete($id=null) {
		if($id) {
			$this->load->model('customer_model');
			return $this->customer_model->delete_customer($id);
		}
		return false;
	}
}

