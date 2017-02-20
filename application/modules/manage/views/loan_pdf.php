<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Loan Application ID <?php echo $enterprise_profile[0]->application_id;?> </title>
</head>

<body style="margin:0px; padding:0px; font-family:Calibri, Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;">
<div style="margin:0px auto; max-width:1170px; background:#ffffff; padding-bottom:25px;">
<div style="margin:0px auto; text-align:center; padding:20px 0px;"><img src="<?php echo base_url();?>assets/front/images/logo.png" style="max-width:100%;" alt=""></div>
<?php if(!empty($msme_details)){  ?>

<div style="margin:0px auto; text-align:center; padding:20px 0px;"><strong>From MSME: <?php echo $msme_details[0]->name;?> ref #<?php echo $enterprise_profile[0]->application_id;?></strong></div>

<?php } else { ?>
<div style="margin:0px auto; text-align:center; padding:20px 0px;"><strong>From Channel Partner: <?php echo $channel_name[0]->name;?> ref #<?php echo $enterprise_profile[0]->application_id;?></strong></div>
<?php } ?>


<table border="1" bordercolor="#C0C0C0" cellpadding="0" cellspacing="0" style="width:95%; line-height:35px; text-indent:10px; font-size:18px; margin:0px auto;">
	<tr style="background:#F8F8F8;">
		<td colspan="2"><h2 style="text-align:center; text-transform:uppercase; color:#db0c1e;">Enterprise Profile</h2></td>
	</tr>
	<tr style="background:#db0c1e;">
		<td colspan="2" style="text-align:center; color:#ffffff; text-transform:uppercase;"><strong>Enterprise Details</strong></td>
	</tr>
	<tr>
		<td style="width:60%;"><strong>Name of the Enterprise</strong></td>
		<td><?php echo $name_enterprise = isset($enterprise_profile)? $enterprise_profile[0]->name_enterprise: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>PAN No of Firm</strong></td>
		<td><?php echo $pan_enterprise = isset($enterprise_profile)? $enterprise_profile[0]->pan_enterprise: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Constitution</strong></td>
		<td><?php echo $legal_entity = isset($enterprise_profile)? $enterprise_profile[0]->legal_entity: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Name of Owner/Director</strong></td>
		<td><?php echo $name_of_owner = isset($enterprise_profile)? $enterprise_profile[0]->name_of_owner: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Owners Email id</strong></td>
		<td><?php echo $owner_email = isset($enterprise_profile)? $enterprise_profile[0]->owner_email: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Office Address</strong></td>
		<td><?php echo $name_enterprise = isset($enterprise_profile)? $enterprise_profile[0]->name_enterprise: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>State</strong></td>
		<td><?php echo $state = isset($state)? $state[0]->name: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>City</strong></td>
		<td><?php echo $city = isset($city)? $city[0]->name: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Pincode</strong></td>
		<td><?php echo $pincode = isset($enterprise_profile)? $enterprise_profile[0]->pincode: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Contact Numbers</strong></td>
		<td><?php echo $contact_numbers = isset($enterprise_profile)? $enterprise_profile[0]->contact_numbers: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Latest Audited Turnover (<img src="<?php echo base_url()?>assets/front/images/rupee.png" width="15px" height="15px" style="position:relative; margin-top:15px;" /> In Lacs)</strong></td>
		<td><?php echo $last_audited_trunover = isset($enterprise_profile[0]->last_audited_trunover)? $enterprise_profile[0]->last_audited_trunover: "-"; ?></td>
	</tr>
