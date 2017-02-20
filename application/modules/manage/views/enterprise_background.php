<script src="<?php echo base_url()?>assets/front/js/jquery-ui.js"></script>
<link href="<?php echo base_url()?>assets/front/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){	
	
<?php if(validation_errors() =="") {?>
$(".requirederror").css("display","none");
<?php } ?>
	
	<?php if(($utype_id ==3 || $utype_id ==4 || $utype_id ==5) && (!empty($application_id) && !empty($enterprise_background))){?>
	$('input,textarea').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('readonly', true);
	});
	
	$('input:radio').each(function() { 
                	if( $(this).is(":checked"))
                		$(this).attr('disabled', false);
                	else
                		$(this).attr('disabled', true);
                });
				
	$('select').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('disabled', true);
       
		
	});
	
    $("#date_of_establishment").attr('disabled', true);
	$(".pull-right").hide();

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
					

					pan:{required:true},
					//vat:{required:true},
					//cin:{required:true},
					//service_tax:{required:true},
					industry_segment:{required:true},
					date_of_establishment:{required:true},
					//adress_of_factoy:{required:true},
					//adress1:{required:true},
					//adress2:{required:true},
					//existing_activity:{required:true},
					//amount_invested_plant_machinery:{required:true},
					//amount_invested_equipments:{required:true},	
					//geographical_areas:{required:true},
					//no_of_operating_states:{required:true},
					//key_products_services:{required:true},
					
					
					}
				});	
				
				/* $('#vat').on('keyup blur input',function(){	
					var name=$(this).val();
					name=name.replace(/[^0-9]+/g, '');
					$(this).val(name);
				});	 */			

				/* $('#service_tax').on('keyup blur input',function(){	
					var name=$(this).val();
					name=name.replace(/[^0-9.]+/g, '');
					$(this).val(name);
				}); */
				
				$('#amount_invested_plant_machinery1,#amount_invested_equipments').on('keyup input blur',function(){	
					var name=$(this).val();
					name=name.replace(/[^0-9.]+/g, '');
					$(this).val(name);
				});
				
			/*$("#amount_invested_plant_machinery,#amount_invested_equipments").on("keyup input blur",function(){
				var val1=$(this).val();
				var val2 = val1.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				$(this).val(val2);
			});
			
			
			 $('#pan').keyup(function(){
				var pan = $(this).val().length;
				if(pan < 10)
				 {
					  $("#span_pan").html("<p>Enter 10 digits PAN no.</p>");
					  $("#submit_btn").attr('disabled','disabled');
				 }else{
					  $("#span_pan").html("");
					  $("#submit_btn").removeAttr('disabled','disabled');
				 }
			
			}); */
			
			
			//invested_plant  invested_equipments
			
			/* var existing_activity = $("#existing_activity").val();
			  if(existing_activity == "")
			  {
				  $(".invested_plant1").html("");
				  $(".invested_equipments1").html("");
			  }
						
			$("#existing_activity").change(function() {
				
			  var existing_activity = $(this).val();
			  if(existing_activity == "")
			  {
				  $(".invested_plant").html("");
				  $(".invested_equipments").html("");
			  }
			  if(existing_activity == "Manufacturing")
			  {
				  $(".invested_plant").html('<div class="col-lg-4">Amount invested in Plants &amp; Machinery</div><div class="col-lg-5"><input type="text" name="amount_invested_plant_machinery" id="amount_invested_plant_machinery" value="" class="module-input" placeholder="Rs. in Lacs"></div>');
				  $(".invested_equipments").html("");				  
			  }
			  if(existing_activity == "Service")
			  {
				  $(".invested_equipments").html('<div class="col-lg-4">Amount invested in Equipments</div><div class="col-lg-5"><input type="text" name="amount_invested_equipments" id="amount_invested_equipments" value="" class="module-input" placeholder="Rs. in Lacs"></div>');
				  $(".invested_plant").html("");
			  } 
			  
			  });*/
			  
			  $('#amount_invested_plant_machinery,#amount_invested_equipments').on('keyup input blur',function(){	
					var name=$(this).val();
					name=name.replace(/[^0-9.]+/g, '');
					$(this).val(name);
				});
				$("#amount_invested_plant_machinery,#amount_invested_equipments").on("keyup input blur",function(){
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
				
			
				/*  $('#vat').on("keyup input blur",function(){

					var vat = $(this).val().length;
					//alert(pan_enterprise);
					if(vat !=""){
						if(vat < 15)
						 {
							  $("#span_vat").html("<p>Enter 15 digits VAT no.</p>");
							  $("#submit_btn").attr('disabled','disabled');
						 }else{
							  $("#span_vat").html("");
							  $("#submit_btn").removeAttr('disabled','disabled');
						 }
					}else{
						$("#span_vat").html("");
					    $("#submit_btn").removeAttr('disabled','disabled'); 
					}
			
				 }); */
				 
				 $('#pan').on("keyup input",function(){

					fnValidatePAN(this);
				 });
				 
				 $('#cin').on("keyup input",function(){

					fnValidateCIN(this);
				 });
				 
				 $('#service_tax').on("keyup input",function(){

					fnValidateTAX(this);
				 });
				 /* 
				 $('#cin').on("keyup input blur",function(){

					var cin = $(this).val().length;
					//alert(pan_enterprise);
					if(cin !=""){
						if(cin < 21)
						 {
							  $("#span_cin").html("<p>Enter 21 digits CIN no.</p>");
							  $("#submit_btn").attr('disabled','disabled');
						 }else{
							  $("#span_cin").html("");
							  $("#submit_btn").removeAttr('disabled','disabled');
						 }
					}else{
						$("#span_cin").html("");
						$("#submit_btn").removeAttr('disabled','disabled');
					}
			
				 }); */
				 
				 /* $('#service_tax').on("keyup input blur",function(){

					var service_tax = $(this).val().length;
					//alert(pan_enterprise);
					if(service_tax !=""){
						if(service_tax < 15)
						 {
							  $("#span_tax").html("<p>Enter 15 digits TAX no.</p>");
							  $("#submit_btn").attr('disabled','disabled');
						 }else{
							  $("#span_tax").html("");
							  $("#submit_btn").removeAttr('disabled','disabled');
						 }
					}else{
						$("#span_tax").html("");
						$("#submit_btn").removeAttr('disabled','disabled');
					}
			
				 }); */
				
			//For alphabetically in drop down  
				var my_options = $("#industry_segment option");
				var selected = $("#industry_segment").val();

				my_options.sort(function(a,b) {
				if (a.text > b.text) return 1;
				if (a.text < b.text) return -1;
				return 0
				})

				$("#industry_segment").empty().append( my_options );
				$("#industry_segment").val(selected);
			//End alphabetically in drop down 
 <?php } ?>
		});
		
		
			
						
			function isNumber(evt) {
				var iKeyCode = (evt.which) ? evt.which : evt.keyCode
				if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
					return false;

				return true;
			} 
		
		
		</script>
