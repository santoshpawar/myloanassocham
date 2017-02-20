<script src="<?php echo base_url()?>assets/front/js/jquery-ui.js"></script>
<link href="<?php echo base_url()?>assets/front/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>
<script>
$(document).ready(function(){
			
		<?php if(validation_errors() =="") {?>
		$(".requirederror").css("display","none");
		<?php } ?>
				
			<?php if(($utype_id ==5  || $utype_id ==4 || $utype_id ==3 || $utype_id ==2 || $utype_id ==1) && (!empty($application_id) && !empty($bank_application))){?>
				$('input,textarea').each(function() { 
					//$(this).attr('disabled', true);
					$(this).attr('readonly', true);
					//$(this).rules('remove');
		
        
		
				});
				$('select').each(function() { 
					//$(this).attr('disabled', true);
					$(this).attr('disabled', true);
				   
					
				});
			<?php } ?>	
				$("#cancel_btn").click(function(){
					 window.location.href='<?php echo base_url();?>manage/dashboard/loan_application_list';
				 });
				 
				var v = $("#hold_frm").validate({
				rules:{
					

					status:{required:true},
					comment:{required:true},
					branch_details:{required:true},
					preson_name:{required:true},
					person_mobile_no:{required:true},
					email_id:{required:true},
					}
				});
				
				$('#person_mobile_no').on('keyup blur input',function(){	
					var name=$(this).val();
					name=name.replace(/[^0-9]+/g, '');
					$(this).val(name);
				});
				
				$('#preson_name').on('keyup blur input',function(){	
					var name=$(this).val();
					name=name.replace(/[^a-zA-Z ]+/g, '');
					$(this).val(name);
				});
				
				$('#person_mobile_no').on("keyup input blur",function(){
					//alert("afasd");
				var person_mobile_no = $(this).val().length;
				var mob_no = $(this).val();
				if(mob_no!=""){
					if(person_mobile_no < 10)
					 {
						  $("#mobile_no").html("<p>Enter 10 digits Mobile no.</p>");
						  $("#submit_btn").attr('disabled','disabled');
					 }else{
						  $("#mobile_no").html("");
						  $("#submit_btn").removeAttr('disabled','disabled');
					 }
				}else{
					 $("#mobile_no").html("");
					 $("#submit_btn").removeAttr('disabled','disabled');
				}
			
			});
			
			
			$('#email_id').on("keyup input blur",function(){
				var email_id = $(this).val();
				validateEmail(email_id);
			
			});
			
		});
			
			
	function validateEmail(email) {
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#email_id").val();
			
			 if(!emailReg.test(emailaddress) || emailaddress=="")
			 {
					  $("#span_email").html("<p>Enter valid Email Id.</p>");
					  $("#submit_btn").attr('disabled','disabled');
				 }else{
					  $("#span_email").html("");
					  $("#submit_btn").removeAttr('disabled','disabled');
				 } 
		}
		
