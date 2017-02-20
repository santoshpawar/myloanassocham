<script src="<?php echo base_url()?>assets/front/js/jquery-ui.js"></script>
<link href="<?php echo base_url()?>assets/front/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>

<script type="text/javascript" language="javascript">
var base_url="<?php echo base_url();?>";
$(document).ready(function(){

<?php if(($utype_id ==3 || $utype_id ==4 || $utype_id ==5) && (!empty($application_id) && !empty($owner_details))){?>
	$('input,textarea').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('readonly', true);
        $(this).removeClass('error');
				
	});

	$('select').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('disabled', true);
       
		
	});
	
	 $("#dob0").attr('disabled', true);
	 $("#dob1").attr('disabled', true);
	 $("#dob2").attr('disabled', true);
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
						'name[]': {
							required: true
						},
						'dob[]': {
							required: true
						},
						'father_name[]': {
							required: true
						},
						'academic_qualification[]': {
							required: true
						},
						'pan[]': {
							required: true
						},
						'residentail_address[]': {
							required: true
						},
						'state[]': {
							required: true
						},
						'pincode[]': {
							required: true
						},
						'adress_proof_type[]': {
							required: true
						},
						'address_proof_id[]': {
							required: true
						},
						'mobile_no[]': {
							required: true
						},
						'landline_no[]': {
							required: true
						},
						'exp_in_line_activity[]': {
							required: true
						},
						'souce_of_other_income[]': {
							required: true
						},
						'know_cibil_score[]': {
							required: true
						},
						 'cibil_score[]': {
							required: true
						}, 
						'cast[]': {
							required: true
						},
					
					}
				});	
				
				
				
				$('#pincode0,#pincode1,#pincode2,#mobile_no0,#mobile_no1,#mobile_no2,#landline_no0,#landline_no1,#landline_no2,#cibil_score0,#cibil_score1,#cibil_score2').on('keyup blur input',function(){	
				var name=$(this).val();
				name=name.replace(/[^0-9]+/g, '');
				$(this).val(name);
				});
				
				$('#name0,#name1,#name2,#father_name0,#father_name1,#father_name2').on('keyup blur input',function(){	
					var name=$(this).val();
					name=name.replace(/[^a-zA-Z ]+/g, '');
					$(this).val(name);
				});
				
				var i = 0;
				$(".know_cibil").each(function() {
						
						var  know_cibil_score = $("#know_cibil_score"+i).val();
						//alert(know_cibil_score);
						i++;

					  if(know_cibil_score == "Yes")
					  {
						  $(".cibil"+i).html("");
						 
					  }
					 /*  if(know_cibil_score == "")
					  {
						  $("#invested_plant").html('<div class="col-lg-4">Amount invested in Plants &amp; Machinery</div><div class="col-lg-5"><input type="text" name="amount_invested_plant_machinery" id="amount_invested_plant_machinery1" value="" class="module-input" placeholder="Rs. in Lacs"></div>');
						  $("#invested_equipments").html("");
					  }
					  if(know_cibil_score == "")
					  {
						  $("#invested_equipments").html('<div class="col-lg-4">Amount invested in Equipments</div><div class="col-lg-5"><input type="text" name="amount_invested_equipments" id="amount_invested_equipments1" value="" class="module-input" placeholder="Rs. in Lacs"></div>');
						  $("#invested_plant").html("");
					  }  */
				});
				
				
			
			 $('select').each(function(e){
				var namefld=$(this).attr('name');
				var i=0;
				if(namefld.match('know_cibil_score') && namefld.length==18){
					$(this).addClass('knowCibilScore');
				}
				if(namefld.match('cast') && namefld.length==6){
					$(this).addClass('castfld');
				}
			});	 
			$('.knowCibilScore').change(function(){
				if($(this).val()=='Y'){
					$(this).parent('td').parent('tr').next('tr').find('input').removeAttr('disabled').removeClass('disappeared');
				}
				else{
					$(this).parent('td').parent('tr').next('tr').find('input').attr('disabled','disabled').addClass('disappeared');					
				}
			});
			
			$('.knowCibilScore').each(function(){
				if($(this).val()=='Y'){
					$(this).parent('td').parent('tr').next('tr').find('input').removeAttr('disabled').removeClass('disappeared');
					
				}
				else{
					$(this).parent('td').parent('tr').next('tr').find('input').attr('disabled','disabled').addClass('disappeared');					
				}
			});

			 $('.castfld').change(function(){
				if($(this).val()=='Yes'){
					$(this).parent('td').parent('tr').next('tr').find('input').removeAttr('disabled').removeClass('disappeared');
					$(this).parent('td').parent('tr').next('tr').find('label').removeClass('invisible');
				}
				else{
					$(this).parent('td').parent('tr').next('tr').find('input').attr('disabled','disabled').addClass('disappeared');		
					$(this).parent('td').parent('tr').next('tr').find('label').addClass('invisible');	
				}
			});
			$('.castfld').each(function(){
				if($(this).val()=='Yes'){
					$(this).parent('td').parent('tr').next('tr').find('input').removeAttr('disabled').removeClass('disappeared');
					$(this).parent('td').parent('tr').next('tr').find('label').removeClass('invisible');
				}
				else{
					$(this).parent('td').parent('tr').next('tr').find('input').attr('disabled','disabled').addClass('disappeared');		
					$(this).parent('td').parent('tr').next('tr').find('label').addClass('invisible');	
				}
			});	

			
			
			/* $(".owner_det1").each(function () {
				$(this).on('keyup blur input',function(){	
					//alert("adsad");
					$("#submit").prop("disabled", CheckInputs());
				});
			}); */
			//var totalElements1 = $('.owner_det1').length;
			//alert(totalElements1);
			 $('.owner_det1').on('change input blur',function(){
				//alert($(this).val());
				 //keyup input
				 var totalElements1=0;
				if($(this).val() != ""){
					$(this).removeClass("owner_det1");
					totalElements1 = $(this).parent('td').parent('tr').parent('tbody').find('.owner_det1:not(:disabled)').length;
				 }else{
					$(this).addClass("owner_det1");
					totalElements1 = $(this).parent('td').parent('tr').parent('tbody').find('.owner_det1:not(:disabled)').length;
				 }
					 
					 //alert($(this).val());
					//alert(totalElements1);	
					console.log(totalElements1);					
					if(totalElements1==0 || totalElements1==16)
					{
						var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
						if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1').length>0){
							$(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1:not(.disappeared)').removeAttr('disabled');
						}
						$("#submit_btn").removeAttr('disabled','disabled');
						// $(".owner_det2").attr("readonly", false);
						
					}else{
						var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
						if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1').length>0){
							$(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1').attr('disabled','disabled');
						}
						 $("#submit_btn").attr('disabled','disabled');
						 // $(".owner_det2").attr("readonly", true);
					}
					
					var cibil_score1 = $('#cibil_score1').val();
					//alert(cibil_score1);
					
				});
				
				
			
		
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
	  var dateToday = new Date();
	  var yrRange = '1950' + ":" + (dateToday.getFullYear() - 18).toString();
		
		//alert(n);
    $( "#dob0,#dob1,#dob2,#dob" ).datepicker({

					dateFormat: 'yy-mm-dd',
					changeMonth: true,
					changeYear: true,
					yearRange: yrRange
				});
  }); 
