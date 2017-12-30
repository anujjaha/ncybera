<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('test_method'))
{
    function test_method($var = null)
    {
        echo "Test Method";
    }   
    
    function user_logged_in() {
        $ci =& get_instance();
        $class = $ci->router->fetch_class();
        $method = $ci->router->fetch_method();
        if($class == 'user' &&  $method == 'login' || $method == 'logout') {
            return true;
        } else { 
            if(! isset($ci->session->userdata['login'])) {
                redirect("user/login/",'refresh'); 
            }
        }
    }
    
    function user_authentication($department) {
        $ci =  & get_instance();
        $class = $ci->router->fetch_class();
        $method = $ci->router->fetch_method();
        if($class == 'user' &&  $method == 'login' || $method == 'logout') {
            return true;
        }
        if($class == 'ajax') { return true; }
        if($class != $department) {
            redirect("$department",'refresh'); 
        }
        return true;
    }
  	
  	function createAllExistingCustomerDropDown($flag = true)
  	{
  		$sql = "SELECT id,name,companyname FROM customer order by companyname";
		$ci=& get_instance();
		$ci->load->database(); 	
		$query = $ci->db->query($sql);
		$extra ="";
		if($flag) {
			$extra = 'onchange="customer_selected('."'customer'".',this.value)"';
		}
		$dropdown = "<select id='customer'  class='form-control select-customer' name='customer' $extra><option value=0> Select Customer</option>";
		
		foreach($query->result() as $customer) {
				$cname = ucwords($customer->name);
				if($customer->companyname) {
					$cname = ucwords($customer->companyname);
				}
				$dropdown .= "<option value='".$customer->id."'>".strtolower($cname)."</option>";
		}
		$dropdown .= '</select>';
		return $dropdown;
  	}
    
    function create_customer_dropdown($type,$flag=null) {
		if($type == "customer") {
			$sql = "SELECT id,name,companyname FROM customer WHERE ctype = 0 order by companyname";
			$ci=& get_instance();
			$ci->load->database(); 	
			$query = $ci->db->query($sql);
			$extra ="";
			if($flag) {
				$extra = 'onchange="customer_selected('."'customer'".',this.value)"';
			}
			$dropdown = "<select  class='form-control select-customer' name='customer' $extra><option value=0> Select Customer</option>";
			
			foreach($query->result() as $customer) {
					$cname = ucwords($customer->name);
					if($customer->companyname) {
						$cname = ucwords($customer->companyname);
					}
					$dropdown .= "<option value='".$customer->id."'>".strtolower($cname)."</option>";
			}
			$dropdown .= '</select>';
			return $dropdown;
		}
		
		if($type == "dealer") {
			$sql = "SELECT id,name,companyname,name,dealercode FROM customer WHERE ctype=1 order by companyname";
			$ci=& get_instance();
			$ci->load->database(); 	
			$query = $ci->db->query($sql);
			$extra ="";
			if($flag) {
				$extra = 'onchange="customer_selected('."'dealer'".',this.value)"';
			}
			$dropdown = "<select  class='form-control select-dealer' name='customer' $extra><option value=0> Select Dealer</option>";
			foreach($query->result() as $customer) {
				$name = $customer->companyname ? $customer->companyname : $customer->name;
					$dropdown .= "<option value='".$customer->id."'>".
					strtolower($name)
					." [".$customer->dealercode."]</option>";
			}
			$dropdown .= '</select>';
			return $dropdown;
		}
		
		if($type == "outstation") {
			$sql = "SELECT id,name,companyname,name,dealercode FROM customer WHERE ctype=3 order by companyname";
			$ci=& get_instance();
			$ci->load->database(); 	
			$query = $ci->db->query($sql);
			$extra ="";
			if($flag) {
				$extra = 'onchange="customer_selected('."'outstation'".',this.value)"';
			}
			$dropdown = "<select  class='form-control select-dealer' name='customer' $extra><option value=0> Select Customer</option>";
			foreach($query->result() as $customer) {
				$name = $customer->companyname ? $customer->companyname : $customer->name;
					$dropdown .= "<option value='".$customer->id."'>".
					strtolower($name)
					." [".$customer->dealercode."]</option>";
			}
			$dropdown .= '</select>';
			return $dropdown;
		}
		
		if($type == "voucher") {
			$sql = "SELECT id,name,companyname FROM customer WHERE ctype=2 order by companyname";
		$ci=& get_instance();
		$ci->load->database(); 	
		$query = $ci->db->query($sql);
		$extra ="";
		if($flag) {
			$extra = 'onchange="customer_selected('."'voucher'".',this.value)"';
		}
		$dropdown = "<select  class='form-control select-voucher' name='customer' $extra><option value=0> Select Voucher Customer</option>";
		foreach($query->result() as $customer) {
				$c_name = $customer->companyname ? $customer->companyname : $customer->name;
			
				$dropdown .= "<option value='".$customer->id."'>".
				strtolower($c_name)
				."</option>";
		}
		$dropdown .= '</select>';
		return $dropdown;
		}
	}
	
	
    function get_all_customers($param=null,$value=null) {
		$sql = "SELECT * FROM customer order by companyname";
		if(!empty($param)) {
			$sql = "SELECT * FROM customer where $param = '".$value."' order by companyname";
		}
		$ci=& get_instance();
		$ci->load->database(); 	
		$query = $ci->db->query($sql);
		return $query->result();
	}
	
	function getAllEmailEstimationCustomers($param=null,$value=null) {
		$sql = "SELECT DISTINCT('id'), customer.* FROM customer order by companyname";
		if(!empty($param)) {
			$sql = "SELECT DISTINCT('id'), customer.* FROM customer where $param = '".$value."' order by companyname";
		}
		$ci=& get_instance();
		$ci->load->database(); 	
		$query = $ci->db->query($sql);
		return $query->result();
	}
	
	function getCustomerOutside($customerId = null)
	{
		if($customerId)
		{
			$sql = "SELECT outside FROM customer where id = '".$customerId."'";
			$ci=& get_instance();
			$ci->load->database(); 	
			$query = $ci->db->query($sql);
			return $query->row()->outside;
		}
		
		return false;
	}
	
	function getAllEmailBulkCustomers($param=null,$value=null) {
		$sql = "SELECT DISTINCT('id'), customer.* FROM customer WHERE emailid != '' order by companyname";
		if(!empty($param)) {
			$sql = "SELECT DISTINCT('id'), customer.* FROM customer where $param = '".$value."' AND WHERE emailid != '' order by companyname";
		}
		$ci=& get_instance();
		$ci->load->database(); 	
		$query = $ci->db->query($sql);
		return $query->result();
	}
	
	
	function getAllEmailBulkCustomersOnly($param=null,$value=null) {
		$sql = "SELECT DISTINCT('id'), customer.* FROM customer WHERE emailid != '' AND ctype = 0 order by companyname";
		if(!empty($param)) {
			$sql = "SELECT DISTINCT('id'), customer.* FROM customer where $param = '".$value."' AND WHERE emailid != '' AND ctype = 0  order by companyname";
		}
		$ci=& get_instance();
		$ci->load->database(); 	
		$query = $ci->db->query($sql);
		return $query->result();
	}
	
	function getAllEmailBulkDealersOnly($param=null,$value=null) {
		$sql = "SELECT DISTINCT('id'), customer.* FROM customer WHERE emailid != '' AND ctype = 1 order by companyname";
		if(!empty($param)) {
			$sql = "SELECT DISTINCT('id'), customer.* FROM customer where $param = '".$value."' AND WHERE emailid != '' AND ctype = 1  order by companyname";
		}
		$ci=& get_instance();
		$ci->load->database(); 	
		$query = $ci->db->query($sql);
		return $query->result();
	}
	
	function getAllEmailBulkVourcherCustomerOnly($param=null,$value=null) {
		$sql = "SELECT DISTINCT('id'), customer.* FROM customer WHERE emailid != '' AND ctype = 2 order by companyname";
		if(!empty($param)) {
			$sql = "SELECT DISTINCT('id'), customer.* FROM customer where $param = '".$value."' AND WHERE emailid != '' AND ctype = 2  order by companyname";
		}
		$ci=& get_instance();
		$ci->load->database(); 	
		$query = $ci->db->query($sql);
		return $query->result();
	}
	
	function send_sms($user_id=null,$customer_id=null,$mobile,$sms_text=null,$prospect_id=0) {

		//return true;
		
		$ci=& get_instance();
		$ci->load->database(); 
		if(! $user_id) {
			$user_id = $ci->session->userdata['user_id'];
		}
		
		$msg = str_replace(" ","+",$sms_text);
		$url = "http://ip.infisms.com/smsserver/SMS10N.aspx?Userid=cyberabill&UserPassword=cyb123&PhoneNumber=$mobile&Text=$msg&GSM=CYBERA";
		
		$url = urlencode($url);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, urldecode($url));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		$response = curl_exec($ch);
		curl_close($ch);
		
		
		if($user_id && $customer_id)
		{
			$ci->load->model('sms_transaction_model','sms');
			$sms_data['user_id'] = $user_id;
			$sms_data['customer_id'] = $customer_id;
			$sms_data['prospect_id'] = $prospect_id;
			$sms_data['sms_text'] = $sms_text;
			$sms_data['mobile'] = $mobile;
			$sms_data['char_count'] = strlen($sms_text);
			$sms_data['status'] = $response;
			$ci->sms->insert_sms($sms_data);
		}
	return true;
	}
	
}

