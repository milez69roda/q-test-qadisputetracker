        
        <div id="textWarning">
        	<!--<span>Successfully Sent!</span>-->
        </div>
        <!-- //textWarning -->
        <style type="text/css">
			#formtable td{
				font-size:16px;
			
			}	
			/*tbody, tfoot, thead, tr, th, td {padding:3px;border:1px solid transparent}
			input.txtbut{font-size:20px;padding:3px;width:95%;}
			label.txtlabel{font-size:20px;}
			input.frmbutt{padding:3px;font-weight:bold;margin:0;border:1px solid #ccc;} */
        </style>
        <div id="containerHolder">
			<div id="container" style="background-image:none;position:relative;overflow:hidden;text-align:center;">
				<div id="box">
					<div style="border:1px solid #ccc;width:300px;margin:50px auto;text-align:left;padding:15px;">
						<?php echo $this->dx_auth->get_auth_error();?>
						<?php 
							$attributes = array('class' => 'form', 'id' => 'form');
						
							echo form_open($this->uri->uri_string(),$attributes);
						?>
							<table  width="300" id="formtable">
								<tr>
									<td width="60"><strong>Username :</strong></td>
									<td width="100" ><input  type="text" name="user_name" value="" /></td>
								</tr>
								<tr valign="middle" >
									<td><strong>Password :</strong></td>
									<td><input  type="password" name="user_password" value="" /></td>
								</tr>
								<tr >
									<td>&nbsp;</td>
									<td align="left">
										<input type="submit" class="button" name="btnsubmit" value="Login" width="60" />
									</td>
								</tr>
							</table>
						<?php echo form_close()?>
					</div>
				</div>	
            </div>
            <!-- // #container -->
        </div>	
        <!-- // #containerHolder -->