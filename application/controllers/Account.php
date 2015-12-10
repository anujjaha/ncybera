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
