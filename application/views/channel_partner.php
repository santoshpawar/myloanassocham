<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>

<script>
	$(document).ready(function(){

		$('#check').click(function(){
			if ($(this).is(':checked')){
				$(this).val(1);
			}
			else{
				$(this).val(0);
			}
		});	

		<?php if(validation_errors() =="") {?>
			$(".requirederror").css("display","none");
			<?php } ?>

			$("#cancel_btn").click(function(){
				window.location.href='<?php echo base_url();?>Register';
			});			


			







			jQuery.validator.addClassRules("required", {
				required: true
			});

			$('#advisor_mob_no').on('keyup blur input',function(){	
				var name=$(this).val();
				name=name.replace(/[^0-9]+/g, '');
				$(this).val(name);
			});


			$('#advisor_name').on('keyup blur input',function(){	
				var name=$(this).val();
				name=name.replace(/[^a-zA-Z ]+/g, '');
				$(this).val(name);
			});



			var v = $("#hold_frm").validate({
				rules:{
					advisor_name:{required:true},
					advisor_mob_no:{required:true},
					advisor_email:{required:true},
					advisor_pan:{required:true},
					password:{required:true},
					con_password:{required:true},
					
				}
			});	


			$("#advisor_mob_no").blur(function(){
				var advisor_mob_no = $("#advisor_mob_no").val();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>home/mobile_checking_partner",
					data: { advisor_mob_no: advisor_mob_no},

					success: function(data){
						if(data==1)
						{
							$("#advisor_mob").html("Mobile number already exists!");
							$("#contact_btn").attr('disabled','disabled');
						}else{
							$("#advisor_mob").html("");
							$("#contact_btn").removeAttr('disabled','disabled');
							var advisor_email = $("#advisor_email").val();
							$.ajax({
								type: "POST",
								url: "<?php echo base_url();?>home/email_checking_partner",
								data: { advisor_email: advisor_email},

								success: function(data){
									if(data==1)
									{
										$("#email_exists").html("Email already exists!");
										$("#contact_btn").attr('disabled','disabled');
									}else{
										$("#email_exists").html("");
										$("#contact_btn").removeAttr('disabled','disabled');

									}
								}
							});

						}
					}
				});
				
			});
			
			$("#advisor_email").blur(function(){
				var advisor_email = $("#advisor_email").val();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>home/email_checking_partner",
					data: { advisor_email: advisor_email},

					success: function(data){
						if(data==1)
						{
							$("#email_exists").html("Email already exists!");
							$("#contact_btn").attr('disabled','disabled');
						}else{
							$("#email_exists").html("");
							$("#contact_btn").removeAttr('disabled','disabled');

							var advisor_mob_no = $("#advisor_mob_no").val();
							$.ajax({
								type: "POST",
								url: "<?php echo base_url();?>home/mobile_checking_partner",
								data: { advisor_mob_no: advisor_mob_no},

								success: function(data){
									if(data==1)
									{
										$("#advisor_mob").html("Mobile number already exists!");
										$("#contact_btn").attr('disabled','disabled');
									}else{
										$("#advisor_mob").html("");
										$("#contact_btn").removeAttr('disabled','disabled');


									}
								}
							});

						}
					}
				});
				
			}); 
			
			
			$("#advisor_pan").blur(function(){
				var advisor_pan = $(this).val();
				//alert(advisor_pan);
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>home/pan_checking_partner",
					data: { advisor_pan: advisor_pan},

					success: function(data){
						if(data==1)
						{
							$("#pan_exists").html("PAN already registered");
							$("#contact_btn").attr('disabled','disabled');
						}else{
							$("#pan_exists").html("");
							$("#contact_btn").removeAttr('disabled','disabled');
							var advisor_email = $("#advisor_email").val();
							$.ajax({
								type: "POST",
								url: "<?php echo base_url();?>home/email_checking_partner",
								data: { advisor_email: advisor_email},

								success: function(data){
									if(data==1)
									{
										$("#email_exists").html("Email already exists!");
										$("#contact_btn").attr('disabled','disabled');
									}else{
										$("#email_exists").html("");
										$("#contact_btn").removeAttr('disabled','disabled');

									}
								}
							});
							var advisor_mob_no = $("#advisor_mob_no").val();
							$.ajax({
								type: "POST",
								url: "<?php echo base_url();?>home/mobile_checking_partner",
								data: { advisor_mob_no: advisor_mob_no},

								success: function(data){
									if(data==1)
									{
										$("#advisor_mob").html("Mobile number already exists!");
										$("#contact_btn").attr('disabled','disabled');
									}else{
										$("#advisor_mob").html("");
										$("#contact_btn").removeAttr('disabled','disabled');


									}
								}
							});

						}
					}
				});
				
			});


		});


