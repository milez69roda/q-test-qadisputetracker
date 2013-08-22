<?php
	require_once "Spreadsheet/Excel/Writer.php";
	class DisputeModel extends Model{
		
		function __construct(){
			parent::Model();
			ini_set('memory_limit', '-1');		
			//ini_set("memory_limit","100M");
		}
		
		function encrypt_dispute_id( $dispute_id ){
			$encryp_key = array('0'=>'243','1'=>'cee','1'=>'8f1','3'=>'cd8','4'=>'497','5'=>'9ca','6'=>'473','6'=>'28b','8'=>'bb9','9'=>'206');
			$str_len = strlen($dispute_id);			 
			$str_split = str_split($dispute_id, $str_len);
			
			//foreach()
			//return str_replace( $str_split,$encryp_key,$dispute_id);
		}
		
		function get_uri( $str ){
			
			return explode('&',  $str );
		}
		
		
		function dispute_pagination( $base_url, $total_rows, $per_page  ){
			
			$this->load->library('pagination');

			$config['base_url'] 	= $base_url;
			$config['total_rows'] 	= $total_rows;
			$config['per_page'] 	= $per_page;
			
			$this->pagination->initialize($config);
			
			return $this->pagination->create_links();	
			
		}
		
		function getDispute_by_registereddate( $registeredate ){
			
			$query = $this->db->query('SELECT * FROM (dispute) WHERE dispute_registeredate = FROM_UNIXTIME('.$registeredate.')');
			return $query->result();
		}
		
		
		function getCenterList(){
			
			$this->db->order_by('center_desc', 'asc');
			$query = $this->db->get('centers');
			return $query->result();
		}
		
		function saveDispute( $params = array() ){
			
			if( $this->db->insert('dispute', $params) ){
				return true;
			}else{
				return false;
			}
			 
		}
		
		function getDisputeList( $params = array(), $limit = array(), $condType = array() ){
			/*$this->db->select(" *, LPAD( dispute_id,7,'0' ) as DP_ID,
								   (CASE dispute_type 
									WHEN 1 then 'Re-Dispute #1' 
									WHEN 2 then 'Re-Dispute #2'
									ELSE 'Dispute'
								  END) AS 'xdispute_type',
								  DATE_FORMAT( dispute_registeredate,'%m/%d/%Y  %T') AS 'xdispute_registeredate',
								  DATE_FORMAT( FROM_UNIXTIME(last_update),'%m/%d/%Y %T') AS 'xlast_update',
								  DATE_FORMAT( FROM_UNIXTIME(last_update) + INTERVAL 48 HOUR,'%m/%d/%Y %T') AS 'estimate_dute_date',
								  DATE_FORMAT( FROM_UNIXTIME(last_update) + INTERVAL 24 HOUR,'%m/%d/%Y %T') AS 'estimate_due_date_one_day',
								  DATE_FORMAT( FROM_UNIXTIME(last_update) + INTERVAL 72 HOUR,'%m/%d/%Y %T') AS 'estimate_due_date_four_day',
								  TIMEDIFF( FROM_UNIXTIME(last_update) + INTERVAL 48 HOUR, CURRENT_TIMESTAMP) AS 'turnaroundtime',
								  TIMEDIFF( TIMEDIFF( FROM_UNIXTIME(last_update) + INTERVAL 48 HOUR, CURRENT_TIMESTAMP), '24:00:00') AS almost_past_due  ", FALSE);*/			
			//LPAD( dispute_id, 7, '0' ) AS DP_ID
			
			//ini_set("memory_limit","100M");
			
			/* $this->db->select(" *, LPAD( dispute_id, 7, '0' ) AS DP_ID, 
								(CASE dispute_type WHEN 1 THEN 'Re-Dispute #1' WHEN 2 THEN 'Re-Dispute #2' ELSE 'Dispute' END) AS 'xdispute_type', 
								DATE_FORMAT( dispute_registeredate, '%m/%d/%Y %T') AS 'xdispute_registeredate', 
								DATE_FORMAT( FROM_UNIXTIME(last_update), '%m/%d/%Y %T') AS 'xlast_update', 
								DATE_FORMAT( FROM_UNIXTIME(last_update) + INTERVAL 2 DAY, '%m/%d/%Y') AS 'estimate_dute_date', 
								DATE_FORMAT( FROM_UNIXTIME(last_update) + INTERVAL 1 DAY, '%m/%d/%Y') AS 'estimate_due_date_one_day', 
								DATE_FORMAT( FROM_UNIXTIME(last_update) + INTERVAL 3 DAY, '%m/%d/%Y') AS 'estimate_due_date_four_day', 
								DATEDIFF( FROM_UNIXTIME(last_update) + INTERVAL 2 DAY, CURRENT_TIMESTAMP) AS 'turnaroundtime',
								DATEDIFF( CURRENT_TIMESTAMP, FROM_UNIXTIME(last_update)) AS almost_past_due,
								DATEDIFF( CURRENT_TIMESTAMP, FROM_UNIXTIME(last_update) + INTERVAL 2 DAY) AS 'twodays',
								DATEDIFF( CURRENT_TIMESTAMP, FROM_UNIXTIME(last_update) + INTERVAL 3 DAY) AS 'threedays'", FALSE); */
								
			$this->db->select(" *, 
								(CASE dispute_type WHEN 1 THEN 'Re-Dispute #1' WHEN 2 THEN 'Re-Dispute #2' ELSE 'Dispute' END) AS 'xdispute_type', 
								DATEDIFF( FROM_UNIXTIME(last_update) + INTERVAL 2 DAY, CURRENT_TIMESTAMP) AS 'turnaroundtime',
								DATEDIFF( CURRENT_TIMESTAMP, FROM_UNIXTIME(last_update)) AS almost_past_due", FALSE);
			
			if( !empty($params) )
				$this->db->where( $params, NULL ,FALSE );
			
			if( !empty($limit) )
				$this->db->limit( $limit["limit"], $limit["offset"] );	


			/*if( $orderby == '0' ){
				$this->db->order_by("last_update", 'DESC');
			}elseif( $orderby == '1' ){	
				//$this->db->order_by("dispute_type_status", 'ASC');
				$this->db->order_by("almost_past_due", 'desc');				
			}elseif( trim($orderby)=='asc' || trim($orderby)=='desc' ){
				$this->db->order_by("dispute_id", $orderby);
			}else{	
				$this->db->order_by("dispute_type", 'DESC');
				$this->db->order_by("almost_past_due", 'ASC');	
			}*/
			//$type = $condType["searchType"];
			
			if( !empty($condType) ){
				
				switch( $condType["searchType"] ){
					case 1:
						$this->db->order_by("last_update", $condType['orderby']);
						break;
					case 2:
						
						if( $condType['isAlert'] ){
								
							$this->db->where( 'dispute_type_status',0  );	
							$this->db->where( '(dispute_type','0', FALSE  );
							$this->db->or_where( 'dispute_type','1)', FALSE);

							//$this->db->order_by("last_update", 'DESC');
							$this->db->order_by("almost_past_due", 'DESC');		
						}else{
							$this->db->order_by("last_update", $condType['orderby']);
						}
						
						break;
					case 3:
						if( $condType['isAlert'] ){
							$this->db->where( 'dispute_type_status',0 );
							$this->db->where( 'redispute21_status',0 );
							
							$this->db->order_by("almost_past_due", 'DESC');	
						}else{
							$this->db->order_by("last_update", $condType['orderby']);	
						}
						
						break;
					case 4:
						if( $condType['isAlert'] ){
							
							$this->db->where( 'dispute_type_status',0 );
							$this->db->where('dispute_type','2', FALSE);
							
							$this->db->order_by("almost_past_due", 'DESC');	
						}else{
							$this->db->order_by("last_update", $condType['orderby']);	
						}						
						break;		
				}
				
			}
	
			
			$this->db->join('centers', 'centers.center_id = dispute.center_id', 'left');
			$this->db->join('users', 'users.user_name = dispute.disputer_id', 'left');
			$this->db->join('dropdowns', 'dropdowns.drpd_id = dispute.drpd_id', 'left');
			
			$query = $this->db->get('dispute');
			return $query->result();
		}
		
		
		function getDisputeInfo_CorporateQAR( $dispute_id ){			
			
			/*$this->db->select('*,DATE_FORMAT(dispute_registeredate, %m/%d/%Y)');
			$this->db->from('dispute');
			$this->db->join('centers', 'centers.center_id = dispute.center_id', 'left');
			$this->db->join('users', 'users.user_name = dispute.disputer_id', 'left');
			$this->db->where($dispute);
			$query = $this->db->get();*/
			
			$query = $this->db->query("SELECT *,DATE_FORMAT(dispute_registeredate, '%m/%d/%Y') AS xdispute_registeredate,
												DATE_FORMAT( FROM_UNIXTIME(evaldate),'%m/%d/%Y') AS xevaldate,
												DATE_FORMAT( FROM_UNIXTIME(cqardispute_date),'%m/%d/%Y') AS xcqardispute_date	 
										FROM dispute d
										LEFT OUTER JOIN centers c ON c.center_id = d.center_id
										LEFT OUTER JOIN users u ON u.user_name = d.disputer_id
										WHERE dispute_id=".$dispute_id);
			
			return $query->result();					
		} 
		
		function getDisputeInfo( $dispute_id ){			
			
			/*$query = $this->db->query("SELECT *, d.center_id as dispute_center_id ,DATE_FORMAT(dispute_registeredate, '%m/%d/%Y') AS xdispute_registeredate,
												DATE_FORMAT( FROM_UNIXTIME(evaldate),'%m/%d/%Y') AS xevaldate,
												DATE_FORMAT( FROM_UNIXTIME(cqardispute_date),'%m/%d/%Y') AS xcqardispute_date,	 
												DATE_FORMAT( FROM_UNIXTIME(redispute1_date),'%m/%d/%Y') AS xredispute1_date,
												DATE_FORMAT( FROM_UNIXTIME(cqarredispute1_date),'%m/%d/%Y') AS xcqarredispute1_date,
												DATE_FORMAT( FROM_UNIXTIME(redispute2_date),'%m/%d/%Y') AS xredispute2_date,
												DATE_FORMAT( FROM_UNIXTIME(redispute21_date),'%m/%d/%Y') AS xredispute21_date,
												DATE_FORMAT( FROM_UNIXTIME(redispute22_date),'%m/%d/%Y') AS xredispute22_date,
												DATE_FORMAT( FROM_UNIXTIME(last_update) + INTERVAL 1 DAY,'%m/%d/%Y') AS 'estimate_due_date_one_day',
												DATE_FORMAT( FROM_UNIXTIME(last_update) + INTERVAL 2 DAY,'%m/%d/%Y') AS 'estimate_due_date_two_days',
												DATE_FORMAT( FROM_UNIXTIME(last_update) + INTERVAL 3 DAY,'%m/%d/%Y') AS 'estimate_due_date_four_day'
										FROM dispute d
										LEFT OUTER JOIN centers c ON c.center_id = d.center_id
										LEFT OUTER JOIN users u ON u.user_name = d.disputer_id										
										WHERE dispute_id=".$dispute_id);*/
					
												/* DATE_FORMAT(dispute_registeredate, '%m/%d/%Y') AS xdispute_registeredate,
												DATE_FORMAT( FROM_UNIXTIME(evaldate),'%m/%d/%Y') AS xevaldate,
												DATE_FORMAT( FROM_UNIXTIME(cqardispute_date),'%m/%d/%Y') AS xcqardispute_date,	 
												DATE_FORMAT( FROM_UNIXTIME(redispute1_date),'%m/%d/%Y') AS xredispute1_date,
												DATE_FORMAT( FROM_UNIXTIME(cqarredispute1_date),'%m/%d/%Y') AS xcqarredispute1_date,
												DATE_FORMAT( FROM_UNIXTIME(redispute2_date),'%m/%d/%Y') AS xredispute2_date,
												DATE_FORMAT( FROM_UNIXTIME(redispute21_date),'%m/%d/%Y') AS xredispute21_date,

												DATE_FORMAT( FROM_UNIXTIME(redispute22_date),'%m/%d/%Y') AS xredispute22_date,
												DATE_FORMAT( FROM_UNIXTIME(last_update) + INTERVAL 1 DAY,'%m/%d/%Y') AS 'estimate_due_date_one_day',
												DATE_FORMAT( FROM_UNIXTIME(last_update) + INTERVAL 2 DAY,'%m/%d/%Y') AS 'estimate_due_date_two_days',
												DATE_FORMAT( FROM_UNIXTIME(last_update) + INTERVAL 3 DAY,'%m/%d/%Y') AS 'estimate_due_date_four_day' */
			$query = $this->db->query("SELECT *, d.center_id as dispute_center_id 
										FROM dispute d
										LEFT OUTER JOIN centers c ON c.center_id = d.center_id
										LEFT OUTER JOIN users u ON u.user_name = d.disputer_id										
										WHERE dispute_id=".$dispute_id);
			
			return $query->result();					
		}		
		
		function updateDispute( $dispute_id, $params = array() ){
			
			$this->db->where( 'dispute_id', $dispute_id);
			$this->db->update( 'dispute' , $params );
			
			return true;
		}
		
		function getSelection_dropdown( $where ){
			
			$this->db->where($where);
			$query = $this->db->get('dropdowns');
			
			$options[''] = '--Select--';
			foreach( $query->result() as $row){
				$options[$row->drpd_id]=$row->dp_desc;
			}
			
			return $options;
		}
		function getSelection( $where ){
			
			if( !empty($where) )
				$this->db->where($where);
				
			$query = $this->db->get('dropdowns');

			return $query;
		}
		
		function getSelection_modified( $ids ){
			
			$temp = explode(";",$ids);
			$rows = '';
			$i = 1;
			
			if( count($temp) > 1 ){
				
				foreach( $temp as $id ){
					
					$id = trim( str_replace('"','',$id) );
					
					if( $id != '' ){
						if( $i == 1 ) $this->db->where('drpd_id',$id, FALSE);
						else $this->db->or_where('drpd_id',$id, FALSE);
					}
	
					$i++;
				}
								
				$query = $this->db->get('dropdowns');
				$results = $query->result();
				
				
				foreach( $results as $row){
					$rows[] = $row->dp_desc;	
				}
			}else{
				$rows = 'NO SECTION SELECTED';	
			}
			//echo $this->db->last_query();
			return $rows;					
		}
		
		function getDisputeOwner( $id ){
			
			
			if( ($id ==  2) OR ($id ==  4) OR ($id ==  6) ){
				$this->db->where('access_id', 1);	
			}

			if( ($id ==  3) OR ($id ==  5) ){
				$this->db->where('access_id', 2);	
			}			

			if( ($id ==  7) ){
				$this->db->where('access_id', 3);	
			}

			if( ($id ==  8) || ($id ==  9) ){
				$this->db->where('access_id', 4);	
			}			
			
			$query = $this->db->get('accesstypes')->row();
			
			return $query->access_abbr;
			
		}
		
		function checkDisputeOnwerStatus( $dType, $twodays, $threedays, $owner ){
			
			$result = '';
			$daysdue='';
			
			if( $daysdue > 0) $daysdue = '+'.$daysdue.'D';
			else $daysdue ='';
			
			switch( $dType ){
				case 0:			
					$result = $this->getReturnDays( $twodays );					
					break;
				case 1:									
					$result = $this->getReturnDays( $twodays );	
					break;
				case 2:
					if( ( $owner ) == 7 ){
						$daysdue = $this->getReturnDays( $twodays );						
					}elseif( ( $owner ) == 8 ){
						$daysdue = $this->getReturnDays( $threedays );					
					}else{
						$daysdue = $this->getReturnDays( $twodays );				
					}					
					$result = $daysdue;	
					break;
			}
			return $result;
			
		}
		
		function getReturnDays( $sdays ){
			
			if( $sdays > 0) {
				return '+'.$sdays.'D';
			}else{
				return '';
			}
								
		}
		
		function getDisputeList_report( $where = array(), $where_or = array(), $limit = array() ){
			
			$this->db->select(" *, u1.user_qarno as 'qarno1', u2.user_qarno as 'qarno2', LPAD( dispute_id,7,'0' ) as DP_ID,
								   (CASE dispute_type 
									WHEN 1 then 'Re-Dispute #1' 
									WHEN 2 then 'Re-Dispute #2'
									ELSE 'Dispute'
								  END) AS 'xdispute_type',
								  DATE_FORMAT( dispute_registeredate,'%m/%d/%Y  %T') AS 'xdispute_registeredate',
								  ABS(current_score-original_score) AS 'scorechange'", FALSE);
			
			$this->db->from('dispute');
			
			if( !empty($where) )
				$this->db->where( $where, NULL ,FALSE );

			$i = 1;
			if( !empty($where_or) ){
				foreach( $where_or as $key=>$value ){				
					if( $i == 1 ){
						$this->db->where( '('.$key, $value, NULL ,FALSE );
					
					}else{
						if($i == count($where_or)   ){
							
							$this->db->or_where( $key, $value.')', NULL ,FALSE );	
						}else{
							$this->db->or_where( $key, $value, NULL ,FALSE );
						}
						
						
					}
					$i++;
				}
			} 					 
			
			if( !empty($limit) )
				$this->db->limit( $limit["limit"], $limit["offset"] );	
					
			$this->db->order_by("dispute_registeredate", 'DESC');
				
			$this->db->join('centers', 'centers.center_id = dispute.center_id', 'left');
			$this->db->join('users u1', 'u1.user_name = dispute.cqardispute_userid', 'left');
			$this->db->join('users u2', 'u2.user_name= dispute.cqarredispute1_userid', 'left');
			$query = $this->db->get();
			return $query->result();
		}		
		
    	function excelwriter_factory( $where = array(), $where_or = array(), $summary = array() ){
	        //delete files
			ini_set('memory_limit', '-1');
	       	error_reporting(0);
	       	   
	    	list($usec, $sec) = explode(" ", microtime());
	    	$now = ((float)$usec + (float)$sec);		
	
	    	$current_dir = @opendir('filemanager/export');
	
	        //echo $current_dir;
	    	while( $filename = @readdir($current_dir) ) {
				
	    		if ($filename != "." and $filename != ".." and $filename != "index.html") {
	    			$name = str_replace(".xls", "", $filename);
					
	    			if (($name + 3600) < $now) {
	    				@unlink('filemanager/export/'.$filename);
	    			}
	    		}
	    	}
	
	    	@closedir($current_dir);
	
			$this->db->select(" IF( u1.user_qarno = u2.user_qarno, u1.user_qarno, CONCAT(u1.user_qarno,' ',u2.user_qarno) ) AS 'Evaluator ID',							
								DATE_FORMAT( dispute_registeredate,'%m/%d/%Y  %T') AS 'Dispute Date Submitted',
								auditcontno as 'Audit Contact #:',
								center_desc as 'Center',
								login_id as 'Login ID',
								original_score as 'Original Score',
								current_score as 'Current Score'
								", FALSE);
			
			//$this->db->from('dispute');
			
			if( !empty($where) )
				$this->db->where( $where, NULL ,FALSE );
				
	
			$i = 1;
			if( !empty($where_or) ){
				foreach( $where_or as $key=>$value ){				
					if( $i == 1 ){
						$this->db->where( '('.$key, $value, NULL ,FALSE );
					
					}else{
						if($i == count($where_or)   ){
							
							$this->db->or_where( $key, $value.')', NULL ,FALSE );	
						}else{
							$this->db->or_where( $key, $value, NULL ,FALSE );
						}
						
						
					}
					$i++;
				}
			}  	
			
	
			if( !empty($limit) )
				$this->db->limit( $limit["limit"], $limit["offset"] );	
					
			$this->db->order_by("dispute_registeredate", 'DESC');
				
			$this->db->join('centers', 'centers.center_id = dispute.center_id', 'left');
			$this->db->join('users u1', 'u1.user_name = dispute.cqardispute_userid', 'left');
			$this->db->join('users u2', 'u2.user_name= dispute.cqarredispute1_userid', 'left');
			$query = $this->db->get('dispute');
				
			
	        foreach ( $query->list_fields() as $field ){
	             $colNames[] =  $field;
	        }
	
	        $filename = 'filemanager/export/'.number_format($now, 0, '.', '').'.xls';
	
	
	        $xls =& new Spreadsheet_Excel_Writer( $filename );
	
	        $sheet =& $xls->addWorksheet(' QA Dispute Tracker Export ');
	
			$colHeadingFormat =& $xls->addFormat();
			$colHeadingFormat->setBold();
			$colHeadingFormat->setFontFamily('Arial');
			$colHeadingFormat->setSize('10');
			$colHeadingFormat->setColor(1);
			$colHeadingFormat->setFgColor(12);
			$colHeadingFormat->setAlign('center');
			$colHeadingFormat->setTextWrap();
		
			$sheet->writeRow(2,0,$colNames,$colHeadingFormat);
			$sheet->setColumn(0,50,10);				
			
			$i = 3;
			
			foreach( $query->result() as $row ){
	    	    $j = 0;    	    
	        	foreach( $row as $value ){
	        		$sheet->writestring( $i, $j, $value );
	        		$j++;
	        	}
	  	        $i++;
			}
			
			$title =& $xls->addFormat();
			$title->setBold();
			$title->setFontFamily('Arial');
			$title->setSize('10');
					
			$i = $i+2; 
			$sheet->writeRow($i+1,0,array('Report Summary'),$title);
			
			$sheet->writestring( $i+2, 0, 'Disputes' );
			$sheet->writestring( $i+3, 0, 'Total Disputes' );
			$sheet->writestring( $i+3, 1,  $summary['totalDisputes'] );
			
			$sheet->writestring( $i+4, 0, 'Total Re-Disputes #1' );
			$sheet->writestring( $i+4, 1,  $summary['totalDisputes1'] );
	
			$sheet->writestring( $i+5, 0, 'Total Re-Disputes #2' );
			$sheet->writestring( $i+5, 1, $summary['totalDisputes2'] );		
			
			$sheet->writeRow($i+6,0,array('Scores'),$title);
			
			$sheet->writestring( $i+7, 0, 'Total # Disputes Changed' );
			$sheet->writestring( $i+7, 1, $summary['totalscorechanged'] );		
					
			$xls->close();
					
								
		  	return  $filename;
      }

      
	}
?>