<script src="<?php echo base_url()?>assets/front/js/jquery-ui.js"></script>
<link href="<?php echo base_url()?>assets/front/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>

<script type="text/javascript" language="javascript">
var base_url="<?php echo base_url();?>";
$(document).ready(function(){


	$("#cancel_btn").click(function(){
	 window.location.href='<?php echo base_url();?>manage/dashboard';
	});	
	
			
		
			/* var v = $("#hold_frm").validate({

				rules:{
						
						'industry[]': {
							required: true
						},
						'loan_product[]': {
							required: true
						}, 
																	
					}
				});	 */
				
				
				 $('#min_loan_amt,#max_loan_amt').on('keyup blur input',function(){	
					var name=$(this).val();
					name=name.replace(/[^0-9]+/g, '');
					$(this).val(name);
				});				

				$("#min_loan_amt,#max_loan_amt").on("keyup input blur",function(){
					var val1=$(this).val();
					x=val1.toString();
					//alert(x);
					var lastThree = x.substring(x.length-3);
					var otherNumbers = x.substring(0,x.length-3);
					if(otherNumbers != '')
						lastThree = ',' + lastThree;
					var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
					$(this).val(res);
				}); 
				
				$('#max_loan_amt').on("keyup input blur",function(){
				var max_loan_amt = $(this).val();
				var min_loan_amt = $("#min_loan_amt").val();
				
				min_loan_amt = min_loan_amt.replace(/,/g,'');
				max_loan_amt = max_loan_amt.replace(/,/g,'');
				//alert(min_loan_amt);
				//alert(max_loan_amt);
				if(max_loan_amt !=""){
					if(parseInt(min_loan_amt) > parseInt(max_loan_amt))
					 {
						  $(this).parent('td').parent('tr').next('tr').find('span').html("Min loan amount should not be greater than max amount.");
						  $("#submit_btn").attr('disabled','disabled');
					 }else{
						  $(this).parent('td').parent('tr').next('tr').find('span').html("");
						  $("#submit_btn").removeAttr('disabled','disabled');
					 }
				}else{
					$(this).parent('td').parent('tr').next('tr').find('span').html("");
					$("#submit_btn").removeAttr('disabled','disabled');
				}
			
			}); 
			
			
			$('#min_loan_amt').on("keyup input blur",function(){
				var min_loan_amt = $(this).val();
				var max_loan_amt = $("#max_loan_amt").val();
				
				min_loan_amt = min_loan_amt.replace(/,/g,'');
				max_loan_amt = max_loan_amt.replace(/,/g,'');
				//alert(min_loan_amt);
				//alert(max_loan_amt);
				if(min_loan_amt !=""){
					if(parseInt(min_loan_amt) > parseInt(max_loan_amt))
					 {
						  $(this).parent('td').parent('tr').next('tr').find('span').html("Min loan amount should not be greater than max amount.");
						  $("#submit_btn").attr('disabled','disabled');
					 }else{
						  $(this).parent('td').parent('tr').next('tr').find('span').html("");
						  $("#submit_btn").removeAttr('disabled','disabled');
					 }
				}else{
					$(this).parent('td').parent('tr').next('tr').find('span').html("");
					$("#submit_btn").removeAttr('disabled','disabled');
				}
			
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
	    //var dateToday = new Date();
	  //var yrRange = '1950' + ":" + (dateToday.getFullYear() - 18).toString();
				
		 $.datepicker.setDefaults({
		  dateFormat: 'dd-mm-yy',
		  changeMonth: true,
		  changeYear: true,
		  maxDate: 'today',					
		  yearRange: '1900:' + new Date().getFullYear().toString()
	}); 
				
	$( "#from_year" ).datepicker({
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			//minDate:-7,
			//maxDate:'31-12-2020',
			onSelect: function () {
				var minDate = $('#from_year').datepicker('getDate');
				//minDate.setDate(minDate.getDate());
				$('#to_year').datepicker('option', 'minDate', minDate);
				
			}
		});
		$( "#to_year" ).datepicker({
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate:$('#from_year').datepicker('getDate'),		
			
		});
  }); 
</script>
<style>
span.requirederror{
	puser_detailsding-left:5px;
}

.errorClass { border:  2px solid blue; }

</style>


<?php if(empty($bank_filter)) {?>

<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_bank_filter" method="post">
<?php
if($this->session->userdata('error_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='search_error' style='color:#1797a2; padding-left:50px;'><strong>Data has been saved.</strong></span>";
	$this->session->set_userdata('error_message','');
	} ?>
<div class="content-wrapper select" id="bankuser_filter">
        <div class="clear"></div>
        <h5 class="tab-form-head">Bank Filter</h5>
        <div class="p100 horizontal-scroll scrl_not">

		<table class="table mixed" style="margin-bottom:0px;">
        <tbody>
        	<tr>
        		<td>
                <table class="table sbitem">
                <tbody>
                <tr><td style="font-weight:600; whitee-space:nowrap; color:#fff;">Numbers of years in business</td></tr>
                    
                     <tr>
                    <td>
					
					<div class="modl_puty">FROM :&nbsp&nbsp<input type="text" name="from_year" id="from_year" value="" class="module-input"></div>
					
					</td>
                    <td>
                        <div class="modl_puty">TO :&nbsp&nbsp<input type="text" name="to_year" id="to_year" value="" class="module-input "></div>
                    </td>
                         
                    </tr>
                    
<!--                    <tr></tr>-->
                    
                <tr><td style="font-weight:600; whitee-space:nowrap; color:#fff;">Industry or sector(select Industry you DON'T want application from):</td> </tr>
                    <tr>
                        <td>
                            <div class="iput_grp">
                                <input type="checkbox" name="industry[]" value="1" >    <span>Steel</span><br>
                                <input type="checkbox" name="industry[]" value="2" >    <span>Construction</span><br>
                                <input type="checkbox" name="industry[]" value="3" >    <span>Chemicals</span><br> 
                            </div>
                            <div class="iput_grp">
                                <input type="checkbox" name="industry[]" value="4" >    <span>Textile /Garment</span><br>
                                <input type="checkbox" name="industry[]" value="5" >    <span>Power Generation , Transmission & Distribution</span><br>
                                <input type="checkbox" name="industry[]" value="6" >    <span>Financial Services</span><br> 
                            </div>
                            <div class="iput_grp">
                                <input type="checkbox" name="industry[]" value="7" >    <span>Petrochemicals</span><br>
                                <input type="checkbox" name="industry[]" value="8" >    <span>Consumer Durable Goods</span><br>
                                <input type="checkbox" name="industry[]" value="9" >    <span>Food & Beverages</span><br> 
                            </div>
                            <div class="iput_grp">
                                <input type="checkbox" name="industry[]" value="10" >  <span>Hotels & Hospitality</span><br>
                                <input type="checkbox" name="industry[]" value="11" >  <span>Real estate</span><br>
                                <input type="checkbox" name="industry[]" value="12" >  <span>Restaurants & Catering</span><br>
							 </div>
							 <div class="iput_grp">
                                <input type="checkbox" name="industry[]" value="13" >  <span>Soaps and Detergents</span><br>                             
                                <input type="checkbox" name="industry[]" value="14" >  <span>Personal care</span><br>
                                <input type="checkbox" name="industry[]" value="15" >  <span>Paints and Pigments</span><br>
							 </div>
							 <div class="iput_grp">	
                                <input type="checkbox" name="industry[]" value="16" >  <span>Consumer and Industrial Electricals</span><br>                             
                                <input type="checkbox" name="industry[]" value="17" >  <span>Automobile and Auto Component</span><br>
                                <input type="checkbox" name="industry[]" value="18" >  <span>Aviation</span><br>
							 </div>
							 <div class="iput_grp">	
                                <input type="checkbox" name="industry[]" value="19" >  <span>Shipping & Ports</span><br>                             
                                <input type="checkbox" name="industry[]" value="20" >  <span>Logistics and Transportation</span><br>
                                <input type="checkbox" name="industry[]" value="21" >  <span>Agri Commodites & Agro Processing</span><br>
							</div> 
							 <div class="iput_grp">	
                                <input type="checkbox" name="industry[]" value="22" >  <span>Packaging and Films</span><br>                            
                                <input type="checkbox" name="industry[]" value="23" >  <span>Media & Entertainment</span><br>
                                <input type="checkbox" name="industry[]" value="24" >  <span>Information Technology Hardware</span><br>
							</div>
							<div class="iput_grp">	
                                <input type="checkbox" name="industry[]" value="25" >  <span>Information Technology Software</span><br>                        
                                <input type="checkbox" name="industry[]" value="26" >  <span>BPO/KPO</span><br>
                                <input type="checkbox" name="industry[]" value="27" >  <span>Telecom</span><br>
                                <input type="checkbox" name="industry[]" value="28" >  <span>Retail</span><br> 
                                <input type="checkbox" name="industry[]" value="29" >  <span>Infrastructure (roads, rail, airports )</span><br> 
                            </div>
                        </td>
                        
                        

                    </tr>
                <tr><td style="font-weight:600; whitee-space:nowrap; color:#fff;">Loan Product(select Industry you DON'T want application from):</td></tr>
                    <tr>
                        <td>
                            <div class="iput_grp">
                                <input type="checkbox" name="loan_product[]" value="1" ><span>Personal Loan</span><br>
                                <input type="checkbox" name="loan_product[]" value="2" ><span>Housing Loan</span><br>
                                <input type="checkbox" name="loan_product[]" value="3" ><span>Loan against Property</span><br>
                                <input type="checkbox" name="loan_product[]" value="4" ><span>Vehicle Loan</span><br>
                            </div>
                            <div class="iput_grp">                                
                                
                                <input type="checkbox" name="loan_product[]" value="5" ><span>Education Loan</span><br>
                                <input type="checkbox" name="loan_product[]" value="6" ><span>Gold Loan</span><br>
                                <input type="checkbox" name="loan_product[]" value="7" ><span>Others</span><br>
                             </div>
                        </td>
                    </tr>
                <tr><td style="font-weight:600; whitee-space:nowrap; color:#fff;">Loan Amount (Rs. In Lakhs):</td></tr>
                    
                <tr><td style="line-height:20px; font-weight:600; whitee-space:nowrap;">
					
					Minimum :&nbsp&nbsp<input type="text" name="min_loan_amt" id="min_loan_amt" value="" class="module-input ">
                    
                    </td>
                    
                    <td style="line-height:20px; font-weight:600; whitee-space:nowrap;">
                       Maximum :&nbsp&nbsp<input type="text" name="max_loan_amt" id="max_loan_amt" value="" class="module-input ">
                    </td>                   
                    
                    </tr>
					
               <tr><td><span id="span_amt"></span></td></tr>     
                                 
                </tbody>
                </table>
                </td>
              </tr>
        </tbody>
        </table>
		<div class="clear"></div>
		<input type="hidden" name="id" value="<?php echo $id;?>"/>
		<hr class="yellow-hr">
        <div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default">Submit</button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>


        </div>
      </div>
</form>

<?php } else { ?>
<form class="agencyappviewform" id="hold_frm" action="<?php echo base_url();?>manage/dashboard/save_bank_filter" method="post">
<?php
if($this->session->userdata('error_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='validate_error' class='alert alert-success alrt_md'><strong>You have not changed anything.</strong></span>";
	$this->session->set_userdata('error_message','');
	} ?>
<div class="content-wrapper select" id="bankuser_filter">
        <div class="clear"></div>
        <h5 class="tab-form-head">Bank Filter</h5>
        <div class="p100 horizontal-scroll scrl_not">

		<table class="table mixed" style="margin-bottom:0px;">
        <tbody>
        	<tr>
        		<td>
                <table class="table sbitem">
                <tbody>
                <tr><td style="font-weight:600; whitee-space:nowrap; color:#fff;">Numbers of years in business</td></tr>
                    
                     <tr>
                    <td>
                        <div class="modl_puty">
					<?php $from_year=new DateTime($bank_filter[0]->from_year); $to_year=new DateTime($bank_filter[0]->to_year); ?>
					FROM :&nbsp&nbsp<input type="text" name="from_year" id="from_year" value="<?php if($bank_filter[0]->from_year=='0000-00-00'){echo "";}else{echo $from_year->format('d-m-Y');} ?>" class="module-input">
					   </div>
					</td>
                         
                    <td>
                         <div class="modl_puty">
                        TO :&nbsp&nbsp<input type="text" name="to_year" id="to_year" value="<?php if($bank_filter[0]->to_year=='0000-00-00'){echo "";}else{echo $to_year->format('d-m-Y');} ?>" class="module-input "></td>
                         </div>
                    </tr>
                    
			<?php $industry = explode(",",$bank_filter[0]->industry);?>
                    
                <tr><td style="font-weight:600; whitee-space:nowrap; color:#fff;">Industry or sector(select Industry you DON'T want application from):</td> </tr>
                    <tr>
                        <td>
                            <div class="iput_grp">
                                <input type="checkbox" name="industry[]" value="1"<?php if(in_array('1',$industry)){?> checked="checked"<?php } ?> >    <span>Steel</span><br>
                                <input type="checkbox" name="industry[]" value="2" <?php if(in_array('2',$industry)){?> checked="checked"<?php } ?>>    <span>Construction</span><br>
                                <input type="checkbox" name="industry[]" value="3" <?php if(in_array('3',$industry)){?> checked="checked"<?php } ?>>    <span>Chemicals</span><br> 
                            </div>
                            <div class="iput_grp">
                                <input type="checkbox" name="industry[]" value="4"<?php if(in_array('4',$industry)){?> checked="checked"<?php } ?> >    <span>Textile /Garment</span><br>
                                <input type="checkbox" name="industry[]" value="5" <?php if(in_array('5',$industry)){?> checked="checked"<?php } ?>>    <span>Power Generation , Transmission & Distribution</span><br>
                                <input type="checkbox" name="industry[]" value="6"<?php if(in_array('6',$industry)){?> checked="checked"<?php } ?> >    <span>Financial Services</span><br> 
                            </div>
                            <div class="iput_grp">
                                <input type="checkbox" name="industry[]" value="7" <?php if(in_array('7',$industry)){?> checked="checked"<?php } ?>>    <span>Petrochemicals</span><br>
                                <input type="checkbox" name="industry[]" value="8" <?php if(in_array('8',$industry)){?> checked="checked"<?php } ?> >    <span>Consumer Durable Goods</span><br>
                                <input type="checkbox" name="industry[]" value="9" <?php if(in_array('9',$industry)){?> checked="checked"<?php } ?> >    <span>Food & Beverages</span><br> 
                            </div>
                            <div class="iput_grp">
                                <input type="checkbox" name="industry[]" value="10" <?php if(in_array('10',$industry)){?> checked="checked"<?php } ?>>  <span>Hotels & Hospitality</span><br>
                                <input type="checkbox" name="industry[]" value="11" <?php if(in_array('11',$industry)){?> checked="checked"<?php } ?>>  <span>Real estate</span><br>
                                <input type="checkbox" name="industry[]" value="12" <?php if(in_array('12',$industry)){?> checked="checked"<?php } ?>>  <span>Restaurants & Catering</span><br>
                            </div>
                            <div class="iput_grp">   
								<input type="checkbox" name="industry[]" value="13" <?php if(in_array('13',$industry)){?> checked="checked"<?php } ?>>  <span>Soaps and Detergents</span><br>                           
                                <input type="checkbox" name="industry[]" value="14" <?php if(in_array('14',$industry)){?> checked="checked"<?php } ?>>  <span>Personal care</span><br>
                                <input type="checkbox" name="industry[]" value="15" <?php if(in_array('15',$industry)){?> checked="checked"<?php } ?> >  <span>Paints and Pigments</span><br>
                             </div>
                            <div class="iput_grp">   
								<input type="checkbox" name="industry[]" value="16" <?php if(in_array('16',$industry)){?> checked="checked"<?php } ?> >  <span>Consumer and Industrial Electricals</span><br>                            
                                <input type="checkbox" name="industry[]" value="17" <?php if(in_array('17',$industry)){?> checked="checked"<?php } ?>>  <span>Automobile and Auto Component</span><br>
                                <input type="checkbox" name="industry[]" value="18" <?php if(in_array('18',$industry)){?> checked="checked"<?php } ?> >  <span>Aviation</span><br>
                            </div>
                            <div class="iput_grp">    
								<input type="checkbox" name="industry[]" value="19" <?php if(in_array('19',$industry)){?> checked="checked"<?php } ?>>  <span>Shipping & Ports</span><br>                           
                                <input type="checkbox" name="industry[]" value="20" <?php if(in_array('20',$industry)){?> checked="checked"<?php } ?>>  <span>Logistics and Transportation</span><br>
                                <input type="checkbox" name="industry[]" value="21" <?php if(in_array('21',$industry)){?> checked="checked"<?php } ?>>  <span>Agri Commodites & Agro Processing</span><br>
                             </div>
                            <div class="iput_grp">   
								<input type="checkbox" name="industry[]" value="22" <?php if(in_array('22',$industry)){?> checked="checked"<?php } ?>>  <span>Packaging and Films</span><br>                            
                                <input type="checkbox" name="industry[]" value="23" <?php if(in_array('23',$industry)){?> checked="checked"<?php } ?>>  <span>Media & Entertainment</span><br>
                                <input type="checkbox" name="industry[]" value="24" <?php if(in_array('24',$industry)){?> checked="checked"<?php } ?>>  <span>Information Technology Hardware</span><br>
                             </div>
                            <div class="iput_grp">   
								<input type="checkbox" name="industry[]" value="25" <?php if(in_array('25',$industry)){?> checked="checked"<?php } ?>>  <span>Information Technology Software</span><br>                          
                                <input type="checkbox" name="industry[]" value="26" <?php if(in_array('26',$industry)){?> checked="checked"<?php } ?>>  <span>BPO/KPO</span><br>
                                <input type="checkbox" name="industry[]" value="27" <?php if(in_array('27',$industry)){?> checked="checked"<?php } ?>>  <span>Telecom</span><br>
                                <input type="checkbox" name="industry[]" value="28" <?php if(in_array('28',$industry)){?> checked="checked"<?php } ?>>  <span>Retail</span><br> 
                                <input type="checkbox" name="industry[]" value="29" <?php if(in_array('29',$industry)){?> checked="checked"<?php } ?>>  <span>Infrastructure (roads, rail, airports )</span><br> 
                            </div>
                        </td>
                        
                        

                    </tr>
					<?php $loan_product = explode(",",$bank_filter[0]->loan_product);?>
                <tr><td style="font-weight:600; whitee-space:nowrap; color:#fff;">Loan Product(select Industry you DON'T want application from):</td></tr>
                    <tr>
                        <td>
                            <div class="iput_grp">
                                <input type="checkbox" name="loan_product[]" value="1"<?php if(in_array('1',$loan_product)){?> checked="checked"<?php } ?> ><span>Personal Loan</span><br>
                                <input type="checkbox" name="loan_product[]" value="2" <?php if(in_array('2',$loan_product)){?> checked="checked"<?php } ?>><span>Housing Loan</span><br>
                                <input type="checkbox" name="loan_product[]" value="3" <?php if(in_array('3',$loan_product)){?> checked="checked"<?php } ?>><span>Loan against Property</span><br>
                                <input type="checkbox" name="loan_product[]" value="4"<?php if(in_array('4',$loan_product)){?> checked="checked"<?php } ?> ><span>Vehicle Loan</span><br>
                            </div>
                            <div class="iput_grp">                                
                                
                                <input type="checkbox" name="loan_product[]" value="5" <?php if(in_array('5',$loan_product)){?> checked="checked"<?php } ?>><span>Education Loan</span><br>
                                <input type="checkbox" name="loan_product[]" value="6" <?php if(in_array('6',$loan_product)){?> checked="checked"<?php } ?>><span>Gold Loan</span><br>
                                <input type="checkbox" name="loan_product[]" value="7" <?php if(in_array('7',$loan_product)){?> checked="checked"<?php } ?>><span>Others</span><br>
                             </div>
                        </td>
                    </tr>
                <tr><td style="font-weight:600; whitee-space:nowrap; color:#fff;">Loan Amount (Rs. In Lakhs):</td></tr>
                    
                <tr><td style="line-height:20px; font-weight:600; whitee-space:nowrap;">
					
					Minimum :&nbsp&nbsp<input type="text" name="min_loan_amt" id="min_loan_amt" value="<?php if($bank_filter[0]->min_loan_amt >0){ echo $bank_filter[0]->min_loan_amt;}?>" class="module-input ">
                    
                    </td>
                    
                    <td style="line-height:20px; font-weight:600; whitee-space:nowrap;">
                       Maximum :&nbsp&nbsp<input type="text" name="max_loan_amt" id="max_loan_amt" value="<?php if($bank_filter[0]->max_loan_amt >0) { echo $bank_filter[0]->max_loan_amt;}?>" class="module-input ">
                    </td>                   
                    
                    </tr>
                  <tr><td><span id="span_amt"></span></td></tr>  
                                 
                </tbody>
                </table>
                </td>
              </tr>
        </tbody>
        </table>
		<div class="clear"></div>
		<input type="hidden" name="id" value="<?php echo $bank_filter[0]->id;?>"/>
		<input type="hidden" name="flag" value="1" />
		<hr class="yellow-hr">
        <div class="col-sm-3 top-padding10"><button type="submit" id="submit_btn" class="yellow-button btn-default">Submit</button></div>
        <div class="col-sm-3 top-padding10"><button type="button" id="cancel_btn" class="yellow-button btn-default">Cancel</button></div>


        </div>
      </div>
</form>
<?php } ?>