</script>
<style>
span.requirederror{
	puser_detailsding-left:5px;
}

.errorClass { border:  2px solid blue; }

</style>


<?php if(!empty($application_id) && empty($owner_details)) {?>

<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_owner_details" method="post">
<?php
if($this->session->userdata('error_message')){ ?>
	<script>
		$(document).ready(function(){
			//$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='search_error' style='color:#1797a2; padding-left:50px;'><strong>Data has been saved.</strong></span>";
	$this->session->set_userdata('error_message','');
	} ?>
<div class="content-wrapper select">
        <div class="clear"></div>
        <h5 class="tab-form-head">Owner Director KYC Details</h5>
        <div class="p100 horizontal-scroll">

		<table class="table mixed" style="margin-bottom:0px;">
        <tbody>
        	<tr>
        		<td style="width:300px;">
                <table class="table sbitem" style="width:300px;">
                <tbody>
                <tr><td>Name</td></tr>
                <tr><td>DOB</td> </tr>
                <tr><td>Father/Spouse Name</td></tr>
                <tr><td>Academic Qualification</td></tr>
                <tr><td>PAN of the Promoter</td></tr>
                <tr><td style="height:95px;">Residential Address</td></tr>
                <tr><td>State</td></tr>
                <tr><td>Pincode</td></tr>
                <tr><td>Address Proof Type</td></tr>
                <tr><td>Address Proof ID</td></tr>
                <tr><td>Mobile No.</td></tr>
                <tr><td>Landline No.</td></tr>
                <tr><td>Experience in Line of Activity</td></tr>
                <tr><td>Does owner have other source of income</td></tr>
                <tr><td>Do you know your CIBIL Score</td></tr>
                <tr><td>Provide your CIBIL Score</td></tr>
                <tr><td>Whether belong to SC/ST/Minority</td></tr>
                <tr><td>Please Specify</td></tr>
                </tbody>
                </table>
                </td>
                <!--Use the below td for Add More function-->
				<?php //$rem = 3 - count($owner_details); ?>
				<?php for($i=0;$i<3;$i++){ ?>
        		<td style="width:250px;">
                <table class="table sbitem">
                	<tbody>
                    <tr><td>
					<input type="text" name="name[]" id="name<?php echo $i; ?>" value="" class="module-input owner_det1">
					</td></tr>
					
                    <tr><td><input type="text" name="dob[]" id="dob<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><input type="text" name="father_name[]" id="father_name<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><input type="text" name="academic_qualification[]" id="academic_qualification<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><input type="text" maxlength="10" name="pan[]" id="pan<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><textarea name="residentail_address[]" id="residentail_address<?php echo $i; ?>" class="module-text owner_det1" style="height:85px; line-height:25px;"></textarea></td></tr>
                    <tr><td><select name="state[]" id="state<?php echo $i; ?>" class="module-select owner_det1">
					<option value="">--select--</option>
					<?php 
						foreach($state as $k=>$st){ ?>
							<option value="<?php echo $st->id; ?>" ><?php echo $st->name; ?> </option>
						<?php } ?>
					</select></td></tr>
                    <tr><td><input type="text" maxlength="6" name="pincode[]" id="pincode<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><select name="adress_proof_type[]" id="adress_proof_type<?php echo $i; ?>"  class="module-select owner_det1">
					<option value="">--select--</option>
					
					<option value="Electricity Bill" >Electricity Bill</option>		
					<option value="Telephone Bill" >Telephone Bill</option>		
					<option value="Bank Account statement" >Bank Account statement</option>		
					<option value="Letter from reputer Employer" >Letter from reputer Employer</option>		
					<option value="Letter from recognized Public authority" >Letter from recognized Public authority</option>		
					<option value="Aadhar Card" >Aadhar Card</option>		
					<option value="Ration card" >Ration card</option>	
					
					</select></td></tr>
                    <tr><td><input type="text" name="address_proof_id[]" id="address_proof_id<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><input type="text" maxlength="10" name="mobile_no[]" id="mobile_no<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><input type="text" maxlength="11" name="landline_no[]" id="landline_no<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><input type="text" name="exp_in_line_activity[]" id="exp_in_line_activity<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><input type="text" name="souce_of_other_income[]" id="souce_of_other_income<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><select name="know_cibil_score[]" id="know_cibil_score<?php echo $i; ?>" class="module-select know_cibil owner_det1">
					<option value="">--select--</option>
					
					<option value="Y" >Yes</option>		
					<option value="N" >No</option>
					
					</select></td></tr>
					

                    <tr><td><input type="text" name="cibil_score[]" id="cibil_score<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    
					
					<tr><td><select name="cast[]" id="cast<?php echo $i; ?>" class="module-select owner_det1">
					<option value="">--select--</option>
					<option value="Yes" >Yes</option>
					<option value="No" >No</option>
					
					</select></td></tr>
                    <tr><td style="line-height:20px;">
                     <label class="radio-inline"><input type="radio" checked value="0" name="please_specify[<?php echo $i; ?>]" id="please_specify<?php echo $i; ?>" >SC</label>
					 <label class="radio-inline"><input type="radio" value="1" name="please_specify[<?php echo $i; ?>]" id="please_specify<?php echo $i; ?>" >ST</label>
					 <label class="radio-inline"><input type="radio" value="2" name="please_specify[<?php echo $i; ?>]" id="please_specify<?php echo $i; ?>" >Minority</label> 
                    </td></tr>
                    </tbody>
                </table>
                </td>
				<?php } ?>
				<td><button type="button" class="yellow-button top-margin10" style="width:150px;"><span class="big-text">Add More</span> &nbsp;&nbsp;<i class="fa fa-plus-circle" aria-hidden="true"></i>
</button></td>
        	</tr>
        </tbody>
        </table>
		<div class="clear"></div>
		<input type="hidden" name="application_id" value="<?php echo $application_id;?>"/>
		<input type="hidden" name="flag" value="1" />
		<hr class="yellow-hr">
        <div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default">Save &amp; Continue</button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>


        </div>
      </div>
</form>
<?php } else { ?>

<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_owner_details" method="post">
<!--<form class="agencyappviewform" id="hold_frm" action="javascript:void(0)" method="post">-->
<div class="content-wrapper select">
        <div class="clear"></div>
        <h5 class="tab-form-head">Owner Director KYC Details</h5>
        <div class="p100 horizontal-scroll">

		<table class="table mixed" style="margin-bottom:0px;">
        <tbody>
        	<tr>
        		<td style="width:300px;">
                <table class="table sbitem" style="width:300px;">
                <tbody>
                <tr><td>Name</td></tr>
                <tr><td>DOB</td> </tr>
                <tr><td>Father/Spouse Name</td></tr>
                <tr><td>Academic Qualification</td></tr>
                <tr><td>PAN of the Promoter</td></tr>
                <tr><td style="height:95px;">Residential Address</td></tr>
                <tr><td>State</td></tr>
                <tr><td>Pincode</td></tr>
                <tr><td>Address Proof Type</td></tr>
                <tr><td>Address Proof ID</td></tr>
                <tr><td>Mobile No.</td></tr>
                <tr><td>Landline No.</td></tr>
                <tr><td>Experience in Line of Activity</td></tr>
                <tr><td>Does owner have other source of income</td></tr>
                <tr><td>Do you know your CIBIL Score</td></tr>
                <tr><td>Provide your CIBIL Score</td></tr>
                <tr><td>Whether belong to SC/ST/Minority</td></tr>
                <tr><td>Please Specify</td></tr>
                </tbody>
                </table>
                </td>
                <!--Use the below td for Add More function-->
				<?php $rem = 3 - count($owner_details); ?>
				<?php for($i=0;$i<count($owner_details);$i++){ ?>
        		<td style="width:250px;">
                <table class="table sbitem">
                	<tbody>
                    <tr><td>
					<input type="text" name="name[]" id="name<?php echo $i; ?>" value="<?php echo $owner_details[$i]->name;?>" class="module-input owner_det<?php echo $i; ?>">
					</td></tr>
					
                    <tr><td><input type="text" name="dob[]" id="dob<?php echo $i; ?>" value="<?php echo $owner_details[$i]->dob;?>" class="module-input owner_det<?php echo $i; ?>"></td></tr>
                    <tr><td><input type="text" name="father_name[]" id="father_name<?php echo $i; ?>" value="<?php echo $owner_details[$i]->father_name;?>" class="module-input owner_det<?php echo $i; ?>"></td></tr>
                    <tr><td><input type="text" name="academic_qualification[]" id="academic_qualification<?php echo $i; ?>" value="<?php echo $owner_details[$i]->academic_qualification;?>" class="module-input owner_det<?php echo $i; ?>"></td></tr>
                    <tr><td><input type="text" maxlength="10" name="pan[]" id="pan<?php echo $i; ?>" value="<?php echo $owner_details[$i]->pan;?>" class="module-input owner_det<?php echo $i; ?>"></td></tr>
                    <tr><td><textarea name="residentail_address[]" id="residentail_address<?php echo $i; ?>" class="module-text owner_det<?php echo $i; ?>" style="height:85px; line-height:25px;"><?php echo $owner_details[$i]->residentail_address;?></textarea></td></tr>
                    <tr><td><select name="state[]" id="state<?php echo $i; ?>" class="module-select owner_det<?php echo $i; ?>">
					<?php 
						foreach($state as $k=>$st){ ?>
							<option value="<?php echo $st->id; ?>" <?php if($st->id==$owner_details[$i]->state){ echo "selected"; }  ?>><?php echo $st->name; ?> </option>
						<?php } ?>
					</select></td></tr>
                    <tr><td><input type="text" maxlength="6" name="pincode[]" id="pincode<?php echo $i; ?>" value="<?php echo $owner_details[$i]->pincode;?>" class="module-input owner_det<?php echo $i; ?>"></td></tr>
                    <tr><td><select name="adress_proof_type[]" id="adress_proof_type<?php echo $i; ?>"  class="module-select owner_det<?php echo $i; ?>">
					<option value="">--select--</option>
					
					<option value="Electricity Bill" <?php if($owner_details[$i]->adress_proof_type=='Electricity Bill') { echo "selected"; }?>>Electricity Bill</option>		
					<option value="Telephone Bill" <?php if($owner_details[$i]->adress_proof_type=='Telephone Bill') { echo "selected"; }?>>Telephone Bill</option>		
					<option value="Bank Account statement" <?php if($owner_details[$i]->adress_proof_type=='Bank Account statement') { echo "selected"; }?>>Bank Account statement</option>		
					<option value="Letter from reputer Employer" <?php if($owner_details[$i]->adress_proof_type=='Letter from reputer Employer') { echo "selected"; }?>>Letter from reputer Employer</option>		
					<option value="Letter from recognized Public authority" <?php if($owner_details[$i]->adress_proof_type=='Letter from recognized Public authority') { echo "selected"; }?>>Letter from recognized Public authority</option>		
					<option value="Aadhar Card" <?php if($owner_details[$i]->adress_proof_type=='Aadhar Card') { echo "selected"; }?>>Aadhar Card</option>		
					<option value="Ration card" <?php if($owner_details[$i]->adress_proof_type=='Ration card') { echo "selected"; }?>>Ration card</option>	
					
					</select></td></tr>
                    <tr><td><input type="text" name="address_proof_id[]" id="address_proof_id<?php echo $i; ?>" value="<?php echo $owner_details[$i]->address_proof_id;?>" class="module-input owner_det<?php echo $i; ?>"></td></tr>
                    <tr><td><input type="text" maxlength="10" name="mobile_no[]" id="mobile_no<?php echo $i; ?>" value="<?php echo $owner_details[$i]->mobile_no;?>" class="module-input owner_det<?php echo $i; ?>"></td></tr>
                    <tr><td><input type="text" maxlength="11" name="landline_no[]" id="landline_no<?php echo $i; ?>" value="<?php echo $owner_details[$i]->landline_no;?>" class="module-input owner_det<?php echo $i; ?>"></td></tr>
                    <tr><td><input type="text" name="exp_in_line_activity[]" id="exp_in_line_activity<?php echo $i; ?>" value="<?php echo $owner_details[$i]->exp_in_line_activity;?>" class="module-input owner_det<?php echo $i; ?>"></td></tr>
                    <tr><td><input type="text" name="souce_of_other_income[]" id="souce_of_other_income<?php echo $i; ?>" value="<?php echo $owner_details[$i]->souce_of_other_income;?>" class="module-input owner_det<?php echo $i; ?>"></td></tr>
                    <tr><td><select name="know_cibil_score[]" id="know_cibil_score<?php echo $i; ?>" class="module-select know_cibil owner_det<?php echo $i; ?>">
					<option value="">--select--</option>
					
					<option value="Y" <?php if($owner_details[$i]->know_cibil_score=='Y') { echo "selected"; }?>>Yes</option>		
					<option value="N" <?php if($owner_details[$i]->know_cibil_score=='N') { echo "selected"; }?>>No</option>
					
					</select></td></tr>
					
					<?php //if($owner_details[$i]->know_cibil_score=='Yes') { ?>
					<div class="cibil<?php echo $i; ?>">
                    <tr><td><input type="text" name="cibil_score[]" id="cibil_score<?php echo $i; ?>" value="<?php echo $owner_details[$i]->cibil_score;?>" class="module-input"></td></tr>
                    </div>
					<?php //} ?>
					
					<tr><td><select name="cast[]" id="cast<?php echo $i; ?>" class="module-select owner_det<?php echo $i; ?>">
					<option value="">--select--</option>
					<option value="Yes" <?php if($owner_details[$i]->cast=='Yes') { echo "selected"; }?>>Yes</option>
					<option value="No" <?php if($owner_details[$i]->cast=='No') { echo "selected"; }?>>No</option>
					</select></td></tr>
					
					<?php //if($owner_details[$i]->cast=='Yes') {?>
                    <tr><td style="line-height:20px;">
                     <label class="radio-inline"><input type="radio" value="0" checked name="please_specify[<?php echo $i; ?>]" id="please_specify<?php echo $i; ?>" <?php if($owner_details[$i]->please_specify=='0') { echo "checked"; }?>>SC</label>
					 <label class="radio-inline"><input type="radio" value="1" name="please_specify[<?php echo $i; ?>]" id="please_specify<?php echo $i; ?>" <?php if($owner_details[$i]->please_specify=='1') { echo "checked"; }?>>ST</label>
					 <label class="radio-inline"><input type="radio" value="2" name="please_specify[<?php echo $i; ?>]" id="please_specify<?php echo $i; ?>" <?php if($owner_details[$i]->please_specify=='2') { echo "checked"; }?>>Minority</label> 
                    </td></tr>
					<?php //} ?>
					
                    </tbody>
                </table>
                </td>
				<?php } ?>
				<?php if($rem == 1 ) { 
					 $j = 2;  
					 $rem = 3;
					}else { 
					$j = 1;
					$rem = 3;
				}?>
				
				<?php for($i=$j;$i<$rem;$i++){ ?>
				
				<td style="width:250px;">
                <table class="table sbitem">
                	<tbody>
                    <tr><td>
					<input type="text" name="name[]" id="name<?php echo $i; ?>" value="" class="module-input owner_det1">
					</td></tr>
					
                    <tr><td><input type="text" name="dob[]" id="dob<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><input type="text" name="father_name[]" id="father_name<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><input type="text" name="academic_qualification[]" id="academic_qualification<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><input type="text" maxlength="10" name="pan[]" id="pan<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><textarea name="residentail_address[]" id="residentail_address<?php echo $i; ?>" class="module-text owner_det1" style="height:85px; line-height:25px;"></textarea></td></tr>
                    <tr><td><select name="state[]" id="state<?php echo $i; ?>" class="module-select owner_det1">
					<option value="">--select--</option>
					<?php 
						foreach($state as $k=>$st){ ?>
							<option value="<?php echo $st->id; ?>" ><?php echo $st->name; ?> </option>
						<?php } ?>
					</select></td></tr>
                    <tr><td><input type="text" maxlength="6" name="pincode[]" id="pincode<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><select name="adress_proof_type[]" id="adress_proof_type<?php echo $i; ?>"  class="module-select owner_det1">
					<option value="">--select--</option>
					<option value="Electricity Bill">Electricity Bill</option>		
					<option value="Telephone Bill">Telephone Bill</option>		
					<option value="Bank Account statement">Bank Account statement</option>		
					<option value="Letter from reputer Employer">Letter from reputer Employer</option>		
					<option value="Letter from recognized Public authority">Letter from recognized Public authority</option>		
					<option value="Aadhar Card">Aadhar Card</option>		
					<option value="Ration card">Ration card</option>
					</select></td></tr>
                    <tr><td><input type="text" name="address_proof_id[]" id="address_proof_id<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><input type="text" maxlength="10" name="mobile_no[]" id="mobile_no<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><input type="text" maxlength="11" name="landline_no[]" id="landline_no<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><input type="text" name="exp_in_line_activity[]" id="exp_in_line_activity<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><input type="text" name="souce_of_other_income[]" id="souce_of_other_income<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    <tr><td><select name="know_cibil_score[]" id="know_cibil_score<?php echo $i; ?>" class="module-select know_cibil owner_det1">
					<option value="">--select--</option>
					<option value="Y">Yes</option>		
					<option value="N">No</option>
					</select></td></tr>
					
					<div class="cibil<?php echo $i; ?>">
                    <tr><td><input type="text" name="cibil_score[]" id="cibil_score<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr>
                    </div>
					
					<tr><td><select name="cast[]" id="cast<?php echo $i; ?>" class="module-select owner_det1">
					<option value="">--select--</option>
					<option value="Yes">Yes</option>
					<option value="No">No</option>
					</select></td></tr>
                    <tr><td style="line-height:20px;">
                     <label class="radio-inline"><input type="radio" checked value="0" name="please_specify[<?php echo $i; ?>]" id="please_specify<?php echo $i; ?>" >SC</label>
					 <label class="radio-inline"><input type="radio" value="1" name="please_specify[<?php echo $i; ?>]" id="please_specify<?php echo $i; ?>" >ST</label>
					 <label class="radio-inline"><input type="radio" value="2" name="please_specify[<?php echo $i; ?>]" id="please_specify<?php echo $i; ?>" >Minority</label> 
                    </td></tr>
                    </tbody>
                </table>
                </td>
				
				<?php } ?>
				
        		<!--<td style="width:250px;">
                <table class="table">
                	<tbody>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><textarea name="" id="" class="module-text" style="height:85px; line-height:25px;"></textarea></td></tr>
                    <tr><td><select name="" id="" class="module-select"></select></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><select name="" id="" class="module-select"></select></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><select name="" id="" class="module-select"></select></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><select name="" id="" class="module-select"></select></td></tr>
                    <tr><td style="line-height:20px;">
                     <label class="radio-inline"><input type="radio" name="optradio">SC</label>
					 <label class="radio-inline"><input type="radio" name="optradio">ST</label>
					 <label class="radio-inline"><input type="radio" name="optradio">Minority</label> 
                    </td></tr>
                    </tbody>
                </table>
                </td>
        		<td style="width:250px;">
                <table class="table">
                	<tbody>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><textarea name="" id="" class="module-text" style="height:85px; line-height:25px;"></textarea></td></tr>
                    <tr><td><select name="" id="" class="module-select"></select></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><select name="" id="" class="module-select"></select></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><select name="" id="" class="module-select"></select></td></tr>
                    <tr><td><input type="text" name="" id="" class="module-input"></td></tr>
                    <tr><td><select name="" id="" class="module-select"></select></td></tr>
                    <tr><td style="line-height:20px;">
                     <label class="radio-inline"><input type="radio" name="optradio">SC</label>
					 <label class="radio-inline"><input type="radio" name="optradio">ST</label>
					 <label class="radio-inline"><input type="radio" name="optradio">Minority</label> 
                    </td></tr>
                    </tbody>
                </table>
                </td>-->
				<td><button type="button" class="yellow-button top-margin10" style="width:150px;"><span class="big-text">Add More</span> &nbsp;&nbsp;<i class="fa fa-plus-circle" aria-hidden="true"></i>
</button></td>
        	</tr>
        </tbody>
        </table>
		<div class="clear"></div>
		<input type="hidden" name="application_id" value="<?php echo $application_id;?>"/>
		<input type="hidden" name="flag" value="1" />
		<hr class="yellow-hr">
        <div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default"><?php if($utype_id ==3 || $utype_id ==4 || $utype_id ==5){ echo "Next"; }else { echo "Save &amp; Continue";} ?></button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>


        </div>
      </div>
</form>

<?php } ?>