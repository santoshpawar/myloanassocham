<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>

<script>
$(document).ready(function(){
	
<?php if(validation_errors() =="") {?>
$(".requirederror").css("display","none");
<?php } ?>
	
	$('form#hold_frm').bind('submit',function(){
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#analyst_email").val();
			var analyst_mob_no = $("#analyst_mob_no").val().length;
			
			 if(!emailReg.test(emailaddress)){
				alert("Please enter valid Email address");
				return false;
			 }
			 var password = $("#new_password").val();
			 var password2 = $("#con_password").val();
			
			  if(password!=password2)
			  {
				alert('Password does not match.');
				return false;
			  }
			  else  if(analyst_mob_no < 10)
			 {
				 alert("Please enter 10 digits mobile no.");
				return false;
			 }			
	
	});
	
	 
	jQuery.validator.addClassRules("required", {
		  required: true
		});
		
				
				$('#analyst_mob_no').on('keyup blur input',function(){	
				var name=$(this).val();
				name=name.replace(/[^0-9]+/g, '');
				$(this).val(name);
				});
				
				$('#analyst_name').on('keyup blur input',function(){	
				var name=$(this).val();
				name=name.replace(/[^a-zA-Z ]+/g, '');
				$(this).val(name);
				});
				
				
				
				var v = $("#hold_frm").validate({
				rules:{
					
					analyst_name:{required:true},
					analyst_mob_no:{required:true},
					analyst_email:{required:true},
					}
				});	

		 
}); 

</script>

<div class="row">

      <form id="hold_frm" id="agenceyapp" method="post" action="<?php echo base_url();?>manage/dashboard/save_details" class="div-margin">
	 
		<?php
		if($this->session->userdata('error_message')){ ?>
		<script>
		$(document).ready(function(){
			$("#search_error").show().delay(3000).fadeOut('slow');
		})
		</script>
			<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Details has been save successfully.</strong></span>";
			$this->session->set_userdata('error_message','');
			}
		?>
		<?php
		if($this->session->userdata('pass_message')){ ?>
		<script>
		$(document).ready(function(){
			$("#search_error").show().delay(3000).fadeOut('slow');
		})
		</script>
			<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Password successfully updated.</strong></span>";
			$this->session->set_userdata('pass_message','');
			}
		?>
		<div class="col-lg-6">Analyst Name: <span class="star">*</span><br><input type="text" maxlength="50" name="analyst_name" id="analyst_name" value="<?php echo $user_details[0]->analyst_name; ?>" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('analyst_name'); ?></span>
		</div>
		<div class="col-lg-6">Analyst Mobile Number: <span class="star">*</span><br><input type="text" maxlength="10" readonly name="analyst_mob_no" id="analyst_mob_no" value="<?php echo $user_details[0]->analyst_mob_no; ?>" class="module-input" placeholder="This will be your Login ID">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('analyst_mob_no'); ?></span>
		</div>
        <div class="clear"></div>
		<div class="col-lg-6">Analyst Email Id: <span class="star">*</span><br><input type="text" readonly name="analyst_email" id="analyst_email" value="<?php echo $user_details[0]->analyst_email; ?>" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('analyst_email'); ?></span>
		</div>
		
        <div class="clear"></div>
		

		<div class="col-lg-6">Select Password:<br><input type="password" id="new_password" name="password" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('password'); ?></span>
		</div>
		<div class="col-lg-6">Confirm Password:<br><input type="password" id="con_password" name="con_password" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('con_password'); ?></span>
		</div>
        <div class="clear"></div>
        <div class="col-lg-4"></div>
        <div class="col-lg-2 col-sm-6 col-xs-12 text-right" style="margin-top:15px;"><button type="submit" id="contact_btn" class="btn btn-default">Submit</button></div>
        <div class="col-lg-2 col-sm-6 col-xs-12" style="margin-top:15px;"><button type="button" class="btn btn-default">Cancel</button></div>
        <div class="col-lg-4"></div>
      </form>
    </div>





