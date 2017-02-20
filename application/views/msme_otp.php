<script>
$(document).ready(function(){
	$('form#form_otp').bind('submit',function(){
			var otp_no = $("#otp_no").val();
			if(otp_no==""){
				alert("Please enter OTP");
				return false;
			 }
			 
		 });
	});
</script>




<section id="inner-pages">
  <div class="container">
  
    <div class="row">
      <h2 class="module-head text-center">User Registration</h2>
      <form name="form_otp" id="form_otp" method="post" action="<?php echo base_url() ?>home/check_otp_msme" style="line-height:35px;" class="div-margin">
		<?php
if($this->session->userdata('error_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>OTP does not match.</strong></span>";
	$this->session->set_userdata('error_message','');
	} ?>
	
<?php
if($this->session->userdata('resend_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>OTP has been resend.</strong></span>";
	$this->session->set_userdata('resend_message','');
	} ?>
	
<?php
if($this->session->userdata('send_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
		
		window.setTimeout(function() {
                        location.href = '<?php echo base_url(); ?>home';
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
	<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Email has been send please activate your account.<br/>Page will redirect automatically to home page in <span id='timer'></span> seconds.</strong></span>";
	$this->session->set_userdata('send_message','');
	} ?>
		
		<div class="col-lg-2">Enter OTP:</div>
		<div class="col-lg-2"><input type="text" name="otp_no" id="otp_no" class="module-input"></div>
		<div class="col-lg-8"></div>
        <div class="clear"></div>
		<input type="hidden" name="uid" value="<?php echo $this->session->userdata('sess_uid');?>" >
		<input type="hidden" name="email_id" value="<?php echo $email_id; ?>" >
		<input type="hidden" name="password" value="<?php echo base64_encode($password); ?>" >
		<input type="hidden" name="mob_no" value="<?php echo $mob_no; ?>" >
          <div class="col-lg-2 col-xs-6"><button type="submit" class="btn btn-default">Submit</button></div>
        <div class="clear"></div>
        <div class="col-lg-12 top-margin20 resend bottom-margin60">Didn't receive OTP yet? <a href="<?php echo base_url();?>home/resend_otp_msme/<?php echo $this->session->userdata('sess_uid');?>">Resend OTP</a></div>
      </form>
    </div>
  </div>
</section>





