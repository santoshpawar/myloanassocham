<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>

<script>
$(document).ready(function(){
	
<?php if(validation_errors() =="") {?>
$(".requirederror").css("display","none");
<?php } ?>
	
	$('form#hold_frm').bind('submit',function(){
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#email").val();
			var pan_firm = $("#pan_firm").val().length;
			var pincode = $("#pincode").val().length;
			var mob_no = $("#mob_no").val().length;
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
			/* if(password=="")
			  {
				alert('Please enter new password.');
				return false;
			  }
			  else if(password2=="")
			  {
				alert('Please enter confirm password.');
				return false;
			  } */
			  if(password!=password2)
			  {
				alert('Password does not match.');
				return false;
			  }			  
			 else if(pincode < 6)
			 {
				 alert("Please enter 6 digits pincode.");
				return false;
			 }
			else  if(mob_no < 10)
			 {
				 alert("Please enter 10 digits contact no.");
				return false;
			 }
	
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
				
				
				$('#mob_no,#landline_no,#pincode').on('keyup blur input',function(){	
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
				name=name.replace(/[^0-9]+/g, '');
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
					pincode:{required:true},
					owner_email:{required:true},
					mob_no:{required:true},
					address1:{required:true},	
					//password:{required:true},
					//con_password:{required:true},
					
					}
				});	
				
		$("#turnover").on("keyup input blur",function(){
			/* var val1=$(this).val();
			var val2 = val1.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			$(this).val(val2); */
			var val1=$(this).val();
			x=val1.toString();
			//alert(x);
			var lastThree = x.substring(x.length-3);
			var otherNumbers = x.substring(0,x.length-3);
			if(otherNumbers != '')
				lastThree = ',' + lastThree;
			var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
			$(this).val(res);
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
						  //$("#contact_btn").attr('disabled','disabled');
					  }else{
						  $("#email_exists").html("");
						  //$("#contact_btn").removeAttr('disabled','disabled');
						 
							var mob_no = $("#mob_no").val();
							 $.ajax({
							  type: "POST",
							  url: "<?php echo base_url();?>home/mobile_checking_msme",
							  data: { mob_no: mob_no},
							  
							  success: function(data){
								  if(data==1)
								  {
									  $("#mob_no_msme").html("Mobile number already exists!");
									 // $("#contact_btn").attr('disabled','disabled');
								  }else{
									  $("#mob_no_msme").html("");
									  //$("#contact_btn").removeAttr('disabled','disabled');
									  
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
						  //$("#contact_btn").attr('disabled','disabled');
					  }else{
						  $("#mob_no_msme").html("");
						  //$("#contact_btn").removeAttr('disabled','disabled');
						  var owner_email = $("#email").val();
							 $.ajax({
							  type: "POST",
							  url: "<?php echo base_url();?>home/email_checking_msme",
							  data: { owner_email: owner_email},
							  
							  success: function(data){
								  if(data==1)
								  {
									  $("#email_exists").html("Email already exists!");
									  //$("#contact_btn").attr('disabled','disabled');
								  }else{
									  $("#email_exists").html("");
									  //$("#contact_btn").removeAttr('disabled','disabled');
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
			var pan_enterprise = ObjVal.length;
            var panPat = /^([a-zA-Z]{5})(\d{4})([a-zA-Z]{1})([A-Z0-9]{10})$/;
            var code = /([C,P,H,F,A,T,B,L,J,G])/;
            var code_chk = ObjVal.substring(3,4);
            if (ObjVal.search(panPat) == -1 || pan_enterprise < 10) {
                //alert("Invalid Pan No");
                //Obj.focus();
				//return false;
				$("#span_pan").html("<p>Invalid Pan No.</p>");
				$("#contact_btn").attr('disabled','disabled');
                
            }else{
				$("#span_pan").html("");
				$("#contact_btn").removeAttr('disabled','disabled');
			}
			
            if (code.test(code_chk) == false || pan_enterprise < 10) {
               // alert("Invaild PAN Card No.");
                //return false;
				$("#span_pan").html("<p>Invalid Pan No.</p>");
				$("#contact_btn").attr('disabled','disabled');
            }else{
				$("#span_pan").html("");
				$("#contact_btn").removeAttr('disabled','disabled');
			}
        }
   }
		

</script>

<?php 
function moneyFormatIndia($num){
    $explrestunits = "" ;
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }

        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.

}

?>

<style>
span.requirederror{
	puser_detailsding-left:5px;
}
</style>
<!--<form class="agencyappviewform" id="agenceyapp" action="<?php echo base_url();?>manage/dashboard/save_details" method="post">-->
	
<div class="row">


      <form id="hold_frm" id="agenceyapp" method="post" action="<?php echo base_url();?>manage/dashboard/save_details" class="div-margin">
	  		
		<?php
		if($this->session->userdata('error_message')){ ?>
		<script>
		$(document).ready(function(){
			$("#search_error").show().delay(3000).fadeOut('slow');
		})
		</script>
			<?php echo "<span id='search_error'  class='alert alert-success alrt_md'><strong>Details has been save successfully.</strong></span>";
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
			<?php echo "<span id='search_error'  class='alert alert-success alrt_md'><strong>Password successfully updated.</strong></span>";
			$this->session->set_userdata('pass_message','');
			}
		?>
		
		<div class="col-lg-6">Name of Enterprise: <span class="star">*</span><br>
		<input type="text" maxlength="50" name="enterprise_name" id="enterprise_name" value="<?php  echo $user_details[0]->enterprise_name;  ?>" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('enterprise_name'); ?></span>
		</div>
<!--		<span style="color:#F00" class="requirederror"><?php echo form_error('enterprise_name'); ?></span>-->
		<div class="col-lg-6">Constitution: <span class="star">*</span><br>
		<select name="constitution" id="constitution" class="module-select">
			  <option value="">--select--</option>
				<option value="Partnership Firm" <?php if($user_details[0]->constitution=="Partnership Firm") { echo "selected"; } ?>>Partnership Firm</option>
				<option value="Proprietorship" <?php if($user_details[0]->constitution=="Proprietorship") { echo "selected"; } ?>>Proprietorship</option>
				<option value="Pvt Ltd Company" <?php if($user_details[0]->constitution=="Pvt Ltd Company") { echo "selected"; } ?>>Pvt Ltd Company</option>
				<option value="LLP" <?php if($user_details[0]->constitution=="LLP") { echo "selected"; } ?>>LLP</option>
				<option value="Trust" <?php if($user_details[0]->constitution=="Trust") { echo "selected"; } ?>>Trust</option>
				<option value="Hindu Undivided Family" <?php if($user_details[0]->constitution=="Hindu Undivided Family") { echo "selected"; } ?>>Hindu Undivided Family</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('constitution'); ?></span>
		</div>
		
        <!--<div class="clear"></div>
		<div class="col-lg-6">Category<br><select name="category" id="category" class="module-select">
			 <option value="">--select--</option>
              <option value="1" <?php if($user_details[0]->category==1) { echo "selected"; } ?>>Option #1</option>
              <option value="2" <?php if($user_details[0]->category==2) { echo "selected"; } ?>>Option #2</option>
              <option value="3" <?php if($user_details[0]->category==3) { echo "selected"; } ?>>Option #3</option>
              <option value="4" <?php if($user_details[0]->category==4) { echo "selected"; } ?>>Option #4</option>
			 
			 
		</select></div>-->
		<div class="col-lg-6">Name of Owner/Director: <span class="star">*</span><br><input type="text" maxlength="50" name="owner_name" id="owner_name" value="<?php echo $user_details[0]->owner_name; ?>" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('owner_name'); ?></span>
		</div>
        <!--<div class="clear"></div>-->
		<div class="col-lg-6">PAN of Firm: <span class="star">*</span><br><input type="text" maxlength="10" onblur="fnValidatePAN(this);" name="pan_firm" id="pan_firm" value="<?php echo $user_details[0]->pan_firm; ?>" class="module-input"><span id="span_pan"></span>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pan_firm'); ?></span>
		</div>
		<div class="col-lg-6">Owner's email ID: <span class="star">*</span><br><input type="text" readonly name="owner_email" id="email" value="<?php echo $user_details[0]->owner_email; ?>" class="module-input" placeholder="This will be your Login ID">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('owner_email'); ?></span>
		</div>
        <!--<div class="clear"></div>-->
		<div class="col-lg-6">Address Line 1: <span class="star">*</span><br><input type="text" name="address1" id="address1" value="<?php echo $user_details[0]->address1; ?>" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('address1'); ?></span>
		</div>
		<!--<div id="email_exists" style="color:blue;"></div>-->
		<div class="col-lg-6">Address Line 2:<br><input type="text" name="address2" id="address2" value="<?php echo $user_details[0]->address2; ?>" class="module-input"></div>
       <!-- <div class="clear"></div>-->
		<div class="col-lg-6">State: <span class="star">*</span><br>
		<select name="state" id="state" class="module-select">
		<option value="">--select--</option>
			<?php 
			foreach($state as $k=>$st){ ?>
				<option value="<?php echo $st->id; ?>" <?php if($st->id==$user_details[0]->state){ echo "selected"; }  ?>><?php echo $st->name; ?> </option>
			<?php } ?>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('state'); ?></span>
		
		</div>
		<div class="col-lg-6">City: <span class="star">*</span><br>
		<select name="city" id="city" class="module-select">
		<?php 
			foreach($city as $k1=>$ct){ ?>
				<option value="<?php echo $ct->id; ?>" <?php if($ct->id==$user_details[0]->city){ echo "selected"; }  ?>><?php echo $ct->name; ?> </option>
		<?php } ?>
		</select>
		</div>
        <!--<div class="clear"></div>-->
		<div class="col-lg-6">Pincode: <span class="star">*</span><br><input type="text" maxlength="6" name="pincode" id="pincode" value="<?php echo $user_details[0]->pincode; ?>" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pincode'); ?></span>
		</div>
		<div class="col-lg-6">Mobile Number:<br><input type="text" readonly maxlength="10" name="mob_no" id="mob_no" value="<?php echo $user_details[0]->mob_no; ?>" class="module-input" placeholder="This will be your Login ID, We will send OTP verification on this Mobile number">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('mob_no'); ?></span>
		</div>
        <!--<div class="clear"></div>-->
		<div class="col-lg-6">Landline Number: <span class="star">*</span><br><input type="text" maxlength="11" name="landline_no" id="landline_no" value="<?php echo $user_details[0]->landline_no; ?>" class="module-input"></div>
		<!--<div id="mob_no_msme" style="color:blue;"></div>-->
		<div class="col-lg-6">Latest Audited Turnover:<br><input type="text" name="latest_audited_turnover" id="turnover" value="<?php echo moneyFormatIndia($user_details[0]->latest_audited_turnover); ?>" placeholder="&#8377; in Lacs" class="module-input">(&#8377; in Lacs)
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('latest_audited_turnover'); ?></span>
		</div>
        <!--<div class="clear"></div>-->		
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
	
	
	

