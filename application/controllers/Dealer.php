<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dealer extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('dealer_model');
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
		$today = date("Y-m-d");
		$condition = array('condition'=>array('jdate'=>$today))	;
		$result = $this->dealer_model->get_dealer_details();
		$data['title']="Dealers Management";
		$data['heading']="Dealers Management";
		$data['customers']= $result;
		$this->template->load('dealer', 'index', $data);
	}
	
	public function edit($dealer_id=null) {
		$this->load->model('dealer_model');
		$data['title']="Add Dealer";
		$data['heading']="Add Dealer";
		if($dealer_id) {
			$data['title']="Edit Dealer";
			$data['heading']="Edi tDealer";
			$data['dealer_info']= $this->dealer_model->get_dealer_details('id',$dealer_id);
		}
		if($this->input->post()) {
			$data = array();
			$data['name'] = $this->input->post('name');
			$data['companyname'] = $this->input->post('companyname');
			$data['mobile'] = $this->input->post('mobile');
			$data['officecontact'] = $this->input->post('officecontact');
			$data['emailid'] = $this->input->post('emailid');
			$data['add1'] = $this->input->post('add1');
			$data['add2'] = $this->input->post('add2');
			$data['city'] = $this->input->post('city');
			$data['state'] = $this->input->post('state');
			$data['pin'] = $this->input->post('pin');
			$dealer_id = $this->input->post('dealer_id');
			if($dealer_id) {
				$this->dealer_model->update_dealer($dealer_id,$data);
			} else {
				$data['type'] = 1;
				$this->dealer_model->insert_dealer($data);
			}
			$this->load->helper('url');
			redirect("dealer/index",'refresh');
		}
		$this->template->load('dealer', 'edit', $data);
	}
	
	public function update_dealer_status($dealer_id,$status) {
		$this->load->model('dealer_model');
		$data['status'] = $status;
		return $this->dealer_model->update_dealer($dealer_id,$data);
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
	
	public function get_all_dealers() {
		$data = array();
		return $data;
	}
}
