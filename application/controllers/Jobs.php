<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('dealer_model');
		$this->load->model('customer_model');
		$this->load->model('user_model');
		
	}

  public function pending()
  {
    $this->load->model('job_model');
    $data = array();
    $data['jobs'] = $this->job_model->get_dashboard_pending_details();
    $data['title']="Job - Cybera Print Art";
    $data['heading']="Jobs";
    $this->template->load('user', 'pending', $data);
  }
	
	public function copyjob($jobId = null)
	{
		if($jobId)
		{
			$this->load->model('job_model');
			
			$jobData 			= $this->job_model->get_job_data($jobId);
			$jobDetails 		= $this->job_model->get_job_details($jobId);
			$jobCuttingDetails 	= $this->job_model->get_cutting_details($jobId);
			
			
			
			$jobdata['customer_id'] = $jobData->customer_id;
            $jobdata['user_id'] = $this->session->userdata['user_id'];
            $jobdata['jobname'] = $jobData->jobname;
            $jobdata['subtotal'] = $jobData->subtotal;
            $jobdata['tax'] = 0;
            $jobdata['total'] = $jobData->total;
            $jobdata['advance'] = 0;
            $jobdata['due'] = $jobData->total;
            $jobdata['notes'] = $jobData->notes;
            $jobdata['extra_notes'] = $jobData->extra_notes;
            $jobdata['receipt'] = '';
            $jobdata['voucher_number'] = '';
            $jobdata['bill_number'] = '';
            $jobdata['jsmsnumber']= $jobData->jsmsnumber;
            $jobdata['jmonth'] = date('M-Y');
            $jobdata['jdate'] = date('Y-m-d');
            
            $job_id = $this->job_model->insert_job($jobdata);
			$j_status =$this->add_job_transaction($job_id,JOB_PENDING);
			
			
			foreach($jobDetails as $jobDetails)
			{
				$jobDetails = (object)$jobDetails;
				if(isset($jobDetails->jdetails) && !empty($jobDetails->jdetails))
				{
					$job_details[] = array(
						'job_id' 	=> $job_id,
						'jtype' 	=> $jobDetails->jtype,
						'jdetails' 	=> $jobDetails->jdetails,
						'jqty' 		=> $jobDetails->jqty,
						'jrate' 	=> $jobDetails->jrate,
						'jamount' 	=> $jobDetails->jamount,
						'created' 	=> date('Y-m-d H:i:s')
					);
				}
			}
			
			$this->job_model->insert_jobdetails($job_details);
			
			if(count($jobCuttingDetails))
			{
				foreach($jobCuttingDetails as $jobCuttingDetail)
				{
					$jobCuttingDetail = (object) $jobCuttingDetail;
					if(isset($jobCuttingDetail->c_qty) && !empty($jobCuttingDetail->c_qty))
					{
						 $cutting_details[] = array('j_id'=>$job_id,
                                       'c_machine' 		=> $jobCuttingDetail->c_machine,
                                       'c_material' 	=> $jobCuttingDetail->c_material,
                                       'c_qty' 			=> $jobCuttingDetail->c_qty,
                                       'c_size' 		=> $jobCuttingDetail->c_size,
                                       'c_sizeinfo' 	=> $jobCuttingDetail->c_sizeinfo,
                                       'c_print' 		=> $jobCuttingDetail->c_print,
                                       'c_details'		=> $jobCuttingDetail->c_details,
                                       'c_lamination'	=> $jobCuttingDetail->c_lamination,
                                       'c_laminationinfo'=>$jobCuttingDetail->c_laminationinfo,
                                       'c_binding' 		=> $jobCuttingDetail->c_binding,
                                       'c_blade_per_sheet' => $jobCuttingDetail->c_blade_per_sheet,
                                       'c_bindinginfo' 	=> $jobCuttingDetail->c_bindinginfo,
                                       'c_checking' 	=> $jobCuttingDetail->c_checking,
                                       'c_packing' 		=> $jobCuttingDetail->c_packing,
                                       'c_corner' 		=> $jobCuttingDetail->c_corner,
                                       'c_laser' 		=> $jobCuttingDetail->c_laser,
                                       'c_rcorner' 		=> $jobCuttingDetail->c_rcorner,
                                       'c_cornerdie'	=> $jobCuttingDetail->c_cornerdie,
                                    );
					}
				}
				$this->job_model->insert_cuttingdetails($cutting_details);
			}
			
			redirect("jobs/edit_job/".$job_id,'refresh');
		}
		
		redirect("user/index", 'refresh');
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
		$this->load->model('job_model');
		$data = array();
		$data['jobs'] = $this->job_model->get_job_data();
		
		//echo "<pre>";
		//print_r($data);die;
	
		/*foreach($jobs as $job) {
			$jd = $this->job_model->get_job_details($job['job_id']);	
		}*/
		$data['title']="Job - Cybera Print Art";
		$data['heading']="Jobs";
		$this->template->load('job', 'index', $data);
	}

