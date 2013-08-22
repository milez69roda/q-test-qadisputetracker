		<?php 
			
			/*if( $disputeInfo[0]->cqardispute_status == 1 ){
				$class = 'answered';
			}else{
				$class = 'unaswered';
			}*/
		$class = "";
		
		?>
		<div id="wrapper">
            <div id="content">
            	 
            	<form id="form" action="" method="post" enctype="multipart/form-data" >
            	
		 			<div class="box">
		 				<h3>Disputer Information</h3>                     
	                	<table width="736" border="0" style="width:700px;" id="formtable" >
							
							<tbody>
								<tr>
	                            	<td width="147"><strong>Date Submitted:</strong></td>
                                  <td width="194"><input type="text" name="todaysdate" id="todaysdate" value="<?=$disputeInfo[0]->xdispute_registeredate?>" readonly="readonly" /></td>
                                  <td width="171"><strong>Evaluation Date:</strong></td>
                                  <td width="170"><input type="text" name="evaldate" id="evaldate" value="<?=$disputeInfo[0]->xevaldate?>" readonly="readonly" /></td>
							  </tr>
								<tr>
	                            	<td><strong>Center:</strong></td>
	                            	<td><input type="text" name="center" id="center" readonly="readonly" value="<?=$disputeInfo[0]->center_desc?>" /></td>
	                                <td><strong>Audit Contact Number:</strong></td>
	                                <td><input type="text" name="auditcontno" id="auditcontno" value="<?=$disputeInfo[0]->auditcontno?>" readonly="readonly"  /></td>
								</tr>
								<tr>
	                            	<td><strong>Disputer Name:</strong></td>
	                                <td><input type="text" name="todaysdate" id="disputername" readonly="readonly" value="<?=$disputeInfo[0]->user_firstname.' '.$disputeInfo[0]->user_lastname?>"/></td>
	                                <td><strong>Agent Name:</strong></td>
	                                <td><input type="text" name="agentname" id="agentname"  value="<?=$disputeInfo[0]->agentname?>"  readonly="readonly" /> </td>
								</tr>
								<tr>
	                            	<td><strong>Disputer Email:</strong></td>
	                                <td><input type="text" name="disputeremail" id="disputeremail" readonly="readonly" value="<?=$disputeInfo[0]->user_email?>" /></td>
	                                <td><strong>Login ID:</strong></td>
	                                <td><input type="text" name="login_id" id="login_id" value="<?=$disputeInfo[0]->login_id?>" readonly="readonly"/> </td>
								</tr>
	                            <tr>
	                            	<td><strong>Disputer Contact's:</strong></td>
	                                <td><input type="text" name="disputercontacts" id="disputercontacts"  readonly="readonly" value="<?=$disputeInfo[0]->user_ext?>" /></td>
	                                <td><strong>Page # File Name:</strong></td>
	                                <td><input type="text" name="pagenofilename" id="pagenofilename" value="<?=$disputeInfo[0]->pagenofilename?>" readonly="readonly"/> </td>
	                            </tr>
	                            <tr>
	                              <td>&nbsp;</td>
	                              <td>&nbsp;</td>
	                              <td><strong>Original Score:</strong></td>
	                              <td><input type="text" name="original_score" id="original_score" value="<?=$disputeInfo[0]->original_score?>" readonly="readonly" /></td>
                                </tr>
	                            <tr>
	                              <td>&nbsp;</td>
	                              <td>&nbsp;</td>
	                              <td><strong>Current Score:</strong></td>
	                              <td><input type="text" name="original_score" id="original_score" value="<?=$disputeInfo[0]->current_score?>" readonly="readonly" /></td>
                                </tr>                                
							</tbody>
						</table>	                   	 		
 			  	    </div> 
					
					<br />
            		<div class="box">
            			<h3>Miami QAR Information</h3>            			
						<table width="736" border="0" style="width:350px;" id="formtable" >
							<tbody>
                            	<tr>
                                	<td width="148"><strong>Today's Date:</strong></td>
                                    <td width="192"><input type="text" name="todaysdate2" id="todaysdate2" value="<?=date('m/d/Y')?>" readonly="readonly" /></td>
                                </tr>
                            	<tr>
                            	  <td><strong>Miami QAR Name:</strong></td>
                            	  <td><input type="text" name="todaysdate3" id="todaysdate3" value="<?=$userinfo[0]->user_firstname.' '.$userinfo[0]->user_lastname?>" readonly="readonly" /></td>
                          	  </tr>
                            	<tr>
                            	  <td><strong>Miami QAR #:</strong></td>
                            	  <td><input type="text" name="todaysdate4" id="todaysdate4" value="<?=$disputeInfo[0]->user_qarno?>" readonly="readonly" /></td>
                          	  </tr>
                            </tbody>
						</table>
           		    </div>
           		     			  	   
			       <br />
			       <div class="box">
				   	   <h3>Dispute History</h3>
				
					   <table width="980" border="0" id="formtable" >
					   		<tbody>
                            	<tr>
                                	<td width="475">
                                		<span style="font-weight:bold">Despute Request Comment( <?=$disputeInfo[0]->xdispute_registeredate?> ): </span> <br />
										<textarea rows="6" name="dispute_comment" id="dispute_comment" readonly="readonly" ><?=$disputeInfo[0]->dispute_comment?></textarea>
										<br />
										<a href="<?=$disputeInfo[0]->evalform_attachment?>" style="text-decoration:underline" ><strong>Evaluation Form Attachment</strong></a>                                    </td>
										<br />
                                    <td width="495">&nbsp;</td>
              					</tr>
                            	<tr>
                            	    <td>
					 	  			    <span style="font-weight:bold">Despute Response( <?=$disputeInfo[0]->xcqardispute_date?> ): </span> <br />
			 	  					    <textarea rows="6" name="cqardispute_text" id="cqardispute_text" readonly="readonly" ><?=$disputeInfo[0]->cqardispute_text?> </textarea>                         </td>
	                            	 
                            	    <td>
                                  		<span style="width:100px;float:left;font-weight:bold">Previous Score:</span> <input type="text" name="todaysdate6" id="todaysdate6" value="<?=$disputeInfo[0]->original_score?>" readonly="readonly" />
                                        <br />
                                        <span style="width:100px;float:left;font-weight:bold">New Score: </span><input type="text" name="todaysdate6" id="todaysdate6" value="<?=$disputeInfo[0]->cqarnew_score?>" readonly="readonly" />
                                  </td>
                          	  </tr>
                            	<tr>
                            	  <td>&nbsp;</td>
                            	  <td>&nbsp;</td>
                           	  </tr>
                            </tbody>
						</table>
						
			  
			      </div>
			      <br />
	 			  <div class="box">
 			      	<h3>Re-dispute #1 Request Section</h3>
 			      	
						<table width="988" border="0"  id="formtable" >
					    <tbody>
                        	<tr>
                            	<td width="316">
					 	  			    <span style="font-weight:bold">Re-dispute #1 Request Comment:</span> <br />
			 	  					    <textarea rows="6" name="redispute1_text" id="redispute1_text" ><?=$disputeInfo[0]->cqarredispute1_text?></textarea>                                      
                                </td>
                                 <td width="662">&nbsp;</td>
                        	</tr>
                        </tbody>
						</table> 			    	
 			    	
   		          <br/><br/>
			   		 <input class="button" type="reset" name="reset" value="Clear Form" />
			   		 <input class="button <?=$class?>" type="submit" name="submit" id="save" value="Save" />
			   		 <input class="button" type="button" name="cancel" value="Cancel" onclick="javascript:history.go(-1)"/> 			    	
 			     </div>  
	 			    
			   </form>         	 
               <p>&nbsp;</p>
               <p>&nbsp;</p>
            </div>
        </div>
        
        <script>

    	/*$("#form").submit( function(){

			xcfrm = confirm("Do you want to save?");	

			if( xcfrm ){
				return true;
			}	
        	
        	return false;
    	});*/

    	$("#change_score").change( function (){
        	//alert($("#change_score").val());
        	
        	$val = $("#change_score").val();
        	
        	if( $val == '0' ){
        		$("#new_score_box").css('display','block');	
        	}else{
        		$("#new_score_box").css('display','none');	
        	}
        	//alert($("#new_score_box").css('display'));
    	})
        
        
        $(document).ready( function() {

			$('.answered').attr("readonly", true);
        		
            
        })
        
        </script>