</table>
<br>
<?php if(!empty($loan_requirement)) {?>
<table border="1" bordercolor="#C0C0C0" cellpadding="0" cellspacing="0" style="width:95%; line-height:35px; text-indent:10px; font-size:18px; margin:0px auto;">
	<tr style="background:#F8F8F8;">
		<td colspan="2"><h2 style="text-align:center; text-transform:uppercase; color:#db0c1e;">Loan Requirement</h2></td>
	</tr>
	<tr style="background:#db0c1e;">
		<td colspan="2" style="text-align:center; color: #ffffff; text-transform:uppercase;"><strong>Details of Credit facilities</strong></td>
	</tr>
	<tr>
		<td style="width:60%;"><strong>Type of Facilities </strong></td>
		<td><?php //echo $facility = isset($loan_requirement[0]->type_of_facility)? $loan_requirement[0]->type_of_facility: ""; 
		if(isset($loan_requirement[0]->type_of_facility) && $loan_requirement[0]->type_of_facility=="1")
		{
			echo "Personal Loan";
		}else if(isset($loan_requirement[0]->type_of_facility) && $loan_requirement[0]->type_of_facility=="2")
		{
			echo "Housing Loan";
		}else if(isset($loan_requirement[0]->type_of_facility) && $loan_requirement[0]->type_of_facility=="3")
		{
			echo "Loan against Property";
		}else if(isset($loan_requirement[0]->type_of_facility) && $loan_requirement[0]->type_of_facility=="4")
		{
			echo "Vehicle Loan";
		}else if(isset($loan_requirement[0]->type_of_facility) && $loan_requirement[0]->type_of_facility=="5")
		{
			echo "Education Loan";
		}else if(isset($loan_requirement[0]->type_of_facility) && $loan_requirement[0]->type_of_facility=="6")
		{
			echo "Gold Loan";
		}else if(isset($loan_requirement[0]->type_of_facility) && $loan_requirement[0]->type_of_facility=="7")
		{
			echo "Business Loan";
		}else if(isset($loan_requirement[0]->type_of_facility) && $loan_requirement[0]->type_of_facility=="8")
		{
			echo "Others";
		}
		?>
		
		</td>
	</tr>
	<tr>
		<td><strong>Amount (<img src="<?php echo base_url()?>assets/front/images/rupee.png" width="15px" height="15px" style="position:relative; margin-top:15px;" /> in Lacs) </strong></td>
		<td><?php echo $amount = isset($loan_requirement[0]->Amount)? $loan_requirement[0]->Amount: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Purpose</strong></td>
		<td><?php echo $purpose = isset($loan_requirement[0]->purpose)? $loan_requirement[0]->purpose: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Tenure in Years:</strong></td>
		<td><?php echo $tenure = isset($loan_requirement[0]->tenure_in_years)? $loan_requirement[0]->tenure_in_years: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>State</strong></td>
		<td><?php echo @$re_state = isset($rec_state)? $rec_state[0]->name: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>City</strong></td>
		<td><?php echo @$re_city = isset($rec_city)? $rec_city[0]->name: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Branch where loan is required</strong></td>
		<td><?php echo $branch = isset($loan_requirement[0]->branch)? $loan_requirement[0]->branch: "-"; ?></td>
	</tr>
</table>
<?php } ?>
<br>
<?php if(!empty($enterprise_background)) {?>
<table border="1" bordercolor="#C0C0C0" cellpadding="0" cellspacing="0" style="width:95%; line-height:35px; text-indent:10px; font-size:18px; margin:0px auto;">
	<tr style="background:#F8F8F8;">
		<td colspan="2"><h2 style="text-align:center; text-transform:uppercase; color:#db0c1e;">Enterprise Background</h2></td>
	</tr>
	<tr style="background:#db0c1e;">
		<td colspan="2" style="text-align:center; color: #ffffff; text-transform:uppercase;"><strong>KYC Details</strong></td>
	</tr>
	<tr>
		<td style="width:60%;"><strong>PAN</strong></td>
		<td><?php echo $pan = isset($enterprise_background[0]->pan)? $enterprise_background[0]->pan: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>VAT</strong></td>
		<td><?php echo $vat = isset($enterprise_background[0]->vat)? $enterprise_background[0]->vat: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>CIN</strong></td>
		<td><?php echo $cin = isset($enterprise_background[0]->cin)? $enterprise_background[0]->cin: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Service Tax</strong></td>
		<td><?php echo $service_tax = isset($enterprise_background[0]->service_tax)? $enterprise_background[0]->service_tax: "-"; ?></td>
	</tr>
    <tr>
    	<td colspan="2" height="25"></td>
    </tr>
	<tr style="background:#db0c1e;">
		<td colspan="2" style="text-align:center; color: #ffffff; text-transform:uppercase;"><strong>Business Background</strong></td>
	</tr>
	<tr>
		<td><strong>Select Industry Segment</strong></td>
		<td>
		<?php 
		if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="1")
		{
			echo "Steel";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="2")
		{
			echo "Construction";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="3")
		{
			echo "chemicals";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="4")
		{
			echo "Textile /Garment";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="5")
		{
			echo "Power generation, Transmission & Distribution";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="6")
		{
			echo "Financial services";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="7")
		{
			echo "Petrochemicals";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="8")
		{
			echo "Consumer durable goods";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="9")
		{
			echo "Food & Beverages";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="10")
		{
			echo "Hotels & Hospitality";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="11")
		{
			echo "Real estate";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="12")
		{
			echo "Restaurants & Catering";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="13")
		{
			echo "Soaps & Detergents";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="14")
		{
			echo "Personal care";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="15")
		{
			echo "Paints & Pigments";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="16")
		{
			echo "Consumer & Industrial electricals";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="17")
		{
			echo "Automobile & Auto component";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="18")
		{
			echo "Aviation";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="19")
		{
			echo "Shipping & Ports";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="20")
		{
			echo "Logistics & Transportation";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="21")
		{
			echo "Agri commodites & Agro processing";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="22")
		{
			echo "Packaging & Films";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="23")
		{
			echo "Media & Entertainment";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="24")
		{
			echo "Information technology hardware";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="25")
		{
			echo "Information technology software";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="26")
		{
			echo "BPO/KPO";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="27")
		{
			echo "Telecom";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="28")
		{
			echo "Retail";
		}else if(isset($enterprise_background[0]->industry_segment) && $enterprise_background[0]->industry_segment=="29")
		{
			echo "Infrastructure (roads, rail, airports )";
		}
		
		?>
		</td>
	</tr>
	<tr>
		<td><strong>Date of Establishment</strong></td>
		<td><?php echo $date_of_establishment = isset($enterprise_background[0]->date_of_establishment)? $enterprise_background[0]->date_of_establishment: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Address of Factory Shop Line 1</strong></td>
		<td><?php echo $adress1 = isset($enterprise_background[0]->adress1)? $enterprise_background[0]->adress1: "-"; ?></td>
    </tr>
	<tr>
		<td><strong>Address Line 2</strong></td>
		<td><?php echo $adress2 = isset($enterprise_background[0]->adress2)? $enterprise_background[0]->adress2: "-"; ?></td>
    </tr>
	<tr>
		<td><strong>Business Activity</strong></td>
		<td>
		<?php 
		if(!empty($enterprise_background[0]->existing_activity) && $enterprise_background[0]->existing_activity=="manufacturing")
		{
			echo "Manufacturing";
		}else if(!empty($enterprise_background[0]->existing_activity) && $enterprise_background[0]->existing_activity=="trading")
		{
			echo "Trading";
		}else if(!empty($enterprise_background[0]->existing_activity) && $enterprise_background[0]->existing_activity=="retail")
		{
			echo "Retails";
		}else if(!empty($enterprise_background[0]->existing_activity) && $enterprise_background[0]->existing_activity=="services")
		{
			echo "Services";
		}else if(!empty($enterprise_background[0]->existing_activity) && $enterprise_background[0]->existing_activity=="small business")
		{
			echo "Small business";
		}else if(!empty($enterprise_background[0]->existing_activity) && $enterprise_background[0]->existing_activity=="construction contractor")
		{
			echo "Construction contractor";
		}
		?>
		</td>
    </tr>
	<tr>
		<td><strong>Amount invested in Plants &amp; Machinery</strong></td>
		<td><?php echo $amount_invested_plant_machinery = isset($enterprise_background[0]->amount_invested_plant_machinery)? $enterprise_background[0]->amount_invested_plant_machinery: "-"; ?></td>
    </tr>
	<tr>
		<td><strong>Amount invested in Equipments</strong></td>
		<td><?php echo $amount_invested_equipments = isset($enterprise_background[0]->amount_invested_equipments)? $enterprise_background[0]->amount_invested_equipments: "-"; ?></td>
    </tr>
	<tr>
		<td><strong>What is your geographical area of Operation/Sales</strong></td>
		<td><?php echo $geographical_areas = isset($enterprise_background[0]->geographical_areas)? $enterprise_background[0]->geographical_areas: "-"; ?></td>
    </tr>
	<tr>
		<td><strong>No of states you are operating?</strong></td>
		<td>
		
		<?php 
		if(!empty($enterprise_background[0]->no_of_operating_states) && $enterprise_background[0]->no_of_operating_states=="Single State")
		{
			echo "Single State";
		}else if(!empty($enterprise_background[0]->no_of_operating_states) && $enterprise_background[0]->no_of_operating_states=="Multi State")
		{
			echo "Multi State";
		}
		?>
		
		</td>
	</tr>
    <tr>
    	<td colspan="2" height="25"></td>
    </tr>
	<tr style="background:#db0c1e;">
		<td colspan="2" style="text-align:center; color: #ffffff; text-transform:uppercase;"><strong>Customer/ Sales Details</strong></td>
	</tr>
	<tr>
		<td style="width:60%;"><strong>Are your Sales?</strong></td>
		<td>
		<?php 
		if($enterprise_background[0]->are_you_sales == "0")
		{
			echo "Domestic";
		}else if($enterprise_background[0]->are_you_sales == "1")
		{
			echo "Export";
		}else if($enterprise_background[0]->are_you_sales == "2")
		{
			echo "Both";
		}
		?>
			
		</td>
	</tr>
	<tr>
		<td><strong>Are Your Sales to a?</strong></td>
		<td>
		<?php 
		if($enterprise_background[0]->are_you_sales_a == "0")
		{
			echo "Large Company";
		}else if($enterprise_background[0]->are_you_sales_a == "1")
		{
			echo "Small Medium Enterprise	";
		}else if($enterprise_background[0]->are_you_sales_a == "2")
		{
			echo "Retail Customer";
		}
		?>
		</td>
	</tr>
	<tr>
		<td><strong>Key Products/Services Offered</strong></td>
		<td><?php echo $key_products_services = isset($enterprise_background[0]->key_products_services)? $enterprise_background[0]->key_products_services: "-"; ?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($owner_details)) {?>
<?php foreach($owner_details as $value){?>
<br>
<table border="1" bordercolor="#C0C0C0" cellpadding="0" cellspacing="0" style="width:95%; line-height:35px; text-indent:10px; font-size:18px; margin:0px auto;">
	<tr style="background:#F8F8F8;">
		<td colspan="2"><h2 style="text-align:center; text-transform:uppercase; color:#db0c1e;">Promoter Details</h2></td>
	</tr>
	<tr style="background:#db0c1e;">
		<td colspan="2" style="text-align:center; color: #ffffff; text-transform:uppercase;"><strong>Promoter/Director KYC Details</strong></td>
	</tr>
	<tr style="background:#ff9900;">
		<td colspan="2" style="text-align:center; color: #ffffff; text-transform:uppercase;"><strong>Main Promoters / Director [+]</strong></td>
	</tr>
	<tr>
		<td style="width:60%;"><strong>Name</strong></td>
		<td><?php echo $valuename = isset($value->name)? $value->name: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>DOB</strong></td>
		<td><?php echo date('d-m-Y',strtotime($value->dob));?></td>
	</tr>
	<tr>
		<td><strong>Father / Spouse name</strong></td>
		<td><?php echo $valuefather_name = isset($value->father_name)? $value->father_name: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Academic qualification</strong></td>
		<td><?php echo $valueacademic_qualification = isset($value->academic_qualification)? $value->academic_qualification: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>PAN</strong></td>
		<td><?php echo $valueapan = isset($value->pan)? $value->pan: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Residential Address</strong></td>
		<td><?php echo $valueresidentail_address = isset($value->residentail_address)? $value->residentail_address: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>State</strong></td>
		<td><?php echo $valuereowner_state = isset($owner_state[0]->name)? $owner_state[0]->name: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Pincode</strong></td>
		<td><?php echo $valueapincode = isset($value->pincode)? $value->pincode: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Address Proof Type</strong></td>
		<td><?php echo $valueadress_proof_type = isset($value->adress_proof_type)? $value->adress_proof_type: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Address proof ID</strong></td>
		<td><?php echo $valueaddress_proof_id = isset($value->address_proof_id)? $value->address_proof_id: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Mobile no</strong></td>
		<td><?php echo $valueaddmobile_no = isset($value->mobile_no)? $value->mobile_no: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Landline no</strong></td>
		<td><?php echo $valueaddlandline_no = isset($value->landline_no)? $value->landline_no: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Experience in line of activity</strong></td>
		<td><?php echo $valueaddexp_in_line_activity = isset($value->exp_in_line_activity)? $value->exp_in_line_activity: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Does promoter have other sources of income?</strong></td>
		<td><?php echo $valueaddsouce_of_other_income = isset($value->souce_of_other_income)? $value->souce_of_other_income: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Do you know you CIBIL Score? </strong></td>
		<td><?php if($value->know_cibil_score=='Y') { echo "Yes"; }else{ echo "No";}?></td>
	</tr>
	<?php if($value->know_cibil_score=='Y') {?>
	<tr>
		<td><strong>CIBIL Score</strong></td>
		<td><?php echo $value->cibil_score;?></td>
	</tr>
	<?php } ?>
	<tr>
		<td><strong>Whether belong to SC/ST/Minority</strong></td>
		<td><?php if($value->cast=='Yes') { echo "Yes"; }else{ echo "No";}?></td>
	</tr>
	<?php if($value->cast=='Yes') {?>
	<tr>
		<td><strong>Please specify if yes</strong></td>
		<td><?php if($value->please_specify=='0') { echo "SC"; }else if($value->please_specify=='1') { echo "ST"; }else{ echo "Minority";}?></td>
	</tr>
	<?php } ?>
</table>
<?php } }?>
<?php if(!empty($banking_credit_facilities)){?>
<?php foreach($banking_credit_facilities as $credit_facilities){?>
<br>
<table border="1" bordercolor="#C0C0C0" cellpadding="0" cellspacing="0" style="width:95%; line-height:35px; text-indent:10px; font-size:18px; margin:0px auto;">
	<tr style="background:#F8F8F8;">
		<td colspan="2"><h2 style="text-align:center; text-transform:uppercase; color:#db0c1e;">Banking / Credit Facilities</h2></td>
	</tr>
	<tr style="background:#db0c1e;">
		<td colspan="2" style="text-align:center; color: #ffffff; text-transform:uppercase;"><strong>Banking / Credit Facilities (Existing)</strong></td>
	</tr>
	<tr>
		<td style="width:60%;"><strong>Type of facility</strong></td>
		<td>
		<?php 
		if(isset($credit_facilities->type_of_facility) && $credit_facilities->type_of_facility=="1")
		{
			echo "Personal Loan";
		}else if(isset($credit_facilities->type_of_facility) && $credit_facilities->type_of_facility=="2")
		{
			echo "Housing Loan";
		}else if(isset($credit_facilities->type_of_facility) && $credit_facilities->type_of_facility=="3")
		{
			echo "Loan against Property";
		}else if(isset($credit_facilities->type_of_facility) && $credit_facilities->type_of_facility=="4")
		{
			echo "Vehicle Loan";
		}else if(isset($credit_facilities->type_of_facility) && $credit_facilities->type_of_facility=="5")
		{
			echo "Education Loan";
		}else if(isset($credit_facilities->type_of_facility) && $credit_facilities->type_of_facility=="6")
		{
			echo "Gold Loan";
		}else if(isset($credit_facilities->type_of_facility) && $credit_facilities->type_of_facility=="7")
		{
			echo "Business Loan";
		}else if(isset($credit_facilities->type_of_facility) && $credit_facilities->type_of_facility=="8")
		{
			echo "Others";
		}
		?>
		</td>
	</tr>
	<tr>
		<td><strong>Limits</strong></td>
		<td><?php echo $valueaddsoucelimits = isset($credit_facilities->limits)? $credit_facilities->limits: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Outstanding as on</strong></td>
		<td><?php echo date('d-m-Y',strtotime($credit_facilities->outstanding_as_on)); ?></td>
	</tr>
	<tr>
		<td><strong>Name Of Bank/NBFC</strong></td>
		<td><?php echo $valueaddname_of_bank = isset($credit_facilities->name_of_bank)? $credit_facilities->name_of_bank: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Security Provided</strong></td>
		<td><?php 
		if(isset($credit_facilities->security_lodged) && $credit_facilities->security_lodged=="2")
		{
			echo "Property";
		}
		?>
		
		</td>
	</tr>
	<?php if($credit_facilities->security_lodged==2){?>
	<tr>
		<td><strong>Type of Property</strong></td>
		<td><?php 
			if(isset($credit_facilities->if_property_selected) && $credit_facilities->if_property_selected=="1")
			{
				echo "Residential Flat";
			}else if(isset($credit_facilities->if_property_selected) && $credit_facilities->if_property_selected=="2")
			{
				echo "Commercial/Office";
			}else if(isset($credit_facilities->if_property_selected) && $credit_facilities->if_property_selected=="3")
			{
				echo "Land(Non Agriculture)";
			}else if(isset($credit_facilities->if_property_selected) && $credit_facilities->if_property_selected=="4")
			{
				echo "Land(Agriculture)";
			}
		?>
		</td>
	</tr>
	
	
	<tr>
		<td><strong>Current Market Value (<img src="<?php echo base_url()?>assets/front/images/rupee.png" width="15px" height="15px" style="position:relative; margin-top:15px;" /> in Lacs)</strong></td>
		<td><?php echo $valueaddcurrent_market_value = isset($credit_facilities->current_market_value)? $credit_facilities->current_market_value: "-"; ?></td>
	
	</tr>
	<?php } ?>
	<tr>
		<td><strong>Rate of Interest</strong></td>
		<td><?php echo $valueaddrate_of_interest = isset($credit_facilities->rate_of_interest)? $credit_facilities->rate_of_interest: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Monthly EMI Amount(<img src="<?php echo base_url()?>assets/front/images/rupee.png" width="15px" height="15px" style="position:relative; margin-top:15px;" /> in thousand)</strong></td>
		<td><?php echo $valueaddmonthly_emi_amount = isset($credit_facilities->monthly_emi_amount)? $credit_facilities->monthly_emi_amount: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Balance Tenture (Years)</strong></td>
		<td><?php echo $valueaddbalance_tenure = isset($credit_facilities->balance_tenure)? $credit_facilities->balance_tenure: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Does owner have other source of income</strong></td>
		<td><?php echo $valueaddother_source_income = isset($credit_facilities->other_source_income)? $credit_facilities->other_source_income: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Annual Income From other Sources(<img src="<?php echo base_url()?>assets/front/images/rupee.png" width="15px" height="15px" style="position:relative; margin-top:15px;" /> In Lacs)</strong></td>
		<td><?php echo $valueaddother_annual_income = isset($credit_facilities->other_annual_income)? $credit_facilities->other_annual_income: "-"; ?></td>
	</tr>
	<tr>
		<td><strong>Repayment terms</strong></td>
		<td><?php echo $valueaddrepayment_terms = isset($credit_facilities->repayment_terms)? $credit_facilities->repayment_terms: "-"; ?></td>
	</tr>
	<tr style="background:#ff9900;">
		<td colspan="2" style="text-align:center; color: #ffffff; text-transform:uppercase;"><strong>Additional Loan Information</strong></td>
	</tr>
	<tr>
		<td><strong>What is additional monthly interest + EMI liability that business can service? (<img src="<?php echo base_url()?>assets/front/images/rupee.png" width="15px" height="15px" style="position:relative; margin-top:15px;" /> Lacs)</strong></td>
		<td><?php echo $valueaddadditional_loan_information = isset($credit_facilities->additional_loan_information)? $credit_facilities->additional_loan_information: "-"; ?></td>
	</tr>
</table>
<?php } } ?>
<?php if(!empty($upload_documents)){?>
<br>
<table border="1" bordercolor="#C0C0C0" cellpadding="0" cellspacing="0" style="width:95%; line-height:35px; text-indent:10px; font-size:18px; margin:0px auto;">
	<tr style="background:#F8F8F8;">
		<td colspan="2"><h2 style="text-align:center; text-transform:uppercase; color:#db0c1e;">Upload Documents</h2></td>
	</tr>
	<tr style="background:#db0c1e;">
		<td colspan="2" style="text-align:center; color: #ffffff; text-transform:uppercase;"><strong>Company KYC and financials</strong></td>
	</tr>
	<tr style="background:#ff9900;">
		<td colspan="2" style="text-align:center; color: #ffffff; text-transform:uppercase;"><strong>Bank Statement [+]</strong></td>
	</tr>
	<?php foreach($upload_add_more as $upload_add){ ?>
	<tr>
		<td style="width:60%;"><strong>Name of Bank</strong></td>
		<td><?php echo $upload_add->bank_name;?></td>
	</tr>
	<tr>
		<td><strong>Period for Month/Year</strong></td>
		<td><?php echo date("d-m-Y", strtotime($upload_add->period_from_month)); ?> To <?php echo date("d-m-Y", strtotime($upload_add->period_to_month)); ?></td>
	</tr>
	<tr>
		<td><strong>Upload File</strong></td>
		<td><?php if($upload_add->upload_file!=''){ echo "Attached";}?></td>
	</tr>
    <tr>
    	<td colspan="2" height="25"></td>
    </tr>
	<?php } ?>
	<tr style="background:#ff9900;">
		<td colspan="2" style="text-align:center; color: #ffffff; text-transform:uppercase;"><strong>CIBIL Report</strong></td>
	</tr>
	<tr>
		<td><strong>CIBIL report (optional)</strong></td>
		<td><?php if($upload_documents[0]->cibil_report!=""){ echo "Attached";}?></td>
	</tr>
    <tr>
    	<td colspan="2" height="25"></td>
    </tr>
	<tr style="background:#ff9900;">
		<td colspan="2" style="text-align:center; color: #ffffff; text-transform:uppercase;"><strong>KYC Details</strong></td>
	</tr>
	<tr>
		<td><strong>PAN Card</strong></td>
		<td><?php if($upload_documents[0]->pan_card!=""){ echo "Attached";}?></td>
	</tr>
	<tr>
		<td><strong>Address Proof of Company Business</strong></td>
		<td><?php if($upload_documents[0]->address_proof_company!=""){ echo "Attached";}?></td>
	</tr>
	<tr>
		<td><strong>VAT Registration Certificate</strong></td>
        <td><?php if($upload_documents[0]->vat_registration_certificate!=""){ echo "Attached";}?></td>
	</tr>
	<tr>
		<td><strong>Shop and Establishment Certificate</strong></td>
		<td><?php if($upload_documents[0]->shop_establishment_certificate!=""){ echo "Attached";}?></td>
	</tr>
	<tr>
		<td><strong>Do you want to add additional documents(Y/N)</strong></td>
		<td><?php if($upload_documents[0]->add_additional_documents=="0"){ echo "No";} else{ echo "Yes";}?></td>
	</tr>
    <tr>
    	<td colspan="2" height="25"></td>
    </tr>
	<tr style="background:#db0c1e; color:#ffffff; text-align:center; text-transform:uppercase;">
		<td colspan="2"><strong>Promoter KYC and financials</strong></td>
	</tr>
	<?php foreach($owner_documents as $ownervalues ){ ?>
		<tr>
		<td><strong>Owner Name</strong></td>
		<td><?php if($owner_name!=""){ echo $owner_name;}?></td>
	</tr>
	<tr>
		<td><strong>PAN Card</strong></td>
		<td><?php if($ownervalues->pan_card1!=""){ echo "Attached";}?></td>
	</tr>
	<tr>
		<td><strong>Address Proof</strong></td>
		<td><?php if($ownervalues->address_proof1!=""){ echo "Attached";}?></td>
	</tr>
	<tr>
		<td><strong>Cibil Score</strong></td>
		<td><?php if($ownervalues->civil_score1!=""){ echo "Attached";}?></td>
	</tr>
	<?php }  ?>
</table>
<?php } ?>
<?php if(!empty($analyst_documents)){?>
<br>
<table border="1" bordercolor="#C0C0C0" cellpadding="0" cellspacing="0" style="width:95%; line-height:35px; text-indent:10px; font-size:18px; margin:0px auto;">
	<tr style="background:#F8F8F8;">
		<td colspan="2"><h2 style="text-align:center; text-transform:uppercase; color:#db0c1e;">Analyst</h2></td>
	</tr>
	<tr style="background:#db0c1e;">
		<td colspan="2" style="text-align:center; color: #ffffff; text-transform:uppercase;"><strong>Application Status</strong></td>
	</tr>
	<tr>
		<td style="width:60%;"><strong>PAN details</strong></td>
		<td><?php if($analyst_documents[0]->pan_card_file!=''){ echo "Attached";}?></td>
	</tr>
	<tr>
		<td><strong>Address Proof of Company Business</strong></td>
		<td><?php if($analyst_documents[0]->address_proof_company_file!=''){ echo "Attached";}?></td>
	</tr>
	<tr>
		<td><strong>VAT Registration Certificate</strong></td>
		<td><?php if($analyst_documents[0]->vat_registration_certificate_file!=''){ echo "Attached";}?></td>
	</tr>
	<tr>
		<td><strong>Shop Establishment Certificate</strong></td>
        <td><?php if($analyst_documents[0]->shop_establishment_certificate_file!=''){ echo "Attached";}?></td>
	</tr>
	<tr>
		<td><strong>CIBIL Report</strong></td>
		<td><?php if($analyst_documents[0]->cibil_report_file!=''){ echo "Attached";}?></td>
	</tr>
	<tr>
		<td><strong>Defaulter List</strong></td>
        <td><?php if($analyst_documents[0]->defaulter_list=='1'){ echo "No";}else{ echo "Yes";}?></td>
	</tr>
    <tr>
    	<td colspan="2" height="25"></td>
    </tr>
	<tr style="background:#db0c1e;">
		<td colspan="2" style="text-align:center; color: #ffffff; text-transform:uppercase;"><strong>Verification Of Owner</strong></td>
	</tr>
	<?php if(!empty($analyst_director_documents)){?>
	<?php foreach($analyst_director_documents as $analystdirector){?>
	<tr>
		<td><strong>Owner Name</strong></td>
		<td><?php if($owner_name!=""){ echo $owner_name;}?></td>
	</tr>
	<tr>
		<td><strong>Address</strong></td>
		<td><?php if($analystdirector->director1_name_address_file!=''){ echo "Attached";}?></td>
	</tr>
	<tr>
		<td><strong>ID</strong></td>
		<td><?php if($analystdirector->director1_name_file!=''){ echo "Attached";}?></td>
	</tr>
	<tr>
		<td><strong>CIBIL</strong></td>
        <td><?php if($analystdirector->director1_name_cibilscore!=''){ echo "Attached";}?></td>
	</tr>
	<?php } } ?>
</table>
<?php }?>
<?php if(!empty($bank_application)){?>
<br>
<table border="1" bordercolor="#C0C0C0" cellpadding="0" cellspacing="0" style="width:95%; line-height:35px; text-indent:10px; font-size:18px; margin:0px auto;">
	<tr style="background:#F8F8F8;">
		<td colspan="2"><h2 style="text-align:center; text-transform:uppercase; color:#db0c1e;">Bank </h2></td>
	</tr>
	<tr style="background:#db0c1e;">
		<td colspan="2" style="text-align:center; color:#ffffff; text-transform:uppercase;"><strong>Bank Module</strong></td>
	</tr>
	<?php foreach($bank_application as $bankapp){?>
	<tr>
		<td style="width:60%;"><strong>Status of Application</strong></td>
		<td><?php if($bankapp->status=="1"){ echo "In-principle approved";}else{echo "Rejected";}?></td>
	</tr>
	<tr>
		<td><strong>Comment</strong></td>
		<td><?php if($bankapp->comment!=''){ echo $bankapp->comment ; } ?></td>
	</tr>
	<tr>
		<td><strong>Branch Details</strong></td>
		<td><?php if($bankapp->branch_details!=''){ echo $bankapp->branch_details; }?></td>
	</tr>
	<tr>
		<td><strong>Person to Contact</strong></td>
		<td><?php if($bankapp->preson_name!=''){ echo $bankapp->preson_name; } ?></td>
	</tr>
	<tr>
		<td><strong>Contact Person Mobile No.</strong></td>
		<td><?php if($bankapp->person_mobile_no!=''){ echo $bankapp->person_mobile_no; }  ?></td>
	</tr>
	<tr>
		<td><strong>Contact Person Email ID</strong></td>
		<td><?php if($bankapp->email_id!=''){ echo $bankapp->email_id; } ?></td>
	</tr>
	<?php } ?>
</table>
<?php } ?>
</div>
</body>
</html>
