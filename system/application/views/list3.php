
       	<link type="text/css" href="package/jquery/css/start/start.css" rel="stylesheet" />
		<script type="text/javascript" src="package/jquery/ui.core.js"></script>
		<script type="text/javascript" src="package/jquery/ui.datepicker.js"></script>
		<script>
			$(function() {
				
				$("#txtfrom").datepicker( { showOn: 'button',
											 buttonImageOnly: true, 
											 buttonImage: 'package/jquery/calendar.gif'} );
				$("#txtto").datepicker( { showOn: 'button',
											 buttonImageOnly: true, 
											 buttonImage: 'package/jquery/calendar.gif'} );			 
			});
		</script>				
        <div id="wrapper">
            <div id="content">
            
            	<form id="form" name="searchform" action="" method="GET">     
            		<input type="hidden" name="flag" id="flag" value="0" tabindex="0" />       	
            		<input type="hidden" name="alert" id="alert" value="0" tabindex="0" />
	            	<div class="box">
						<h3>Search</h3>
	                	<table width="800" border="0" style="width:700px;" id="formtable" >
							
							<tbody>
								<tr>
	                            	<td width="96"><strong>Status</strong></td>
                              		<td width="148">
										<select name="status" id="status">
	                                		<option value="-1">Select</option>
	                                		<option value="0" <?=( isset($_GET["status"]) && ( $_GET["status"] == 0) )?'selected="selected"':"";?> >Pending</option>
	                                		<option value="1" <?=( isset($_GET["status"]) && ( $_GET["status"] == 1) )?'selected="selected"':"";?>>Completed</option>
	                                	</select>	                                
	                                </td>
                                  	<td width="132"><strong>Center</strong></td>
                              		<td width="146">	
                              			<select name="center" id="center">
									      <option value="0">All</option>
									  	<?php 
									  		foreach( $centerList as $rows):	

									  			if( isset($_GET["center"]) && ($rows->center_id == $_GET["center"])  ):							  		
									  	?>
	                                      			<option  value="<?=$rows->center_id?>" selected="selected" ><?=$rows->center_desc?></option>
	                                    <?php 
	                                    		else:	
	                                    ?>  
	                                    			<option  value="<?=$rows->center_id?>" ><?=$rows->center_desc?></option>
	                                    <?php 
	                                    		endif;
	                                    	endforeach;
	                                    ?>                                      
	                                  </select>
									</td>
                                  	<td width="74"><input name="alertbtn" id="alertbtn" class="button" type="button" value="Alert" style="width:80px; color:red" /></td>
                                  	<td width="78">&nbsp;</td>								
							  	</tr>
								<tr>
                                  <td><strong>Date Range</strong></td>
								  <td>&nbsp;</td>
								  <td><strong>Audit Contact #.</strong></td>
								  <td><input type="text" name="searchtxt" id="searchtxt" value="<?=( isset($_GET["searchtxt"]) )?$_GET["searchtxt"]:''?>" /></td>
								  <td><input type="button" name="searchbtn" id="searchbtn" class="button"  value="Search" style="width:80px" /></td>
								  <td>&nbsp;</td>
							    </tr>
								<tr>
                                  <td><strong>From:</strong></td>
								  <td><input name="txtfrom" type="text" id="txtfrom" size="15" value="<?=( isset($_GET["txtfrom"]) )?$_GET["txtfrom"]:"";?>" /></td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td><input name="clearbtn" id="clearbtn" class="button" type="reset" value="Clear" style="width:80px" /></td>
								  <td>&nbsp;</td>
							  </tr>
								<tr>
                                  <td><strong>To:</strong></td>
								  <td><input name="txtto" type="text" id="txtto" size="15" value="<?=( isset($_GET["txtto"]) )?$_GET["txtto"]:"";?>"  /></td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
							  </tr>

							</tbody> 
						</table>
					</div>			
					<br />	
					<div class="box">
						<h3>Results</h3>
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
	                            	<th><a href="<?=$page_url.$order?>" >Counter<img src="<?=$img?>" width="16" height="16" align="absmiddle" /></a></th>
	                                <th>Name</th>	                                
	                                <th>Audit Contact #</th>
	                                <th>Last Updated</th>
	                                <th>Status</th>
	                                <th>Center</th>
	                                <th>Dispute Type</th>
	                                <th>Estimated Due Date</th>	                             
	                            </tr>	
	                        </thead>
	                        <tbody>
	                        	<?php 
	                        		foreach( $disputeList as $row): 
										$page = '';
										$isAlmostDue = '';
										//$xtemp = explode('-',$row->almost_past_due);
										$oneday = $row->almost_past_due;
	                        			switch( $row->dispute_type ){
	                                		case 0:
												//if( $row->dispute_type_status == 0 ) $page = 'response';
												//else $page = 'response';
												$page = 'response';		
	                                			//$isAlmostDue = ( (count($xtemp) > 1) && isset($_GET["alert"]) && ($_GET["alert"] == 1) && ($row->dispute_type_status == 0) )?'almostdue':'';
	                                			break;
	                                		case 1:	                                		
												$page = 'redispute1response';
	                                			//$isAlmostDue = ( (count($xtemp) > 1) && isset($_GET["alert"]) && ($_GET["alert"] == 1) && ($row->dispute_type_status == 0) )?'almostdue':'';
	                                															
												break;
	                                		case 2:
	                                			$page = 'redispute21response';
	                                			$isAlmostDue = ( ($oneday > 1) && isset($_GET["alert"]) && ($_GET["alert"] == 1) && ($row->redispute2_status == 1) )?'almostdue':'';
	                                			
	                                			break;	
	                                	}
	                                	
	                        	?>
	                        	<tr class="<?=$isAlmostDue;?>">
	                            	<td><a href="client/<?php echo $page.'/'.str_pad($row->dispute_id, 7, "0", STR_PAD_LEFT); ?>">select</a> </td>	                                                               
	                                <td><?php echo str_pad($row->dispute_id, 7, "0", STR_PAD_LEFT); ?></td>
	                                <td><?php echo $row->agentname; ?></td>
	                                <td><?php echo $row->auditcontno; ?></td>
	                                <td><?php 
										//$row->xlast_update
										echo date('m/d/Y H:i:s', $row->last_update );
									?>
									</td>
	                                <td><?php ($row->redispute21_status == 0)? 'Pending':'Completed'; ?></td>
	                                <td><?php echo $row->center_desc; ?></td>
	                                <td><?php echo $row->xdispute_type; ?></td>
	                                <td><?php
	                                	if ($row->redispute21_status == 0){
	                                		//echo $row->estimate_dute_date.' '.$this->disputes->checkDisputeOnwerStatus($row->dispute_type,$row->twodays, $row->threedays, $row->dispute_process+1);
	                                		
											$days2 = floor((strtotime('NOW')-strtotime('+2 day', $row->last_update))/86400);
											
											$days3 = floor((strtotime('NOW')-strtotime('+3 day', $row->last_update))/86400);
											
											echo date('m/d/Y', strtotime('+2 day', $row->last_update)).' '.$this->disputes->checkDisputeOnwerStatus($row->dispute_type,$days2, $days3, $row->dispute_process+1);
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
					<br />
					<div class="box">
					<h3>Legend</h3>
						<div>
						<b>+(Number)D</b> = Over Number Days <span style="color:green">(Example: +3D = Over Three Days from the Estimated Due Date)</span>
						</div>
						<br />
					</div>                
					
                </form>	
            </div>
        </div>
        
        <script>
			
			$(document).ready( function(){

			
				//alert($("#alert").val());
						
			})	
			
				
    		$("#searchbtn").click(function(){
            	$("form").submit();
        	});

        	$("#clearbtn").click( function(){
            	window.location = "<?=base_url();?>client/list3/";
        	})
        	
        	$("#alertbtn").click( function() {
            	
				$("#alert").val(1);
				$("#txtfrom").val('');
				$("#txtto").val('');
				$("#center").val(0);
				$("#status").val(-1);
				$("#type").val(-1);
				$("#searchtxt").val('');
				
        		$("form").submit();
            	
        	})        	
        	
        </script>