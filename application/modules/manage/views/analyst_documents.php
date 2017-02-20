<script src="<?php echo base_url()?>assets/front/js/jquery-ui.js"></script>
<link href="<?php echo base_url()?>assets/front/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){

<?php if(validation_errors() =="") {?>
$(".requirederror").css("display","none");
<?php } ?>

<?php if(($utype_id ==4 || $utype_id ==5) ){?>
	$('input').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('readonly', true);

	});
		
	$('input[type=file]').attr('disabled', true);
	
	$('.btn').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('disabled', true);
        //$(this).rules('remove');
	});
	
	$('select').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('disabled', true);
       
		
	});
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
<?php } ?>


	 $("#cancel_btn").click(function(){
	 window.location.href='<?php echo base_url();?>manage/dashboard';
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
			<?php if(!empty($application_id) && empty($analyst_documents)){?>
				$(this).parent(".btn-primary").next("span").html("Invalid extension!");
			<?php } else {?>
				$(this).parent(".btn-primary").next("a").find("span").html("Invalid extension!");
			<?php } ?>
			//return false;
		}
		else{
			if(file_size>2000000) {
				<?php if(!empty($application_id) && empty($analyst_documents)){?>
					$(this).parent(".btn-primary").next("span").html("File size is greater than 2MB");
				<?php } else {?>
					$(this).parent(".btn-primary").next("a").find("span").html("File size is greater than 2MB");
				<?php } ?>
				//return false;
			}
			else{
				<?php if(!empty($application_id) && empty($analyst_documents)){?>
					$(this).parent(".btn-primary").next("span").html(fileNm);
				<?php } else {?>
					$(this).parent(".btn-primary").next("a").find("span").html(fileNm);
				<?php } ?>
			}
		}
	}   
	
	$(this).parents('form').find('input[type=file]').each(function(e){
		<?php if(!empty($application_id) && empty($analyst_documents)){?>
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
			var v = $("#hold_frm").validate({
				rules:{
					
						'pan_card': {
							required: true
						},
						'address_proof_company': {
							required: true
						},
						'vat_registration_certificate': {
							required: true
						},
						'shop_establishment_certificate': {
							required: true
						},
						'cibil_report': {
							required: true
						},
						'defaulter_list': {
							required: true
						},
						'type_of_defaulter': {
							required: true
						},
						'director1_name_address[]': {
							required: true
						},
						'director1_name_id[]': {
							required: true
						},
						'director1_name_cibilscore[]': {
							required: true
						},
						'director2_name_address': {
							required: true
						},
						'director2_name_id': {
							required: true
						},
						'director2_name_cibilscore': {
							required: true
						},
						

					
					}
				});	
				
				var defaulter_list = $("#defaulter_list").val();
			  if(defaulter_list == 1)
			  {
				  $("#text1").html("");
			  }
			  
			
			$("#defaulter_list").change(function() {
				
			  var defaulter_list = $(this).val();
			  //alert(defaulter_list);
			  if(defaulter_list == 1)
			  {
				  $("#text1").html("");
			  }
			  if(defaulter_list == 2)
			  {
				  $("#text1").html('<div class="col-sm-4">Type Of Defaulter</div><div class="col-sm-4"><select name="type_of_defaulter" id="type_of_defaulter" class="module-select"><option value="">--select--</option><option value="1">--Wilful--</option><option value="2">--YES--</option><option value="3">--Correct--</option></select></div><div class="col-sm-3"><label class="btn btn-primary yellow-button"><input type="file" name="type_of_defaulter_file" id="type_of_defaulter_file" style="display:none;" onchange="$(\'#upload-file-info6\').html($(this).val());">BROWSE FILE</label><span class="label label-info" id="upload-file-info6"></span></div><div class="clear"></div>');
				  
			  }
				
			});

				
				
				
		
		
		});
		
		
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

<script>
   $(function() {
    $( "#period_to_month,#period_from_month" ).datepicker({
					dateFormat: 'dd-mm-yy',
					//dateFormat: 'yy-mm-dd',
					changeMonth: true,
					changeYear: true,
					//minDate:"today",
					//maxDate:'31-12-2020' 
					yearRange: '1950:' + new Date().getFullYear().toString()
				});
  }); 
</script>
<?php if(!empty($application_id) && empty($analyst_documents)) {?>
<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_analyst_upload_doc" enctype="multipart/form-data" method="post">

<?php
if($this->session->userdata('error_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<!--<span id='search_error' style='color:#1797a2; padding-left:50px;'><strong><?php echo $this->session->userdata('error_message');?></strong></span>-->
	<?php $this->session->set_userdata('error_message','');
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
	<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Your Application is forwarded to Bank, we will get back to you shortly.<br/>Page will redirect automatically to dashboard page in <span id='timer'></span>.</strong></span>";
	$this->session->set_userdata('save_message','');
	} ?>
<div class="content-wrapper select">
        <div class="clear"></div>
        <h5 class="tab-form-head">Application Status  <span class="upload_msg"><img src="<?php echo base_url()?>assets/front/images/info_big.png" width="23px;"/>For Attachment:(pdf, jpg, jpeg only max size 2MB)</span></h5>
        <div class="p100">
        <div class="col-sm-4">PAN Card</div>
        <div class="col-sm-4">
		<select name="pan_card" id="pan_card" class="module-select">
		<option value="">--select--</option>
		<option value="1">--Incorrect--</option>
		<option value="2">--Correct--</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pan_card'); ?></span>
		</div>
		
        <div class="col-sm-3"><label class="btn btn-primary yellow-button">
    	<input type="file" name="pan_card_file" id="pan_card_file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">BROWSE FILE</label>
        <span class="label label-info" id="upload-file-info"></span></div>
        <div class="clear"></div>
		
        <div class="col-sm-4">Address Proof of Company Business</div>
        <div class="col-sm-4">
		<select name="address_proof_company" id="address_proof_company" class="module-select">
		<option value="">--select--</option>
		<option value="1">--Incorrect--</option>
		<option value="2">--Correct--</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('address_proof_company'); ?></span>
		</div>
        <div class="col-sm-3"><label class="btn btn-primary yellow-button">
    	<input type="file" name="address_proof_company_file" id="address_proof_company_file" style="display:none;" onchange="$('#upload-file-info2').html($(this).val());">BROWSE FILE</label>
        <span class="label label-info" id="upload-file-info2"></span></div>
        <div class="clear"></div>
		
        <div class="col-sm-4">VAT Registration Certificate</div>
        <div class="col-sm-4">
		<select name="vat_registration_certificate" id="vat_registration_certificate" class="module-select">
		<option value="">--select--</option>
		<option value="1">--Incorrect--</option>
		<option value="2">--Correct--</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('vat_registration_certificate'); ?></span>
		</div>
        <div class="col-sm-3"><label class="btn btn-primary yellow-button">
    	<input type="file" name="vat_registration_certificate_file" id="vat_registration_certificate_file" style="display:none;" onchange="$('#upload-file-info3').html($(this).val());">BROWSE FILE</label>
        <span class="label label-info" id="upload-file-info3"></span></div>
        <div class="clear"></div>
		
        <div class="col-sm-4">Shop  Establishment Certificate</div>
        <div class="col-sm-4">
		<select name="shop_establishment_certificate" id="shop_establishment_certificate" class="module-select">
		<option value="">--select--</option>
		<option value="1">--Incorrect--</option>
		<option value="2">--Correct--</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('shop_establishment_certificate'); ?></span>
		</div>
        <div class="col-sm-3"><label class="btn btn-primary yellow-button">
    	<input type="file" name="shop_establishment_certificate_file" id="shop_establishment_certificate_file" style="display:none;" onchange="$('#upload-file-info4').html($(this).val());">BROWSE FILE</label>
        <span class="label label-info" id="upload-file-info4"></span></div>
        <div class="clear"></div>
		
        <div class="col-sm-4">CIBIL Report</div>
        <div class="col-sm-4">
		<select name="cibil_report" id="cibil_report" class="module-select">
		<option value="">--select--</option>
		<option value="1">--Incorrect--</option>
		<option value="2">--Correct--</option>
		<option value="3">--Not Avilabale--</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('cibil_report'); ?></span>
		</div>
        <div class="col-sm-3"><label class="btn btn-primary yellow-button">
    	<input type="file" name="cibil_report_file" id="cibil_report_file" style="display:none;" onchange="$('#upload-file-info5').html($(this).val());">BROWSE FILE</label>
        <span class="label label-info" id="upload-file-info5"></span></div>
        <div class="clear"></div>
		
        <div class="col-sm-4">Defaulter List</div>
        <div class="col-sm-4">
		<select name="defaulter_list" id="defaulter_list" class="module-select">
		<option value="">--select--</option>
		<option value="1">--No--</option>
		<option value="2">--Yes--</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('defaulter_list'); ?></span>
		</div>
        <!--<div class="col-sm-3"><label class="btn btn-primary yellow-button">
    	<input type="file" style="display:none;" onchange="$('#upload-file-info6').html($(this).val());">BROWSE FILE</label>
        <span class="label label-info" id="upload-file-info6"></span></div>-->
        <div class="clear"></div>
		
		
		<div id="text1">
        
		
		</div>
		
		
		
		
        
        <div class="clear"></div>
		
		
		
        <div class="space30"></div>
        <h5 class="tab-form-head">Verification of Owner</h5>
        <div class="clear"></div>
        <div class="col-sm-3"></div>
		<div class="anaylst_scroll">
         <div class="col-sm-3"></div>    
        <div class="col-sm-3"><strong>Address</strong></div>
        <div class="col-sm-3"><strong>ID</strong></div>
        <div class="col-sm-3"><strong>CIBIL</strong></div>
        <div class="clear"></div>
		<?php if(!empty($owner_details)){?>
		<?php
		$val = 899; 
		?>
		<?php foreach($owner_details as $owner=>$values ){?>
		<input type="hidden" name="ownerid[]" value="<?php echo $values->id;?>"/>
        <div class="col-sm-3"><?php if(!empty($owner_details) && isset($values->name)){ echo ucwords($values->name);}else{?>Director 1 Name<?php } ?></div>
        <div class="col-sm-3">
		<select name="director1_name_address[]" id="director1_name_address<?php echo $val;?>" class="module-select">
		<option value="">--select--</option>
		<option value="1">--Incorrect--</option>
		<option value="2">--Correct--</option>
		</select><br>
        <label class="btn btn-primary yellow-button">
    	<input type="file" name="director1_name_address_file[]" id="director1_name_address_file<?php echo $val;?>" style="display:none;" onchange="$('#upload-file-info<?php echo $val;?>').html($(this).val());">BROWSE FILE</label>
        <span class="label label-info" id="upload-file-info<?php echo $val;?>"></span>
        </div>
		<?php $val++; ?>
        <div class="col-sm-3">
		<select name="director1_name_id[]" id="director1_name_id<?php echo $val;?>" class="module-select">
		<option value="">--select--</option>
		<option value="1">--Incorrect--</option>
		<option value="2">--Correct--</option>
		</select><br>
        <label class="btn btn-primary yellow-button">
    	<input type="file" name="director1_name_file[]" id="director1_name_file<?php echo $val;?>" style="display:none;" onchange="$('#upload-file-info<?php echo $val;?>').html($(this).val());">BROWSE FILE</label>
        <span class="label label-info" id="upload-file-info<?php echo $val;?>"></span>
        </div>
		<?php $val++; ?>
        <div class="col-sm-3">
		<select name="director1_name_cibilscore[]" id="director1_name_cibilscore<?php echo $val;?>" class="module-select">
		<option value="">--select--</option>
		<option value="1">--Incorrect--</option>
		<option value="2">--Correct--</option>
		</select><br>
        <label class="btn btn-primary yellow-button">
    	<input type="file" name="director1_name_cibilscore_file[]" id="director1_name_cibilscore_file<?php echo $val;?>" style="display:none;" onchange="$('#upload-file-info<?php echo $val.$owner;?>').html($(this).val());">BROWSE FILE</label>
        <span class="label label-info" id="upload-file-info<?php echo $val.$owner;?>"></span>
        </div>
        <div class="clear"></div>
		<?php } }?>
   		<input type="hidden" name="application_id" value="<?php echo $application_id;?>"/>
		</div>
		<hr class="top-margin20 yellow-hr">
        <div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default"><?php if($utype_id ==4 || $utype_id ==5){ echo "Next"; }else { echo "Submit";} ?></button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button">Cancel</button></div>
		<?php if($utype_id ==3) {?>
        <!--<div class="col-sm-3 top-padding10"><button type="button" class="yellow-button">Sent To Bank</button></div>-->
		<?php } ?>
        </div>
      </div>
	  
</form>
<?php } else { ?>

<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_analyst_upload_doc" enctype="multipart/form-data" method="post">

<?php
if($this->session->userdata('save_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
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
	<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Your Application is forwarded to Bank, we will get back to you shortly.<br/>Page will redirect automatically to dashboard page in <span id='timer'></span>.</strong></span>";
	$this->session->set_userdata('save_message','');
	} ?>
<div class="content-wrapper select">
        <div class="clear"></div>
        <h5 class="tab-form-head">Application Status     <span class="upload_msg"><img src="<?php echo base_url()?>assets/front/images/info_big.png" width="23px;"/>For Attachment: (pdf, jpg, jpeg only max size 2MB)</span></h5>
        <div class="p100">
        <div class="col-sm-4">PAN Card</div>
        <div class="col-sm-4">
		<select name="pan_card" id="pan_card" class="module-select">
		<option value="">--select--</option>
		<option value="1" <?php if($analyst_documents[0]->pan_card==1){ echo "selected"; }?>>--Incorrect--</option>
		<option value="2" <?php if($analyst_documents[0]->pan_card==2){ echo "selected"; }?>>--Correct--</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pan_card'); ?></span>
		</div>
		
        <div class="col-sm-3"><label class="btn btn-primary yellow-button">
    	<input type="file" name="pan_card_file" id="pan_card_file" value="" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">BROWSE FILE</label>
		<a href="<?php if($analyst_documents[0]->pan_card_file!=''){?><?php echo base_url()?>uploads/analyst_document/<?php echo $analyst_documents[0]->pan_card_file; ?><?php }else {echo "javascript:void(0)";}?>" target="_blank"><span class="label label-info" id="upload-file-info"><?php if($analyst_documents[0]->pan_card_file!=""){ echo $analyst_documents[0]->pan_card_file;}?></span></a></div>
        <div class="clear"></div>
		
        <div class="col-sm-4">Address Proof of Company Business</div>
        <div class="col-sm-4">
		<select name="address_proof_company" id="address_proof_company" class="module-select">
		<option value="">--select--</option>
		<option value="1" <?php if($analyst_documents[0]->address_proof_company==1){ echo "selected"; }?>>--Incorrect--</option>
		<option value="2" <?php if($analyst_documents[0]->address_proof_company==2){ echo "selected"; }?>>--Correct--</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('address_proof_company'); ?></span>
		</div>
        <div class="col-sm-3"><label class="btn btn-primary yellow-button">
    	<input type="file" name="address_proof_company_file" id="address_proof_company_file" style="display:none;" onchange="$('#upload-file-info2').html($(this).val());">BROWSE FILE</label>
        <a href="<?php if($analyst_documents[0]->address_proof_company_file!=''){?><?php echo base_url()?>uploads/analyst_document/<?php echo $analyst_documents[0]->address_proof_company_file; ?><?php }else {echo "javascript:void(0)";}?>" target="_blank"><span class="label label-info" id="upload-file-info2"><?php if($analyst_documents[0]->address_proof_company_file!=""){ echo $analyst_documents[0]->address_proof_company_file;}?></span></a></div>
        <div class="clear"></div>
		
        <div class="col-sm-4">VAT Registration Certificate</div>
        <div class="col-sm-4">
		<select name="vat_registration_certificate" id="vat_registration_certificate" class="module-select">
		<option value="">--select--</option>
		<option value="1" <?php if($analyst_documents[0]->vat_registration_certificate==1){ echo "selected"; }?>>--Incorrect--</option>
		<option value="2" <?php if($analyst_documents[0]->vat_registration_certificate==2){ echo "selected"; }?>>--Correct--</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('vat_registration_certificate'); ?></span>
		</div>
        <div class="col-sm-3"><label class="btn btn-primary yellow-button">
    	<input type="file" name="vat_registration_certificate_file" id="vat_registration_certificate_file" style="display:none;" onchange="$('#upload-file-info3').html($(this).val());">BROWSE FILE</label>
        <a href="<?php if($analyst_documents[0]->vat_registration_certificate_file!=''){?><?php echo base_url()?>uploads/analyst_document/<?php echo $analyst_documents[0]->vat_registration_certificate_file; ?><?php }else {echo "javascript:void(0)";}?>" target="_blank"><span class="label label-info" id="upload-file-info3"><?php if($analyst_documents[0]->vat_registration_certificate_file!=""){ echo $analyst_documents[0]->vat_registration_certificate_file;}?></span></a></div>
        <div class="clear"></div>
		
        <div class="col-sm-4">Shop  Establishment Certificate</div>
        <div class="col-sm-4">
		<select name="shop_establishment_certificate" id="shop_establishment_certificate" class="module-select">
		<option value="">--select--</option>
		<option value="1" <?php if($analyst_documents[0]->shop_establishment_certificate==1){ echo "selected"; }?>>--Incorrect--</option>
		<option value="2" <?php if($analyst_documents[0]->shop_establishment_certificate==2){ echo "selected"; }?>>--Correct--</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('shop_establishment_certificate'); ?></span>
		</div>
        <div class="col-sm-3"><label class="btn btn-primary yellow-button">
    	<input type="file" name="shop_establishment_certificate_file" id="shop_establishment_certificate_file" style="display:none;" onchange="$('#upload-file-info4').html($(this).val());">BROWSE FILE</label>
        <a href="<?php if($analyst_documents[0]->shop_establishment_certificate_file!=''){?><?php echo base_url()?>uploads/analyst_document/<?php echo $analyst_documents[0]->shop_establishment_certificate_file; ?><?php }else {echo "javascript:void(0)";}?>" target="_blank"><span class="label label-info" id="upload-file-info4"><?php if($analyst_documents[0]->shop_establishment_certificate_file!=""){ echo $analyst_documents[0]->shop_establishment_certificate_file;}?></span></a></div>
        <div class="clear"></div>
		
        <div class="col-sm-4">CIBIL Report</div>
        <div class="col-sm-4">
		<select name="cibil_report" id="cibil_report" class="module-select">
		<option value="">--select--</option>
		<option value="1" <?php if($analyst_documents[0]->cibil_report==1){ echo "selected"; }?>>--Incorrect--</option>
		<option value="2" <?php if($analyst_documents[0]->cibil_report==2){ echo "selected"; }?>>--Correct--</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('cibil_report'); ?></span>
		</div>
        <div class="col-sm-3"><label class="btn btn-primary yellow-button">
    	<input type="file" name="cibil_report_file" id="cibil_report_file" style="display:none;" onchange="$('#upload-file-info5').html($(this).val());">BROWSE FILE</label>
        <a href="<?php if($analyst_documents[0]->cibil_report_file!=''){?><?php echo base_url()?>uploads/analyst_document/<?php echo $analyst_documents[0]->cibil_report_file; ?><?php }else {echo "javascript:void(0)";}?>" target="_blank"><span class="label label-info" id="upload-file-info5"><?php if($analyst_documents[0]->cibil_report_file!=""){ echo $analyst_documents[0]->cibil_report_file;}?></span></a></div>
        <div class="clear"></div>
		
        <div class="col-sm-4">Defaulter List</div>
        <div class="col-sm-4">
		<select name="defaulter_list" id="defaulter_list" class="module-select">
		<option value="">--select--</option>
		<option value="1" <?php if($analyst_documents[0]->defaulter_list==1){ echo "selected"; }?>>--No--</option>
		<option value="2" <?php if($analyst_documents[0]->defaulter_list==2){ echo "selected"; }?>>--Yes--</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('defaulter_list'); ?></span>
		</div>
        <!--<div class="col-sm-3"><label class="btn btn-primary yellow-button">
    	<input type="file" style="display:none;" onchange="$('#upload-file-info6').html($(this).val());">BROWSE FILE</label>
        <span class="label label-info" id="upload-file-info6"></span></div>-->
        <div class="clear"></div>
		
		<?php if($analyst_documents[0]->defaulter_list==2){ ?>
		<div id="text1">
		<div class="col-sm-4">Type Of Defaulter</div>
        <div class="col-sm-4">
		<select name="type_of_defaulter" id="type_of_defaulter" class="module-select">
		<option value="">--select--</option>
		<option value="1" <?php if($analyst_documents[0]->type_of_defaulter==1){ echo "selected"; }?>>--Wilful--</option>
		<option value="2" <?php if($analyst_documents[0]->type_of_defaulter==2){ echo "selected"; }?>>--YES--</option>
		<option value="3" <?php if($analyst_documents[0]->type_of_defaulter==3){ echo "selected"; }?>>--Correct--</option>
		</select></div>
        <div class="col-sm-3"><label class="btn btn-primary yellow-button">
    	<input type="file" name="type_of_defaulter_file" id="type_of_defaulter_file" style="display:none;" onchange="$('#upload-file-info6').html($(this).val());">BROWSE FILE</label>
        <a href="<?php if($analyst_documents[0]->type_of_defaulter_file!=''){?><?php echo base_url()?>uploads/analyst_document/<?php echo $analyst_documents[0]->type_of_defaulter_file; ?><?php }else {echo "javascript:void(0)";}?>" target="_blank"><span class="label label-info" id="upload-file-info6"><?php if($analyst_documents[0]->type_of_defaulter_file!=""){ echo $analyst_documents[0]->type_of_defaulter_file;}?></span></a></div>
        </div>
		<div class="clear"></div>
		
		<?php } ?>
		
		<div id="text1">
		</div>
		
        <div class="space30"></div>
        <h5 class="tab-form-head">Verification of Owner</h5>
        <div class="clear"></div>
        <div class="col-sm-3"></div>
		<div class="anaylst_scroll">
        <div class="col-sm-3"><strong>Address</strong></div>
        <div class="col-sm-3"><strong>ID</strong></div>
        <div class="col-sm-3"><strong>CIBIL</strong></div>
        <div class="clear"></div>
        <?php if(!empty($owner_details)){?>
		<?php $i=count($owner_details);?>
		<?php
		$val = 899; 
		?>
		<?php foreach($owner_details as $k=>$values){ ?>
        <div class="col-sm-3"><?php if(!empty($owner_details) && isset($values->name)){ echo ucwords($values->name);}else{?>Director 1 Name<?php } ?></div>
        <div class="col-sm-3">
		<input type="hidden" name="analyst_director[]" value="<?php echo $analyst_director_documents[$k]->id;?>"/>
		<select name="director1_name_address[]" id="director1_name_address<?php echo $val; ?>" class="module-select">
		<option value="">--select--</option>
		<option value="1"<?php if($analyst_director_documents[$k]->director1_name_address==1){ echo "selected"; }?>>--Incorrect--</option>
		<option value="2"<?php if($analyst_director_documents[$k]->director1_name_address==2){ echo "selected"; }?>>--Correct--</option>
		</select><br>
        <label class="btn btn-primary yellow-button">
    	
		<input type="file" name="director1_name_address_file[]" id="director1_name_address_file<?php echo $val; ?>" style="display:none;" onchange="$('#upload-file-info<?php echo $val; ?>').html($(this).val());">BROWSE FILE</label>
		<a href="<?php if($analyst_director_documents[$k]->director1_name_address_file!=''){?><?php echo base_url()?>uploads/analyst_document/<?php echo $analyst_director_documents[$k]->director1_name_address_file; ?><?php }else {echo "javascript:void(0)";}?>" target="_blank"><span class="label label-info" id="upload-file-info<?php echo $val; ?>"><?php if($analyst_director_documents[$k]->director1_name_address_file!=""){ echo $analyst_director_documents[$k]->director1_name_address_file;}?></span></a>
        </div>
		<?php $val++; ?>
        <div class="col-sm-3">
		<select name="director1_name_id[]" id="director1_name_id<?php echo $val; ?>" class="module-select">
		<option value="">--select--</option>
		<option value="1"<?php if($analyst_director_documents[$k]->director1_name_id==1){ echo "selected"; }?>>--Incorrect--</option>
		<option value="2"<?php if($analyst_director_documents[$k]->director1_name_id==2){ echo "selected"; }?>>--Correct--</option>
		</select><br>
        <label class="btn btn-primary yellow-button">
    	<input type="file" name="director1_name_file[]" id="director1_name_file<?php echo $val; ?>" style="display:none;" onchange="$('#upload-file-info<?php echo $val; ?>').html($(this).val());">BROWSE FILE</label>
        <a href="<?php if($analyst_director_documents[$k]->director1_name_file!=''){?><?php echo base_url()?>uploads/analyst_document/<?php echo $analyst_director_documents[$k]->director1_name_file; ?><?php }else {echo "javascript:void(0)";}?>" target="_blank"><span class="label label-info" id="upload-file-info<?php echo $val; ?>"><?php if($analyst_director_documents[$k]->director1_name_file!=""){ echo $analyst_director_documents[$k]->director1_name_file;}?></span></a>
        </div>
		<?php $val++; ?>
        <div class="col-sm-3">
		<select name="director1_name_cibilscore[]" id="director1_name_cibilscore<?php echo $val; ?>" class="module-select">
		<option value="">--select--</option>
		<option value="1" <?php if($analyst_director_documents[$k]->director1_name_cibilscore==1){ echo "selected"; }?>>--Incorrect--</option>
		<option value="2" <?php if($analyst_director_documents[$k]->director1_name_cibilscore==2){ echo "selected"; }?>>--Correct--</option>
		</select><br>
        <label class="btn btn-primary yellow-button">
    	<input type="file" name="director1_name_cibilscore_file[]" id="director1_name_cibilscore_file<?php echo $val; ?>" style="display:none;" onchange="$('#upload-file-info<?php echo $val.$k; ?>').html($(this).val());">BROWSE FILE</label>
        <a href="<?php if($analyst_director_documents[$k]->director1_name_cibilscore_file!=''){?><?php echo base_url()?>uploads/analyst_document/<?php echo $analyst_director_documents[$k]->director1_name_cibilscore_file; ?><?php }else {echo "javascript:void(0)";}?>" target="_blank"><span class="label label-info" id="upload-file-info<?php echo $val.$k; ?>"><?php if($analyst_director_documents[$k]->director1_name_cibilscore_file!=""){ echo $analyst_director_documents[$k]->director1_name_cibilscore_file;}?></span></a>
        </div>
        <div class="clear"></div>
		<?php 
		$i++;} }?>
   		<input type="hidden" name="application_id" value="<?php echo $application_id;?>"/>
		<input type="hidden" name="flag" value="1"/>
		</div>
		<hr class="top-margin20 yellow-hr">
        <div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" value="1" name="submit"  class="yellow-button btn-default"><?php if($utype_id ==4 || $utype_id ==5){ echo "Next"; }else { echo "Submit";} ?></button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button">Cancel</button></div>
           <?php if($utype_id ==3){ ?>
		<!--<div class="col-sm-3 top-padding10"><button type="submit" value="0" name="save" class="yellow-button">Sent To Bank</button></div>-->
		   <?php } ?>
	   </div>
      </div>
	  
</form>

<?php }  ?>

