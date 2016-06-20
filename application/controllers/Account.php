<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('account_model');
		$this->load->model('customer_model');
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
		$result = $this->customer_model->get_customer_details();
		$data['title']="Customer Account Management";
		$data['heading']="Customer Account Management";
		$data['customers']= $result;
		//$this->template->load('customer', 'index', $data);
		$this->template->load('account', 'index', $data);
	}
	
	public function quick()
	{
		$like = null;
		$offset= 0;
		$limit = 10;
		$result = $this->customer_model->get_customer_details_quick($like,$offset,$limit);
		$data['title']="Customer Account Management";
		$data['heading']="Customer Account Management";
		$data['customers']= $result;
		$data['offset'] = 0;
		//$this->template->load('customer', 'index', $data);
		$this->template->load('account', 'index_quick', $data);
	}
	
	public function quick_ajax()
	{
		$like = null;
		$offset= 0;
		$limit = 10;
		if($this->input->post()) {
			$like = null;
			if($this->input->post('search_box')) {
				$like  = $this->input->post('search_box');
			}
			$offset = $this->input->post('offset');
			if($offset > 0 ) {
				$offset = $offset * $limit;
			}
			$sort_by = $this->input->post('sort_by');
			$sort_value = $this->input->post('sort_value');
			$limit = $this->input->post('limit');
			$result = $this->customer_model->get_customer_details_quick($like,$offset,$limit,$sort_by,$sort_value);
			$data['customers']= $result;
			$data['offset']= $this->input->post('offset');
		}
		$ajax_result = $this->load->view('account/ajax_quick', $data);
		return $ajax_result;
	}
	public function quick_ajax_balance()
	{
		$like = null;
		$offset= 0;
		$limit = 10;
		if($this->input->post()) {
			$like = null;
			if($this->input->post('search_box')) {
				$like  = $this->input->post('search_box');
			}
			$offset = $this->input->post('offset');
			if($offset > 0 ) {
				$offset = $offset * $limit;
			}
			$sort_by = $this->input->post('sort_by');
			$sort_value = $this->input->post('sort_value');
			$limit = $this->input->post('limit');
			$result = $this->customer_model->get_customer_details_quick_balance($like,$offset,$limit,$sort_by,$sort_value);
			$data['customers']= $result;
			$data['offset']= $offset;
		}
		$ajax_result = $this->load->view('account/ajax_quick_balance', $data);
		return $ajax_result;
	}
	
	public function quick_ajax_clear()
	{
		$like= null;
		$offset= 0;
		$limit = 10;
		$result = $this->customer_model->get_customer_details_quick($like,$offset,$limit);
			$data['customers']= $result;
		$ajax_result = $this->load->view('account/ajax_quick', $data);
		return $ajax_result;
	}
	
	public function account_details($user_id) {
		$data['heading'] = $data['title']="Customer Account";
		
		$data['customer'] = $this->customer_model->get_customer_details('id',$user_id);
		$data['results'] = $this->account_model->get_account_details($user_id);
		$this->template->load('account', 'account', $data);
	}
         
    public function add_amount($customer_id=null) {
		$data['heading'] =$data['title']="Add Amount";
		
		if($this->input->post()) {
			$save_data = $this->input->post();
			unset($save_data['save']);
			
			$status = $this->account_model->credit_amount($save_data['customer_id'],$save_data);
			redirect('account/account_details/'.$save_data['customer_id'],'refresh');
		}
		$data['customer_id'] = $customer_id;
		$data['customer'] = $this->customer_model->get_customer_details('id',$customer_id);
		$this->template->load('account', 'add', $data);
	}     
}
