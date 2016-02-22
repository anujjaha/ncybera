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
  
    
    function create_customer_dropdown($type,$flag=null) {
		if($type == "customer") {
			$sql = "SELECT id,name,companyname FROM customer WHERE ctype = 0 order by name";
			$ci=& get_instance();
			$ci->load->database(); 	
			$query = $ci->db->query($sql);
			$extra ="";
			if($flag) {
				$extra = 'onchange="customer_selected('."'customer'".',this.value)"';
			}
			$dropdown = "<select  class='form-control' name='customer' $extra><option value=0> Select Customer</option>";
			
			foreach($query->result() as $customer) {
					$cname = $customer->name;
					if($customer->companyname) {
						$cname = $customer->companyname;
					}
					$dropdown .= "<option value='".$customer->id."'>".$cname."</option>";
			}
			$dropdown .= '</select>';
			return $dropdown;
		}
		
		if($type == "dealer") {
			$sql = "SELECT id,name,companyname,dealercode FROM customer WHERE ctype=1 order by name";
		$ci=& get_instance();
		$ci->load->database(); 	
		$query = $ci->db->query($sql);
		$extra ="";
		if($flag) {
			$extra = 'onchange="customer_selected('."'dealer'".',this.value)"';
		}
		$dropdown = "<select  class='form-control' name='customer' $extra><option value=0> Select Dealer</option>";
		foreach($query->result() as $customer) {
				$dropdown .= "<option value='".$customer->id."'>".
				$customer->companyname
				."[".$customer->dealercode."]</option>";
		}
		$dropdown .= '</select>';
		return $dropdown;
		}
	}
	
	
    function get_all_customers($param=null,$value=null) {
		$sql = "SELECT * FROM customer order by name";
		if(!empty($param)) {
			$sql = "SELECT * FROM customer where $param = '".$value."' order by name";
		}
		$ci=& get_instance();
		$ci->load->database(); 	
		$query = $ci->db->query($sql);
		return $query->result();
	}
	
	function send_sms($user_id,$customer_id,$mobile,$sms_text=null) {
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
		
		$ci->load->model('sms_transaction_model','sms');
		$sms_data['user_id'] = $user_id;
		$sms_data['customer_id'] = $customer_id;
		$sms_data['sms_text'] = $sms_text;
		$sms_data['mobile'] = strlen($mobile);
		$sms_data['char_count'] = strlen($sms_text);
		$sms_data['status'] = $response;
		$ci->sms->insert_sms($sms_data);
	return true;
	}
	
}

function create_pdf($content=null,$size ='A5-L') {
	if($content) {
		$ci = & get_instance();
		$mpdf = new mPDF('', $size,8,'',4,4,10,2,4,4);
		$mpdf->SetHeader('CYBERA Print ART');
		$mpdf->defaultheaderfontsize=8;
		//$mpdf->SetFooter('{PAGENO}');
		$mpdf->WriteHTML($content);
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->shrink_tables_to_fit=0;
		$mpdf->list_indent_first_level = 0;  
		$filename = "jobs/".rand(1111,9999)."_".rand(1111,9999)."_Job_Order.pdf";
		$mpdf->Output('cybera.pdf','D');
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
