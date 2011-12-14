<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Login_model');

        $this->load->model('po/Privilege_model');
			
	}
	
	
	public function login(){
					 
	 	if($this->session->userdata('logged_in'))
		{
			//already logged users are redirected to the dashboard
			$this->template->setTitles('Page Title', 'Page Sub Title', 'Inner Page Title', 'Inner Page Sub Title');
			
			$this->template->load('template', 'dashboard');
		}
		else
		{
			$this->load->view('login');
		}
	
	}
	
	/*
	
	public function index()
	{
		
		if($this->session->userdata('logged_in'))
		{
			//if the user is loged, then the priviledges should be checked. 
 if($this->Privilege_model->grant_privilege($this->session->userdata('level'), $this->session->userdata('department'), 150))
            {
				
			//if the user is having priviledges, he should be redirected to the dashboard	
			$this->template->setTitles('Page Title', 'Page Sub Title', 'Inner Page Title', 'Inner Page Sub Title');
			
			$this->template->load('template', 'dashboard');
		
		            }
            else
            {
			
						$this->template->setTitles('Error Page Title', 'Error Page Sub Title', 'Inner Page Title', 'Inner Page Sub Title');
			
			$this->template->load('template', 'dashboard');
	
				
            }
			
		}//if logged
		else
		{
			redirect(base_url().'index.php/Login/login');
		}
		
	}
	



	public function loging_in(){
		
	 if($this->session->userdata('logged_in'))
        {

			// after successfully login, the user should be redirected the index page.
			$this->index();
			
        }
        else
        {

            if($this->Login_model->loging_in())
            {

                        
                $row = $this->Login_model->get_emp_data($_POST['login_username']);

                $emp_data = array
                (
                    'emp_id'  => $row['Employee_Code'],
                    'emp_name'  => $row['Employee_Name'],
                    'level'  => $row['Level_Code'],
                    'department'  => $row['Department_Code'],
                    'email'     => $row['Email'],
                    'logged_in' => TRUE
                );

                $this->session->set_userdata($emp_data);
                        echo 1;
            }
            else
            { 
			
               echo 2;
            }
        }
	
	
	}
	
	*/
	
	
	
	public function index()
	{
		
		if($this->session->userdata('logged_in'))
		{
				
			$this->template->setTitles('Page Title', 'Page Sub Title', 'Inner Page Title', 'Inner Page Sub Title');
			
			$this->template->load('template', 'dashboard');
		
			
		}//if logged
		else
		{
			redirect(base_url().'index.php/Login/login');
		}
		
	}
	



	public function loging_in(){
		
	 if($this->session->userdata('logged_in'))
        {

			// after successfully login, the user should be redirected the index page.
			$this->index();
			
        }
        else
        {

            if($this->Login_model->loging_in())
            {

                        
                $row = $this->Login_model->get_emp_data($_POST['login_username']);

                $emp_data = array
                (
                    'emp_id'  => $row['Employee_Code'],
                    'emp_name'  => $row['Employee_Name'],
                    'level'  => $row['Level_Code'],
                    'department'  => $row['Department_Code'],
                    'email'     => $row['Email'],
                    'logged_in' => TRUE
                );

                $this->session->set_userdata($emp_data);
                        echo 1;
            }
            else
            { 
			
               echo 2;
            }
        }
	}
	
	
	
	
	function log_out()
    {
        $emp_data = array
        (
            'emp_id'  => '',
            'emp_name'  => '',
            'level'  => '',
            'department'  => '',
            'email'     => '',
            'logged_in' => FALSE
        );

        $this->session->unset_userdata($emp_data);
	   
	   	redirect(base_url().'index.php/Login/login');

    }
	
	
	
	 function load_manage_employees(){
		 
		 		
	 if($this->session->userdata('logged_in'))
        {
      
      $this->load->library('pagination');  
      $offset='';
        
        
 $allemployees = $this->Login_model->get_allemployees();       

            $per_page = 15;
            $total = count($allemployees);
        
           $config['base_url'] = site_url()."/login/load_manage_employees/";
           $config['total_rows'] = $total;
           $config['per_page'] = $per_page;
           $config['first_link'] = 'First';
           $config['last_link'] = 'Last';
           $config['next_link'] = 'Next '.'&gt;';
           $config['prev_link'] = '&lt;'.' Previous';
                  
           $this->pagination->initialize($config);
           
            $allemployees = $this->Login_model->get_allemployeespaginated($per_page,$offset);   
    
  /*  
    $data = array('title' => 'Manage Employees', 'desc' => 'Manage Employees.', 'subtitle' => 'Manage Employees', 'msg' => 'Manage Employees' , 'pagetitle' => 'Manage Employees', 'allemployees' => $allemployees);     

    $this->load->view('ssi/header.php', $data);
    $this->load->view('ssi/navigation.php');
    $this->load->view('ssi/search.php');
    $this->load->view('ssi/sub_navigation.php', $data);
    $this->load->view('ssi/top_buttons.php');

    $this->load->view('ssi/contents/user_management/manage_employees.php');

    $this->load->view('ssi/sidebar.php');
    $this->load->view('ssi/footer.php');
	*/
	
	
    $data = array('title' => 'Manage Employees', 'desc' => 'Manage Employees.', 'subtitle' => 'Manage Employees', 'msg' => 'Manage Employees' , 'pagetitle' => 'Manage Employees', 'allemployees' => $allemployees);   
	
	$this->template->setTitles('Manage Employees', 'Manage Employees
', '', '');
			
			$this->template->load('template', 'po/manageUsers',$data);
				
				
		}
		else{
			
		redirect(base_url().'index.php/Login/login');	
			
		}
      
  }//load_manage_employees  
  
    
}






/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

?>