function send_account_sms($mobile,$sms_text=null)
{
		$msg = str_replace(" ","+",$sms_text);
		$url = "http://ip.infisms.com/smsserver/SMS10N.aspx?Userid=cyberabill&UserPassword=cyb123&PhoneNumber=$mobile&Text=$msg&GSM=CYBERA";
		$url = urlencode($url);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, urldecode($url));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		$response = curl_exec($ch);
		curl_close($ch);
}

function create_pdf($content=null,$size ='A5-L') {
	if($content) {
		
		//print_r($content);die("F");
		$ci = & get_instance();
		$mpdf = new mPDF('', $size,8,'',4,4,10,2,4,4);
		//$mpdf->SetHeader('CYBERA Print ART');
		$mpdf->defaultheaderfontsize=8;
		//$mpdf->SetFooter('{PAGENO}');
		$mpdf->WriteHTML($content);
		$mpdf->shrink_tables_to_fit=0;
		$mpdf->list_indent_first_level = 0;  
		//$filename = "jobs/".rand(1111,9999)."_".rand(1111,9999)."_Job_Order.pdf";
		$fname = "account_pdf_report/".rand(1111,9999)."_cybera.pdf";
		$mpdf->Output($fname,'F');
		return base_url().$fname;
	}
}

function get_user_by_param($param=null,$value=null) {
	if($param && $value) {
		$ci = & get_instance();
		$ci->db->select('*')
			->from('user_meta')
			->where("$param","$value");
		$query = $ci->db->get();
		return $query->row();
	}
}

