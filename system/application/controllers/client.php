<?php

class Client extends Controller {
	
	private $no_of_rows = 20;
	 
	function __construct()
	{
		parent::Controller();	
			
		$this->load->helper('html');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('my_form_validation');
		$this->load->library('DX_Auth');
		
		$this->load->model('userModel', 'users');
		$this->load->model('disputeModel', 'disputes');
		
		parse_str( $_SERVER["REQUEST_URI"] ,$_GET);//converts query string into global GET array variable
		
		ini_set('memory_limit', '-1');		
		//ini_set("memory_limit","100M");
	}
	
	function index(){
		redirect('client/home');
	}
	
	function home(){
		
		if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{
			$data['userInfo'] = $this->users->getUser( $this->session->userdata('DX_username') );
			
			$this->load->view('main/header');
			$this->load->view('home', $data );
			$this->load->view('main/footer');
		}	
	}
//1
//carecenter action
	function request(){
		
		if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{
			$data['userinfo'] = $this->users->getUser( $this->session->userdata('DX_username') );	

			//print_r($_FILES);
			if( $this->input->post('submit') == 'Save' ){						
				
				$this->form_validation->set_rules('evaldate', 'Evaluation Date', 'required|callback_evaldate_check');
				$this->form_validation->set_rules('auditcontno', 'Audit Contact Number', 'trim|required|callback_auditcontno_check');
				$this->form_validation->set_rules('agentname', 'Agent Name', 'trim|required');
				$this->form_validation->set_rules('login_id', 'Login ID', 'trim|required|numeric|exact_length[5]');
				//$this->form_validation->set_rules('pagenofilename', 'Page # File Name', 'required');
				$this->form_validation->set_rules('original_score', 'Original Score', 'numeric|required');
				
				// $this->form_validation->set_rules($file_field_name,"YOUR FILE","file_required|file_min_size[10KB]|file_max_size[500KB]|file_allowed_type[image]|file_image_mindim[50,50]|file_image_maxdim[400,300]"); 
				$this->form_validation->set_rules('evalform_attachment',"YOUR FILE", "file_required");
				
				$this->form_validation->set_rules('dispute_comment', 'Despute Request Comments', 'trim|required');
				$this->form_validation->set_rules('dp_selection[]', 'Section', 'required');
							
				//print_r($_POST['dp_selection']);
				if( $this->form_validation->run() ){
				
					$disputes["center_id"] 			= $this->session->userdata('DX_center_id');
					$disputes["disputer_id"] 		= $this->session->userdata('DX_username');
					
					$disputes["evaldate"] 			= strtotime( $this->input->post('evaldate') );	
					$disputes["auditcontno"]	 	= $this->input->post('auditcontno');
					$disputes["agentname"] 			= $this->input->post('agentname');
					$disputes["login_id"] 			= $this->input->post('login_id');
					//$disputes["pagenofilename"] 	= $this->input->post('pagenofilename');
					
					$disputes["original_score"] 	= $this->input->post('original_score');				
					$disputes["current_score"]  	= $this->input->post('original_score');
					
					$disputes["last_update"]    	= mktime( date('H'), date('i'), date('s'), date("m")  , date("d"), date("Y"));
									
					$disputes["dispute_comment"]	= $this->input->post('dispute_comment');				
					
					$disputes["dispute_type"] 		= 0;
					$disputes["dispute_type_status"]= 0;
					
					$disputes["dispute_process"] 	= 2;
					
					//$disputes["drpd_id"] 			= $this->input->post('dp_selection');					
					//$disputes["dispute_process_status"] = 0;					
				    $temp_drpd_id = '';
					foreach( $_POST['dp_selection'] as $value){
						$temp_drpd_id .= '"'.$value.'";';		
					}						
					$disputes["drpd_id"] 			= $temp_drpd_id;
					
					$tmp_path = '';
	    			list($usec, $sec) = explode(" ", microtime());
	    			$now = ((float)$usec + (float)$sec);					
					$folder = date('Y-m');
					$add_filename = number_format($now, 0, '.', '');
					//$folder = number_format($now, 0, '.', '');
	    			@mkdir('filemanager/'.$folder,0, false);	
	    							
					while(list($key,$value) = each($_FILES['fileX']['name'])){
						
						if(!empty($value)){   // this will check if any blank field is entered
							$filename = $add_filename.'_'.$value;    // filename stores the value
							
							$filename=str_replace(" ","_",$filename);// Add _ inplace of blank space in file name, you can remove this line
							

			    			
							$target_path = 'filemanager/'.$folder.'/'.$filename; 
							
							move_uploaded_file($_FILES['fileX']['tmp_name'][$key], $target_path);

							$tmp_path .= $target_path.';';
							//echo $filename.'<br />';
						}
					}					
					
					$disputes["evalform_attachment"]	= $tmp_path;
					if( $this->disputes->saveDispute( $disputes ) ){
						
						redirect('client/list1', 'refresh');
					}					
				}
					
			}
			if( $this->input->post('submit') == 'Cancel' ){
				redirect('client/list1', 'refresh');
			}
			
			$data['dp_selection'] = $this->disputes->getSelection(array('dp_cat'=>1, 'dp_status'=>0))->result();
			
			$this->load->view('main/header');
			$this->load->view('request', $data);
			$this->load->view('main/footer');
		}	
	}
	
