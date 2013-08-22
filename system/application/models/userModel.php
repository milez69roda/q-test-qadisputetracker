<?php
	class UserModel extends Model{			
		
		function __construct(){
			parent::Model();
		}
		
		function getUser( $user_name ){
			
			$this->db->from('users');
			$this->db->join('centers', 'centers.center_id = users.center_id', 'left');
			$this->db->join('accesstypes', 'accesstypes.access_id = users.access_id', 'left');
			$this->db->where('user_name', $user_name);
			$query = $this->db->get();
			return $query->result();			
			
		}
		
		function getUser_Dropdown( $where = array() ){
			
			if( !empty($where) )
				$this->db->where($where);
			
			$query = $this->db->get('users');
			
			$temp=array();
			$temp[''] = 'All'; 
			foreach ($query->result() as $row)
			{
				$temp[$row->user_name]= $row->user_firstname.' '.$row->user_lastname;
			}
			
			return $temp;
		}		
		
		function updateUser( $set = array(), $where = array() ){
			$this->db->where($where);
			$this->db->update('users', $set); 			
		}
		
		function getUser_by_id($id){
			$this->db->where('user_name', $id);
			return $this->db->get('users');
		}

		function listUser($offset = 0, $row_count = 0,$cri = ''){
			if($offset >= 0 AND $row_count > 0){
				$query = $this->db->query("SELECT * FROM users u LEFT JOIN centers c ON c.center_id=u.center_id LEFT JOIN accesstypes ac ON ac.access_id=u.access_id WHERE user_status != 10 $cri LIMIT $offset,$row_count");
				//echo "SELECT * FROM users u LEFT JOIN centers c ON c.center_id=u.center_id LEFT JOIN accesstypes ac ON ac.access_id=u.access_id WHERE user_status =0 $cri LIMIT $offset,$row_count";
			}else{
				$query = $this->db->query("SELECT * FROM users u LEFT JOIN centers c ON c.center_id=u.center_id LEFT JOIN accesstypes ac ON ac.access_id=u.access_id WHERE user_status != 10 $cri");
				//echo "SELECT * FROM users u LEFT JOIN centers c ON c.center_id=u.center_id LEFT JOIN accesstypes ac ON ac.access_id=u.access_id WHERE user_status =0 $cri";
			}
			return $query;
		}

		function gethosting($offset = 0, $row_count = 0,$cri = ''){
		
			//trap if you want to get the total or the results
			if($offset >= 0 AND $row_count > 0){			
				$query=$this->db->query("SELECT * FROM tbl_client a,tbl_domain b,tbl_hostingplans c WHERE a.client_hplan=c.hosting_id AND a.client_domaintype=b.domain_id $cri LIMIT $offset,$row_count");			
			}else{
				$query = $this->db->query("SELECT * FROM tbl_client a,tbl_domain b,tbl_hostingplans c WHERE a.client_hplan=c.hosting_id AND a.client_domaintype=b.domain_id $cri");
			}
			
			return $query;
		}

		function getCri($sType,$keyword){
			$cri="";
			switch($sType){
				case "user_name":
					$cri="AND u.user_name like '%$keyword%'";
					break;
				case "user_avaya":
					$cri="AND u.user_avaya = '$keyword'";
					break;
				case "user_qarno":
					$cri="AND u.user_qarno = '$keyword'";
					break;
				case "user_firstname":
					$cri="AND u.user_firstname like '%$keyword%'";
					break;
				case "user_lastname":
					$cri="AND u.user_lastname like '%$keyword%'";
					break;
				case "user_email":
					$cri="AND u.user_email like '%$keyword%'";
					break;
				case "user_ext":
					$cri="AND u.user_ext = '$keyword'";
					break;
				case "center_id":
					$cri="AND c.center_desc like '%$keyword%'";
					break;
			}
			return $cri;
		}

		function pgConf($baseurl,$uriseg,$numlink,$toNum,$rowCnt){
			$p_config['base_url'] = $baseurl;
			$p_config['uri_segment'] = $uriseg;
			$p_config['num_links'] = $numlink;
			$p_config['total_rows'] =$toNum;
			$p_config['per_page'] = $rowCnt;
			
			$p_config['next_link'] = '&nbsp;next';
			$p_config['next_tag_open'] = '<span class="next">';
			$p_config['next_tag_close'] = '</span>';
				
			$p_config['prev_link'] = 'prev&nbsp;';
			$p_config['prev_tag_open'] = '<span class="prev">';
			$p_config['prev_tag_close'] = '</span>';
			
			$p_config['first_link'] = 'First';
			$p_config['first_tag_open'] = '<span class="first">';
			$p_config['first_tag_close'] = '</span>';
			
			$p_config['last_link'] = 'Last';
			$p_config['last_tag_open'] = '<span class="last">';
			$p_config['last_tag_close'] = '</span>';
			
			$p_config['full_tag_open'] = '<div class="pagination">';
			$p_config['full_tag_close'] = '</div>';
			return $p_config;
		}
		
		function getCenter2(){
		
			$query = $this->db->get('centers');
			$dumar=array();
			
			foreach ($query->result() as $row)
			{
				$dumar[$row->center_id]=$row->center_desc;
			}
			
			return $dumar;
		}
		
		function getAccess(){
			$query = $this->db->get('accesstypes');
			$dumar=array();
			foreach ($query->result() as $row)
			{
				$dumar[$row->access_id]=$row->access_name;
			}
			
			return $dumar;
		}
		
		function checkuser($str){
			 $this->db->where('user_name',$str);
			 $query=$this->db->get('users');
			 return $query->num_rows();
		}
		
		function checkemail($str){
			$this->db->where('user_email',$str);
			$query=$this->db->get('users');
			return $query->num_rows();
		}

	}
?>