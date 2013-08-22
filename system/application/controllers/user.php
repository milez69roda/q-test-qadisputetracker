<?php

class User extends Controller {

	function User()
	{
		parent::Controller();
		
		$this->load->library('Form_validation');
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('DX_Auth');
		
		ini_set('memory_limit', '128M');
	}
	
	function index()
	{
		$this->login();
	}
	
	function login(){
		
		if ( ! $this->dx_auth->is_logged_in()){
			$val = $this->form_validation;
			// Set form validation rules
			$val->set_rules('user_name', 'Username', 'trim|required|xss_clean');
			$val->set_rules('user_password', 'Password', 'trim|required|xss_clean');
			$val->set_error_delimiters('<p class="error">', '</p>');
			
			$data['error'] = '';
			
			if ($val->run() AND $this->dx_auth->login($val->set_value('user_name'), $val->set_value('user_password'), $val->set_value('remember'))){
				// Redirect to homepage
				redirect('', 'location');
			}else{
                 //if ($this->dx_auth->is_max_login_attempts_exceeded()){  
                       //$data["error"] = "<p>Username or Password is Incorrect!</p>";
                 //} 				
				
			}
			$this->load->view('main/header');
			$this->load->view('userslogin');
			$this->load->view('main/footer');
		}else{
			//echo '<script type="text/javascript">alert(\'You are already logged in.\')</script>';
			redirect('client/home','location');
			//$data['auth_message'] = 'You are already logged in.';
			//$this->load->view($this->dx_auth->logged_in_view, $data);
		}
	}
	
	function logout(){
		$this->dx_auth->logout();
		$data['auth_message'] = 'You have been logged out.';		
		//$this->load->view($this->dx_auth->logout_view, $data);
		redirect('user/login','refresh');
	}
}

/* End of file User.php */
/* Location: ./system/application/controllers/user.php */