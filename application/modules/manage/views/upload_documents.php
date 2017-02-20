<script src="<?php echo base_url()?>assets/front/js/jquery-ui.js"></script>
<link href="<?php echo base_url()?>assets/front/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>
<script type="text/javascript" language="javascript">
	$(document).ready(function(){	

		<?php if(validation_errors() =="") {?>
			$(".requirederror").css("display","none");
			<?php } ?>

			<?php if(($utype_id ==3 || $utype_id ==4 || $utype_id ==5) ){?>
				$('input,textarea').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('readonly', true);
    });
				
				$('input[type=file]').attr('disabled', true);
				
				$("#period_to_month").datepicker({minDate:-1,maxDate:-2}).attr('readonly','readonly');
				$("#period_from_month").datepicker({minDate:-1,maxDate:-2}).attr('readonly','readonly');
				
				$('.btn').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('disabled', true);
        //$(this).rules('remove');
    });
				
				$('select').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('disabled', true);  
    });
				
				$(".pull-right").hide();
				$(".from_month").attr('disabled', true);
				$(".to_month").attr('disabled', true);	
				<?php } ?>


				<?php if( (!empty($bank_application))){?>
					$('input,textarea').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('readonly', true);

    });
					
					$('select').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('disabled', true);
    });
					$('input[type=file]').attr('disabled', true);
					$('.btn').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('disabled', true);
        //$(this).rules('remove');
    });
					$("#submit_btn").attr("disabled",true);
					$("#add_more").hide();
					<?php } ?>


					

					$('input[type=file]').on("change", function(){
	//alert(this.files[0].size);
	var fileNm=$(this).val();
	var ext = $(this).val().split('.').pop().toLowerCase();		
	var file_size = $(this)[0].files[0].size;
	var extall=[];
	var file_size_all=[];
	
	
	
	//var ext = $(this).val();
	//console.log();
	//alert(ext);
	if(ext!=""){
		if($.inArray(ext, ['jpg','jpeg','pdf']) == -1) {
			<?php if(!empty($application_id) && empty($upload_documents)){?>
				$(this).parent(".btn-primary").next("span").html("Invalid extension!");
				<?php } else {?>
					$(this).parent(".btn-primary").next("a").find("span").html("Invalid extension!");
					<?php } ?>
			//return false;
		}
		else{
			if(file_size>2000000) {
				<?php if(!empty($application_id) && empty($upload_documents)){?>
					$(this).parent(".btn-primary").next("span").html("File size is greater than 2MB");
					<?php } else {?>
						$(this).parent(".btn-primary").next("a").find("span").html("File size is greater than 2MB");
						<?php } ?>
				//return false;
			}
			else{
				<?php if(!empty($application_id) && empty($upload_documents)){?>
					$(this).parent(".btn-primary").next("span").html(fileNm);
					<?php } else {?>
						$(this).parent(".btn-primary").next("a").find("span").html(fileNm);
						<?php } ?>
					}
				}
			}   
			
			$(this).parents('form').find('input[type=file]').each(function(e){
				<?php if(!empty($application_id) && empty($upload_documents)){?>
					var exteach=$(this).parent('label').next('span').html().split('.').pop().toLowerCase();
					<?php } else {?>
						var exteach=$(this).parent('label').next('a').find('span').html().split('.').pop().toLowerCase();
						<?php } ?>
						
						if($.trim($(this).parent('label').next('a').find('span').html())!=''){
							if(exteach=='jpg' || exteach=='jpeg' || exteach=='pdf'){
								extall.push('yes');
							}
							else{
								extall.push('no');
							}
						}	
						
						if($.trim($(this).parent('label').next('span').html())!=''){
							if(exteach=='jpg' || exteach=='jpeg' || exteach=='pdf'){
								extall.push('yes');
							}
							else{
								extall.push('no');
							}
						}
		/*if(file_size_each>2000000) {
			file_size_all.push('no');
		}
		else{
			file_size_all.push('yes');
		}*/
	});
			
			if(extall.indexOf('no')>-1){
				$('#submit_btn').attr('disabled','disabled');
			}
			else{
				$('#submit_btn').removeAttr('disabled');
			}
			
		});




					$("#cancel_btn").click(function(){
						window.location.href='<?php echo base_url();?>manage/dashboard';
					});
					
					
					
					$('#state').change(function () {
						var selState = $(this).val();
						$.ajax({   
							url: "<?php echo base_url() ?>home/ajax_call/"+selState, 
							async: false,
							type: "POST", 
							data: "city="+selState, 
							dataType: "html", 
							
							
							success: function(data) {
                        //console.log(data);
                        $('#city').html(data);
                        
                    }
                })
					});
					
					var v = $("#hold_frm").validate({
						rules:{					
							'bank_name[]': {
								required: true
							},
							'add_additional_documents_text1': {
								required: true
							},
							'period_to_month[]': {
								required: true
							},
							'period_from_month[]': {
								required: true
							},
							'upload_file[]': {
								required: true
							},
							'pan_card1[]': {
								required: true
							},
							'address_proof1[]': {
								required: true
							},
							'pan_card':{required:true},
							'address_proof_company':{required:true}

						}
					});	
					
					
					var add_additional_documents = $("#add_additional_documents").val();
					if(add_additional_documents == 0 || add_additional_documents == "")
					{
				  //$("#text1").html("");
				  $("#text2").html("");
				}
				
				
				$("#add_additional_documents").change(function() {
					
					var add_additional_documents = $(this).val();
			  //alert(add_additional_documents);
			  if(add_additional_documents == 0)
			  {
				  //$("#text1").html("");
				  $("#text2").html("");
				  $("#cont_details_brows").html("");
				}
				if(add_additional_documents == 1)
				{
				  //$("#text1").html('<div class="col-sm-5 top-margin20"><input type="text" name="add_additional_documents_text1" id="add_additional_documents_text1" class="module-input"></div><div class="col-sm-3 top-margin20"><label class="btn btn-primary yellow-button"><input type="file" name="add_additional_documents_file1" id="add_additional_documents_file1" style="display:none;" onchange="$(\'#upload-file-info8\').html($(this).val());">BROWSE FILE</label><span class="label label-info" id="upload-file-info8"></span></div>');
				  $("#text2").html('<div class="col-sm-5"><input type="text" name="add_additional_documents_text2[]" id="add_additional_documents_text2" class="module-input"></div><div class="col-sm-3 bottom-margin20"><label class="btn btn-primary yellow-button"><input type="file" name="add_additional_documents_file2[]" id="add_additional_documents_file2" style="display:none;" onchange="$(\'#upload-file-info9\').html($(this).val());">BROWSE FILE</label><span class="label label-info" id="upload-file-info9"></span></div><div class="col-sm-4"><button id="add_more" style="width:150px;" class="yellow-button top-margin10 ad_btn pull-right" type="button" onclick="addFles()"><span class="big-text">Add More</span> &nbsp;&nbsp;<i aria-hidden="true" class="fa fa-plus-circle"></i></button></div>');				  
				}
				

			});
				
				
				
				/* $('.upld_doc').on("change",function () {

                var fileExtension = ['jpeg', 'jpg'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    // alert("Only '.jpeg','.jpg' formats are allowed.");
                    //$('#spanFileName').html(this.value);
                    $('#spanFileName').html("Only '.jpeg','.jpg' formats are allowed.");
					$("#submit_btn").attr("disabled","disabled");
                }
                else {
                    //$('#spanFileName').html(this.value);
                    $('#spanFileName').html("");
                   //do what ever you want
				   $("#submit_btn").removeAttr("disabled","disabled");
                } 
            })  */
            
            
            $('form#hold_frm').bind('submit',function(){
            	if(v.form()){
            		var formerror=[];
            		$('#text2 input[type=text]').each(function(){
            			if($(this).val()==''){
            				$(this).parents('.miw').append('<label class="error">This field is required.</label>');
            				formerror.push('no');
            			}
            		});
            		$('#text2 span.label.label-info').each(function(){
            			if($(this).html()==''){
            				$(this).parents('.miw').append('<label class="error">This field is required.</label>');
            				formerror.push('no');
            			}
            		});
            		$('.addnewfrst span.label.label-info').each(function(){
            			if($(this).html()==''){
            				$(this).parents('.up_file').append('<label class="error">This field is required.</label>');
            				formerror.push('no');
            			}
            		});
            		$('.addnewfrst1 span.label.label-info').each(function(){
            			if($(this).html()==''){
            				$(this).parents('.test').append('<label class="error">This field is required.</label>');
            				formerror.push('no');
            			}
            		}); 
            		$('.mixed .kyc span.label.label-info').each(function(){
            			if($(this).html()==''){							
            				$(this).parents('.kyc').append('<label class="error">This field is required.</label>');					
            				formerror.push('no');
            			}
            		}); 
            		
            		$('#cont_details_brows input:not([type=hidden])').each(function(){
            			if($(this).val()==''){
            				$(this).parents('.miw').append('<label class="error">This field is required.</label>');
            				formerror.push('no');
            			}
            		});
            		$('.bank_cont_seprt input[type=text]').each(function(){
            			if($(this).val()==''){
            				$(this).parent('div').append('<label class="error">This field is required.</label>');
            				formerror.push('no');
            			}
            		});
            		
            		if(formerror.length>0){
            			return false;
            		}
            	}
            });
            
            
        });

		/* function validate() {
				var count = $(".upld_doc_owner").length;
				var index = 0;
				$(".upld_doc_owner").each(function () {
					var files = $(this).val();

					if (files == '') {
						alert("All owner files details is required");
						return false;
					}

					index += 1;
				});

			if (index != count) { //If the validation in .each() looping has returned false
				return false;
			}
		} */
		
		
		<?php $cal_date=date('Y-m-d'); ?>
		var output = reverseDate('<?php echo $cal_date?>');
		//var $j = jQuery.noConflict();
		
		
		function reverseDate(givenDate){
			var dateArr=givenDate.split('-').reverse().toString().replace(/,/g, "-");
			return dateArr; 
		}
		function isNumber(evt) {
			var iKeyCode = (evt.which) ? evt.which : evt.keyCode
			if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
				return false;

			return true;
		} 
		
	</script>
	<style>
		.mixed .kyc .label.label-info{
			max-width:165px;
		}
	</style>
	<script>
		$(function() {
			var dateToday = new Date();
			var yrRange = '1950' + ":" + (dateToday.getFullYear() - 18).toString();
   /*  $( "#period_to_month,#period_from_month" ).datepicker({
					dateFormat: 'dd-mm-yy',
					//dateFormat: 'yy-mm-dd',
					changeMonth: true,
					changeYear: true,
					//minDate:"today",
					//maxDate:'31-12-2020' 
					yearRange: '1950:' + new Date().getFullYear().toString()
				}); */
				
				$.datepicker.setDefaults({
					dateFormat: 'dd-mm-yy',
					changeMonth: true,
					changeYear: true,
		  //dateFormat: 'yy-mm-dd',
		  //yearRange: '1950:' + new Date().getFullYear().toString()
		  maxDate: 'today', 
		  yearRange: '1900:dateToday'
		});
				
				$( "#period_from_month0" ).datepicker({
					dateFormat: 'dd-mm-yy',
					changeMonth: true,
					changeYear: true,
			//minDate:-7,
			//maxDate:'31-12-2020',
			onSelect: function () {
				var minDate = $('#period_from_month0').datepicker('getDate');
				//minDate.setDate(minDate.getDate());
				$('#period_to_month0').datepicker('option', 'minDate', minDate);
				
			}
		});
				$( "#period_to_month0" ).datepicker({
					dateFormat: 'dd-mm-yy',
					changeMonth: true,
					changeYear: true,
					minDate:$('#period_from_month0').datepicker('getDate'),		
					
				});
				
				
				
				
				
				$(".from_month").datepicker({
					dateFormat: 'dd-mm-yy',
					changeMonth: true,
					changeYear: true,
				//minDate:-7,
				//maxDate:'31-12-2020',
				onSelect: function () {
					var minDate = $(this).datepicker('setDate');
					//minDate.setDate(minDate.getDate());
					$('.to_month').datepicker('option', 'minDate', minDate);
					
				}
			});
				$(".to_month").datepicker({
					dateFormat: 'dd-mm-yy',
					changeMonth: true,
					changeYear: true,
					minDate:$('.from_month').datepicker('getDate'),		
					
				});
			}); 
		</script>
		<?php if(!empty($application_id) && empty($upload_documents)) {?>
		<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_upload_documents" enctype="multipart/form-data" method="post">
			
			<?php
			if($this->session->userdata('error_message')){ ?>
			<script>
				$(document).ready(function(){
					$("#search_error").show().delay(5000).fadeOut('slow');
				})
			</script>
			<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Data has been saved.</strong></span>";
			$this->session->set_userdata('error_message','');
		} ?>
		<?php
		if($this->session->userdata('err_message')){ ?>
		<script>
			$(document).ready(function(){
				$("#search_error").show().delay(5000).fadeOut('slow');
			})
		</script>
		<span id='search_error'  class="alert alert-success alrt_md"><strong><?php echo $this->session->userdata('err_message');?></strong></span>
	<?php //echo "<span id='search_error' style='color:#ff9900; padding-left:50px;'><strong>Data has been saved.</strong></span>";
	$this->session->set_userdata('err_message','');
} ?>


<?php
if($this->session->userdata('save_message')){ ?>
<script>
	$(document).ready(function(){
			//$("#search_error").show().delay(5000).fadeOut('slow');
		})
	window.setTimeout(function() {
		location.href = '<?php echo base_url(); ?>manage/dashboard';
	}, 5000); 
	var count=6;
			var counter=setInterval(timer, 1000); //1000 will  run it every 1 second
			function timer()
			{
				count=count-1;
				if (count <= 0)
				{
					clearInterval(counter);
					return;
				}
				document.getElementById("timer").innerHTML=count + " secs";
			}
		</script>
		<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Your Application is forwarded to Analyst, we will get back to you shortly.<br/>Page will redirect automatically to dashboard page in <span id='timer'></span>.</strong></span>";
		$this->session->set_userdata('save_message','');
	} ?>
	<div class="content-wrapper select">
		<div class="clear"></div>
		<h5 class="tab-form-head">Company KYC and Financials  <span class="upload_msg"><img src="<?php echo base_url()?>assets/front/images/info_big.png" width="23px;"/>For Attachment: (pdf, jpg, jpeg only max size 2MB)</span></h5>
		<div class="p100">
			<div class="col-sm-3"><strong>Bank Statement</strong></div>
			<div class="col-sm-3"></div>
			<div class="col-sm-3"></div>
			<div class="col-sm-3"><button style="width:150px;" id="add_more" class="yellow-button pull-right top-margin10 ad_btn" type="button" onclick="addBank()"><span class="big-text">Add More</span> &nbsp;&nbsp;<i aria-hidden="true" class="fa fa-plus-circle"></i>
			</button></div>
			
			<div class="addnew_div">          
				
				<div class="addnewfrst">
					<div class="clear"></div>
					<div class="col-sm-5">Name of Bank <span class="star">*</span></div>

					<!--        <div class="bank_cont_seprt">      -->

					<div class="col-sm-6"><input type="text" maxlength="50" value="<?php echo set_value('bank_name');?>" name="bank_name[]" id="bank_name0" class="module-input">
						<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('bank_name[]'); ?></span>
					</div>
					<div class="col-sm-1"></div>
					<div class="clear"></div>
					<div class="col-sm-5">Period for Month/Year <span class="star">*</span></div>
					<div class="col-sm-1">From:</div>
					<div class="col-sm-2"><input type="text" autocomplete="off" name="period_from_month[]" id="period_from_month0" class="module-input from_month">
						<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('period_from_month[]'); ?></span>
					</div>
					<div class="col-sm-1">To:</div>
					<div class="col-sm-2"><input type="text" autocomplete="off" name="period_to_month[]" id="period_to_month0" class="module-input to_month">
						<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('period_to_month[]'); ?></span>
					</div>
					<div class="clear"></div>
					<div class="up_file">
						<div class="col-sm-5">Upload File <span class="star">*</span></div>
						<div class="col-sm-4"><label class="btn btn-primary yellow-button">
							<input type="file" class="upld_doc" name="upload_file[]" id="upload_file0" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">BROWSE FILE</label>
							<span class="label label-info" id="upload-file-info"></span>
							<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('upload_file[]'); ?></span>
						</div>
					</div>
					<span id='spanFileName'></span>			
				</div>
				<!--        </div>-->
				<!--<div id="cont_details_bank_uper"> </div>-->
				
				
				
				<div id="cont_details_bank"> 
					
				</div>       
				
				<div class="clear"></div> 
			</div>    
			
			
			
			<div class="col-sm-1"></div>
			<div class="col-sm-3"></div>
			<div class="clear"></div>
			<div class="col-sm-3"><strong>CIBIL Report</strong></div>
			<div class="col-sm-3"></div>
			<div class="col-sm-3"></div>
			<div class="col-sm-3"></div>
			<div class="clear"></div>
			
			<div class="cbl_repot">   
				
				<div class="col-sm-5">CIBIL Report (optional)</div>
				<div class="col-sm-3"><label class="btn btn-primary yellow-button">
					<input type="file" class="upld_doc"  name="cibil_report" id="cibil_report" style="display:none;" onchange="$('#upload-file-info2').html($(this).val());">BROWSE FILE</label>
					<span class="label label-info" id="upload-file-info2"></span></div>
					<div class="col-sm-1"></div>
					<div class="col-sm-3"></div>
					<div class="clear"></div>  
				</div>    
				
				<div class="clear"></div>
				<div class="col-sm-3"><strong>KYC Details</strong></div>
				<div class="col-sm-3"></div>
				<div class="col-sm-3"></div>
				<div class="col-sm-3"></div>
				<div class="clear"></div>
				<div class="addnewfrst1">  
					<div class="test">
						<div class="col-sm-5">PAN Card <span class="star">*</span></div>
						<div class="col-sm-3"><label class="btn btn-primary yellow-button">
							<input type="file" class="upld_doc" name="pan_card" id="pan_card" style="display:none;" onchange="$('#upload-file-info3').html($(this).val());">BROWSE FILE</label>
							<span class="label label-info" id="upload-file-info3"></span>
							<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pan_card'); ?></span>
						</div>
					</div>
					<div class="col-sm-1"></div>
					<div class="col-sm-3"></div>
					<div class="clear"></div>
					<div class="test">
						<div class="col-sm-5 line-height25">Address Proof of Company Business <span class="star">*</span></div>
						<div class="col-sm-3"><label class="btn btn-primary yellow-button">
							<input type="file" class="upld_doc"  name="address_proof_company" id="address_proof_company" style="display:none;" onchange="$('#upload-file-info4').html($(this).val());">BROWSE FILE</label>
							<span class="label label-info" id="upload-file-info4"></span>
							<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('address_proof_company'); ?></span>
						</div>
					</div>
				</div>
				
				<div class="col-sm-1"></div>
				<div class="col-sm-3"></div>
				<div class="clear"></div>
				<div class="col-sm-5 line-height25">VAT Registration Certificate</div>
				<div class="col-sm-3"><label class="btn btn-primary yellow-button">
					<input type="file" class="upld_doc"  name="vat_registration_certificate" id="vat_registration_certificate" style="display:none;" onchange="$('#upload-file-info5').html($(this).val());">BROWSE FILE</label>
					<span class="label label-info" id="upload-file-info5"></span></div>
					<div class="col-sm-1"></div>
					<div class="col-sm-3"></div>
					<div class="clear"></div>
					<div class="col-sm-5 line-height25">Shop and Establishment Certificate</div>
					<div class="col-sm-3"><label class="btn btn-primary yellow-button">
						<input type="file" class="upld_doc" name="shop_establishment_certificate" id="shop_establishment_certificate" style="display:none;" onchange="$('#upload-file-info6').html($(this).val());">BROWSE FILE</label>
						<span class="label label-info" id="upload-file-info6"></span></div>
						<div class="col-sm-1"></div>
						<div class="col-sm-3"></div>
						<div class="clear"></div>
						<div class="col-sm-5 line-height25">Do you want to add Additional Documents</div>
						<div class="col-sm-3">
							<select name="add_additional_documents" id="add_additional_documents" class="module-select">
								<option value="0">--No--</option>
								<option value="1">--Yes--</option>
							</select></div>
							<div class="col-sm-1"></div>
							<div class="col-sm-2"></div>
							<div class="clear"></div>
							
							<div id="text1">
								
								
							</div>
							
							<div class="col-sm-1"></div>
							<div class="col-sm-3"></div>
							<div class="clear"></div>
							
							<div id="text2">
							</div>
							
							<div id="cont_details_brows"> 
								
							</div> 
							
							<div class="col-sm-1"></div>
							<div class="col-sm-3"></div>
							<div class="clear"></div>
							<h5 class="tab-form-head">Company KYC and Financials  <span class="upload_msg"><img src="<?php echo base_url()?>assets/front/images/info_big.png" width="23px;"/>For Attachment: (pdf, jpg, jpeg only max size 2MB)</span></h5>
							<div class="col-sm-3"></div>
							
							<div class="clear"></div>
		<!------------------Owner Name Fetching and Data showing as per Owner Detials----------------------->
		
        
                    <!--
                    ========================
                    edit by mp-22-09-2016
                    ========================
                --> 
                <div class="horizontal-scroll">
                	
                	<table class="table mixed">
                		<tbody>
                			<tr>
                				<td style="width:180px;">
                					<table class="table sbitem" style="margin-top:39px">
                						<tbody>
                							<tr><td style="white-space:nowrap">PAN Card <span class="star">*</span></td></tr>
                							<tr><td style="white-space:nowrap">Address Proof <span class="star">*</span></td></tr>
                							<tr><td style="white-space:nowrap">CIBIL Score</td></tr>
                						</tbody>
                					</table>
                				</td><!--1st td end here-->

                				
                				<?php if(!empty($owner_details) && empty($owner_documents)){?>
                				<td style="width:180px;">
                					<table class="table sbitem" style="margin-top:20px">
                						<tbody>
                							<tr>
                								
                								<?php $val = 499;?>
                								<?php foreach($owner_details as $value){ $val++;?>
                								<td style="width:180px;">
                									
                									<div style="text-align:left;padding-right:35px;"><?php if(!empty($owner_details) && isset($value->name)){ echo ucwords($value->name);} ?></div>
                								</td>
                								<?php } ?>
                							</tr>
                							<tr>
                								
                								<?php $val = 499;?>
                								<?php foreach($owner_details as $values){ $val++;?>
                								
                								<input type="hidden" name="ownerid[]" value="<?php echo $values->id;?>"/>
                								
                								<td><div class="kyc"><label class="btn btn-primary yellow-button">
                									<input type="file" onchange="$('#upload-file-info<?php echo $val;?>').html($(this).val());" style="display:none;" id="pan_card<?php echo $val;?>" name="pan_card1[]">BROWSE FILE</label>
                									<span id="upload-file-info<?php echo $val;?>" class="label label-info"></span>
                									<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pan_card1[]'); ?></span>
                								</div></td>
                								
                								<?php } ?>
                								
                							</tr>
                							
                							<tr>
                								<?php $val1 = 599; ?>
                								<?php foreach($owner_details as $values){ $val1++;?>
                								
                								<td><div class="kyc"><label class="btn btn-primary yellow-button">
                									<input type="file" onchange="$('#upload-file-info<?php echo $val1;?>').html($(this).val());" style="display:none;" id="address_proof<?php echo $val1;?>" name="address_proof1[]">BROWSE FILE</label>
                									<span id="upload-file-info<?php echo $val1;?>" class="label label-info"></span>
                									<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('address_proof1[]'); ?></span>
                								</div></td>
                								<?php } ?>
                								
                							</tr>
                							<tr>
                								<?php $val2 = 699; ?>
                								<?php foreach($owner_details as $values){ $val2++;?>
                								
                								<td><div style="max-width:165px;"><label class="btn btn-primary yellow-button">
                									<input type="file" onchange="$('#upload-file-info<?php echo $val2;?>').html($(this).val());" style="display:none;" id="civil_score<?php echo $val2;?>" name="civil_score1[]">BROWSE FILE</label>
                									<span id="upload-file-info<?php echo $val2;?>" class="label label-info"></span></div></td>
                									<?php } ?>
                									
                								</tr>
                							</tbody>
                						</table>
                						
                					</td><!--2nd td end here-->
                					<?php } ?>
                					
                					
                					
                				</tr>
                			</tbody>
                		</table>
                		

                	</div>
                    <!--
                    ========================
                    edit by mp-22-09-2016
                    ========================
                -->

                
                
                
                
                
                
                
                
                
                

		<!------------------End Owner Name Fetching and Data showing as per Owner Detials----------------------->
        
		<input type="hidden" name="application_id" value="<?php echo $application_id;?>" />
		<hr class="top-margin20 yellow-hr">
        <div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default">Submit</button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>
        
        </div>
      </div>
	  
</form>
<?php } 

