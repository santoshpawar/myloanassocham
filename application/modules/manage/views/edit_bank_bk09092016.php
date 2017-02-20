<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	
	
	 $('form#hold_frm').bind('submit',function(){
					 
			var password = $("#new_password").val();
			var password2 = $("#con_password").val();
			
			  if(password!=password2)
			  {
				alert('Password does not match.');
				return false;
			  }
			  
	
	}); 

			var v = $("#hold_frm").validate({

				rules:{
						'email': {
							required: true
						},
						'bank_name': {
							required: true
						},
						'mob_no': {
							required: true
						},
						'designation': {
							required: true
						},
						'person_name': {
							required: true
						},
						'branch': {
							required: true
						},
						'emp_branch[]': {
							required: true
						},
						'emp_person_name[]': {
							required: true
						},
						'emp_designation[]': {
							required: true
						},
						'emp_mob_no[]': {
							required: true
						},
						'emp_email[]': {
							required: true
						},
						
					
					}
				});	
				$("#cancel_btn").click(function(){
				//alert("asdsd");
				window.location.href='<?php echo base_url();?>manage/dashboard';
				});
				
				$('#mob_no0,#mob_no1').on('keyup blur input',function(){	
				var name=$(this).val();
				name=name.replace(/[^0-9]+/g, '');
				$(this).val(name);
				});
				
				
				$('#mob_no0').on("keyup input blur",function(){
					 var contact_numbers = $(this).val().length;
					 if(contact_numbers < 10)
					 {
						  $("#span_mob_no0").html("<p>Enter 10 digits mobile no.</p>");
						  $("#submit_btn").attr('disabled','disabled');
					 }else{
						  $("#span_mob_no0").html("");
						  $("#submit_btn").removeAttr('disabled','disabled');
					 } 
			
				});
				
				$('#mob_no1').on("keyup input blur",function(){
					 var contact_numbers = $(this).val().length;
					 if(contact_numbers < 10)
					 {
						  $("#span_mob_no1").html("<p>Enter 10 digits mobile no.</p>");
						  $("#submit_btn").attr('disabled','disabled');
					 }else{
						  $("#span_mob_no1").html("");
						  $("#submit_btn").removeAttr('disabled','disabled');
					 } 
			
				});
				
				$('#email0').on("keyup input blur",function(){
					var email0 = $(this).val();
					validateEmail(email0);
				
				});
				
				$('#email1').on("keyup input blur",function(){
					var email1 = $(this).val();
					validateEmail_1(email1);
				
				});
						
		});
		
	function validateEmail(email) {
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#email0").val();
			var emailaddress1 = $("#email1").val();
			
			 if(!emailReg.test(emailaddress) || emailaddress=="")
			{
					  $("#span_email0").html("<p>Enter valid Email Id.</p>");
					  $("#submit_btn").attr('disabled','disabled');
			}else{
					  $("#span_email0").html("");
					  $("#submit_btn").removeAttr('disabled','disabled');
			} 
			
		}
		
		function validateEmail_1(email) {
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress1 = $("#email1").val();
			
			 if(!emailReg.test(emailaddress1) || emailaddress1=="")
			{
					  $("#span_email1").html("<p>Enter valid Email Id.</p>");
					  $("#submit_btn").attr('disabled','disabled');
			}else{
					  $("#span_email1").html("");
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
    <form role="form" id="hold_frm" method="post" action="<?php echo base_url();?>manage/dashboard/Update_userdetails" class="div-margin line-height40">
	<input type="hidden" name="id" id="id" value="<?php echo $bank_details[0]->bank_id;?>" />
	<input type="hidden" name="uid" id="uid" value="<?php echo $bank_details[0]->uid;?>" />
<div class="col-sm-2">Bank Name:</div>
<div class="col-sm-6"><input type="text" name="bank_name" id="bank_name" value="<?php echo $bank_details[0]->bank_name;?>" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<hr class="top-margin20 yellow-hr">
<h2 class="left-padding">First Point of Contact</h2>
<div class="clear"></div>
<div class="col-sm-2">Person Name:</div>
<div class="col-sm-6"><input type="text" name="person_name" id="person_name" value="<?php echo $bank_details[0]->person_name; ?>" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">Designation:</div>
<div class="col-sm-6"><input type="text" name="designation" id="designation" value="<?php echo $bank_details[0]->designation; ?>" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">Mobile No:</div>
<div class="col-sm-6"><input type="text" maxlength="10" name="mob_no" id="mob_no0" value="<?php echo $bank_details[0]->mob_no; ?>" class="module-input"></div><span id="span_mob_no0"></span>
<div class="col-sm-4">Login ID</div>
<div class="clear"></div>
<div class="col-sm-2">Email:</div>
<div class="col-sm-6"><input type="text" name="email" id="email0" value="<?php echo $bank_details[0]->email; ?>" class="module-input"></div><span id="span_email0"></span>
<div class="col-sm-4">Login ID</div>
<div class="clear"></div>
<div class="col-sm-2">Branch:</div>
<div class="col-sm-6"><input type="text" name="branch" id="branch" value="<?php echo $bank_details[0]->branch; ?>" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">Select Password:</div>
<div class="col-lg-6"><input type="password" id="new_password" name="password" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">Confirm Password:</div>
<div class="col-lg-6"><input type="password" id="con_password" name="con_password" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>

<?php foreach($emp_details as $k=>$row){?>
<input type="hidden" name="emp_id[]" value="<?php echo $row->id; ?>">
<hr class="top-margin20 yellow-hr">
<h2 class="left-padding"><?php echo $k=$k+2; ?> Point of Contact</h2>
<div class="clear"></div>
<div class="col-sm-2">Person Name:</div>
<div class="col-sm-6"><input type="text" name="emp_person_name[]" id="person_name" type="text" value="<?php echo $row->person_name; ?>" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">Designation:</div>
<div class="col-sm-6"><input type="text" name="emp_designation[]"  id="designation" value="<?php echo $row->designation; ?>" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">Mobile No:</div>
<div class="col-sm-6"><input type="text" maxlength="10" name="emp_mob_no[]" id="mob_no1" value="<?php echo $row->mob_no; ?>" class="module-input"></div>
<div class="col-sm-4"></div><span id="span_mob_no1"></span>
<div class="clear"></div>
<div class="col-sm-2">Email:</div>
<div class="col-sm-6"><input type="text" name="emp_email[]" id="email1"  value="<?php echo $row->email; ?>" class="module-input"></div>
<div class="col-sm-4"></div><span id="span_email1"></span>
<div class="clear"></div>
<div class="col-sm-2">Branch:</div>
<div class="col-sm-6"><input type="text" name="emp_branch[]" id="branch" value="<?php echo $row->branch; ?>" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<?php } ?>
<input type="hidden" name="user_type" id="user_type" value="<?php echo $user_type;?>">
<hr class="top-margin20 yellow-hr">
<div class="col-sm-3 top-padding10"><button type="submit btn-default" id="submit_btn" class="yellow-button">Submit</button></div>
<div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button">Cancel</button></div>

    </form>
    </div>