function get_restricted_department() {
	return array("prints","cuttings");
}

function get_papers_size() {
	$ci = & get_instance();
	$ci->load->model('job_model');
	$data['papers'] = $ci->job_model->get_paper_gsm();
	$data['size'] = $ci->job_model->get_paper_size();
	return $data;
}

function job_complete_sms($job_id=null) {
	if($job_id) {
		$ci = & get_instance();
		$sql = "SELECT if(CHAR_LENGTH(c.companyname) > 0,c.companyname,c.name) as customer_name,
				job.smscount,job.customer_id,c.mobile,job.smscount,
				job.total,job.due, job.jsmsnumber,
				(SELECT SUM(total) from job WHERE job.customer_id = c.id)  as 'total_amount' ,
				(SELECT SUM(due) from job WHERE job.customer_id = c.id)  as 'total_due' ,
				(select sum(amount) from user_transactions where user_transactions.customer_id=c.id) as 'total_credit'
				FROM job 
				LEFT JOIN customer c
				ON c.id = job.customer_id
				WHERE job.id = $job_id";
				
		$query = $ci->db->query($sql);
		$result = $query->row();
		$balance = $result->total_credit - $result->due;
		
		if($result->smscount != 0 ) {
				return true;
		}
		
		if( $balance < 0 ) {
			$sms_text = "Dear ".$result->customer_name." Your Job Num $job_id of rs. ".$result->total." completed and ready for delivery. Total due Rs. $balance (GST Extra) Thank You.";
		} else {
				$sms_text = "Dear ".$result->customer_name." Your Job Num $job_id of rs. ".$result->total." completed and ready for delivery. Pay ".$result->due." due amt. (GST Extra) to collect your job. Thank You.";
		}
		
		$data['smscount'] = $result->smscount  + 1;
		$ci->db->where('id',$job_id);
		$ci->db->update('job',$data);
		
		$customer_id = $result->customer_id;
		$mobile = $result->mobile;
		$otherMobile = $result->jsmsnumber;
		//$mobile = "9898618697";
		$user_id = $ci->session->userdata['user_id'];
		
		send_sms($user_id,$customer_id,$mobile,$sms_text);
		if(strlen($otherMobile) > 2 )
		{
			send_sms($user_id,$customer_id,$otherMobile,$sms_text);
		}
		
		return true;
	}
	return true;
}

