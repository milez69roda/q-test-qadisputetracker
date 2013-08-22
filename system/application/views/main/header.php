<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Quality Assurance Dispute Tracker</title>
<base href="<?=base_url()?>"/>

<link rel="stylesheet" type="text/css" href="css/theme.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/theme1.css" />

<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->

<!--[if IE 8]> 
	<style>
		#topmenu{
			margin-top:0px;
		}
	</style>
<![endif]-->

<script type="text/javascript" src="package/jquery/jquery-1.3.2.min.js" ></script>
</head>

<body>
	<div id="container">
    	<div id="header">
          	<div style="padding-top:2px;color:#fff;height:73px ">
				<div style="text-align:right;">
				<?php if( $this->session->userdata('DX_logged_in') ): ?>
					<a style="color:#fff; padding:0px 5px; text-decoration:underline" href="manageaccounts/myaccount/">My Account</a> 
					<strong><?php echo $this->session->userdata('DX_firstname').' '.$this->session->userdata('DX_lastname'); ?></strong> ( <a id="logoutlink" href="user/logout" style="color:#fff;text-decoration:underline">Logout</a> )										
				<?php endif; ?>	
				</div>
				<div style="">
					<h2>Quality Assurance Dispute Tracker</h2>
				</div>
          	</div>	
          
       <?php  if( $this->session->userdata('DX_logged_in') ): ?>   
          <div id="topmenu">
          		<?php 
          			$currentPage = $this->uri->segment(2);     
          			$tabname	 = "Dispute/Re-Disputes List";    
          			//echo $currentPage; 		
          		?>
            	<ul>                	
                	<li <?php if( $currentPage == "home" || $currentPage == "myaccount" ) echo 'class="current"';?> ><a href="client/home">Home</a></li>
                	
          			<?php if( $this->session->userdata('DX_access_id') == 1 ): ?>
                    	<li <?php if( $currentPage == "request" ) echo 'class="current"';?> ><a href="client/request/">Dispute Request</a></li>
                	<?php endif; ?>
                	
                	<?php 
                		$access = $this->session->userdata('DX_access_id');	
                		$listpage = '';
                		$currentlistpage = ( $currentPage == "list1" || $currentPage == "list2" || $currentPage == "list3" || $currentPage == "list4" || $currentPage == "response" || $currentPage == "redispute1" || $currentPage == "redispute2" || $currentPage == "redispute1response" || $currentPage == "redispute21response" || $currentPage == "redispute22response" )?'current':'';
                		switch( $access ){	
                		
							case 1:
								$listpage = 'list1';
								break;
							case 2:
								$listpage = 'list2';
								break;
							case 3:
								$listpage = 'list3';
								$tabname = 'Re-Dispute List #2';
								break;
							case 4:
								$listpage = 'list4';
								break;
																
                		};
                	?>
                	
                	<li class="<?=$currentlistpage?>" ><a href="client/<?=$listpage?>/"><?=$tabname?></a></li>
                    <?php if( $this->session->userdata('DX_access_id') == 4): ?>
                    	<li <?php if( $currentPage == "accountlist" || $currentPage == "accountsearch" || $currentPage == "edituser" || $currentPage == "createuser" ) echo 'class="current"';?>><a href="manageaccounts/accountlist">Manage Accounts</a></li>
                    	<li <?php if( $currentPage == "report" ) echo 'class="current"';?>><a href="client/report">Report</a></li>
                    <?php endif;?>                    
              </ul>
          </div>
        <?php endif; ?> 
      </div>