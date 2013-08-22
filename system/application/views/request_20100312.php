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
      
      	<link type="text/css" href="package/jquery/css/start/start.css" rel="stylesheet" />
		<script type="text/javascript" src="package/jquery/ui.core.js"></script>
		<script type="text/javascript" src="package/jquery/ui.datepicker.js"></script>
		
		<link rel="stylesheet" href="package/jquery/tooltip/css/jquery.tooltip.css" />
		<script type="text/javascript" src="package/jquery/jquery.bgiframe.js" ></script>
		<script type="text/javascript" src="package/jquery/jquery.dimensions.js" ></script>
		<script type="text/javascript" src="package/jquery/tooltip/jquery.tooltip.js" ></script>
		<script type="text/javascript" src="package/jquery/chili-1.7.pack.js" ></script>
				
		<script type="text/javascript" src="package/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
		<script>
			
			tinyMCE.init({
			    mode : "textareas",
			    theme : "advanced",
			    theme_advanced_buttons1 : "spellchecker,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo",
			    theme_advanced_buttons2 : "",
			    theme_advanced_buttons3 : "",
			    theme_advanced_toolbar_location : "top",
			    theme_advanced_toolbar_align : "left",
			    theme_advanced_statusbar_location : "bottom",
				plugins : 'inlinepopups,spellchecker',
			                setup : function(ed) {
			                ed.onKeyUp.add(function(ed, e) {
			                    txt = tinyMCE.activeEditor.getContent();
			                    //strip the html
			                    txt = txt.replace(/(<([^>]+)>)/ig,"");
			                    txt = txt.replace(/&nbsp;/g,"");
			                    if (txt.length > 255) {
			                          txt = txt.substring(0,255);
			                          tinyMCE.execCommand('mceSetContent',false,txt);
			                          alert('limit');
			                  }
			                });
			             }
            });


			
			$(function() {
				
				$("#evaldate").datepicker( { showOn: 'button',
											 buttonImageOnly: true, 
											 buttonImage: 'package/jquery/calendar.gif'} );
				 
			});
			
		
		</script>
		<div id="wrapper">
            <div id="content">
            	
            	<div class="error"> <?php echo validation_errors(); ?></div>
            	
            	<form id="form" action="client/request/" method="post" enctype="multipart/form-data" >
		 			<div class="box">
		 				<h3>Dispute Information</h3>                     
	                	<table width="736" border="0" style="width:700px;" id="formtable" >
							
							<tbody>
								<tr>
	                            	<td width="114"><strong>Today's Date:</strong></td>
	                                <td width="182"><input type="text" name="todaysdate" id="todaysdate" value="<?=date('m/d/Y')?>" readonly="readonly" /></td>
	                                <td width="175"><strong>Evaluation Date:<span style="color:red;font-weight:bold;font-size:18px;padding-left:10px">*</span></strong></td>
	                                <td width="211"><input type="text" name="evaldate" id="evaldate" readonly="readonly" value="<?=set_value('evaldate')?>" tabindex="1"/> 
	                                	<span id="notes">
	                                		<a href="javascript:void(0)" title="For evaluations completed on Friday, Saturday and Sunday, the system will only allow the center to submit the dispute up until Monday.  The cutoff is Tuesday" style="color:red"> *Note</a> 
	                                	</span>
	                                </td>
							  </tr>
								<tr>
	                            	<td><strong>Center:</strong></td>
	                            	<td><input type="text" name="center" id="center" readonly="readonly" value="<?=$userinfo[0]->center_desc?>" /></td>
	                                <td><strong>Audit Contact Number:<span style="color:red;font-weight:bold;font-size:18px;padding-left:10px">*</span></strong></td>
	                                <td><input type="text" name="auditcontno" id="auditcontno" value="<?=set_value('auditcontno')?>" tabindex="2"/></td>
								</tr>
								<tr>
	                            	<td><strong>Disputer Name:</strong></td>
	                                <td><input type="text" name="todaysdate" id="disputername" readonly="readonly" value="<?=$userinfo[0]->user_firstname.' '.$userinfo[0]->user_lastname?>"/></td>
	                                <td><strong>Agent Name:<span style="color:red;font-weight:bold;font-size:18px;padding-left:10px">*</span></strong></td>
	                                <td><input type="text" name="agentname" id="agentname" value="<?=set_value('agentname')?>" tabindex="3" /> </td>
								</tr>
								<tr>
	                            	<td><strong>Disputer Email:</strong></td>
	                                <td><input type="text" name="disputeremail" id="disputeremail" readonly="readonly" value="<?=$userinfo[0]->user_email?>" /></td>
	                                <td><strong>Login ID:<span style="color:red;font-weight:bold;font-size:18px;padding-left:10px">*</span></strong></td>
	                                <td><input type="text" name="login_id" id="login_id" value="<?=set_value('login_id')?>" tabindex="4" /> </td>
								</tr>
	                            <tr>
	                            	<td><strong>Disputer Phone:</strong></td>
	                                <td><input type="text" name="disputercontacts" id="disputercontacts"  readonly="readonly" value="<?=$userinfo[0]->user_ext?>" /></td>
	                                <td><strong>Original Score:<span style="color:red;font-weight:bold;font-size:18px;padding-left:10px">*</span></strong></td>
	                                <td><input type="text" name="original_score" id="original_score" value="<?=set_value('original_score')?>" tabindex="6" /></td>
	                            </tr>
	                            <tr>
	                              <td>&nbsp;</td>
	                              <td>&nbsp;</td>
	                              <td></td>
	                              <td></td>
                              </tr>
                              
							</tbody>
						</table>
	                   	 			
 			  	  </div> 
	 			    <br />
	 			  	<div class="box">
	 			  		<h3>Dispute Request</h3>
	 			  		<div style="padding:5px">
	 			  			<b>Dispute Request Comments<span style="color:red;font-weight:bold;font-size:18px;padding-left:10px">*</span></b>
	 			  			<br/><br/>
		 			  		<textarea rows="6" name="dispute_comment" id="dispute_comment" tabindex="7"><?=set_value('dispute_comment')?></textarea>
		 			  				  		
		 			  		<b>Form Attachment<span style="color:red;font-weight:bold;font-size:18px;padding-left:10px">*</span></b>
		 			  		<div class="mUpload"> 
		 			  			<input type="file" name="fileX[]" id="element_input" class="upload" tabindex="8" />
		 			  		</div>	
		 			  		<br/><br/>
		 			  		<input class="button" type="reset" name="reset" value="Clear Form" />
		 			  		<input class="button" type="submit" name="submit" id="save" value="Save" tabindex="9"/>
		 			  		<input class="button" type="button" name="cancel" value="Cancel" onclick="javascript:history.go(-1)" />

	 			  		</div>
	 			    </div> 
			   </form>         	 
               <p>&nbsp;</p>
               <p>&nbsp;</p>
            </div>
        </div>
        
        <script>

    	$("#form").submit( function(){

    		/*if( $("#original_score").val() == '' ){
        		alert("* Score must be Numeric");
    		}else{*/
        		
				xcfrm = confirm("Do you want to save?");	
	
				if( xcfrm ){
					return true;
				}	
    		//}
        	return false;
    	});

		//tooltip for remarks
		$(function() {
						
			$('#notes a').tooltip({
				track: true,
				delay: 0,
				showURL: false,
				showBody: " - ",
				fade: 250
			});
		});    

		$(document).ready(function(){	
			//var fileMax = 3;
			
			$('.mUpload').after('<div id="files_list" style="border:1px solid #d9e6f0;padding:5px;background:#f3f9ff;font-weight:bold; width:500px"><strong><u>Attachment List:</u></strong></div>');
			$("input.upload").change(function(){
			doIt(this);
			});
		
		});

		function doIt(obj) {
			//if($('input.upload').size() > fm) {alert('Max files is '+fm); obj.value='';return true;}
			
			$(obj).hide();
			$(obj).parent().prepend('<input type="file" class="upload" name="fileX[]" />').find("input").change(function() {doIt(this)});
			var v = obj.value;
			if(v != '') {
				$("div#files_list").append('<div>'+v+'<input type="button" class="remove button" value="Delete" /></div>').find("input").click(function(){
					$(this).parent().remove();
					$(obj).remove();
					return true;
				});
			}

		};
        </script>