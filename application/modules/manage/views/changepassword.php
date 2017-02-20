<style>
fieldset.bottomskywrapepr.bsn_adm img{
	left:260px;
}
fieldset.bottomskywrapepr.bsn_adm{
	margin-top:30px;
}
</style>
<div class="mainrigthpanel fr nospace_noborder_rightpanel greybg">
<h2 class="iframe_edit" style="margin:0;">Change Password <a class="exitbtn backbtn back_top" style="top:9px;" href="<?php echo base_url();?>manage/dashboard">Back</a></h2>
<form name="change_password_form" id="change_password_form" action="<?php echo base_url()?>manage/dashboard/changepassword" method="post">

<fieldset style="margin:0; padding:0;">

	<fieldset class="bottomskywrapepr bsn_adm">
	
		<legend>Information</legend>
		<img style="float:left; margin-top:10px; margin-bottom:10px;" width="25" height="auto" alt="" src="<?php echo base_url()?>assets/admin/images/info_big.png">
		
		
		<strong style="text-align:center; float:left; position:static; margin-top:10px; margin-bottom:10px;">Before you can use the system you must now change your password</strong>
		<?php if(isset($message)){echo '<span class="successmsg" style="float:right; margin-right:10px; margin-top:0; margin-top:4px; margin-bottom:0; line-height:26px; width:auto; padding:0 10px 0 0; font-size:13px;"><strong style="top:0;">'.$message.'</strong></span>' ;}?>
		<?php if(isset($error)){echo '<span class="error_message" style="float:right; margin-right:10px; margin-top:0; margin-top:4px; margin-bottom:0; line-height:26px; width:auto; padding:0 10px 0 0; font-size:13px;"><strong style="top:0;">'.$error.'</strong></span>' ;}?>
		</fieldset>
	
	<div class="spacer"></div>	
	
	<div class="spacer"></div>
		
	<div class="spacer"></div>	
	<label>Current Password <span class="red">*</span></label>
	<p class="fl"><input type="password" name="currpassword" id="currpassword" value="<?php echo set_value('currpassword'); ?>" class="text_type" /></p>
	<span style="color:#F00" class="requirederror fl"><?php echo form_error('currpassword'); ?></span>
	<br class="spacer" />
	<label>New Password <span class="red">*</span></label>
	<p class="fl"><input type="password" name="newpassword" id="newpassword" value="<?php echo set_value('newpassword');?>" class="text_type" /></p>
	<span style="color:#F00" class="requirederror fl"><?php echo form_error('newpassword'); ?></span>
	<br class="spacer" />
	<label>Confirm Password <span class="red">*</span></label>
	<p class="fl"><input type="password" name="conpassword" id="conpassword" value="<?php echo set_value('conpassword'); ?>" class="text_type" /></p>
	<span style="color:#F00" class="requirederror fl"><?php echo form_error('conpassword');?></span>
	<br class="spacer" />
	<p class="pass_change_btn"><input type="submit" name="change_password_submit" id="change_password_submit" value="Submit New Password" class="submit_bt" style="margin-left:0; padding-left:25px;" />
	
</fieldset>
</form>
</div>