function get_master_statistics() {
	$ci = & get_instance();
	$ci->load->model('master_model');
	return $ci->master_model->get_master_statistics();
}

function get_department_revenue() {
	$ci = & get_instance();
	$sql = "SELECT 
			(select sum(jamount) from job_details 
			where jtype = 'Digital Print') as dprint,
			
			(select sum(jamount) from job_details 
			where jtype = 'Flex') as dflex,

			(select sum(jamount) from job_details 
			where jtype = 'Cutting' ) as 'dcutting' ,

			(select sum(jamount) from job_details 
			where jtype = 'Designing' ) as 'ddesigning',

			(select sum(jamount) from job_details 
			where jtype = 'Visiting Card' ) as 'dvisitingcard',
			
			(select sum(jamount) from job_details 
			where jtype = 'Offset Print' ) as 'doffsetprint',
			
			(select sum(jamount) from job_details 
			where jtype = 'Binding' ) as 'dbinding',

			(select sum(jamount) from job_details 
			where jtype = 'Lamination' ) as 'dlamination',

			(select sum(jamount) from job_details 
			where jtype = 'Packaging and Forwading' ) as 'dpackaging',

			(select sum(jamount) from job_details 
			where jtype = 'Transportation' ) as 'dtransportation',

			(select sum(jamount) from job_details 
			where jtype = 'B/W Print' ) as 'dbwprint'
			from job_details limit 1";
	$query = $ci->db->query($sql);
	return $query->row();
}

function sendCorePHPMail($to, $from, $subject="Cybera Email System", $content=null)
{
	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	$headers .= 'From: Cybera<'.$from.'>' . "\r\n";
	
	if(! mail($to, $subject, $content, $headers))
	{
		return 'Unable to send an Email';
	}
	
	return true;
}

function send_mail($to, $from,$subject="Cybera Email System",$content=null) {
	$mail = new PHPMailer();
	$mail->Host     	= "smtp.gmail.com"; // SMTP server
	$mail->SMTPAuth    	= TRUE; // enable SMTP authentication
	$mail->SMTPSecure  	= "tls"; //Secure conection
	$mail->Port        	= 587; // set the SMTP port
	$mail->Username    	= 'cyberaprintart@gmail.com'; // SMTP account username
	$mail->Password     = 'cyb_1215@printart'; // SMTP account password
	$mail->SetFrom('cybera.printart@gmail.com', 'Cybera Print Art');
	$mail->AddAddress($sendTo);	
	$mail->isHTML( TRUE );
	$mail->Subject  = $subject;
	$mail->Body     = $content;
	if(!$mail->Send()) {
	  echo 'Message was not sent.';
	 // echo 'Mailer error: ' . $mail->ErrorInfo;
	} else {
	  return true;
	}
}