	function evaldate_check($str){		
		
		$getEvaday = trim( date('D', strtotime($str) ));
		$getEvadate = date('Y-m-d', strtotime($str) );
		$getNowDay = trim( date('D') );
		
		$query = $this->db->query("select DATEDIFF( DATE_FORMAT(FROM_UNIXTIME('".strtotime($str)."'),'%Y-%m-%d'), DATE_FORMAT(NOW(),'%Y-%m-%d') ) AS isgreaterdays ")->row();
		
		$range1 = date('Y-m-d', strtotime("now"));
		$range2 = date('Y-m-d', strtotime("now"));
		
		switch( $getNowDay  ){
			
			case 'Fri':		
				$range1	= date('Y-m-d', strtotime("now"));
				$range2 = date('Y-m-d', strtotime("+3 day"));
				break;
			case 'Sat':
				$range1	= date('Y-m-d', strtotime("-1 day"));
				$range2 = date('Y-m-d', strtotime("+2 day"));				
				break;
			case 'Sun':
				$range1	= date('Y-m-d', strtotime("-2 day"));
				$range2 = date('Y-m-d', strtotime("+1 day"));				
				break;
			case 'Mon':
				$range1	= date('Y-m-d', strtotime("-3 day"));
				$range2 = date('Y-m-d', strtotime("now"));				
				break;												
		}
		
		
		if( $getEvaday == 'Fri' || $getEvaday == 'Sat' || $getEvaday == 'Sun' ){
			
			$query1 = $this->db->query("SELECT '{$getEvadate}' BETWEEN '{$range1}' AND '{$range2}' as checkdate ")->row();
			//echo ;
			if( $query1->checkdate == 0 ){
				
				$this->form_validation->set_message('evaldate_check', 'Evaluation is out of range');	
				return FALSE;
			/*}elseif(  ($getNowDay == 'Tue') ){
				
				$this->form_validation->set_message('evaldate_check', 'The cutoff is Tuesday');	
				return FALSE;*/				
			}else{
				return TRUE;
			}
			
			
		}else{
			
			if(  ($query->isgreaterdays <= 0 && $query->isgreaterdays >= -2 ) ){
				return TRUE;	
			}else{
				$this->form_validation->set_message('evaldate_check', 'Evaluation is out of range');
				return FALSE;	
			}
				
		}
		
		function section_check($str){
			
			if( $str == '0'){
				$this->form_validation->set_message('evaldate_check', 'Section is required');
				return FALSE;
			}else{
				return TRUE;
			}
			
			
		}	
		
	
		/*if( $getday == 'Fri' || $getday == 'Sat' || $getday == 'Sun'  ){
			
			$query = $this->db->query("select DATEDIFF( FROM_UNIXTIME('".strtotime($str)."'), NOW() ) AS isgreaterdays ")->row();
			$getNowDay = trim( date('D') );
			
			if( $getNowDay == 'Tue' && ($query->isgreaterdays < 0 && $query->isgreaterdays >= -3 ) ) {
				RETURN TRUE;
			}	

			if( $getNowDay == 'Fri' || $getNowDay == 'Sat' || $getNowDay == 'Sun' || $getNowDay == 'Mon' ){
				if(  )
			}
			
			
			$this->form_validation->set_message('evaldate_check', 'Invalid Evaluation Date! The evaluation date that you have submitted falls on this days; Fridays, Saturdays and Sundays.The system will only allow centers to submit disputes that falls on this three days up to Monday only.');
		
			return FALSE;
		}else{			
			$query = $this->db->query("select DATEDIFF( FROM_UNIXTIME('".strtotime($str)."'), NOW() ) AS isgreaterdays ")->row();
			if ($query->isgreaterdays > 3){
				$this->form_validation->set_message('evaldate_check', 'Submitting of dispute only allowed less 3 days from the evaluation date');
				return FALSE;
			}elseif( $query->isgreaterdays < 0 ){
				$this->form_validation->set_message('evaldate_check', 'Evaluation is out of range');
				return FALSE;			
			}else{
				return TRUE;
			}			
			
		}*/
		
		/*$query = $this->db->query("select DATEDIFF( FROM_UNIXTIME('".strtotime($str)."'), NOW() ) AS isgreaterdays ")->row();
		if ($query->isgreaterdays > 3){
			$this->form_validation->set_message('evaldate_check', 'Submitting of dispute only allowed less 3 days from the evaluation date');
			return FALSE;
		}else{
			return TRUE;
		}*/
	}

