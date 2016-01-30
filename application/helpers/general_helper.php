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
					$dropdown .= "<option value='".$customer->id."'>".$customer->companyname."</option>";
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
	
}
