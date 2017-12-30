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
            $data = $this->job_model->get_print_dashboard('job.jdate',"'".$today."'");
            $data['heading'] =$data['title']="Print Department - Cybera Print Art";
            
            $this->template->load('print', 'index', $data);
		
	}
	public function update_job_status($job_id=null,$status) {
            if(! $job_id) {
                return false;
            }
           
			$this->load->model('job_model');
            $data = array('j_status'=>$this->input->post('j_status'),'j_id'=>$this->input->post('j_id'));
            $flag = false;

            if($this->input->post('bill_number')) 
            {
				$jdata['bill_number'] = $this->input->post('bill_number');
				$flag = true;
			}
            if($this->input->post('voucher_number')) 
            {
				$jdata['voucher_number'] = $this->input->post('voucher_number');
				$flag = true;
			}
            if($this->input->post('receipt')) 
            {
				$jdata['receipt'] = $this->input->post('receipt');
				$flag = true;
			}
			if($flag) 
			{
				$jdata['is_delivered'] = $this->input->post('is_delivered');
				$this->job_model->update_job($job_id,$jdata);
			}
			else
			{
				$jdata['is_delivered'] = $this->input->post('is_delivered');
				$this->job_model->update_job($job_id,$jdata);
			}
			
			if($this->input->post('send_sms') == 'Yes') 
			{
				$this->job_model->add_job_transaction($data);
				return job_complete_sms($job_id);
			}
			
			if( $this->input->post('j_status') == 'Completed' )
			{
				$this->job_model->add_job_transaction($data);
				$is_cutting = $this->job_model->is_cutting($job_id);

				if(! $is_cutting ) {
					//return job_complete_sms($job_id);
				}
			}
			
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
	
	public function search() {
		$data=array();
		$data['heading'] = $data['title']="Search Result";
		$data['search']="";
		if($this->input->post('q')) {
			$this->load->model('user_model');
			$search = $this->input->post('q');
			$data['dealers'] = $data['customers'] = $this->user_model->search_customers($search);
			$data['job_data'] = $this->user_model->search_job($search);
			$data['job_details'] = $this->user_model->search_jobdetails($search);
			$data['search']=$search;
		}
		$this->template->load('print', 'search', $data);
	}
}
