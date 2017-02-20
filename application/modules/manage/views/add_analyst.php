<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>


<script type="text/javascript">
$(document).ready(function(){
	
<?php if(validation_errors() =="") {?>
$(".requirederror").css("display","none");
<?php } ?>

 $("#add_bank").click(function(){
	 //alert("asdsd");
	 window.location.href='<?php echo base_url();?>manage/dashboard/add_bank';
 });
 
	$("#cancel_btn").click(function(){
	 window.location.href='<?php echo base_url();?>manage/dashboard';
	});
	
			
		$('form#hold_frm').bind('submit',function(){
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#analyst_email").val();
			var password = $("#password").val();
	        var password2 = $("#conf_password").val();
			var analyst_mob_no = $("#analyst_mob_no").val().length;
			/*  if(emailaddress!=""){
				 if(!emailReg.test(emailaddress)){
					alert("Please enter valid Email address");
					return false;
				 }
			 } */
						 
			  if(password!=password2)
			  {
				alert('Password does not match.');
				return false;
			  }
			 /*  if(analyst_mob_no < 10 && analyst_mob_no > 0)
			 {
				 alert("Please enter 10 digits mobile no.");
				return false;
			 } */
		 
				
	});
	
	jQuery.validator.addClassRules("required", {
		  required: true
		});
		
		
		 $('#analyst_mob_no').on("keyup input blur",function(){
				var analyst_mob_no = $(this).val().length;
				if(analyst_mob_no !=""){
				 if(analyst_mob_no < 10)
				 {
					  $("#span_mob_no").html("Enter 10 digits mobile no.");
					  $("#submit_btn").attr('disabled','disabled');
				 }else{
					  $("#span_mob_no").html("");
					  $("#submit_btn").removeAttr('disabled','disabled');
				 } 
				}else{
					 $("#span_mob_no").html("");
					 $("#submit_btn").removeAttr('disabled','disabled');					
				}
			
			});
	
	
	$("#analyst_email").blur(function(){
				var owner_email = $("#analyst_email").val();
				 $.ajax({
				  type: "POST",
				  url: "<?php echo base_url();?>home/email_checking_msme",
				  data: { owner_email: owner_email},
				  
				  success: function(data){
					  if(data==1)
					  {
						  $("#email_exists").html("Email already exists!");
						  $("#submit_btn").attr('disabled','disabled');
					  }else{
						  $("#email_exists").html("");
						  $("#submit_btn").removeAttr('disabled','disabled');
						 
							var mob_no = $("#analyst_mob_no").val();
							 $.ajax({
							  type: "POST",
							  url: "<?php echo base_url();?>home/mobile_checking_msme",
							  data: { mob_no: mob_no},
							  
							  success: function(data){
								  if(data==1)
								  {
									  $("#mob_no_msme").html("Mobile number already exists!");
									  $("#submit_btn").attr('disabled','disabled');
								  }else{
									  $("#mob_no_msme").html("");
									  $("#submit_btn").removeAttr('disabled','disabled');
									  
								  }
							  }
							});
					  }
				  }
				});
			
		});
		
		$("#analyst_mob_no").blur(function(){
				 var mob_no = $("#analyst_mob_no").val();
				 $.ajax({
				  type: "POST",
				  url: "<?php echo base_url();?>home/mobile_checking_msme",
				  data: { mob_no: mob_no},
				  
				  success: function(data){
					  if(data==1)
					  {
						  $("#mob_no_msme").html("Mobile number already exists!");
						  $("#submit_btn").attr('disabled','disabled');
					  }else{
						  $("#mob_no_msme").html("");
						  $("#submit_btn").removeAttr('disabled','disabled');
						  var owner_email = $("#analyst_email").val();
							 $.ajax({
							  type: "POST",
							  url: "<?php echo base_url();?>home/email_checking_msme",
							  data: { owner_email: owner_email},
							  
							  success: function(data){
								  if(data==1)
								  {
									  $("#email_exists").html("Email already exists!");
									  $("#submit_btn").attr('disabled','disabled');
								  }else{
									  $("#email_exists").html("");
									  $("#submit_btn").removeAttr('disabled','disabled');
								  }
							  }
							});
						  
					  }
				  }
				});
		});	

		var v = $("#hold_frm").validate({

				rules:{
						'analyst_name': {
							required: true
						},
						'analyst_mob_no': {
							required: true
						},
						'analyst_email': {
							required: true
						},
						'designation': {
							required: true
						},
						'password': {
							required: true
						},
						'conf_password': {
							required: true
						}, 
					}
				});	
				
				
			//Start numeric,char,dot validation
			$('#analyst_mob_no').on('keyup',function(){	
				var name=$(this).val();
				name=name.replace(/[^0-9]+/g, '');
				$(this).val(name);
			});
			
			$('#analyst_name').on('keyup',function(){	
					var name=$(this).val();
					name=name.replace(/[^a-zA-Z ]+/g, '');
					$(this).val(name);
				});
				
			$('#analyst_email').on("keyup input blur",function(){
				var email = $(this).val();
				validateEmail(email);
			
			});
		
		
});

