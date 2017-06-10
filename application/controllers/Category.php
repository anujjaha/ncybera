<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

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
		$this->load->model('category_model');
		$data['heading'] =$data['title']="List of Categories";
		$data['items'] = $this->category_model->getAll();            
		$this->template->load('category', 'index', $data);
	}
		
	public function add() {
	$data['heading'] = $data['title'] = "Add of Task";
		
	if($this->input->post()) {
		
		$data = $this->input->post();
		
		$sdata['name'] = $data['name'];
		
			$this->load->model('category_model');
		
			$this->category_model->create($sdata);
			redirect("category/index",'refresh');
		}
		$this->template->load('category', 'add', $data);
	}
	
	
}