function send_email_attachment($to, $subject="Cybera Email System", $content=null, $attachment = null)
{
	$mail = new PHPMailer();
	$mail->Host     	= "smtp.gmail.com"; // SMTP server
	$mail->SMTPAuth    	= TRUE; // enable SMTP authentication
	$mail->SMTPSecure  	= "tls"; //Secure conection
	$mail->Port        	= 587; // set the SMTP port
	$mail->Username    	= 'cyberaprintart@gmail.com'; // SMTP account username
	$mail->Password     = 'cyb_1215@printart'; // SMTP account password
	$mail->SetFrom('cybera.printart@gmail.com', 'Cybera Print Art');
	$mail->AddAddress($to);	
	$mail->isHTML( TRUE );
	$mail->Subject  = $subject;
	$mail->Body     = $content;
	if($attachment)
	{
		$mail->AddAttachment($attachment);
	}

	if(!$mail->Send()) 
	{
		return false;
	}else
	{
		addDueEmailToday();	
	}
	return true;
}

function sendEstimationEmail($to, $from,$subject="Cybera Email System",$content=null) {
	$mail = new PHPMailer();
	$mail->Host     	= "smtp.gmail.com"; // SMTP server
	$mail->SMTPAuth    	= TRUE; // enable SMTP authentication
	$mail->SMTPSecure  	= "tls"; //Secure conection
	$mail->Port        	= 587; // set the SMTP port
	$mail->Username    	= 'cyberaprintart@gmail.com'; // SMTP account username
	$mail->Password     = 'cyb_1215@printart'; // SMTP account password
	$mail->SetFrom('cybera.printart@gmail.com', 'Cybera Print Art');
	
	foreach($to as $sendTo) 
	{
		if(isset($sendTo))
		{
			$mail->AddAddress(trim($sendTo));		
		}
		
	}
	
	$mail->AddCC("cyberaprintart@gmail.com");
	$mail->isHTML( TRUE );
	$mail->Subject  = $subject;
	$mail->Body     = $content;
	if(!$mail->Send()) {
	  echo 'Message was not sent.';
	 // echo 'Mailer error: ' . $mail->ErrorInfo;
	} else {
	  return true;
	}
}	

function sendBulkEmail($to, $from,$subject="Cybera Email System",$content=null) {
	$mail = new PHPMailer();
	$mail->Host     	= "smtp.gmail.com"; // SMTP server
	$mail->SMTPAuth    	= TRUE; // enable SMTP authentication
	$mail->SMTPSecure  	= "tls"; //Secure conection
	$mail->Port        	= 587; // set the SMTP port
	$mail->Username    	= 'cyberaprintart@gmail.com'; // SMTP account username
	$mail->Password     = 'cyb_1215@printart'; // SMTP account password
	$mail->SetFrom('cybera.printart@gmail.com', 'Cybera Print Art');
	
	foreach($to as $sendTo) 
	{
		if(isset($sendTo))
		{
			$mail->AddAddress(trim($sendTo));		
		}
		
	}
	
	$mail->isHTML( TRUE );
	$mail->Subject  = $subject;
	$mail->Body     = $content;
	if(!$mail->Send()) {
	  echo 'Message was not sent.';
	 // echo 'Mailer error: ' . $mail->ErrorInfo;
	} else {
	  return true;
	}
}	


	function get_balance($user_id=null) {
		$ci = & get_instance();
		$sql = "SELECT id,
					(SELECT sum(amount) from user_transactions ut where ut.customer_id=$user_id and t_type ='credit') as 'total_credit',
					(SELECT sum(amount) from user_transactions ut where ut.customer_id=$user_id and t_type ='debit') as 'total_debit'
				 from user_transactions
				 WHERE customer_id = $user_id LIMIT 1" ;
		$query = $ci->db->query($sql);
		$result = $query->row();
		$balance = $result->total_debit - $result->total_credit;
		return round($balance);
	}
	function get_acc_balance($user_id=null) {
		$ci = & get_instance();
		$sql = "SELECT id,
					(SELECT sum(amount) from user_transactions ut where ut.customer_id=$user_id and t_type ='credit') as 'total_credit',
					(SELECT sum(amount) from user_transactions ut where ut.customer_id=$user_id and t_type ='debit') as 'total_debit'
				 from user_transactions
				 WHERE customer_id = $user_id LIMIT 1" ;
		$query = $ci->db->query($sql);
		$result = $query->row();
		$balance = $result->total_credit - $result->total_debit;
		return round($balance);
	}

