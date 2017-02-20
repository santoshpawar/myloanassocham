<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>


<script type="text/javascript">
$(document).ready(function(){
	//alert("sdfsad");
	 $('form#forgot_frm').bind('submit',function(){
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress1 = $("#email_id1").val();
			//alert(emailaddress1);
			if(emailaddress1==""){
				alert("Please enter Email address");
				return false;
			 }
			 else if(!emailReg.test(emailaddress1)){
				alert("Please enter valid Email address");
				return false;
			 }

		 });
		 
		 /* $('#email_id').on("keyup input blur",function(){
			 alert("sdfasd");
				var email_id = $(this).val();
				validateEmail(email_id);
			
			}); */
			 
	
	});
	
	

</script>

<section id="inner-pages">

  <div class="container">
	<div class="row">
      <h2 class="module-head text-center">Forgot Password</h2>
      <form name="forgot_frm" id="forgot_frm" method="post" action="<?php echo base_url();?>home/insertfor_pass_record" style="line-height:35px;" class="div-margin">
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
			<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Password has been sent to your inbox </strong></span>";
			$this->session->set_userdata('error_message','');
			}
		if($this->session->userdata('notification')){ ?>
			<script>
				$(document).ready(function(){
					$("#search_error").show().delay(5000).fadeOut('slow');
				})
			</script>
			<?php echo "<span id='email_notification' class='alert alert-success alrt_md'><strong>Email is not registed try again with different email! </strong></span>";
			$this->session->set_userdata('notification','');
			}
		?>
		
		<div class="col-lg-2">Enter Email Id:</div>
		<div class="col-lg-2"><input type="text" name="email_id1" id="email_id1"  class="module-input"></div><span id="span_email"></span>
		<div class="col-lg-8"></div>
        <div class="clear"></div>
		
          <div class="col-lg-2 col-xs-6"><button type="submit" id="submit_btn" class="btn btn-default">Submit</button></div>
        <div class="clear"></div>
        
      </form>
	
	
    </div>
  </div>
</section>