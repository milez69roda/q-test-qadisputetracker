	
        <div id="wrapper">
            <div id="content">
            	<form id="form" action="<?=$action?>" method="post">
					<div class="box">
						<h3><?=$title?></h3>
							<?php echo $this->validation->error_string; ?>
							<?php echo form_open('form'); ?>
							<table id="formtable">
								<tr>
									<td style="width:50%;">
										<table id="formtable" style="width:430px;font-weight:bold;">
											<tr>
												<td width="60%">Access Type : </td>
												<td>
													<?php echo form_dropdown('dpAccess', $selaccess,(!empty($dpaccess)?$dpaccess:''));?>
												</td>
											</tr>
											<tr>
												<td >Username : </td>
												<td>
													<input type="text" name="txtusername" <?=$title=='Update Account'?'readonly="true"':''?> value="<?=$this->validation->txtusername?>" />
												</td>
											</tr>
											<tr>
												<td >Password : </td>
												<td>
													<input type="text" name="txtpassword" value="<?=$this->validation->txtpassword?>" />
												</td>
											</tr>
											<tr>
												<td >Avaya Login : </td>
												<td>
													<input type="text" name="txtavaya" value="<?=$this->validation->txtavaya?>" />
												</td>
											</tr>
											<tr>
												<td >QAR # : </td>
												<td>
													<input type="text" name="txtqar" value="<?=$this->validation->txtqar?>" />
												</td>
											</tr>
											<tr>
												<td >First Name : </td>
												<td>
													<input type="text" name="txtfirstname" value="<?=$this->validation->txtfirstname?>" />
												</td>
											</tr>
											<tr>
												<td >Last Name : </td>
												<td>
													<input type="text" name="txtlastname" value="<?=$this->validation->txtlastname?>" />
												</td>
											</tr>
										</table>
									</td>
									<td valign="top">
										<table id="formtable" style="width:300px;font-weight:bold;">
											
											<tr>
												<td width="30%">Email : </td>
												<td>
													<input type="text" name="txtemail" value="<?=$this->validation->txtemail?>" />
												</td>
											</tr>
											<tr>
												<td width="30%">Contact Ext. : </td>
												<td>
													<input type="text" name="txtext" value="<?=$this->validation->txtext?>" />
												</td>
											</tr>
											
											<tr>
												<td width="30%">Center : </td>
												<td>
													<?php echo form_dropdown('dpcenters', $selcenter,(!empty($dpcenters)?$dpcenters:'')); ?>
												</td>
											</tr>
											<tr >
												<td colspan="2" style="padding-top:30px;">
													<input class="button" type="submit" name="btnsub" id="btnsub" value="Save" style="width:90px"/>&nbsp;&nbsp;&nbsp;&nbsp;
													<input class="button" onclick="window.location='<?=base_url()?>manageaccounts/accountlist/'" type="button" name="btncancel" value="Cancel" style="width:90px"/>
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