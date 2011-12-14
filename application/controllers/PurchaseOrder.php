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
				
              //echo "user has the priviledges and po form should be displayed";
			  
			  
			  $this->load->model('po/Create_po_model');
                
                $res1 = $this->Create_po_model->load_departments();
                $data['depts'] = $res1;
                
                $res2 = $this->Create_po_model->load_employees();
                $data['emps'] = $res2;
                
                $res3 = $this->Create_po_model->load_pay_type();
                $data['pay_types'] = $res3;
                
                $res4 = $this->Create_po_model->load_currency();
                $data['currency'] = $res4;
                
                $res5 = $this->Create_po_model->load_units();
                $data['units'] = $res5;
			  
			    $data['title'] = "Create New Purchase Order";
				
				//load create purchase order request form
									$this->template->setTitles('Purchase Order Request Form', 'Create New Purchase Order
', '', '');
			
			$this->template->load('template', 'po/createPurchaseOrderRequest',$data);
				
						
		      }
            else
            {
			
						$this->template->setTitles('Access Denied', 'You are not allowed to access this page.', 'You are not allowed to access this page.', 'Please Contact Administrator...');
			
			$this->template->load('template', 'errorPage');
				
				
            }
	
	
	}
	
	
	
	
	
	
	public function loadSuppliersBasedOnType(){
		
		if($this->session->userdata('logged_in'))
            {
                $this->load->model('po/Create_po_model');
                
                $res = $this->Create_po_model->load_suppliers(strtolower($_GET["q"]));
                
                if(! empty($res))
                {
                    foreach ($res->result_array() as $row)
                    {
                        $sup = $row['Supplier_Name'] . ' - ' . $row['Supplier_Code'];
                        
                        echo "$sup\n";
                    }
                }
            }
            else
            {
                $this->load->view('login');
            }
		
	}//function
	


}


?>
