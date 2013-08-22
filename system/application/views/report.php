
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
						<h3><a class="head" href="#">-</a> Search</h3>
						<div>
		                	<table width="790" border="0" id="formtable" >							
								<tbody>
									<tr>
	                                  <td><strong>From:</strong></td>
									  <td><input type="text" name="txtfrom" id="txtfrom" size="15" value="<?=( isset($_GET["txtfrom"]) )?$_GET["txtfrom"]:"";?>" /></td>
									  <td><strong>Center:</strong></td>
									  <td>
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
									  <td><strong>Audit Contact #: </strong></td> 	
									  <td><input type="text" name="textsearch" value="<?= (isset($_GET["textsearch"]) )?$_GET["textsearch"]:""?>"/></td>
									  <td><input type="button" name="searchbtn" id="searchbtn" class="button"  value="Search" style="width:80px" /></td>
								  	</tr>
									<tr>
	                                  <td><strong>To:</strong></td>
									  <td><input name="txtto" type="text" id="txtto" size="15" value="<?=( isset($_GET["txtto"]) )?$_GET["txtto"]:"";?>"  /></td>
									  <td><strong>QAR Name:</strong></td>
									  <td>
										<?
											echo form_dropdown('qarname', $qarList, ( isset($_GET["qarname"]) )?$_GET["qarname"]:"" );
										?>
	
									  </td>
									  <td><strong>Evaluator ID:</strong></td>
									  <td>
									  <?php 
									  	echo form_dropdown('evaluatorid', $evaluatorList, ( isset($_GET["evaluatorid"]) )?$_GET["evaluatorid"]:"" );
									  ?>			
									  </td>
									  <td><input name="clearbtn" id="clearbtn" class="button" type="reset" value="Clear" style="width:80px" /></td>
								  </tr>
									<tr>
	                                  <td><strong>Weekly View:</strong></td>
									  <td><input type="text" name="weeklyview" value="<?=( isset($_GET["weeklyview"]) )?$_GET["weeklyview"]:"";?>" size="15"></td>
									  
									  <td><strong>Section:</strong></td>
									  <td colspan="2"><?=form_dropdown('dp_selection', $dp_selection, ( isset($_GET["dp_selection"]) )?$_GET["dp_selection"]:"" );?></td>
									  <td>&nbsp;</td>									  
									  <td>&nbsp;</td>
								  </tr>								  
	
								</tbody> 
							</table>
						</div>
					</div>			
					<br />	
					<div class="box">
						<h3><a class="head" href="#">-</a> Results</h3>
						<?php if( trim($exportlink) != ''  ): ?>
						<div style="width:900px; text-align:right; padding:2px 0px; font-weight:bold"><a href="client/export/?flag=0&xfilename=<?=$exportlink?>">Export to Excel</a></div>
						<?php endif; ?>
						<div>							
		                	<table  border="1">
		                    	<thead>
		                        	<tr>
		                            	<th>#</th>
		                                <th>Evaluator ID</th>		                                
		                                <th>Dispute Date Submitted</th>		                               
		                                <!-- <th>Counter</th> -->
		                                <th>Audit Contact #</th>
		                                <th>Center</th>
		                                <th>Login</th>
		                                <th>Original Score</th>
		                                <th>Current Score</th>		                                	                            
		                            </tr>	
		                        </thead>
		                        <tbody>
		                        	<?php 
		                        	
		                        		$pageno = 1;
										if( isset($_GET['per_page']) && ($_GET['per_page'] != '')  )
		                        		 	$pageno = $_GET['per_page'] + 1;
		                        		
		                        		foreach( $disputeList as $row): 
											
		                        		$original_score = $row->original_score;
		                        		$tmp_avg_score = 0;		
		                        			
		                        			if( $row->cqarnew_score_changed == 1 ){
		                        				
		                        				$tmp_avg_score += abs($row->original_score - $row->cqarnew_score);
		                        				
		                        				if( $row->cqarnew_score2_changed == 1 ){
		                        					
		                        					$tmp_avg_score += abs($row->cqarnew_score - $row->cqarnew_score2);
	
		                        					if( $row->snew_score3_changed == 1 ){
		                        						$tmp_avg_score += abs($row->cqarnew_score2 - $row->snew_score3);
		                        					}	                        					
		                        					
		                        				}else{
		                        					
		                        					if( $row->snew_score3_changed == 1 ){
		                        						$tmp_avg_score += abs($row->original_score - $row->snew_score3);
		                        					}	                        					
		                        				}
		                        				
		                        			}else{
		                        				
		                        				if( $row->cqarnew_score2_changed == 1 ){
		                        					
		                        					$tmp_avg_score += abs($row->cqarnew_score - $row->cqarnew_score2);
	
		                        					if( $row->snew_score3_changed == 1 ){
		                        						$tmp_avg_score += abs($row->cqarnew_score2 - $row->snew_score3);	
		                        					}
		                        				}else{
		                        					
		                        					if( $row->snew_score3_changed == 1 ){
		                        						$tmp_avg_score += abs($row->original_score - $row->snew_score3);
		                        					}
		                        				}
		                        				
		                        			}	                        			
		                        			
		                        			$tmp_avg_score = @($tmp_avg_score/$row->score_changedcounter);	
		                        			$tmp_avg_score == ($tmp_avg_score == 0)?'0':$tmp_avg_score;		
		                        		
		                        	?>
		                        	<tr>
		                            	<td><?=$pageno.'.'?></td>
		                                <td><?=($row->qarno1 == $row->qarno2 )?$row->qarno1:$row->qarno1.' '.$row->qarno2?></td>                                		                                
		                                <td><?=$row->xdispute_registeredate?></td>		                                
		                                <!-- <td><?=$row->DP_ID?></td> -->
		                                <td><?=$row->auditcontno?></td>
		                                <td><?=$row->center_desc?></td>
		                                <td><?=$row->login_id?></td>
		                                <td><?=$row->original_score?></td>		                                
		                                <td><?=$row->current_score?></td>		                                
		                            </tr>
		                            <?php
		                            	$pageno++; 
		                            	endforeach; 
		                            ?>
		                        </tbody>
		                    </table>
	                    </div>
            			<div id="pagination" >
            				<?=$pagination;?>
            			</div>	                    	                    
	                </div>
	                <br />
	                
	                <div class="box">
	                	<h3>Reports Summary</h3>
	                	<div style="padding:0px 10px">
	                	
                        	<?php 
                        		/*$totalDisputes = 0;
                        		$totalDisputes1 = 0;
                        		$totalDisputes2 = 0;
                        		
                        		$totalNoScoreChange = 0; 
                        			
                        		$averagePointChanged = 0;
                        		$total_Points_Changed = 0;
                        		
                        		foreach( $disputeListAll as $row): 
									
                        			$original_score = $row->original_score;
                        			$tmp_avg_score = 0;		
                        			
                        			if( $row->cqarnew_score_changed == 1 ){
                        				
                        				$tmp_avg_score += abs($row->original_score - $row->cqarnew_score);
                        				
                        				if( $row->cqarnew_score2_changed == 1 ){
                        					
                        					$tmp_avg_score += abs($row->cqarnew_score - $row->cqarnew_score2);

                        					if( $row->snew_score3_changed == 1 ){
                        						$tmp_avg_score += abs($row->cqarnew_score2 - $row->snew_score3);
                        					}	                        					
                        					
                        				}else{
                        					
                        					if( $row->snew_score3_changed == 1 ){
                        						$tmp_avg_score += abs($row->original_score - $row->snew_score3);
                        					}	                        					
                        				}
                        				
                        			}else{
                        				
                        				if( $row->cqarnew_score2_changed == 1 ){
                        					
                        					$tmp_avg_score += abs($row->cqarnew_score - $row->cqarnew_score2);

                        					if( $row->snew_score3_changed == 1 ){
                        						$tmp_avg_score += abs($row->cqarnew_score2 - $row->snew_score3);	
                        					}
                        				}else{
                        					
                        					if( $row->snew_score3_changed == 1 ){
                        						$tmp_avg_score += abs($row->original_score - $row->snew_score3);
                        					}
                        				}                        				
                        			}	                        			
                        			
									
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
                        			
									$totalNoScoreChange += ($row->score_changedcounter-1); 
									
                        			$tmp_avg_score = @($tmp_avg_score/$row->score_changedcounter);	
                        			
                        			$total_Points_Changed +=  $tmp_avg_score;
                        					
                        		endforeach;
                        		
                        		$averagePointChanged = @round( $total_Points_Changed/($totalDisputes+$totalDisputes1+$totalDisputes2), 2);*/
                        		//print_r($summary);
                        		
                        	?>	                	
		                	<table style="width:250px" >
			                	<thead>
			                		<tr>
			                			<th width="200px" style="text-align:left">Disputes</th>
			                			<th width="50px" ></th>
			                		</tr>
			                	</thead>
			                	<tbody>	
			                		<tr>
			                			<td>Total Disputes</td>
			                			<td style="text-align:center"><?=@$summary['totalDisputes'];?></td>	                			
			                		</tr>
			                		<tr>
			                			<td>Total Re-Disputes #1</td>
			                			<td style="text-align:center"><?=@$summary['totalDisputes2'];?></td>	                			
			                		</tr>
			                		<tr>
			                			<td>Total Re-Disputes #2</td>
			                			<td style="text-align:center"><?=@$summary['totalDisputes2'];?></td>	                			
			                		</tr>
			                	</tbody>	
			                	<thead>	
			                		<tr>
			                			<th style="text-align:left">Scores</th>
			                			<th style="text-align:center"></th>	                			
			                		</tr>
			                	</thead>
			                	<tbody>
			                		<tr>
			                			<td>Total # Disputes Changed</td>
			                			<td style="text-align:center"><?=@$summary['totalscorechanged'];?></td>	                			
			                		</tr>
			                	</tbody>		                			                			                			                			                			                			                		
		                	</table>	
	                	</div>
	                </div>	                
                </form>	
                
            </div>
        </div>
        
        <script>
			
    		$("#searchbtn").click(function(){
            	$("form").submit();
        	});

        	$("#clearbtn").click( function(){
            	window.location = "<?=base_url();?>client/report/";
        	})
        	      	
	        $(document).ready( function() {
	
				$('.head').click( function() {
					
					$(this).parent().next().toggle('fast');
					if( $(this).text() == '-' ){
						$(this).text('+');
					}else{
						$(this).text('-');
					}
					
					return false;
				})             
	        });	
			        	
        </script>