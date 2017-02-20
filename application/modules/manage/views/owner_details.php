<script src="<?php echo base_url()?>assets/front/js/jquery-ui.js"></script>
<link href="<?php echo base_url()?>assets/front/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>

<script type="text/javascript" language="javascript">
var base_url="<?php echo base_url();?>";
$(document).ready(function(){

<?php if(validation_errors() =="") {?>
$(".requirederror").css("display","none");
<?php } ?>

<?php if(($utype_id ==3 || $utype_id ==4 || $utype_id ==5) && (!empty($application_id) && !empty($owner_details))){?>
	$('input,textarea').each(function() { 
        //$(this).attr('disabled', true);
        $(this).attr('readonly', true);
        //$(this).removeClass('error');
				
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
	
	 $("#dob0").attr('disabled', true);
	 $("#dob1").attr('disabled', true);
	 $("#dob2").attr('disabled', true);
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
	$('#add_more').hide();
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
						'name[]': {
							required: true
						},
						'dob[]': {
							required: true
						},
						'pan[]': {
							required: true
						},
						/* 'father_name[]': {
							required: true
						},
						'academic_qualification[]': {
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
						}, */
						'adress_proof_type[]': {
							required: true
						},
						'address_proof_id[]': {
							required: true
						},
						'mobile_no[]': {
							required: true
						},
						/* 'landline_no[]': {
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
						}, */
					
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
				if($(this).val() == ""){
					$(this).removeClass("owner_det1");
					totalElements1 = $(this).parent('td').parent('tr').parent('tbody').find('.owner_det1:not(:disabled)').length;
				 }else{
					$(this).addClass("owner_det1");
					totalElements1 = $(this).parent('td').parent('tr').parent('tbody').find('.owner_det1:not(:disabled)').length;
				 }
					 
					 //alert($(this).val());
					//alert(totalElements1);	
					console.log(totalElements1);					
					if(totalElements1==0 || totalElements1==16 || totalElements1 ==17)
					{
						var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
						if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1').length>0){
							$(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1:not(.disappeared)').removeAttr('disabled');
						}
						$("#submit_btn").removeAttr('disabled','disabled');
						// $(".owner_det2").attr("readonly", false);
						$(".pull-right").removeAttr('disabled','disabled');
						
					}else{
						var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
						if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1').length>0){
							$(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1').attr('disabled','disabled');
						}
						 $("#submit_btn").attr('disabled','disabled');
						 // $(".owner_det2").attr("readonly", true);
						 $(".pull-right").attr('disabled','disabled');
					}
					
					var cibil_score1 = $('#cibil_score1').val();
					//alert(cibil_score1);
					
				});
				
		
		$(".owner_mob").on('keyup input blur',function(){
			//alert("dddd");
				    var id = $(this).attr("id");
					//alert(id);
					var name=$('#'+id).val();
					name=name.replace(/[^0-9]+/g, '');
					$(this).val(name);

				
					//var mob_no = $('#'+id).val().length;
					var mob_no = $(this).val().length;
					//alert(mob_no);
					if(mob_no ==0){
						$(this).parent('td').parent('tr').next('tr').find('span').html("");
					}else{
						if(mob_no < 10 )
						 {
							  $(this).parent('td').parent('tr').next('tr').find('span').html("Enter 10 digits mobile no.");
							  //$("#submit_btn").attr('disabled','disabled');
						 }else{
							 //alert("asds");
							  $(this).parent('td').parent('tr').next('tr').find('span').html("");
							  //$("#submit_btn").removeAttr('disabled','disabled');
						 } 
						
					}
				
				
			});
			
			
			$(".owner_pincode").on('keyup input blur',function(){
			//alert("dddd");
				    var id = $(this).attr("id");
					//alert(id);
					var name=$('#'+id).val();
					name=name.replace(/[^0-9]+/g, '');
					$(this).val(name);

				
					var pincode = $(this).val().length;
					//alert(mob_no3);
					if(pincode ==0){
						$(this).parent('td').parent('tr').next('tr').find('span').html("");
					}else{
						if(pincode < 6 )
						 {
							  $(this).parent('td').parent('tr').next('tr').find('span').html("Enter 6 digits pincode.");
							  //$("#submit_btn").attr('disabled','disabled');
						 }else{
							 //alert("asds");
							  $(this).parent('td').parent('tr').next('tr').find('span').html("");
							  //$("#submit_btn").removeAttr('disabled','disabled');
						 } 
						
					}
					
				
			});
			
			$(".owner_landline").on('keyup input blur',function(){
			//alert("dddd");
				    var id = $(this).attr("id");
					//alert(id);
					var name=$('#'+id).val();
					name=name.replace(/[^0-9]+/g, '');
					$(this).val(name);

				
					var landline = $(this).val().length;
					//alert(mob_no3);
					if(landline ==0){
						$(this).parent('td').parent('tr').next('tr').find('span').html("");
					}else{
						if(landline < 11 )
						 {
							  $(this).parent('td').parent('tr').next('tr').find('span').html("Enter 11 digits landline no.");
							  //$("#submit_btn").attr('disabled','disabled');
						 }else{
							 //alert("asds");
							  $(this).parent('td').parent('tr').next('tr').find('span').html("");
							  //$("#submit_btn").removeAttr('disabled','disabled');
						 } 
						
					}
					
				
			});
			
			$(".add_pan").on('keyup input blur',function(){
			//alert("dddd");
				    var id = $(this).attr("id");
					var ObjVal = $(this).val();
					var panPat = "^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$";
					/* var code = /([C,P,H,F,A,T,B,L,J,G])/;
					var code_chk = ObjVal.substring(3,4); */
					if(ObjVal !="")
					{
					if (ObjVal.search(panPat) == -1 || ObjVal < 10)
						{
							$(this).parent('td').parent('tr').next('tr').find('span').html("Invalid PAN no.");
						}else{
							$(this).parent('td').parent('tr').next('tr').find('span').html("");
						}
					}else{
						$(this).parent('td').parent('tr').next('tr').find('span').html("");
					}						
					
					
				
			});
				
				
				
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
	  var dateToday = new Date();
	  //var yrRange = '1900' + ":" + (dateToday.getFullYear() - 10).toString();
	 
	  
		//alert(n);
    $( "#dob0,#dob1,#dob2,#dob" ).datepicker({

					dateFormat: 'dd-mm-yy',
					changeMonth: true,
					changeYear: true,
					showMonthAfterYear:true,
					//yearRange: yrRange
					//minDate:"01-01-1900",
					maxDate: "-10Y", 
					//yearRange: '1900:' + (new Date().getFullYear()-10).toString()
					yearRange: '1900:' + new Date().getFullYear().toString()
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
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='search_error' class='alert alert-success alrt_md'><strong>Data has been saved.</strong></span>";
	$this->session->set_userdata('error_message','');
	} ?>
<div class="content-wrapper select" id="ownerdetlstbl_content">
        <div class="clear"></div>
        <h5 class="tab-form-head">Owner/Director KYC Details</h5>
    
    <button type="button" id="add_more" class="yellow-button top-margin10 ylw pull-right" style="width:150px;" onclick="addOwnview()"><span class="big-text small-txt_p">Add More</span> &nbsp;&nbsp;<i class="fa fa-plus-circle" aria-hidden="true"></i>
    </button>
        <div class="p100">
            <div class="owntlmxd">
				<div class="horizontal-scroll">    
			<table class="table mixed" style="margin-bottom:0px;">
        <tbody>
        	<tr class="tds_own">
        		<td style="width:300px;">
                <table class="table sbitem" style="width:300px;">
                <tbody>
                <tr><td>Name <span class="star">*</span></td></tr>
                <tr><td>DOB <span class="star">*</span></td> </tr>
                <tr><td>Father/Spouse Name</td></tr>
                <tr><td>Academic Qualification</td></tr>
                <tr><td>PAN of the Promoter <span class="star">*</span></td></tr>
                <tr><td style="height:95px;">Residential Address</td></tr>
                <tr><td>State</td></tr>
                <tr><td>Pincode</td></tr>
                <tr><td>Address Proof Type <span class="star">*</span></td></tr>
                <tr><td>Address Proof ID <span class="star">*</span></td></tr>
                <tr><td>Mobile No. <span class="star">*</span></td></tr>
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
				<?php for($i=0;$i<1;$i++){ ?>
        		<td style="width:250px;">
                <table class="table sbitem" style="width:300px;">
                	<tbody>
                    <tr><td>
					<input type="text" maxlength="50" name="name[]" id="name<?php echo $i; ?>" value="" class="module-input">
					<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('name[]'); ?></span>
					</td>
					</tr>
					
                    <tr><td><input type="text" name="dob[]" id="dob<?php echo $i; ?>" value="" class="module-input">
					<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('dob[]'); ?></span>
					</td></tr>
                    <tr><td><input type="text" maxlength="50" name="father_name[]" id="father_name<?php echo $i; ?>" value="" class="module-input"></td></tr>
                    <tr><td><input type="text"  maxlength="20" name="academic_qualification[]" id="academic_qualification<?php echo $i; ?>" value="" class="module-input"></td></tr>
                    <tr><td><input type="text" maxlength="10"  name="pan[]" id="pan<?php echo $i; ?>" value="" style="text-transform: uppercase" class="module-input add_pan">
					<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pan[]'); ?></span>
					</td></tr>
                    <tr><td><span class="sp_pan" id="span_pan<?php echo $i; ?>"></span></td></tr>
					<tr><td><textarea  maxlength="500" name="residentail_address[]" id="residentail_address<?php echo $i; ?>" class="module-text" style="height:85px; line-height:25px;"></textarea></td></tr>
                    <tr><td><select name="state[]" id="state<?php echo $i; ?>" class="module-select">
					<option value="">--select--</option>
					<?php 
						foreach($state as $k=>$st){ ?>
							<option value="<?php echo $st->id; ?>" ><?php echo $st->name; ?> </option>
						<?php } ?>
					</select></td></tr>
                    <tr><td><input type="text" maxlength="6" name="pincode[]" id="pincode<?php echo $i; ?>" value="" class="module-input owner_pincode"></td></tr>
                    <tr><td><span class="sp_pincode" id="span_pincode<?php echo $i; ?>"></span></td></tr>
					<tr><td><select name="adress_proof_type[]" id="adress_proof_type<?php echo $i; ?>"  class="module-select">
					<option value="">--select--</option>
					
					<option value="Electricity Bill" >Electricity Bill</option>		
					<option value="Telephone Bill" >Telephone Bill</option>		
					<option value="Bank Account statement" >Bank Account statement</option>		
					<option value="Letter from reputer Employer" >Letter from reputer Employer</option>		
					<option value="Letter from recognized Public authority" >Letter from recognized Public authority</option>		
					<option value="Aadhar Card" >Aadhar Card</option>		
					<option value="Ration card" >Ration card</option>	
					
					</select>
					<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('adress_proof_type[]'); ?></span>
					</td></tr>
                    <tr><td><input type="text"  maxlength="30" name="address_proof_id[]" id="address_proof_id<?php echo $i; ?>" value="" class="module-input">
					<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('address_proof_id[]'); ?></span>
					</td></tr>
                    <tr><td><input type="text" maxlength="10" name="mobile_no[]" id="mobile_no<?php echo $i; ?>" value="" class="module-input owner_mob">
					<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('mobile_no[]'); ?></span>
					</td></tr>
                    <tr><td><span class="sp_mob" id="span_mob_no<?php echo $i; ?>"></span></td></tr>
                    <tr><td><input type="text" maxlength="11" name="landline_no[]" id="landline_no<?php echo $i; ?>" value="" class="module-input owner_landline"></td></tr>
                    <tr><td><span class="sp_land" id="span_lanline<?php echo $i; ?>"></span></td></tr>
					<tr><td><input type="text"  maxlength="20" name="exp_in_line_activity[]" id="exp_in_line_activity<?php echo $i; ?>" value="" class="module-input"></td></tr>
                    <tr><td><input type="text"  maxlength="50" name="souce_of_other_income[]" id="souce_of_other_income<?php echo $i; ?>" value="" class="module-input"></td></tr>
                    <tr><td><select name="know_cibil_score[]" id="know_cibil_score<?php echo $i; ?>" class="module-select know_cibil">
					<option value="">--select--</option>
					
					<option value="Y" >Yes</option>		
					<option value="N" >No</option>
					
					</select></td></tr>
					

                    <tr><td><input type="text"  maxlength="3" name="cibil_score[]" id="cibil_score<?php echo $i; ?>" value="" class="module-input"></td></tr>
                    
					
					<tr><td><select name="cast[]" id="cast<?php echo $i; ?>" class="module-select">
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
              <td>
                                
        	</tr>
            
                <!--07-09-2016-edit-mp-->
            
           
            
            <script type="text/javascript">
			var rowNum =0;
                function addOwnview(){
					 rowNum++;
                  //$("tr.tds_own").append('<td style="width:250px;position:relative;top:-18px;" class="apnd_bg"><a title="Delete" href="#" class="rmv_bnk pull-right"><i class="fa fa-close"></i></a><table class="table sbitem" style="width:300px;"><tbody><tr><td><input type="text" name="name[]" id="name<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" name="dob[]" id="dob<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" name="father_name[]" id="father_name<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" name="academic_qualification[]" id="academic_qualification<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" maxlength="10" name="pan[]" id="pan<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><textarea name="residentail_address[]" id="residentail_address<?php echo $i; ?>" class="module-text owner_det1" style="height:85px; line-height:25px;"></textarea></td></tr><tr><td><select name="state[]" id="state<?php echo $i; ?>" class="module-select owner_det1"><option value="">--select--</option><?php foreach($state as $k=>$st){ ?><option value="<?php echo $st->id; ?>" ><?php echo $st->name; ?> </option> <?php } ?> </select></td></tr><tr><td><input type="text" maxlength="6" name="pincode[]" id="pincode<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><select name="adress_proof_type[]" id="adress_proof_type<?php echo $i; ?>"  class="module-select owner_det1"><option value="">--select--</option><option value="Electricity Bill" >Electricity Bill</option><option value="Telephone Bill" >Telephone Bill</option><option value="Bank Account statement" >Bank Account statement</option><option value="Letter from reputer Employer" >Letter from reputer Employer</option><option value="Letter from recognized Public authority" >Letter from recognized Public authority</option><option value="Aadhar Card" >Aadhar Card</option><option value="Ration card" >Ration card</option></select></td></tr><tr><td><input type="text" name="address_proof_id[]" id="address_proof_id <?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" maxlength="10" name="mobile_no[]" id="mobile_no<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" maxlength="11" name="landline_no[]" id="landline_no<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" name="exp_in_line_activity[]" id="exp_in_line_activity<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" name="souce_of_other_income[]" id="souce_of_other_income<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><select name="know_cibil_score[]" id="know_cibil_score<?php echo $i; ?>" class="module-select know_cibil owner_det1"><option value="">--select--</option><option value="Y" >Yes</option><option value="N" >No</option></select></td></tr><tr><td><input type="text" name="cibil_score[]" id="cibil_score <?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><select name="cast[]" id="cast<?php echo $i; ?>" class="module-select owner_det1"><option value="">--select--</option><option value="Yes" >Yes</option><option value="No" >No</option></select></td></tr></tbody></table></td>');
                  $("tr.tds_own").append('<td style="width:250px; position:relative;top:-18px;" class="apnd_bg"><a title="Delete" href="#" class="rmv_bnk pull-right"><i class="fa fa-close"></i></a><table class="table sbitem" style="width:300px;"><tbody><tr><td><input type="text" maxlength="50" name="name[]" id="name'+rowNum+'" value="" class="module-input add_more_name owner_det1"></td></tr><tr><td><input type="text" name="dob[]" id="dob'+rowNum+'" value="" class="module-input owner_dob owner_det1"></td></tr><tr><td><input type="text" maxlength="50" name="father_name[]" id="father_name'+rowNum+'" value="" class="module-input add_more_father"></td></tr><tr><td><input type="text"  maxlength="20" name="academic_qualification[]" id="academic_qualification'+rowNum+'" value="" class="module-input"></td></tr><tr><td><input type="text" maxlength="10" name="pan[]" id="pan'+rowNum+'" value="" style="text-transform: uppercase" class="module-input add_more_pan owner_det1"></td></tr><tr><td><span class="sp_pan" id="span_pan'+rowNum+'"></span></td></tr><tr><td><textarea  maxlength="500" name="residentail_address[]" id="residentail_address'+rowNum+'" class="module-text" style="height:85px; line-height:25px;"></textarea></td></tr><tr><td><select name="state[]" id="state'+rowNum+'" class="module-select"><option value="">--select--</option><?php foreach($state as $k=>$st){ ?><option value="<?php echo $st->id; ?>" ><?php echo $st->name; ?> </option> <?php } ?> </select></td></tr><tr><td><input type="text" maxlength="6" name="pincode[]" id="pincode'+rowNum+'" value="" class="module-input add_more_pincode"></td></tr><tr><td><span class="sp_pincode" id="span_pincode'+rowNum+'"></span></td></tr><tr><td><select name="adress_proof_type[]" id="adress_proof_type'+rowNum+'"  class="module-select owner_det1"><option value="">--select--</option><option value="Electricity Bill" >Electricity Bill</option><option value="Telephone Bill" >Telephone Bill</option><option value="Bank Account statement" >Bank Account statement</option><option value="Letter from reputer Employer" >Letter from reputer Employer</option><option value="Letter from recognized Public authority" >Letter from recognized Public authority</option><option value="Aadhar Card" >Aadhar Card</option><option value="Ration card" >Ration card</option></select></td></tr><tr><td><input type="text"  maxlength="30" name="address_proof_id[]" id="address_proof_id'+rowNum+'" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" maxlength="10" name="mobile_no[]" id="mobile_no'+rowNum+'" value="" class="module-input add_more_mob owner_det1"></td></tr><tr><td><span class="sp_mob" id="span_mob_no'+rowNum+'"></span></td></tr><tr><td><input type="text" maxlength="11" name="landline_no[]" id="landline_no'+rowNum+'" value="" class="module-input add_more_landline"></td></tr><tr><td><span class="sp_land" id="span_lanline'+rowNum+'"></span></td></tr><tr><td><input type="text"  maxlength="20" name="exp_in_line_activity[]" id="exp_in_line_activity'+rowNum+'" value="" class="module-input"></td></tr><tr><td><input type="text"  maxlength="50" name="souce_of_other_income[]" id="souce_of_other_income'+rowNum+'" value="" class="module-input"></td></tr><tr><td><select name="know_cibil_score[]" id="know_cibil_score'+rowNum+'" class="module-select know_cibil addMore"><option value="">--select--</option><option value="Y" >Yes</option><option value="N" >No</option></select></td></tr><tr><td><input type="text"  maxlength="3" name="cibil_score['+rowNum+']" id="cibil_score'+rowNum+'" value="" class="module-input cibil_sc"></td></tr><tr><td><select name="cast[]" id="cast'+rowNum+'" class="module-select addMore"><option value="">--select--</option><option value="Yes" >Yes</option><option value="No" >No</option></select></td></tr><tr><td style="line-height:20px;"><label class="radio-inline"><input type="radio" checked value="0" name="please_specify['+rowNum+']" id="please_specify'+rowNum+'" >SC</label><label class="radio-inline"><input type="radio" value="1" name="please_specify['+rowNum+']" id="please_specify'+rowNum+'" >ST</label><label class="radio-inline"><input type="radio" value="2" name="please_specify['+rowNum+']" id="please_specify'+rowNum+'" >Minority</label> </td></tr></tbody></table></td>');

                $('.rmv_bnk').on('click', function(c){
                    $(this).parent().fadeOut('slow', function(c){
                    });
					$("#submit_btn").removeAttr("disabled","disabled");
					$(".pull-right").removeAttr("disabled","disabled");
                });

				//for add more
				
			$('.add_more_father').on('keyup blur input',function(){	
					var name=$(this).val();
					name=name.replace(/[^a-zA-Z ]+/g, '');
					$(this).val(name);
			});
			$('.add_more_name').on('keyup blur input',function(){	
					var name=$(this).val();
					name=name.replace(/[^a-zA-Z ]+/g, '');
					$(this).val(name);
			});
				
			$(".add_more_mob").on('keyup input blur',function(){
			//alert("dddd");
				    var id = $(this).attr("id");
					//alert(id);
					var name=$('#'+id).val();
					name=name.replace(/[^0-9]+/g, '');
					$(this).val(name);

				
					var mob_no3 = $(this).val().length;
					//alert(mob_no3);
					if(mob_no3 ==0){
						$(this).parent('td').parent('tr').next('tr').find('span').html("");
					}else{
						if(mob_no3 < 10 )
						 {
							  $(this).parent('td').parent('tr').next('tr').find('span').html("Enter 10 digits mobile no.");
						 }else{
							 //alert("asds");
							  $(this).parent('td').parent('tr').next('tr').find('span').html("");
						 } 
						
					}
					
				
			});
			
			$(".add_more_pincode").on('keyup input blur',function(){
			//alert("dddd");
				    var id = $(this).attr("id");
					//alert(id);
					var name=$('#'+id).val();
					name=name.replace(/[^0-9]+/g, '');
					$(this).val(name);

				
					var pincode = $(this).val().length;
					//alert(mob_no3);
					if(pincode ==0){
						$(this).parent('td').parent('tr').next('tr').find('span').html("");
					}else{
						if(pincode < 6 )
						 {
							  $(this).parent('td').parent('tr').next('tr').find('span').html("Enter 6 digits pincode.");
						 }else{
							 //alert("asds");
							  $(this).parent('td').parent('tr').next('tr').find('span').html("");
						 } 
						
					}
					
				
			});
			
			$(".add_more_landline").on('keyup input blur',function(){
			//alert("dddd");
				    var id = $(this).attr("id");
					//alert(id);
					var name=$('#'+id).val();
					name=name.replace(/[^0-9]+/g, '');
					$(this).val(name);

				
					var landline = $(this).val().length;
					//alert(mob_no3);
					if(landline ==0){
						$(this).parent('td').parent('tr').next('tr').find('span').html("");
					}else{
						if(landline < 11 )
						 {
							  $(this).parent('td').parent('tr').next('tr').find('span').html("Enter 11 digits landline no.");
						 }else{
							 //alert("asds");
							  $(this).parent('td').parent('tr').next('tr').find('span').html("");
						 } 
						
					}
					
				
			});
			
			$(".add_more_pan").on('keyup input blur',function(){
			//alert("dddd");
				    var id = $(this).attr("id");
					var ObjVal = $(this).val();
					var panPat = "^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$";
					/* var code = /([C,P,H,F,A,T,B,L,J,G])/;
					var code_chk = ObjVal.substring(3,4); */
					if(ObjVal !="")
					{
					if (ObjVal.search(panPat) == -1 || ObjVal < 10)
						{
							$(this).parent('td').parent('tr').next('tr').find('span').html("Invalid PAN no.");
						}else{
							$(this).parent('td').parent('tr').next('tr').find('span').html("");
						}
					}else{
						$(this).parent('td').parent('tr').next('tr').find('span').html("");
					}						
					
					
				
			});
			
			$('.cibil_sc').on('keyup blur input',function(){	
				var name=$(this).val();
				name=name.replace(/[^0-9]+/g, '');
				$(this).val(name);
				});

	  var dateToday = new Date();
	  var yrRange = '1950' + ":" + (dateToday.getFullYear() - 18).toString();
		
		//alert(n);
    $( ".owner_dob" ).datepicker({

					dateFormat: 'dd-mm-yy',
					changeMonth: true,
					changeYear: true,
					showMonthAfterYear:true,
					//yearRange: yrRange
					//minDate:"01-01-1900",
					 maxDate: '-10Y', 
					 yearRange: '1900:' + new Date().getFullYear().toString()
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
				
				
			
			  $('.addMore').each(function(e){
				var namefld=$(this).attr('name');
				//alert(namefld);
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
					if(totalElements1==0 || totalElements1==6)
					{
						var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
						if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1').length>0){
							$(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1:not(.disappeared)').removeAttr('disabled');
						}
						$("#submit_btn").removeAttr('disabled','disabled');
						// $(".owner_det2").attr("readonly", false);
						$(".pull-right").removeAttr('disabled','disabled');
						
					}
					/* else if(totalElements1==15)
					{
						var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
						if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1').length>0){
							$(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1:not(.disappeared)').removeAttr('disabled');
						}
						$("#submit_btn").removeAttr('disabled','disabled');
						// $(".owner_det2").attr("readonly", false);
						$(".pull-right").removeAttr('disabled','disabled');
						
					} */
					else{
						var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
						if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1').length>0){
							$(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1').attr('disabled','disabled');
						}
						 $("#submit_btn").attr('disabled','disabled');
						 // $(".owner_det2").attr("readonly", true);
						 $(".pull-right").attr('disabled','disabled');
					}
					
					var cibil_score1 = $('#cibil_score1').val();
					//alert(cibil_score1);
					
				});
			 
			
		
		//end add more

                }
				
		
				
            </script>
                
            
        </tbody>
		
		
		
		
		
		
        </table>
				</div>
		<div class="clear"></div>
		<input type="hidden" name="application_id" value="<?php echo $application_id;?>"/>

		<hr class="yellow-hr">
        <div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default">Save &amp; Continue</button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>

		
		
		
		  </div>

        </div><!--    p100 end-->
      </div>
</form>
<?php } else { ?>

<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_owner_details" method="post">


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

<div class="content-wrapper select" id="ownerdetlstbl_content">
        <div class="clear"></div>
        <h5 class="tab-form-head">Owner / Director KYC Details</h5>
    
    <button type="button" id="add_more" class="yellow-button top-margin10 ylw pull-right" style="width:150px;" onclick="addOwnview()"><span class="big-text small-txt_p">Add More</span> &nbsp;&nbsp;<i class="fa fa-plus-circle" aria-hidden="true"></i>
    </button>
    
        <div class="p100">
<div class="owntlmxd">
	<div class="horizontal-scroll">
		<table class="table mixed" style="margin-bottom:0px;">
        <tbody>
        	<tr class="tds_own">
        		<td style="width:300px;">
                <table class="table sbitem" style="width:300px;">
                <tbody>
				<tr><td>Name <span class="star">*</span></td></tr>
                <tr><td>DOB <span class="star">*</span></td> </tr>
                <tr><td>Father/Spouse Name</td></tr>
                <tr><td>Academic Qualification</td></tr>
                <tr><td>PAN of the Promoter <span class="star">*</span></td></tr>
                <tr><td style="height:95px;">Residential Address</td></tr>
                <tr><td>State</td></tr>
                <tr><td>Pincode</td></tr>
                <tr><td>Address Proof Type <span class="star">*</span></td></tr>
                <tr><td>Address Proof ID <span class="star">*</span></td></tr>
                <tr><td>Mobile No. <span class="star">*</span></td></tr>
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
				<?php for($i=0;$i<count($owner_details);$i++){ ?>
        		<td style="width:250px;">
                <table class="table sbitem" style="width:300px;">
                	<tbody>
                    <tr><td>
					<input type="text" maxlength="50" name="name[]" id="name<?php echo $i; ?>" value="<?php echo $owner_details[$i]->name;?>" class="module-input owner_det1">
					<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('name[]'); ?></span>
					</td></tr>
					
                    <tr><td><input type="text" name="dob[]" id="dob<?php echo $i; ?>" value="<?php echo date('d-m-Y',strtotime($owner_details[$i]->dob));?>" class="module-input owner_det1">
					<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('dob[]'); ?></span>
					</td></tr>
                    <tr><td><input type="text" maxlength="50" name="father_name[]" id="father_name<?php echo $i; ?>" value="<?php echo $owner_details[$i]->father_name;?>" class="module-input"></td></tr>
                    <tr><td><input type="text"  maxlength="20" name="academic_qualification[]" id="academic_qualification<?php echo $i; ?>" value="<?php echo $owner_details[$i]->academic_qualification;?>" class="module-input"></td></tr>
                    <tr><td><input type="text" maxlength="10" name="pan[]" id="pan<?php echo $i; ?>" value="<?php echo $owner_details[$i]->pan;?>" style="text-transform: uppercase" class="module-input add_pan owner_det1">
					<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('pan[]'); ?></span>
					</td></tr>
                    <tr><td><span class="sp_pan" id="span_pan<?php echo $i; ?>"></span></td></tr>
					<tr><td><textarea  maxlength="500" name="residentail_address[]" id="residentail_address<?php echo $i; ?>" class="module-text" style="height:85px; line-height:25px;"><?php echo $owner_details[$i]->residentail_address;?></textarea></td></tr>
                    <tr><td><select name="state[]" id="state<?php echo $i; ?>" class="module-select">
					<option value="">--select--</option>
					<?php 
						foreach($state as $k=>$st){ ?>
							<option value="<?php echo $st->id; ?>" <?php if($st->id==$owner_details[$i]->state){ echo "selected"; }  ?>><?php echo $st->name; ?> </option>
						<?php } ?>
					</select></td></tr>
                    <tr><td><input type="text" maxlength="6" name="pincode[]" id="pincode<?php echo $i; ?>" value="<?php echo $owner_details[$i]->pincode;?>" class="module-input owner_pincode"></td></tr>
                    <tr><td><span class="sp_pincode" id="span_pincode<?php echo $i; ?>"></span></td></tr>
					<tr><td><select name="adress_proof_type[]" id="adress_proof_type<?php echo $i; ?>"  class="module-select owner_det1">
					<option value="">--select--</option>
					
					<option value="Electricity Bill" <?php if($owner_details[$i]->adress_proof_type=='Electricity Bill') { echo "selected"; }?>>Electricity Bill</option>		
					<option value="Telephone Bill" <?php if($owner_details[$i]->adress_proof_type=='Telephone Bill') { echo "selected"; }?>>Telephone Bill</option>		
					<option value="Bank Account statement" <?php if($owner_details[$i]->adress_proof_type=='Bank Account statement') { echo "selected"; }?>>Bank Account statement</option>		
					<option value="Letter from reputer Employer" <?php if($owner_details[$i]->adress_proof_type=='Letter from reputer Employer') { echo "selected"; }?>>Letter from reputer Employer</option>		
					<option value="Letter from recognized Public authority" <?php if($owner_details[$i]->adress_proof_type=='Letter from recognized Public authority') { echo "selected"; }?>>Letter from recognized Public authority</option>		
					<option value="Aadhar Card" <?php if($owner_details[$i]->adress_proof_type=='Aadhar Card') { echo "selected"; }?>>Aadhar Card</option>		
					<option value="Ration card" <?php if($owner_details[$i]->adress_proof_type=='Ration card') { echo "selected"; }?>>Ration card</option>	
					
					</select>
					<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('adress_proof_type[]'); ?></span>
					</td></tr>
                    <tr><td><input type="text"  maxlength="30" name="address_proof_id[]" id="address_proof_id<?php echo $i; ?>" value="<?php echo $owner_details[$i]->address_proof_id;?>" class="module-input owner_det1">
					<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('address_proof_id[]'); ?></span>
					</td></tr>
                    <tr><td><input type="text" maxlength="10" name="mobile_no[]" id="mobile_no<?php echo $i; ?>" value="<?php echo $owner_details[$i]->mobile_no;?>" class="module-input owner_mob add_more_mob owner_det1">
					<span  class="requirederror alert alert-success alrt_md"><?php echo form_error('mobile_no[]'); ?></span>
					</td></tr><span id="span_mob_no<?php echo $i; ?>"></span>
                    <tr><td><span class="sp_mob" id="span_mob_no<?php echo $i; ?>"></span></td></tr>
					<tr><td><input type="text" maxlength="11" name="landline_no[]" id="landline_no<?php echo $i; ?>" value="<?php echo $owner_details[$i]->landline_no;?>" class="module-input owner_landline"></td></tr>
                    <tr><td><span class="sp_land" id="span_lanline<?php echo $i; ?>"></span></td></tr>
					<tr><td><input type="text"  maxlength="20" name="exp_in_line_activity[]" id="exp_in_line_activity<?php echo $i; ?>" value="<?php echo $owner_details[$i]->exp_in_line_activity;?>" class="module-input"></td></tr>
                    <tr><td><input type="text"  maxlength="50" name="souce_of_other_income[]" id="souce_of_other_income<?php echo $i; ?>" value="<?php echo $owner_details[$i]->souce_of_other_income;?>" class="module-input"></td></tr>
                    <tr><td><select name="know_cibil_score[]" id="know_cibil_score<?php echo $i; ?>" class="module-select know_cibil">
					<option value="">--select--</option>
					
					<option value="Y" <?php if($owner_details[$i]->know_cibil_score=='Y') { echo "selected"; }?>>Yes</option>		
					<option value="N" <?php if($owner_details[$i]->know_cibil_score=='N') { echo "selected"; }?>>No</option>
					
					</select></td></tr>
					
					<?php //if($owner_details[$i]->know_cibil_score=='Yes') { ?>
					<div class="cibil<?php echo $i; ?>">
                    <tr><td><input type="text"  maxlength="3" name="cibil_score[<?php echo $i; ?>]" id="cibil_score<?php echo $i; ?>" value="<?php echo $owner_details[$i]->cibil_score;?>" class="module-input"></td></tr>
                    </div>
					<?php //} ?>
					
					<tr><td><select name="cast[]" id="cast<?php echo $i; ?>" class="module-select">
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
				 
				
				<script type="text/javascript">
			var rowNum =<?php echo count($owner_details); ?>;
                function addOwnview(){
					 rowNum++;
                  //$("tr.tds_own").append('<td style="width:250px;position:relative;top:-18px;" class="apnd_bg"><a title="Delete" href="#" class="rmv_bnk pull-right"><i class="fa fa-close"></i></a><table class="table sbitem" style="width:300px;"><tbody><tr><td><input type="text" name="name[]" id="name<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" name="dob[]" id="dob<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" name="father_name[]" id="father_name<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" name="academic_qualification[]" id="academic_qualification<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" maxlength="10" name="pan[]" id="pan<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><textarea name="residentail_address[]" id="residentail_address<?php echo $i; ?>" class="module-text owner_det1" style="height:85px; line-height:25px;"></textarea></td></tr><tr><td><select name="state[]" id="state<?php echo $i; ?>" class="module-select owner_det1"><option value="">--select--</option><?php foreach($state as $k=>$st){ ?><option value="<?php echo $st->id; ?>" ><?php echo $st->name; ?> </option> <?php } ?> </select></td></tr><tr><td><input type="text" maxlength="6" name="pincode[]" id="pincode<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><select name="adress_proof_type[]" id="adress_proof_type<?php echo $i; ?>"  class="module-select owner_det1"><option value="">--select--</option><option value="Electricity Bill" >Electricity Bill</option><option value="Telephone Bill" >Telephone Bill</option><option value="Bank Account statement" >Bank Account statement</option><option value="Letter from reputer Employer" >Letter from reputer Employer</option><option value="Letter from recognized Public authority" >Letter from recognized Public authority</option><option value="Aadhar Card" >Aadhar Card</option><option value="Ration card" >Ration card</option></select></td></tr><tr><td><input type="text" name="address_proof_id[]" id="address_proof_id <?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" maxlength="10" name="mobile_no[]" id="mobile_no<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" maxlength="11" name="landline_no[]" id="landline_no<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" name="exp_in_line_activity[]" id="exp_in_line_activity<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" name="souce_of_other_income[]" id="souce_of_other_income<?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><select name="know_cibil_score[]" id="know_cibil_score<?php echo $i; ?>" class="module-select know_cibil owner_det1"><option value="">--select--</option><option value="Y" >Yes</option><option value="N" >No</option></select></td></tr><tr><td><input type="text" name="cibil_score[]" id="cibil_score <?php echo $i; ?>" value="" class="module-input owner_det1"></td></tr><tr><td><select name="cast[]" id="cast<?php echo $i; ?>" class="module-select owner_det1"><option value="">--select--</option><option value="Yes" >Yes</option><option value="No" >No</option></select></td></tr></tbody></table></td>')
                  $("tr.tds_own").append('<td style="width:250px;position:relative;top:-18px;" class="apnd_bg"><a title="Delete" href="#" class="rmv_bnk pull-right"><i class="fa fa-close"></i></a><table class="table sbitem" style="width:300px;"><tbody><tr><td><input type="text" maxlength="50" name="name[]" id="name'+rowNum+'" value="" class="module-input add_more_name owner_det1"></td></tr><tr><td><input type="text" name="dob[]" id="dob'+rowNum+'" value="" class="module-input owner_dob owner_det1"></td></tr><tr><td><input type="text" maxlength="50" name="father_name[]" id="father_name'+rowNum+'" value="" class="module-input add_more_father"></td></tr><tr><td><input type="text"  maxlength="20" name="academic_qualification[]" id="academic_qualification'+rowNum+'" value="" class="module-input"></td></tr><tr><td><input type="text" maxlength="10" name="pan[]" id="pan'+rowNum+'" value="" style="text-transform: uppercase" class="module-input add_more_pan owner_det1"></td></tr><tr><td><span class="sp_pan" id="span_pan'+rowNum+'"></span></td></tr><tr><td><textarea  maxlength="500" name="residentail_address[]" id="residentail_address'+rowNum+'" class="module-text" style="height:85px; line-height:25px;"></textarea></td></tr><tr><td><select name="state[]" id="state'+rowNum+'" class="module-select"><option value="">--select--</option><?php foreach($state as $k=>$st){ ?><option value="<?php echo $st->id; ?>" ><?php echo $st->name; ?> </option> <?php } ?> </select></td></tr><tr><td><input type="text" maxlength="6" name="pincode[]" id="pincode'+rowNum+'" value="" class="module-input add_more_pincode"></td></tr><tr><td><span class="sp_pincode" id="span_pincode'+rowNum+'"></span></td></tr><tr><td><select name="adress_proof_type[]" id="adress_proof_type'+rowNum+'"  class="module-select owner_det1"><option value="">--select--</option><option value="Electricity Bill" >Electricity Bill</option><option value="Telephone Bill" >Telephone Bill</option><option value="Bank Account statement" >Bank Account statement</option><option value="Letter from reputer Employer" >Letter from reputer Employer</option><option value="Letter from recognized Public authority" >Letter from recognized Public authority</option><option value="Aadhar Card" >Aadhar Card</option><option value="Ration card" >Ration card</option></select></td></tr><tr><td><input type="text"  maxlength="30" name="address_proof_id[]" id="address_proof_id'+rowNum+'" value="" class="module-input owner_det1"></td></tr><tr><td><input type="text" maxlength="10" name="mobile_no[]" id="mobile_no'+rowNum+'" value="" class="module-input add_more_mob owner_det1"></td></tr><tr><td><span class="sp_mob" id="span_mob_no'+rowNum+'"></span></td></tr><tr><td><input type="text" maxlength="11" name="landline_no[]" id="landline_no'+rowNum+'" value="" class="module-input class="sp_land" add_more_landline"></td></tr><tr><td><span id="span_land'+rowNum+'"></span></td></tr><tr><td><input type="text"  maxlength="20" name="exp_in_line_activity[]" id="exp_in_line_activity'+rowNum+'" value="" class="module-input"></td></tr><tr><td><input type="text"  maxlength="50" name="souce_of_other_income[]" id="souce_of_other_income'+rowNum+'" value="" class="module-input"></td></tr><tr><td><select name="know_cibil_score[]" id="know_cibil_score'+rowNum+'" class="module-select know_cibil addMore"><option value="">--select--</option><option value="Y" >Yes</option><option value="N" >No</option></select></td></tr><tr><td><input type="text"  maxlength="3" name="cibil_score[]" id="cibil_score'+rowNum+'" value="" class="module-input cibil_sc"></td></tr><tr><td><select name="cast[]" id="cast'+rowNum+'" class="module-select addMore"><option value="">--select--</option><option value="Yes" >Yes</option><option value="No" >No</option></select></td></tr><tr><td style="line-height:20px;"><label class="radio-inline"><input type="radio" checked value="0" name="please_specify['+rowNum+']" id="please_specify'+rowNum+'" >SC</label><label class="radio-inline"><input type="radio" value="1" name="please_specify['+rowNum+']" id="please_specify'+rowNum+'" >ST</label><label class="radio-inline"><input type="radio" value="2" name="please_specify['+rowNum+']" id="please_specify'+rowNum+'" >Minority</label> </td></tr></tbody></table></td>')

                $('.rmv_bnk').on('click', function(c){
                    $(this).parent().fadeOut('slow', function(c){
                    });
					$("#submit_btn").removeAttr("disabled","disabled");
					$(".pull-right").removeAttr("disabled","disabled");
                });

				//for add more
				
			$('.add_more_father').on('keyup blur input',function(){	
					var name=$(this).val();
					name=name.replace(/[^a-zA-Z ]+/g, '');
					$(this).val(name);
			});
			$('.add_more_name').on('keyup blur input',function(){	
					var name=$(this).val();
					name=name.replace(/[^a-zA-Z ]+/g, '');
					$(this).val(name);
			});
				
			$(".add_more_mob").on('keyup input blur',function(){
			//alert("dddd");
				    var id = $(this).attr("id");
					//alert(id);
					var name=$('#'+id).val();
					name=name.replace(/[^0-9]+/g, '');
					$(this).val(name);

				
					var mob_no3 = $(this).val().length;
					//alert(mob_no3);
					if(mob_no3 ==0){
						$(this).parent('td').parent('tr').next('tr').find('span').html("");
					}else{
						if(mob_no3 < 10 )
						 {
							  $(this).parent('td').parent('tr').next('tr').find('span').html("Enter 10 digits mobile no.");
						 }else{
							 //alert("asds");
							  $(this).parent('td').parent('tr').next('tr').find('span').html("");
						 } 
						
					}
					
				
			});
			
			$(".add_more_pincode").on('keyup input blur',function(){
			//alert("dddd");
				    var id = $(this).attr("id");
					//alert(id);
					var name=$('#'+id).val();
					name=name.replace(/[^0-9]+/g, '');
					$(this).val(name);

				
					var pincode = $(this).val().length;
					//alert(mob_no3);
					if(pincode ==0){
						$(this).parent('td').parent('tr').next('tr').find('span').html("");
					}else{
						if(pincode < 6 )
						 {
							  $(this).parent('td').parent('tr').next('tr').find('span').html("Enter 6 digits pincode.");
						 }else{
							 //alert("asds");
							  $(this).parent('td').parent('tr').next('tr').find('span').html("");
						 } 
						
					}
					
				
			});
			
			$(".add_more_landline").on('keyup input blur',function(){
			//alert("dddd");
				    var id = $(this).attr("id");
					//alert(id);
					var name=$('#'+id).val();
					name=name.replace(/[^0-9]+/g, '');
					$(this).val(name);

				
					var landline = $(this).val().length;
					//alert(mob_no3);
					if(landline ==0){
						$(this).parent('td').parent('tr').next('tr').find('span').html("");
					}else{
						if(landline < 11 )
						 {
							  $(this).parent('td').parent('tr').next('tr').find('span').html("Enter 11 digits landline no.");
						 }else{
							 //alert("asds");
							  $(this).parent('td').parent('tr').next('tr').find('span').html("");
						 } 
						
					}
					
				
			});
			
			$(".add_more_pan").on('keyup input blur',function(){
			//alert("dddd");
				    var id = $(this).attr("id");
					var ObjVal = $(this).val();
					var panPat = "^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$";
					/* var code = /([C,P,H,F,A,T,B,L,J,G])/;
					var code_chk = ObjVal.substring(3,4); */
					if(ObjVal !="")
					{
					if (ObjVal.search(panPat) == -1 || ObjVal < 10)
						{
							$(this).parent('td').parent('tr').next('tr').find('span').html("Invalid PAN no.");
						}else{
							$(this).parent('td').parent('tr').next('tr').find('span').html("");
						}
					}else{
						$(this).parent('td').parent('tr').next('tr').find('span').html("");
					}						
					
					
				
			});
			
		$('.cibil_sc').on('keyup blur input',function(){	
				var name=$(this).val();
				name=name.replace(/[^0-9]+/g, '');
				$(this).val(name);
				});

	  var dateToday = new Date();
	  var yrRange = '1950' + ":" + (dateToday.getFullYear() - 18).toString();
		
		//alert(n);
    $( ".owner_dob" ).datepicker({

					dateFormat: 'dd-mm-yy',
					changeMonth: true,
					changeYear: true,
					showMonthAfterYear:true,
					//yearRange: yrRange
					//minDate:"01-01-1900",
					//maxDate: 'today',
					maxDate: '-10Y', 
					yearRange: '1900:' + new Date().getFullYear().toString()
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
				
				
			
			  $('.addMore').each(function(e){
				var namefld=$(this).attr('name');
				//alert(namefld);
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
			
			var total_class = $(".owner_det1").length;													
							if(total_class >=32){
								$(".pull-right").attr('disabled','disabled');
							}
			
			
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
					if(totalElements1==0 || totalElements1==6)
					{
						var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
						if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1').length>0){
							$(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1:not(.disappeared)').removeAttr('disabled');
						}
						$("#submit_btn").removeAttr('disabled','disabled');
						// $(".owner_det2").attr("readonly", false);
						$(".pull-right").removeAttr('disabled','disabled');
						
					}
					else if(totalElements1==15)
					{
						var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
						if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1').length>0){
							$(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1:not(.disappeared)').removeAttr('disabled');
						}
						$("#submit_btn").removeAttr('disabled','disabled');
						// $(".owner_det2").attr("readonly", false);
						$(".pull-right").removeAttr('disabled','disabled');
						
					}
					else{
						var avltm=$(this).parents('table.sbitem').parent('td').next('td').parents('.mixed').children('tbody').children('tr').children('td').length-$(this).parents('table.sbitem').parent('td').next('td').index();
						if(avltm>0 && $(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1').length>0){
							$(this).parents('table.sbitem').parent('td').next('td').find('.owner_det1').attr('disabled','disabled');
						}
						 $("#submit_btn").attr('disabled','disabled');
						 // $(".owner_det2").attr("readonly", true);
						 $(".pull-right").attr('disabled','disabled');
					}
					
					var cibil_score1 = $('#cibil_score1').val();
					//alert(cibil_score1);
					
				});
			
			
		
		//end add more

                }
				
		
				
            </script>
				
				
        	</tr>
        </tbody>
        </table>
	</div>
		<div class="clear"></div>
		<input type="hidden" name="application_id" value="<?php echo $application_id;?>"/>
		<input type="hidden" name="flag" value="1" />
		<hr class="yellow-hr">
        <div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default"><?php if($utype_id ==3 || $utype_id ==4 || $utype_id ==5){ echo "Next"; }else { echo "Save &amp; Continue";} ?></button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>

</div>
        </div>
      </div>
</form>

<?php } ?>