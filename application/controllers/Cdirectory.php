<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cdirectory extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
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
		$data = array();
		$data['heading'] = $data['title']="Phone Directory - Cybera Print Art";
		$this->load->model('directory_model');
		$data['data'] = $this->directory_model->get_all();
		$this->template->load('phone_directory', 'index', $data);
	}     
	public function add()
	{
		$data = array();
		$data['heading'] = $data['title']="Phone Directory - Add";
		
		if($this->input->post()) {
		$this->load->model('directory_model');
			$sdata['name'] = $this->input->post('name');
			$sdata['phone'] = $this->input->post('phone');
			$sdata['mobile'] = $this->input->post('mobile');
			$this->directory_model->insert_data($sdata);
			redirect("cdirectory/index",'refresh');
		}
		$this->template->load('phone_directory', 'add', $data);
	}  
	
	public function edit($id)
	{
		$data = array();
		$data['heading'] = $data['title']="Phone Directory - Edit";
		$this->load->model('directory_model');
		$data['datas'] = $this->directory_model->get_single($id);
		
		
		if($this->input->post()) {
			
			$id = $this->input->post('id');
			$sdata['name'] = $this->input->post('name');
			$sdata['phone'] = $this->input->post('phone');
			$sdata['mobile'] = $this->input->post('mobile');
			$this->directory_model->update_data($id,$sdata);
			redirect("cdirectory/index",'refresh');
		}
		$this->template->load('phone_directory', 'edit', $data);
	}  
	
	public function delete_data() {
		if($this->input->post()) {
			$id = $this->input->post('id');
			$this->load->model('directory_model');
			$this->directory_model->del_data($id);
			die('done');
		}
	}   
}