function validateEmail(email) {
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#analyst_email").val();
			if(emailaddress !=""){
			 if(!emailReg.test(emailaddress))
			 {
					  $("#span_email").html("Enter valid Email Id.");
					  $("#submit_btn").attr('disabled','disabled');
				 }else{
					  $("#span_email").html("");
					  $("#submit_btn").removeAttr('disabled','disabled');
				 } 
			}else{
				$("#span_email").html("");
				$("#submit_btn").removeAttr('disabled','disabled');
			}
		}
		
				
		</script>
<style>
span.requirederror{
	puser_detailsding-left:5px;
}

</style>

	
<div class="row">

<form id="hold_frm" name="add_analyst" method="post" action="<?php echo base_url()?>manage/dashboard/saveAnalyst" class="div-margin line-height40">
<!--<?php if(validation_errors() !="") {?>
<script>
		$(document).ready(function(){
			$("#validate_error").show().delay(5000).fadeOut('slow');
		})
	</script>
<span id='validate_error' class='alert alert-success alrt_md'><strong><?php echo validation_errors(); ?></strong></span>
<?php } ?>-->
<?php
if($this->session->userdata('error_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Analyst has been saved successfully.</strong></span>";
	$this->session->set_userdata('error_message','');
	} ?>	
	
<div class="col-sm-3">Analyst Name: <span class="star">*</span></div>
<div class="col-sm-6"><input type="text" maxlength="50" name="analyst_name" id="analyst_name" value="<?php echo set_value('analyst_name'); ?>" class="module-input">
<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('analyst_name'); ?></span>
</div>
<div class="col-sm-3"></div>
<div class="clear"></div>
<div class="col-sm-3">Analyst Mobile Number: <span class="star">*</span></div>
<div class="col-sm-6"><input type="text" maxlength="10" name="analyst_mob_no" id="analyst_mob_no" value="<?php echo set_value('analyst_mob_no'); ?>" class="module-input">
<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('analyst_mob_no'); ?></span>
</div>
<div class="col-sm-3"><span class="lg-m">(This is your Login ID)</span><div id="mob_no_msme" style="color:blue;" ></div><span id="span_mob_no"></span></div>
<div class="clear"></div>
<div class="col-sm-3">Analyst Email ID: <span class="star">*</span></div>
<div class="col-sm-6"><input type="text" name="analyst_email" id="analyst_email" value="<?php echo set_value('analyst_email'); ?>" class="module-input">
<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('analyst_email'); ?></span>
</div>
<div class="col-sm-3"><span class="lg-m">(This is your Login ID)</span><div id="email_exists" style="color:blue;"></div><span id="span_email"></span></div>
<div class="clear"></div>
<div class="col-sm-3">New Password: <span class="star">*</span></div>
<div class="col-sm-6"><input type="password" name="password" id="password" value="<?php echo set_value('password'); ?>" class="module-input">
<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('password'); ?></span>
</div>
<div class="col-sm-3"></div>
<div class="clear"></div>
<div class="col-sm-3">Confirm Password: <span class="star">*</span></div>
<div class="col-sm-6"><input type="password" name="conf_password" id="conf_password" value="<?php echo set_value('conf_password'); ?>" class="module-input">
<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('conf_password'); ?></span>
</div>
<div class="col-sm-3"></div>
<div class="clear"></div>
<hr class="top-margin20 yellow-hr">
<div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button">Submit</button></div>
<div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button">Cancel</button></div>

    </form>
    </div>

