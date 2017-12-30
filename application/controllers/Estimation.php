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
	
	public function forward($estimationId)
	{
		$data = array();
		$data['item']   = $this->estimation_model->getEstimation($estimationId);
		$data['heading'] = $data['title']="Update Estimations - Cybera Print Art";
		
		$this->template->load('estimations', 'edit', $data);
	}
	
	public function bulk()
	{
		if($this->input->post())
		{
			$data = $this->input->post();
			
			$emailList = $this->input->post('estimation_customer');
			$counter = 0;
			foreach($emailList as $email)
			{
				$email = explode("," ,$email);
				
				$status = sendBulkEmail($email, $data['from_email'], $data['subject'], $data['html_content']);
				
				if($status) 
				{
					$counter++;
				}
				else
				{
					echo $status;
				}
			}
			
			$data['msg'] =  "Total <strong>".$counter."</strong> Mail sent";
		}
		$data['heading'] = $data['title'] = "Create Bulk Send Email - Cybera Print Art";
		$this->template->load('estimations', 'bulk', $data);
	}
	
	public function create()
	{
		if($this->input->post())
		{
			$data = $this->input->post();
			if(isset($data['email_id']))
			{
				$customerName 	= $data['customer_name'];
				$customerId 	= $data['estimation_customer'];
				
				$this->load->model('customer_model');
				
				if(isset($data['new_customer']) && !empty($data['new_customer']))
				{
					$customerName 	= $data['new_customer'];	
					$cybCustomer 	= $this->customer_model->checkCustomerByEmailId($data['email_id']);
					
					if($cybCustomer)
					{
						$customerId = $cybCustomer->id;	
					}
					else
					{
						$newCustomerData = array(
							'name' 		=> $data['new_customer'],
							'emailid' 	=> $data['email_id'],
							'mobile' 	=> $data['mobile']
						);
						
						$customerId = $this->customer_model->insert_customer($newCustomerData);
					}
				}
				else
				{
					$this->customer_model->checkOrUpdateCustomerEmailId($customerId, $data['email_id']);
				}
				
				$insertEstimation = array(
					'customer_id' 	=> $customerId,
					'name' 			=> $customerName,
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
					sendEstimationEmail($receivers, $data['from_email'], $customerName. ' - ' .$subject, $data['html_content']);
				}
			}
			
			redirect("estimation/index", "refresh");
		}
		$data['heading'] = $data['title'] = "Create Estimation - Cybera Print Art";
		$this->template->load('estimations', 'create', $data);
	}
	
	public function edited()
	{
		$data = $this->input->post();
		if(isset($data['email_id']))
		{
			$customerName 	= $data['customer_name'];
			$customerId 	= $data['estimation_customer'];
			
			$this->load->model('customer_model');
			
			$this->customer_model->checkOrUpdateCustomerEmailId($customerId, $data['email_id']);
			
			$insertEstimation = array(
				'customer_id' 	=> $customerId,
				'name' 			=> $customerName,
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
				sendEstimationEmail($receivers, $data['from_email'], $customerName. ' - ' .$subject, $data['html_content']);
			}
		}
			
			redirect("estimation/index", "refresh");
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
				
				/* FTP Account */
				$ftp_host 		= 'php-techie.com'; // 'laravel-lab.com'; /* host */
				$ftp_user_name 	= 'cybnewmedia@php-techie.com'; //'cyberam@laravel-lab.com'; /* username */
				$ftp_user_pass 	= 'Admin@123'; /* password */
				
				
				$local_file = 'C:\wamp\www\ncybera\assets\emailpictures\xxx'.$picData['file_name'];
				
				$local_file = str_replace("xxx","",$local_file);
				$remote_file = $picData['file_name'];
				
				$connect_it = ftp_connect( $ftp_host );
				$login_result = ftp_login( $connect_it, $ftp_user_name, $ftp_user_pass );
				
				
				
					/* Send $local_file to FTP */
					if ( ftp_put( $connect_it, $remote_file, $local_file, FTP_BINARY ) ) {
						$status =  "WOOT! Successfully transfer $local_file\n";
					}
					else {
						$status = "Doh! There was a problem\n";
					}
					/* Close the connection */
					ftp_close( $connect_it );
					
				$myImageUrl = "http://media.cyberaprint.com/".$picData['file_name'];
				echo "<script>top.$('.mce-btn.mce-open').parent().find('.mce-textbox').val('".$myImageUrl."').closest('.mce-window').find('.mce-primary').click();</script>".$imageUrl;
			}
			else 
			{
				echo "<script>alert('Unable to Upload Image !');</script>";
			}
		}
		die;
	}

}