function check_receipt_num($rnum) {
	$ci = & get_instance();
	$ci->db->select('id')
			->from('user_transactions')
			->where('receipt',$rnum);
	$query = $ci->db->get();
	if($query->row()->id) {
		return true;
	}
	return false;
	
}
	
function update_user_discount($job_id,$amount) {
	$ci = & get_instance();
	$ci->db->select('user_transaction_id')
			->from('job_discount')
			->where('job_id',$job_id);
	$query = $ci->db->get();
	$user_transaction_id = $query->row()->user_transaction_id;
	
	$update_discount_data = array('amount'=>$amount); 
	$ci->db->where('id',$user_transaction_id);
	$ci->db->update('user_transactions',$update_discount_data);
	//echo $ci->db->last_query();
	
	$ci->db->where('job_id',$job_id);
	$ci->db->update('job_discount',$update_discount_data);
	//echo $ci->db->last_query();
	
	//die("F");
}

function get_task_user_list() {
	 $ci = & get_instance();
	
	$ci->db->select('user_meta.id,nickname')
			->from('user_meta')
			->join('users','users.id = user_meta.user_id','left')
			->where('users.department != ','Master')
			->where('users.id != ','1')
			->where('users.active','1')
			->where('users.id !=',$ci->session->userdata['id'])
			->order_by('user_meta.nickname');
	$query = $ci->db->get();
	$result = $query->result_array();
	?>
	<select name="receiver[]" id="receiver" class="form-control" multiple="multiple">
	<?php
	foreach($result as $user) {
	?>
		<option value="<?php echo $user['id'];?>">
			<?php echo $user['nickname'];?>
		</option>
	<?php
	}
	?>
	</select>
	<?php
}

function getCustomerPreferCourierService($customerId = null)
{
	if($customerId)
	{
		$sql = "SELECT * FROM transporter_details WHERE customer_id = $customerId";
		$ci=& get_instance();
		$ci->load->database(); 	
		$query = $ci->db->query($sql);
		return $query->row()->name;
	}
	
	return false;
}

function pr($data, $flag = true)
{
	echo "<pre>";
		print_r($data);
	echo "</pre>";
	
	if($flag)
	{
		die;
	}
}

function getEmployeeSelectBoxForAttendance($month = null, $year = null)
{
	if(! $month)
	{
		$month = date('F');
	}
	
	if(! $year)
	{
		$year = date('Y');	
	}
	
	
	$sql = 'SELECT id,name FROM employees
			WHERE id NOT IN ( SELECT emp_id from attendance WHERE month = "'.$month.'" and year = "'.$year.'")
			order by name';
	$ci=& get_instance();
	$ci->load->database(); 	
	$query = $ci->db->query($sql);
	$extra ="";
	
	$dropdown = "<select  class='form-control select-customer' name='emp_id' ><option value=0> Select Emplooyee</option>";
	
	foreach($query->result() as $customer) 
	{
			$cname = ucwords($customer->name);
			$dropdown .= "<option value='".$customer->id."'>".$cname."</option>";
	}
	$dropdown .= '</select>';
	return $dropdown;
}


