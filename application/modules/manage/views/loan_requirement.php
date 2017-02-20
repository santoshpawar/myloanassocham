<script src="<?php echo base_url()?>assets/front/js/jquery-ui.js"></script>
<link href="<?php echo base_url()?>assets/front/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>

<script type="text/javascript" language="javascript">
$(document).ready(function(){
	
<?php if(validation_errors() =="") {?>
$(".requirederror").css("display","none");
<?php } ?>

<?php if(($utype_id ==3 || $utype_id ==4 || $utype_id ==5) && (!empty($application_id) && !empty($loan_requirement))){?>
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
					type_of_facility:{required:true},
					Amount:{required:true},
					purpose:{required:true},
					tenure_in_years:{required:true},
					//state:{required:true},
					//district:{required:true},
					//city:{required:true},
					//branch:{required:true},
					//security_offered:{required:true},
					//primary_security:{required:true},	
					//collateral_security:{required:true},
					
					
					}
				});	 
				
				$('#Amount').on('keyup blur input',function(){	
				var name=$(this).val();
				name=name.replace(/[^0-9.]+/g, '');
				$(this).val(name);
			});
			
			$('#branch').on('keyup blur input',function(){	
				var branch=$(this).val();
				branch=branch.replace(/[^a-zA-Z ]+/g, '');
				$(this).val(branch);
			});
				
				
			$("#Amount").on("keyup input blur",function(){
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
		
		
		});
		
		
		
		
		 <?php $cal_date=date('Y-m-d'); ?>
		var output = reverseDate('<?php echo $cal_date?>');
		//var $j = jQuery.noConflict();
		
		
		function reverseDate(givenDate){
			var dateArr=givenDate.split('-').reverse().toString().replace(/,/g, "-");
			return dateArr; 
		}
		function isNumberKey(evt)
			{
			 var Amount = $('#Amount').val();
			 Amount	= Amount.split(".").length - 1;
			 if(Amount < 1){
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

<script>
   $(function() {
    /* $( "#tenure_in_years" ).datepicker({
					dateFormat: 'dd-mm-yy',
					changeMonth: true,
					changeYear: true,
					minDate:"today",
					maxDate:'31-12-2020' 
				}); */
  }); 
</script>
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

<?php if(!empty($application_id) && empty($loan_requirement)) {?>
<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_loan_requirement" method="post">
<!--<?php if(validation_errors() !="") {?>
<script>
		$(document).ready(function(){
			$("#validate_error").show().delay(5000).fadeOut('slow');
		})
	</script>
<span id='validate_error' class='alert alert-success alrt_md'><strong><?php echo validation_errors(); ?></strong></span>
<?php } ?>-->

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
        <h5 class="tab-form-head">Details of Credit Facility (Proposed)</h5>
        <div class="p100">
        <div class="col-lg-4">Type of Facility <span class="star">*</span></div>
        <div class="col-lg-5"><select title="Facility is required" name="type_of_facility" id="type_of_facility" class="module-select">
		<option value="">--select--</option>
			<option value="1">Personal Loan</option>		
			<option value="2">Housing Loan</option>		
			<option value="3">Loan against Property</option>
			<option value="4">Vehicle Loan</option>
			<option value="5">Education Loan</option>
			<option value="6">Gold Loan</option>
		 	<option value="7">Business Loan</option>
			<option value="8">Others</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('type_of_facility'); ?></span>
		</div>
        <div class="clear"></div>
        <div class="col-lg-4">Amount (&#8377; in Lacs) <span class="star">*</span></div>
        <div class="col-lg-5"><input type="text" onkeypress="return isNumberKey(event)" title="Amount is required" maxlength="11" name="Amount" id="Amount" placeholder="&#8377; in Lacs" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('Amount'); ?></span>
		</div>
            <div class="col-lg-3">(&#8377; in Lacs)</div> 
        <div class="clear"></div>
        <div class="col-lg-4">Purpose <span class="star">*</span></div>
        <div class="col-lg-5">
		<!--<textarea name="purpose" id="purpose" class="module-text"></textarea>-->
		
		<select name="purpose" title="Purpose is required" id="purpose" class="module-select">
			<option value="">--select--</option>
			
			<option value="Finance Inventory" >Finance Inventory</option>		
			<option value="Finance Debtors" >Finance Debtors</option>		
			<option value="Payment to Vendors" >Payment to Vendors</option>
			<option value="Purchase of Equipment" >Purchase of Equipment</option>
			<option value="Purchase of Property" >Purchase of Property</option>
			<option value="Margin For LC For Raw Material Purchase" >Margin For LC For Raw Material Purchase</option>
			<option value="Margin For LC For Fixed Asset Purchase" >Margin For LC For Fixed Asset Purchase</option>
			<option value="Short Term Advance Payment to Contractors For Project" >Short Term Advance Payment to Contractors For Project</option>
			<option value="Capital Expenditure" >Capital Expenditure</option>
			<option value="Business Running Expenses" >Business Running Expenses/Short Term Cashflow Mismatch/Tax Payment</option>
			<option value="Promoters Personal Expenses" >Promoters Personal Expenses</option>
			<option value="Long Term WC" >Long Term WC</option>
			
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('purpose'); ?></span>
		</div>
        <div class="clear"></div>
        <div class="col-lg-4">Tenure in Years <span class="star">*</span></div>
        <div class="col-lg-5">
		<!--<input type="text" name="tenure_in_years" id="tenure_in_years" class="module-input">-->
		<select name="tenure_in_years" title="Tenure is required" id="tenure_in_years" class="module-select">
			<option value="">--select--</option>
			<option value="1">1</option>		
			<option value="2">2</option>		
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('tenure_in_years'); ?></span>
		</div>
        <div class="clear"></div>
        <div class="col-lg-12"><h5 class="details">---------Details from where Loan is required----------</h5></div>
        <div class="clear"></div>
        <div class="col-lg-4">State</div>
        <div class="col-lg-5"><select title="State is required" name="state" id="state" class="module-select">
		
		<option value="">--select--</option>
			<?php 
			foreach($state as $k=>$st){ ?>
				<option value="<?php echo $st->id; ?>"><?php echo $st->name; ?> </option>
			<?php } ?>
		
		</select></div>
        <div class="clear"></div>
        <!--<div class="col-lg-4">District</div>
        <div class="col-lg-5"><select name="" id="" class="module-select">		
		
		</select></div>
        <div class="clear"></div>-->
        <div class="col-lg-4">City</div>
        <div class="col-lg-5"><select title="City is required" name="city" id="city" class="module-select">
		
		</select></div>
        <div class="clear"></div>
        <div class="col-lg-4">Branch</div>
        <div class="col-lg-5"><input type="text" title="Branch is required" maxlength="200" name="branch" id="branch" class="module-input"></div>
		<div class="clear"></div>
		<input type="hidden" name="application_id" value="<?php echo $application_id;?>"/>
		<hr class="top-margin20 yellow-hr">
        <div class="col-sm-3 top-padding10"><button type="submit" class="yellow-button btn-default">Save &amp; Continue</button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>
        </div>
      </div>
</form>
<?php } else {?>

<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_loan_requirement" method="post">
<!--<?php if(validation_errors() !="") {?>
<script>
		$(document).ready(function(){
			$("#validate_error").show().delay(5000).fadeOut('slow');
		})
	</script>
<span id='validate_error' class='alert alert-success alrt_md'><strong><?php echo validation_errors(); ?></strong></span>
<?php } ?>-->

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
        <h5 class="tab-form-head">Details of Credit Facility (Proposed)</h5>
        <div class="p100">
        <div class="col-lg-4">Type of Facility <span class="star">*</span></div>
        <div class="col-lg-5"><select title="Facility is required" name="type_of_facility" id="type_of_facility" class="module-select">
			<option value="">--select--</option>
			
			<option value="1" <?php if($loan_requirement[0]->type_of_facility=='1') { echo "selected"; }?>>Personal Loan</option>		
			<option value="2" <?php if($loan_requirement[0]->type_of_facility=='2') { echo "selected"; }?>>Housing Loan</option>		
			<option value="3" <?php if($loan_requirement[0]->type_of_facility=='3') { echo "selected"; }?>>Loan against Property</option>
			<option value="4" <?php if($loan_requirement[0]->type_of_facility=='4') { echo "selected"; }?>>Vehicle Loan</option>
			<option value="5" <?php if($loan_requirement[0]->type_of_facility=='5') { echo "selected"; }?>>Education Loan</option>
			<option value="5" <?php if($loan_requirement[0]->type_of_facility=='6') { echo "selected"; }?>>Gold Loan</option>
			<option value="5" <?php if($loan_requirement[0]->type_of_facility=='7') { echo "selected"; }?>>Business Loan</option>
			<option value="5" <?php if($loan_requirement[0]->type_of_facility=='8') { echo "selected"; }?>>Others</option>
			
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('type_of_facility'); ?></span>
		</div>
        <div class="clear"></div>
        <div class="col-lg-4">Amount (&#8377; in Lacs) <span class="star">*</span></div>
        <div class="col-lg-5"><input type="text" onkeypress="return isNumberKey(event)" title="Amount is required" maxlength="11" name="Amount" id="Amount" value="<?php echo moneyFormatIndia($loan_requirement[0]->Amount);?>" placeholder="&#8377; in Lacs" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('Amount'); ?></span>
		</div>
            <div class="col-lg-3">(&#8377; in Lacs)</div> 
        <div class="clear"></div>
        <div class="col-lg-4">Purpose <span class="star">*</span></div>
        <div class="col-lg-5">
		<!--<textarea name="purpose" id="purpose"  class="module-text"><?php //echo $loan_requirement[0]->purpose;?></textarea>-->
		
		<select name="purpose" title="Purpose is required" id="purpose" class="module-select">
			<option value="">--select--</option>
			
			<option value="Finance Inventory" <?php if($loan_requirement[0]->purpose=='Finance Inventory') { echo "selected"; }?>>Finance Inventory</option>		
			<option value="Finance Debtors" <?php if($loan_requirement[0]->purpose=='Finance Debtors') { echo "selected"; }?>>Finance Debtors</option>		
			<option value="Payment to Vendors" <?php if($loan_requirement[0]->purpose=='Payment to Vendors') { echo "selected"; }?>>Payment to Vendors</option>
			<option value="Purchase of Equipment" <?php if($loan_requirement[0]->purpose=='Purchase of Equipment') { echo "selected"; }?>>Purchase of Equipment</option>
			<option value="Purchase of Property" <?php if($loan_requirement[0]->purpose=='Purchase of Property') { echo "selected"; }?>>Purchase of Property</option>
			<option value="Margin For LC For Raw Material Purchase" <?php if($loan_requirement[0]->purpose=='Margin For LC For Raw Material Purchase') { echo "selected"; }?>>Margin For LC For Raw Material Purchase</option>
			<option value="Margin For LC For Fixed Asset Purchase" <?php if($loan_requirement[0]->purpose=='Margin For LC For Fixed Asset Purchase') { echo "selected"; }?>>Margin For LC For Fixed Asset Purchase</option>
			<option value="Short Term Advance Payment to Contractors For Project" <?php if($loan_requirement[0]->purpose=='Short Term Advance Payment to Contractors For Project') { echo "selected"; }?>>Short Term Advance Payment to Contractors For Project</option>
			<option value="Capital Expenditure" <?php if($loan_requirement[0]->purpose=='Capital Expenditure') { echo "selected"; }?>>Capital Expenditure</option>
			<option value="Business Running Expenses" <?php if($loan_requirement[0]->purpose=='Business Running Expenses') { echo "selected"; }?>>Business Running Expenses/Short Term Cashflow Mismatch/Tax Payment</option>
			<option value="Promoters Personal Expenses" <?php if($loan_requirement[0]->purpose=='Promoters Personal Expenses') { echo "selected"; }?>>Promoters Personal Expenses</option>
			<option value="Long Term WC" <?php if($loan_requirement[0]->purpose=='Long Term WC') { echo "selected"; }?>>Long Term WC</option>
			
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('purpose'); ?></span>
		</div>
        <div class="clear"></div>
        <div class="col-lg-4">Tenure in Years <span class="star">*</span></div>
        <div class="col-lg-5">
		<!--<input type="text" name="tenure_in_years" id="tenure_in_years" value="<?php //echo $loan_requirement[0]->tenure_in_years;?>" class="module-input">-->
		<select title="Tenure is required" name="tenure_in_years" id="tenure_in_years" class="module-select">
			<option value="">--select--</option>
			<option value="1" <?php if($loan_requirement[0]->tenure_in_years==1) { echo "selected"; }?>>1</option>		
			<option value="2" <?php if($loan_requirement[0]->tenure_in_years==2) { echo "selected"; }?>>2</option>		
			<option value="3" <?php if($loan_requirement[0]->tenure_in_years==3) { echo "selected"; }?>>3</option>
			<option value="4" <?php if($loan_requirement[0]->tenure_in_years==4) { echo "selected"; }?>>4</option>
			<option value="5" <?php if($loan_requirement[0]->tenure_in_years==5) { echo "selected"; }?>>5</option>
			<option value="6" <?php if($loan_requirement[0]->tenure_in_years==6) { echo "selected"; }?>>6</option>
			<option value="7" <?php if($loan_requirement[0]->tenure_in_years==7) { echo "selected"; }?>>7</option>
			<option value="8" <?php if($loan_requirement[0]->tenure_in_years==8) { echo "selected"; }?>>8</option>
			<option value="9" <?php if($loan_requirement[0]->tenure_in_years==9) { echo "selected"; }?>>9</option>
			<option value="10" <?php if($loan_requirement[0]->tenure_in_years==10) { echo "selected"; }?>>10</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('tenure_in_years'); ?></span>
		</div>
        <div class="clear"></div>
        <div class="col-lg-12"><h5 class="details">---------Details from where Loan is required----------</h5></div>
        <div class="clear"></div>
        <div class="col-lg-4">State</div>
        <div class="col-lg-5"><select title="State is required" name="state" id="state" class="module-select">
		
		<option value="">--select--</option>
			<?php 
			//foreach($state as $k=>$st){ ?>
				<!--<option value="<?php echo $st->id; ?>"><?php echo $st->name; ?> </option>-->
			<?php //} ?>
			
			<?php 
			foreach($state as $k=>$st){ ?>
				<option value="<?php echo $st->id; ?>" <?php if($st->id==$loan_requirement[0]->state){ echo "selected"; }  ?>><?php echo $st->name; ?> </option>
			<?php } ?>
		
		</select></div>
        <div class="clear"></div>
        <!--<div class="col-lg-4">District</div>
        <div class="col-lg-5"><select name="" id="" class="module-select">
		
		
		</select></div>
        <div class="clear"></div>-->
        <div class="col-lg-4">City</div>
        <div class="col-lg-5"><select title="City is required" name="city" id="city" class="module-select">
		<?php 
			foreach($city as $k1=>$ct){ ?>
				<option value="<?php echo $ct->id; ?>" <?php if($ct->id==$loan_requirement[0]->city){ echo "selected"; }  ?>><?php echo $ct->name; ?> </option>
			<?php } ?>
		</select></div>
        <div class="clear"></div>
        <div class="col-lg-4">Branch</div>
        <div class="col-lg-5"><input type="text" title="Branch is required" maxlength="200" name="branch" id="branch" value="<?php echo $loan_requirement[0]->branch;?>" class="module-input"></div>
		<div class="clear"></div>
		<input type="hidden" name="application_id" value="<?php echo $application_id;?>"/>
		<input type="hidden" name="flag" value="1"/>
		
		<hr class="top-margin20 yellow-hr">
        <div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default"><?php if($utype_id ==3 || $utype_id ==4 || $utype_id ==5){ echo "Next"; }else { echo "Save &amp; Continue";} ?></button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>
        </div>
      </div>
</form>

<?php } ?>