function fnValidatePAN(Obj) {
	if (Obj == null) Obj = window.event.srcElement;
	if (Obj.value != "") {
		ObjVal = Obj.value;

			//alert(ObjVal);
			var pan_enterprise = ObjVal.length;
            //var panPat = /^([a-zA-Z]{5})(\d{4})([a-zA-Z]{1})([A-Z0-9]{10})$/;
            var panPat = "^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$";
            var code = /([C,P,H,F,A,T,B,L,J,G])/;
            var code_chk = ObjVal.substring(3,4);
			//alert(ObjVal.search(panPat));
			if (ObjVal.search(panPat) == -1) {
                //alert("Invalid Pan No");
                //Obj.focus();
				//return false;
				$("#span_pan").html("<p>Invalid Pan No.</p>");
				$("#contact_btn").attr('disabled','disabled');

			}else{
				$("#span_pan").html("");
				$("#contact_btn").removeAttr('disabled','disabled');
			}			

		}else{
			$("#span_pan").html("");
			$("#contact_btn").removeAttr('disabled','disabled');
		}
	}



</script>




<section id="inner-pages">
	<div class="container">



		<?php
		if($this->session->userdata('error_message')){ ?>
		<script>
			$(document).ready(function(){
			//$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='search_error' style='color:#1797a2; padding-left:50px;'><strong>Email Id exist! Please use another email.</strong></span>";
	$this->session->set_userdata('error_message','');
} ?>


<div class="row">
	<h2 class="left-padding module-head text-center">Channel Partner Registration</h2>
	<form role="form" id="hold_frm" method="post" action="<?php echo base_url();?>home/channel_partner_registration" class="div-margin">
		<div class="col-lg-6" style="padding: 0 0 30px 8px;">Advisor Name: <span class="star">*</span><br><input type="text" maxlength="50" name="advisor_name" id="advisor_name" value="<?php echo set_value('advisor_name'); ?>" class="module-input">
			<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('advisor_name'); ?></span>
		</div>
		<div class="col-lg-6" style="padding: 0 0 30px 8px;">Advisor's Mobile No.: <span class="star">*</span><br><input type="text" maxlength="10" name="advisor_mob_no" id="advisor_mob_no" value="<?php echo set_value('advisor_mob_no'); ?>" class="module-input" placeholder="This will be your Login ID | OTP will be sent on this No.">
			<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('advisor_mob_no'); ?></span>
		</div>
		<div class="clear"></div>
		<div class="col-lg-6" style="padding: 0 0 30px 8px;">Advisor's Email ID: <span class="star">*</span><br><input type="text" name="advisor_email" id="advisor_email" value="<?php echo set_value('advisor_email'); ?>" class="module-input" placeholder="This will be your Login ID">
			<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('advisor_email'); ?></span>
		</div>
		<div id="advisor_mob"></div>
		<div class="col-lg-6" style="padding: 0 0 30px 8px;">Advisor's PAN: <span class="star">*</span><br><input type="text" maxlength="10" onblur="fnValidatePAN(this);"  name="advisor_pan" id="advisor_pan" style="text-transform: uppercase" value="<?php echo set_value('advisor_pan'); ?>" class="module-input"><span id="span_pan"></span>
			<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('advisor_pan'); ?></span>
		</div>
		<div class="clear"></div>
		<div id="email_exists"></div>
		<div class="col-lg-6" style="padding: 0 0 30px 8px;">Select Password: <span class="star">*</span><br><input type="password" name="password" id="new_password" class="module-input">
			<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('password'); ?></span>
		</div>
		<div id="pan_exists"></div>
		<div class="col-lg-6" style="padding: 0 0 30px 8px;">Confirm Password: <span class="star">*</span><br><input type="password" name="con_password" id="con_password" class="module-input">
			<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('con_password'); ?></span>
		</div>
		<input type="hidden" name="created_dtm">
		<input type="hidden" name="utype_id" value="1">
		<div class="clear"></div>
		<div class="col-lg-4"></div>
		<div class="col-lg-2 col-sm-6 col-xs-12 text-right" style="margin-top:15px;"><button type="submit" id="contact_btn" class="btn btn-default">Submit</button></div>
		<div class="col-lg-2 col-sm-6 col-xs-12 text-right" style="margin-top:15px;"><button type="button" id="cancel_btn" class="btn btn-default">Cancel</button></div>
		<div class="col-lg-4"></div>
	</form>
</div>




</div>
</section>