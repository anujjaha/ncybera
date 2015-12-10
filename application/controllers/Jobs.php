<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		//$this->load->model('dealer_model');
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
		$this->load->model('job_model');
		$data = array();
		$data['jobs'] = $this->job_model->get_job_data();
		
		//echo "<pre>";
		//print_r($data);die;
	
		/*foreach($jobs as $job) {
			$jd = $this->job_model->get_job_details($job['job_id']);	
		}*/
		$data['title']="Job - Cybera Print Art";
		$data['heading']="Jobs";
		$this->template->load('job', 'index', $data);
	}
	public function edit($job_id=null)
	{
		$data['title']="Job - Cybera Print Art";
		$data['heading']="Jobs";
		if($this->input->post()) {
			$this->load->model('customer_model');
			if($this->input->post('customer_type') == 'new') {
				$data=array();
				
				$data['name'] = $this->input->post('name');
				$data['mobile'] = $this->input->post('user_mobile');
				$data['companyname'] = $this->input->post('companyname');
				$data['emailid'] = $this->input->post('emailid');
				$customer_id = $this->customer_model->insert_customer($data);
			} else {
				$customer_id = $this->input->post('customer_id');
			}
			
			
			$this->load->model('job_model');
			$jobdata = array();
			$jobdata['customer_id'] = $customer_id;
			$jobdata['user_id'] = $this->session->userdata['user_id'];
			$jobdata['jobname'] = $this->input->post('jobname');
			$jobdata['subtotal'] = $this->input->post('subtotal');
			$jobdata['tax'] = $this->input->post('tax');
			$jobdata['total'] = $this->input->post('total');
			$jobdata['advance'] = $this->input->post('advance');
			$jobdata['due'] = $this->input->post('due');
			$jobdata['notes'] = $this->input->post('notes');
			$jobdata['receipt'] = $this->input->post('receipt');
			$jobdata['voucher_number'] = $this->input->post('voucher_number');
			$jobdata['bill_number'] = $this->input->post('bill_number');
			$jobdata['jstatus'] = "Pending";
			$jobdata['jmonth'] = date('M-Y');
			$jobdata['jdate'] = date('Y-m-d');
			$job_id = $this->job_model->insert_job($jobdata);
			
			$job_details = array();
			for($i=1;$i<6;$i++) {
				$check = $this->input->post('details_'.$i);
				if(!empty($check)) {
					
					$job_details[] = array(
										'job_id'=>$job_id,
										'jtype'=>$this->input->post('category_'.$i),
										'jdetails'=>$this->input->post('details_'.$i),
										'jqty'=>$this->input->post('qty_'.$i),
										'jrate'=>$this->input->post('rate_'.$i),
										'jamount'=>$this->input->post('sub_'.$i),
										'created'=>date('Y-m-d H:i:s')
								);
				}
			}
			$this->job_model->insert_jobdetails($job_details);
			redirect("jobs/job_print/".$job_id,'refresh');
		}
		$this->template->load('job', 'edit', $data);
	}
	
	
	public function edit_job($job_id=null) {
		if($job_id) {
			$data['title']='Edit Job';
			$data['heading']='Cybera Job Edit';
			$this->load->model('job_model');
			$job_data = $this->job_model->get_job_data($job_id);
			$job_details = $this->job_model->get_job_details($job_id);
			$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
			$customer_mobile = $customer_details->mobile;
			$data['customer_details']=$customer_details;
			$data['job_details']=$job_details;
			$data['job_data']=$job_data;
			
			if($this->input->post()) {
				if($customer_mobile !=  $this->input->post('user_mobile')) {
					$customer_data['mobile'] = $this->input->post('user_mobile');
					$this->load->model('customer_model');
					$customer_id = $this->input->post('customer_id');
					$customer_update_status =$this->customer_model->update_customer($customer_id,$customer_data);
				}
				$jobdata['jobname'] = $this->input->post('jobname');
				$jobdata['subtotal'] = $this->input->post('subtotal');
				$jobdata['tax'] = $this->input->post('tax');
				$jobdata['total'] = $this->input->post('total');
				$jobdata['advance'] = $this->input->post('advance');
				$jobdata['due'] = $this->input->post('due');
				$jobdata['notes'] = $this->input->post('notes');
				$jobdata['bill_number'] = $this->input->post('bill_number');
				$jobdata['voucher_number'] = $this->input->post('voucher_number');
				$jobdata['receipt'] = $this->input->post('receipt');
				$jobdata['jstatus'] = "Pending";
				$jobdata['jmonth'] = date('M-Y');
				//$jobdata['jdate'] = date('Y-m-d');
				$this->job_model->update_job($job_id,$jobdata);
				
				for($i=1;$i<6;$i++) {
				$job_details=array();
				$job_id = $this->input->post('job_id');
				$check = $this->input->post('details_'.$i);
				if(!empty($check)) {
					$j_details_id = $this->input->post('jdid_'.$i);
					if($j_details_id) {
					$job_details['jtype'] = $this->input->post('category_'.$i);
					$job_details['jdetails'] = $this->input->post('details_'.$i);
					$job_details['jqty'] = $this->input->post('qty_'.$i);
					$job_details['jrate'] = $this->input->post('rate_'.$i);
					$job_details['jamount'] = $this->input->post('sub_'.$i);
					$job_details['modifiedby'] = $this->input->post('modified');
					$job_details['ismodified'] = 1;
					$job_update_status = $this->job_model->update_job_details($j_details_id,$job_details);
					} else {
						$job_details['job_id'] = $this->input->post('job_id');
						$job_details['jtype'] = $this->input->post('category_'.$i);
						$job_details['jdetails'] = $this->input->post('details_'.$i);
						$job_details['jqty'] = $this->input->post('qty_'.$i);
						$job_details['jrate'] = $this->input->post('rate_'.$i);
						$job_details['jamount'] = $this->input->post('sub_'.$i);
						$this->job_model->insert_jobdetails($job_details,true);
					}
				}
			}
			redirect("jobs/job_print/".$job_id,'refresh');	
			}
			$this->template->load('job', 'edit_job', $data);
		}
	}
	public function job_print($job_id=null) {
		if($job_id) {
			$this->load->model('job_model');
			$job_data = $this->job_model->get_job_data($job_id);
			$job_details = $this->job_model->get_job_details($job_id);
			$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
			$data['customer_details']=$customer_details;
			$data['job_details']=$job_details;
			$data['job_data']=$job_data;
			$data['title']='Print Job';
			$data['heading']='Cybera Print View';
			$this->template->load('job', 'print_job', $data);
		}
	}
        
        public function view_job($job_id) {
            if($job_id) {
			$this->load->model('job_model');
			$job_data = $this->job_model->get_job_data($job_id);
			$job_details = $this->job_model->get_job_details($job_id);
			$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
			$data['customer_details']=$customer_details;
			$data['job_details']=$job_details;
			$data['job_data']=$job_data;
			$data['heading'] = $data['title']='View Job';
			$this->template->load('job', 'view_job', $data);
		}
        }
}