	function auditcontno_check( $str ){
	
		$query = $this->db->query("SELECT COUNT(*) AS num FROM dispute WHERE  auditcontno = '".trim($str)."'")->row();
		
		//echo $this->db->last_query();
		
		if( $query->num > 0){
			$this->form_validation->set_message('auditcontno_check', 'Audit Contact Number is already Exist');
			return FALSE;
		}else{
			return TRUE;
		}	
	
	}	
	
//3	
	function redispute1(){

		if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{	
			//$dispute_id = $this->disputes->getDispute_by_registereddate($this->uri->segment(3));
			//$dispute_id = $dispute_id[0]->dispute_id;			
			$dispute_id = $this->uri->segment(3); 											
			
			$data['userinfo'] = $this->users->getUser($this->session->userdata('DX_username'));	
			$data['disputeInfo'] = $this->disputes->getDisputeInfo( $dispute_id );							
			
			if( ($this->session->userdata('DX_access_id') == 1 ) && 
				($data['disputeInfo'][0]->dispute_center_id != $this->session->userdata('DX_center_id')) ){
				redirect('client/list1');		
			}
			
			
			if( $this->input->post('submit') == 'Save' ){	
			
				$disputes["redispute1_text"] 	= $this->input->post("redispute1_text");
				$disputes["redispute1_date"]    = mktime( date('H'), date('i'), date('s'), date("m")  , date("d"), date("Y")); 
				$disputes["redispute1_userid"]  = $this->session->userdata('DX_username');
				$disputes["redispute1_status"]  = 1;
				
				$disputes["dispute_type"] 		= 1;
				$disputes["dispute_type_status"]= 0;
				
				$disputes["dispute_process"] 	= 4;

				if( $this->disputes->updateDispute($dispute_id, $disputes ) ){
				
					redirect('client/list1');
					
				}				
			}
	
			$this->load->view('main/header');
			$this->load->view('carecenterredispute1', $data);
			$this->load->view('main/footer');
		}		
		
		
	}	
//5	
	function redispute2(){

		if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{	
			//$dispute_id = $this->disputes->getDispute_by_registereddate($this->uri->segment(3));
			//$dispute_id = $dispute_id[0]->dispute_id;
			$dispute_id = $this->uri->segment(3); 							
		
			$data['userinfo'] = $this->users->getUser($this->session->userdata('DX_username'));	
			$data['disputeInfo'] = $this->disputes->getDisputeInfo( $dispute_id );							
			
			//keep from carecenter viewing other carecenter request
			if( ($this->session->userdata('DX_access_id') == 1 ) && 
				($data['disputeInfo'][0]->dispute_center_id != $this->session->userdata('DX_center_id')) ){
				redirect('client/list1');		
			}
						
			if( $this->input->post('submit') == 'Save' ){	
			
				$disputes["redispute2_text"] 	= $this->input->post("redispute2_text");
				$disputes["redispute2_date"]    = mktime( date('H'), date('i'), date('s'), date("m")  , date("d"), date("Y")); 
				$disputes["redispute2_userid"]  = $this->session->userdata('DX_username');
				$disputes["redispute2_status"]  = 1;
				
				$disputes["dispute_type"] 		= 2;
				$disputes["dispute_type_status"]= 0;
				
				$disputes["dispute_process"] 	= 6;

				if( $this->disputes->updateDispute($dispute_id, $disputes ) ){
				
					redirect('client/list1');
					
				}				
			}
	
			$this->load->view('main/header');
			$this->load->view('carecenterredispute2', $data);
			$this->load->view('main/footer');
		}		
		
		
	}	
	

	function  list1(){
		
		if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{
					
			$params 	= array();	
			$orderby 	= isset($_GET["orderby"])?'&orderby='.$_GET["orderby"]:'&orderby=desc';
			
			$condType['searchType'] 	= 1;
			$condType['isAlert']	   	= FALSE;	
			$condType['orderby']		= isset($_GET["orderby"])?$_GET["orderby"]:'desc';
						
			$per_page 	= 0;	
			$limit 		= $this->no_of_rows;	
			$total_rows = 0;
		
			
			if( isset($_GET["per_page"]) )
				$per_page	= $_GET["per_page"];
						
			if( isset($_GET["searchtxt"])  && ($_GET["searchtxt"] != ''))
				$params["auditcontno"] = '"'.$_GET["searchtxt"].'"';
			
			$params['dispute.center_id'] = $this->session->userdata('DX_center_id');
			
			$total_rows = count( $this->disputes->getDisputeList($params,"",$condType ) );

			/*if( isset($_GET["orderby"]) ){
				$orderby = $_GET["orderby"];
			}*/
			//echo $orderby;
			$data['disputeList'] = $this->disputes->getDisputeList( $params, array('limit'=>$limit,'offset'=>$per_page), $condType );	
			//echo $this->db->last_query();
			
			//pagination
			$searchtxt 			= ( isset($_GET["searchtxt"]) )?'&searchtxt='.$_GET["searchtxt"]:'' ;			
			$page_url 			= base_url().'client/list1/?flag=0'.$searchtxt;			
			$data["pagination"] = $this->disputes->dispute_pagination( $page_url, $total_rows, $limit );
			$data["page_url"]   = $page_url;
			
			$this->load->view('main/header');
			$this->load->view('list1', $data);
			$this->load->view('main/footer');
		}		
	}
	
	
	
