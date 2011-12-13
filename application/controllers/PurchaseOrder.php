<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PurchaseOrder extends CI_Controller {

	function __construct()
	{
		parent::__construct();
			
        $this->load->model('po/Privilege_model');
		
	    //non authenticated users will be redirected to the login page without giving the access for this controller
		if(!$this->session->userdata('logged_in')){
		
		redirect(base_url().'index.php/Login/login');
		
	    }
			
    }
	
	
	
	public function index(){
		
		$this->placeOrder();
		
	}
	
	
	
	public function placeOrder(){
	
				//if the user is loged, then the priviledges should be checked. 
 if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), 1))
            {
				
              echo "user has the priviledges and po form should be displayed";
		
		      }
            else
            {
			
						$this->template->setTitles('Access Denied', 'You are not allowed to access this page.', 'You are not allowed to access this page.', 'Please Contact Administrator...');
			
			$this->template->load('template', 'errorPage');
				
				
            }
	
	
	}
	



}


?>

	
	