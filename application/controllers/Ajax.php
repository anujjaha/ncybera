<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function ajax_job_view() {
		if($this->input->post()) {
			$this->load->model('jobview_model');
			$data=array();
			$data['department'] = $this->input->post('department');
			$data['j_id'] = $this->input->post('id');
			$data['user_id'] = $this->session->userdata['user_id'];
			$data['view_time'] = date('h:i');
			$data['view_date'] = date('Y-m-d');
			$this->jobview_model->insert_jobview($data);
			return true;
		}
		
	}
	public function ajax_job_details($job_id=null) {
		if(! $job_id) {
			return true;
		}
		$this->load->model('job_model');
		$this->load->model('user_model');
		$job_data = $this->job_model->get_job_data($job_id);
		$job_details = $this->job_model->get_job_details($job_id);
		$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
		$data['customer_details']=$customer_details;
		$data['job_details']=$job_details;
		$data['job_data']=$job_data;
		$data['heading'] = $data['title']='View Job';
		$data['courier'] = $this->user_model->get_courier($job_id);
		$data['userInfo'] = get_user_by_param('id', $job_data->user_id);
		$data['cuttingInfo'] = $this->job_model->get_cutting_details($job_id);
		$this->load->view('ajax/view_job', $data);
	}
	public function ajax_job_simple_details($job_id=null) {
		if(! $job_id) {
			return true;
		}
		$this->load->model('job_model');
		$this->load->model('user_model');
		$this->load->model('account_model');
		$job_data = $this->job_model->get_job_data($job_id);
		$data['cuttingInfo'] = $this->job_model->get_cutting_details($job_id);
		$job_details = $this->job_model->get_job_details($job_id);
		$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
		$data['userInfo'] = get_user_by_param('id', $job_data->user_id);
		$data['customer_details']=$customer_details;
		$data['job_details']=$job_details;
		$data['job_data']=$job_data;
		$data['heading'] = $data['title']='View Job';
		$data['job_transactions'] = $this->account_model->get_job_transactions($job_id);
		$this->load->view('ajax/view_simple_job', $data);
	}
	
	public function ajax_cutting_details($job_id=null) {
		if(! $job_id) {
			return true;
		}
		$this->load->model('job_model');
		$job_data = $this->job_model->get_job_data($job_id);
		$job_details = $this->job_model->get_job_details($job_id);
		$cutting_details = $this->job_model->get_cutting_details($job_id);
		$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
		$data['customer_details']=$customer_details;
		$data['cutting_details']=$cutting_details;
		$data['job_details']=$job_details;
		$data['job_data']=$job_data;
		$data['heading'] = $data['title']='View Job';
		$this->load->view('ajax/view_cutting', $data);
	}
	
	public function ajax_job_datatable($param='jdate',$value) {
		$this->load->model('job_model');
		$data = array();
		if(! $value) {
			$value = "'".date('Y-m-d')."'";
		}
		$data['jobs'] = $this->job_model->get_today_details("job.$param","$value");
		$this->load->view('ajax/job_datatable', $data);
	}
	public function ajax_cutting_datatable($param='jstatus',$value='Pending') {
		$this->load->model('job_model');
		$data = array();
		//$data['jobs'] = $this->job_model->get_today_cutting_details();
		$data = $this->job_model->get_cutting_dashboard();
		$this->load->view('ajax/cutting_datatable', $data);
	}
	
	public function ajax_job_count($param='jdate',$value) {
		$this->load->model('job_model');
		if(! $value) {
			$value = "'".date('Y-m-d')."'";
		}
		$data = array();
		$data['jobs'] = count($this->job_model->get_today_details("job.$param","$value"));
		echo $data['jobs'];return true;
	}
	public function ajax_cutting_count($param='jstatus',$value='Pending') {
		$this->load->model('job_model');
		$data = array();
		$data['jobs'] = count($this->job_model->get_today_cutting_details());
		echo $data['jobs'];return true;
	}
	
	public function ajax_jobstatus_history($job_id=null) {
		if($job_id) {
			$this->load->model('job_model');
			$data['job_data'] = $this->job_model->get_job_data($job_id);
			$data['job_history'] = $this->job_model->job_status_history($job_id);
			$this->load->view('ajax/job_history', $data);
		}
	}
	
	public function save_courier($job_id=null){ 
		if($job_id) {
			$this->load->model('user_model');
			$data['j_id'] = $job_id;
			$data['courier_name'] = $this->input->post('courier_name');
			$data['docket_number'] = $this->input->post('docket_number');
			$data['user_id'] = $this->session->userdata['user_id'];
			$data['created'] = date('Y-m-d H:i:s');
			
			$this->load->model('job_model');
			$job_data = $this->job_model->get_job_data($job_id);
			$customer = $this->job_model->get_customer_details($job_data->customer_id);
			
			$sms_text = 'Dear '.$customer->name.', We have dispatched your parcel via - '.$this->input->post('courier_name').' and the docket number is '.$this->input->post('docket_number').'. Thank You.';
			send_sms($this->session->userdata['user_id'], $customer->id,$customer->mobile,$sms_text);
			
			$this->user_model->save_courier($job_id,$data);
		}
		return true;
	}
	
	public function create_estimation() {
		if($this->input->post()) {
			$this->load->model('estimationsms_model'); 	
			$customer_id = $this->input->post('customer_id');
			$customer_email = $this->input->post('customer_email');
			$sms_message = $this->input->post('sms_message');
			$sms_mobile = $this->input->post('sms_mobile');
			$sms_customer_name = $this->input->post('sms_customer_name');
			$prospect_id = 0;	
			if($this->input->post('prospect') && $this->input->post('prospect') == 1) {
				$this->load->model('customer_model');
				$pdata['name']= $sms_customer_name;
				$pdata['mobile']= $sms_mobile;
				$pdata['ccategory']= 'General-Estimation';
				$prospect_id = $this->customer_model->insert_prospect($pdata);
			}
			
			$quote_data['customer_id'] = $customer_id;
			$quote_data['prospect_id'] = $prospect_id;
			$quote_data['sms_message'] = $sms_message;
			$quote_data['mobile'] = $mobile = $sms_mobile;
			$quote_data['user_id'] = $user_id =  $this->session->userdata['user_id'];
			$quote_id = $this->estimationsms_model->insert_estimation($quote_data);
			$sms_text = "Dear ".$sms_customer_name.", ".$sms_message." GST Extra.Quote No. ".$quote_id." valid for 7 days.";
			send_sms($user_id,$customer_id,$mobile,$sms_text,$prospect_id);
			sendCorePHPMail('cybera.printart@gmail.com', 'cybera.printart@gmail.com', 'Cybera Estimation - ' .$sms_customer_name, $sms_text);
			
			if($customer_email) {
				$emailStatus = send_mail($customer_email,'cybera.printart@gmail.com','Estimation - Cybera',$sms_text);
			}
			
			
			echo $sms_text;
		}
		return true;
	}
	
	public function get_cutting_details_by_job_detail($id,$job_id) {
		$this->load->model('job_model');
		$jdetails = $this->job_model->get_job_details_by_param('id',$id);
		$cutting_details = $this->job_model->get_cutting_details_by_job_detail($job_id,$jdetails->jdetails);
		echo json_encode($cutting_details);
		die();
	}
	
	public function ajax_update_cutting_details($job_details_id,$job_id,$sr) {
		
		$this->load->model('job_model');
		$jdetails = $this->job_model->get_job_details_by_param('id',$job_details_id);
		$data['cutting_details'] = $this->job_model->get_cutting_details_by_job_detail($job_id,$jdetails->jdetails);
		$data['jdetails'] = $jdetails;
		$data['j_id'] = $job_id;
		$data['sr'] = $sr;
		$this->load->view('ajax/update_cutting',$data);
	}
	
	public function save_edit_cutting_details() {
		if($this->input->post()) {
			$this->load->model('job_model');
			$data = $this->input->post();
			unset($data['update']);
			unset($data['cutting_id']);
			$id = $this->input->post('cutting_id');
			$data['j_id'] = $this->input->post('j_id');
			if(!$id) {
				$this->job_model->insert_cuttingdetails($data,true);
			}
			$this->job_model->update_cutting_details($id,$data);
			return true;
		}
	}
	
	public function pay_job($job_id=null) {
		if($job_id) {
			$this->load->model('job_model');
			$this->load->model('account_model');
			
			$myjob = $this->job_model->get_job_data($job_id);
			
			$data = array();
			$data['settlement_amount'] = $this->input->post('settlement_amount');
			
			$data['due'] = $myjob->due - $this->input->post('settlement_amount');
			if($data['due'] == 0 ) {
				$data['jpaid'] = 1;
			}
			$this->job_model->update_job($job_id,$data);
			
			$cMonth = date("M-Y",strtotime($this->input->post('cmonth')));	
			
			$job_data = $this->job_model->get_job_data($job_id);
			$pay_data['job_id'] = $job_id;
			$pay_data['customer_id'] = $job_data->customer_id;
			$pay_data['amount'] = $data['settlement_amount'];
			$pay_data['amountby'] = 'Cash';
			$pay_data['bill_number'] = $this->input->post('bill_number') ? $this->input->post('bill_number') : "";
			$pay_data['receipt'] = $this->input->post('receipt');
			$pay_data['other'] = $this->input->post('other') ? $this->input->post('other') : '';
			$pay_data['cmonth'] = $cMonth;
			$pay_data['pay_ref'] = $this->input->post('payRef');
			$pay_data['notes'] = $this->input->post('payRefNote');
			
			$pay_data['cheque_number'] = $this->input->post('cheque_number') ? $this->input->post('cheque_number') : '';
			$pay_data['creditedby'] =$this->session->userdata['user_id'];
			$this->account_model->credit_amount($job_data->customer_id,$pay_data,CREDIT);
			return true;
		}
	}
	
	public function ajax_get_customer($customer_id=null) {
		if($customer_id) {
			$this->load->model('job_model');
			$data = $this->job_model->get_customer_details($customer_id);
			echo json_encode($data);
		die();
		}
		return false;
	}
	
	public function ajax_customer_details_by_param($param=null,$value=null) {
		if($param && $value) {
			$this->load->model('customer_model');
			$data = $this->customer_model->get_customer_details($param,$value);
			if( count($data) > 0 ) {
				echo $data->companyname ? $data->companyname : $data->name;
			}
		}
		return true;
	}
	
	public function ajax_job_short_details($job_id=null) {
		if(! $job_id) {
			return true;
		}
		$this->load->model('job_model');
		$this->load->model('user_model');
		$job_data = $this->job_model->get_job_data($job_id);
		$job_details = $this->job_model->get_job_details($job_id);
		$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
		$data['customer_details']=$customer_details;
		$data['job_details']=$job_details;
		$data['job_data']=$job_data;
		$data['heading'] = $data['title']='View Job';
		$data['courier'] = $this->user_model->get_courier($job_id);
		$this->load->view('ajax/view_short_job', $data);
	}
	
	public function ajax_job_verify($job_id=null) {
		if($this->input->post()) {
			$this->load->model('job_model');
			$jdata['job_id'] = $job_id;
			$jdata['user_id'] = $this->session->userdata['user_id'];
			$jdata['notes'] = $this->input->post('notes');
			$verify_id = $this->job_model->verify_job_by_user($jdata);
			$data['bill_number'] = $this->input->post('bill_number');
			$data['receipt'] = $this->input->post('receipt');
			$data['voucher_number'] = $this->input->post('voucher_number');
			$data['verify_id'] = $verify_id;
			$this->job_model->update_job($job_id,$data);
			print_r($data);
			return true;
		}
	}
	
	public function update_user_status($user_id=null,$status) {
		if($user_id) {
			$data['active'] = 1;
			if($status == 1 ) {
				$data['active'] = 0;
			}
			$this->load->model('user_model');
			return $this->user_model->update_user($user_id,$data);
		}
		return false;
	}
	
	public function ajax_switch_customer($id=null,$roll=0) {
		if($id) {
			$this->load->model('customer_model');
			$customer_info = $this->customer_model->get_customer_details('id',$id);
			$update_customer = array();
			//Convert to Customer
			if($roll == 0 ) {
				$update_customer['username'] = $update_customer['password'] = 	"customer".$customer_info->id;
				$update_customer['ctype'] = 0;
				$update_customer['dealercode'] = "";
			}
			//Convert to Dealer
			if($roll == 1 ) {
				$update_customer['username'] = $update_customer['password'] = 	"dealer".$customer_info->id;
				$update_customer['ctype'] = 1;
				$update_customer['dealercode'] = "D-".$customer_info->id;
			}
			//Convert to Voucher
			if($roll == 2 ) {
				$update_customer['username'] = $update_customer['password'] = 	"customer".$customer_info->id;
				$update_customer['ctype'] = 2;
				$update_customer['dealercode'] = "";
			}
			$this->customer_model->update_customer($id,$update_customer);
				return true;
		}
		return false;
	}
	
	public function ajax_delete($id=null) {
		if($id) {
			$this->load->model('customer_model');
			return $this->customer_model->delete_customer($id);
		}
		return false;
	}
	
	public function ajax_old_job_details($id=null) {
		$this->load->model('user_model');
		$data['jobdata'] = $this->user_model->get_old_job($id);
		$this->load->view('ajax/view_old_job',$data);
	}
	
	public function get_customer_due_with_outside($user_id=null) {
		if($user_id) {
			
			echo json_encode(array(
				'balance' 		=> round(get_balance($user_id)),
				'outsideStatus' => getCustomerOutside($user_id)
			));
			die;
		}
		return false;
	}
	
	public function get_customer_due($user_id=null) {
		if($user_id) {
			echo round(get_balance($user_id));
			die;
		}
		return false;
	}
	
	public function ajax_credit_amount() {
		if($this->input->post()) {
			
			$this->load->model('account_model');
			$this->load->model('job_model');
			$customer_id = $this->input->post('customer_id');
			$pay_data['amount'] = $this->input->post('settlement_amount');
			$pay_data['customer_id'] = $this->input->post('customer_id');
			$pay_data['amountby'] = 'Cash';
			$pay_data['cheque_number'] = $this->input->post('bill_number') ? $this->input->post('bill_number') : 0;
			$pay_data['receipt'] = $this->input->post('receipt') ? $this->input->post('receipt') : 0;
			$pay_data['other'] = $this->input->post('other') ? $this->input->post('other') : '';
			$pay_data['notes'] = $this->input->post('notes') ? $this->input->post('notes') : 'Cash Added';
			$pay_data['creditedby'] =$this->session->userdata['user_id'];
			
			if(strlen($this->input->post('cmonth')) > 1) {
				$pay_data['cmonth'] = date("M-Y",strtotime($this->input->post('cmonth')));
			}
			
			$this->account_model->credit_amount($customer_id,$pay_data,CREDIT);
			
			if($this->input->post('send_sms') == "0") {
				$send_sms = false;
				return true;
			}
			
				$today = date('d-m-Y');
				$customer_details = $this->job_model->get_customer_details($customer_id);
				$mobile = $customer_details->mobile;
				//$mobile = "9898618697";
				$customer_name = $customer_details->companyname ? $customer_details->companyname : $customer_details->name; 
				//$sms_text = "Dear \$customer_name, we have received ".$pay_data['amount']." Rs. by Cash on date ".$today.". Thank You.";
				$user_balance  = get_balance($customer_id);
				$sms_text = "Dear $customer_name, received Rs. ".$pay_data['amount']." on ".$today." total due Rs. ".$user_balance." Thank You.";
				send_sms($this->session->userdata['user_id'],$customer_id,$mobile,$sms_text) ;
			
			return true;
		}
	}
	
	public function ajax_delete_transaction($id) {
		$this->load->model('account_model');
		$this->account_model->delete_entry($id);
		die('done');
		return true;
	}
	
	public function ajax_account_statstics() {
		if($this->input->post()) {
			$this->load->model('account_model');
			$this->load->model('job_model');
			$user_id = $this->input->post('customer_id');
			$customer_details = $this->job_model->get_customer_details($user_id);
			$c_balance = get_balance($user_id);
			$month = $this->input->post('month');
			$year = $this->input->post('year');
			
			$all=false;
			
			if($year == "all" || $month[0] == 'all') {
				$all = true;
			}  
			else if (count($month) > 0 )
			{
				foreach($month as $useMonth) 
				{
					$jmonth[] = "'". $useMonth."-".$year .  "'";	
				}
			}
			else
			{
				$jmonth = $month[0]."-".$year;	
			}
			
			$customer_name = $customer_details->companyname ? $customer_details->companyname : $customer_details->name; 
			$data = $this->account_model->account_statstics($user_id,$jmonth,$all);
			$print = '<table border="2" width="100%">
					
					<tr>
						<td colspan="10" align="center">
						<h2>'.$customer_name.' (Total Due - '.$c_balance.' ) </h2>
						</td>
					</tr>
					<tr>
					<td style="border:1px solid">Date</td>
					<td style="border:1px solid">Time</td>
					<td style="border:1px solid">Job No.</td>
					<td style="border:1px solid">Job Name</td>
					<td style="border:1px solid">Debit</td>
					<td style="border:1px solid">Credit</td>
					<td style="border:1px solid">Balance</td>
					<td style="border:1px solid">Reference</td>
					<td style="border:1px solid">Credit Note</td>
					<td style="border:1px solid">Received By</td>
					<td style="border:1px solid">Details</td>
					</tr>';
		$total_debit = $total_credit = 0;
		foreach($data as $result) {
			
			
			if($result['t_type'] == CREDIT and $result['amount'] == 0) { 
				continue;
			}
			if($result['t_type'] == DEBIT ) {
			$total_debit = $total_debit + $result['amount'];
			$balance = $balance - $result['amount'];
		} else {
			$total_credit = $total_credit + $result['amount'];
			$balance = $balance + $result['amount'];
		}
		
		$print .= '<tr>
					<td style="border:1px solid">'.date('d-m-y',strtotime($result['created'])).'</td>
					<td style="border:1px solid">'.date('H:i A',strtotime($result['created'])).'</td>
					<td style="border:1px solid">';
		
		if($result['job_id']) {
				$print .= $result['job_id'];
		 } else {
			$print .= "-";
		}
		//echo $print;
		$print .= '</td><td style="border:1px solid">'.$result['jobname'].'</td>
				  <td align="right" style="border:1px solid">';
			
				$show = "-";
					if($result['t_type'] == DEBIT ) {
							$show = $result['amount'];
					}
				$print .= $show;
		$print .= '</td><td align="right" style="border:1px solid">';
			
				$show = "-";
					if($result['t_type'] != DEBIT ) {
							$show = $result['amount'];
					}
				$print .= $show;
				
		$print .= '</td><td align="right" style="border:1px solid">'.$balance.'
		</td><td style="border:1px solid">';
			if(!empty($result['j_receipt'])) {
					$print .= "Receipt : ". $result['j_receipt'];
			}
			if(!empty($result['j_bill_number'])) {
				$print .=  "Bill  : ".$result['j_bill_number'];
			} 	
			if(!empty($result['cheque_number'])) {
				$print .=  "Cheque Number  : ".$result['cheque_number'];
			} 
		$print .= '</td><td style="border:1px solid">';
		
		
			if(!empty($result['receipt'])) {
				$print .=	 "Receipt : ". $result['receipt'];
			}
			if(!empty($result['bill_number'])) {
				$print .=  "Bill No. : ".$result['bill_number'];
			} 
		$print .= '</td><td style="border:1px solid">';
			$print .= $result['receivedby'];
			
			$print .= '-'.$result['amountby'];
		$print .= '</td><td style="border:1px solid">'.$result['notes'].'
		</td></tr>';
				
			}
			
		$monthly_balance = $total_credit - $total_debit;
		$print .= "<tr><td style='border:1px solid' colspan='4' align='right'>Total Debit</td><td style='border:1px solid'  align='right'><h3>".$total_debit."</h3></td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td></tr>";
		$print .= "<tr><td style='border:1px solid' colspan='4' align='right'>Total Credit</td><td style='border:1px solid'>-</td><td style='border:1px solid'  align='right'><h3>".$total_credit."</h3></td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td></tr>";
		$print .= "<tr><td style='border:1px solid' colspan='4' align='right'>Monthly Balance</td><td style='border:1px solid'>-</td><td style='border:1px solid'>-</td><td style='border:1px solid' align='right'><h3>".$monthly_balance."</h3></td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td></tr>";
		$print .= "</table>";
		$pdf = create_pdf($print,'A4');
		echo $pdf;
		}
	}

	public function ajax_view_customer($id,$print=0) {
		$this->load->model('customer_model');
		$c_info = $this->customer_model->get_customer_details('id',$id);
		$html = "";
		//print_r($print);
		if($print == 1) {
			$cname = $c_info->companyname ? $c_info->companyname : $c_info->name;
			$html .= '<table width="40%" align="center" border="0">
					<tr>
						<td>
							<strong>Name : '.$cname.'</strong>
							<p>
								'.$c_info->add1.',<br>
								'.$c_info->add2.',<br>
								'.$c_info->city.',<br>
								'.$c_info->state.',<br>
								'.$c_info->pin.'<br>
								Mobile : ' .$c_info->mobile.'<br>
								Email Id : ' .$c_info->emailid.'<br>
							</p>
						</td>
					</tr>
					</table>';
					
					$pdf = create_pdf($html,'A5');
		echo $pdf;
		die;			
		}else {
		$html .= '<table width="90%" border="1">
					<tr>
						<td align="right">Company Name : </td>
						<td>'.$c_info->companyname.'</td>
						<td align="right">	Mobile : </td>
						<td>'.$c_info->mobile.'</td>
					</tr>
					<tr>
						<td align="right">Contact Person Name : </td>
						<td>'.$c_info->name.'</td>
						<td align="right">	Mobile : </td>
						<td>'.$c_info->officecontact.'</td>
					</tr>
					<tr>
						<td align="right">Email Id : </td>
						<td>'.$c_info->emailid.'</td>
						<td align="right">	Other Email Id : </td>
						<td>'.$c_info->emailid2.'</td>
					</tr>
					<tr>
						<td colspan="4">
							<center>Address</center>
							<p>
								'.$c_info->add1.'<br>
								'.$c_info->add2.'<br>
								'.$c_info->city.'<br>
								'.$c_info->state.'<br>
								'.$c_info->pin.'<br>
							</p>
						</td>
					</tr>
					</table>';
					echo $html;
					die;
				}
	}
	
	public function ajax_check_receipt($rnum) {
		echo check_receipt_num($rnum);
	}
	
	public function ajax_task_reply() {
		if($this->input->post()) {
			$id = $this->input->post('id');
			$data['reply'] = $this->input->post('reply');
			$data['status'] = $this->input->post('status');
			$data['modified'] = date('Y-m-d H:i:s');
			$data['reply_from'] = $this->session->userdata['user_id'];
			
			$this->load->model('task_model');
			$status = $this->task_model->update_task($id,$data);
			echo "done";die;
		}
	}
	
	public function ajax_task_delete() {
		if($this->input->post()) {
			$id = $this->input->post('id');
			$this->load->model('task_model');
			$status = $this->task_model->delete_task($id);
			echo "done";die;
		}
	}
	
	public function set_schedule() {
		if($this->input->post()) {
			$data['title'] = $this->input->post('title');
			$data['description'] = $this->input->post('description');
			$data['reminder_time'] = $this->input->post('reminder_time');
			$data['user_for'] = implode(",",$this->input->post('receiver'));
			$data['is_sms'] = $this->input->post('is_sms');
			$data['user_creator'] = $this->session->userdata('user_id');
			$this->load->model('task_model');
			$this->task_model->save_scheduler($data);
			die("Done");
			
		}
	}
	
	public function check_notifications() {
		$this->load->model('task_model');
		$user_id = $this->session->userdata('user_id');
		$result = $this->task_model->get_all_schedules($user_id);
		
		/*$today = strtotime('today 14:30');
		$now =  strtotime('now');
		$today = ($today * 10 ) + 10000;
		
		if($today >= $now || $today <= $now)
		{
			echo 'Please Check Delivery Jobs !';
			die;
		}*/
		
		if($result['count'] > 0 ) {
			echo $result['task'];
		} else {
			echo 0;
		}
		die;
	}
	
	public function generaeAjaxCuttingSlip($jobId = null)
	{
		if($jobId)
		{
			$this->load->model('job_model');
			$jobData 			= $this->job_model->get_job_data($jobId);
			$jobDetails 		= $this->job_model->get_job_details($jobId);
			$customerDetails 	= $this->job_model->get_customer_details($jobData->customer_id);
			$cutting_info 		= $this->job_model->get_cutting_details($jobId);
			$created_info 		= get_user_by_param('id', $jobData->user_id);
			
			$pcontent = "";
			$sr=0;
		
			foreach($cutting_info as $cutting) {
				
				
			$cuttingBlock = $cornerBlock = $laserBlock = $laminationBlock = $bindingBlock = '';
			$pcontent .= '<table align="center" width="90%" align="center" style="border:1px solid;">
						<tr>
							<td style="font-size: 15px;" align="left" width="50%">Customer Name : '.$customerDetails->companyname.'</td>
							<td style="font-size: 15px;" align="right" width="50%">Date : '. date('d-m-Y H:i A', strtotime($jobData->created)).'</td>
						</tr>
						<tr>
							<td style="font-size: 14px;" align="left">Job Name : <strong>'.$jobData->jobname.'</strong></td>
							<td style="font-size: 14px;" align="right">Job Num : <strong>'.$jobData->id.'</strong></td>
						</tr>
						<tr>
							<td colspan="2" style="font-size: 12px;" align="center">Created By : <strong>'. strtoupper( $created_info->nickname ).'</strong></td>
							
						</tr></table>';

			$pcontent .='<table align="center" border="2" width="90%" style="border:1px solid;"><tr>';
			
				$pcontent .= '<td>
							<table align="center" border="2" width="100%" style="border:1px solid;">';
				
				if(!empty($cutting['c_material'])) {
					$c_m_label = "Material";
					if($cutting['c_material'] == "ROUND CORNER CUTTING") {
							$c_m_label = "";
					}	
				}
				$cuttingBlock .= '<table width="500px" align="center" border="1">
								<tr>
									<td colspan="2" style="font-size: 16px;">
										<strong>Cutting Details</strong>
									</td>
								</tr>
								<tr>
									<td   style="width: 100px; font-size:16px;" align="right"> Machine : </td>
									<td style="font-size:16px;"> '.$cutting['c_machine'].' </td>
								</tr>
								<tr>
									<td style="font-size:16px;" align="right"> ' .$c_m_label. ' : </td>
									<td style="font-size:16px;"> '.$cutting['c_material'].' </td>
								</tr>
								<tr>
									<td style="font-size:16px;" align="right"> Quantity : </td>
									<td style="font-size:16px;"> '.$cutting['c_qty'].' </td>
								</tr>
								<tr>
									<td style="font-size:16px;" align="right"> Size : </td>
									<td style="font-size:16px;"> '.$cutting['c_size'].' </td>
								</tr>
								<tr>
									<td  style="font-size:16px;" align="right"> Print : </td>
									<td  style="font-size:16px;"> '.$cutting['c_print'].' </td>
								</tr>
								<tr>
									<td  style="font-size:16px;" align="right"> Cutting Details : </td>
									<td  style="font-size:16px;"> '.$cutting['c_sizeinfo'].' </td>
								</tr>
							</table>';
				
				if(!empty($cutting['c_corner']) || !empty($cutting['c_cornerdie']) || !empty($cutting['c_rcorner']))
				{
					$cornerBlock .= '<table width="500px" align="center" border="1">
									<tr>
										<td colspan="2"  style="font-size:16px;">
											<strong>Corner Cutting Details</strong>
										</td>
									</tr>';
									
									if(!empty($cutting['c_corner'])) {
										$cornerBlock .= '<tr>
											<td  style="width: 100px; font-size: 16px;" align="right"> Corner Cut : </td>
											<td  style="font-size:16px;"> '.$cutting['c_corner'] .' </td>
										</tr>';	
									}
									
									if(!empty($cutting['c_cornerdie'])) {
										$cornerBlock .= '<tr>
										<td  style="font-size:16px;" align="right"> Corner Die : </td>
										<td style="font-size:16px;"> '.$cutting['c_cornerdie'] .' </td>
									</tr>';	
									}
									
									if(!empty($cutting['c_rcorner'])) {
										$cornerBlock .= '<tr>
										<td  style="font-size:16px;" align="right"> Round Side : </td>
										<td style="font-size:16px;"> '.$cutting['c_rcorner'] .' </td>
									</tr>';	
									}
					$cornerBlock .=	'</table>';
				} 
				
				if(!empty($cutting['c_laser']))
				{
					$laserBlock .= '<table width="500px"  align="center" border="1">
									<tr>
										<td colspan="2"  style="font-size:16px;">
											<strong>Laser Cutting</strong>
										</td>
									</tr>';
									
									if(!empty($cutting['c_laser']))
									{
									$laserBlock .= '<tr>
											<td style="width:100px; font-size: 16px;" align="right"> Laser Cut : </td>
											<td style="font-size:16px;"> '.$cutting['c_laser'] .' </td>
										</tr>';
									}
					$laserBlock .= '</table>';
				}
				
				if(!empty($cutting['c_lamination']) || !empty($cutting['c_laminationinfo']))
				{
					$laminationBlock .= '<table width="500px" align="center" border="1">
									<tr>
										<td colspan="2"  style="font-size:16px;">
											<strong>Lamination Details</strong>
										</td>
									</tr>';
									
									if(!empty($cutting['c_lamination']))
									{
										$laminationBlock .= '<tr>
											<td style="width:100px; font-size: 16px;" align="right"> Lamination : </td>
											<td style="font-size:16px;"> '.$cutting['c_lamination'] .' </td>
										</tr>';
									}
									
									if(!empty($cutting['c_laminationinfo']))
									{
										$laminationBlock .= '<tr>
										<td style="width:100px; font-size: 16px;" align="right"> Lamination Extra Details : </td>
										<td style="font-size:16px;"> '.$cutting['c_laminationinfo'].' </td>
									</tr>';
									}
									
					$laminationBlock .= '</table>';
				}
					
				if(!empty($cutting['c_binding']) || !empty($cutting['c_bindinginfo']))
				{
					$bindingBlock .= '<table width="500px" align="center" border="1">
									<tr>
										<td colspan="2"  style="font-size:16px;">
											<strong>Binding Details</strong>
										</td>
									</tr>';
										
									if(!empty($cutting['c_binding']))
									{
										$bindingBlock .= '<tr>
											<td style="width:100px; font-size: 16px;" align="right"> Binding Detaiils : </td>
											<td style="font-size:16px;"> '.$cutting['c_binding']  .' </td>
										</tr>';
									}

									if(!empty($cutting['c_blade_per_sheet']))
									{
										$bindingBlock .= '<tr>
											<td style="width:100px; font-size: 16px;" align="right"> Blade Per Sheet : </td>
											<td style="font-size:16px;"> '.$cutting['c_blade_per_sheet']  .' </td>
										</tr>';
									}
									if(!empty($cutting['c_bindinginfo']))
									{
										$bindingBlock .= '<tr>
											<td style="width:100px; font-size: 16px;" align="right"> Extra Details : </td>
											<td style="font-size:16px;"> '.$cutting['c_bindinginfo']  .' </td>
										</tr>';
									}
									
					$bindingBlock .= '</table>';
				}
				
				if(strlen($cuttingBlock) > 1 )
				{
					$pcontent .= '<tr><td colspan="2">' .$cuttingBlock.'</td></tr>';
					$pcontent .= '<tr><td colspan="2"><br></td></tr>';
				}
				
				if(strlen($cornerBlock) > 1 )
				{
					$pcontent .= '<tr><td colspan="2">' .$cornerBlock.'</td></tr>';
					$pcontent .= '<tr><td colspan="2"><br></td></tr>';
				}
				
				if(strlen($laserBlock) > 1 )
				{
					$pcontent .= '<tr><td colspan="2">' .$laserBlock.'</td></tr>';
					$pcontent .= '<tr><td colspan="2"><br></td></tr>';
				}
				
				if(strlen($laminationBlock) > 1 )
				{
					$pcontent .= '<tr><td colspan="2">' .$laminationBlock.'</td></tr>';
					$pcontent .= '<tr><td colspan="2"><br></td></tr>';
				}
				
				if(strlen($bindingBlock) > 1 )
				{
					$pcontent .= '<tr><td colspan="2">' .$bindingBlock.'</td></tr>';
				}
				
				if(!empty($cutting['c_details'])) {
					$pcontent .= '<tr><td style="width:40px; font-size: 16px;">Description : </td><td style="font-size:16px;"><strong> '.$cutting['c_details'].'</strong></td></tr>';
				}
				
				if(!empty($cutting['c_packing'])) {
					$pcontent .= '<tr><td style="width:40px; font-size: 16px;">Packing Details : </td><td style="font-size:16px;"><strong>'.$cutting['c_packing'].'</strong></td></tr>';
				}

			
				$pcontent .= '</table> </td>';
				$pcontent .= '</tr></table>';
				$sr++;
				
				if(isset($cutting_info[$sr]))
				{
					$pcontent .= "<pagebreak />";
				}
			}
			
			
			$pdfLink = create_pdf($pcontent, 'A5');
			
			echo json_encode(array( 
				'status' 	=> true,
				'link' 		=> $pdfLink
			));
			die();
		}
		
		echo json_encode(array( 
				'status' 	=> false,
				'message'  	=> "Unable to Crete PDF"
			));
		die;
	}
	
	public function getOutstationTransporterName($customerId)
	{
		$this->load->model('customer_model');
		$transporter = $this->customer_model->getTransporterDetailsByCustomerId($customerId);
		
		if($transporter)
		{
			echo json_encode(array(
				'status' => true,
				'transporter' => $transporter
			));
			
			die;
		}
		
		echo json_encode(array(
				'status' => false
			));
		die;
	}
	
	public function ajax_add_billnumber($jobId)
	{
		
		if($this->input->post()) 
		{
			$billNumber = $this->input->post('billNumber');
			
			$this->load->model('job_model');
			
			addBillToJobClearDueAmount($jobId, $billNumber);
			
		
			$status = $this->job_model->addJobBillNumber($jobId, $billNumber);
			
			if($status)
			{
				echo json_encode(array(
					'status' => true
				));
			
			die;
		}
		
		echo json_encode(array(
				'status' => false
			));
		die;
		}
	}
	
	public function ajax_add_discount($jobId = null)
	{
		if($jobId)
		{
			$discount = $this->input->post('discountAmount');
			$customerId = $this->input->post('customerId');
			
			$data = array(
				'customer_id' 	=> $customerId,
				'job_id' 		=> $jobId,
				'amount'		=> $discount,
				't_type'		=> 'credit',
				'notes'			=> 'Apply Discount',
				'creditedby'	=> $this->session->userdata['user_id'],
				'cmonth' 		=> date('M-Y'),
				'date'			=> date('Y-m-d')
			);
			$this->load->model('job_model');
			
			$jobData = array(
				'discount' => $discount
			);
			$this->job_model->update_job($jobId, $jobData);
			
			$status = $this->job_model->insert_transaction($data);
			
			if($status)
			{
			echo json_encode(array(
					'status' => true
				));
			
			die;
			}
		}
		
		echo json_encode(array(
				'status' => false
			));
		die;
	}
}