<script>
   $(function() {
	   //var dateToday = new Date();
	   //var dd = dateToday.getDate();
	  //var yrRange = '1950' + ":" + (dd).toString();
    $( "#date_of_establishment" ).datepicker({
					dateFormat: 'dd-mm-yy',
					changeMonth: true,
					changeYear: true,
					showMonthAfterYear:true,
					//minDate:"01-01-1900",
					//maxDate: new Date()
					maxDate: 'today',					
					yearRange: '1900:' + new Date().getFullYear().toString()
					
				});
  }); 
  
  function fnValidatePAN(Obj) {
        if (Obj == null) Obj = window.event.srcElement;
        if (Obj.value != "") {
            ObjVal = Obj.value;
			var pan_enterprise = ObjVal.length;
            var panPat = "^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$";
            var code = /([C,P,H,F,A,T,B,L,J,G])/;
            var code_chk = ObjVal.substring(3,4);
            if (ObjVal.search(panPat) == -1 || pan_enterprise < 10) {
                //alert("Invalid Pan No");
                //Obj.focus();
				//return false;
				$("#span_pan").html("<p>Invalid Pan No.</p>");
				$("#submit_btn").attr('disabled','disabled');
                
            }else{
				$("#span_pan").html("");
				$("#submit_btn").removeAttr('disabled','disabled');
			}
			
            
        }else{
			$("#span_pan").html("");
			$("#submit_btn").removeAttr('disabled','disabled');
		}
   }
   
   
   function fnValidateTAX(Obj) {
        if (Obj == null) Obj = window.event.srcElement;
        if (Obj.value != "") {
            ObjVal = Obj.value;
			var tax = ObjVal.length;
            var panPat = /^([a-zA-Z]{5})(\d{4})([a-zA-Z]{1})([STDstd]{2})(\d{3})$/;
            var code = /([C,P,H,F,A,T,B,L,J,G])/;
            var code_chk = ObjVal.substring(3,4);
			//alert(ObjVal.search(panPat));
            if (ObjVal.search(panPat) == -1) {
                //alert("Invalid Pan No");
                //Obj.focus();
				//return false;
				$("#span_tax").html("<p>Invalid TAX No.</p>");
				$("#submit_btn").attr('disabled','disabled');
                
            }else if(tax < 15){
				$("#span_tax").html("<p>Enter 15 digits TAX No.</p>");
				$("#submit_btn").attr('disabled','disabled');
				
			}else{
				$("#span_tax").html("");
				$("#submit_btn").removeAttr('disabled','disabled');
			}			
           
        }else{
			$("#span_tax").html("");
			$("#submit_btn").removeAttr('disabled','disabled');
		}
   }
   
   
   function fnValidateCIN(Obj) {
        if (Obj == null) Obj = window.event.srcElement;
        if (Obj.value != "") {
            ObjVal = Obj.value;
			var CIN = ObjVal.length;
            var panPat = /^([LUlu]{1})(\d{5})([a-zA-Z]{2})(\d{4})([PLCTplct]{3})(\d{6})$/;
            var code = /([C,P,H,F,A,T,B,L,J,G])/;
            var code_chk = ObjVal.substring(3,4);
			//alert(ObjVal.search(panPat));
            if (ObjVal.search(panPat) == -1) {
                //alert("Invalid Pan No");
                //Obj.focus();
				//return false;
				$("#span_cin").html("<p>Invalid CIN No.</p>");
				$("#submit_btn").attr('disabled','disabled');
                
            }else if(CIN < 15){
				$("#span_cin").html("<p>Enter 21 digits CIN No.</p>");
				$("#submit_btn").attr('disabled','disabled');
				
			}else{
				$("#span_cin").html("");
				$("#submit_btn").removeAttr('disabled','disabled');
			}			
           
        }else{
			$("#span_cin").html("");
			$("#submit_btn").removeAttr('disabled','disabled');
		}
   }
   
   function isNumberKey1(evt)
			{
			 var amount_invested = $('#amount_invested_plant_machinery').val();
			 amount_invested	= amount_invested.split(".").length - 1;
			 if(amount_invested < 1){
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
			 var amount_equipments = $('#amount_invested_equipments').val();
			 amount_equipments	= amount_equipments.split(".").length - 1;
			 if(amount_equipments < 1){
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

<?php if(!empty($application_id) && empty($enterprise_background)) {?>

<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_enterprise_background" method="post">


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
        <h5 class="tab-form-head">KYC Details</h5>
        <div class="p100">
        <div class="col-lg-5">PAN <span class="star">*</span></div>
        <div class="col-lg-5"><input type="text" title="PAN is required" maxlength="10"  style="text-transform: uppercase" name="pan" id="pan" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pan'); ?></span>
		</div><span id="span_pan"></span>
        <div class="clear"></div>
        <div class="col-lg-5">VAT</div>
        <div class="col-lg-5"><input type="text" title="VAT is required" maxlength="15" style="text-transform: uppercase" name="vat" id="vat" class="module-input"></div><span id="span_vat"></span>
        <div class="clear"></div>
        <div class="col-lg-5">CIN</div>
        <div class="col-lg-5"><input type="text" title="CIN is required" maxlength="21" style="text-transform: uppercase"  name="cin" id="cin" class="module-input"></div><span id="span_cin"></span>
        <div class="clear"></div>
        <div class="col-lg-5">Service Tax</div>
        <div class="col-lg-5"><input type="text" title="Service Tax is required" maxlength="15" style="text-transform: uppercase"  name="service_tax" id="service_tax" class="module-input"></div><span id="span_tax"></span>
        <div class="clear"></div>
        <div class="space10"></div>
        <h5 class="tab-form-head">Business Background</h5>
        <div class="col-lg-5">Select Industry Segment <span class="star">*</span></div>
        <div class="col-lg-5"><select name="industry_segment" title="Industry is required" id="industry_segment" class="module-select">
			<option value="">--select--</option>
			<option value="1">Steel</option>
			<option value="2">Construction</option>
			<option value="3">chemicals</option>
			<option value="4">Textile /Garment</option>
			<option value="5">Power generation, Transmission & Distribution</option>
			<option value="6">Financial services</option>
			<option value="7">Petrochemicals</option>
			<option value="8">Consumer durable goods</option>
			<option value="9">Food & Beverages</option>
			<option value="10">Hotels & Hospitality</option>
			<option value="11">Real estate</option>
			<option value="12">Restaurants & Catering</option>
			<option value="13">Soaps & Detergents</option>
			<option value="14">Personal care</option>
			<option value="15">Paints & Pigments</option>
			<option value="16">Consumer & Industrial electricals</option>
			<option value="17">Automobile & Auto component</option>
			<option value="18">Aviation</option>
			<option value="19">Shipping & Ports</option>
			<option value="20">Logistics & Transportation</option>
			<option value="21">Agri commodites & Agro processing</option>
			<option value="22">Packaging & Films</option>
			<option value="23">Media & Entertainment</option>
			<option value="24">Information technology hardware</option>
			<option value="25">Information technology software</option>
			<option value="26">BPO/KPO</option>
			<option value="27">Telecom</option>
			<option value="28">Retail</option>
			<option value="29">Infrastructure (roads, rail, airports )</option>
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('industry_segment'); ?></span>
		</div>
        <div class="clear"></div>
        <div class="col-lg-5">Date of Establishment <span class="star">*</span></div>
        <div class="col-lg-5"><input type="text" title="Date is required" name="date_of_establishment" id="date_of_establishment" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('date_of_establishment'); ?></span>
		</div>
        <div class="clear"></div>
        <div class="col-lg-5">Address of Factory Shop Line 1</div>
        <div class="col-lg-5"><input type="text" title="Address1 is required" maxlength="500" name="adress1" id="adress1" class="module-input"></div>
        <div class="clear"></div>
        <div class="col-lg-5">Address Line 2</div>
        <div class="col-lg-5"><input type="text" title="Address2 is required" maxlength="500" name="adress2" id="adress2" class="module-input"></div>
        <div class="clear"></div>
        <div class="col-lg-5">Business Activity</div>
        <div class="col-lg-5"><select title="Business Activity is required" name="existing_activity" id="existing_activity" class="module-select">
			<option value="">--select--</option>
			<option value="manufacturing">Manufacturing</option>		
			<option value="trading">Trading</option>		
			<option value="retail">Retail</option>		
			<option value="services">Services</option>		
			<option value="small business">Small business</option>		
			<option value="construction contractor">Construction contractor</option>		
		
		</select></div>
        <div class="clear"></div>
		<div class="invested_plant">
        <div class="col-lg-5">Amount invested in Plants &amp; Machinery</div>
        <div class="col-lg-5"><input type="text" onkeypress="return isNumberKey1(event)" title="Amount is required" maxlength="11" name="amount_invested_plant_machinery" id="amount_invested_plant_machinery" class="module-input" placeholder="&#8377; in Lacs"></div>
            <div class="col-lg-2">(&#8377; in Lacs)</div> 
        </div>
		<div class="clear"></div>
		<div class="invested_equipments">
        <div class="col-lg-5">Amount invested in Equipments</div>
        <div class="col-lg-5"><input type="text" onkeypress="return isNumberKey2(event)" title="Amount is required" maxlength="11" name="amount_invested_equipments" id="amount_invested_equipments" class="module-input" placeholder="&#8377; in Lacs"></div>
            <div class="col-lg-2">(&#8377; in Lacs)</div> 
        </div>
		<div class="clear"></div>
        <div class="col-lg-5" style="line-height:24px;">What is your geographical area of Operation/Sales</div>
        <div class="col-lg-5"><input type="text" title="Area is required" name="geographical_areas" id="geographical_areas" class="module-input" ></div>
        <div class="clear"></div>
        <div class="col-lg-5">No. of States you are operating</div>
        <div class="col-lg-5"><select name="no_of_operating_states" id="no_of_operating_states" class="module-select">
		<option value="">--select--</option>
		<option value="Single State">Single State</option>		
		<option value="Multi State">Multi State</option>
		
		</select></div>
        <div class="clear"></div>
        <div class="space10"></div>
        <h5 class="tab-form-head">Customer / Sales Details</h5>
        <div class="col-lg-5">No. of States you are operating</div>
        <div class="col-lg-12">
        <div class="col-lg-4"><label><input type="radio" name="are_you_sales" checked value="0">Domestic</label></div>
        <div class="col-lg-4"><label><input type="radio" name="are_you_sales" value="1">Export</label></div>
        <div class="col-lg-4"><label><input type="radio" name="are_you_sales" value="2">Both</label></div>
        </div>
        <div class="clear"></div>
        <div class="col-lg-5">Are you Sales?</div>
        <div class="col-lg-12">
        <div class="col-lg-4"><label><input type="radio" name="are_you_sales_a" checked value="0">Large Company</label></div>
        <div class="col-lg-4" style="/*line-height:22px;*/"><label><input type="radio" name="are_you_sales_a" value="1">Small Medium Enterprise</label></div>
        <div class="col-lg-4"><label><input type="radio" name="are_you_sales_a" value="2">Retail Customer</label></div>
        </div>
        <div class="clear"></div>
        <div class="col-lg-5">Key Products / Services Offered</div>
        <div class="col-lg-8"><textarea title="Key product is required" maxlength="500" name="key_products_services" id="key_products_services" class="module-text"></textarea></div>
		<div class="clear"></div>
		<input type="hidden" name="application_id" value="<?php echo $application_id;?>"
		<hr class="top-margin20 yellow-hr">
		
        <div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default">Save &amp; Continue</button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>
        </div>
      </div>
</form>
<?php } else { ?>

<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_enterprise_background" method="post">

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
        <h5 class="tab-form-head">KYC Details</h5>
        <div class="p100">
        <div class="col-lg-5">PAN <span class="star">*</span></div>
        <div class="col-lg-5"><input type="text" title="PAN is required" maxlength="10"  style="text-transform: uppercase" name="pan" id="pan" value="<?php echo $enterprise_background[0]->pan;?>" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pan'); ?></span>
		</div><span id="span_pan"></span>
        <div class="clear"></div>
        <div class="col-lg-5">VAT</div>
        <div class="col-lg-5"><input type="text" title="VAT is required"  maxlength="15" style="text-transform: uppercase"  name="vat" id="vat" value="<?php echo $enterprise_background[0]->vat;?>" class="module-input"></div><span id="span_vat"></span>
        <div class="clear"></div>
        <div class="col-lg-5">CIN</div>
        <div class="col-lg-5"><input type="text" title="CIN is required"  maxlength="21" style="text-transform: uppercase" onkeyup="fnValidateCIN(this);" name="cin" id="cin" value="<?php echo $enterprise_background[0]->cin;?>" class="module-input"></div><span id="span_cin"></span>
        <div class="clear"></div>
        <div class="col-lg-5">Service Tax</div>
        <div class="col-lg-5"><input type="text" title="Service tax is required" maxlength="15" style="text-transform: uppercase" onkeyup="fnValidateTAX(this);" name="service_tax" id="service_tax" value="<?php echo $enterprise_background[0]->service_tax;?>" class="module-input"></div><span id="span_tax"></span>
        <div class="clear"></div>
        <div class="space10"></div>
        <h5 class="tab-form-head">Business Background</h5>
        <div class="col-lg-5">Select Industry Segment <span class="star">*</span></div>
        <div class="col-lg-5"><select title="Industry is required" name="industry_segment" id="industry_segment" class="module-select">
		<option value="">--select--</option>		
		    <option value="1" <?php if($enterprise_background[0]->industry_segment=='1') { echo "selected"; }?>>Steel</option>
			<option value="2" <?php if($enterprise_background[0]->industry_segment=='2') { echo "selected"; }?>>Construction</option>
			<option value="3" <?php if($enterprise_background[0]->industry_segment=='3') { echo "selected"; }?>>Chemicals</option>
			<option value="4" <?php if($enterprise_background[0]->industry_segment=='4') { echo "selected"; }?>>Textile /Garment</option>
			<option value="5" <?php if($enterprise_background[0]->industry_segment=='5') { echo "selected"; }?>>Power generation, transmission & Distribution</option>
			<option value="6" <?php if($enterprise_background[0]->industry_segment=='6') { echo "selected"; }?>>Financial services</option>
			<option value="7" <?php if($enterprise_background[0]->industry_segment=='7') { echo "selected"; }?>>Petrochemicals</option>
			<option value="8" <?php if($enterprise_background[0]->industry_segment=='8') { echo "selected"; }?>>Consumer durable goods</option>
			<option value="9" <?php if($enterprise_background[0]->industry_segment=='9') { echo "selected"; }?>>Food & Beverages</option>
			<option value="10" <?php if($enterprise_background[0]->industry_segment=='10') { echo "selected"; }?>>Hotels & Hospitality</option>
			<option value="11" <?php if($enterprise_background[0]->industry_segment=='11') { echo "selected"; }?>>Real estate</option>
			<option value="12" <?php if($enterprise_background[0]->industry_segment=='12') { echo "selected"; }?>>Restaurants & Catering</option>
			<option value="13" <?php if($enterprise_background[0]->industry_segment=='"13') { echo "selected"; }?>>Soaps & Detergents</option>
			<option value="14"<?php if($enterprise_background[0]->industry_segment=='14') { echo "selected"; }?>>Personal care</option>
			<option value="15"<?php if($enterprise_background[0]->industry_segment=='15') { echo "selected"; }?>>Paints & Pigments</option>
			<option value="16" <?php if($enterprise_background[0]->industry_segment=='16') { echo "selected"; }?> >Consumer & Industrial electricals</option>
			<option value="17" <?php if($enterprise_background[0]->industry_segment=='17') { echo "selected"; }?>>Automobile & Auto component</option>
			<option value="18" <?php if($enterprise_background[0]->industry_segment=='18') { echo "selected"; }?>>Aviation</option>
			<option value="19" <?php if($enterprise_background[0]->industry_segment=='19') { echo "selected"; }?>>Shipping & Ports</option>
			<option value="20" <?php if($enterprise_background[0]->industry_segment=='20') { echo "selected"; }?>>Logistics & Transportation</option>
			<option value="21" <?php if($enterprise_background[0]->industry_segment=='21') { echo "selected"; }?>>Agri commodites & Agro processing</option>
			<option value="22" <?php if($enterprise_background[0]->industry_segment=='22') { echo "selected"; }?>>Packaging & Films</option>
			<option value="23" <?php if($enterprise_background[0]->industry_segment=='23') { echo "selected"; }?>>Media & Entertainment</option>
			<option value="24" <?php if($enterprise_background[0]->industry_segment=='24') { echo "selected"; }?>>Information technology hardware</option>
			<option value="25" <?php if($enterprise_background[0]->industry_segment=='25') { echo "selected"; }?>>Information technology software</option>
			<option value="26" <?php if($enterprise_background[0]->industry_segment=='26') { echo "selected"; }?>>BPO/KPO</option>
			<option value="27" <?php if($enterprise_background[0]->industry_segment=='27') { echo "selected"; }?>>Telecom</option>
			<option value="28" <?php if($enterprise_background[0]->industry_segment=='28') { echo "selected"; }?>>Retail</option>
			<option value="29" <?php if($enterprise_background[0]->industry_segment=='29') { echo "selected"; }?>>Infrastructure (roads, rail, airports )</option>
		
		
		</select>
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('industry_segment'); ?></span>
		</div>
        <div class="clear"></div>
        <div class="col-lg-5">Date of Establishment <span class="star">*</span></div>
        <div class="col-lg-5"><input type="text" title="Date is required" value="<?php echo date('d-m-Y',strtotime($enterprise_background[0]->date_of_establishment));?>" name="date_of_establishment" id="date_of_establishment" class="module-input">
		<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('date_of_establishment'); ?></span>
		</div>
        <div class="clear"></div>
        <div class="col-lg-5">Address of Factory Shop Line 1</div>
        <div class="col-lg-5"><input type="text" title="Address1 is required" maxlength="500" name="adress1" id="adress1" value="<?php echo $enterprise_background[0]->adress1;?>" class="module-input"></div>
        <div class="clear"></div>
        <div class="col-lg-5">Address Line 2</div>
        <div class="col-lg-5"><input type="text" title="Address2 is required" maxlength="500" name="adress2" id="adress2" value="<?php echo $enterprise_background[0]->adress2;?>" class="module-input"></div>
        <div class="clear"></div>
        <div class="col-lg-5">Business Activity</div>
        <div class="col-lg-5"><select title="Business activity is required" name="existing_activity" id="existing_activity" class="module-select">
			<option value="">--select--</option>			
			<option value="manufacturing" <?php if($enterprise_background[0]->existing_activity=='manufacturing') { echo "selected"; }?>>Manufacturing</option>		
			<option value="trading" <?php if($enterprise_background[0]->existing_activity=='trading') { echo "selected"; }?>>Trading</option>		
			<option value="retail" <?php if($enterprise_background[0]->existing_activity=='retail') { echo "selected"; }?>>Retail</option>		
			<option value="services" <?php if($enterprise_background[0]->existing_activity=='services') { echo "selected"; }?>>Services</option>		
			<option value="small business" <?php if($enterprise_background[0]->existing_activity=='small business') { echo "selected"; }?>>Small business</option>		
			<option value="construction contractor" <?php if($enterprise_background[0]->existing_activity=='construction contractor') { echo "selected"; }?>>Construction contractor</option>
		</select></div>
        <div class="clear"></div>
		
		<div class="invested_plant">
		<?php //if($enterprise_background[0]->existing_activity =="Manufacturing"){?>
        <div class="col-lg-5">Amount invested in Plants &amp; Machinery</div>
        <div class="col-lg-5"><input type="text" title="Amount is required" maxlength="11" name="amount_invested_plant_machinery" id="amount_invested_plant_machinery" value="<?php echo moneyFormatIndia($enterprise_background[0]->amount_invested_plant_machinery);?>" class="module-input" placeholder="&#8377; in Lacs"></div>
            <div class="col-lg-2">(&#8377; in Lacs)</div> 
        <?php //} ?>
		</div>
		
	   <div class="clear"></div>
	    <div class="invested_equipments">
		 <?php //if($enterprise_background[0]->existing_activity =="Service"){?>
        <div class="col-lg-5">Amount invested in Equipments</div>
        <div class="col-lg-5"><input type="text" title="Amount is required" maxlength="11" name="amount_invested_equipments" id="amount_invested_equipments" value="<?php echo moneyFormatIndia($enterprise_background[0]->amount_invested_equipments);?>" class="module-input" placeholder="&#8377; in Lacs"></div>
            <div class="col-lg-2">(&#8377; in Lacs)</div> 
	   <?php //} ?>
	   </div>
		
		<div class="clear"></div>
        <div class="col-lg-5" style="line-height:24px;">What is your geographical area of Operation/Sales</div>
        <div class="col-lg-5"><input type="text" title="Area product is required" name="geographical_areas" id="geographical_areas" value="<?php echo $enterprise_background[0]->geographical_areas;?>" class="module-input" ></div>
        <div class="clear"></div>
        <div class="col-lg-5">No. of States you are operating</div>
        <div class="col-lg-5"><select name="no_of_operating_states" id="no_of_operating_states" class="module-select">
		<option value="">--select--</option>
		<option value="Single State" <?php if($enterprise_background[0]->no_of_operating_states=='Single State') { echo "selected"; }?>>Single State</option>		
		<option value="Multi State" <?php if($enterprise_background[0]->no_of_operating_states=='Multi State') { echo "selected"; }?>>Multi State</option>		
		
		</select></div>
        <div class="clear"></div>
        <div class="space10"></div>
        <h5 class="tab-form-head">Customer / Sales Details</h5>
        <div class="col-lg-5">No. of States you are operating</div>
        <div class="col-lg-12">
        <div class="col-lg-4"><label><input type="radio" name="are_you_sales" <?php if($enterprise_background[0]->are_you_sales=='0') { echo "checked"; }?> value="0">Domestic</label></div>
        <div class="col-lg-4"><label><input type="radio" name="are_you_sales" <?php if($enterprise_background[0]->are_you_sales=='1') { echo "checked"; }?> value="1">Export</label></div>
        <div class="col-lg-4"><label><input type="radio" name="are_you_sales" <?php if($enterprise_background[0]->are_you_sales=='2') { echo "checked"; }?> value="2">Both</label></div>
        </div>
        <div class="clear"></div>
        <div class="col-lg-5">Are you Sales?</div>
        <div class="col-lg-12">
        <div class="col-lg-4"><label><input type="radio" name="are_you_sales_a" <?php if($enterprise_background[0]->are_you_sales_a=='0') { echo "checked"; }?> value="0">Large Company</label></div>
        <div class="col-lg-4" style="/*line-height:22px;*/"><label><input type="radio" name="are_you_sales_a" <?php if($enterprise_background[0]->are_you_sales_a=='1') { echo "checked"; }?> value="1">Small Medium Enterprise</label></div>
        <div class="col-lg-4"><label><input type="radio" name="are_you_sales_a" <?php if($enterprise_background[0]->are_you_sales_a=='2') { echo "checked"; }?> value="2">Retail Customer</label></div>
        </div>
        <div class="clear"></div>
        <div class="col-lg-5">Key Products / Services Offered</div>
        <div class="col-lg-8"><textarea title="Key product is required" maxlength="500" name="key_products_services" id="key_products_services" class="module-text"><?php echo $enterprise_background[0]->key_products_services; ?></textarea></div>
		<div class="clear"></div>
		<input type="hidden" name="application_id" value="<?php echo $application_id;?>" />
		<input type="hidden" name="flag" value="1"/>
		<hr class="top-margin20 yellow-hr">
		
        <!--<div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default">SAVE &amp; Continue</button></div>-->
        <div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default"><?php if($utype_id ==3 || $utype_id ==4 || $utype_id ==5){ echo "Next"; }else { echo "Save &amp; Continue";} ?></button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>
        </div>
      </div>
</form>


<?php } ?>