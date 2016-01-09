<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prints extends CI_Controller {

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
            $today = date('Y-m-d');
            $data['jobs'] = $this->job_model->get_today_details('job.jdate',"'".$today."'");
            $data['heading'] =$data['title']="Print Department - Cybera Print Art";
            $this->template->load('print', 'index', $data);
		
	}
	public function update_job_status($job_id=null,$status) {
            if(! $job_id) {
                return false;
            }
            $this->load->model('job_model');
            $data = array('j_status'=>$this->input->post('j_status'),'j_id'=>$this->input->post('j_id'));
            return $this->job_model->add_job_transaction($data);
        }
	public function get_all()
	{
            $this->load->model('job_model');
            $data = array();
            $data['jobs'] = $this->job_model->get_today_details();
            $data['heading'] =$data['title']="Print Department - Cybera Print Art";
            $this->template->load('print', 'all', $data);
		
	}
	public function c()
	{
		echo "this is print";
		
	}
}
