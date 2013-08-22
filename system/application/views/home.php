        <!-- <div id="top-panel">
            <div id="panel">
                <ul>
                    <li><a href="#" class="report">Sales Report</a></li>
                    <li><a href="#" class="report_seo">SEO Report</a></li>
                    <li><a href="#" class="search">Search</a></li>
                    <li><a href="#" class="feed">RSS Feed</a></li>
                </ul>
            </div> 
      </div>-->
        <div id="wrapper">
            <div id="content">
            	<div class='box'>
            		<h3><?=date("F j, Y, g:i a");?></h3>
            		<p style="font-weight:bold;padding:10px 2px; font-size:20px">Welcome, </p>
            		<div class="homebg">
            			<br />
	            		<p style="padding-left:28px">
	            			<?=$userInfo[0]->user_firstname.' '.$userInfo[0]->user_lastname ?>
	            			<br>
	            			<?=$userInfo[0]->access_name?>
	            		</p>
	            		<br />
	                </div>
	                <p>&nbsp;</p>	    
            	</div>            	
            </div>
        </div>