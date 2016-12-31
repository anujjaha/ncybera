<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estimation extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->helper('form');


		$this->load->model('estimation_model');
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
		$data['items']   = $this->estimation_model->getAllEtimations();
		$data['heading'] = $data['title']="Estimations - Cybera Print Art";
		
		$this->template->load('estimations', 'index', $data);
	}
	
	public function create()
	{
		if($this->input->post())
		{
			$data = $this->input->post();
			
			if(isset($data['email_id']))
			{
				$insertEstimation = array(
					'customer_id' 	=> $data['estimation_customer'],
					'name' 			=> $data['customer_name'],
					'mobile' 		=> $data['mobile'],
					'emailid' 		=> $data['email_id'],
					'subject' 		=> $data['subject'],
					'content' 		=> $data['html_content'],
					'validity' 		=> $data['validity'],
					'created_at' 	=> date('Y-m-d H:i:s')
				);
				
				$status = $this->estimation_model->createNewEstimation($insertEstimation);
				
				if($status)
				{
					$subject = isset($data['subject']) ? $data['subject'] : "Cybera Estimation";
					$receivers =  explode(",", $data['email_id']);
					sendEstimationEmail($receivers, $data['from_email'], $subject, $data['html_content']);
				}
			}
			
			redirect("estimation/index", "refresh");
		}
		$data['heading'] = $data['title'] = "Create Estimation - Cybera Print Art";
		$this->template->load('estimations', 'create', $data);
	}
	
	public function uploadImage()
	{
		if($_FILES['image']) 
		{
			$config = array( 'upload_path'   => 'assets/emailpictures',
							 'allowed_types' => 'gif|jpg|png',
							 'file_name'     => rand(111111,999999)."_email_template.jpg"
						);
				
			$this->load->library('upload', $config);

			if ( $this->upload->do_upload('image'))
			{
				$picData = $this->upload->data();  
			
				$imageUrl = site_url('assets/emailpictures/'.$picData['file_name']);


				echo "<script>top.$('.mce-btn.mce-open').parent().find('.mce-textbox').val('".$imageUrl."').closest('.mce-window').find('.mce-primary').click();</script>".$imageUrl;
			}
			else 
			{
				echo "<script>alert('Unable to Upload Image !');</script>";
			}
		}
		die;
	}

}
