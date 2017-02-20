<script src="<?php echo base_url()?>assets/front/js/jquery-ui.js"></script>
<link href="<?php echo base_url()?>assets/front/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>


<script type="text/javascript">
$(document).ready(function(){
//alert("asdasd");	

 $("#add_bank").click(function(){
	 //alert("asdsd");
	 window.location.href='<?php echo base_url();?>manage/dashboard/add_bank';
 });
 
	$("#cancel_btn").click(function(){
	 window.location.href='<?php echo base_url();?>manage/dashboard';
	});
 
		$('form#hold_frm').bind('submit',function(){
			
			var password = $("#password").val();
	        var password2 = $("#conf_password").val();
			
						 
			   if(password!=password2)
			  {
				alert('Password does not match.');
				return false;
			  } 
			  
		 
				
	});
	
			
		
			
			$('#mob_no').on("keyup input blur",function(){
				var mob_no = $(this).val().length;
				 if(mob_no < 10)
				 {
					  $("#span_mob_no").html("<p>Enter 10 digits contact no.</p>");
					  $("#submit_btn").attr('disabled','disabled');
				 }else{
					  $("#span_mob_no").html("");
					  $("#submit_btn").removeAttr('disabled','disabled');
				 } 
			
			});
			
			$('#mob_no1').on("keyup input blur",function(){
				var mob_no1 = $(this).val().length;
				 if(mob_no1 < 10)
				 {
					  $("#span_mob_no1").html("<p>Enter 10 digits contact no.</p>");
					  $("#submit_btn").attr('disabled','disabled');
				 }else{
					  $("#span_mob_no1").html("");
					  $("#submit_btn").removeAttr('disabled','disabled');
				 } 
			
			});
			
			$('#mob_no2').on("keyup input blur",function(){
				var mob_no2 = $(this).val().length;
				 if(mob_no2 < 10)
				 {
					  $("#span_mob_no2").html("<p>Enter 10 digits contact no.</p>");
					  $("#submit_btn").attr('disabled','disabled');
				 }else{
					  $("#span_mob_no2").html("");
					  $("#submit_btn").removeAttr('disabled','disabled');
				 } 
			
			});
			
			
			$('#email').on("keyup input blur",function(){
				var email = $(this).val();
				validateEmail(email);
			
			});
			$('#email1').on("keyup input blur",function(){
				var email1 = $(this).val();
				validateEmail1(email1);
			
			});
			$('#email2').on("keyup input blur",function(){
				var email2 = $(this).val();
				validateEmail2(email2);
			
			});
			
			//for Add more
			
			 
		 
				

	
	
	
	jQuery.validator.addClassRules("required", {
		  required: true
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
						  $("#submit_bt").attr('disabled','disabled');
					  }else{
						  $("#email_exists").html("");
						  $("#submit_bt").removeAttr('disabled','disabled');
						 
							var mob_no = $("#mob_no").val();
							 $.ajax({
							  type: "POST",
							  url: "<?php echo base_url();?>home/mobile_checking_msme",
							  data: { mob_no: mob_no},
							  
							  success: function(data){
								  if(data==1)
								  {
									  $("#mob_no_msme").html("Mobile number already exists!");
									  $("#submit_bt").attr('disabled','disabled');
								  }else{
									  $("#mob_no_msme").html("");
									  $("#submit_bt").removeAttr('disabled','disabled');
									  
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
						  $("#submit_bt").attr('disabled','disabled');
					  }else{
						  $("#mob_no_msme").html("");
						  $("#submit_bt").removeAttr('disabled','disabled');
						  var owner_email = $("#email").val();
							 $.ajax({
							  type: "POST",
							  url: "<?php echo base_url();?>home/email_checking_msme",
							  data: { owner_email: owner_email},
							  
							  success: function(data){
								  if(data==1)
								  {
									  $("#email_exists").html("Email already exists!");
									  $("#submit_bt").attr('disabled','disabled');
								  }else{
									  $("#email_exists").html("");
									  $("#submit_bt").removeAttr('disabled','disabled');
								  }
							  }
							});
						  
					  }
				  }
				});
		});

			var v = $("#hold_frm").validate({

				rules:{
						'bank_name': {
							required: true
						},
						'branch': {
							required: true
						},
						'person_name': {
							required: true
						},
						'designation': {
							required: true
						},
						'mob_no': {
							required: true
						},
						'email': {
							required: true
						},
						'password': {
							required: true
						},
						'conf_password': {
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
				
				
			//Start numeric,char,dot validation
			$('#mob_no,#mob_no1,#mob_no2').on('keyup blur input',function(){	
				var name=$(this).val();
				name=name.replace(/[^0-9]+/g, '');
				$(this).val(name);
			});
			
			
			
		
		
});

function validateEmail(email) {
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#email").val();
			
			 if(!emailReg.test(emailaddress) || emailaddress=="")
			 {
					  $("#span_email").html("<p>Enter valid Email Id.</p>");
					  $("#submit_btn").attr('disabled','disabled');
				 }else{
					  $("#span_email").html("");
					  $("#submit_btn").removeAttr('disabled','disabled');
				 } 
		}
	
		
		function validateEmail1(email) {
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#email1").val();
			
			 if(!emailReg.test(emailaddress) || emailaddress=="")
			 {
					  $("#span_email1").html("<p>Enter valid Email Id.</p>");
					  $("#submit_btn").attr('disabled','disabled');
				 }else{
					  $("#span_email1").html("");
					  $("#submit_btn").removeAttr('disabled','disabled');
			} 
		}
		
		function validateEmail2(email) {
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#email2").val();
			
			 if(!emailReg.test(emailaddress) || emailaddress=="")
			 {
					  $("#span_email2").html("<p>Enter valid Email Id.</p>");
					  $("#submit_btn").attr('disabled','disabled');
				 }else{
					  $("#span_email2").html("");
					  $("#submit_btn").removeAttr('disabled','disabled');
			} 
		}
		//for add more
		var i =3;
		function validateEmail_addmore(email) {
			//i++;
			//alert(email);
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#"+email).val();
			//alert(emailaddress);
			 if(!emailReg.test(emailaddress))
				{
					 // $("#span_email"+i).html("<p>Enter valid Email Id.</p>");
					  $("#submit_btn").attr('disabled','disabled');
				}else if(emailaddress=="")
				{
						  $("#span_email"+i).html("");
						  $("#submit_btn").removeAttr('disabled','disabled');
				}
				else
				{
						  $("#span_email"+i).html("");
						  $("#submit_btn").removeAttr('disabled','disabled');
				} 
			i++;
		}
		
		//end add more
		
		
		
				
		</script>
<style>
span.requirederror{
	puser_detailsding-left:5px;
}
</style>
<!--<form class="agencyappviewform" id="agenceyapp" action="<?php echo base_url();?>manage/dashboard/save_details" method="post">-->
	
<div class="row">
    <form id="hold_frm" name="add_termform" method="post" action="<?php echo base_url()?>manage/dashboard/saveBank" class="div-margin line-height40">
<?php
if($this->session->userdata('error_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Bank has been saved successfully.</strong></span>";
	$this->session->set_userdata('error_message','');
	} ?>
	<div class="col-sm-2">Bank Name:</div>
<div class="col-sm-6"><input type="text" name="bank_name" id="bank_name" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<hr class="top-margin20 yellow-hr">
<h2 class="left-padding">First Point of Contact</h2>
<div class="clear"></div>
<div class="col-sm-2">Person Name:</div>
<div class="col-sm-6"><input type="text" name="person_name" id="person_name" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">Designation:</div>
<div class="col-sm-6"><input type="text" name="designation" id="designation" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">Mobile No:</div>
<div class="col-sm-6"><input type="text" maxlength="10" name="mob_no" id="mob_no" class="module-input"></div><span id="span_mob_no"></span>
<div class="col-sm-4">Login ID<div id="mob_no_msme" style="color:blue;"></div></div>
<div class="clear"></div>
<div class="col-sm-2">Email:</div>
<div class="col-sm-6"><input type="text" name="email" id="email" class="module-input"></div>
<div class="col-sm-4">Login ID <span id="span_email"></span> <div id="email_exists" style="color:blue;"></div></div>
<div class="clear"></div>
<div class="col-sm-2">Branch:</div>
<div class="col-sm-6"><input type="text" name="branch" id="branch" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">Change Password:</div>
<div class="col-sm-6"><input type="password" name="password" id="password" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">New Password:</div>
<div class="col-sm-6"><input type="password" name="conf_password" id="conf_password" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<hr class="top-margin20 yellow-hr">
<h2 class="left-padding">Second Point of Contact</h2>
<div class="clear"></div>
<div class="col-sm-2">Person Name:</div>
<div class="col-sm-6"><input type="text" name="emp_person_name[]" id="person_name1" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">Designation:</div>
<div class="col-sm-6"><input type="text" name="emp_designation[]" id="designation1" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">Mobile No:</div>
<div class="col-sm-6"><input type="text" maxlength="10" name="emp_mob_no[]" id="mob_no1" class="module-input"></div>
<div class="col-sm-4"></div><span id="span_mob_no1"></span>
<div class="clear"></div>
<div class="col-sm-2">Email:</div>
<div class="col-sm-6"><input type="text" name="emp_email[]" id="email1" class="module-input"></div>
<div class="col-sm-4"></div><span id="span_email1"></span>
<div class="clear"></div>
<div class="col-sm-2">Branch:</div>
<div class="col-sm-6"><input type="text" name="emp_branch[]" id="branch1" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-lg-12 no-padding">
<hr class="top-margin20 yellow-hr">
<h2 class="left-padding">Third Point of Contact</h2>

    <div class="col-sm-12 top-margin20"><button type="button" class="yellow-button pull-right" onclick="addTable()"><span class="big-text">Add More</span> &nbsp;&nbsp;<i class="fa fa-plus-circle" aria-hidden="true"></i>
</button></div>
    
<div class="clear"></div>
<div class="col-sm-2">Person Name:</div>
<div class="col-sm-6"><input type="text" name="emp_person_name[]" id="person_name2" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">Designation:</div>
<div class="col-sm-6"><input type="text" name="emp_designation[]" id="designation2" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">Mobile No:</div>
<div class="col-sm-6"><input type="text" maxlength="10" name="emp_mob_no[]" id="mob_no2" class="module-input"></div><span id="span_mob_no2"></span>
<div class="col-sm-4"></div>
<div class="clear"></div>
<div class="col-sm-2">Email:</div>
<div class="col-sm-6"><input type="text" name="emp_email[]" id="email2" class="module-input"></div>
<div class="col-sm-4"></div><span id="span_email2"></span>
<div class="clear"></div>
<div class="col-sm-2">Branch:</div>
<div class="col-sm-6"><input type="text" name="emp_branch[]" id="branch2" class="module-input"></div>
<div class="col-sm-4"></div>
<div class="clear"></div>

<div id="cont_details">
    
  
          
</div>
    
<script type="text/javascript">
    var rowNum =2;
    function addTable(){
		rowNum++;
      $('#cont_details').append('<div class="grp_content"><div class="col-sm-2">Person Name:</div><div class="col-sm-6"><input type="text" name="emp_person_name[]" id="person_name'+rowNum+'" class="module-input add_more"></div><a title="Delete" href="#" class="rmv"><i class="fa fa-close"></i></a><div class="col-sm-4"></div><div class="clear"></div><div class="col-sm-2">Designation:</div><div class="col-sm-6"><input type="text" name="emp_designation[]" id="designation'+rowNum+'" class="module-input add_more"></div><div class="col-sm-4"></div><div class="clear"></div><div class="col-sm-2">Mobile No:</div><div class="col-sm-6"><input type="text" maxlength="10" name="emp_mob_no[]" id="mob_no'+rowNum+'" class="module-input add_more add_more_mob"></div><div class="col-sm-4"></div><span id="span_mob_no'+rowNum+'"></span><div class="clear"></div><div class="col-sm-2">Email:</div><div class="col-sm-6"><input type="text" name="emp_email[]" id="email'+rowNum+'" class="module-input add_more add_more_email"></div><div class="col-sm-4"></div><span id="span_email'+rowNum+'"></span><div class="clear"></div><div class="col-sm-2">Branch:</div><div class="col-sm-6"><input type="text" name="emp_branch[]" id="branch'+rowNum+'" class="module-input add_more"></div><div class="col-sm-4"></div><div class="clear"></div></div>');
        
    $('.rmv').on('click', function(c){
		$(this).parent().fadeOut('slow', function(c){
		});
	});	

	
		var j =3;
		$(".add_more_mob").on('keyup input blur',function(){
			//alert("dddd");
				    var id = $(this).attr("id");
					var name=$('#'+id).val();
					name=name.replace(/[^0-9]+/g, '');
					$(this).val(name);

				
					var mob_no3 = $('#'+id).val().length;
					//alert(mob_no3);
					 if(mob_no3 < 10 )
					 {
						  $("#span_mob_no"+j).html("<p>Enter 10 digits contact no.</p>");
						  //$("#submit_btn").attr('disabled','disabled');
					 }else{
						  $("#span_mob_no"+j).html("");
						  //$("#submit_btn").removeAttr('disabled','disabled');
					 } 
				j++;	
				
			});
			
			
			
			
		$(".add_more_email").on('keyup input blur',function(){
				var eid = $(this).attr("id");
				validateEmail_addmore(eid);
				
			}); 
			
			
		
		

			 $('.add_more').on('change input blur',function(){
				 var totalElements1=0;
				if($(this).val() != ""){
					$(this).removeClass("add_more");
					totalElements1 = $(this).parent('.col-sm-6').parent('.grp_content').find('.add_more:not(:disabled)').length;
				 }else{
					$(this).addClass("add_more");
					totalElements1 = $(this).parent('.col-sm-6').parent('.grp_content').find('.add_more:not(:disabled)').length;
				 }
				 
					console.log(totalElements1);					
					if(totalElements1==0 || totalElements1==5)
					{
						$("#submit_btn").removeAttr('disabled','disabled');
						$(".pull-right").removeAttr('disabled','disabled');
						
					}else{
						
						 $("#submit_btn").attr('disabled','disabled');
						 $(".pull-right").attr('disabled','disabled');
					}
					
				});
		
	
			
		
						
			
      
    }
</script>    

</div>
<div class="clear"></div>
<hr class="top-margin20 yellow-hr">
<div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button">Submit</button></div>
<div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button">Cancel</button></div>

    </form>
    </div>
	