</script>
<?php if(!empty($application_id) && empty($bank_application)) {?>
<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_bank_status" enctype="multipart/form-data" method="post">
 
   <?php
if($this->session->userdata('error_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='search_error' style='color:#1797a2; padding-left:50px;'><strong>Application Processed</strong></span>";
	$this->session->set_userdata('error_message','');
	} ?>        
      <div class="content-wrapper select">
        <div class="clear"></div>
        <h5 class="tab-form-head">Application Status</h5>
        <div class="p100">
        <div class="col-sm-4">Status of Application <span class="star">*</span></div>
        <div class="col-sm-5"><select name="status" id="status" class="module-select">
        <option value="">--select--</option>
        <option value="1">In-principle approved</option>
        <option value="0">Rejected</option>
        </select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('status'); ?></span>
		</div>
        <div class="col-sm-3"></div>
        <div class="clear"></div>
        <div class="col-sm-4">Comment <span class="star">*</span></div>
        <div class="col-sm-5"><textarea name="comment" id="comment" class="module-text"></textarea>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('comment'); ?></span>
		</div>
        <div class="col-sm-3"></div>
        <div class="clear"></div>
        <div class="col-sm-4">Branch Details <span class="star">*</span></div>
        <div class="col-sm-5"><textarea maxlength="500" name="branch_details" id="branch_details" class="module-text"></textarea>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('branch_details'); ?></span>
		</div>
        <div class="col-sm-3"></div>
        <div class="clear"></div>
        <div class="col-sm-4">Person to Contact <span class="star">*</span></div>
        <div class="col-sm-5"><input type="text" maxlength="500" name="preson_name" id="preson_name" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('preson_name'); ?></span>
		</div>
        <div class="col-sm-3"></div>
        <div class="clear"></div>
        <div class="col-sm-4">Contact Person Mobile No. <span class="star">*</span></div>
        <div class="col-sm-5"><input type="text" maxlength="10" name="person_mobile_no" id="person_mobile_no" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('person_mobile_no'); ?></span>
		</div>
		<span id="mobile_no" class="dis_msg"></span>
        <div class="col-sm-3"></div>
        <div class="clear"></div>
        <div class="col-sm-4">Contact Person Email ID <span class="star">*</span></div>
        <div class="col-sm-5"><input type="text" name="email_id" id="email_id" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('email_id'); ?></span>
		</div>
		<span id="span_email"></span>
        <div class="col-sm-3"></div>
        <div class="clear"></div>
		<input type="hidden" name="application_id" value="<?php echo $application_id;?>" />
		<hr class="top-margin20 yellow-hr">
        <!--<div class="col-sm-3 top-padding10"><button type="submit" value="1" name="submit" id="submit_btn"  class="yellow-button">SAVE &amp; Continue</button></div>-->
		<div class="col-sm-3 top-padding10"><button type="submit"  id="submit_btn"  class="yellow-button">Save &amp; Continue</button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button">Cancel</button></div>
        <!--<div class="col-sm-3 top-padding10"><button type="submit" value="0" name="save" class="yellow-button">Submit</button></div>-->
        </div>
      </div>
	  </form>
<?php } else { ?>
<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_bank_status" enctype="multipart/form-data" method="post">
   <?php if(validation_errors() !="") {?>
<script>
		$(document).ready(function(){
			$("#validate_error").show().delay(5000).fadeOut('slow');
		})
	</script>
<span id='validate_error' class='alert alert-success alrt_md'><strong><?php echo validation_errors(); ?></strong></span>
<?php } ?>
   <?php
if($this->session->userdata('error_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Application Processed</strong></span>";
	$this->session->set_userdata('error_message','');
	} ?>      
      <div class="content-wrapper select">
        <div class="clear"></div>
        <h5 class="tab-form-head">Application Status</h5>
        <div class="p100">
        <div class="col-sm-4">Status of Application <span class="star">*</span></div>
        <div class="col-sm-5"><select name="status" id="status" class="module-select">
		<option value="">--select--</option>
        <option value="1"<?php if($bank_application[0]->status=="1"){ echo "selected";}?>>In-principle approved</option>
        <option value="0"<?php if($bank_application[0]->status=="0"){ echo "selected";}?>>Rejected</option>
        </select></div>
        <div class="col-sm-3"></div>
        <div class="clear"></div>
        <div class="col-sm-4">Comment <span class="star">*</span></div>
        <div class="col-sm-5"><textarea name="comment" id="comment" class="module-text"><?php echo $bank_application[0]->comment;?></textarea></div>
        <div class="col-sm-3"></div>
        <div class="clear"></div>
        <div class="col-sm-4">Branch Details <span class="star">*</span></div>
        <div class="col-sm-5"><textarea maxlength="500" name="branch_details" id="branch_details" class="module-text"><?php echo $bank_application[0]->branch_details;?></textarea></div>
        <div class="col-sm-3"></div>
        <div class="clear"></div>
        <div class="col-sm-4">Person to Contact <span class="star">*</span></div>
        <div class="col-sm-5"><input type="text" maxlength="500" name="preson_name" value="<?php echo $bank_application[0]->preson_name;?>" id="preson_name" class="module-input"></div>
        <div class="col-sm-3"></div>
        <div class="clear"></div>
        <div class="col-sm-4">Contact Person Mobile No. <span class="star">*</span></div>
        <div class="col-sm-5"><input type="text" maxlength="10" name="person_mobile_no" value="<?php echo $bank_application[0]->person_mobile_no;?>" id="person_mobile_no" class="module-input"></div>
		<span id="mobile_no" class="dis_msg"></span>
        <div class="col-sm-3"></div>
        <div class="clear"></div>
        <div class="col-sm-4">Contact Person Email ID <span class="star">*</span></div>
        <div class="col-sm-5"><input type="text" name="email_id" value="<?php echo $bank_application[0]->email_id;?>" id="email_id" class="module-input"></div>
        <span id="span_email"></span>
		<div class="col-sm-3"></div>
        <div class="clear"></div>
		<input type="hidden" name="flag" value="1"/>
		<input type="hidden" name="application_id" value="<?php echo $application_id;?>" />
		<hr class="top-margin20 yellow-hr">
        <div class="col-sm-3 top-padding10"><button type="button" value="1" name="submit" disabled="disabled" id="submit_btn" class="yellow-button"><?php if($utype_id==4){ echo "Save &amp; Continue" ;}else { echo "Next";}?></button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button">Cancel</button></div>
        <!--<div class="col-sm-3 top-padding10"><button type="submit" value="0" name="save" id="submit_btn" class="yellow-button">Submit</button></div>-->
        </div>
      </div>
	  </form>
<?php } ?>   