else

{?>
<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_upload_documents" enctype="multipart/form-data" method="post">

<?php
if($this->session->userdata('error_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Data has been saved.</strong></span>";
	$this->session->set_userdata('error_message','');
	} ?>
<?php
if($this->session->userdata('err_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<span id='search_error' style='color:#ff9900; padding-left:50px;'><strong><?php echo $this->session->userdata('err_message');?></strong></span>
	<?php $this->session->set_userdata('err_message','');
	} ?>


<?php
if($this->session->userdata('save_message')){ ?>
	<script>
		$(document).ready(function(){
			//$("#search_error").show().delay(5000).fadeOut('slow');
		})
		  window.setTimeout(function() {
                        location.href = '<?php echo base_url(); ?>manage/dashboard';
                    }, 5000);  
		    var count=6;
			var counter=setInterval(timer, 1000); //1000 will  run it every 1 second
			function timer()
			{
			  count=count-1;
			  if (count <= 0)
			  {
				 clearInterval(counter);
				 return;
			  }
			  document.getElementById("timer").innerHTML=count + " secs";
			}
	</script>
	<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Your Application is forwarded to Analyst, we will get back to you shortly.<br/>Page will redirect automatically to dashboard page in <span id='timer'></span>.</strong></span>";
	$this->session->set_userdata('save_message','');
	} ?>
<div class="content-wrapper select">
        <div class="clear"></div>
        <h5 class="tab-form-head">Company KYC and Financials  <span class="upload_msg"><img src="<?php echo base_url()?>assets/front/images/info_big.png" width="23px;"/>For Attachment: (pdf, jpg, jpeg only max size 2MB)</span></h5>
        <div class="p100">
        <div class="col-sm-3"><strong>Bank Statement</strong></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-3"><button style="width:150px;" id="add_more" class="yellow-button pull-right top-margin10 ad_btn" type="button" onclick="addBank()"><span class="big-text">Add More</span> &nbsp;&nbsp;<i aria-hidden="true" class="fa fa-plus-circle"></i>
</button></div>
           
<!--  by mp-06-09-2016 add a new div-->
<div class="addnew_div">    
	
	<div class="clear"></div>
	<?php $k = 299; ?>
	<?php foreach($upload_add_more as $key=>$val){   $k++; ?>
	
	<div class="col-sm-5">Name of Bank <span class="star">*</span></div>
	
	<!--        <div class="bank_cont_seprt">-->
	
	<div class="col-sm-6"><input type="text" maxlength="50" name="bank_name[]" id="bank_name<?php echo $k;?>" value="<?php echo $val->bank_name;?>" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('bank_name[]'); ?></span>
	</div>
	<div class="col-sm-1"></div>
	<div class="clear"></div>
	<div class="col-sm-5">Period for Month/Year <span class="star">*</span></div>
	<div class="col-sm-1">From:</div>
	<div class="col-sm-2"><input type="text" autocomplete="off" name="period_from_month[]" id="period_from_month<?php echo $k;?>" value="<?php echo date("d-m-Y", strtotime($val->period_from_month)); ?>" class="module-input from_month">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('period_from_month[]'); ?></span>
	</div>
	<div class="col-sm-1">To:</div>
	<div class="col-sm-2"><input type="text" autocomplete="off" name="period_to_month[]" id="period_to_month<?php echo $k;?>" value="<?php echo date("d-m-Y", strtotime($val->period_to_month));?>" class="module-input to_month">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('period_to_month[]'); ?></span>
	</div>
	<div class="clear"></div>	
	<div class="col-sm-5">Upload File <span class="star">*</span></div>
	<input type="hidden" name="bank_id[]" value="<?php echo $val->id;?>">
	<div class="col-sm-4"><label class="btn btn-primary yellow-button">
		<input type="file" name="upload_file[]" id="upload_file<?php echo $k;?>" style="display:none;"  value="<?php if($val->upload_file!=""){ echo $val->upload_file;}?>" onchange="$('#upload-file-info<?php echo $k;?>').html($(this).val());">BROWSE FILE</label>
		<a href="<?php echo base_url()?>uploads/loan_documents/<?php echo $val->upload_file;?>" target="_blank"><span class="label label-info" id="upload-file-info<?php echo $k;?>"><?php if($val->upload_file!=""){ echo $val->upload_file;}?></span></a></div>
		
		<?php } ?>
		
		<!--        </div>  -->
		<div id="cont_details_bank"> 
			
		</div>    
		<div class="clear"></div> 
	</div>
	
	<div class="col-sm-1"></div>
	<div class="col-sm-3"></div>
	<div class="clear"></div>
	<div class="col-sm-3"><strong>CIBIL Report</strong></div>
	<div class="col-sm-3"></div>
	<div class="col-sm-3"></div>
	<div class="col-sm-3"></div>
	<div class="clear"></div>
	
	<div class="cbl_repot">
		
		<div class="col-sm-5">CIBIL Report (optional)</div>
		<div class="col-sm-3"><label class="btn btn-primary yellow-button">
			<input type="file" name="cibil_report" id="cibil_report" style="display:none;" value="<?php if($upload_documents[0]->cibil_report!=""){ echo $upload_documents[0]->cibil_report;}?>" onchange="$('#upload-file-info2').html($(this).val());">BROWSE FILE</label>
			<a href="<?php echo base_url()?>uploads/loan_documents/<?php echo $upload_documents[0]->cibil_report;?>" target="_blank"><span class="label label-info" id="upload-file-info2"><?php if($upload_documents[0]->cibil_report!=""){ echo $upload_documents[0]->cibil_report;}?></span></a></div>
			<div class="col-sm-1"></div>
			<div class="col-sm-3"></div>
			
			<div class="clear"></div>
		</div>
		
		
		<div class="clear"></div>
		<div class="col-sm-3"><strong>KYC Details</strong></div>
		<div class="col-sm-3"></div>
		<div class="col-sm-3"></div>
		<div class="col-sm-3"></div>
		<div class="clear"></div>
		<div class="col-sm-5">PAN Card <span class="star">*</span></div>
		<div class="col-sm-3"><label class="btn btn-primary yellow-button">
			<input type="file" name="pan_card" id="pan_card" style="display:none;" value="<?php if($upload_documents[0]->pan_card!=""){ echo $upload_documents[0]->pan_card;}?>" onchange="$('#upload-file-info3').html($(this).val());">BROWSE FILE</label>
			<a href="<?php echo base_url()?>uploads/loan_documents/<?php echo $upload_documents[0]->pan_card;?>" target="_blank"><span class="label label-info" id="upload-file-info3"><?php if($upload_documents[0]->pan_card!=""){ echo $upload_documents[0]->pan_card;}?></span></a></div>
			<div class="col-sm-1"></div>
			<div class="col-sm-3"></div>
			<div class="clear"></div>
			<div class="col-sm-5 line-height25">Address Proof of Company Business <span class="star">*</span></div>
			<div class="col-sm-3"><label class="btn btn-primary yellow-button">
				<input type="file" name="address_proof_company" id="address_proof_company" style="display:none;" value="<?php if($upload_documents[0]->address_proof_company!=""){ echo $upload_documents[0]->address_proof_company;}?>" onchange="$('#upload-file-info4').html($(this).val());">BROWSE FILE</label>
				<a href="<?php echo base_url()?>uploads/loan_documents/<?php echo $upload_documents[0]->address_proof_company;?>" target="_blank"><span class="label label-info" id="upload-file-info4"><?php if($upload_documents[0]->address_proof_company!=""){ echo $upload_documents[0]->address_proof_company;}?></span></a></div>
				<div class="col-sm-1"></div>
				<div class="col-sm-3"></div>
				<div class="clear"></div>
				<div class="col-sm-5 line-height25">VAT Registration Certificate</div>
				<div class="col-sm-3"><label class="btn btn-primary yellow-button">
					<input type="file" name="vat_registration_certificate" id="vat_registration_certificate" style="display:none;" value="<?php if($upload_documents[0]->vat_registration_certificate!=""){ echo $upload_documents[0]->vat_registration_certificate;}?>" onchange="$('#upload-file-info5').html($(this).val());">BROWSE FILE</label>
					<a href="<?php echo base_url()?>uploads/loan_documents/<?php echo $upload_documents[0]->vat_registration_certificate;?>" target="_blank"><span class="label label-info" id="upload-file-info5"><?php if($upload_documents[0]->vat_registration_certificate!=""){ echo $upload_documents[0]->vat_registration_certificate;}?></span></a></div>
					<div class="col-sm-1"></div>
					<div class="col-sm-3"></div>
					<div class="clear"></div>
					<div class="col-sm-5 line-height25">Shop and Establishment Certificate</div>
					<div class="col-sm-3"><label class="btn btn-primary yellow-button">
						<input type="file" name="shop_establishment_certificate" id="shop_establishment_certificate" style="display:none;" value="<?php if($upload_documents[0]->shop_establishment_certificate!=""){ echo $upload_documents[0]->shop_establishment_certificate;}?>" onchange="$('#upload-file-info6').html($(this).val());">BROWSE FILE</label>
						<a href="<?php echo base_url()?>uploads/loan_documents/<?php echo $upload_documents[0]->shop_establishment_certificate;?>" target="_blank"><span class="label label-info" id="upload-file-info6"><?php if($upload_documents[0]->shop_establishment_certificate!=""){ echo $upload_documents[0]->shop_establishment_certificate;}?></span></a></div>
						<div class="col-sm-1"></div>
						<div class="col-sm-3"></div>
						<div class="clear"></div>
						<div class="col-sm-5 line-height25">Do you want to add Additional Documents</div>
						<div class="col-sm-3">
							<select name="add_additional_documents" id="add_additional_documents" class="module-select">
								<option value="0" <?php if($upload_documents[0]->add_additional_documents=="0"){ echo "selected";}?>>--No--</option>
								<option value="1"<?php if($upload_documents[0]->add_additional_documents=="1"){ echo "selected";}?>>--Yes--</option>
							</select></div>
							<div class="col-sm-1"></div>
							<div class="col-sm-2"></div>
							<div class="clear"></div>
							<?php //if($upload_documents[0]->add_additional_documents == "1" ) { ?>
							<div id="text1">
								
								
								
			<!--<div class="col-sm-5 top-margin20"><input type="text" name="add_additional_documents_text1" id="add_additional_documents_text1" value="<?php if($upload_documents[0]->add_additional_documents_text1!=""){ echo $upload_documents[0]->add_additional_documents_text1;}?>" class="module-input"></div>
			<div class="col-sm-3 top-margin20"><label class="btn btn-primary yellow-button">
			<input type="file" name="add_additional_documents_file1" id="add_additional_documents_file1" style="display:none;" value="<?php if($upload_documents[0]->add_additional_documents_file1!=""){ echo $upload_documents[0]->add_additional_documents_file1;}?>" onchange="$('#upload-file-info8').html($(this).val());">BROWSE FILE</label>
			<a href="<?php echo base_url()?>uploads/loan_documents/<?php echo $upload_documents[0]->add_additional_documents_file1;?>" target="_blank"><span class="label label-info" id="upload-file-info8"><?php if($upload_documents[0]->add_additional_documents_file1!=""){ echo $upload_documents[0]->add_additional_documents_file1;}?></span></a></div>  -->
			
		</div>
		<?php //}  ?>
		
		<div id="text1">
		</div>

		<div class="col-sm-1"></div>
		<div class="col-sm-3"></div>
		<div class="clear"></div>
		<?php if($upload_documents[0]->add_additional_documents == "1" ) { ?>
		<?php if(!empty($additional_documents)){?>
		<?php $j=399; ?>
		<?php foreach($additional_documents as $jey=>$row){ $j++; ?>
		<input type="hidden" name="additional_documents[]" value="<?php echo $row->id;?>">	
		<div id="text2">	
			<div class="col-sm-5"><input type="text" name="add_additional_documents_text2[]" id="add_additional_documents_text<?php echo $j;?>" value="<?php if($row->add_additional_documents_text2!=""){ echo $row->add_additional_documents_text2;}?>" class="module-input"></div>
			<div class="col-sm-3 bottom-margin20"><label class="btn btn-primary yellow-button">
				<input type="file" name="add_additional_documents_file2[]" id="add_additional_documents_file<?php echo $j;?>" style="display:none;" value="<?php if($row->add_additional_documents_file2!=""){ echo $row->add_additional_documents_file2;}?>" onchange="$('#upload-file-info9<?php echo $j;?>').html($(this).val());">BROWSE FILE</label>
				<a href="<?php echo base_url()?>uploads/loan_documents/<?php echo $row->add_additional_documents_file2;?>" target="_blank"><span class="label label-info" id="upload-file-info9<?php echo $j;?>"><?php if($row->add_additional_documents_file2!=""){ echo $row->add_additional_documents_file2;}?></span></a></div></div>
				
				<?php } ?> 
				<?php } ?>	
				<div id="text2">
					
					<div class="col-sm-4"><button style="width:150px;" id="add_more" class="yellow-button top-margin10 ad_btn pull-right" type="button" onclick="addFles()"><span class="big-text">Add More</span> &nbsp;&nbsp;<i aria-hidden="true" class="fa fa-plus-circle"></i></button></div>
				</div>
				<?php } ?>
				
				<div id="text2">
				</div>
				<!--by mp 06-09-2016-->
				
				<div id="cont_details_brows"> 
					
				</div> 
				<div class="col-sm-1"></div>
				<div class="col-sm-3"></div>
				<div class="clear"></div>
				
				<h5 class="tab-form-head">Company KYC and Financials <span class="upload_msg"><img src="<?php echo base_url()?>assets/front/images/info_big.png" width="23px;"/>For Attachment: (pdf, jpg, jpeg only max size 2MB)</span></h5>
				<div class="horizontal-scroll">
					<table class="table mixed">
						<tbody>
							<tr>
<!--
                        <td style="width:180px;">
                            <table class="table sbitem" style="margin-top:39px">
                                <tbody>
                                    
                                    <tr><td style="white-space:nowrap">Address Proof</td></tr>
                                    <tr><td style="white-space:nowrap">CIBIL Score</td></tr>
                                </tbody>
                            </table>
                        </td>
                    -->

                    
                    
                    <td style="width:180px;">
                    	<table class="table sbitem" style="margin-top:20px">
                    		<tbody>
                    			<?php if(!empty($owner_details)){?>	
                    			<tr>
                    				<td style="white-space:nowrap"></td>					
                    				<?php foreach($owner_details as $kdf=>$values){ ?>						
                    				<td style="width:180px;">
                    					<input type="hidden" name="ownerid[]" value="<?php echo $values->id;?>"/>
                    					<div style="text-align:center;padding-right:35px;"><?php echo ucwords($values->name);?></div>
                    				</td>
                    				<?php } ?>
                    			</tr>
                    			<tr>
                    				<td style="white-space:nowrap">PAN Card <span class="star">*</span></td>
                    				<?php $val = 499; ?>
                    				<?php foreach($owner_documents as $owner=>$values ){ $val++;?>
                    				<input type="hidden" name="owner_documents_id[]" value="<?php echo $values->id;?>">
                    				<td><div style="max-width:165px;"><label class="btn btn-primary yellow-button">
                    					<input type="file" onchange="$('#upload-file-info<?php echo $val;?>').html($(this).val());" style="display:none;" id="pan_card<?php echo $val;?>" value="<?php if($values->pan_card1!=""){ echo $values->pan_card1;}?>" onchange="$('#upload-file-info<?php echo $val;?>" name="pan_card1[]">BROWSE FILE</label>
                    					<a href="<?php echo base_url()?>uploads/loan_documents/<?php echo $values->pan_card1;?>" target="_blank"><span class="label label-info" id="upload-file-info<?php echo $val;?>"><?php if($values->pan_card1!=""){ echo $values->pan_card1;}?></span></a></div></td>
                    					<?php } ?>
                    				</tr>
                    				
                    				<tr>
                    					<td style="white-space:nowrap">Address Proof <span class="star">*</span></td>
                    					<?php $val1 = 599; ?>
                    					<?php foreach($owner_documents as $owner=>$values ){ $val1++;?>
                    					<td><div style="max-width:165px;"><label class="btn btn-primary yellow-button">
                    						<input type="file" onchange="$('#upload-file-info<?php echo $val1;?>').html($(this).val());" style="display:none;" id="address_proof<?php echo $val1;?>" name="address_proof1[]" value="<?php if($values->address_proof1!=""){ echo $values->address_proof1;}?>">BROWSE FILE</label>
                    						<a href="<?php echo base_url()?>uploads/loan_documents/<?php echo $values->address_proof1;?>" target="_blank"><span class="label label-info" id="upload-file-info<?php echo $val1;?>"><?php if($values->address_proof1!=""){ echo $values->address_proof1;}?></span></a></div></td>
                    						<?php } ?>
                    					</tr>
                    					<tr>
                    						<td style="white-space:nowrap">CIBIL Score</td>
                    						<?php $val2 = 699; ?>
                    						<?php foreach($owner_documents as $owner=>$values ){ $val2++;?>
                    						<td><div style="max-width:165px;">
                    							<label class="btn btn-primary yellow-button">
                    								<input type="file" onchange="$('#upload-file-info<?php echo $val2;?>').html($(this).val());" style="display:none;" id="civil_score<?php echo $val2;?>" name="civil_score1[]" value="<?php if($values->civil_score1!=""){ echo $values->civil_score1;}?>">BROWSE FILE</label>
                    								<a href="<?php echo base_url()?>uploads/loan_documents/<?php echo $values->civil_score1;?>" target="_blank"><span class="label label-info" id="upload-file-info<?php echo $val2;?>"><?php if($values->civil_score1!=""){ echo $values->civil_score1;}?></span></a></div></td>
                    								<?php } ?>
                    							</tr>
                    							<?php } ?>
                    						</tbody>
                    					</table>
                    					
                    				</td><!--2nd td end here-->
                    				
                    				
                    				
                    			</tr>
                    			
                    		</tbody>
                    	</table>
                    </div>

                    
                    
                    <input type="hidden" name="flag" value="1"/>
                    <input type="hidden" name="application_id" value="<?php echo $application_id;?>" />
                    <input type="hidden" name="upload_more" value="<?php echo $upload_documents[0]->id;?>" />
                    
                    <hr class="top-margin20 yellow-hr">
                    <div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" value="1" name="submit" class="yellow-button btn-default"><?php if($utype_id ==3 || $utype_id ==4 || $utype_id ==5){ echo "Next"; }else { echo "Submit";} ?></button></div>
                    <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>
                    
                    <div class="clear"></div>
                </div>
                
                
                
                
                
                
            </div>
            
        </form>
        <?php } ?>               

        
        <script type="text/javascript">
        	var rowNum =<?php if(!empty($upload_add_more)&& count($upload_add_more)>0){ echo count($upload_add_more); }else { echo "0"; } ?>;
        	var up_load = 19;
        	function addBank(){
        		var grp_bank_ln=$("#cont_details_bank .grp_bank-content").length;
        		var errorarray=[];
        		if(grp_bank_ln>0){
        			var grp_bank_lst=grp_bank_ln-1;
        			$("#cont_details_bank .grp_bank-content:eq("+grp_bank_lst+") input").each(function(){
        				if($(this).val()==''){
        					errorarray.push('no');
        				}
        			});
        		}
        		else{
        			$(".addnewfrst input").each(function(){
        				if($(this).val()==''){
        					errorarray.push('no');
        				}
        			});
        		}
        		rowNum++;
        		up_load++;
        		<?php if(!empty($upload_documents)) {?>
        			if(errorarray.length==0){
        				$('#cont_details_bank').append('<div class="grp_bank-content"><div class="clear"></div><div class="bank_cont_seprt"><div class="col-sm-4">Name of Bank</div><div class="col-sm-6"><input type="hidden" maxlength="50" name="bank_add_more[]"  value="'+rowNum+'" class="module-input"><input type="text" maxlength="50" name="bank_name1[]" id="bank_name'+rowNum+'" value="" class="module-input bank_add"></div><a title="Delete" href="#" class="rmv_upld"><i class="fa fa-close"></i></a><div class="col-sm-1"></div><div class="clear"></div><div class="col-sm-4">Period for Month/Year</div><div class="col-sm-1">From:</div><div class="col-sm-3"><input type="text" autocomplete="off" name="period_from_month1[]" id="period_from_month'+rowNum+'" value="" class="module-input from_month"></div><div class="col-sm-1">To:</div><div class="col-sm-3"><input type="text" autocomplete="off" name="period_to_month1[]" id="period_to_month'+rowNum+'" value="" class="module-input to_month"></div><div class="clear"></div><div class="col-sm-3">Upload File</div><div class="col-sm-4"><label class="btn btn-primary yellow-button"><input type="file" name="upload_file1[]" id="upload_file'+rowNum+'" style="display:none;"  value="" onchange="$(\'#upload-file-info'+up_load+'\').html($(this).val());">BROWSE FILE</label><a href="" target="_blank"><span class="label label-info" id="upload-file-info'+up_load+'"></span></a></div></div></div>');
        			}else{
        				alert('Please fill up all field');
        			}
        			<?php }else{?>
        				if(errorarray.length==0){
        					$('#cont_details_bank').append('<div class="grp_bank-content"><div class="clear"></div><div class="bank_cont_seprt"><div class="col-sm-4">Name of Bank</div><div class="col-sm-6"><input type="text" maxlength="50" name="bank_name[]" id="bank_name'+rowNum+'" value="" class="module-input"></div><a title="Delete" href="#" class="rmv_upld"><i class="fa fa-close"></i></a><div class="col-sm-1"></div><div class="clear"></div><div class="col-sm-4">Period for Month/Year</div><div class="col-sm-1">From:</div><div class="col-sm-3"><input type="text" autocomplete="off" name="period_from_month[]" id="period_from_month'+rowNum+'" value="" class="module-input from_month"></div><div class="col-sm-1">To:</div><div class="col-sm-3"><input type="text" autocomplete="off" name="period_to_month[]" id="period_to_month'+rowNum+'" value="" class="module-input to_month"></div><div class="clear"></div><div class="col-sm-3">Upload File</div><div class="col-sm-4"><label class="btn btn-primary yellow-button"><input type="file" name="upload_file[]" id="upload_file'+rowNum+'" style="display:none;"  value="" onchange="$(\'#upload-file-info'+up_load+'\').html($(this).val());">BROWSE FILE</label><span class="label label-info" id="upload-file-info'+up_load+'"></span></div></div></div>');
        				}
        				else{
        					alert('Please fill up all field');
        				}
        				<?php }?>		
        				$('.rmv_upld').on('click', function(e){
        					e.preventDefault();
		/* $(this).parent().fadeOut('slow', function(c){
		}); */
		//alert("asdfd");
		$(this).parent('.bank_cont_seprt').remove();
		//$('#cont_details_bank').css("display", "none");
		$('#submit_btn').removeAttr('disabled');
	});
        				
        				$('input[type=file]').on("change", function(){
	//alert(this.files[0].size);
	var fileNm=$(this).val();
	var ext = $(this).val().split('.').pop().toLowerCase();		
	var file_size = $(this)[0].files[0].size;
	var extall=[];
	var file_size_all=[];
	
	
	
	//var ext = $(this).val();
	//console.log();
	//alert(ext);
	if(ext!=""){
		if($.inArray(ext, ['jpg','jpeg','pdf']) == -1) {
			<?php if(!empty($application_id) && empty($upload_documents)){?>
				$(this).parent(".btn-primary").next("span").html("Invalid extension!");
				<?php } else {?>
					$(this).parent(".btn-primary").next("a").find("span").html("Invalid extension!");
					<?php } ?>
			//return false;
		}
		else{
			if(file_size>2000000) {
				<?php if(!empty($application_id) && empty($upload_documents)){?>
					$(this).parent(".btn-primary").next("span").html("File size is greater than 2MB");
					<?php } else {?>
						$(this).parent(".btn-primary").next("a").find("span").html("File size is greater than 2MB");
						<?php } ?>
				//return false;
			}
			else{
				<?php if(!empty($application_id) && empty($upload_documents)){?>
					$(this).parent(".btn-primary").next("span").html(fileNm);
					<?php } else {?>
						$(this).parent(".btn-primary").next("a").find("span").html(fileNm);
						<?php } ?>
					}
				}
			}   
			
			$(this).parents('form').find('input[type=file]').each(function(e){
				<?php if(!empty($application_id) && empty($upload_documents)){?>
					var exteach=$(this).parent('label').next('span').html().split('.').pop().toLowerCase();
					<?php } else {?>
						var exteach=$(this).parent('label').next('a').find('span').html().split('.').pop().toLowerCase();
						<?php } ?>
						
						if($.trim($(this).parent('label').next('a').find('span').html())!=''){
							if(exteach=='jpg' || exteach=='jpeg' || exteach=='pdf'){
								extall.push('yes');
							}
							else{
								extall.push('no');
							}
						}	
						
						if($.trim($(this).parent('label').next('span').html())!=''){
							if(exteach=='jpg' || exteach=='jpeg' || exteach=='pdf'){
								extall.push('yes');
							}
							else{
								extall.push('no');
							}
						}
				/*if(file_size_each>2000000) {
					file_size_all.push('no');
				}
				else{
					file_size_all.push('yes');
				}*/
			});
			
			if(extall.indexOf('no')>-1){
				$('#submit_btn').attr('disabled','disabled');
			}
			else{
				$('#submit_btn').removeAttr('disabled');
			}
			
		});

        				$.datepicker.setDefaults({
        					dateFormat: 'dd-mm-yy',
        					changeMonth: true,
        					changeYear: true,
        					dateFormat: 'yy-mm-dd',
        					yearRange: '1950:' + new Date().getFullYear().toString()
        				});

        				$( "#period_from_month"+rowNum ).datepicker({
        					dateFormat: 'dd-mm-yy',
        					changeMonth: true,
        					changeYear: true,
			//minDate:-7,
			//maxDate:'31-12-2020',
			onSelect: function () {
				var minDate = $('#period_from_month'+rowNum).datepicker('getDate');
				//minDate.setDate(minDate.getDate());
				$('#period_to_month'+rowNum).datepicker('option', 'minDate', minDate);
				
			}
		});
        				$( "#period_to_month"+rowNum).datepicker({
        					dateFormat: 'dd-mm-yy',
        					changeMonth: true,
        					changeYear: true,
        					minDate:$('#period_from_month'+rowNum).datepicker('getDate'),		
        					
        				}); 		
        				
        				
        			}
        		</script> 
        		
        		<script type="text/javascript">
        			var additional = 99;
        			function addFles(){
        				additional++;
        				<?php if(!empty($upload_documents)) {?>
        					$('#cont_details_brows').append('<div class="cont_details_brows_row"><div class="col-sm-5 miw"><input type="hidden" name="additional_documents_addmore[]"  value="'+additional+'" class="module-input"><div class=""><input type="text" name="add_additional_documents_text21[]" id="add_additional_documents_text'+additional+'" class="module-input"></div></div><div class="col-sm-3 bottom-margin20 miw"><div class=""><label class="btn btn-primary yellow-button"><input type="file" name="add_additional_documents_file21[]" id="add_additional_documents_file'+additional+'" style="display:none;" onchange="$(\'#upload-file-info'+additional+'\').html($(this).val());">BROWSE FILE</label><span class="label label-info" id="upload-file-info'+additional+'"></span></div></div><span class="cont_details_brows_row_close">x</span></div>');
        					<?php }else{?>
        						$('#cont_details_brows').append('<div class="cont_details_brows_row"><div class="col-sm-5 miw"><div class=""><input type="text" name="add_additional_documents_text2[]" id="add_additional_documents_text'+additional+'" class="module-input"></div></div><div class="col-sm-3 bottom-margin20 miw"><div class=""><label class="btn btn-primary yellow-button"><input type="file" name="add_additional_documents_file2[]" id="add_additional_documents_file'+additional+'" style="display:none;" onchange="$(\'#upload-file-info'+additional+'\').html($(this).val());">BROWSE FILE</label><span class="label label-info" id="upload-file-info'+additional+'"></span></div></div><span class="cont_details_brows_row_close">x</span></div>');
        						<?php } ?>	 
        						$('.cont_details_brows_row_close').click(function(){
        							$(this).parents('.cont_details_brows_row').remove();
        						});
        						$('.rmv_bro').on('click', function(c){
        							$(this).parent().fadeOut('slow', function(c){
        							});
        						});	 
        						
        					} 
        				</script> 
        				
        				
        				
        				