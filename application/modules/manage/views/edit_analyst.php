<script type="text/javascript">
$(document).ready(function(){
//alert("asdasd");	

 $("#cancel_btn").click(function(){
	 //alert("asdsd");
	 window.location.href='<?php echo base_url();?>manage/dashboard/analyst_list';
 });
	
	$('form#hold_frm').bind('submit',function(){
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#analyst_email").val();
			//var password = $("#password").val();
	        //var password2 = $("#conf_password").val();
			var analyst_mob_no = $("#analyst_mob_no").val().length;
			 if(emailaddress!=""){
				 if(!emailReg.test(emailaddress)){
					alert("Please enter valid Email address");
					return false;
				 }
			 }
						 
			  /* if(password!=password2)
			  {
				alert('Password does not match.');
				return false;
			  } */
			  if(analyst_mob_no < 10 && analyst_mob_no > 0)
			 {
				 alert("Please enter 10 digits mobile no.");
				return false;
			 }
		 
				
	});
	
		var v = $("#hold_frm").validate({
				rules:{
					
					analyst_name:{required:true},
					analyst_mob_no:{required:true},
					analyst_email:{required:true},
					
					}
				});	
		
		$('#analyst_mob_no').on('keyup',function(){	
				var name=$(this).val();
				name=name.replace(/[^0-9]+/g, '');
				$(this).val(name);
			});
			
			$('#analyst_name').on('keyup blur input',function(){	
				var name=$(this).val();
				name=name.replace(/[^a-zA-Z]+/g, '');
				$(this).val(name);
			});
 
 });
		
				
		</script>
<div class="row">
      <form id="hold_frm" id="agenceyapp" method="post" action="<?php echo base_url();?>manage/dashboard/Update_userdetails" class="div-margin">
		
		<div class="col-lg-6">Analyst Name:<br><input type="text" name="analyst_name" id="analyst_name" value="<?php echo $user_details[0]->analyst_name; ?>" class="module-input"></div>
		<div class="col-lg-6">Analyst Mobile Number:<br><input type="text" maxlength="10" name="analyst_mob_no" id="analyst_mob_no" value="<?php echo $user_details[0]->analyst_mob_no; ?>" class="module-input" placeholder="This will be your Login ID"></div>
        <div class="clear"></div>
		<div class="col-lg-6">Analyst Email Id:<br><input type="text" name="analyst_email" id="analyst_email" value="<?php echo $user_details[0]->analyst_email; ?>" class="module-input"></div>
		
        <div class="clear"></div>
		<input type="hidden" name="user_type" id="user_type" value="<?php echo $user_type;?>">
		<input type="hidden" name="id" id="id" value="<?php echo $analyst_id;?>">
        <div class="clear"></div>
        <div class="col-lg-4"></div>
        <div class="col-lg-2 col-sm-6 col-xs-12 text-right" style="margin-top:15px;"><button type="submit" id="contact_btn" class="btn btn-default">Submit</button></div>
        <div class="col-lg-2 col-sm-6 col-xs-12" style="margin-top:15px;"><button type="button" id="cancel_btn" class="btn btn-default">Cancel</button></div>
        <div class="col-lg-4"></div>
      </form>
    </div>





