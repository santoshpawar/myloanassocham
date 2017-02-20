<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>


<script>
$(document).ready(function(){
	
		<?php if(validation_errors() =="") {?>
		$(".requirederror").css("display","none");
		<?php } ?>
	
	var selState = $("#state").val();
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
                    });
					
	$('form#hold_frm').bind('submit',function(){
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#email").val();
			
			var pan_firm = $("#pan_firm").val().length;
			var pincode = $("#pincode").val().length;
			var mob_no = $("#mob_no").val().length;
			//var landline = $("#landline").val().length;
			
			 if(emailaddress==""){
				alert("Please fill up all required fields");
				return false;
			 } 
			 if(!emailReg.test(emailaddress) || emailaddress==""){
				alert("Please enter valid Email address");
				return false;
			 }
		 
			var password = $("#new_password").val();
			var password2 = $("#con_password").val();
			if(password=="")
			  {
				alert('Please enter new password.');
				return false;
			  }
			  else if(password2=="")
			  {
				alert('Please enter confirm password.');
				return false;
			  }
			  else if(password!=password2)
			  {
				alert('Password does not match.');
				return false;
			  }
			 else if(pincode < 6 && pincode > 0)
			 {
				 alert("Please enter 6 digits pincode.");
				return false;
			 }
			else  if(mob_no < 10 && mob_no > 0)
			 {
				 alert("Please enter 10 digits contact no.");
				return false;
			 }
			 
	
	});
	
	$("#cancel_btn").click(function(){
		window.location.href='<?php echo base_url();?>Register';
	});
	
	 /* $('input#turnover').keyup(function(){
		var number = $(this).val();
		number.toLocaleString();
	}); */
	
	
	 
	jQuery.validator.addClassRules("required", {
		  required: true
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
				
				
				$('#mob_no,#landline,#pincode').on('keyup blur input',function(){	
				var name=$(this).val();
				name=name.replace(/[^0-9]+/g, '');
				$(this).val(name);
				});
				
				$('#enterprise_name,#owner_name').on('keyup blur input',function(){	
				var name=$(this).val();
				name=name.replace(/[^a-zA-Z ]+/g, '');
				$(this).val(name);
				});
				
				$('#turnover').on('keyup blur input',function(){	
				var name=$(this).val();
				name=name.replace(/[^0-9.]+/g, '');
				$(this).val(name);
				});
				
				
				
				var v = $("#hold_frm").validate({
				rules:{
					
					enterprise_name:{required:true},
					legal_entity:{required:true},
					constitution:{required:true},
					category:{required:true},
					state:{required:true},
					city:{required:true},
					owner_name:{required:true},
					pan_firm:{required:true},
					owner_email:{required:true},
					mob_no:{required:true},
					pincode:{required:true},
					address1:{required:true},	
					latest_audited_turnover:{required:true},	
					password:{required:true},
					con_password:{required:true},
					
					}
				});	
				
		$("#turnover").on("keyup input blur",function(){
			/* var val1=$(this).val();
			var val2 = val1.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			$(this).val(val2); */
				var val1=$(this).val();
				x=val1.toString();
				if (x.indexOf('.') == -1) {
				    var lastThree = x.substring(x.length-3);
					var otherNumbers = x.substring(0,x.length-3);
					if(otherNumbers != '')
						lastThree = ',' + lastThree;
					var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
					//alert(res);
					if(res=="0"){
						$(this).val("");
					}else{
						$(this).val(res);
					}
				}else{
					//$(this).val(val1);
					if(val1=="."){
								$(this).val("");
							}else{
								$(this).val(val1);
							}
				}
		});		
		
		$("#email").blur(function(){
			var owner_email = $("#email").val();
				 $.ajax({
				  type: "POST",
				  url: "<?php echo base_url();?>home/email_checking_msme",
				  data: { owner_email: owner_email},
				  
				  success: function(data){
					  if(data==1)
					  {
						  $("#email_exists").html("Email already exists!");
						  $("#contact_btn").attr('disabled','disabled');
					  }else{
						  $("#email_exists").html("");
						  $("#contact_btn").removeAttr('disabled','disabled');
						 
							var mob_no = $("#mob_no").val();
							 $.ajax({
							  type: "POST",
							  url: "<?php echo base_url();?>home/mobile_checking_msme",
							  data: { mob_no: mob_no},
							  
							  success: function(data){
								  if(data==1)
								  {
									  $("#mob_no_msme").html("Mobile number already exists!");
									  $("#contact_btn").attr('disabled','disabled');
								  }else{
									  $("#mob_no_msme").html("");
									  $("#contact_btn").removeAttr('disabled','disabled');
									  
								  }
							  }
							});
					  }
				  }
				});
			
		});
		
		$("#mob_no").blur(function(){
				 var mob_no = $("#mob_no").val();
				 $.ajax({
				  type: "POST",
				  url: "<?php echo base_url();?>home/mobile_checking_msme",
				  data: { mob_no: mob_no},
				  
				  success: function(data){
					  if(data==1)
					  {
						  $("#mob_no_msme").html("Mobile number already exists!");
						  $("#contact_btn").attr('disabled','disabled');
					  }else{
						  $("#mob_no_msme").html("");
						  $("#contact_btn").removeAttr('disabled','disabled');
						  var owner_email = $("#email").val();
							 $.ajax({
							  type: "POST",
							  url: "<?php echo base_url();?>home/email_checking_msme",
							  data: { owner_email: owner_email},
							  
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
		
		
		$("#pan_firm").blur(function(){
			var pan_firm = $(this).val();
				 $.ajax({
				  type: "POST",
				  url: "<?php echo base_url();?>home/pan_checking_msme",
				  data: { pan_firm: pan_firm},
				  
				  success: function(data){
					  if(data==1)
					  {
						  $("#pan_exists").html("PAN already registered");
						  $("#contact_btn").attr('disabled','disabled');
					  }else{
						  $("#pan_exists").html("");
						  $("#contact_btn").removeAttr('disabled','disabled');
						 
							var mob_no = $("#mob_no").val();
							 $.ajax({
							  type: "POST",
							  url: "<?php echo base_url();?>home/mobile_checking_msme",
							  data: { mob_no: mob_no},
							  
							  success: function(data){
								  if(data==1)
								  {
									  $("#mob_no_msme").html("Mobile number already exists!");
									  $("#contact_btn").attr('disabled','disabled');
								  }else{
									  $("#mob_no_msme").html("");
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
		
		
		 function isNumberKey(evt)
			{
			 var turnover = $('#turnover').val();
			 turnover	= turnover.split(".").length - 1;
			 if(turnover < 1){
				 var charCode = (evt.which) ? evt.which : event.keyCode
			  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
				 return false;
	 
			  return true;
			 }
			 else
			 {
				 var charCode = (evt.which) ? evt.which : event.keyCode
				if (charCode == 46 && charCode > 31 && (charCode < 48 || charCode > 57))
				 return false;
	 
			  return true;
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
      <h2 class="left-padding module-head text-center">User Registration</h2>
      <form id="hold_frm" method="post" action="<?php echo base_url();?>home/msme_registration" class="div-margin">
		<div class="col-lg-6">Name of Enterprise: <span class="star">*</span><br>
		<input type="text" maxlength="50" name="enterprise_name" id="enterprise_name" value="<?php echo set_value('enterprise_name'); ?>" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('enterprise_name'); ?></span>
		</div>
		<div class="col-lg-6">Type of Legal Entity: <span class="star">*</span><br>
		<select name="constitution" id="constitution" class="module-select">
			  <option value="">--select--</option>
				<option value="Partnership Firm" <?php echo (set_value('constitution')=='Partnership Firm')?" selected=' selected'":""?>>Partnership Firm</option>
				<option value="Proprietorship" <?php echo (set_value('constitution')=='Proprietorship')?" selected=' selected'":""?>>Proprietorship</option>
				<option value="Pvt Ltd Company" <?php echo (set_value('constitution')=='Pvt Ltd Company')?" selected=' selected'":""?>>Pvt Ltd Company</option>
				<option value="LLP" <?php echo (set_value('constitution')=='LLP')?" selected=' selected'":""?>>LLP</option>
				<option value="Trust" <?php echo (set_value('constitution')=='Trust')?" selected=' selected'":""?>>Trust</option>
				<option value="Hindu Undivided Family" <?php echo (set_value('constitution')=='Hindu Undivided Family')?" selected=' selected'":""?>>Hindu Undivided Family</option>
		
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('constitution'); ?></span>
		</div>
<!--        <div class="clear"></div>-->
<!--
		<div class="col-lg-6">Category<br><select name="category" id="category" class="module-select">
			  <option value="">--select--</option>
              <option value="1">Option #1</option>
              <option value="2">Option #2</option>
              <option value="3">Option #3</option>
              <option value="4">Option #4</option>
		</select></div>
-->
		<div class="col-lg-6">Name of Owner/Director: <span class="star">*</span><br><input type="text" maxlength="50" name="owner_name" id="owner_name" value="<?php echo set_value('owner_name'); ?>" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('owner_name'); ?></span>
		</div>
<!--        <div class="clear"></div>-->
		<div class="col-lg-6">PAN of Firm: <span class="star">*</span><br><input type="text" maxlength="10" onblur="fnValidatePAN(this);" name="pan_firm" id="pan_firm" value="<?php echo set_value('pan_firm'); ?>" style="text-transform: uppercase" class="module-input"><span id="span_pan"></span>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pan_firm'); ?></span>
		</div>
		<div class="col-lg-6">Owner's email ID: <span class="star">*</span><br><input type="text" name="owner_email" id="email" value="<?php echo set_value('owner_email'); ?>" class="module-input" placeholder="This will be your Login ID">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('owner_email'); ?></span>
		</div>
		<span id="pan_exists"></span>	
<!--		<div class="clear"></div>-->
		<div class="col-lg-6">Address Line 1: <span class="star">*</span><br><input type="text" maxlength="500" name="address1" id="address1" value="<?php echo set_value('address1'); ?>" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('address1'); ?></span>
		</div>
		<span id="email_exists" class="pull-left" style="position:relative;top:5px;"></span>
		<div class="col-lg-6">Address Line 2:<br><input type="text" name="address2" id="address2" class="module-input"></div>
<!--        <div class="clear"></div>-->
		<div class="col-lg-6">State: <span class="star">*</span><br><select name="state" id="state"  class="module-select">
		<option value="">--select--</option>
			<?php 
			foreach($state as $k=>$st){ ?>
				<option value="<?php echo $st->id; ?>" <?php echo (set_value('state')==$st->id)?" selected=' selected'":""?>><?php echo $st->name; ?> </option>
			<?php } ?>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('state'); ?></span>
		</div>
		<div class="col-lg-6">City: <span class="star">*</span><br>
		<select name="city" id="city"  class="module-select">
		
		</select>
		</div>
<!--        <div class="clear"></div>-->
		<div class="col-lg-6">Pincode: <span class="star">*</span><br><input type="text" maxlength="6" name="pincode" id="pincode" value="<?php echo set_value('pincode'); ?>" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pincode'); ?></span>
		</div>
		<div class="col-lg-6">Mobile Number: <span class="star">*</span><br><input type="text" maxlength="10" name="mob_no" id="mob_no" value="<?php echo set_value('mob_no'); ?>" class="module-input" placeholder="This will be your Login ID, We will send OTP verification on this Mobile number">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('mob_no'); ?></span>
		</div>
        
<!--		<div class="clear"></div>-->
		<div class="col-lg-6">Landline Number:<br><input type="text" maxlength="11" name="landline" id="landline" class="module-input"></div>
		<!--<div class="col-lg-6"><span id="mob_no_msme"></span></div>-->
		
          <div class="clear"></div>
		  <span style="position:relative;top:4px;" class="pull-left" id="mob_no_msme"></span>
		<div class="col-lg-6">Latest Audited Turnover: <span class="star">*</span><br><input type="text" onkeypress="return isNumberKey(event)" maxlength="11" name="latest_audited_turnover" id="turnover" value="<?php echo set_value('latest_audited_turnover'); ?>" placeholder="&#8377; in Lacs" class="module-input">(&#8377; in Lacs)
		
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('latest_audited_turnover'); ?></span>
		</div>
<!--        <div class="clear"></div>-->
		<div class="col-lg-6">Select Password: <span class="star">*</span><br><input type="password" id="new_password" name="password" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('password'); ?></span>
		</div>
                  <div class="clear"></div>
		<div class="col-lg-6">Confirm Password: <span class="star">*</span><br><input type="password" id="con_password" name="con_password" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('con_password'); ?></span>
		</div>
        <div class="clear"></div>
        <div class="col-lg-4"></div>
        <div class="col-lg-2 col-sm-6 col-xs-12 text-right" style="margin-top:15px;"><button type="submit" id="contact_btn" class="btn btn-default">Submit</button></div>
        <div class="col-lg-2 col-sm-6 col-xs-12" style="margin-top:15px;"><button type="button" id="cancel_btn" class="btn btn-default">Cancel</button></div>
        <div class="col-lg-4"></div>
      </form>
    </div>
  </div>
</section>