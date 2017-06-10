<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('account_model');
		$this->load->model('customer_model');
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
		$result = $this->account_model->get_account_customer_details();
		$data['title']="Customer Account Management";
		$data['heading']="Customer Account Management";
		$data['customers']= $result;
		//$this->template->load('customer', 'index', $data);
		$this->template->load('account', 'index', $data);
	}
	
	

	public function pdf()
	{
		if(isset($_GET['sEcho']))
		{
			return $this->ajax_list();
		}
		$data["data"] = $this->account_model->get_all();
 		$data['title']="Customer Account Management";
		$data['heading']="Customer Account Management";
		$this->template->load('account', 'pdf', $data);
	}
	
	public function sendmail()
	{
		$message = getAccountInfo();
		$pdfFile = create_pdf($message);
		$fileName = explode("/", $pdfFile);
		$pdfFileName = array_pop($fileName);

		$attachment ="account_pdf_report/".$pdfFileName;
		$content = "Hello Shaishav, \n\n <br><br>
						Send an Email - ".date('d-m-Y H:i A')."
						Please find attached PDF For Due Amount List with Company Names." ;
		$subject = 'List of Companies Due Amount - '.date('d-m-Y H:i A');
		$status = send_email_attachment('cyberaprintart@gmail.com', $subject, $content, $attachment);
		
		if($status)
		{
			redirect('user/index','refresh');
		}
	}

	public function ajax_list()
	{
        $offset = 0;
        $limit = 10;
        if ( isset( $_GET["start"] ) && $_GET["start"] != "-1"  ) {
            $offset = $_GET["start"];
            $limit = $_GET["length"];
        }
    
        $like = "";
        if (isset( $_GET["search"]["value"] ) &&   $_GET["search"]["value"] != "" ) {
            $like =  $_GET["search"]["value"];
        }
    
        $records = $this->account_model->get_all_list($like,$offset,$limit);
        $total_modules = $this->account_model->count_all();
        $iTotal = $total_modules->total_records;
        $init_val = 1;
        if(isset($_GET["draw"]))
        {
        	$init_val = $_GET["draw"];
        }
        $output = array(  "recordsTotal" => $iTotal,"recordsFiltered" => $iTotal, "data"=>array());	
        $sr=0;
       	
       	$balance = 0;
       	foreach($records as $record) 
       	{
       		$balance = round($record['total_credit'] - $record['total_debit'], 0);

       		$show = '<span class="green">'.$balance.'</span>';
			if($balance < 0 ) {
				$show = '<span class="red">'.$balance.'</span>';
			} 

        	$output["data"][$sr] = array(
        		$sr+1,
        		$record["name"],
        		$record["companyname"],
        		$record["total_debit"],
        		$record["total_credit"],
        		$show,
        		$record["mobile"],
        		$record["emailid"],
        		$record['city'],
        		'<a target="_blank" href="'.site_url().'/account/account_details/'.$record['id'].'">View</a>'
        	);
            $sr++;
        }
        
        echo json_encode($output);
                    die;
                            
    }

	public function index_bk()
	{
		$offset =0;
		$limit = 10;
		if(isset($_GET['start'] ) ){
			$offset = $_GET['start'];
		}
		$like = 'Anuj';
		
		if($_GET['search']) {
			$like = $_GET['search'];
		}
		$result = $this->customer_model->get_customer_details_ajax($like,$offset,$limit);
		$data['title']="Customer Account Management";
		$data['heading']="Customer Account Management";
		$data['customers']= $result;
		//$this->template->load('customer', 'index', $data);
		$this->template->load('account', 'index_bk', $data);
	}
	public function index_ajax_data()
	{
		$offset =0;
		$limit = 10;
		if(isset($_GET['start'] ) ){
			$offset = $_GET['start'];
		}
		$like = 'Anuj';
		
		if($_GET['search']) {
			$like = $_GET['search'];
		}
		$mdata = $this->customer_model->get_customer_details_ajax($like,$offset,$limit);
		
		//echo count($result);
		$data["draw"] = 1;
		$data["recordsTotal"] = 60;
		$data["recordsFiltered"] = 70;
	
		$sr=1;
		//foreach($result as $record) {
		//	$status = "Inactive";
	
			//if($record->status == '1') { 
				//$status = "Active";
			// }
			//$view ='<a target="_blank" href="'.site_url().'/account/account_details/'.$result->id.'">View</a>';
			/*$data["data"][] = array($sr,$sr);
			$sr++;
			$mydata[] = array($sr,$record->companyname,$record->name,
										$record-total_debit,$record->total_credit,
										round($record->total_credit - $record->total_debit,0),
										$record->mobile,
										$record->emailid,
										$record->city,$status,
										'view'		);
										*/
		for($i=0; $i < 3;$i++) {
			$show_id = $mdata[$i]['id'];
			$data['data'][] = array('1', (int)$show_id,'1','1','1','1','1','1','1','1','1');								
			$sr++;
		}
		
		//echo "<pre>";
		//print_r($mydata);
		
		echo json_encode($data);
	
		//$data['title']="Customer Account Management";
		//$data['heading']="Customer Account Management";
		//$data['customers']= $result;
		//$this->template->load('customer', 'index', $data);
		//$this->template->load('account', 'index_bk', $data);
	}

	
	public function quick()
	{
		$like = null;
		$offset= 0;
		$limit = 10;
		$result = $this->customer_model->get_customer_details_quick($like,$offset,$limit);
		$data['title']="Customer Account Management";
		$data['heading']="Customer Account Management";
		$data['customers']= $result;
		$data['offset'] = 0;
		//$this->template->load('customer', 'index', $data);
		$this->template->load('account', 'index_quick', $data);
	}
	
	public function quick_ajax()
	{
		$like = null;
		$offset= 0;
		$limit = 10;
		if($this->input->post()) {
			$like = null;
			if($this->input->post('search_box')) {
				$like  = $this->input->post('search_box');
			}
			$offset = $this->input->post('offset');
			if($offset > 0 ) {
				$offset = $offset * $limit;
			}
			$sort_by = $this->input->post('sort_by');
			$sort_value = $this->input->post('sort_value');
			$limit = $this->input->post('limit');
			$result = $this->customer_model->get_customer_details_quick($like,$offset,$limit,$sort_by,$sort_value);
			$data['customers']= $result;
			$data['offset']= $this->input->post('offset');
		}
		$ajax_result = $this->load->view('account/ajax_quick', $data);
		return $ajax_result;
	}
	public function quick_ajax_balance()
	{
		$like = null;
		$offset= 0;
		$limit = 10;
		if($this->input->post()) {
			$like = null;
			if($this->input->post('search_box')) {
				$like  = $this->input->post('search_box');
			}
			$offset = $this->input->post('offset');
			if($offset > 0 ) {
				$offset = $offset * $limit;
			}
			$sort_by = $this->input->post('sort_by');
			$sort_value = $this->input->post('sort_value');
			$limit = $this->input->post('limit');
			$result = $this->customer_model->get_customer_details_quick_balance($like,$offset,$limit,$sort_by,$sort_value);
			$data['customers']= $result;
			$data['offset']= $offset;
		}
		$ajax_result = $this->load->view('account/ajax_quick_balance', $data);
		return $ajax_result;
	}
	
	public function quick_ajax_clear()
	{
		$like= null;
		$offset= 0;
		$limit = 10;
		$result = $this->customer_model->get_customer_details_quick($like,$offset,$limit);
			$data['customers']= $result;
		$ajax_result = $this->load->view('account/ajax_quick', $data);
		return $ajax_result;
	}
	
	public function account_details($user_id) {
		$data['heading'] = $data['title']="Customer Account";
		
		$data['customer'] = $this->customer_model->get_customer_details('id',$user_id);
		$data['results'] = $this->account_model->get_account_details($user_id);
		$this->template->load('account', 'account', $data);
	}
         
    public function add_amount($customer_id=null) {
		$data['heading'] =$data['title']="Add Amount";
		
		if($this->input->post()) {
			$save_data = $this->input->post();
			unset($save_data['save']);
			
			$status = $this->account_model->credit_amount($save_data['customer_id'],$save_data);
			redirect('account/account_details/'.$save_data['customer_id'],'refresh');
		}
		$data['customer_id'] = $customer_id;
		$data['customer'] = $this->customer_model->get_customer_details('id',$customer_id);
		$this->template->load('account', 'add', $data);
	}     
}
