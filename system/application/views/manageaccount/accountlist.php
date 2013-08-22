	
        <div id="wrapper">
            <div id="content">
            
				<form name="frmsearch" id="form" method="get" action="manageaccounts/accountsearch/" >
					<table style="width:520px;">
						<tr >
							<td style="border:none;width:50px;" valign="middle">
								<span style="font-weight:bold;">Search : <span>
							</td>
							<td style="border:none;" valign="middle">
								<input type="hidden" name="fsub" value="true">
								<input type="text" name="keyword" value="<?=(empty($keyword)?'':$keyword)?>" />
							</td>
							<td style="border:none;" valign="middle">
								<span style="font-weight:bold;">by</span>&nbsp;&nbsp;
								<select name="typsel">
									<option value="user_name" <?=( isset($_GET["typsel"]) && ( $_GET["typsel"] == 'user_name') )?'selected="selected"':"";?> >Username</option>
									<option value="user_avaya" <?=( isset($_GET["typsel"]) && ( $_GET["typsel"] == 'user_avaya') )?'selected="selected"':"";?> >Avaya</option>
									<option value="user_qarno" <?=( isset($_GET["typsel"]) && ( $_GET["typsel"] == 'user_qarno') )?'selected="selected"':"";?> >QAR #</option>
									<option value="user_firstname" <?=( isset($_GET["typsel"]) && ( $_GET["typsel"] == 'user_firstname') )?'selected="selected"':"";?> >First Name</option>
									<option value="user_lastname" <?=( isset($_GET["typsel"]) && ( $_GET["typsel"] == 'user_lastname') )?'selected="selected"':"";?> >Last Name</option>
									<option value="user_email" <?=( isset($_GET["typsel"]) && ( $_GET["typsel"] == 'user_email') )?'selected="selected"':"";?> >Email</option>
									<option value="user_ext" <?=( isset($_GET["typsel"]) && ( $_GET["typsel"] == 'user_ext') )?'selected="selected"':"";?> >Contact Ext #.</option>
									<option value="center_id" <?=( isset($_GET["typsel"]) && ( $_GET["typsel"] == 'center_id') )?'selected="selected"':"";?> >Center</option>
								</select>
							</td>
							<td style="border:none;" valign="middle">
								<input type="button" class="button" onclick="document.frmsearch.submit()" name="frmsearchsub" style="font-weight:bold;" value="Search" />
								<input type="button" class="button" onclick="window.location='<?=base_url()?>manageaccounts/accountlist/'" name="clear" style="font-weight:bold;" value="Clear" />
							</td>
						</tr>
					</table>
				</form>
				
            	<form id="form" action="" method="post">            	
	                <div class="box">						
						<h3>User List</h3>
	                	<table  border="1">
	                    	<thead>
	                        	<tr>
	                            	<th>Username</th>
	                                <th>Password</th>
	                                <th>Avaya</th>
	                                <th>QAR #</th>
	                                <th>Access</th>
	                                <th>Center</th>
	                                <th>Name</th>
	                                <!-- <th>Requester</th> -->
	                                <th width="2%">Action</th>
	                            </tr>	
	                        </thead>
	                        <tbody>
	                        	<?php 
								foreach($accountlist as $row){ 
								?>
	                        	<tr>
	                            	<td><?=$row->user_name?></td>
	                            	<td><?=$row->user_password?></td>
	                            	<td align="center"><?=$row->user_avaya?></td>
	                            	<td align="center"><?=$row->user_qarno?></td>
	                            	<td><?=$row->access_name?></td>
	                            	<td><?=$row->center_desc?></td>
	                            	<td><?= $row->user_firstname ." ".$row->user_lastname?></td>
	                            	<!-- <td><?=$row->user_registeredby?></td> -->
	                                <td align="center"><a href="manageaccounts/edituser/<?=$row->user_name?>">edit</a></td>
	                            </tr>
	                            <?php 
								}
								?>
	                        </tbody>
	                    </table>
						<?=$pages?>
	                </div>
	                
                </form>
            </div>
        </div>
        
        
        
        