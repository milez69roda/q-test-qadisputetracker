	
        <div id="wrapper">
            <div id="content">
            	<form id="form" action="" method="post">
					<div class="box">
						<h3>My Account Info</h3>
							
							<?php echo form_open('form'); ?>
							<table id="formtable">
								<tr>
									<td style="width:50%;">
										<table id="formtable" class="formtableaddheight" style="width:430px;">
											<tr>
												<td width="100px" style="font-weight:bold;">Access Type : </td>
												<td>
													<!-- <input type="text" name="txtaccesstype" readonly="readonly" value="" style="width:250px"/> -->
													<?=$userInfo[0]->access_name?>
												</td>
											</tr>
											<tr>
												<td style="font-weight:bold;">Username : </td>
												<td>
													<!-- <input type="text" name="txtusername" readonly="readonly" value="" /> -->
													<?=$userInfo[0]->user_name?>
												</td>
											</tr>
											<tr>
												<td style="font-weight:bold;">Password : </td>
												<td>
													<input type="text" name="txtpassword" id="txtpassword" readonly="readonly" maxlength="15" value="<?=$userInfo[0]->user_password?>" /> 
													
												</td>
											</tr>
											<tr>
												<td style="font-weight:bold;">Avaya Login : </td>
												<td>
													<!-- <input type="text" name="txtavaya" readonly="readonly" value="" /> -->
													<?=$userInfo[0]->user_avaya?>
												</td>
											</tr>
											<tr>
												<td style="font-weight:bold;">QAR # : </td>
												<td>
													<!-- <input type="text" name="txtqar" readonly="readonly" value="" /> -->
													<?=$userInfo[0]->user_qarno?>
												</td>
											</tr>
											<tr>
												<td style="font-weight:bold;">First Name : </td>
												<td>
													<!-- <input type="text" name="txtfirstname" readonly="readonly" value="" /> -->
													<?=$userInfo[0]->user_firstname?>
												</td>
											</tr>
											<tr>
												<td style="font-weight:bold;">Last Name : </td>
												<td>
													<!-- <input type="text" name="txtlastname" readonly="readonly" value="" /> -->
													<?=$userInfo[0]->user_lastname?>
												</td>
											</tr>
										</table>
									</td>
									<td valign="top">
										<table id="formtable" class="formtableaddheight" style="width:300px;">
											
											<tr>
												<td width="30%" style="font-weight:bold;">Email : </td>
												<td>
													<!-- <input type="text" name="txtemail" readonly="readonly" value="" /> -->
													<?=$userInfo[0]->user_email?>
												</td>
											</tr>
											<tr>
												<td width="30%" style="font-weight:bold;">Contact Ext. : </td>
												<td>
													<!-- <input type="text" name="txtext" readonly="readonly" value="" /> -->
													<?=$userInfo[0]->user_ext?>
												</td>
											</tr>
											
											<tr>
												<td width="30%" style="font-weight:bold;">Center : </td>
												<td>
													<!-- <input type="text" name="txtcenter" readonly="readonly" value="" /> -->
													<?=$userInfo[0]->center_desc?>
												</td>
											</tr>
											<tr >
												<td colspan="2" style="padding-top:30px;">
													<input class="button" type="button" name="btnchangepass" id="btnchangepass" value="Change Password" style="width:150px" />
													<input class="button" type="submit" name="btnsub" id="btnsub" value="Save" style="display:none; width:90px" />
													<input class="button" type="button" name="btncancel"  value="Cancel" onclick="javascript:history.go(-1)" style="width:90px"/>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
					</div>
                </form>	
            </div>
        </div>
        
        <script>

    		$("#btnchangepass").click( function(){
				$("#btnsub").show();
				$("#btnchangepass").hide();	   
				$("#txtpassword").removeAttr("readonly");     		
    		});

    		$("#btnsub").click( function(){

    				
				 xconf = confirm("Do you want to change your password?");

				 if( xconf ){
					 return true;
				 }else{
					 window.location = "<?=base_url()?>manageaccounts/myaccount/";
					 return false;
				 }

				 return false;	 
        		
    		})
    		
        </script>