public function edit($job_id=null)
{
        $data['title']="Job - Cybera Print Art";
        $data['heading']="Jobs";
        if($this->input->post()) {
			    $this->load->model('customer_model');
                if($this->input->post('customer_type') == 'new') 
                {
					if( ( strlen($this->input->post('name')) < 1)  && ( strlen ($this->input->post('companyname')) < 1) )
					{
						redirect("jobs/edit", 'refresh');
					}
					
                        $data=array();

                        $data['name'] = $this->input->post('name');
                        $data['mobile'] = $this->input->post('user_mobile');
                        $data['companyname'] = $this->input->post('companyname');
                        $data['emailid'] = $this->input->post('emailid');
                        $data['add1'] = $this->input->post('add1');
						$data['add2'] = $this->input->post('add2');
						$data['city'] = $this->input->post('city');
						$data['state'] = $this->input->post('state');
						$data['pin'] = $this->input->post('pin');
                                                
                        if($this->input->post('customerType')  == "NewDealer")
                        {
							
							$customer_id = $this->dealer_model->insert_dealer($data);
						}else
						{
							if($this->input->post('customerType')  == "NewVoucher")
							{
								$data['ctype'] = 2;
							}
							$customer_id = $this->customer_model->insert_customer($data);
						}
                } else {
						if(strlen($this->input->post('customer_id')) < 1)
						{
							redirect("jobs/edit", 'refresh');
						}
					
                        $customer_id = $this->input->post('customer_id');
                        $customerType = getCustomerType($customer_id);
                        
                        if($customerType == 0 )
                        {
							$jsmsnumber = $this->input->post('regular_extra_contact_number');
						}
						
                        if($customerType == 1 )
                        {
							$jsmsnumber = $this->input->post('dealer_extra_contact_number');
						}
						
                        if($customerType == 2 )
                        {
							$jsmsnumber = $this->input->post('voucher_extra_contact_number');
						}
				}


                $this->load->model('job_model');
                $jobdata = array();
                $jobdata['customer_id'] = $customer_id;
                $jobdata['user_id'] = $this->session->userdata['user_id'];
                $jobdata['jobname'] = $this->input->post('jobname');
                $jobdata['subtotal'] = $this->input->post('subtotal');
                $jobdata['tax'] = $this->input->post('tax');
                $jobdata['total'] = $this->input->post('total');
                $jobdata['advance'] = $this->input->post('advance');
                $jobdata['due'] = $this->input->post('due');
                $jobdata['notes'] = $this->input->post('notes');
                $jobdata['extra_notes'] = $this->input->post('extra_notes');
                $jobdata['receipt'] = $this->input->post('receipt');
                $jobdata['voucher_number'] = $this->input->post('voucher_number');
                $jobdata['bill_number'] = $this->input->post('bill_number');
                $jobdata['jsmsnumber']=$jsmsnumber;
                $jobdata['jmonth'] = date('M-Y');
                $jobdata['jdate'] = date('Y-m-d');
                $job_id = $this->job_model->insert_job($jobdata);
				$j_status =$this->add_job_transaction($job_id,JOB_PENDING);
        $job_details = array();
        $cutting_details = array();
        for($i=1;$i<6;$i++) 
        {
        $check = $this->input->post('details_'.$i);
        $check_cutting = $this->input->post('c_machine_'.$i);
        $check_rount_cutting = $this->input->post('c_rcorner_'.$i);
        if(!empty($check)) {
            $job_details[] = array(
                'job_id'=>$job_id,
                'jtype'=>$this->input->post('category_'.$i),
                'jdetails'=>$this->input->post('details_'.$i),
                'jqty'=>$this->input->post('qty_'.$i),
                'jrate'=>$this->input->post('rate_'.$i),
                'jamount'=>$this->input->post('sub_'.$i),
                'created'=>date('Y-m-d H:i:s')
                );
            }
        if(!empty($check_cutting) || !empty($check_rount_cutting) ) {
            $cutting_details[] = array('j_id'=>$job_id,
                                       'c_machine'=>$this->input->post('c_machine_'.$i),
                                       'c_material'=>$this->input->post('c_material_'.$i),
                                       'c_qty'=>$this->input->post('c_qty_'.$i),
                                       'c_size'=>$this->input->post('c_size_'.$i),
                                       'c_sizeinfo'=>$this->input->post('c_sizeinfo_'.$i),
                                       'c_print'=>$this->input->post('c_print_'.$i),
                                       'c_details'=>$this->input->post('c_details_'.$i),
                                       'c_lamination'=>$this->input->post('c_lamination_'.$i),
                                       'c_laminationinfo'=>$this->input->post('c_laminationinfo_'.$i),
                                       'c_binding'=>$this->input->post('c_binding_'.$i),
                                       'c_blade_per_sheet'=>$this->input->post('c_blade_per_sheet_'.$i),
                                       'c_bindinginfo'=>$this->input->post('c_bindinginfo_'.$i),
                                       'c_checking'=>$this->input->post('c_checking_'.$i),
                                       'c_packing'=>$this->input->post('c_packing_'.$i),
                                       'c_corner'=>$this->input->post('c_corner_'.$i),
                                       'c_laser'=>$this->input->post('c_laser_'.$i),
                                       'c_rcorner'=>$this->input->post('c_rcorner_'.$i),
                                       'c_cornerdie'=>$this->input->post('c_cornerdie_'.$i),
                                    );
        }
        }
                $this->job_model->insert_jobdetails($job_details);
                if($cutting_details) {
					$this->job_model->insert_cuttingdetails($cutting_details);
				}
				
				if($this->input->post('remindMe') == 1 )
				{
					$jobInfo 		= $this->job_model->getJobById($job_id);
					$customerName 	= isset($jobInfo->companyname) ? $jobInfo->companyname : $jobInfo->name;
					
					$sdata['title'] = $this->input->post('jobname');
					$sdata['description'] = '<span style="color: red; font-size: 18px;">PLEASE DELIVER JOB ! </span> <br> <span style="font-size: 18px;"> Customer Name : <strong>' . $customerName . ' </strong> - Est Id<strong> - '. $job_id . '</strong></span>' ;
					$sdata['reminder_time'] = $this->input->post('reminder_time');
					$sdata['user_for'] = $this->session->userdata['user_id'];
					$sdata['is_sms'] = 1;
					$sdata['status'] = 0;
					$sdata['user_creator'] = $this->session->userdata['user_id'];
					$this->load->model('task_model');
					$this->task_model->save_scheduler($sdata);
				}
                redirect("jobs/job_print/".$job_id,'refresh');
        }
        $data['paper_gsm']= $this->get_paper_gsm();
        $data['paper_size']= $this->get_paper_size();
        $this->template->load('job', 'edit', $data);
	}
	
	public function outstationjob($job_id=null)
	{
        $data['title']="Outstation Job - Cybera Print Art";
        $data['heading']="Jobs";
        if($this->input->post()) {
			    $this->load->model('customer_model');
                if($this->input->post('customer_type') == 'new') {
					
					if( ( strlen($this->input->post('name')) < 1)  && ( strlen ($this->input->post('companyname')) < 1) )
					{
						redirect("jobs/edit", 'refresh');
					}
					
                        $data=array();

                        $data['name'] = $this->input->post('name');
                        $data['mobile'] = $this->input->post('user_mobile');
                        $data['companyname'] = $this->input->post('companyname');
                        $data['emailid'] = $this->input->post('emailid');
                        $customer_id = $this->customer_model->insert_customer($data);
                } else {
					
						if(strlen($this->input->post('customer_id')) < 1)
						{
							redirect("jobs/edit", 'refresh');
						}
					
                        $customer_id = $this->input->post('customer_id');
                }


                $this->load->model('job_model');
                $jobdata = array();
                $jobdata['customer_id'] = $customer_id;
                $jobdata['user_id'] = $this->session->userdata['user_id'];
                $jobdata['jobname'] = $this->input->post('jobname');
                $jobdata['subtotal'] = $this->input->post('subtotal');
                $jobdata['tax'] = $this->input->post('tax');
                $jobdata['total'] = $this->input->post('total');
                $jobdata['advance'] = $this->input->post('advance');
                $jobdata['due'] = $this->input->post('due');
                $jobdata['notes'] = $this->input->post('notes');
                $jobdata['receipt'] = $this->input->post('receipt');
                $jobdata['voucher_number'] = $this->input->post('voucher_number');
                $jobdata['bill_number'] = $this->input->post('bill_number');
                $jobdata['jmonth'] = date('M-Y');
                $jobdata['jdate'] = date('Y-m-d');
                $job_id = $this->job_model->insert_job($jobdata);
				$j_status =$this->add_job_transaction($job_id,JOB_PENDING);
        $job_details = array();
        $cutting_details = array();
        for($i=1;$i<6;$i++) {
        $check = $this->input->post('details_'.$i);
        $check_cutting = $this->input->post('c_machine_'.$i);
        $check_rount_cutting = $this->input->post('c_rcorner_'.$i);
        if(!empty($check)) {
            $job_details[] = array(
                'job_id'=>$job_id,
                'jtype'=>$this->input->post('category_'.$i),
                'jdetails'=>$this->input->post('details_'.$i),
                'jqty'=>$this->input->post('qty_'.$i),
                'jrate'=>$this->input->post('rate_'.$i),
                'jamount'=>$this->input->post('sub_'.$i),
                'created'=>date('Y-m-d H:i:s')
                );
            }
        if(!empty($check_cutting) || !empty($check_rount_cutting) ) {
            $cutting_details[] = array('j_id'=>$job_id,
                                       'c_machine'=>$this->input->post('c_machine_'.$i),
                                       'c_material'=>$this->input->post('c_material_'.$i),
                                       'c_qty'=>$this->input->post('c_qty_'.$i),
                                       'c_size'=>$this->input->post('c_size_'.$i),
                                       'c_sizeinfo'=>$this->input->post('c_sizeinfo_'.$i),
                                       'c_print'=>$this->input->post('c_print_'.$i),
                                       'c_details'=>$this->input->post('c_details_'.$i),
                                       'c_lamination'=>$this->input->post('c_lamination_'.$i),
                                       'c_laminationinfo'=>$this->input->post('c_laminationinfo_'.$i),
                                       'c_blade_per_sheet'=>$this->input->post('c_blade_per_sheet_'.$i),
                                       'c_binding'=>$this->input->post('c_binding_'.$i),
                                       'c_bindinginfo'=>$this->input->post('c_bindinginfo_'.$i),
                                       'c_checking'=>$this->input->post('c_checking_'.$i),
                                       'c_packing'=>$this->input->post('c_packing_'.$i),
                                       'c_corner'=>$this->input->post('c_corner_'.$i),
                                       'c_laser'=>$this->input->post('c_laser_'.$i),
                                       'c_rcorner'=>$this->input->post('c_rcorner_'.$i),
                                       'c_cornerdie'=>$this->input->post('c_cornerdie_'.$i),
                                    );
        }
        }
                $this->job_model->insert_jobdetails($job_details);
                if($cutting_details) {
					$this->job_model->insert_cuttingdetails($cutting_details);
				}
                redirect("jobs/job_print/".$job_id,'refresh');
        }
        $data['paper_gsm']= $this->get_paper_gsm();
        $data['paper_size']= $this->get_paper_size();
        $this->template->load('job', 'outstation', $data);
	}
	
	
	public function edit_job($job_id=null) {
		if($job_id) {
			$data['title']='Edit Job';
			$data['heading']='Cybera Job Edit';
			$this->load->model('job_model');
			$job_data = $this->job_model->get_job_data($job_id);
			$job_details = $this->job_model->get_job_details($job_id);
			$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
			$customer_mobile = $customer_details->mobile;
			$data['cutting_details'] = $this->job_model->get_cutting_details($job_id);
			$data['customer_details']=$customer_details;
			$data['job_details']=$job_details;
			$data['job_data']=$job_data;
			
			
			if($this->input->post()) {
				
				
				
				$customer_id = $this->input->post('customer_id');
				$original_customer_id = $this->input->post('original_customer_id');
					
				if($customer_mobile !=  $this->input->post('user_mobile')) {
					$customer_data['mobile'] = $this->input->post('user_mobile');
					$this->load->model('customer_model');
					$customer_update_status =$this->customer_model->update_customer($customer_id,$customer_data);
				}
				
				$update_advance = false;
				if($original_customer_id != $customer_id) {
						$jobdata['customer_id'] = $customer_id;
						$this->load->model('account_model');
						$this->account_model->update_job_transactions($job_id,$customer_id);
						$update_advance = false;
				}
				
				$jobdata['jobname'] = $this->input->post('jobname');
				$jobdata['subtotal'] = $this->input->post('subtotal');
				$jobdata['tax'] = $this->input->post('tax');
				$jobdata['total'] = $this->input->post('total');
				$jobdata['advance'] = $this->input->post('advance');
				$jobdata['due'] = $this->input->post('due');
				$jobdata['notes'] = $this->input->post('notes');
        $jobdata['extra_notes'] = $this->input->post('extra_notes');
				$jobdata['bill_number'] = $this->input->post('bill_number');
				$jobdata['voucher_number'] = $this->input->post('voucher_number');
				$jobdata['receipt'] = $this->input->post('receipt');
				$jobdata['discount'] = $this->input->post('discount');
				$jobdata['jsmsnumber'] = $this->input->post('jsmsnumber');
				$jobdata['jmonth'] = date('M-Y');
				
				//$jobdata['jdate'] = date('Y-m-d');
				$this->job_model->update_job($job_id,$jobdata);
				$this->load->model('account_model');
				$transaction_data['amount'] = $jobdata['total'];
				
				// Update JOB Bill settings
				$isBillNumber = getBillStatus($job_id);	
				if(isset($isBillNumber) && strlen($isBillNumber) > 2)
				{
					clearUserTransactionsByJobId($job_id);
					jobSettleAmount($job_id, $jobdata['subtotal']);
					addBillToJobClearDueAmount($job_id, $jobBill->bill_number);
				}
				
				//Update Total - Transaction
				$tcondition = array('job_id'=>$job_id,'t_type'=>DEBIT);
				$this->account_model->update_transaction($tcondition,$transaction_data);
				
				//Update Advance - Transaction
				if($update_advance) {
					$advance_transaction_data['amount'] = $jobdata['advance'];
					$tcondition = array('job_id'=>$job_id,'t_type'=>CREDIT);
					$this->account_model->update_transaction($tcondition,$advance_transaction_data);
				}
				
				update_user_discount($job_id,$jobdata['discount']);
				$j_status =$this->add_job_transaction($job_id,JOB_EDIT);
				for($i=1;$i<6;$i++) {
				$job_details=array();
				$job_id = $this->input->post('job_id');
				$check = $this->input->post('details_'.$i);
				if(!empty($check)) {
					$j_details_id = $this->input->post('jdid_'.$i);
					if($j_details_id) {
					$job_details['jtype'] = $this->input->post('category_'.$i);
					$job_details['jdetails'] = $this->input->post('details_'.$i);
					$job_details['jqty'] = $this->input->post('qty_'.$i);
					$job_details['jrate'] = $this->input->post('rate_'.$i);
					$job_details['jamount'] = $this->input->post('sub_'.$i);
					$job_details['modifiedby'] = $this->input->post('modified');
					$job_details['ismodified'] = 1;
					$job_update_status = $this->job_model->update_job_details($j_details_id,$job_details);
					} else {
						$job_details['job_id'] = $this->input->post('job_id');
						$job_details['jtype'] = $this->input->post('category_'.$i);
						$job_details['jdetails'] = $this->input->post('details_'.$i);
						$job_details['jqty'] = $this->input->post('qty_'.$i);
						$job_details['jrate'] = $this->input->post('rate_'.$i);
						$job_details['jamount'] = $this->input->post('sub_'.$i);
						$this->job_model->insert_jobdetails($job_details,true);
					}
				}
			}
			
			if($this->input->post('remindMe') == 1 )
			{
				$jobInfo 		= $this->job_model->getJobById($job_id);
				$customerName 	= isset($jobInfo->companyname) ? $jobInfo->companyname : $jobInfo->name;
				
				$sdata['title'] = $this->input->post('jobname');
				$sdata['description'] = '<span style="color: red; font-size: 18px;">PLEASE DELIVER JOB ! </span> <br> <span style="font-size: 18px;"> Customer Name : <strong>' . $customerName . ' </strong> - Est Id<strong> - '. $job_id . '</strong></span>' ;
				$sdata['reminder_time'] = $this->input->post('reminder_time');
				$sdata['user_for'] = $this->session->userdata['user_id'];
				$sdata['is_sms'] = 1;
				$sdata['status'] = 0;
				$sdata['user_creator'] = $this->session->userdata['user_id'];
				$this->load->model('task_model');
				$this->task_model->save_scheduler($sdata);
			}
			
			
			
			
			redirect("jobs/job_print/".$job_id,'refresh');	
			}
			$data['all_customers'] = $this->job_model->get_all_customers();
			$data['paper_gsm']= $this->get_paper_gsm();
			$data['paper_size']= $this->get_paper_size();
			$this->template->load('job', 'edit_job', $data);
		}
	}
	public function job_print($job_id=null) {
		if($job_id) {
			$this->load->model('job_model');
			$job_data = $this->job_model->get_job_data($job_id);
			$job_details = $this->job_model->get_job_details($job_id);
			$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
			$data['customer_details']=$customer_details;
			$data['job_details']=$job_details;
			$data['job_data']=$job_data;
			$data['title']='Print Job';
			$data['heading']='Cybera Print View';
			$data['cutting_info'] = $this->job_model->get_cutting_details($job_id);
			$data['transporter_info'] = $this->customer_model->getTransporterDetailsByCustomerId($job_data->customer_id);
			
      $this->template->load('job', 'print_job', $data);
		}
	}

  public function job_print_with($job_id=null) {
    if($job_id) {
      $this->load->model('job_model');
      $job_data = $this->job_model->get_job_data($job_id);
      $job_details = $this->job_model->get_job_details($job_id);
      $customer_details = $this->job_model->get_customer_details($job_data->customer_id);
      $data['customer_details']=$customer_details;
      $data['job_details']=$job_details;
      $data['job_data']=$job_data;
      $data['title']='Print Job';
      $data['heading']='Cybera Print View';
      $data['cutting_info'] = $this->job_model->get_cutting_details($job_id);
      $data['transporter_info'] = $this->customer_model->getTransporterDetailsByCustomerId($job_data->customer_id);
      
      $this->template->load('job', 'print_with_edit_job', $data);
    }
  }
        
        public function view_job($job_id) {
            if($job_id) {
			$this->load->model('job_model');
			$job_data = $this->job_model->get_job_data($job_id);
			$job_details = $this->job_model->get_job_details($job_id);
			$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
			$data['customer_details']=$customer_details;
			$data['job_details']=$job_details;
			$data['job_data']=$job_data;
			$data['heading'] = $data['title']='View Job';
			$this->template->load('job', 'view_job', $data);
		}
        }
        
	public function get_paper_gsm() {
		$this->load->model('job_model');
		return $this->job_model->get_paper_gsm();
	}
	public function get_paper_size() {
		$this->load->model('job_model');
		return $this->job_model->get_paper_size();
	}
	
	public function add_job_transaction($job_id=null,$job_status='Created') {
		$this->load->model('job_model');
		$data['j_id']=$job_id;
		$data['j_status']=$job_status;
		return $this->job_model->add_job_transaction($data);
	}
	
	public function print_job_ticket($job_id=null) {
		if($job_id) {
			$this->load->model('job_model');
			$job_data = $this->job_model->get_job_data($job_id);
			$job_details = $this->job_model->get_job_details($job_id);
			$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
			$data['customer_details']=$customer_details;
			$data['job_details']=$job_details;
			$data['job_data']=$job_data;
			$data['title']='Print Job';
			$data['heading']='Cybera Print View';
			$this->load->view('ajax/print_job_ticket',$data);
		}
		return true;
	}
	public function print_cutting_ticket($job_id=null) {
		if($job_id) {
			$this->load->model('job_model');
			$job_data = $this->job_model->get_job_data($job_id);
			$cutting_info = $this->job_model->get_cutting_details($job_id);
			$job_details = $this->job_model->get_job_details($job_id);
			$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
			if(! $cutting_info) {
				return true;
			}
			$data['customer_details']=$customer_details;
			$data['job_details']=$job_details;
			$data['cutting_info']=$cutting_info;
			$data['job_data']=$job_data;
			$data['title']='Print Job';
			$data['heading']='Cybera Print View';
			$this->load->view('ajax/print_cutting_ticket',$data);
		}
		return true;
	}
	
	public function print_courier_ticket($job_id=null) {
		if($job_id) {
			$this->load->model('job_model');
			$job_data = $this->job_model->get_job_data($job_id);
			$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
			$data['customer_details']=$customer_details;
			$data['job_data']=$job_data;
			$data['title']='Print Job';
			$data['heading']='Cybera Print View';
			$this->load->view('ajax/print_courier_ticket',$data);
		}
		return false;
	}
	
	public function estimation_sms() {
		$this->load->model('estimationsms_model','emodel');
		$data = array();
		$data['estimations'] = $this->emodel->get_all_estimations();
		$data['heading'] = $data['title']="SMS Estimation - Cybera Print Art";
		$this->template->load('estimationsms', 'index', $data);
	}
	
	public function test()
	{
		$data =  create_customer_dropdown('customer',true);
		die('test');
	}
	
	public function courier()
	{
		$this->load->model('job_model');
		$data['items']  = $this->job_model->getAllCourierServices();
		$data['heading'] = $data['title']="Courier Job Details - Cybera Print Art";
		$this->template->load('job', 'couriers', $data);
	}
}
