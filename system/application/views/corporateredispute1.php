		<?php 
			$class = ""; $class1="";
			
			$xcqardispute_date = @date('m/d/Y', $disputeInfo[0]->cqardispute_date);
			$xdispute_registeredate  = @date('m/d/Y', strtotime($disputeInfo[0]->dispute_registeredate) );
			$xevaldate = @date('m/d/Y', strtotime($disputeInfo[0]->dispute_registeredate) );			
			$xredispute1_date = @date('m/d/Y', $disputeInfo[0]->redispute1_date);			
			$xcqarredispute1_date = @date('m/d/Y', $disputeInfo[0]->cqarredispute1_date);				
			$xredispute21_date = @date('m/d/Y', $disputeInfo[0]->redispute21_date);
						
			
			//dispute,response user:
			$user2_name = ""; $user2_no = ""; $user2_datesubmitted = "";
			
			if( ($disputeInfo[0]->cqarredispute1_status == 0) && ($this->session->userdata('DX_access_id') == 2) ){
				$class = 'nodisable';
			}elseif( $disputeInfo[0]->cqarredispute1_status == 1 ){
				
				$class = 'inputdisable';
				$class1 = 'selectdisable';	
				
				$iuser2 = $this->users->getUser( $disputeInfo[0]->cqarredispute1_userid );								
				
				$user2_name= $iuser2[0]->user_firstname.' '.$iuser2[0]->user_lastname;
				$user2_no  = $iuser2[0]->user_ext;
				$user2_datesubmitted = $xcqarredispute1_date;	
			}else{
				
				$class = 'inputdisable';
				$class1 = 'selectdisable';				
			}
			
		?>
		<script type="text/javascript" src="package/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
		<script>
			tinyMCE.init({
				elements: 'inputdisable, textarea1, textarea2, textarea3, textarea4 ', 
				mode : "exact",
				theme : "advanced",
				readonly : true
			});

			
			tinyMCE.init({
				elements: 'nodisable', 
			    mode : "exact",
			    theme : "advanced",
			    theme_advanced_buttons1 : "spellchecker,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo",
			    theme_advanced_buttons2 : "",
			    theme_advanced_buttons3 : "",
			    theme_advanced_toolbar_location : "top",
			    theme_advanced_toolbar_align : "left",
			    theme_advanced_statusbar_location : "bottom",
				plugins : 'inlinepopups,spellchecker',
			                setup : function(ed) {
			                /*ed.onKeyUp.add( function(ed, e) {
			                    txt = tinyMCE.activeEditor.getContent();
			                    //strip the html
			                    txt = txt.replace(/(<([^>]+)>)/ig,"");
			                    txt = txt.replace(/&nbsp;/g,"");
			                    if (txt.length > 255) {
			                          txt = txt.substring(0,255);
			                          tinyMCE.execCommand('mceSetContent',false,txt);
			                          alert('limit');
			                  }
			                });*/
			             }
            });

		
		</script>			
		<div id="wrapper">
            <div id="content">
            	 
            	<form id="form" action="" method="post" enctype="multipart/form-data" >

            		<div class="box">
            			<h3><a class="head" href="#">-</a> Corporate QAR Information</h3>    
            			<div>        			
							<table width="736" border="0" style="width:350px;" id="formtable" >
								<tbody>
	                            	<tr>
	                                	<td width="148"><strong><?=($class=="nodisable")?"Today's Date":"Date Submitted"?>:</strong></td>
	                                    <td width="192"><input type="text" name="todaysdate2" id="todaysdate2" value="<?=($class == 'nodisable' )?date('m/d/Y'):$user2_datesubmitted;?>" readonly="readonly" /></td>
	                                </tr>
	                            	<tr>
	                            	  <td><strong>Reviewed By:</strong></td>
	                            	  <td><input type="text" name="todaysdate3" id="todaysdate3" value="<?=($class == 'nodisable' )?$userinfo[0]->user_firstname.' '.$userinfo[0]->user_lastname:$user2_name;?>" readonly="readonly" /></td>
	                          	  </tr>
	                            	<tr>
	                            	  <td><strong>Evaluator ID:</strong></td>
	                            	  <td><input type="text" name="todaysdate4" id="todaysdate4" value="<?=($class == 'nodisable' )?$disputeInfo[0]->user_qarno:$user2_no;?>" readonly="readonly" /></td>
	                          	  </tr>
	                            </tbody>
							</table>
						</div>
           		    </div>           		     			  	  
			       <br />
			       			                   		
		 		   <div class="box">
		 				<h3><a class="head" href="#">-</a> Disputer Information</h3>                     
		 				<div>
		                	<table width="736" border="0" style="width:700px;" id="formtable" >							
								<tbody>
									<tr>
		                            	<td width="147"><strong>Date Submitted:</strong></td>
	                                  <td width="194"><input type="text" name="todaysdate" id="todaysdate" value="<?=$xdispute_registeredate?>" readonly="readonly" /></td>
	                                  <td width="171"><strong>Evaluation Date:</strong></td>
	                                  <td width="170"><input type="text" name="evaldate" id="evaldate" value="<?=$xevaldate?>" readonly="readonly" /></td>
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
		                            <!-- 
		                            <tr>
		                            	<td><strong>Disputer Contact:</strong></td>
		                                <td><input type="text" name="disputercontacts" id="disputercontacts"  readonly="readonly" value="<?=$disputeInfo[0]->user_ext?>" /></td>
		                                <td><strong>Page # File Name:</strong></td>
		                                <td><input type="text" name="pagenofilename" id="pagenofilename" value="<?=$disputeInfo[0]->pagenofilename?>" readonly="readonly"/> </td>
		                            </tr> -->
		                            <tr>
		                              <td>Disputer Phone:</td>
		                              <td><input type="text" name="disputercontacts" id="disputercontacts"  readonly="readonly" value="<?=$disputeInfo[0]->user_ext?>" /></td>
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
 			  	   </div> 					
				   <br />
					
			       <div class="box">
				   	   <h3><a class="head" href="#">-</a> Dispute History</h3>
					   <div>
						   <table width="980" border="0" >
						   		<tbody>
	                            	<tr>
	                                	<td width="316" style="border: 1px solid #fff">
	                                		<span style="font-weight:bold">Dispute Request Comment( <?=$xdispute_registeredate?> ): </span> 
	                                		<br />	
											<textarea rows="6" name="dispute_comment" id="textarea1" readonly="readonly"  ><?=$disputeInfo[0]->dispute_comment?></textarea>
								 	  		<br />
								 	  		<div>
								 	  			<strong>Section:</strong> <br />
								 	  			<?php echo ul($this->disputes->getSelection_modified($disputeInfo[0]->drpd_id), array('class'=>'sectionlist') );?>				 	  		
								 	  		</div>																						
											<br />
								 	  		Attachment(s):
								 	  		<br/>											
											<?php if( trim($disputeInfo[0]->evalform_attachment) != '' ): ?>
												<!-- <a href="<?=$disputeInfo[0]->evalform_attachment?>" style="text-decoration:underline" ><strong>Evaluation Form Attachment</strong></a> -->
									 	  		<?php 
									 	  			$files1 = explode(';',$disputeInfo[0]->evalform_attachment );
									 	  			foreach( $files1 as $values ):
									 	  				if( trim($values) != ''):
									 	  					$xfname = explode('/',$values);
									 	  		?>			  		
									 	  				<a href="client/download/&xfilename=<?=$values?>" style="text-decoration:underline;font-weight:bold"> <?=(@$xfname[2])?$xfname[2]:$xfname[1]?> </a><br/>
									 	  		<?php 
									 	  				endif;
									 	  			endforeach;
									 	  		?>	
			 			  					<?php else:
				 			  							echo '<b>No Attachment!</b>';
				 			  				  	 endif;	
				 			  				?>											
											<br />                                    
										</td>
											
	                                    <td style="border: 1px solid #fff">&nbsp;</td>
	              					</tr>
	                            	<tr>
	                            	    <td style="border: 1px solid #fff">
						 	  			    <span style="font-weight:bold">Dispute Response( <?=$xcqardispute_date?> ): </span> <br />
				 	  					    <textarea rows="6" name="cqardispute_text" id="textarea2" readonly="readonly"  ><?=$disputeInfo[0]->cqardispute_text?> </textarea>
					 	  					<br>
											<?php 
												$att1 = explode('_',$disputeInfo[0]->cqardispute_attachment);
												if( (trim($disputeInfo[0]->cqardispute_attachment) != '') && ($att1[1] != '') ): 
											?>
				 			  							<a href="<?=$disputeInfo[0]->cqardispute_attachment?>" style="text-decoration:underline;font-weight:bold"> Attachment </a>
				 			  				<?php else:
				 			  							echo '<b>No Attachment!</b>';
				 			  				  	 endif;	
				 			  				?>				 	  					                             
				 	  					</td>
			 			  				                        	 
	                            	    <td style="border: 1px solid #fff">
	                                  		<span style="width:100px;float:left;font-weight:bold">Previous Score:</span> <input type="text" name="todaysdate6" id="todaysdate6" value="<?=$disputeInfo[0]->original_score?>" readonly="readonly" />
	                                        <br />
	                                        <span style="width:100px;float:left;font-weight:bold">New Score: </span><input type="text" name="todaysdate6" id="todaysdate6" value="<?=$disputeInfo[0]->cqarnew_score?>" readonly="readonly" />
	                                  </td>
	                          	  </tr>

	                            </tbody>
							</table>
						</div>
			      </div>			      
			      <br />
			      
	 			  <div class="box">
 			      	<h3><a class="head" href="#">-</a> Re-dispute #1 Response</h3>
 			      	<div>
						<table width="988" border="0"  >
					    	<tbody>
		                        <tr>
		                            <td width="316" style="border: 1px solid #fff">
						 	  			    <span style="font-weight:bold">Re-dispute #1 Request Comment( <?=$xredispute1_date?> ):</span> <br />
				 	  					    <textarea rows="6" name="cqardispute_text" id="textarea3" readonly="readonly" ><?=$disputeInfo[0]->redispute1_text?></textarea>                                      
		                                </td>
		                                 <td width="662" style="border: 1px solid #fff">&nbsp;</td>
		                        </tr>
		                        <tr>
		                            <td width="316" style="border: 1px solid #fff">
						 	  			<span style="font-weight:bold">Re-dispute #1 Response:</span> <br />
				 	  					<textarea rows="6" name="cqarredispute1_text" id="<?=$class;?>" ><?=$disputeInfo[0]->cqarredispute1_text?></textarea>                                      
							 	  		<br />				 	  		
							 	  		<?php if( $class != 'inputdisable'): ?> 
					 			  		<b>Attachment</b><input type="file" name="form_attachment" id="form_attachment" tabindex="8" />
					 			  		<?php else:
					 			  				$att2 = explode('_',$disputeInfo[0]->cqarredispute1_attachment);
					 			  				if( (trim($disputeInfo[0]->cqarredispute1_attachment) != '') && ($att2[1] != '')  ):
					 			  		?>
					 			  					<a href="<?=$disputeInfo[0]->cqarredispute1_attachment?>" style="text-decoration:underline;font-weight:bold"> Attachment </a>
					 			  			<?php else:
					 			  					echo '<b>No Attachement!</b>';
					 			  				  endif;	
					 			  			?>			
					 			  		<?php endif; ?>			                            
		                           </td>
		                            <td width="662" style="border: 1px solid #fff">&nbsp;</td>
		                        </tr>                        	
	                        </tbody>
						</table> 
					</div>			    	 			    	   		          			   
 			      </div>  
 			      <br/>
 			      
	 			  <div class="box">
 			      	<h3><a class="head" href="#">-</a> Score</h3>
 			      	<div>
						<table width="736" border="0" style="width:350px;" id="formtable" >
							<tbody>
                            	<tr>
                                	<td width="148"><strong>Score:</strong></td>
                                    <td width="192">
                                    	<select id="change_score" name="change_score"  class="<?=$class1;?>">
                                    		<option value="0" <?=($disputeInfo[0]->cqarnew_score2_changed == 0)?'selected="selected"':""?>>Change Score</option>
                                    		<option value="1" <?=($disputeInfo[0]->cqarnew_score2_changed == 1)?'selected="selected"':""?>>Score Remains the same</option>
                                    	</select>
                                    </td>
                                </tr>
                            	<tr id="new_score_box" >
                            	  <td><strong>New Score:</strong></td>
                            	  <td>                            	  			
                            	  	 <input type="text" name="new_score" id="new_score" value="<?=$disputeInfo[0]->cqarnew_score2?>"  class="<?=$class?>"/>
                            	  </td>
                          	  </tr>
                            </tbody>
						</table> 			    	
 			    	 </div>
			   		 <br/><br/>
			   		 <?php if( $class != 'inputdisable'):?>
			   		 <input class="button" type="reset" name="reset" value="Clear Form" />			   		 			   		 
			   		 <input class="button" type="submit" name="submit" id="save" value="Save" />
			   		 <?php endif; ?>
			   		 <input class="button" type="button" name="cancel" value="Cancel" onclick="javascript:history.go(-1)"/> 			    	
 			     </div>
 			       	 			    
			   </form>         	 
               <p>&nbsp;</p>
               <p>&nbsp;</p>
            </div>
        </div>
        
        <script>

    	$("#form").submit( function(){
        	
    		var val 	= jQuery.trim($("#new_score").val());
    		
    		var iscon = true;
    		
    		if( (val == '0' || val == '') && ($("#change_score :selected").val() == 0) ){

				scfrm = confirm("Score is Zero or Empty please verify");

				if( !scfrm )
					iscon = false;
				$("#new_score").val(val);		
			}
			if( iscon ){
				xcfrm = confirm("Do you want to save?");	
	
				if( xcfrm ){
					return true;
				}	
			}
        	return false;
    	});

    	$("#change_score").change( function (){
        	
        	val = $("#change_score").val();
        	
        	if( val == '0' ){
        		$("#new_score_box").css('display','block');	
        	}else{
        		$("#new_score_box").css('display','none');	
        	}

    	})
        
        
        $(document).ready( function() {

			$('.inputdisable').attr("readonly", true);
			$('.selectdisable').attr("disabled", true);
        		
			$('.head').click( function() {
				
				$(this).parent().next().toggle('fast');
				if( $(this).text() == '-' ){
					$(this).text('+');
				}else{
					$(this).text('-');
				}
				
				return false;
			})             
        })
        
        </script>