function  getEmployeeSelectBox()
{
	$sql = 'SELECT id,name FROM employees
			WHERE id NOT IN ( SELECT emp_id from attendance WHERE month = "'.$month.'" and year = "'.$year.'")
			order by name';
	$ci=& get_instance();
	$ci->load->database(); 	
	$query = $ci->db->query($sql);
	$extra ="";
	
	$dropdown = "<select  class='form-control select-customer' name='emp_id' ><option value=0> Select Emplooyee</option>";
	
	foreach($query->result() as $customer) 
	{
			$cname = ucwords($customer->name);
			$dropdown .= "<option value='".$customer->id."'>".$cname."</option>";
	}
	$dropdown .= '</select>';
	return $dropdown;
}

function getBusinessByDate($date = null)
{
	$todayDate = date('d-m-y');
	
	if($date)
	{
		$todayDate = date('d-m-y', strtotime($date));
	}
	$sql = 'SELECT SUM(amount) totalBusiness FROM  user_transactions WHERE 
			t_type = "debit" AND date_format(created, "%d-%m-%y") = "'.$todayDate.'"';
			
	$ci=& get_instance();
	$ci->load->database(); 	
	$query = $ci->db->query($sql);
	
	return $query->row()->totalBusiness;
}

function getBusinessCollectionByDate($date = null)
{
	$todayDate = date('d-m-y');
	
	if($date)
	{
		$todayDate = date('d-m-y', strtotime($date));
	}
	$sql = 'SELECT SUM(amount) totalCollection FROM  user_transactions WHERE 
			t_type = "credit" AND date_format(created, "%d-%m-%y") = "'.$todayDate.'"';
			
	$ci=& get_instance();
	$ci->load->database(); 	
	$query = $ci->db->query($sql);
	
	return $query->row()->totalCollection;
}

function getAccountInfo()
{
	$sql = "select DISTINCT(job.customer_id), customer.id, customer.name, customer.companyname, customer.mobile 
			from job 
			LEFT JOIN customer  on customer.id = job.customer_id
			WHERE ctype != 2";
			
		$ci=& get_instance();
	$ci->load->database(); 	
	$query = $ci->db->query($sql);
		

		$html = '<table align="center" border="2" style="border: solid 2px black;">
				<tr>
					<td style="border: solid 2px;"> Sr </td>
					<td style="border: solid 2px;"> Company Name </td>
					<td style="border: solid 2px;"> Name </td>
					<td style="border: solid 2px;"> Mobile </td>
					<td style="border: solid 2px;"> Credit </td>
					<td style="border: solid 2px;"> Debit </td>
				</tr>';
			$sr = 1;
		foreach($query->result() as $customer)
		{
			if(! $customer->id )
			{
				continue;
			}
				$customerSql = "select 
							(SELECT SUM(amount) from user_transactions ut WHERE ut.customer_id = customer.id and t_type ='debit')  as 'total_debit' ,
							(select sum(amount) from user_transactions ut where ut.customer_id=customer.id  and t_type ='credit') as 'total_credit'
										from customer where id = ".$customer->id;
				
				$customerBalance = $ci->db->query($customerSql)->row();
				if(! $customerBalance)
				{
					continue;
				}
				//$customerBal = mysql_fetch_row($customerBalance);
				
				
				$balance = round($customerBalance->total_credit - $customerBalance->total_debit, 0);
				if($balance != 0 )
				{
					$debit = $credit = " - ";
					
					if($balance > 0 )
					{
						$credit = $balance;
					}
					else
					{
						$debit = $balance;
					}
					
					$html .= '<tr>
								<td style="border: solid 2px;"> '.$sr.' </td>
								<td style="border: solid 2px;"> '. $customer->companyname .' </td>
								<td style="border: solid 2px;"> '. $customer->name .' </td>
								<td style="border: solid 2px;"> '. $customer->mobile  .' </td>
								<td style="border: solid 2px; color: green;"> ' .$credit . ' </td>
								<td style="border: solid 2px; color: red;"> ' .$debit . ' </td>
							</tr>';
				}
				else
				{
					continue;
				}
				
				$sr++; 
		} 

		$html .= '</table>';
		return $html;
}