	function list2(){
		
		if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{
			$params 				= array();	
			$condType['searchType'] 	= 2;
			$condType['isAlert']	   	= FALSE;	
			$condType['orderby']		= isset($_GET["orderby"])?$_GET["orderby"]:'desc';
			
			$per_page 	= 0;	
			$limit 		= $this->no_of_rows;		
			$total_rows = 0;	

			
			$txtfrom 	= ( isset($_GET["txtfrom"]) )?'&txtfrom='.$_GET["txtfrom"]:'';
			$txtto 		= ( isset($_GET["txtto"]) )?'&txtto='.$_GET["txtto"]:'';
			$status 	= ( isset($_GET["status"]) )?'&status='.$_GET["status"]:'';
			$type 		= ( isset($_GET["type"]) )?'&type='.$_GET["type"]:'';
			$center 	= ( isset($_GET["center"]) )?'&center='.$_GET["center"]:'';
			$alert 		= ( isset($_GET["alert"]) )?'&alert='.$_GET["alert"]:'';
			$textsearch = ( isset($_GET["searchtxt"]) )?'&searchtxt='.$_GET["searchtxt"]:'';
			
			if( isset($_GET["per_page"]) )
				$per_page	= $_GET["per_page"];			
			
			if( isset($_GET["txtfrom"]) &&  isset($_GET["txtto"]) && ($_GET["txtfrom"] != '') && ($_GET["txtto"] != '') ){
				$params["DATE_FORMAT( FROM_UNIXTIME(last_update),'%m/%d/%Y')  BETWEEN"] = '"'.date($_GET["txtfrom"]).'" AND "'.date($_GET["txtto"]).'"';
				$txtfrom = '&txtfrom='.$_GET["txtfrom"];
				$txtto = '&txtto='.$_GET["txtto"]; 
			}	
			
			if( isset($_GET["searchtxt"]) && ($_GET["searchtxt"] != '') )
				$params["auditcontno"] = '"'.$_GET["searchtxt"].'"';			
			
			if( isset($_GET["status"]) &&  ($_GET["status"] != -1)){
				$params["dispute_type_status"] = $_GET["status"];
				$status = '&status='.$_GET["status"];
			}	
			if( isset($_GET["type"]) &&  ($_GET["type"] != -1)){
				if( $_GET["type"] == 0 )
					$params["dispute_type"] = $_GET["type"];
				else
					$params["dispute_type != "] = 0;

				$type = '&type='.$_GET["type"];
			}
				
			if( isset($_GET["center"]) &&  ($_GET["center"] != 0) ){
				$params["dispute.center_id"] = $_GET["center"];
				$center = '&center='.$_GET["center"];
			}
			
			if(  isset($_GET["alert"]) &&  ($_GET["alert"] == 1) ){	

				//$params["dispute_type_status"]  = 0;
				//$params["dispute_type != "]  	= 2;
				//$orderby 						= isset($_GET["orderby"])?$_GET["orderby"]:1;
				$condType['isAlert'] 	= TRUE;
				//$condType['orderby'] 	= isset($_GET["orderby"])?$_GET["orderby"]:'';
				//$condType['searchType']  = 2;
			}
				
			$total_rows = count( $this->disputes->getDisputeList($params,"",$condType ) );				
							
			$data['disputeList'] = $this->disputes->getDisputeList( $params, array('limit'=>$limit,'offset'=>$per_page), $condType );	
			//echo $this->db->last_query();
			$data['centerList'] = $this->disputes->getCenterList();
			
			//pagination	
			//=-1&center=0&txtfrom=&searchtxt=&txtto=
			$page_url 			= base_url().'client/list2/?flag=0'.$alert.$status.$type.$txtfrom.$center.$textsearch.$txtto;			
			$data["pagination"] = $this->disputes->dispute_pagination( $page_url, $total_rows, $limit );			
			$data["page_url"]   = $page_url;
						
			$this->load->view('main/header');
			$this->load->view('list2', $data);
			$this->load->view('main/footer');
		}		
	}	


	function list3(){
		
		if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{
			$params 					= array();	
			//$orderby 	= isset($_GET["orderby"])?$_GET["orderby"]:0;
			$condType['searchType'] 	= 3;
			$condType['isAlert']	   	= FALSE;	
			$condType['orderby']		= isset($_GET["orderby"])?$_GET["orderby"]:'desc';
						
			$per_page 	= 0;	
			$limit 		= $this->no_of_rows;		
			$total_rows = 0;	

			
			$txtfrom 	= ( isset($_GET["txtfrom"]) )?'&txtfrom='.$_GET["txtfrom"]:'';
			$txtto 		= ( isset($_GET["txtto"]) )?'&txtto='.$_GET["txtto"]:'';
			$status 	= ( isset($_GET["status"]) )?'&status='.$_GET["status"]:'';
			$textsearch = ( isset($_GET["searchtxt"]) )?'&searchtxt='.$_GET["searchtxt"]:'';
			$center 	= ( isset($_GET["center"]) )?'&center='.$_GET["center"]:'';
			$alert 		= ( isset($_GET["alert"]) )?'&alert='.$_GET["alert"]:'';
			
			if( isset($_GET["per_page"]) )
				$per_page	= $_GET["per_page"];		
				
			if( isset($_GET["searchtxt"]) &&  ($_GET["searchtxt"] != '') )
				$params["auditcontno"] = "'".$_GET["searchtxt"]."'";						
			
			if( isset($_GET["txtfrom"]) &&  isset($_GET["txtto"]) && ($_GET["txtfrom"] != '') && ($_GET["txtto"] != '') ){
				$params["DATE_FORMAT( FROM_UNIXTIME(last_update),'%m/%d/%Y')  BETWEEN"] = '"'.date($_GET["txtfrom"]).'" AND "'.date($_GET["txtto"]).'"';
				$txtfrom = '&txtfrom='.$_GET["txtfrom"];
				$txtto = '&txtto='.$_GET["txtto"]; 
			}	
			
			if( isset($_GET["status"]) &&  ($_GET["status"] != -1)){
				//$params["dispute_type_status"] = $_GET["status"];
				$params["redispute21_status"] = $_GET["status"];
				$status = '&status='.$_GET["status"];
			}				
				
			if( isset($_GET["center"]) &&  ($_GET["center"] != 0) ){
				$params["dispute.center_id"] = $_GET["center"];
				$center = '&center='.$_GET["center"];
			}
			
			if(  isset($_GET["alert"]) &&  ($_GET["alert"] == 1) ){	

				//$orderby 						= isset($_GET["orderby"])?$_GET["orderby"]:2;
				$condType['isAlert'] 	= TRUE;
			}
			
			$params["dispute_type"]  	= 2;
				
			$total_rows = count( $this->disputes->getDisputeList($params,"",$condType ) );				
							
			$data['disputeList'] = $this->disputes->getDisputeList( $params, array("limit"=>$limit,"offset"=>$per_page), $condType );	
			//echo $this->db->last_query();
			$data['centerList'] = $this->disputes->getCenterList();
			
			//pagination	
			$page_url 			= base_url().'client/list3/?flag=0'.$alert.$status.$textsearch.$txtfrom.$center.$txtto;			
			$data["pagination"] = $this->disputes->dispute_pagination( $page_url, $total_rows, $limit );			
			$data["page_url"]   = $page_url;
						
			$this->load->view('main/header');
			$this->load->view('list3', $data);
			$this->load->view('main/footer');
		}		
	}	

