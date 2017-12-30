<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends CI_Controller {

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
		$this->load->model('book_model');
		$data['heading'] =$data['title']="List of Books";
		$data['books'] = $this->book_model->getAllBooks();            
		$this->template->load('book', 'index', $data);
	}
		
	public function add()
	{
	
		$data['heading'] = $data['title'] = "Add of Sample Book";
		
		if($this->input->post()) 
		{
			$data = array(
				'customer_id' => $this->input->post('customer'),
				'created_by'  => $this->session->userdata['user_id'],
				'book_id' 	  => 1,
				'book_qty'	  => $this->input->post('book_qty'),
				'book_title'  => $this->input->post('book_title'),
				'paid'		  => $this->input->post('paid'),
				'amount'	  => $this->input->post('amount'),
				'is_courier'  => $this->input->post('is_courier'),
				'created_at'  => date('Y-m-d H:i:s')
			);

			$this->load->model('book_model');
			$this->book_model->create($data);
			redirect("book/index",'refresh');
		}

		$this->template->load('book', 'add', $data);
	}
	
	
}
