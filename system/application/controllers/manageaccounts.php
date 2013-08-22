<?php

class Manageaccounts extends Controller {

	function Manageaccounts()
	{
		parent::Controller();
		
		$this->load->library('Form_validation');
		$this->load->library('Pagination');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('DX_Auth');
		$this->load->library('validation');
		$this->load->model('userModel', 'users');
		parse_str($_SERVER['REQUEST_URI'],$_GET);
		
		ini_set('memory_limit', '128M');
	}
	
	function index()
	{
		$this->accountlist();
	}
	
	function testpage(){
		
		$rules['username']	= "callback_username_check";
		$rules['password']	= "required";
		$rules['passconf']	= "required";
		$rules['email']		= "required";
		
		$this->validation->set_rules($rules);
		if ($this->validation->run() == FALSE)
		{
			echo 
			$this->load->view('main/header');
			$this->load->view('test/testpage');
			$this->load->view('main/footer');
		}
		else
		{
			$this->load->view('test/formsuccess');
		}
		
	}
	
	function username_check($str){
		if ($this->users->checkuser($str)==1){
			$this->validation->set_message('username_check', 'The username "'.$str.'" already exist pls. choose another');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function email_check($str){
		if ($this->users->checkemail($str)==1){
			$this->validation->set_message('email_check', 'The email "'.$str.'" already exist pls. choose another');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function _set_rules($upd){
		$rules['txtusername'] = "trim|required|xss_clean|min_length[5]|alpha_dash".($upd!=true?"|callback_username_check":'');
		$rules['txtpassword'] = "trim|required|xss_clean";
		$rules['txtavaya'] = "required|numeric|xss_clean|min_length[5]";
		$rules['txtqar'] = "required|xss_clean";
		$rules['txtfirstname'] = "required|xss_clean";
		$rules['txtlastname'] = "required|xss_clean";
		$rules['txtemail'] = "trim|required|xss_clean|valid_email".($upd!=true?"|callback_email_check":'');
		$rules['txtext'] = "required|numeric|xss_clean|min_length[5]";
		
		$this->validation->set_rules($rules);
	}
	
	function _set_fields($opt){
		
		$fields['txtusername']	= 'Username';
		$fields['txtpassword']	= 'Password';
		$fields['txtavaya']	= 'Avaya Login';
		$fields['txtqar']	= 'QAR #';
		$fields['txtfirstname']	= 'First Name';
		$fields['txtlastname']	= 'Last Name';
		$fields['txtemail']	= 'Email';
		$fields['txtext']	= 'Contact Ext.';

		$this->validation->set_fields($fields);

	}
	
	
	function edituser($id){
		if(!$this->dx_auth->is_logged_in()){
			redirect('user/login','refresh');
		}else{
			$auser=$this->users->getUser_by_id($id)->row();
			$this->_set_fields('');
			$this->_set_rules('username');
			
			$data['title'] = 'Update Account';
			$data['action'] = 'manageaccounts/updateAccount';
			
			$this->validation->txtusername = $auser->user_name;
			$this->validation->txtpassword = $auser->user_password;
			$this->validation->txtavaya = $auser->user_avaya;
			$this->validation->txtqar = $auser->user_qarno;
			$this->validation->txtfirstname = $auser->user_firstname;
			$this->validation->txtlastname = $auser->user_lastname;
			$this->validation->txtemail = $auser->user_email;
			$this->validation->txtext = $auser->user_ext;
			$this->validation->dpAccess = $auser->access_id;
			
			$data['selcenter']=$this->users->getCenter2();
			$data['selaccess']=$this->users->getAccess();

			$data['dpcenters']=$auser->center_id;
			$data['dpaccess']=$auser->access_id;
			
			$this->load->view('main/header');
			$this->load->view('main/manageaccount/submenu');
			$this->load->view('manageaccount/createuser',$data);
			$this->load->view('main/footer');
		}
	}
	
	function updateAccount(){
		if(!$this->dx_auth->is_logged_in()){
			redirect('user/login','refresh');
		}else{
			$data['title'] = 'Update Account';
			$data['action'] = 'manageaccounts/updateAccount';
			$data['selcenter']=$this->users->getCenter2();
			$data['selaccess']=$this->users->getAccess();
			$this->_set_fields('');
			$this->_set_rules(true);
			$data['title'] = 'Update Account';
			$data['action'] = 'manageaccounts/updateAccount';
			if ($this->validation->run() == FALSE){
				$this->load->view('main/header');
				$this->load->view('main/manageaccount/submenu');
				$this->load->view('manageaccount/createuser',$data);
				$this->load->view('main/footer');
			}else{
				$update_user=array(
					'access_id' => $this->input->post('dpAccess'),
					'user_password' => $this->input->post('txtpassword'),
					'user_avaya' => $this->input->post('txtavaya'),
					'user_qarno' => $this->input->post('txtqar'),
					'user_firstname' => $this->input->post('txtfirstname'),
					'user_lastname' => $this->input->post('txtlastname'),
					'user_email' => $this->input->post('txtemail'),
					'user_ext' => $this->input->post('txtext'),
					'center_id' => $this->input->post('dpcenters')
				);
				
				$where = "user_name = '".$this->input->post('txtusername')."'";
				$str = $this->db->update_string('users', $update_user, $where);
				$this->db->query($str);
				$this->load->view('main/header');
				$this->load->view('main/manageaccount/submenu');
				$this->load->view('manageaccount/success');
				$this->load->view('main/footer');
			}
		}
	}
	function createuser(){
		if(!$this->dx_auth->is_logged_in()){
			redirect('user/login','refresh');
		}else{
			$this->_set_rules('');
			$this->_set_fields('');
			$data['title'] = 'Create Account';
			$data['action'] = 'manageaccounts/createuser';
			if ($this->validation->run() == FALSE){
				$data['selcenter']=$this->users->getCenter2();
				$data['selaccess']=$this->users->getAccess();
				$this->load->view('main/header');
				$this->load->view('main/manageaccount/submenu');
				$this->load->view('manageaccount/createuser',$data);
				$this->load->view('main/footer');
			}else{
				$new_user=array(
					'access_id' => $this->input->post('dpAccess'),
					'user_name' => $this->input->post('txtusername'),
					'user_password' => $this->input->post('txtpassword'),
					'user_avaya' => $this->input->post('txtavaya'),
					'user_qarno' => $this->input->post('txtqar'),
					'user_firstname' => $this->input->post('txtfirstname'),
					'user_lastname' => $this->input->post('txtlastname'),
					'user_email' => $this->input->post('txtemail'),
					'user_ext' => $this->input->post('txtext'),
					'center_id' => $this->input->post('dpcenters')
				);
				 
				$this->db->query($this->db->insert_string('users', $new_user));
				$this->load->view('main/header');
				$this->load->view('main/manageaccount/submenu');
				$this->load->view('manageaccount/success');
				$this->load->view('main/footer');
			}
		}
	}
	
	function accountsearch(){
		if(!$this->dx_auth->is_logged_in()){
			redirect('user/login','refresh');
		}else{
			//get parameters
			$getof = (!empty($_GET['per_page'])?$_GET['per_page']:0);
			$sType = (!empty($_GET['typsel'])?$_GET['typsel']:'');
			$keyword = (!empty($_GET['keyword'])?$_GET['keyword']:'');
			$data['keyword']=$keyword;
			$offset = (int) $getof;
			
			$cri=$this->users->getCri($sType,$keyword); //generate criterea
			
			$row_count = 5;
			$dresult=$this->users->listUser($offset,$row_count,$cri);
			$data['accountlist']=$dresult->result();
			$data['total']=$this->users->listUser($offset,0,$cri)->num_rows();
			
			//pagination
			$numlink=5;
			$toNum=$data['total'];
			$uriseg=3;
			$this->pagination->initialize($this->users->pgConf('manageaccounts/accountsearch/?fsub=true&keyword='.$keyword.'&typsel='.$sType,$uriseg,$numlink,$toNum,$row_count));
			
			//create links
			$data['pages'] = $this->pagination->create_links();	
			
			//Load Views
			$this->load->view('main/header');
			$this->load->view('main/manageaccount/submenu');
			$this->load->view('manageaccount/accountlist',$data);
			$this->load->view('main/footer');
		}
	}
	
	function accountlist(){
		if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{
			
			$getof = (!empty($_GET['per_page'])?$_GET['per_page']:0); //Get offset
			$offset = (int) $getof;
			
			$row_count = 50;
			
			$data['accountlist']=$this->users->listUser($offset,$row_count)->result(); //Generate Results
			$data['total']=$this->users->listUser()->num_rows();//get total rows
			
			//pagination
			$numlink=5;
			$toNum=$this->users->listUser()->num_rows();
			$uriseg=3;
			
			//iniitalize pagination
			$this->pagination->initialize($this->users->pgConf('manageaccounts/accountlist/?dumm=true',3,$numlink,$toNum,$row_count));
			
			//create links
			$data['pages'] = $this->pagination->create_links();	
			
			
			$this->load->view('main/header');
			$this->load->view('main/manageaccount/submenu');
			$this->load->view('manageaccount/accountlist',$data);
			$this->load->view('main/footer');
		}
	}
	
	function myaccount(){
		
		if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{		
			
			
			if( $this->input->post('btnsub') == "Save" ){
				
				$pass["user_password"] = $this->input->post("txtpassword");
				
				$this->users->updateUser($pass, array('user_name'=>$this->session->userdata('DX_username') ));
			}
			$data["userInfo"] = $this->users->getUser( $this->session->userdata('DX_username') );
			$this->load->view('main/header');
			$this->load->view('manageaccount/changepassword', $data);
			$this->load->view('main/footer');
			
		}		
	}
	
	function logout(){
		$this->dx_auth->logout();
		$data['auth_message'] = 'You have been logged out.';		
		//$this->load->view($this->dx_auth->logout_view, $data);
		redirect('user/login','refresh');
	}
}

/* End of file manageaccounts.php */
/* Location: ./system/application/controllers/manageaccounts.php */