	function list4(){
		
		if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{
		
			//ini_set('memory_limit', -1);	
			
			$params 	= array();	
			//$orderby 	= isset($_GET["orderby"])?$_GET["orderby"]:0;
			$condType['searchType'] 	= 4;
			$condType['isAlert']	   	= FALSE;	
			$condType['orderby']		= isset($_GET["orderby"])?$_GET["orderby"]:'desc';			
			
			$per_page 	= 0;	
			$limit 		= $this->no_of_rows;		
			$total_rows = 0;	

			
			$txtfrom 	= ( isset($_GET["txtfrom"]) )?'&txtfrom='.$_GET["txtfrom"]:'';
			$txtto 		= ( isset($_GET["txtto"]) )?'&txtto='.$_GET["txtto"]:'';
			$status 	= ( isset($_GET["status"]) )?'&status='.$_GET["status"]:'';
			$type 		= ( isset($_GET["type"]) )?'&type='.$_GET["type"]:'';
			$center 	= ( isset($_GET["center"]) )?'&center='.$_GET["center"]:'';
			$alert 		= ( isset($_GET["alert"]) )?'&alert='.$_GET["alert"]:'';
			$textsearch = ( isset($_GET["searchtxt"]) )?'&searchtxt='.$_GET["searchtxt"]:'';

			if( isset($_GET["searchtxt"]) &&  ($_GET["searchtxt"] != '') )
				$params["auditcontno"] = "'".$_GET["searchtxt"]."'";				
						
			if( isset($_GET["per_page"]) )
				$per_page	= $_GET["per_page"];			
			
			if( isset($_GET["txtfrom"]) &&  isset($_GET["txtto"]) && ($_GET["txtfrom"] != '') && ($_GET["txtto"] != '') ){
				$params["DATE_FORMAT( FROM_UNIXTIME(last_update),'%m/%d/%Y')  BETWEEN"] = '"'.date($_GET["txtfrom"]).'" AND "'.date($_GET["txtto"]).'"';
				$txtfrom = '&txtfrom='.$_GET["txtfrom"];
				$txtto = '&txtto='.$_GET["txtto"]; 
			}	
			
			if( isset($_GET["status"]) &&  ($_GET["status"] != -1)){
				$params["dispute_type_status"] = $_GET["status"];
				$status = '&status='.$_GET["status"];
			}				

			if( isset($_GET["type"]) &&  ($_GET["type"] != -1)){
				
				$params["dispute_type"] = $_GET["type"];
				
				/*if( $_GET["type"] == 0 )
					$params["dispute_type"] = $_GET["type"];
				else
					$params["dispute_type != "] = 0;*/

				$type = '&type='.$_GET["type"];
			}
							
			if( isset($_GET["center"]) &&  ($_GET["center"] != 0) ){
				$params["dispute.center_id"] = $_GET["center"];
				$center = '&center='.$_GET["center"];
			}
			
			if(  isset($_GET["alert"]) &&  ($_GET["alert"] == 1) ){	

				//$orderby 						= isset($_GET["orderby"])?$_GET["orderby"]:2;
				$condType['isAlert'] 	= TRUE;
			}						
				
			$total_rows = count( $this->disputes->getDisputeList($params,"",$condType ) );				
							
			$data['disputeList'] = $this->disputes->getDisputeList( $params, array('limit'=>$limit,'offset'=>$per_page), $condType );
			//echo $this->db->last_query();	
			$data['centerList'] = $this->disputes->getCenterList();
			
			//pagination	
			$page_url 			= base_url().'client/list4/?flag=0'.$alert.$status.$txtfrom.$center.$textsearch.$txtto;			
			$data["pagination"] = $this->disputes->dispute_pagination( $page_url, $total_rows, $limit );			
			$data["page_url"]   = $page_url;
						
			$this->load->view('main/header');
			$this->load->view('list4', $data);
			$this->load->view('main/footer');
		}		
	}
		
//2
//corporate action
	function response(){

		if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{	

			$dispute_id = $this->uri->segment(3); 										
		
			$data['userinfo'] = $this->users->getUser($this->session->userdata('DX_username'));				
			$data['disputeInfo'] = $this->disputes->getDisputeInfo( $dispute_id );	
				
			//keep from carecenter viewing other carecenter request
			if( ($this->session->userdata('DX_access_id') == 1 ) && 
				($data['disputeInfo'][0]->dispute_center_id != $this->session->userdata('DX_center_id')) ){
				redirect('client/list1');		
			}	

			//$this->form_validation->set_rules('cqarnew_score', 'New Score', 'required|numeric|is_natural_no_zero');
			
			if( $this->input->post('submit') == 'Save' ){
				
				//if( $this->form_validation->run()  ){
				
					if( $this->input->post('change_score') == 0 ){
						
						$disputes["cqarnew_score"]  	  = $this->input->post('cqarnew_score');
						$disputes["cqarnew_score_changed"]= 1;
						$disputes["score_changedcounter"] = $data['disputeInfo'][0]->score_changedcounter+1;
						$disputes["current_score"]  	  = $this->input->post('cqarnew_score');
						
					}else{
						$disputes["cqarnew_score"]  = $this->input->post('original_score');
					}
					
					
					$disputes["cqardispute_text"] 	  = $this->input->post('cqardispute_text');
					$disputes["cqardispute_date"] 	  = mktime( date('H'), date('i'), date('s'), date("m")  , date("d"), date("Y"));
					$disputes["cqardispute_userid"]   =	$this->session->userdata('DX_username');			
					$disputes["cqardispute_status"]   = 1;
					
					$disputes["dispute_type"]  	  	  = 0;		
					$disputes["dispute_type_status"]  = 1;	
												
					$disputes["dispute_process"]	  = 3;				
					
	    			
					if( isset($_FILES['form_attachment']) ){
					
						list($usec, $sec) = explode(" ", microtime());
		    			$now = ((float)$usec + (float)$sec);
		    	
						$target_path = 'filemanager/1/'.number_format($now, 0, '.', '').'_'.basename( $_FILES['form_attachment']['name'] ); 
		
						move_uploaded_file($_FILES['form_attachment']['tmp_name'], $target_path);
						
						$disputes["cqardispute_attachment"]	= $target_path;
					}
					
					if( $this->disputes->updateDispute($dispute_id, $disputes ) ){
						redirect('client/list2');
					}
				//}
			}					
	
			$this->load->view('main/header');
			$this->load->view('response', $data);
			$this->load->view('main/footer');
		}		
	}
	
//4	
	function redispute1response(){
		
		if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{	
			//$dispute_id = $this->disputes->getDispute_by_registereddate($this->uri->segment(3));
			//$dispute_id = $dispute_id[0]->dispute_id;
			$dispute_id = $this->uri->segment(3); 										
		
			$data['userinfo'] = $this->users->getUser($this->session->userdata('DX_username'));	
			$data['disputeInfo'] = $this->disputes->getDisputeInfo( $dispute_id );	
			
			//keep from carecenter viewing other carecenter request
			if( ($this->session->userdata('DX_access_id') == 1 ) && 
				($data['disputeInfo'][0]->dispute_center_id != $this->session->userdata('DX_center_id')) ){
				redirect('client/list1');		
			}
						
			if( $this->input->post('submit') == 'Save' ){

				if( $this->input->post('change_score') == 0 ){
					$disputes["cqarnew_score2"]  	  = $this->input->post('new_score');
					$disputes["cqarnew_score2_changed"]= 1;
					$disputes["current_score"] 		  = $this->input->post('new_score');					
					$disputes["score_changedcounter"] = $data['disputeInfo'][0]->score_changedcounter+1;	
				}else{
					$disputes["cqarnew_score2"]  = $this->input->post('original_score');
				}
												
				$disputes["cqarredispute1_text"]   	= addslashes( $this->input->post('cqarredispute1_text') );
				$disputes["cqarredispute1_date"]   	= mktime( date('H'), date('i'), date('s'), date("m")  , date("d"), date("Y"));
				$disputes["cqarredispute1_userid"] 	= $this->session->userdata('DX_username');
				$disputes["cqarredispute1_status"]  = 1;
				
				$disputes["dispute_type"] 			= 1;
				$disputes["dispute_type_status"] 	= 1;
				
				$disputes["dispute_process"] 		= 5;
				
				if( isset($_FILES['form_attachment']) ){
				
					list($usec, $sec) = explode(" ", microtime());
	    			$now = ((float)$usec + (float)$sec);
	    	
					$target_path = 'filemanager/2/'.number_format($now, 0, '.', '').'_'.basename( $_FILES['form_attachment']['name'] ); 
					move_uploaded_file($_FILES['form_attachment']['tmp_name'], $target_path);				
					$disputes["cqarredispute1_attachment"]	= $target_path;
					
				}
				
				if( $this->disputes->updateDispute($dispute_id, $disputes ) ){
					redirect('client/list2');
				}					
			}
						
			$this->load->view('main/header');
			$this->load->view('corporateredispute1', $data);
			$this->load->view('main/footer');
		}
	}

//6	
//cccm action	
	function redispute21response(){
			if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{	

			$dispute_id = $this->uri->segment(3); 										
		
			$data['userinfo'] = $this->users->getUser($this->session->userdata('DX_username'));	
			$data['disputeInfo'] = $this->disputes->getDisputeInfo( $dispute_id );	

			//keep from carecenter viewing other carecenter request
			if( ($this->session->userdata('DX_access_id') == 1 ) && 
				($data['disputeInfo'][0]->dispute_center_id != $this->session->userdata('DX_center_id')) ){
				redirect('client/list1');		
			}
						
			if( $this->input->post('submit') == 'Save' ){
								
				$disputes["redispute21_text"]   	= addslashes( $this->input->post('redispute21_text') );
				$disputes["redispute21_date"]   	= mktime( date('H'), date('i'), date('s'), date("m")  , date("d"), date("Y"));
				$disputes["redispute21_userid"] 	= $this->session->userdata('DX_username');
				$disputes["redispute21_status"]  	= 1;
				
				$disputes["dispute_type"] 			= 2;
				$disputes["dispute_type_status"] 	= 0;
				
				$disputes["dispute_process"] 		= 7;
								
				if( $this->disputes->updateDispute($dispute_id, $disputes ) ){
					redirect('client/list3');
				}					
			}
			
			//echo $this->db->last_query();
			
			$this->load->view('main/header');
			$this->load->view('cccmredispute2', $data);
			$this->load->view('main/footer');
		}		
	}

//7
//sr manager action	
	function redispute22response(){
			if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{	

			$dispute_id = $this->uri->segment(3); 										
		
			$data['userinfo'] = $this->users->getUser($this->session->userdata('DX_username'));	
			$data['disputeInfo'] = $this->disputes->getDisputeInfo( $dispute_id );	

			//keep from carecenter viewing other carecenter request
			if( ($this->session->userdata('DX_access_id') == 1 ) && 
				($data['disputeInfo'][0]->dispute_center_id != $this->session->userdata('DX_center_id')) ){
				redirect('client/list1');		
			}	
					
			if( $this->input->post('submit') == 'Save' ){

				if( $this->input->post('change_score') == 0 ){
					$disputes["snew_score3"]  	  		= $this->input->post('new_score');
					$disputes["snew_score3_changed"]	= 1;
					$disputes["current_score"] 		  	= $this->input->post('new_score');					
					$disputes["score_changedcounter"] 	= $data['disputeInfo'][0]->score_changedcounter+1;	
				}else{
					$disputes["snew_score3"]  = $this->input->post('original_score');
				}
								
				$disputes["redispute22_text"]   	= addslashes( $this->input->post('redispute22_text') );
				$disputes["redispute22_date"]   	= mktime( date('H'), date('i'), date('s'), date("m")  , date("d"), date("Y"));
				$disputes["redispute22_userid"] 	= $this->session->userdata('DX_username');
				$disputes["redispute22_status"]  	= 1;
				
				$disputes["dispute_type"] 			= 2;
				$disputes["dispute_type_status"] 	= 1;
				
				$disputes["dispute_process"] 		= 8;
								
				if( $this->disputes->updateDispute($dispute_id, $disputes ) ){
					redirect('client/list4');
				}					
			}
			
			//echo $this->db->last_query();
			
			$this->load->view('main/header');
			$this->load->view('srmanagerredispute2', $data);
			$this->load->view('main/footer');
		}		
	}	
	
