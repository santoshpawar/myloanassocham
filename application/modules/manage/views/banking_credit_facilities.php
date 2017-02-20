<script src="<?php echo base_url()?>assets/front/js/jquery-ui.js"></script>
<link href="<?php echo base_url()?>assets/front/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>
<script type="text/javascript" language="javascript">
	$(document).ready(function(){	
		<?php if(validation_errors() =="") {?>
			$(".requirederror").css("display","none");
			<?php } ?>
    //property condition start
    var thisVal=$('select[name^=security_lodged]').find('option:selected').html().toUpperCase();    
    if(thisVal=='PROPERTY'){ 
    	$('select[name^=security_lodged]').parent('td').parent('tr').next('tr').find('select').removeAttr('disabled').css('opacity', 1);
    	$('select[name^=security_lodged]').parent('td').parent('tr').next('tr').next('tr').find('input').removeAttr('disabled').css('opacity', 1);
    }   
    else{
    	$('select[name^=security_lodged]').parent('td').parent('tr').next('tr').find('select').attr('disabled','disabled').css('opacity', 0);
    	$('select[name^=security_lodged]').parent('td').parent('tr').next('tr').next('tr').find('input').attr('disabled','disabled').css('opacity', 0);
    }    
    $('select[name^=security_lodged]').change(function(){
    	var thisVal1=$(this).find('option:selected').html().toUpperCase();
    	if(thisVal1=='PROPERTY'){ 
    		$(this).parent('td').parent('tr').next('tr').find('select').removeAttr('disabled').css('opacity', 1);
    		$(this).parent('td').parent('tr').next('tr').next('tr').find('input').removeAttr('disabled').css('opacity', 1);
    	}   
    	else{
    		$(this).parent('td').parent('tr').next('tr').find('select').attr('disabled','disabled').css('opacity', 0);
    		$(this).parent('td').parent('tr').next('tr').next('tr').find('input').attr('disabled','disabled').css('opacity', 0);
    	}
    });
    //property condition end
    //yes condition Start
    var otherVal=$('select[name^=other_source_income]').find('option:selected').html();
    if(otherVal=='Yes'){
    	$('select[name^=other_source_income]').parent('td').parent('tr').next('tr').find('input').removeAttr('disabled').removeClass('disappeared');
    }
    else{
    	$('select[name^=other_source_income]').parent('td').parent('tr').next('tr').find('input').attr('disabled','disabled').addClass('disappeared');        
    }
    $('select[name^=other_source_income]').change(function(){
    	var otherVal = $(this).find('option:selected').html();
    	if(otherVal=='Yes'){
    		$(this).parent('td').parent('tr').next('tr').find('input').removeAttr('disabled').removeClass('disappeared');
    	}
    	else{
    		$(this).parent('td').parent('tr').next('tr').find('input').attr('disabled','disabled').addClass('disappeared');
    	}
    });
   //yes condition End
   <?php if(($utype_id ==3 || $utype_id ==4 || $utype_id ==5) && (!empty($application_id) && !empty($banking_credit_facilities))){?>
   	$('input,textarea').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('readonly', true);
        //$(this).rules('remove');
    });
   	$('select').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('disabled', true);
    });
   	$(".pull-right").hide();
   	$(".outstanding").attr('disabled', true);
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
   		$("#add_more").hide();
   		<?php } ?>
   		$("#cancel_btn").click(function(){
   			window.location.href='<?php echo base_url();?>manage/dashboard';
   		});
			/*  var v = $("#agenceyapp").validate({
				rules:{
					type_of_facility:{required:true},
					Amount:{required:true},
					purpose:{required:true},
					tenure_in_years:{required:true},
					state:{required:true},
					//district:{required:true},
					city:{required:true},
					branch:{required:true},
					security_offered:{required:true},
					primary_security:{required:true},	
					collateral_security:{required:true},
					}
				});	 */ 
				<?php if($utype_id==1 || $utype_id==2){?>	
					var v = $("#hold_frm").validate({
						rules:{
							'type_of_facility[]': {
								required: true
							},
						/* 'limits[]': {
							required: true
						}, */
						'outstanding_as_on[]': {
							required: true
						},
						/* 'presently_banking_with[]': {
							required: true
						},
						'security_lodged[]': {
							required: true
						},
						'rate_of_interest[]': {
							required: true
						},
						'monthly_emi_amount[]': {
							required: true
						},
						'balance_tenure[]': {
							required: true
						}, */
						/*'repayment_terms[]': {
							required: true
						}
						 'additional_loan_information[]': {
							required: true
						} */
					}
				});	
					$('#monthly_emi_amount,#monthly_emi_amount0,#monthly_emi_amount1,#monthly_emi_amount2').on('keyup blur input',function(){	
						var name=$(this).val();
						name=name.replace(/[^0-9.]+/g, '');
						$(this).val(name);
					});
					$('#rate_of_interest,#rate_of_interest0,#rate_of_interest1,#rate_of_interest2').on('keyup blur input',function(){	
						var name=$(this).val();
						name=name.replace(/[^0-9.]+/g, '');
				//alert(name);
				if(name>=100){
					$(this).val("");
				}else{
						//alert(name);
						//$(this).val(parseFloat(name).toFixed(2));
						var number = (name.split('.'));
						//alert(number.length);
						if (number.length > 2)
						{
							$(this).val(parseFloat(name).toFixed(2));
						}else
						{
							$(this).val(name);
						}
					}
				});
					$('#limits,#limits0').on('keyup blur input',function(){	
						var name=$(this).val();
						name=name.replace(/[^0-9.]+/g, '');
						$(this).val(name);
					});
					$('#balance_tenure,#balance_tenure0,#balance_tenure1,#balance_tenure2').on('keyup blur input',function(){	
						var name=$(this).val();
						name=name.replace(/[^0-9.]+/g, '');
						$(this).val(name);
					});
					$('.market_value').on('keyup blur input',function(){	
						var name=$(this).val();
						name=name.replace(/[^0-9.]+/g, '');
						$(this).val(name);
					});
					$(".market_value").on("keyup input blur",function(){
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
			/*$("#balance_tenure,#balance_tenure0,#balance_tenure1,#balance_tenure2").on("keyup input blur",function(){
				var val1=$(this).val();
				var val2 = val1.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				$(this).val(val2);
			}); */
			$("#monthly_emi_amount,#monthly_emi_amount0,#monthly_emi_amount1,#monthly_emi_amount2").on("keyup input blur",function(){
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
			$("#limits,#limits0").on("keyup input blur",function(){				
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
			//var totalElements1 = $('.credit1').length;
			//alert(totalElements1);
			$("#repayment_terms0").attr("readonly",true);
			$("#repayment_terms1").attr("readonly",true);
			$("#repayment_terms2").attr("readonly",true);
			$('.credit0').on('change keyup blur input',function(){
				  //var totalElements1=0;
				  var val = $(this).val();
				   //alert(val);
				   if( val != ""){							
				   	$(".pull-right").removeAttr('disabled','disabled');
				   	$("#submit_btn").removeAttr('disabled','disabled');
				   	$('input,textarea,select').attr('disabled', false);						 
				   }else{
				   	$(".pull-right").attr('disabled','disabled');
				   	$("#submit_btn").attr('disabled','disabled');
				   	$('input,textarea,select').attr('disabled', true);
				   	$(this).attr('disabled', false);
				   }
					//console.log(totalElements1);	
					//alert(totalElements1);
				}); 
			$('.credit').on('change blur input',function(){
				var totalElements=0;
								//totalElements = $(this).length();
								if($(this).val() == ""){
									$(this).removeClass("credit");
									totalElements = $(this).parent('td').parent('tr').parent('tbody').find('.credit:not(:disabled)').length;
								  //totalElements1 = $(this).length;
								}else{
									$(this).addClass("credit");
									totalElements = $(this).parent('td').parent('tr').parent('tbody').find('.credit:not(:disabled)').length;
									 //totalElements1 = $(this).length;
									}
									console.log(totalElements);
									if(totalElements==2 || totalElements ==0)
									{
										var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
										if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.credit0').length>0){
											$(this).parents('table.sbitem').parent('td').next('td').find('.credit0:not(.disappeared)').removeAttr('disabled');
										}
										$(".pull-right").removeAttr('disabled','disabled');
										$("#submit_btn").removeAttr('disabled','disabled');
									}										
									else
									{
										var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
										if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.credit0').length>0){
											$(this).parents('table.sbitem').parent('td').next('td').find('.credit0').attr('disabled','disabled');
										}
										$(".pull-right").attr('disabled','disabled');
										$("#submit_btn").attr('disabled','disabled');
									}
								}); 
		});
function emiPopulate(vl,id){
	if(vl!=''){
		var balten=$('balance_tenure'+id).val() || '';
		$('#repayment_terms'+id).val('Monthly EMI Amount: '+vl+', Balance Tenure: '+balten);			
	}
}
function tenurePopulate(vl,id){
	if(vl!=''){
		var balten=$('#monthly_emi_amount'+id).val() || '';
		$('#repayment_terms'+id).val('Monthly EMI Amount: '+balten+', Balance Tenure: '+vl);			
	}
}
<?php $cal_date=date('Y-m-d'); ?>
var output = reverseDate('<?php echo $cal_date?>');
		//var $j = jQuery.noConflict();
		function reverseDate(givenDate){
			var dateArr=givenDate.split('-').reverse().toString().replace(/,/g, "-");
			return dateArr; 
		}
		function isNumberKey0(evt)
		{
			var limit = $('#limits0').val();
			limit	= limit.split(".").length - 1;
			if(limit < 1){
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
		function isNumberKey1(evt)
		{
			var limits = $('#limits').val();
			limits	= limits.split(".").length - 1;
			if(limits < 1){
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
		function isNumberKey2(evt)
		{
			var addmore_limit = $('.addmore_limit').val();
			addmore_limit	= addmore_limit.split(".").length - 1;
			if(addmore_limit < 1){
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
		function isNumberKey3(evt)
		{
			var market_value = $('.market_value').val();
			market_value	= market_value.split(".").length - 1;
			if(market_value < 1){
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
		function isNumberKey4(evt)
		{
			var monthly_emi_amount = $('#monthly_emi_amount0').val();
			monthly_emi_amount	= monthly_emi_amount.split(".").length - 1;
			if(monthly_emi_amount < 1){
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
		function isNumberKey5(evt)
		{
			var emi_amount = $('.emi_amount').val();
			emi_amount	= emi_amount.split(".").length - 1;
			if(emi_amount < 1){
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
		$(function() {
				//var dateToday = new Date();
				//var dd = dateToday.getDate();
				//var yrRange = '1950' + ":" + (dd).toString();
				//$( "#outstanding_as_on,#outstanding_as_on0,#outstanding_as_on1,#outstanding_as_on2" ).datepicker({
					$(".outstanding").datepicker({
						dateFormat: 'dd-mm-yy',
						changeMonth: true,
						changeYear: true,
						showMonthAfterYear:true,
						//minDate:"01-01-1900",
						//maxDate: new Date() 
						maxDate: 'today',
						yearRange: '1900:' + new Date().getFullYear().toString()
					});
//            tr & td hide and show
var i = 0;
$(".know_cibil_bk").each(function() {
	var  security_lodged = $("#security_lodged"+i).val();
						//alert(know_cibil_score);
						i++;
						if(security_lodged == "Property")
						{
							$(".cibil"+i).html("");
						}
					});
$('.addMore').each(function(e){
	var namefld=$(this).attr('name');
				//alert(namefld);
				var i=0;
				if(namefld.match('security_lodged') && namefld.length==18){
					$(this).addClass('security_lodged');
				}
				if(namefld.match('cast') && namefld.length==6){
					$(this).addClass('castfld');
				}
			});	 
$('.security_lodged').change(function(){
	if($(this).val()=='2'){
		$(this).parent('td').parent('tr').next('tr').find('input').removeAttr('disabled').removeClass('disappeared');
	}
	else{
		$(this).parent('td').parent('tr').next('tr').find('input').attr('disabled','disabled').addClass('disappeared');					
	}
});
$('.security_lodged').each(function(){
	if($(this).val()=='2'){
		$(this).parent('td').parent('tr').next('tr').find('input').removeAttr('disabled').removeClass('disappeared');
	}
	else{
		$(this).parent('td').parent('tr').next('tr').find('input').attr('disabled','disabled').addClass('disappeared');					
	}
});
$('.castfld').change(function(){
	if($(this).val()=='Property'){
		$(this).parent('td').parent('tr').next('tr').find('input').removeAttr('disabled').removeClass('disappeared');
		$(this).parent('td').parent('tr').next('tr').find('label').removeClass('invisible');
	}
	else{
		$(this).parent('td').parent('tr').next('tr').find('input').attr('disabled','disabled').addClass('disappeared');		
		$(this).parent('td').parent('tr').next('tr').find('label').addClass('invisible');	
	}
});
$('.castfld').each(function(){
	if($(this).val()=='Property'){
		$(this).parent('td').parent('tr').next('tr').find('input').removeAttr('disabled').removeClass('disappeared');
		$(this).parent('td').parent('tr').next('tr').find('label').removeClass('invisible');
	}
	else{
		$(this).parent('td').parent('tr').next('tr').find('input').attr('disabled','disabled').addClass('disappeared');		
		$(this).parent('td').parent('tr').next('tr').find('label').addClass('invisible');	
	}
});	
<?php }?>	   
}); 
</script>
<!--
<script>
   function openContmp() {
$(".veh-secured td").hide();
$('#security_lodged').change(function () {
    var val = $(this).val();
    if (val == veh-secured) {
         $('.veh-secured td').show();
         $('.property_single td').hide();
    } else {
        $('.veh-secured td').hide();
         $('.property_single td').show();
    }
    });
});
</script>
-->
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
		<?php if(!empty($application_id) && empty($banking_credit_facilities)) {?>
		<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_banking_credit_facilities" method="post">
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
		<div class="content-wrapper select" id="banker-facilities_sectn">
			<div class="clear"></div>
			<h5 class="tab-form-head">Owner Director KYC Details</h5>
			<button type="button" id="add_more" class="yellow-button pull-right top-margin10 ylw" style="width:150px;" onclick="addbnkcredit()"><span class="big-text small-txt_p">Add More</span> <i class="fa fa-plus-circle" aria-hidden="true"></i>
			</button>
			<div class="p100">
				<div class="wrapr_bank-flt">
					<div class="horizontal-scroll">    
						<table class="table mixed" style="margin-bottom:0px;">
							<tbody>
								<tr class="tds_brk_fl">
									<td style="width:300px;">
										<table class="table sbitem" style="width:300px;">
											<tbody>
												<tr><td>Type of Facility <span class="star">*</span></td></tr>
												<tr><td>Limits</td> </tr>
												<tr><td>Outstanding as on <span class="star">*</span></td></tr>
												<tr><td>Name Of Bank/NBFC</td></tr>
												<tr><td>Security Provided</td></tr>
												<tr><td>Type of Property</td></tr>         
												<tr><td>Current Market Value (&#8377; in Lacs)</td></tr>         
												<tr><td>Rate of Interest(%)</td></tr>
												<tr><td>Monthly EMI Amount(&#8377; in thousand)</td></tr>
												<tr><td>Balance Tenure (Years)</td></tr>
												<tr><td>Does owner have other source of income</td></tr>       
												<tr><td>Annual Income From other Sources(&#8377; In Lacs)</td></tr>       
												<tr><td>Repayment Terms</td></tr>                    
											</tbody>
										</table>
									</td>
									<div class="clear"></div>
									<td style="width:250px;">
										<table class="table sbitem" style="width:300px;">
											<tbody>
												<tr><td>
													<select name="type_of_facility[]" id="type_of_facility" class="module-select">
														<option value="">--select--</option>
														<option value="1" >Personal Loan</option>		
														<option value="2" >Housing Loan</option>		
														<option value="3" >Loan against Property</option>
														<option value="4" >Vehicle Loan</option>
														<option value="5" >Education Loan</option>
														<option value="6" >Gold Loan</option>
														<option value="7" >Business Loan</option>
														<option value="8" >Others</option>
													</select>
													<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('type_of_facility[]'); ?></span>   
												</td></tr>
												<tr><td>
													<input type="text" onkeypress="return isNumberKey1(event)" maxlength="11" name="limits[]" id="limits" class="module-input"> 
													<td style="white-space:nowrap;">(&#8377; in Lacs)</td> 
												</td>
											</tr>
											<tr><td><input type="text" name="outstanding_as_on[]" id="outstanding_as_on" class="module-input outstanding">
												<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('outstanding_as_on[]'); ?></span>
											</td></tr>
											<tr><td><input type="text" name="name_of_bank[]" id="name_of_bank" class="module-input"></td></tr>
											<tr><td>
												<!--<input type="text" name="security_lodged[]" id="security_lodged" class="module-input">-->
												<select name="security_lodged[]" id="security_lodged" class="module-select know_cibil_bk">
													<option value="">--select--</option>
													<option class="veh-secured" value="1">Vehicle</option>		
													<option class="property_single" value="2">Property</option>		
													<option class="veh-secured" value="3">Unsecured</option>
												</select>
											</td></tr>
											<tr><td>
												<select name="if_property_selected[]" id="if_property_selected" class="module-select">
													<option value="">--select--</option>
													<option value="1" >Residential Flat</option>		
													<option value="2" >Commercial/Office</option>		
													<option value="3" >Land(Non Agriculture)</option>
													<option value="4" >Land(Agriculture)</option>
												</select>
											</td></tr>
											<tr><td><input type="text" onkeypress="return isNumberKey3(event)" name="current_market_value[]" maxlength="8" id="current_market_value" class="module-input market_value"></td></tr>
											<tr><td><input type="text" name="rate_of_interest[]" id="rate_of_interest" class="module-input"></td></tr>
											<tr><td><input type="text" onkeypress="return isNumberKey4(event)" maxlength="11" name="monthly_emi_amount[]" onblur="emiPopulate(this.value, 0)" id="monthly_emi_amount0" class="module-input"></td></tr>
											<tr><td><input type="text" maxlength="8" name="balance_tenure[]" onblur="tenurePopulate(this.value, 0)" id="balance_tenure0" class="module-input"></td>
												<!--<td style="white-space:nowrap;">(&#8377; in Lacs)</td>-->    
											</tr>
											<tr><td>
												<select name="other_source_income[]" id="other_source_income" class="module-select">
													<option value="">--select--</option>
													<option value="Yes" >Yes</option>		
													<option value="No" >No</option>
												</select>
											</td></tr>
											<tr><td><input type="text" name="other_annual_income[]" id="other_annual_income" class="module-input"></td></tr>
											<tr><td><textarea name="repayment_terms[]" id="repayment_terms0" class="module-text"></textarea></td></tr>                        
										</tbody>
									</table>
								</td>
								<script>
									var rowNum = 0;
									function addbnkcredit(){
                            //$("#add_more").click(function(){
                            	rowNum++;
                            	$("tr.tds_brk_fl").append('<td style="width:250px; position:relative;top:-18px;"><a title="Delete" href="#" class="rmv_bnk pull-right"><i class="fa fa-close"></i></a><table class="table sbitem" style="width:300px;"><tbody><tr><td><select name="type_of_facility[]" id="type_of_facility'+rowNum+'" class="module-select credit0"><option value="">--select--</option><option value="1" >Personal Loan</option><option value="2" >Housing Loan</option><option value="3" >Loan against Property</option><option value="4" >Vehicle Loan</option><option value="5" >Education Loan</option><option value="6" >Gold Loan</option></select></td></tr><tr><td><input type="text" onkeypress="return isNumberKey2(event)" name="limits[]" id="limits'+rowNum+'" class="module-input addmore_limit"></td></tr><tr><td><input type="text" name="outstanding_as_on[]" id="outstanding_as_on'+rowNum+'" class="module-input outstanding_date credit0"></td></tr><tr><td><input type="text" name="name_of_bank[]" id="name_of_bank'+rowNum+'" class="module-input"></td></tr><tr><td><select name="security_lodged[]" id="security_lodged'+rowNum+'" class="module-select"><option value="">--select--</option><option value="1" >Vehicle</option><option value="2" >Property</option><option value="3" >Unsecured</option></select></td></tr><tr><td><select name="if_property_selected[]" id="if_property_selected'+rowNum+'" class="module-select"><option value="">--select--</option><option value="1" >Residential Flat</option><option value="2" >Commercial/Office</option><option value="3" >Land(Non Agriculture)</option><option value="4" >Land(Agriculture)</option></select></td></tr><tr><td><input type="text" onkeypress="return isNumberKey3(event)" name="current_market_value[]" maxlength="8" id="current_market_value'+rowNum+'" class="module-input market_value"></td></tr><tr><td><input type="text" name="rate_of_interest[]" id="rate_of_interest'+rowNum+'" class="module-input interest_rate"></td></tr><tr><td><input type="text" onkeypress="return isNumberKey5(event)" name="monthly_emi_amount[]" onblur="emiPopulate(this.value, '+rowNum+')" id="monthly_emi_amount'+rowNum+'" class="module-input emi_amount"></td></tr><tr><td><input type="text" name="balance_tenure[]" onblur="tenurePopulate(this.value, '+rowNum+')" id="balance_tenure'+rowNum+'" class="module-input balance_tenure"></td></tr><tr><td><select name="other_source_income[]" id="other_source_income'+rowNum+'" class="module-select"><option value="">--select--</option><option value="Yes" >Yes</option><option value="No" >No</option></select></td></tr><tr><td><input type="text" name="other_annual_income[]" id="other_annual_income'+rowNum+'" class="module-input"></td></tr><tr><td><textarea name="repayment_terms[]" id="repayment_terms'+rowNum+'" class="module-text txt_area"></textarea></td></tr> </tbody></table></td>');
                            //property condition start
                            var thisVal=$('select#security_lodged'+rowNum).find('option:selected').html().toUpperCase();    
                            if(thisVal=='PROPERTY'){ 
                            	$('select#security_lodged'+rowNum).parent('td').parent('tr').next('tr').find('select').removeAttr('disabled').css('opacity', 1);
                            	$('select#security_lodged'+rowNum).parent('td').parent('tr').next('tr').next('tr').find('input').removeAttr('disabled').css('opacity', 1);
                            }   
                            else{
                            	$('select#security_lodged'+rowNum).parent('td').parent('tr').next('tr').find('select').attr('disabled','disabled').css('opacity', 0);
                            	$('select#security_lodged'+rowNum).parent('td').parent('tr').next('tr').next('tr').find('input').attr('disabled','disabled').css('opacity', 0);
                            }    
                            $('select[name^=security_lodged]').change(function(){
                            	var thisVal1=$(this).find('option:selected').html().toUpperCase();
                            	if(thisVal1=='PROPERTY'){ 
                            		$(this).parent('td').parent('tr').next('tr').find('select').removeAttr('disabled').css('opacity', 1);
                            		$(this).parent('td').parent('tr').next('tr').next('tr').find('input').removeAttr('disabled').css('opacity', 1);
                            	}   
                            	else{
                            		$(this).parent('td').parent('tr').next('tr').find('select').attr('disabled','disabled').css('opacity', 0);
                            		$(this).parent('td').parent('tr').next('tr').next('tr').find('input').attr('disabled','disabled').css('opacity', 0);
                            	}
                            });
                            //property condition end
                            //yes condition Start
                            var otherVal=$('select#other_source_income'+rowNum).find('option:selected').html();
                            if(otherVal=='Yes'){
                            	$('select#other_source_income'+rowNum).parent('td').parent('tr').next('tr').find('input').removeAttr('disabled').removeClass('disappeared');
                            }
                            else{
                            	$('select#other_source_income'+rowNum).parent('td').parent('tr').next('tr').find('input').attr('disabled','disabled').addClass('disappeared');        
                            }
                            $('select[name^=other_source_income]').change(function(){
                            	var otherVal = $(this).find('option:selected').html();
                            	if(otherVal=='Yes'){
                            		$(this).parent('td').parent('tr').next('tr').find('input').removeAttr('disabled').removeClass('disappeared');
                            	}
                            	else{
                            		$(this).parent('td').parent('tr').next('tr').find('input').attr('disabled','disabled').addClass('disappeared');
                            	}
                            });
                           //yes condition End
                           $('.rmv_bnk').on('click', function(c){
                           	$(this).parent().fadeOut('slow', function(c){
                           	});
                           	$("#submit_btn").removeAttr("disabled","disabled");
                           	$(".pull-right").removeAttr("disabled","disabled");
                           });
                           var total_class = $(".credit0").length;
							//alert(total_class);
							if(total_class==2){
								$(".pull-right").attr('disabled','disabled');
							}
							if(total_class >=4){
								$(".pull-right").attr('disabled','disabled');
							}
							$('.credit0').on('change blur input',function(){
								var totalElements1=0;
								if($(this).val() != ""){
									$(this).removeClass("credit0");
									totalElements1 = $(this).parent('td').parent('tr').parent('tbody').find('.credit0:not(:disabled)').length;
							  //totalElements1 = $(this).length;
							}else{
								$(this).addClass("credit0");
								totalElements1 = $(this).parent('td').parent('tr').parent('tbody').find('.credit0:not(:disabled)').length;
								 //totalElements1 = $(this).length;
								}
								console.log(totalElements1);	
							//alert(totalElements1);			
							if(totalElements1==0)
							{
								var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
								if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.credit0').length>0){
									$(this).parents('table.sbitem').parent('td').next('td').find('.credit0:not(.disappeared)').removeAttr('disabled');
								}
								$(".pull-right").removeAttr('disabled','disabled');
								$("#submit_btn").removeAttr('disabled','disabled');
							}
							else if(totalElements1 ==2)
							{
								$(".pull-right").removeAttr('disabled','disabled');
								$("#submit_btn").removeAttr('disabled','disabled');
								$(this).parents('table.sbitem').parent('td').html("");
							}								
							else
							{
								var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
								if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.credit0').length>0){
									$(this).parents('table.sbitem').parent('td').next('td').find('.credit0').attr('disabled','disabled');
								}
								$(".pull-right").attr('disabled','disabled');
								$("#submit_btn").attr('disabled','disabled');
							}
						});
							$(".outstanding_date").datepicker({
								dateFormat: 'dd-mm-yy',
								//dateFormat: 'yy-mm-dd',
								changeMonth: true,
								changeYear: true,
								showMonthAfterYear:true,
								//minDate:"01-01-1900",
								//maxDate: new Date() 
								//yearRange: '1900:' + new Date()
								maxDate: 'today',
								yearRange: '1900:' + new Date().getFullYear().toString()
							});
							$('.emi_amount,.balance_tenure,.addmore_limit').on('keyup blur input',function(){	
								var name=$(this).val();
								name=name.replace(/[^0-9.]+/g, '');
								$(this).val(name);
							});
							$('.interest_rate').on('keyup blur input',function(){	
								var name=$(this).val();
								name=name.replace(/[^0-9.]+/g, '');
								if(name>=100){
									$(this).val("");
								}else{
									var number = (name.split('.'));
										//alert(number.length);
										if (number.length > 2)
										{
											$(this).val(parseFloat(name).toFixed(2));
										}else
										{
											$(this).val(name);
										}
									}
								});
							$(".addmore_limit").on("keyup input blur",function(){
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
							$(".emi_amount").on("keyup input blur",function(){
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
							$('textarea').each(function() { 
								$(this).attr('readonly', true);
							});
							function emiPopulate(vl,id){
								///alert(v1);
								//alert(id);
								if(vl!=''){
									var balten=$('balance_tenure'+id).val() || '';
									alert(balten);
									$('#repayment_terms'+id).val('Monthly EMI Amount: '+vl+', Balance Tenure: '+balten);			
								}
							}
							function tenurePopulate(vl,id){
								if(vl!=''){
									var balten=$('#monthly_emi_amount'+id).val() || '';
									alert(balten);
									$('#repayment_terms'+id).val('Monthly EMI Amount: '+balten+', Balance Tenure: '+vl);			
								}
							}
							$('.market_value').on('keyup blur input',function(){	
								var name=$(this).val();
								name=name.replace(/[^0-9.]+/g, '');
								$(this).val(name);
							});
							$(".market_value").on("keyup input blur",function(){
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
						}
					</script>
				</tr>       
			</tbody>		
		</table>
	</div>     
</div>      
</div>  <!--    P100 END HERE-->
<div class="clear"></div>
<h5 class="tab-form-head">Additional Loan Information</h5>
<div class="col-lg-5" style="line-height:25px;">What is additional Monthly Interest<br>
	+ EMI liability that Business can service?</div>
	<div class="col-lg-3"><input type="text" maxlength="50" name="additional_loan_information[]" id="additional_loan_information" class="module-input" placeholder="&#8377; in Lacs"></div>
	<div class="col-lg-4">(&#8377; in Lacs)</div> 
	<div class="clear"></div>
	<input type="hidden" name="application_id" value="<?php echo $application_id;?>"
	<hr class="top-margin20 yellow-hr">
	<div class="col-lg-3 top-padding25"><button type="submit" id="submit_btn" class="yellow-button btn-default">Save &amp; Continue</button></div>
	<div class="col-lg-3 top-padding25"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>
	<!--</div>-->
</div>
</form>
<?php } else { ?>
<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_banking_credit_facilities" method="post">
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
<div class="content-wrapper select" id="banker-facilities_sectn">
	<div class="clear"></div>
	<h5 class="tab-form-head">Owner Director KYC Details</h5>
	<button type="button" id="add_more" class="yellow-button pull-right top-margin10 ylw" style="width:150px;" onclick="addbnkcredit()"><span class="big-text small-txt_p">Add More</span> <i class="fa fa-plus-circle" aria-hidden="true"></i>
	</button>
	<div class="p100">
		<div class="wrapr_bank-flt">
			<div class="horizontal-scroll">  
				<table class="table mixed" style="margin-bottom:0px;">
					<tbody>
						<tr class="tds_brk_fl">
							<td style="width:300px;">
								<table class="table sbitem" style="width:300px;">
									<tbody>
										<tr><td>Type of Facility <span class="star">*</span></td></tr>
										<tr><td>Limits</td> </tr>
										<tr><td>Outstanding as on <span class="star">*</span></td></tr>
										<tr><td>Name Of Bank/NBFC</td></tr>
										<tr><td>Security Provided</td></tr>
										<tr><td>Type of Property</td></tr>         
										<tr><td>Current Market Value (&#8377; in Lacs)</td></tr>         
										<tr><td>Rate of Interest(%)</td></tr>
										<tr><td>Monthly EMI Amount(&#8377; in thousand)</td></tr>
										<tr><td>Balance Tenure (Years)</td></tr>
										<tr><td>Does owner have other source of income</td></tr>       
										<tr><td>Annual Income From other Sources(&#8377; In Lacs)</td></tr>       
										<tr><td>Repayment Terms</td></tr>                    
									</tbody>
								</table>
							</td>
							<div class="clear"></div>
							<?php for($i=0;$i<count($banking_credit_facilities);$i++){ ?>
							<td style="width:250px;">
								<table class="table sbitem" style="width:300px;">
									<tbody>
										<tr><td>
											<select name="type_of_facility[]" id="type_of_facility<?php echo $i; ?>" class="module-select credit">
												<option value="">--select--</option>
												<option value="1" <?php if($banking_credit_facilities[$i]->type_of_facility=='1') { echo "selected"; }?>>Personal Loan</option>		
												<option value="2" <?php if($banking_credit_facilities[$i]->type_of_facility=='2') { echo "selected"; }?>>Housing Loan</option>		
												<option value="3" <?php if($banking_credit_facilities[$i]->type_of_facility=='3') { echo "selected"; }?>>Loan against Property</option>
												<option value="4" <?php if($banking_credit_facilities[$i]->type_of_facility=='4') { echo "selected"; }?>>Vehicle Loan</option>
												<option value="5" <?php if($banking_credit_facilities[$i]->type_of_facility=='5') { echo "selected"; }?>>Education Loan</option>
												<option value="6" <?php if($banking_credit_facilities[$i]->type_of_facility=='6') { echo "selected"; }?>>Gold Loan</option>
												<option value="6" <?php if($banking_credit_facilities[$i]->type_of_facility=='7') { echo "selected"; }?>>Business Loan</option>
												<option value="7" <?php if($banking_credit_facilities[$i]->type_of_facility=='8') { echo "selected"; }?>>Others</option>
											</select>
											<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('type_of_facility[]'); ?></span>
										</td></tr>
										<tr><td>
											<input type="text" onkeypress="return isNumberKey0(event)" maxlength="11" name="limits[]" id="limits<?php echo $i; ?>" value="<?php echo $banking_credit_facilities[$i]->limits; ?>" class="module-input">
										</td>
										<td style="white-space:nowrap;">(&#8377; in Lacs)</td> 
									</tr>
									<tr><td><input type="text" name="outstanding_as_on[]" id="outstanding_as_on<?php echo $i; ?>" value="<?php echo date('d-m-Y',strtotime($banking_credit_facilities[$i]->outstanding_as_on)); ?>" class="module-input outstanding credit">
										<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('outstanding_as_on[]'); ?></span>
									</td></tr>
									<tr><td><input type="text" name="name_of_bank[]" id="name_of_bank" value="<?php echo $banking_credit_facilities[$i]->name_of_bank; ?>" class="module-input"></td></tr>
									<tr><td>
										<!--<input type="text" name="security_lodged[]" id="security_lodged" class="module-input">-->
										<select name="security_lodged[]" id="security_lodged" class="module-select know_cibil_bk">
											<option value="">--select--</option>
											<option class="veh-secured" value="1" <?php if($banking_credit_facilities[$i]->security_lodged=='1') { echo "selected"; }?>>Vehicle</option>		
											<option class="property_single" value="2" <?php if($banking_credit_facilities[$i]->security_lodged=='2') { echo "selected"; }?>>Property</option>		
											<option class="veh-secured" value="3" <?php if($banking_credit_facilities[$i]->security_lodged=='3') { echo "selected"; }?>>Unsecured</option>
										</select>
									</td></tr>
									<tr><td>
										<select name="if_property_selected[]" id="if_property_selected" class="module-select">
											<option value="">--select--</option>
											<option value="1" <?php if($banking_credit_facilities[$i]->if_property_selected=='1') { echo "selected"; }?>>Residential Flat</option>		
											<option value="2" <?php if($banking_credit_facilities[$i]->if_property_selected=='2') { echo "selected"; }?>>Commercial/Office</option>		
											<option value="3" <?php if($banking_credit_facilities[$i]->if_property_selected=='3') { echo "selected"; }?>>Land(Non Agriculture)</option>
											<option value="4" <?php if($banking_credit_facilities[$i]->if_property_selected=='4') { echo "selected"; }?>>Land(Agriculture)</option>
										</select>
									</td></tr>
									<tr><td><input type="text" onkeypress="return isNumberKey3(event)" name="current_market_value[]" id="current_market_value" maxlength="8" value="<?php echo moneyFormatIndia($banking_credit_facilities[$i]->current_market_value); ?>" class="module-input market_value"></td></tr>
									<tr><td><input type="text" name="rate_of_interest[]" id="rate_of_interest<?php echo $i; ?>" value="<?php echo $banking_credit_facilities[$i]->rate_of_interest; ?>" class="module-input"></td></tr>
									<tr><td><input type="text" maxlength="11" onkeypress="return isNumberKey4(event)" onkeypress="return isNumberKey4(event)" name="monthly_emi_amount[]" onblur="emiPopulate(this.value, <?php echo $i; ?>)" id="monthly_emi_amount<?php echo $i; ?>" value="<?php echo moneyFormatIndia($banking_credit_facilities[$i]->monthly_emi_amount); ?>" class="module-input"></td></tr>
									<tr><td><input type="text" maxlength="8" name="balance_tenure[]" onblur="tenurePopulate(this.value, <?php echo $i; ?>)" id="balance_tenure<?php echo $i; ?>" value="<?php echo $banking_credit_facilities[$i]->balance_tenure; ?>" class="module-input"></td>
										<!--<td style="white-space:nowrap;">(&#8377; in Lacs)</td>-->
									</tr>
									<tr><td>
										<select name="other_source_income[]" id="other_source_income" class="module-select">
											<option value="">--select--</option>
											<option value="Yes" <?php if($banking_credit_facilities[$i]->other_source_income=='Yes') { echo "selected"; }?>>Yes</option>		
											<option value="No" <?php if($banking_credit_facilities[$i]->other_source_income=='No') { echo "selected"; }?>>No</option>
										</select>
									</td></tr>
									<?php if($banking_credit_facilities[$i]->other_source_income=='Yes'){?>
									<tr><td><input type="text" name="other_annual_income[]" id="other_annual_income" value="<?php echo $banking_credit_facilities[$i]->other_annual_income; ?>" class="module-input"></td></tr>
									<?php } ?>
									<tr><td><textarea name="repayment_terms[]" id="repayment_terms<?php echo $i; ?>" class="module-text"><?php echo $banking_credit_facilities[$i]->repayment_terms; ?></textarea></td></tr>                        
								</tbody>
							</table>
						</td> 
						<?php } ?>
						<script>
							var rowNum = <?php echo count($banking_credit_facilities); ?>;
							function addbnkcredit(){
                            //$("#add_more").click(function(){
                            	rowNum++;
                           // $("tr.tds_brk_fl").append('<td style="width:250px; position:relative;top:-18px;"><a title="Delete" href="#" class="rmv_bnk pull-right"><i class="fa fa-close"></i></a><table class="table sbitem" style="width:300px;"><tbody><tr><td><select name="type_of_facility[]" id="type_of_facility'+rowNum+'" class="module-select credit0"><option value="">--select--</option><option value="1" >Personal Loan</option><option value="2" >Housing Loan</option><option value="3" >Loan against Property</option><option value="4" >Vehicle Loan</option><option value="5" >Education Loan</option><option value="6" >Gold Loan</option></select></td></tr><tr><td><input type="text" name="limits[]" id="limits'+rowNum+'" class="module-input"></td></tr><tr><td><input type="text" name="outstanding_as_on[]" id="outstanding_as_on'+rowNum+'" class="module-input outstanding_date credit0"></td></tr><tr><td><input type="text" name="presently_banking_with[]" id="presently_banking_with'+rowNum+'" class="module-input"></td></tr><tr><td><input type="text" name="security_lodged[]" id="security_lodged'+rowNum+'" class="module-input"></td></tr><tr><td><input type="text" name="rate_of_interest[]" id="rate_of_interest'+rowNum+'" class="module-input interest_rate"></td></tr><tr><td><input type="text" name="monthly_emi_amount[]" onblur="emiPopulate(this.value, '+rowNum+')" id="monthly_emi_amount'+rowNum+'" class="module-input emi_amount"></td></tr><tr><td><input type="text" name="balance_tenure[]" onblur="tenurePopulate(this.value, '+rowNum+')" id="balance_tenure'+rowNum+'" class="module-input balance_tenure"></td></tr><tr><td><textarea name="repayment_terms[]" id="repayment_terms'+rowNum+'" class="module-text txt_area"></textarea></td></tr> </tbody></table></td>');
                           $("tr.tds_brk_fl").append('<td style="width:250px; position:relative;top:-18px;"><a title="Delete" href="#" class="rmv_bnk pull-right"><i class="fa fa-close"></i></a><table class="table sbitem" style="width:300px;"><tbody><tr><td><select name="type_of_facility[]" id="type_of_facility'+rowNum+'" class="module-select credit0"><option value="">--select--</option><option value="1" >Personal Loan</option><option value="2" >Housing Loan</option><option value="3" >Loan against Property</option><option value="4" >Vehicle Loan</option><option value="5" >Education Loan</option><option value="6" >Gold Loan</option></select></td></tr><tr><td><input type="text" onkeypress="return isNumberKey2(event)" name="limits[]" id="limits'+rowNum+'" class="module-input addmore_limit"></td></tr><tr><td><input type="text" name="outstanding_as_on[]" id="outstanding_as_on'+rowNum+'" class="module-input outstanding_date credit0"></td></tr><tr><td><input type="text" name="name_of_bank[]" id="name_of_bank'+rowNum+'" class="module-input"></td></tr><tr><td><select name="security_lodged[]" id="security_lodged'+rowNum+'" class="module-select"><option value="">--select--</option><option value="1" >Vehicle</option><option value="2" >Property</option><option value="3" >Unsecured</option></select></td></tr><tr><td><select name="if_property_selected[]" id="if_property_selected'+rowNum+'" class="module-select"><option value="">--select--</option><option value="1" >Residential Flat</option><option value="2" >Commercial/Office</option><option value="3" >Land(Non Agriculture)</option><option value="4" >Land(Agriculture)</option></select></td></tr><tr><td><input type="text" onkeypress="return isNumberKey3(event)" name="current_market_value[]" maxlength="8" id="current_market_value'+rowNum+'" class="module-input market_value"></td></tr><tr><td><input type="text" name="rate_of_interest[]" id="rate_of_interest'+rowNum+'" class="module-input interest_rate"></td></tr></tr><tr><td><input type="text" onkeypress="return isNumberKey5(event)" name="monthly_emi_amount[]" onblur="emiPopulate(this.value, '+rowNum+')" id="monthly_emi_amount'+rowNum+'" class="module-input emi_amount"></td></tr><tr><td><input type="text" name="balance_tenure[]" onblur="tenurePopulate(this.value, '+rowNum+')" id="balance_tenure'+rowNum+'" class="module-input balance_tenure"></td></tr><tr><td><select name="other_source_income[]" id="other_source_income'+rowNum+'" class="module-select"><option value="">--select--</option><option value="Yes" >Yes</option><option value="No" >No</option></select></td></tr><tr><td><input type="text" name="other_annual_income[]" id="other_annual_income'+rowNum+'" class="module-input"></td></tr><tr><td><textarea name="repayment_terms[]" id="repayment_terms'+rowNum+'" class="module-text txt_area"></textarea></td></tr> </tbody></table></td>');
							 //property condition start
							 var thisVal=$('select#security_lodged'+rowNum).find('option:selected').html().toUpperCase();    
							 if(thisVal=='PROPERTY'){ 
							 	$('select#security_lodged'+rowNum).parent('td').parent('tr').next('tr').find('select').removeAttr('disabled').css('opacity', 1);
							 	$('select#security_lodged'+rowNum).parent('td').parent('tr').next('tr').next('tr').find('input').removeAttr('disabled').css('opacity', 1);
							 }   
							 else{
							 	$('select#security_lodged'+rowNum).parent('td').parent('tr').next('tr').find('select').attr('disabled','disabled').css('opacity', 0);
							 	$('select#security_lodged'+rowNum).parent('td').parent('tr').next('tr').next('tr').find('input').attr('disabled','disabled').css('opacity', 0);
							 }    
							 $('select[name^=security_lodged]').change(function(){
							 	var thisVal1=$(this).find('option:selected').html().toUpperCase();
							 	if(thisVal1=='PROPERTY'){ 
							 		$(this).parent('td').parent('tr').next('tr').find('select').removeAttr('disabled').css('opacity', 1);
							 		$(this).parent('td').parent('tr').next('tr').next('tr').find('input').removeAttr('disabled').css('opacity', 1);
							 	}   
							 	else{
							 		$(this).parent('td').parent('tr').next('tr').find('select').attr('disabled','disabled').css('opacity', 0);
							 		$(this).parent('td').parent('tr').next('tr').next('tr').find('input').attr('disabled','disabled').css('opacity', 0);
							 	}
							 });
                            //property condition end
                            //yes condition Start
                            var otherVal=$('select#other_source_income'+rowNum).find('option:selected').html();
                            if(otherVal=='Yes'){
                            	$('select#other_source_income'+rowNum).parent('td').parent('tr').next('tr').find('input').removeAttr('disabled').removeClass('disappeared');
                            }
                            else{
                            	$('select#other_source_income'+rowNum).parent('td').parent('tr').next('tr').find('input').attr('disabled','disabled').addClass('disappeared');        
                            }
                            $('select[name^=other_source_income]').change(function(){
                            	var otherVal = $(this).find('option:selected').html();
                            	if(otherVal=='Yes'){
                            		$(this).parent('td').parent('tr').next('tr').find('input').removeAttr('disabled').removeClass('disappeared');
                            	}
                            	else{
                            		$(this).parent('td').parent('tr').next('tr').find('input').attr('disabled','disabled').addClass('disappeared');
                            	}
                            });
                           //yes condition End
                           $('.rmv_bnk').on('click', function(c){
                           	$(this).parent().fadeOut('slow', function(c){
                           	});
                           	$("#submit_btn").removeAttr("disabled","disabled");
                           	$(".pull-right").removeAttr("disabled","disabled");
                           });
                           var total_class = $(".credit0").length;
							//alert(total_class);
							if(total_class==2){
								$(".pull-right").attr('disabled','disabled');
							}
							if(total_class >=4){
								$(".pull-right").attr('disabled','disabled');
							}
							$('.credit0').on('change blur input',function(){
								var totalElements1=0;
								if($(this).val() != ""){
									$(this).removeClass("credit0");
									totalElements1 = $(this).parent('td').parent('tr').parent('tbody').find('.credit0:not(:disabled)').length;
							  //totalElements1 = $(this).length;
							}else{
								$(this).addClass("credit0");
								totalElements1 = $(this).parent('td').parent('tr').parent('tbody').find('.credit0:not(:disabled)').length;
								 //totalElements1 = $(this).length;
								}
								console.log(totalElements1);	
							//alert(totalElements1);			
							if(totalElements1==0)
							{
								var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
								if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.credit0').length>0){
									$(this).parents('table.sbitem').parent('td').next('td').find('.credit0:not(.disappeared)').removeAttr('disabled');
								}
								$(".pull-right").removeAttr('disabled','disabled');
								$("#submit_btn").removeAttr('disabled','disabled');
							}	
							else if(totalElements1 ==2)
							{
								$(".pull-right").removeAttr('disabled','disabled');
								$("#submit_btn").removeAttr('disabled','disabled');
								$(this).parents('table.sbitem').parent('td').html("");
							}
							else
							{
								var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
								if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.credit0').length>0){
									$(this).parents('table.sbitem').parent('td').next('td').find('.credit0').attr('disabled','disabled');
								}
								$(".pull-right").attr('disabled','disabled');
								$("#submit_btn").attr('disabled','disabled');
							}
						});
							$( ".outstanding_date" ).datepicker({
								dateFormat: 'dd-mm-yy',
								//dateFormat: 'yy-mm-dd',
								changeMonth: true,
								changeYear: true,
								showMonthAfterYear:true,
								//minDate:"01-01-1900",
								//maxDate: new Date() 
								//yearRange: '1900:' + new Date()
								maxDate: 'today',
								yearRange: '1900:' + new Date().getFullYear().toString()
							});
							$('.emi_amount,.balance_tenure,.addmore_limit').on('keyup blur input',function(){	
								var name=$(this).val();
								name=name.replace(/[^0-9.]+/g, '');
								$(this).val(name);
							});
							$('.interest_rate').on('keyup blur input',function(){	
								var name=$(this).val();
								name=name.replace(/[^0-9.]+/g, '');
								if(name>=100){
									$(this).val("");
								}else{
									var number = (name.split('.'));
										//alert(number.length);
										if (number.length > 2)
										{
											$(this).val(parseFloat(name).toFixed(2));
										}else
										{
											$(this).val(name);
										}
									}
								});
							$(".addmore_limit").on("keyup input blur",function(){
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
							$(".emi_amount").on("keyup input blur",function(){
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
							$('textarea').each(function() { 
								$(this).attr('readonly', true);
							});
							function emiPopulate(vl,id){
								///alert(v1);
								//alert(id);
								if(vl!=''){
									var balten=$('balance_tenure'+id).val() || '';
									alert(balten);
									$('#repayment_terms'+id).val('Monthly EMI Amount: '+vl+', Balance Tenure: '+balten);			
								}
							}
							function tenurePopulate(vl,id){
								if(vl!=''){
									var balten=$('#monthly_emi_amount'+id).val() || '';
									alert(balten);
									$('#repayment_terms'+id).val('Monthly EMI Amount: '+balten+', Balance Tenure: '+vl);			
								}
							}
							$('.market_value').on('keyup blur input',function(){	
								var name=$(this).val();
								name=name.replace(/[^0-9.]+/g, '');
								$(this).val(name);
							});
							$(".market_value").on("keyup input blur",function(){
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
						}
					</script>
				</tr>       
			</tbody>		
		</table>
	</div>  
	<div class="clear"></div>
	<h5 class="tab-form-head">Additional Loan Information</h5>
	<div class="col-lg-5" style="line-height:25px;">What is additional Monthly Interest<br>
		+ EMI liability that Business can service?</div>
		<div class="col-lg-3"><input type="text" maxlength="50" name="additional_loan_information[]" id="additional_loan_information" value="<?php echo moneyFormatIndia($banking_credit_facilities[0]->additional_loan_information); ?>" class="module-input" placeholder="&#8377; in Lacs">
		</div>
		<div class="col-lg-4">(&#8377; in Lacs)</div> 
		<div class="clear"></div>
		<input type="hidden" name="application_id" value="<?php echo $application_id;?>" />
		<input type="hidden" name="flag" value="1"/>
		<hr class="top-margin20 yellow-hr">
		<div class="col-lg-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default"><?php if($utype_id ==3 || $utype_id ==4 || $utype_id ==5){ echo "Next"; }else { echo "Save &amp; Continue";} ?></button></div>
		<div class="col-lg-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>
	</div>    
</div> <!-- p100 end here-->
</div>
</form>
<?php } ?>