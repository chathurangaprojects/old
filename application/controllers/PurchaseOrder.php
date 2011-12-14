<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PurchaseOrder extends CI_Controller {

    var $make_po = 4;
 
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
	
	
	
	
	
	
	function addItemsToPurchaseOrder(){
	
		
	if($this->session->userdata('logged_in'))
            {
                if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), $this->make_po))
                {
                        
                    $PO_No = $_POST['pono'];
                    $Item_Code = $this->__last_word(trim($_POST['ic']));
                    $Unit = $_POST['u'];
                    $Unit_Price = $_POST['up'];
                    $Quantity = $_POST['q'];
                    
                    if(empty($_POST['d']))
                    {
                        $Discount = '0';
                    }
                    else
                    {
                        $Discount = $_POST['da'];
                    }
                    
                    if(empty($_POST['da']))
                    {
                        $Discount_Amount = '0';
                    }
                    else
                    {
                        $Discount_Amount = $_POST['da'];
                    }
                    
                    $Item_Value = $_POST['iv'];
                    
                    if(empty($_POST['it']))
                    {
                        $Ind_Tax = '0';
                    }
                    else
                    {
                        $Ind_Tax = $_POST['it'];
                    }
                    
                    if(empty($_POST['tv']))
                    {
                        $Tax_Value = '0';
                    }
                    else
                    {
                        $Tax_Value = $_POST['tv'];
                    }
                    
                    $Description = $_POST['desc'];
                    
                    $this->load->model('po/Create_po_model');
                
                    echo $this->Create_po_model->add_items_to_po($PO_No, $Item_Code, $Unit, $Unit_Price, $Quantity, $Discount, $Discount_Amount, $Item_Value, $Ind_Tax, $Tax_Value, $Description);
                }
                else
                {
                  
					
											$this->template->setTitles('Access Denied', 'You are not allowed to access this page.', 'You are not allowed to access this page.', 'Please Contact Administrator...');
			
			$this->template->load('template', 'errorPage');
					
					
                }
				
				
            }
            else
            {
                $this->load->view('login');
            }
	
	
	}
	

}


?>
