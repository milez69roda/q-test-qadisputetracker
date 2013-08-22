
        <div id="wrapper">
            <div id="content">
            	
            	<form id="form" name="searchform" action="" method="GET">
            		<input type="hidden" name="flag" id="flag" value="0" tabindex="0" />
            		<div class="box">
            		<h3>Search</h3>
	                	<table border="0" style="width:500px;" id="formtable" >
							
							<tbody>
								<tr>
	                            	<td width="96"><strong>Audit Contact #:</strong></td>
                              		<td width="148"> <input type="text" name="searchtxt" id="searchtxt" value="<?=( isset($_GET["searchtxt"]) )?$_GET["searchtxt"]:"";?>" /> </td>
                              		<td>                              			
                              			<input class="button" type="button" name="search" id="search" value="Search" onclick="document.searchform.submit()" tabindex="1" />
                              			<input class="button" type="reset" name="clear" id="clear" value="Clear" />
                              		</td>
							    </tr>
							</tbody>
							
						</table>							    		                  			
            			
            			<hr />
	                	<table  border="1">
	                	<?php 
	                		$order = '&orderby=desc';
	                		$img = 'img/icons/arrow_right.gif';
	                		if( isset($_GET['orderby']) ){
	                			if( $_GET['orderby']=='asc'){
	                				$order = '&orderby=desc';
	                				$img = 'img/icons/arrow_up_mini.gif';
	                			}else{
			                		$order = '&orderby=asc';
			                		$img = 'img/icons/arrow_down_mini.gif';                				
	                			}
	                			
	                		}
	                		
	                	?>
	                    	<thead>
	                        	<tr>
	                            	<th>Action</th>
	                                <!-- <th>Name</th> img/icons/arrow_down_mini.gif -->
	                                <th><a href="<?=$page_url.$order?>" >Counter<img src="<?=$img?>" width="16" height="16" align="absmiddle" /></a></th>
	                                <th>Audit Contact #</th>
	                                <th>Last Updated</th>
	                                <th>Status</th>
	                                <!-- <th>Center</th> -->
	                                <th>Dispute Type</th>
	                                <th>Estimated Due Date</th>
	                               
	                            </tr>	
	                        </thead>
	                        <tbody>
	                        	<?php 
	                        		foreach( $disputeList as $row): 
	                        		    $page = "";
										switch( $row->dispute_type ){
											case 0:
												if( $row->dispute_type_status == 0 ) $page = 'response';
												else $page = 'redispute1';
												break;
											case 1:
												//rigth now this page is for redisputeresponse, which is in favor of miami.
												//we still need to create a page of which carecenter can redispute for the 2nd level.
												//$page = 'redispute1response';
												if( $row->dispute_type_status == 0 ) $page = 'redispute1response';
												else $page = 'redispute2';												
												break;
											case 2:
												//@todo should pud some status for carecenter, cccm, sr. manager
												//$page = 'response3';
											    if( $row->redispute21_status == 1 ){
	                                				$page = 'redispute22response';	
	                                			}else{
	                                				$page = 'redispute21response';
	                                			}												
												break;		
											 	
										}	                        	
	                        	?>	                        		
	                        	<tr>
	                            	<td><a href="client/<?=$page.'/'.str_pad($row->dispute_id, 7, "0", STR_PAD_LEFT); ?>">select</a> </td>
	                                <!-- <td><?php //echo $row->agentname; ?></td>  -->                               
	                                <td><?php echo str_pad($row->dispute_id, 7, "0", STR_PAD_LEFT); ?></td>
	                                <td><?php echo $row->auditcontno?></td>
	                                <td><?php 
										//echo $row->xlast_update
										echo date('m/d/Y H:i:s', $row->last_update );
										?>
									</td>
	                                <td><?php echo ($row->dispute_type_status == 0)? 'Submitted':'Completed';	
	                                	/*switch( $row->dispute_type ){
	                                		case 0:
	                                			echo ($row->dispute_type_status == 0)? 'Submitted':'Completed';	
	                                			break;
	                                		case 1:
	                                			echo ($row->dispute_type_status == 0)? 'Submitted':'Completed';	
	                                			break;
	                                		case 2:	                                				                                		
	                                			echo ($row->dispute_type_status == 0)? 'Submitted':'Completed';
	                                			break;		
	                                	}*/                                
	                                ?></td>
	                                <!-- <td><?=$row->center_desc?></td> -->
	                                <td><?=$row->xdispute_type?></td>
	                                <td><?
	                                
	                                		//($row->dispute_type_status == 0)?$row->estimate_dute_date:''
	                                		
	                                		if( $row->dispute_type_status == 0 )	
	                                			//echo $row->estimate_dute_date;
												echo date('m/d/Y', strtotime('+2 day', $row->last_update));
	                                		else{
	                                			if( $row->dispute_type != 2  ){
	                                				
	                                				//if( strtotime( date('Y-m-d h:m:s')) > strtotime($row->estimate_due_date_one_day ) ){
	                                				
													//if( strtotime( date('Y-m-d')) > strtotime($row->estimate_due_date_one_day ) ){
													if( strtotime( date('Y-m-d')) > strtotime('+1 day', $row->last_update) ){
	                                					echo '<span style="color:red">Re-dispute Locked</span>';
	                                				}else{
	                                					
	                                					//echo $row->estimate_due_date_one_day;
	                                					echo date('m/d/Y', strtotime('+1 day', $row->last_update));
	                                				}
	                                				
	                                			}
	                                		}
	                                	?>	                                	
	                                </td>
	                               
	                            </tr>
	                            <?php endforeach; ?>
	                        </tbody>
	                    </table>
	                                		
            			<div id="pagination" >
            				<?=$pagination;?>
            			</div>
            		</div>
            	</form>

            </div>
        </div>
        <script>

        	$("#clear").click( function(){
            	window.location = "<?=base_url();?>client/list1/";
        	})

        </script>