<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paper extends CI_Controller {

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
		$data['heading'] = $data['title']="Papers - Cybera Print Art";
		$this->load->model('paper_model');
		$data['papers'] = $this->paper_model->get_all_papers();
		$this->template->load('paper', 'index', $data);
	}
	public function add_paper()
	{
		$data['heading'] = $data['title']="Add Paper - Cybera Print Art";
		if($this->input->post()) {
			$this->load->model('paper_model');
			$paper_amount = $this->input->post('paper_amount');
			$paper_name = $this->input->post('paper_name');
			$paper_gram = $this->input->post('paper_gram');
			$paper_size = $this->input->post('paper_size');
			$paper_qty_min = $this->input->post('paper_qty_min');
			$paper_qty_max= $this->input->post('paper_qty_max');
			$data = array();
			$j=0;
			for($i=0;$i<count($paper_amount);$i++) {
				if(!empty($paper_amount[$i]) && !empty($paper_gram[$i])) {
					$data[]=array( 'paper_name'=>$paper_name[$i],
									'paper_gram'=>strtolower($paper_gram[$i]),
									'paper_size'=>$paper_size[$i],
									'paper_qty_min'=>$paper_qty_min[$i],
									'paper_qty_max'=>$paper_qty_max[$i],
									'paper_amount'=>$paper_amount[$i],
									'created_by'=>$this->session->userdata('user_id'),
									'created_date'=>date('Y-m-d H:i:s')
									);
									$j++;
				} 
			}
			if($j>0) {
				$this->paper_model->insert_paper_details($data);
				redirect("paper",'refresh');
			}
						
		}
		$this->template->load('paper', 'add', $data);
	}
	
	public function delete_paper() {
		if($this->input->post()) {
			$id = $this->input->post('id');
			$this->load->model('paper_model');
			echo $this->paper_model->delete_paper_details($id);
		}
	}
	
	public function update_paper() {
		if($this->input->post()) {
			$id = $this->input->post('id');
			$data['paper_amount']= $this->input->post('value');
			$this->load->model('paper_model');
			if($this->paper_model->update_paper_details($id,$data)) {
				echo $data['paper_amount'];
			}
		}
	}
}
