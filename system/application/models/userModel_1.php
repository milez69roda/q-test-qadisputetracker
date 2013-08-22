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
	}
?>