function sendDueEmailToday()
{
	$todayDate = date('Y-m-d');
	
	$sql = 'SELECT count(id) as todayEmailCount from daily_mail_status where checkdate = "'.$todayDate.'" ';
			
	$ci=& get_instance();
	$ci->load->database(); 	
	$query = $ci->db->query($sql);
	
	return $query->row()->todayEmailCount;
}


function addDueEmailToday()
{
	$todayDate = date('Y-m-d');
	
	$data = array(
		'checkdate' 	=> $todayDate,
		'created_at' 	=> date('Y-m-d H:i:s')
	);
	
	$ci=& get_instance();
	$ci->load->database(); 	
	return $ci->db->insert('daily_mail_status', $data);
}

function getCustomerType($customerId)
{
	if($customerId)
	{
		$sql = 'SELECT ctype as customerType from customer where id = "'.$customerId.'" ';
			
		$ci=& get_instance();
		$ci->load->database(); 	
		$query = $ci->db->query($sql);
		
		return $query->row()->customerType;
	}
	
	return false;
}

function getBillStatus($jobId = null)
{
		if($jobId)
		{
			$ci = & get_instance();
			$ci->load->model('job_model');
			$jobInfo = $ci->job_model->getJobById($jobId);
			
			if(isset($jobInfo->bill_number) && strlen($jobInfo->bill_number))
			{
				return $jobInfo->bill_number;
			}
			
			$sql = "SELECT bill_number FROM user_transactions WHERE job_id = '". $jobId ."'";
			
			$ci->load->database(); 	
			$query = $ci->db->query($sql);
			
			foreach($query->result() as $jobBill)
			{
				if($jobBill->bill_number && strlen($jobBill->bill_number) > 2 )
				{
					return $jobBill->bill_number;
				}
			}
			
		}
		
		return false;
	
}

function clearUserTransactionsByJobId($jobId = null)
{
	if($jobId)
	{
			$sql = "Delete from user_transactions WHERE job_id = '". $jobId ."'";
			$ci=& get_instance();
			$ci->load->database(); 	
			return $ci->db->query($sql);
	}
	
	return false;
}

function addBillToJobClearDueAmount($jobId = null, $billNumber = null)
{
	if($jobId)
	{
		$ci = & get_instance();
		$ci->load->model('job_model');
		$jobInfo = $ci->job_model->getJobById($jobId);
		$jobTransactionInfo = array(
			'customer_id' 	=> $jobInfo->customer_id,
			'job_id' 		=> $jobId,
			'amount' 		=> $jobInfo->due,
			'bill_number' 	=> '',
			'other' 		=> 'Bill-Created',
			'pay_ref' 		=> 'Bill-Created',
			'notes' 		=> 'Bill-Created - For Job',
			't_type' 		=> 'credit',
			'cmonth'		=> date('M-Y'),
			'date'			=> date('Y-m-d'),
			'creditedby'	=> $ci->session->userdata['user_id']
		);
		
		$status = $ci->job_model->insert_transaction($jobTransactionInfo);
		
		if($status)
		{
			$updateJob = array(
				'settlement_amount' => $jobInfo->due,
				'due'				=> 0,
				'jpaid'				=> 1
			);
			$ci->job_model->update_job($jobId, $updateJob);
		}
		
		return true;
	}
}


function jobSettleAmount($jobId = null, $amount = 0)
{
	if($jobId)
	{
		$ci = & get_instance();
		$ci->load->model('job_model');
		$jobInfo = $ci->job_model->getJobById($jobId);
		$jobTransactionInfo = array(
			'customer_id' 	=> $jobInfo->customer_id,
			'job_id' 		=> $jobId,
			'amount' 		=> $amount,
			'bill_number' 	=> '',
			'other' 		=> '',
			'pay_ref' 		=> '',
			'notes' 		=> '',
			't_type' 		=> 'debit',
			'cmonth'		=> date('M-Y'),
			'date'			=> date('Y-m-d'),
			'creditedby'	=> $ci->session->userdata['user_id']
		);
		
		return $ci->job_model->insert_transaction($jobTransactionInfo);
	}
}
