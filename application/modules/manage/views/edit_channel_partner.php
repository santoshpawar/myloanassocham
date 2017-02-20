<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
//alert("asdasd");	

 $("#cancel_btn").click(function(){
	 //alert("asdsd");
	 window.location.href='<?php echo base_url();?>manage/dashboard/channel_partner_list';
 });
 
	$('form#hold_frm').bind('submit',function(){
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#advisor_email").val();
			//var password = $("#password").val();
	        //var password2 = $("#conf_password").val();
			var advisor_mob_no = $("#advisor_mob_no").val().length;
			var advisor_pan = $("#advisor_pan").val().length;
			
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
			  if(advisor_mob_no < 10 && advisor_mob_no > 0)
			 {
				 alert("Please enter 10 digits mobile no.");
				return false;
			 }
			 if(advisor_pan < 10 && advisor_pan > 0)
			 {
				 alert("Please enter 10 digits PAN no.");
				return false;
			 }
		 
				
	});
	
		var v = $("#hold_frm").validate({
				rules:{
					
					advisor_name:{required:true},
					advisor_mob_no:{required:true},
					advisor_email:{required:true},
					advisor_pan:{required:true},
					}
				});	
	
	$('#advisor_mob_no').on('keyup',function(){	
				var name=$(this).val();
				name=name.replace(/[^0-9]+/g, '');
				$(this).val(name);
			});
			
			$('#advisor_name').on('keyup',function(){	
				var name=$(this).val();
				name=name.replace(/[^a-zA-Z]+/g, '');
				$(this).val(name);
			});
	
	
 });
</script>


<div class="row">
      <form id="hold_frm"  method="post" action="<?php echo base_url();?>manage/dashboard/Update_userdetails" class="div-margin">
		
		<div class="col-lg-6">Advisor Name:<br><input type="text" name="advisor_name" id="advisor_name" value="<?php echo $user_details[0]->advisor_name; ?>" class="module-input"></div>
		<div class="col-lg-6">Advisor's Mobile No:<br><input type="text" maxlength="10" name="advisor_mob_no" id="advisor_mob_no" value="<?php echo $user_details[0]->advisor_mob_no; ?>" class="module-input" placeholder="This will be your Login ID"></div>
        <div class="clear"></div>
		<div class="col-lg-6">Advisor's Email Id:<br><input type="text" name="advisor_email" id="advisor_email" value="<?php echo $user_details[0]->advisor_email; ?>" class="module-input"></div>
		<div class="col-lg-6">Advisor's Pan:<br><input type="text" maxlength="10" name="advisor_pan" id="advisor_pan" value="<?php echo $user_details[0]->advisor_pan; ?>" class="module-input"></div>
        <div class="clear"></div>
		<input type="hidden" name="user_type" id="user_type" value="<?php echo $user_type;?>">
		<input type="hidden" name="id" id="id" value="<?php echo $channel_id;?>">
        <div class="clear"></div>
        <div class="col-lg-4"></div>
        <div class="col-lg-2 col-sm-6 col-xs-12 text-right" style="margin-top:15px;"><button type="submit" id="contact_btn" class="btn btn-default">Submit</button></div>
        <div class="col-lg-2 col-sm-6 col-xs-12" style="margin-top:15px;"><button type="button" id="cancel_btn" class="btn btn-default">Cancel</button></div>
        <div class="col-lg-4"></div>
      </form>
    </div>







