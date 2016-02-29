<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

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
	public function index() {
		$this->load->model('master_model');
		$data = array();
		$data['heading'] = $data['title']="Master Admin";
		$data['statstics'] = get_master_statistics();
		$data['unverify_jobs'] = $this->master_model->get_all_unverify_jobs();
		$this->template->load('master', 'index', $data);
	}
}