	function report(){
		
		if(!$this->dx_auth->is_logged_in()){
				redirect('user/login','refresh');
		}else{

       		$isDisplay  = 0;
			
			$data['disputeListAll'] = array();
			$data['disputeList']  = array();
			$data['exportlink'] = '';
			
			$data['summary'] = array();
			
			$params 	= array();
			$params1 	= array();	
			$orderby 	= 0;
			
			$per_page 	= 0;	
			$limit 		= $this->no_of_rows;		
			$total_rows = 0;	

			
			$txtfrom 	= ( isset($_GET["txtfrom"]) )?'&txtfrom='.$_GET["txtfrom"]:'';
			$txtto 		= ( isset($_GET["txtto"]) )?'&txtto='.$_GET["txtto"]:'';
			$center 	= ( isset($_GET["center"]) )?'&center='.$_GET["center"]:'';
			$textsearch = ( isset($_GET["textsearch"]) )?'&textsearch='.$_GET["textsearch"]:'';
			$qarname 	= ( isset($_GET["qarname"]) )?'&qarname='.$_GET["qarname"]:'';
			$evaluatorid= ( isset($_GET["evaluatorid"]) )?'&evaluatorid='.$_GET["evaluatorid"]:'';
			$weeklyview = ( isset($_GET["weeklyview"]) )?'&weeklyview='.$_GET["weeklyview"]:'';
			$dp_selection = ( isset($_GET["dp_selection"]) )?'&dp_selection='.$_GET["dp_selection"]:'';
			
			if( isset($_GET["per_page"]) )
				$per_page	= $_GET["per_page"];			
			
			if( isset($_GET["txtfrom"]) &&  isset($_GET["txtto"]) && ($_GET["txtfrom"] != '') && ($_GET["txtto"] != '') ){
				$params["DATE_FORMAT( dispute_registeredate,'%m/%d/%Y')  BETWEEN "] = '"'.$_GET["txtfrom"].'" AND "'.$_GET["txtto"].'"';
				$txtfrom = '&txtfrom='.$_GET["txtfrom"];
				$txtto = '&txtto='.$_GET["txtto"];

				$isDisplay = 1;
			}	
						
			if( isset($_GET["center"]) &&  ($_GET["center"] != 0) ){
				$params["dispute.center_id"] = $_GET["center"];
				$center = '&center='.$_GET["center"];
				
				$isDisplay = 1;
			} 
			
			if( isset($_GET["qarname"]) &&  ($_GET["qarname"] != '') ){
				$params1["disputer_id"] = "'".$_GET["qarname"]."'";
				$params1["redispute1_userid"] = "'".$_GET["qarname"]."'";
				$isDisplay = 1;
			} 	
					
			if( isset($_GET["evaluatorid"]) &&  ($_GET["evaluatorid"] != '') ){
				$params1["cqardispute_userid"] = "'".$_GET["evaluatorid"]."'";
				$params1["cqarredispute1_userid"] = "'".$_GET["evaluatorid"]."'";
				
				$isDisplay = 1;
			} 
			
			if( isset($_GET["weeklyview"]) && is_numeric($_GET["weeklyview"]) ){
				$params[" WEEK(dispute_registeredate) "] = "'".$_GET["weeklyview"]."'";
				
				$isDisplay = 1;
			} 
									
			if( isset($_GET["textsearch"]) &&  ($_GET["textsearch"] != '') ){
				$params["auditcontno"] = "'".$_GET["textsearch"]."'";
				
				$isDisplay = 1;
				
			} 

			if( isset($_GET["dp_selection"]) &&  ($_GET["dp_selection"] != '') ){
				$params["drpd_id like "] = '\'%"'.$_GET["dp_selection"].'"%\'';
				
				$isDisplay = 1;
				
			} 
						
			if( $isDisplay == 1 ){
						
				$data['disputeListAll'] = $this->disputes->getDisputeList_report($params, $params1, "");	
				$total_rows = count( $data['disputeListAll'] );				
				$data['disputeList'] = $this->disputes->getDisputeList_report( $params, $params1, array('limit'=>$limit,'offset'=>$per_page));
				
				//echo $this->db->last_query();
				
                $totalDisputes = 0;
                $totalDisputes1 = 0;
                $totalDisputes2 = 0;                        
                $totalscorechanged = 0; 
                        	
                foreach( $data['disputeListAll'] as $row): 
						
                	$totalscorechanged = $totalscorechanged+ $row->scorechange;
						
	                switch( $row->dispute_type ){
						case 0:
							$totalDisputes++;
							break;
						case 1:
							$totalDisputes1++;
							break;
						case 2:
							$totalDisputes2++;
							break;		
					}
                        		
                        				
                endforeach;

                $summary['totalDisputes'] = $totalDisputes;
                $summary['totalDisputes1'] = $totalDisputes1;
                $summary['totalDisputes2'] = $totalDisputes2;
                $summary['totalscorechanged']=$totalscorechanged;
                
                $data['exportlink'] = $this->disputes->excelwriter_factory( $params, $params1, $summary );
                $data['summary'] = $summary;        						
			}

			//echo $this->db->last_query();
			$data['centerList'] = $this->disputes->getCenterList();
			$data['qarList'] = $this->users->getUser_Dropdown( array( 'access_id ='=>1) );
			$data['evaluatorList'] = $this->users->getUser_Dropdown( array( 'access_id ='=>2) );
			
			//pagination	
			//flag=0&alert=0&txtfrom=&center=0&textsearch=&txtto=
			$page_url 			= base_url().'client/report/?flag=0'.$txtfrom.$center.$textsearch.$txtto.$qarname.$evaluatorid.$weeklyview.$dp_selection;			
			$data["pagination"] = $this->disputes->dispute_pagination( $page_url, $total_rows, $limit );			
			$data["page_url"]   = $page_url;

			
			$data['dp_selection'] = $this->disputes->getSelection_dropdown(array('dp_cat'=>1, 'dp_status'=>0));
			//echo $this->db->last_query();
			
			$this->load->view('main/header');
			$this->load->view('report', $data);
			$this->load->view('main/footer');
		}		
	}
	
	function export(){
       $this->load->helper('download');
		
	   $xp 	 = explode('/',$_GET['xfilename']);
       $data = file_get_contents(base_url().$_GET['xfilename']);
       $name = $xp[2];		
       
       force_download($name, $data );	
       		
	}
	
	function download(){
		
       $this->load->helper('download');
		
	   $xp 	 = explode('/',$_GET['xfilename']);
       $data = @file_get_contents(base_url().$_GET['xfilename']);
       $name = @($xp[2] != '')?$xp[2]:$xp[1] ;	
       		
	   @force_download($name, $data );
		//echo $_GET['xfilename'];
		
	}
	
		
}

/* End of file Client.php */
/* Location: ./system/application/controllers/client.php */