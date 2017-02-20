<div class="row">
      <form id="hold_frm" id="agenceyapp" method="post" action="<?php echo base_url();?>manage/dashboard/save_details" class="div-margin">
		
		<div class="col-lg-6">Person Name:<br><input type="text" name="person_name" id="person_name" value="<?php echo $user_details[0]->person_name; ?>" class="module-input"></div>
		<div class="col-lg-6">Designation:<br><input type="text" name="designation" id="designation" value="<?php echo $user_details[0]->designation; ?>" class="module-input" placeholder="This will be your Login ID"></div>
        <div class="clear"></div>
		<div class="col-lg-6">Mobile No.:<br><input type="text" name="mobile_no" id="mobile_no" value="<?php echo $user_details[0]->mobile_no; ?>" class="module-input"></div>
		<div class="col-lg-6">Email Address:<br><input type="text" name="email_id" id="email_id" value="<?php echo $user_details[0]->email_id; ?>" class="module-input"></div>
        <div class="clear"></div>
		
		
		<div class="col-lg-6">Branch:<br><input type="text" name="branch" id="branch" value="<?php echo $user_details[0]->branch; ?>" class="module-input"></div>
        <div class="clear"></div>
		

		<!--<div class="col-lg-6">Select Password:<br><input type="password" id="new_password" name="password" class="module-input"></div>
		<div class="col-lg-6">Confirm Password:<br><input type="password" id="con_password" name="con_password" class="module-input"></div>-->
        <div class="clear"></div>
        <div class="col-lg-4"></div>
        <div class="col-lg-2 col-sm-6 col-xs-12 text-right" style="margin-top:15px;"><button type="submit" id="contact_btn" class="btn btn-default">Submit</button></div>
        <div class="col-lg-2 col-sm-6 col-xs-12" style="margin-top:15px;"><button type="button" class="btn btn-default">Cancel</button></div>
        <div class="col-lg-4"></div>
      </form>
    </div>



