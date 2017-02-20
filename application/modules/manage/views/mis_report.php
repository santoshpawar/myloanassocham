<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
<link href="<?php echo base_url(); ?>theme/assets/front/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url() ?>assets/front/js/jquery-ui.js"></script>
<link href="<?php echo base_url() ?>assets/front/css/jquery-ui.css" rel="stylesheet" type="text/css">
<style>
	span.requirederror{
		puser_detailsding-left:5px;
	}
</style>

<script type="text/javascript" src="<?php echo base_url() ?>assets/front/js/jquery.dataTables.min.js"></script><script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#DataTable1 tfoot .filterthd th.fltcl').each( function () {
    	var title = $(this).text();
        //$(this).html( '<input type="text" class="module-input" placeholder="Search '+title+'" />' );
        if(title.match('Date Applied'))
        {
        	$(this).html( '<input type="text" class="module-input applied_date" placeholder="Search '+title+'" />' );
        }else {
        	$(this).html( '<input type="text" class="module-input" placeholder="Search '+title+'" />' );
        }
    } );
    // DataTable
    var table = $('#DataTable1').DataTable();
    // Apply the search
    table.columns().every( function () {
    	var that = this;
    	$( 'input', this.footer() ).on( 'keyup change', function () {
    		if ( that.search() !== this.value ) {
    			that
    			.search( this.value )
    			.draw();
    		}
    	} );
    } );
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
    $('#min_amount,#max_amount').on('keyup blur input',function(){
    	var name=$(this).val();
    	name=name.replace(/[^0-9]+/g, '');
    	$(this).val(name);
    });
    $("#min_amount,#max_amount").on("keyup input blur",function(){
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
    $('#max_amount').on("keyup input blur",function(){
    	var max_amount = $(this).val();
    	var min_amount = $("#min_amount").val();
    	min_amount = min_amount.replace(/,/g,'');
    	max_amount = max_amount.replace(/,/g,'');
				//alert(min_loan_amt);
				//alert(max_loan_amt);
				if(max_amount !=""){
					if(parseInt(min_amount) > parseInt(max_amount))
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
    $('#min_amount').on("keyup input blur",function(){
    	var min_amount = $(this).val();
    	var max_amount = $("#max_amount").val();
    	min_amount = min_amount.replace(/,/g,'');
    	max_amount = max_amount.replace(/,/g,'');
				//alert(min_loan_amt);
				//alert(max_loan_amt);
				if(min_amount !=""){
					if(parseInt(min_amount) > parseInt(max_amount))
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
$('#DataTable1').dataTable({
    // display everything
    "lengthMenu": [ [10, 50, 100, -1], [10, 50, 100, "All"] ],
    "iDisplayLength": -1,
    "aaSorting": [[ 0, "desc" ]] // Sort by first column descending
});
$(function() {
	var dateToday = new Date();
	var yrRange = '1950' + ":" + (dateToday.getFullYear() - 18).toString();
	$(".applied_date").datepicker({
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
					//yearRange: yrRange
					minDate:"01-01-1900",
					maxDate: 'today',
				});
});
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
	.dataTables_filter {
		display: none;
		float: right;
		text-align: right;
	}
	input{
		color: black;
	}
</style>

<div class="comman-wrapper">
	<form method="post" action="<?php echo base_url(); ?>manage/dashboard/show_mis_report" id="hold_frm" class="divmargin" novalidate="novalidate">
		<div class="content-wrapper select">
			<div class="p100">
				<div class="col-sm-3"><h5>MIS Report</h5></div>
				<table class="table mixed">
					<tbody>
						<tr>
							<td>
								<table class="table sbitem">
									<tbody>
										<tr>
											<td>
												<div class="report_heading"><i class="fa fa-arrow-right" aria-hidden="true"></i>
													Datewise Report</div>
												</td>
											</tr>
											<tr>
												<td>
													Form :<input type="text" class="module-input" id="from_year" name="from_year" value="<?php if (isset($from_year) && $from_year != '') {echo $from_year;}?>" autocomplete="off">
												</td>
												<td>
													To :<input type="text" class="module-input" id="to_year" name="to_year" value="<?php if (isset($to_year) && $to_year != '') {echo $to_year;}?>" autocomplete="off">
												</td>
											</tr>
											<tr>
												<td>
													<div class="report_heading"><i class="fa fa-arrow-right" aria-hidden="true"></i>
														Status</div>
													</td>
												</tr>
												<tr>
													<td>
														<div class="iput_grp">
															<input type="checkbox" value="0" name="status[]" <?php if (isset($status) && in_array('0', $status)) {?> checked="checked"<?php }?>>    <span>Incomplete</span><br>
															<input type="checkbox" value="2" name="status[]" <?php if (isset($status) && in_array('2', $status)) {?> checked="checked"<?php }?>>    <span>Forwarded To Bank</span><br>
															<input type="checkbox" value="1" name="status[]" <?php if (isset($status) && in_array('1', $status)) {?> checked="checked"<?php }?>> <span>Forword To Analyst</span><br>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<div class="report_heading"><i class="fa fa-arrow-right" aria-hidden="true"></i>
															Bank Status</div>
														</td>
													</tr>
													<tr>
														<td>
															<div class="iput_grp">
																<input type="checkbox" value="1" name="bank_status[]" <?php if (isset($bank_status) && in_array('1', $bank_status)) {?> checked="checked"<?php }?>>    <span>In-principle approved</span><br>
																<input type="checkbox" value="0" name="bank_status[]" <?php if (isset($bank_status) && in_array('0', $bank_status)) {?> checked="checked"<?php }?>>    <span>Rejected</span><br>
															</div>
														</td>
													</tr>
													<tr>
														<td>
															<div class="report_heading"><i class="fa fa-arrow-right" aria-hidden="true"></i>
																Bank</div>
															</td>
														</tr>
														<tr>
															<td>
																<select class="module-select" id="bank_name" name="bank_name[]" multiple="multiple">
																	<option value="">--Select--</option>
																	<?php foreach ($bank_details as $val) {?>
																	<option value="<?php echo $val->bank_id; ?>" <?php if (isset($bank_name) && in_array($val->bank_id, $bank_name)) {?> selected <?php }?>><?php echo $val->bank_name; ?></option>
																	<?php }?>
																</select>
															</td>
														</tr>
														<tr>
															<td>
																<div class="report_heading"><i class="fa fa-arrow-right" aria-hidden="true"></i>
																	Location</div>
																</td>
															</tr>
															<tr>
																<td>
																	<div class="report_heading"><i class="fa fa-arrow-right" aria-hidden="true"></i>
																		State</div>
																		<select class="module-select" id="state" name="state">
																			<option value="">--Select--</option>
																			<?php
																			foreach ($state as $k => $st) {?>
																			<option value="<?php echo $st->id; ?>" <?php if (isset($states) && ($st->id == $states)) {?> selected <?php }?>><?php echo $st->name; ?> </option>
																			<?php }?>
																		</select>
																	</td>
																	<td>
																		<div class="report_heading"><i class="fa fa-arrow-right" aria-hidden="true"></i>
																			City</div>
																			<select class="module-select" id="city" name="city">
																			</select>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<div class="report_heading"><i class="fa fa-arrow-right" aria-hidden="true"></i>
																				Ticket Sizewise: (Loan Amount &#8377; in Lacs)</div>
																			</td>
																		</tr>
																		<tr>
																			<td>
																				Minimum :<input type="text" class="module-input" id="min_amount" name="min_amount" value="<?php if (isset($min_amount) && $min_amount != '') {echo $min_amount;}?>" autocomplete="off">
																			</td>
																			<td>
																				Maximum :<input type="text" class="module-input" id="max_amount" name="max_amount" value="<?php if (isset($max_amount) && $max_amount != '') {echo $max_amount;}?>" autocomplete="off">
																			</td>
																		</tr>
																		<tr>
																			<td>
																				<div class="report_heading"><i class="fa fa-arrow-right" aria-hidden="true"></i>
																					Industry:</div>
																				</td>
																			</tr>
																			<tr>
																				<td>
																					<select class="module-select" id="industry" name="industry[]" multiple="multiple">
																						<option value="">--Select--</option>
																						<option value="1" <?php if (isset($industry) && in_array('1', $industry)) {?> selected <?php }?>>Steel</option>
																						<option value="2"<?php if (isset($industry) && in_array('2', $industry)) {?> selected <?php }?>>Construction</option>
																						<option value="3"<?php if (isset($industry) && in_array('3', $industry)) {?> selected <?php }?>>chemicals</option>
																						<option value="4"<?php if (isset($industry) && in_array('4', $industry)) {?> selected <?php }?>>Textile /Garment</option>
																						<option value="5"<?php if (isset($industry) && in_array('5', $industry)) {?> selected <?php }?>>Power generation, Transmission & Distribution</option>
																						<option value="6"<?php if (isset($industry) && in_array('6', $industry)) {?> selected <?php }?>>Financial services</option>
																						<option value="7"<?php if (isset($industry) && in_array('7', $industry)) {?> selected <?php }?>>Petrochemicals</option>
																						<option value="8"<?php if (isset($industry) && in_array('8', $industry)) {?> selected <?php }?>>Consumer durable goods</option>
																						<option value="9"<?php if (isset($industry) && in_array('9', $industry)) {?> selected <?php }?>>Food & Beverages</option>
																						<option value="10"<?php if (isset($industry) && in_array('10', $industry)) {?> selected <?php }?>>Hotels & Hospitality</option>
																						<option value="11"<?php if (isset($industry) && in_array('11', $industry)) {?> selected <?php }?>>Real estate</option>
																						<option value="12"<?php if (isset($industry) && in_array('12', $industry)) {?> selected <?php }?>>Restaurants & Catering</option>
																						<option value="13"<?php if (isset($industry) && in_array('13', $industry)) {?> selected <?php }?>>Soaps & Detergents</option>
																						<option value="14"<?php if (isset($industry) && in_array('14', $industry)) {?> selected <?php }?>>Personal care</option>
																						<option value="15"<?php if (isset($industry) && in_array('15', $industry)) {?> selected <?php }?>>Paints & Pigments</option>
																						<option value="16"<?php if (isset($industry) && in_array('16', $industry)) {?> selected <?php }?>>Consumer & Industrial electricals</option>
																						<option value="17"<?php if (isset($industry) && in_array('17', $industry)) {?> selected <?php }?>>Automobile & Auto component</option>
																						<option value="18"<?php if (isset($industry) && in_array('18', $industry)) {?> selected <?php }?>>Aviation</option>
																						<option value="19"<?php if (isset($industry) && in_array('19', $industry)) {?> selected <?php }?>>Shipping & Ports</option>
																						<option value="20"<?php if (isset($industry) && in_array('20', $industry)) {?> selected <?php }?>>Logistics & Transportation</option>
																						<option value="21"<?php if (isset($industry) && in_array('21', $industry)) {?> selected <?php }?>>Agri commodites & Agro processing</option>
																						<option value="22"<?php if (isset($industry) && in_array('22', $industry)) {?> selected <?php }?>>Packaging & Films</option>
																						<option value="23"<?php if (isset($industry) && in_array('23', $industry)) {?> selected <?php }?>>Media & Entertainment</option>
																						<option value="24"<?php if (isset($industry) && in_array('24', $industry)) {?> selected <?php }?>>Information technology hardware</option>
																						<option value="25"<?php if (isset($industry) && in_array('25', $industry)) {?> selected <?php }?>>Information technology software</option>
																						<option value="26"<?php if (isset($industry) && in_array('26', $industry)) {?> selected <?php }?>>BPO/KPO</option>
																						<option value="27"<?php if (isset($industry) && in_array('27', $industry)) {?> selected <?php }?>>Telecom</option>
																						<option value="28"<?php if (isset($industry) && in_array('28', $industry)) {?> selected <?php }?>>Retail</option>
																						<option value="29"<?php if (isset($industry) && in_array('29', $industry)) {?> selected <?php }?>>Infrastructure (roads, rail, airports )</option>
																					</select>
																				</td>
																			</tr>
																			<tr>
																				<td>
																					<div class="report_heading"><i class="fa fa-arrow-right" aria-hidden="true"></i>
																						Organization</div>
																					</td>
																				</tr>
																				<tr>
																					<td>
																						<div class="iput_grp">
																							<input type="checkbox" value="Partnership Firm" name="organization[]" <?php if (isset($organization) && in_array('Partnership Firm', $organization)) {?> checked="checked"<?php }?>><span>Partnership Firm</span><br>
																							<input type="checkbox" value="Proprietorship" name="organization[]"<?php if (isset($organization) && in_array('Proprietorship', $organization)) {?> checked="checked"<?php }?>><span>Proprietorship</span><br>
																							<input type="checkbox" value="Pvt Ltd Company" name="organization[]"<?php if (isset($organization) && in_array('Pvt Ltd Company', $organization)) {?> checked="checked"<?php }?>><span>Pvt Ltd Company</span><br>
																						</div>
																					</td>
																					<td>
																						<div class="iput_grp">
																							<input type="checkbox" value="LLP" name="organization[]"<?php if (isset($organization) && in_array('LLP', $organization)) {?> checked="checked"<?php }?>><span>LLP</span><br>
																							<input type="checkbox" value="Trust" name="organization[]"<?php if (isset($organization) && in_array('Trust', $organization)) {?> checked="checked"<?php }?>><span>Trust</span><br>
																							<input type="checkbox" value="Hindu Undivided Family" name="organization[]"<?php if (isset($organization) && in_array('Hindu Undivided Family', $organization)) {?> checked="checked"<?php }?>><span>Hindu Undivided Family</span><br>
																						</div>
																					</td>
																				</tr>
																				<tr>
																					<td>
																						<div class="report_heading"><i class="fa fa-arrow-right" aria-hidden="true"></i>
																							Loan Product</div>
																						</td>
																					</tr>
																					<tr>
																						<td>
																							<div class="iput_grp">
																								<input type="checkbox" name="loan_product[]" value="1" <?php if (isset($loan_product) && in_array('1', $loan_product)) {?> checked="checked"<?php }?>><span>Personal Loan</span><br>
																								<input type="checkbox" name="loan_product[]" value="2" <?php if (isset($loan_product) && in_array('2', $loan_product)) {?> checked="checked"<?php }?>><span>Housing Loan</span><br>
																								<input type="checkbox" name="loan_product[]" value="3" <?php if (isset($loan_product) && in_array('3', $loan_product)) {?> checked="checked"<?php }?>><span>Loan against Property</span><br>
																								<input type="checkbox" name="loan_product[]" value="4" <?php if (isset($loan_product) && in_array('4', $loan_product)) {?> checked="checked"<?php }?>><span>Vehicle Loan</span><br>
																							</div>
																						</td>
																						<td>
																							<div class="iput_grp">
																								<input type="checkbox" name="loan_product[]" value="5" <?php if (isset($loan_product) && in_array('5', $loan_product)) {?> checked="checked"<?php }?>><span>Education Loan</span><br>
																								<input type="checkbox" name="loan_product[]" value="6" <?php if (isset($loan_product) && in_array('6', $loan_product)) {?> checked="checked"<?php }?>><span>Gold Loan</span><br>
																								<input type="checkbox" name="loan_product[]" value="7" <?php if (isset($loan_product) && in_array('7', $loan_product)) {?> checked="checked"<?php }?>><span>Others</span><br>
																							</div>
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td><!--1st td end here-->
																	</tr>
																</tbody>
															</table>
															<div class="col-sm-2 top-padding10"><button class="yellow-button btn-default" id="submit_btn" type="submit">Submit</button></div>
															<div class="col-sm-3 top-padding10"><button class="yellow-button btn-default"  value="1" name="download_btn" id="download_btn" type="submit">Download AS Excel</button></div>
															<div class="col-sm-3 top-padding10"><button class="yellow-button btn-default"  type="button">Reset</button></div>
														</div>
													</div>
												</form>
												<!---------------Start Loan List------------------------------>
												<?php if (isset($loan_list) && !empty($loan_list)) {
													?>
													<div id="loan" style="overflow:hidden; padding:0 20px;" >
														<div class="row">
															<form role="form" class="div-margin line-height40 white-links">
																<div class="col-sm-3">Loan Application <span  class="application-counter"><?php echo count($loan_list); ?></span></div>
																<div class="col-sm-6"></div>
																<div class="clear"></div>
																<table class="table table-striped table-advance table-hover dataTable" role="grid" aria-describedby="DataTable1_info" id="DataTable1">
																	<thead>
																		<tr>
																			<th class="text-center nosort">Reference ID
																				<br>
																				<div class="text-center up-down-arrows"><span class="arrow-up"></span><span class="arrow-down absolute"></span></div>
																			</th>
																			<th class="text-center nosort">MSME
																				<br>
																				<div class="text-center up-down-arrows"><span class="arrow-up"></span><span class="arrow-down absolute"></span></div>
																			</th>
																			<th class="text-center nosort">Channel Partner
																				<br>
																				<div class="text-center up-down-arrows"><span class="arrow-up"></span><span class="arrow-down absolute"></span></div>
																			</th>
																			<th class="text-center nosort">Date Applied
																				<br>
																				<div class="text-center up-down-arrows"><span class="arrow-up"></span><span class="arrow-down absolute"></span></div>
																			</th>
																			<th class="text-center nosort" style="width:15%;">Type of Facility
																				<br>
																				<div class="text-center up-down-arrows"><span class="arrow-up"></span><span class="arrow-down absolute"></span></div>
																			</th>
																			<th class="text-center nosort">PDF</th>
																			<th class="text-center nosort" style="width:15%;">Status</th>
																			<th class="text-center nosort">Action</th>
																		</tr>
																	</thead>
																	<tfoot style="display:table-row-group;">
																		<tr class="filterthd">
																			<th class="fltcl text-center">Reference ID
																			</th>
																			<th class="fltcl text-center">MSME
																			</th>
																			<th class="fltcl text-center">Channel Partner
																			</th>
																			<th class="fltcl text-center">Date Applied
																			</th>
																			<th class="fltcl text-center" style="width:15%;">Type of Facility
																			</th>
																			<th class="text-center">---</th>
																			<th class="text-center">---</th>
																			<th class="text-center">---</th>
																		</tr>
																	</tfoot>
																	<tbody>
																		<?php
																		$i = 1;
																		foreach ($loan_list as $row) {
																			?>
																			<?php $GMT = new DateTimeZone("GMT");
																			$date_post = new DateTime($row['created_dtm'], $GMT);
																			if ($row['type_of_facility'] == 1) {
																				$facility = "Personal Loan";
																			} else if ($row['type_of_facility'] == 2) {
																				$facility = "Housing Loan";
																			} else if ($row['type_of_facility'] == 3) {
																				$facility = "Loan against Property";
																			} else if ($row['type_of_facility'] == 4) {
																				$facility = "Vehicle Loan";
																			} else if ($row['type_of_facility'] == 5) {
																				$facility = "Education Loan";
																			} else if ($row['type_of_facility'] == 6) {
																				$facility = "Gold Loan";
																			} else if ($row['type_of_facility'] == 7) {
																				$facility = "Business Loan";
																			}else if ($row['type_of_facility'] == 8) {
																				$facility = "Others";
																			} else {
																				$facility = "";
																			}
																			?>
																			<tr>
																				<td><?php echo "#" . $row['application_id']; ?></td>
																				<td><?php echo $row['enterprise_name']; ?></td>
																				<td><?php echo $row['advisor_name']; ?></td>
																				<td><?php echo $date_post->format('d-m-Y H:i:s'); ?></td>
																				<td><?php echo $facility; ?></td>
																				<?php if ($row['status'] == 1 || $row['status'] == 2 || $row['status'] == 0) {?>
																				<td><a href="<?php echo base_url(); ?>uploads/loan_doc/Loan-Application-ID-<?php echo $row['application_id'] . ".pdf"; ?>" target="_blank"><img src="<?php echo base_url() ?>assets/front/images/pdf.png" width="25" alt=""/></a></td>
																				<?php } else {?>
																				<td><a href="javascript:void(0)"><img src="<?php echo base_url() ?>assets/front/images/pdf.png" width="25" alt=""/></a></td>
																				<?php }?>
																				<td><button id="modalbtn_<?php echo $row['application_id']; ?>" onclick="open_modal(<?php echo $row['application_id']; ?>);" data-app_id="<?php echo $row['application_id']; ?>" type="button" id="test" class="yellow-button"><strong>STATUS</strong></button>
																					<!-- Modal -->
																					<div id="myModal<?php echo $row['application_id']; ?>" class="modal fade" role="dialog">
																						<div class="modal-dialog width400">
																							<!-- Modal content-->
																							<div class="modal-content">
																								<div class="modal-header">
																									<button type="button" class="close" data-dismiss="modal">&times;</button>
																									<h5 class="red-text">Application Status of #<?php echo $row['application_id']; ?></h5>
																								</div>
																								<div class="modal-body">
																									<table class="table">
																										<tbody>
																											<tr class="appst">
																												<td><div class="app_st">Application Status:</div></td>
																												<td><div class="status-option approved"></div></td>
																											</tr>
																										</tbody>
																										<tbody class="bnknm">
																										</tbody>
																									</table>
																								</div>
																								<div class="modal-footer">
																									<button type="button" class="btn btn-default bn_dtls" data-dismiss="modal">Close</button>
																								</div>
																							</div>
																						</div>
																					</div>
																					<!--Modal Ended-->
																				</td>
																				<td class="edit-delete-icons"><a href="<?php echo base_url() ?>manage/dashboard/loan_application/<?php echo base64_encode($row["application_id"]); ?>" title="Edit"><i class="fa fa-pencil right-margin10"></i></a><a href="#" title="Delete"><i class="fa fa-close"></i></a></td>
																			</tr>
																			<?php $i++;}?>
																		</tbody>
																	</table>
																	<script>
																		function open_modal(uid){
																			var application_id=uid;
																			$.ajax({
																				type: "POST",
																				url: "<?php echo base_url() . "manage/dashboard/statusList"; ?>",
																				data: {application_id:+application_id},
																				success: function(data){
																					if(data)
																					{
																						if(data.loan_lists[0].status==0){
																							$('#myModal'+uid+' .appst td .status-option').html('Incomplete');
																							$('#myModal'+uid+' .bnknm').html('').hide();
																						}
																						else if(data.loan_lists[0].status==1){
																							$('#myModal'+uid+' .appst td .status-option').html('Forwarded To Analyst');
																							$('#myModal'+uid+' .bnknm').html('').hide();
																						}
																						else{
																							if(data.bank_list.length!=0){
																								$('#myModal'+uid+' .appst').hide();
																								$('#myModal'+uid+' .bnknm').html('').show();
																								for(var h=0; h<data.bank_list.length; h++){
																									var bnksts='';
																									if(data.bank_list[h].status==0){
																										bnksts='Rejected';
																										$('#myModal'+uid+' .bnknm').append('<tr><td>'+data.bank_list[h].bank_name+':</td><td><div class="status-option" style="background:#a5000e;">'+bnksts+'</div></td></tr>');
																									}
																									else{
																										bnksts='In-principle approved';
																										$('#myModal'+uid+' .bnknm').append('<tr><td>'+data.bank_list[h].bank_name+':</td><td><div class="status-option approved">'+bnksts+'</div></td></tr>');
																									}
																								}
																							}
																							else{
																								$('#myModal'+uid+' .appst td .status-option').html('Forwarded to bank');
																								$('#myModal'+uid+' .bnknm').html('').hide();
																							}
																						}
																						$('#myModal'+uid).modal('show');
							//$("#show").html(data);
						}
					}
				});
																		}
																	</script>
																</form>
															</div>
														</div>
														<?php }?>
														<!---------------End Loan List------------------------------>
													</div>
