<script src="<?php echo base_url()?>assets/front/js/jquery-ui.js"></script>
<link href="<?php echo base_url()?>assets/front/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>
<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		<?php if(validation_errors() =="") {?>
			$(".requirederror").css("display","none");
			<?php } ?>
			<?php if(($utype_id ==3 || $utype_id ==4 || $utype_id ==5) && (!empty($application_id) && !empty($enterprise_profile))){?>
				$('input,textarea').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('readonly', true);
        //$(this).rules('remove');
    });
				$('select').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('disabled', true);
    });
				<?php } ?>
				<?php if( (!empty($bank_application))){?>
					$('input,textarea').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('readonly', true);
    });
					$('select').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('disabled', true);
    });
					$("#submit_btn").attr("disabled",true);
					<?php } ?>
					$("#cancel_btn").click(function(){
						window.location.href='<?php echo base_url();?>manage/dashboard';
					});
 /* $('form#hold_frm').bind('submit',function(){
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#owner_email").val();
			 if(!emailReg.test(emailaddress) || emailaddress==""){
				alert("Please enter valid Email address");
				return false;
			 }
			}); */
			<?php if($utype_id==1 || $utype_id==2){?>	
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
				var v = $("#hold_frm").validate({
					rules:{
						name_enterprise:{required:true},
						pan_enterprise:{required:true},
						constitution:{required:true},
						legal_entity:{required:true},
						state:{required:true},
						city:{required:true},
						name_of_owner:{required:true},
						pincode:{required:true},
						owner_email:{required:true},
						contact_numbers:{required:true},
						office_address:{required:true},	
						last_audited_trunover:{required:true},
					}
				});	 
				$('#name_enterprise,#name_of_owner').on('keyup blur input',function(){	
					var name=$(this).val();
					name=name.replace(/[^a-zA-Z ]+/g, '');
					$(this).val(name);
				});
				$('#pincode,#contact_numbers').on('keyup blur input',function(){	
					var name=$(this).val();
					name=name.replace(/[^0-9]+/g, '');
					$(this).val(name);
				});
				$('#last_audited_trunover').on('keyup blur input',function(){	
					var name=$(this).val();
					name=name.replace(/[^0-9.]+/g, '');
					$(this).val(name);
				});
				$("#last_audited_trunover").on("keyup input blur",function(){
				/* var val1=$(this).val();
				//var val2 = val1.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				var val2 = val1.toString().replace(/\D/g, '').replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				$(this).val(val2); */
				//x=x.toString();
				//var x=$(this).toString();
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
			  /* $('#pan_enterprise').on("keyup input blur",function(){
				var pan_enterprise = $(this).val().length;
				//alert(pan_enterprise);
				if(pan_enterprise < 10)
				 {
					  $("#span_pan").html("<p>Enter 10 digits PAN no.</p>");
					  $("#submit_btn").attr('disabled','disabled');
				 }else{
					  $("#span_pan").html("");
					  $("#submit_btn").removeAttr('disabled','disabled');
				 }
				 //fnValidatePAN(this);
				});   */
				$('#pincode').on("keyup input blur",function(){
					var pincode = $(this).val().length;
					if(pincode !=""){
						if(pincode < 6)
						{
							$("#span_pincode").html("<p>Enter 6 digits pincode no.</p>");
							$("#submit_btn").attr('disabled','disabled');
						}else{
							$("#span_pincode").html("");
							$("#submit_btn").removeAttr('disabled','disabled');
						}
					}else{
						$("#span_pincode").html("");
						$("#submit_btn").removeAttr('disabled','disabled');
					}
				});
				$('#contact_numbers').on("keyup input blur",function(){
					var contact_numbers = $(this).val().length;
					if(contact_numbers !=""){
						if(contact_numbers < 10)
						{
							$("#span_mob_no").html("<p>Enter 10 digits mobile no.</p>");
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
				$('#owner_email').on("keyup input blur",function(){
					var owner_email = $(this).val();
					validateEmail(owner_email);
				});
				$('#pan_enterprise').on("keyup input",function(){
					fnValidatePAN(this);
				});				 
				<?php if($utype_id ==2) {?> 
					$("#pan_enterprise").blur(function(){
						var pan_enterprise = $(this).val();
				//alert(advisor_pan);
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>home/pan_checking_loan_app",
					data: { pan_enterprise: pan_enterprise},
					success: function(data){
						if(data==1)
						{
							$("#pan_exists").html("PAN already registered");
							$("#submit_btn").attr('disabled','disabled');
						}else{
							$("#pan_exists").html("");
							$("#submit_btn").removeAttr('disabled','disabled');
						}
					}
				});
			});
					<?php } ?>
					$("#show_msme").change(function(){
						var msme = $(this).val();
						if(msme !=""){
							$('#loadingmessage').show();	
							$.ajax({
								type: "POST",
								url: "<?php echo base_url();?>manage/dashboard/ajax_loan_application",
								data: { msme: msme},
								success: function(data){
									if(data)
									{
							  //$("#hi_msme").html("");
							  $("#hi_msme").hide();
							  $("#sh_msme").html(data);
							  $("#loadingmessage").hide();
							  //$("#submit_btn").attr('disabled','disabled');
							}
						}
					});
						}else{
							$("#sh_msme").html('');
							$("#hi_msme").show();
							$("#loadingmessage").hide();
							  //$("#hi_msme").show();
							  //$("#submit_btn").removeAttr('disabled','disabled');
							}
						});
					<?php } ?>
				});
<?php 
function moneyFormatIndia($num){
	$explrestunits = "" ;
	if (strpos($num, '.') == false) {
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
			}
			else
			{
				$thecash = $num;
			}
			return $thecash; // writes the final format where $currency is the currency symbol.
		}
		?>
		function validateEmail(email) {
			var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			var emailaddress = $("#owner_email").val();
			if(!emailReg.test(emailaddress) || emailaddress=="")
			{
				$("#span_email").html("<p>Enter valid Email Id.</p>");
				$("#submit_btn").attr('disabled','disabled');
			}else{
				$("#span_email").html("");
				$("#submit_btn").removeAttr('disabled','disabled');
			} 
		}
	</script>
	<script>
  /* $(function() {
    $( "#constitution" ).datepicker();
}); */
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
				$("#pan_exists").html("");
				$("#submit_btn").attr('disabled','disabled');
			}else{
				$("#span_pan").html("");
				$("#submit_btn").removeAttr('disabled','disabled');
			}
            /* if (code.test(code_chk) == false || pan_enterprise < 10) {
               // alert("Invaild PAN Card No.");
                //return false;
				$("#span_pan").html("<p>Invalid Pan No.</p>");
				$("#submit_btn").attr('disabled','disabled');
            }else{
				$("#span_pan").html("");
				$("#submit_btn").removeAttr('disabled','disabled');
			} */
		}else{
			$("#span_pan").html("");
			$("#pan_exists").html("");
			$("#submit_btn").removeAttr('disabled','disabled');
		}
	}
	function isNumberKey(evt)
	{
		var last_audited_trunover = $('#last_audited_trunover').val();
		last_audited_trunover	= last_audited_trunover.split(".").length - 1;
		if(last_audited_trunover < 1){
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
<?php if(empty($application_id) && empty($enterprise_profile)) {?>
<?php if($utype_id ==1) {?>
<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_enterprise_profile" method="post">
	<?php
	if($this->session->userdata('error_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Data has been saved.</strong></span>";
	$this->session->set_userdata('error_message','');
} ?>
<div class="content-wrapper select">
	<div class="clear"></div>
	<h5 class="tab-form-head">Enterprise Details</h5>
	<div class="p100">
		<div class="col-lg-4">Name of the Enterprise <span class="star">*</span></div>
		<div class="col-lg-5"><input type="text" title="Name is required" maxlength="50" name="name_enterprise" id="name_enterprise" value="<?php echo $user_details[0]->enterprise_name; ?>" class="module-input">
			<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('name_enterprise'); ?></span>
		</div>
		<div class="clear"></div>
		<div class="col-lg-4">PAN of Enterprise <span class="star">*</span></div>
		<div class="col-lg-5"><input type="text" title="PAN is required" maxlength="10"  style="text-transform: uppercase" name="pan_enterprise" id="pan_enterprise" value="<?php echo $user_details[0]->pan_firm; ?>" class="module-input">
			<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pan_enterprise'); ?></span>
		</div><span id="span_pan"></span>
		<div class="clear"></div>
        <!--<div class="col-lg-4">Constitution</div>
        <div class="col-lg-5"><input type="text" name="constitution" id="constitution" value="" class="module-input"></div>-->
        <div class="col-lg-4">Constitution: <span class="star">*</span></div>
        <div class="col-lg-5"><select  title="Constitution is required" name="legal_entity" id="legal_entity" class="module-select">
        	<option value="">--select--</option>
        	<option value="Partnership Firm" <?php if($user_details[0]->constitution=="Partnership Firm") { echo "selected"; } ?>>Partnership Firm</option>
        	<option value="Proprietorship" <?php if($user_details[0]->constitution=="Proprietorship") { echo "selected"; } ?>>Proprietorship</option>
        	<option value="Pvt Ltd Company" <?php if($user_details[0]->constitution=="Pvt Ltd Company") { echo "selected"; } ?>>Pvt Ltd Company</option>
        	<option value="LLP" <?php if($user_details[0]->constitution=="LLP") { echo "selected"; } ?>>LLP</option>
        	<option value="Trust" <?php if($user_details[0]->constitution=="Trust") { echo "selected"; } ?>>Trust</option>
        	<option value="Hindu Undivided Family" <?php if($user_details[0]->constitution=="Hindu Undivided Family") { echo "selected"; } ?>>Hindu Undivided Family</option>
        </select>
        <span  class="requirederror alert alert-success alrt_md"><?php echo form_error('legal_entity'); ?></span>
    </div>
    <div class="clear"></div>
    <div class="col-lg-4">Name of Owner/Director <span class="star">*</span></div>
    <div class="col-lg-5"><input type="text" title="Owner name is required" maxlength="50" name="name_of_owner" id="name_of_owner" value="<?php echo $user_details[0]->owner_name; ?>" class="module-input">
    	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('name_of_owner'); ?></span>
    </div>
    <div class="clear"></div>
    <div class="col-lg-4">Owner's Email ID <span class="star">*</span></div>
    <div class="col-lg-5"><input type="text" title="Email is required" name="owner_email" id="owner_email" value="<?php echo $user_details[0]->owner_email; ?>" class="module-input">
    	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('owner_email'); ?></span>
    </div>
    <span id="span_email"></span>
    <div class="clear"></div>
    <div class="col-lg-4">Office Address <span class="star">*</span></div>
    <div class="col-lg-5"><textarea title="Address is required"  maxlength="700" name="office_address" id="office_address" class="module-text"><?php echo $user_details[0]->address1; ?></textarea>
    	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('office_address'); ?></span>
    </div>
    <div class="clear"></div>
    <div class="col-lg-4">State <span class="star">*</span></div>
    <div class="col-lg-5"><select title="State is required" name="state" id="state" class="module-select">
    	<option value="">--select--</option>
    	<?php 
    	foreach($state as $k=>$st){ ?>
    	<option value="<?php echo $st->id; ?>" <?php if($st->id==$user_details[0]->state){ echo "selected"; }  ?>><?php echo $st->name; ?> </option>
    	<?php } ?>
    </select>
    <span  class="requirederror alert alert-success alrt_md"><?php echo form_error('state'); ?></span>
</div>
<div class="clear"></div>
<div class="col-lg-4">City <span class="star">*</span></div>
<div class="col-lg-5"><select title="City is required" name="city" id="city" class="module-select">
	<?php 
	foreach($city as $k1=>$ct){ ?>
	<option value="<?php echo $ct->id; ?>" <?php if($ct->id==$user_details[0]->city){ echo "selected"; }  ?>><?php echo $ct->name; ?> </option>
	<?php } ?>
</select></div>
<div class="clear"></div>
<div class="col-lg-4">Pin Code <span class="star">*</span></div>
<div class="col-lg-5"><input type="text" title="Pin code is required" maxlength="6" name="pincode" id="pincode" value="<?php echo $user_details[0]->pincode; ?>" class="module-input">
	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pincode'); ?></span>
</div><span id="span_pincode"></span>
<div class="clear"></div>
<div class="col-lg-4">Contact Number(s) <span class="star">*</span></div>
<div class="col-lg-5"><input type="text" title="Mobile no. is required" maxlength="10" name="contact_numbers" id="contact_numbers" value="<?php echo $user_details[0]->mob_no; ?>" class="module-input">
	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('contact_numbers'); ?></span>
</div><span id="span_mob_no"></span>
<div class="clear"></div>
<div class="col-lg-4">Latest Audited Turnover <span class="star">*</span></div>
<div class="col-lg-5"><input type="text" onkeypress="return isNumberKey(event)" title="Latest turnover is required" maxlength="11" name="last_audited_trunover" id="last_audited_trunover" value="<?php echo moneyFormatIndia($user_details[0]->latest_audited_turnover); ?>" class="module-input" placeholder="&#8377; in Lacs">
	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('last_audited_trunover'); ?></span>
</div>
<div class="col-lg-3">(&#8377; in Lacs)</div>   
<div class="clear"></div>
<hr class="top-margin20 yellow-hr">
<div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default">Save &amp; Continue</button></div>
<div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>
</div>
</div>
</form> 
<?php } else { ?>  
<?php if(!empty($msme_list)){?>
<div class="col-lg-1 col-lg-offset-5" style="padding:10px;">MSME:</div>
<div class="col-lg-4" style="padding:0 0px;marfin-left:10px;"><select title="msme is required" name="msme" id="show_msme" class="module-select" style="width:88% !important;">
	<option value="">--select--</option>
	<?php foreach($msme_list as $msme){?>
	<option value="<?php echo $msme->uid;?>" ><?php echo $msme->enterprise_name;?></option>
	<?php } ?>
</select></div>
<div class="clear"></div>
<?php } ?>
<div id="sh_msme">
</div>
<div id="hi_msme">	
	<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_enterprise_profile" method="post">
		<?php
		if($this->session->userdata('error_message')){ ?>
		<script>
			$(document).ready(function(){
				$("#search_error").show().delay(5000).fadeOut('slow');
			})
		</script>
		<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Data has been saved.</strong></span>";
		$this->session->set_userdata('error_message','');
	} ?>
	<div class="content-wrapper select">
		<div class="clear"></div>
		<h5 class="tab-form-head">Enterprise Details</h5>
		<div class="p100">
			<div id='loadingmessage' style='display:none'>
				<img  src='<?php echo base_url();?>assets/front/images/loading.gif'/>
			</div>
			<div class="col-lg-4">Name of the Enterprise <span class="star">*</span></div>
			<div class="col-lg-5"><input type="text" title="Name is required" maxlength="50" name="name_enterprise" id="name_enterprise" value="" class="module-input">
				<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('name_enterprise'); ?></span>
			</div>
			<div class="clear"></div>
			<div class="col-lg-4">PAN of Enterprise <span class="star">*</span></div>
			<div class="col-lg-5"><input type="text" title="PAN is required" maxlength="10"  style="text-transform: uppercase" name="pan_enterprise" id="pan_enterprise" value="" class="module-input">
				<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pan_enterprise'); ?></span>
			</div><span id="span_pan"></span>
			<div class="clear"></div><span id="pan_exists"></span>
        <!--<div class="col-lg-4">Constitution</div>
        <div class="col-lg-5"><input type="text" name="constitution" id="constitution" value="" class="module-input"></div>-->
        <div class="col-lg-4">Constitution: <span class="star">*</span></div>
        <div class="col-lg-5"><select title="Constitution is required" name="legal_entity" id="legal_entity" class="module-select">
        	<option value="">--select--</option>
        	<option value="Partnership Firm" >Partnership Firm</option>
        	<option value="Proprietorship" >Proprietorship</option>
        	<option value="Pvt Ltd Company" >Pvt Ltd Company</option>
        	<option value="LLP" >LLP</option>
        	<option value="Trust" >Trust</option>
        	<option value="Hindu Undivided Family" >Hindu Undivided Family</option>
        </select>
        <span  class="requirederror alert alert-success alrt_md"><?php echo form_error('legal_entity'); ?></span>
    </div>
    <div class="clear"></div>
    <div class="col-lg-4">Name of Owner/Director <span class="star">*</span></div>
    <div class="col-lg-5"><input type="text" title="Owner name is required" maxlength="50" name="name_of_owner" id="name_of_owner" value="" class="module-input">
    	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('name_of_owner'); ?></span>
    </div>
    <div class="clear"></div>
    <div class="col-lg-4">Owner's Email ID <span class="star">*</span></div>
    <div class="col-lg-5"><input type="text" title="Email is required" name="owner_email" id="owner_email" value="" class="module-input">
    	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('owner_email'); ?></span>
    </div><span id="span_email"></span>
    <div class="clear"></div>
    <div class="col-lg-4">Office Address <span class="star">*</span></div>
    <div class="col-lg-5"><textarea title="Address is required" maxlength="700" name="office_address" id="office_address" class="module-text"></textarea>
    	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('office_address'); ?></span>
    </div>
    <div class="clear"></div>
    <div class="col-lg-4">State <span class="star">*</span></div>
    <div class="col-lg-5"><select  title="State is required" name="state" id="state" class="module-select">
    	<option value="">--select--</option>
    	<?php 
    	foreach($state as $k=>$st){ ?>
    	<option value="<?php echo $st->id; ?>" <?php //if($st->id==$user_details[0]->state){ echo "selected"; }  ?>><?php echo $st->name; ?> </option>
    	<?php } ?>
    </select>
    <span  class="requirederror alert alert-success alrt_md"><?php echo form_error('state'); ?></span>
</div>
<div class="clear"></div>
<div class="col-lg-4">City <span class="star">*</span></div>
<div class="col-lg-5"><select title="City is required" name="city" id="city" class="module-select">
</select></div>
<div class="clear"></div>
<div class="col-lg-4">Pin Code <span class="star">*</span></div>
<div class="col-lg-5"><input type="text" title="Pin code is required" maxlength="6" name="pincode" id="pincode" value="" class="module-input">
	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pincode'); ?></span>
</div><span id="span_pincode"></span>
<div class="clear"></div>
<div class="col-lg-4">Contact Number(s) <span class="star">*</span></div>
<div class="col-lg-5"><input type="text" title="Mobile no. is required" maxlength="10" name="contact_numbers" id="contact_numbers" value="" class="module-input">
	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('contact_numbers'); ?></span>
</div><span id="span_mob_no"></span>
<div class="clear"></div>
<div class="col-lg-4">Latest Audited Turnover <span class="star">*</span></div>
<div class="col-lg-5"><input type="text" onkeypress="return isNumberKey(event)" title="Latest turnover is required" maxlength="11" name="last_audited_trunover" id="last_audited_trunover" value="" placeholder="&#8377; in Lacs" class="module-input" placeholder="&#8377; in Lacs">
	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('last_audited_trunover'); ?></span>
</div>
<div class="col-lg-3">(&#8377; in Lacs)</div>
<div class="clear"></div>
<hr class="top-margin20 yellow-hr">
<div class="col-sm-4 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default">Save &amp; Continue</button></div>
<div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>
</div>
</div>
</form>   
</div>
<?php } ?>
<?php }else { ?>
<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_enterprise_profile" method="post">
	<?php
//echo "rj";
	if($this->session->userdata('error_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Data has been saved.</strong></span>";
	$this->session->set_userdata('error_message','');
} ?>
<div class="content-wrapper select">
	<div class="clear"></div>
	<h5 class="tab-form-head">Enterprise Details</h5>
	<div class="p100">
		<div class="col-lg-4">Name of the Enterprise <span class="star">*</span></div>
		<div class="col-lg-5"><input type="text" title="Name is required" maxlength="50" name="name_enterprise" id="name_enterprise" value="<?php echo $enterprise_profile[0]->name_enterprise; ?>" class="module-input">
			<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('name_enterprise'); ?></span>
		</div>
		<div class="clear"></div>
		<div class="col-lg-4">PAN of Enterprise <span class="star">*</span></div>
		<div class="col-lg-5"><input type="text" title="PAN is required" maxlength="10"  style="text-transform: uppercase" name="pan_enterprise" id="pan_enterprise" value="<?php echo $enterprise_profile[0]->pan_enterprise; ?>" class="module-input">
			<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pan_enterprise'); ?></span>
		</div><span id="span_pan"></span>
		<div class="clear"></div>
        <!--<div class="col-lg-4">Constitution</div>
        <div class="col-lg-5"><input type="text" name="constitution" id="constitution" value="<?php //echo $enterprise_profile[0]->constitution; ?>" class="module-input"></div>-->
        <div class="col-lg-4">Constitution: <span class="star">*</span></div>
        <div class="col-lg-5"><select title="Constitution is required" name="legal_entity" id="legal_entity" class="module-select">
        	<option value="">--select--</option>
        	<option value="Partnership Firm" <?php if($enterprise_profile[0]->legal_entity=="Partnership Firm") { echo "selected"; } ?>>Partnership Firm</option>
        	<option value="Proprietorship" <?php if($enterprise_profile[0]->legal_entity=="Proprietorship") { echo "selected"; } ?>>Proprietorship</option>
        	<option value="Pvt Ltd Company" <?php if($enterprise_profile[0]->legal_entity=="Pvt Ltd Company") { echo "selected"; } ?>>Pvt Ltd Company</option>
        	<option value="LLP" <?php if($enterprise_profile[0]->legal_entity=="LLP") { echo "selected"; } ?>>LLP</option>
        	<option value="Trust" <?php if($enterprise_profile[0]->legal_entity=="Trust") { echo "selected"; } ?>>Trust</option>
        	<option value="Hindu Undivided Family" <?php if($enterprise_profile[0]->legal_entity=="Hindu Undivided Family") { echo "selected"; } ?>>Hindu Undivided Family</option>>
        </select>
        <span  class="requirederror alert alert-success alrt_md"><?php echo form_error('legal_entity'); ?></span>
    </div>
    <div class="clear"></div>
    <div class="col-lg-4">Name of Owner/Director <span class="star">*</span></div>
    <div class="col-lg-5"><input type="text" title="Owner name is required" maxlength="50" name="name_of_owner" id="name_of_owner" value="<?php echo $enterprise_profile[0]->name_of_owner; ?>" class="module-input">
    	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('name_of_owner'); ?></span>
    </div>
    <div class="clear"></div>
    <div class="col-lg-4">Owner's Email ID <span class="star">*</span></div>
    <div class="col-lg-5"><input type="text" title="Email is required" name="owner_email" id="owner_email" value="<?php echo $enterprise_profile[0]->owner_email; ?>" class="module-input">
    	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('owner_email'); ?></span>
    </div><span id="span_email"></span>
    <div class="clear"></div>
    <div class="col-lg-4">Office Address <span class="star">*</span></div>
    <div class="col-lg-5"><textarea title="Address is required" maxlength="700" name="office_address" id="office_address" class="module-text"><?php echo $enterprise_profile[0]->office_address; ?></textarea>
    	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('office_address'); ?></span>
    </div>
    <div class="clear"></div>
    <div class="col-lg-4">State <span class="star">*</span></div>
    <div class="col-lg-5"><select title="State is required" name="state" id="state" class="module-select">
    	<option value="">--select--</option>
    	<?php 
    	foreach($state as $k=>$st){ ?>
    	<option value="<?php echo $st->id; ?>" <?php if($st->id==$enterprise_profile[0]->state){ echo "selected"; }  ?>><?php echo $st->name; ?> </option>
    	<?php } ?>
    </select>
    <span  class="requirederror alert alert-success alrt_md"><?php echo form_error('state'); ?></span>
</div>
<div class="clear"></div>
<div class="col-lg-4">City <span class="star">*</span></div>
<div class="col-lg-5"><select title="City is required" name="city" id="city" class="module-select">
	<?php 
	foreach($city as $k1=>$ct){ ?>
	<option value="<?php echo $ct->id; ?>" <?php if($ct->id==$enterprise_profile[0]->city){ echo "selected"; }  ?>><?php echo $ct->name; ?> </option>
	<?php } ?>
</select></div>
<div class="clear"></div>
<div class="col-lg-4">Pin Code <span class="star">*</span></div>
<div class="col-lg-5"><input type="text" title="Pin code is required" maxlength="6" name="pincode" id="pincode" value="<?php echo $enterprise_profile[0]->pincode; ?>" class="module-input">
	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pincode'); ?></span>
</div><span id="span_pincode"></span>
<div class="clear"></div>
<div class="col-lg-4">Contact Number(s) <span class="star">*</span></div>
<div class="col-lg-5"><input type="text" title="Mobile no. is required" maxlength="10" name="contact_numbers" id="contact_numbers" value="<?php echo $enterprise_profile[0]->contact_numbers; ?>" class="module-input">
	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('contact_numbers'); ?></span>
</div><span id="span_mob_no"></span>
<div class="clear"></div>
<div class="col-lg-4">Latest Audited Turnover <span class="star">*</span></div>
<div class="col-lg-5"><input type="text" onkeypress="return isNumberKey(event)" title="Latest turnover is required" maxlength="11" name="last_audited_trunover" id="last_audited_trunover" value="<?php echo moneyFormatIndia($enterprise_profile[0]->last_audited_trunover); ?>" class="module-input" placeholder="&#8377; in Lacs">
	<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('last_audited_trunover'); ?></span>
</div>
<div class="col-lg-3">&#8377; in Lacs)</div>
<div class="clear"></div>
<input type="hidden" name="application_id" value="<?php echo $application_id[0]->application_id;?>"/>
<hr class="top-margin20 yellow-hr">
<div class="col-sm-4 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default"><?php if($utype_id ==3 || $utype_id ==4 || $utype_id ==5){ echo "Next"; }else { echo "Save &amp; Continue";} ?></button></div>
<div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>
</div>
</div>
</form>   
<?php } ?>