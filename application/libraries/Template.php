<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
    class Template 
    {
        var $ci;
         
        function __construct() 
        {
            $this->ci =& get_instance();
            
        }
        
        function load($tpl_view, $body_view = null, $data = null) 
{
		if ( file_exists( APPPATH.'views/'.$tpl_view.'/'.$body_view ) ) 
        {
			$body_view_path = $tpl_view.'/'.$body_view;
        }
        else if ( file_exists( APPPATH.'views/'.$tpl_view.'/'.$body_view.'.php' ) ) 
        {
            $body_view_path = $tpl_view.'/'.$body_view.'.php';
        }
        else if ( file_exists( APPPATH.'views/'.$body_view ) ) 
        {
            $body_view_path = $body_view;
        }
        else if ( file_exists( APPPATH.'views/'.$body_view.'.php' ) ) 
        {
            $body_view_path = $body_view.'.php';
        }
        else
        {
            show_error('Unable to load the requested file: ' . $tpl_name.'/'.$view_name.'.php');
        }
         
         
        $body = $this->ci->load->view($body_view_path, $data, TRUE);
         
        if ( is_null($data) ) 
        {
            $data = array('body' => $body);
        }
        else if ( is_array($data) )
        {
            $data['body'] = $body;
        }
        else if ( is_object($data) )
        {
            $data->body = $body;
        }
        
		if($_SESSION['department'] == 'prints') {
            $this->ci->load->view('layout/default_print', $data);
        } else  if($_SESSION['department'] == 'cuttings') { 
			$this->ci->load->view('layout/default_cutting', $data);
        } else  if($_SESSION['department'] == 'Master') { 
			$this->ci->load->view('layout/default_master', $data);
        } else {
            $this->ci->load->view('layout/default', $data);
        }
        
}
    }
