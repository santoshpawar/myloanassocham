<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smeniwas</title>
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery-latest.js"></script>
<link href="<?php echo base_url()?>assets/admin/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>assets/admin/css/lightbox_form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(function(){
	$("select").css({opacity:0});
	//$('select').find('option:first').attr('seleted', 'seleted');
			
	$('select').change(function(){
		var attr = $(this).find("option:selected").text();
		$(this).parents('p').find("span.selectwrapper").text(attr);
	});
	$('select').each(function(){
		var attr = $(this).find("option:selected").text();
		$(this).parents('p').find("span.selectwrapper").text(attr);
	});
	
	$('#username').focus();
});

	function goBrowser(browserName){
		if(browserName=="firefox"){
			var goUrl='https://www.mozilla.org/en-GB/firefox/new/';
		}
		else if(browserName=="chrome"){
			var goUrl='https://www.google.co.uk/chrome/browser/desktop/';
		}
		else if(browserName=="safari"){
			var goUrl='https://support.apple.com/downloads/safari';
		}
		else if(browserName=="opera"){
			var goUrl='http://www.opera.com/computer/windows';
		}
		window.open(goUrl);
	}
</script>



<style>
fieldset label {
	float: left;
    font-size: 12px;
    font-weight: bold;
    padding-right: 10px;
    text-align: right;
    width: 130px;
}
span.requirederror p{
	width:100px;
}
span.requirederror{
	width:110px;
	padding-left:2px;
}
fieldset span.selectwrapper{
	width:214px;
	height:26px;
}
</style>

</head>

<body class="main">
<!--wrapper-->
<div class="outerwrapper">   
	<div class="wrapper">

<div class="header">
<a href="<?php echo base_url();?>manage/dashboard"><!--<img src="<?php echo base_url();?>assets/admin/images/logo.png" class="logo" alt="">--></a>
</div>
<br />

<!--mainbody-->
<div class="mainbody">
<span style="color:#0C3; text-align:center;font-family:Verdana, Geneva, sans-serif; font-size:18px; margin:0px 0px 0px 250px"><?php echo $this->session->flashdata('notification'); ?></span>
<?php if($this->session->flashdata('block')!='') { ?>
<span style="background: red none repeat scroll 0 0; border-radius: 10px; color: #fff; display: block; font-family: Verdana,Geneva,sans-serif; font-size: 11px; margin: 0 auto; max-width: 525px; padding: 5px 0; text-align: center;"><?php echo $this->session->flashdata('block'); ?></span>
<?php } ?>
<div class="middleform" style="margin:0 auto; width:53%; float:none;">
<form action="" method="post">
<fieldset class="bottomskywrapepr login">
<legend class="login_ico">Login</legend>

<br />
<div class="chckloginerr"><?php echo form_error('temp'); ?></div>
<!---
<label>Login As :</label>
<p><span class="selectwrapper">Select</span>
    <span class="select_icon"></span> 
<select name="user_type" id="user_type">
  <option value="1" <?php echo(isset($_POST['user_type'])&&($_POST['user_type']=='1')?' selected="selected"':'');?>>MSME</option>
  <option value="2" <?php echo(isset($_POST['user_type'])&&($_POST['user_type']=='2')?' selected="selected"':'');?>>Channel Partner</option>
  <option value="3" <?php echo(isset($_POST['user_type'])&&($_POST['user_type']=='3')?' selected="selected"':'');?>>Analyst</option>
  <option value="4" <?php echo(isset($_POST['user_type'])&&($_POST['user_type']=='4')?' selected="selected"':'');?>>Bank</option>
  <option value="5" <?php echo(isset($_POST['user_type'])&&($_POST['user_type']=='5')?' selected="selected"':'');?>>Admin</option>
</select></p>
<br class="spacer" />
-->
<br/>
<input name="temp" id="temp" value="" type="hidden" />
<label>Email ID/Mobile :</label>
<p><input name="email_id" id="email_id" value="<?php echo set_value('email_id'); ?>" type="text" maxlength="255" /></p>
<span style="color:#F00" class="requirederror"><?php echo form_error('email_id'); ?></span>
<br class="spacer" />
<br />
<label>Password :</label> <p><input name="password" id="password" value="<?php echo set_value('password'); ?>" type="password" maxlength="255" /></p>
<span style="color:#F00" class="requirederror"><?php echo form_error('password'); ?></span>
<br class="spacer" />
<br />
<label></label><p> <input name="" type="submit" class="submit_bt" value="Login" /></p>
<br class="spacer" />
<br />
<label></label><p><a  href="<?php echo base_url()?>manage/login/forgetpass" class="forgotpass" onclick="forget()">Forgot Password?</a></p>
<br class="spacer" />
</fieldset>
</form>
</div>
<br />
</div>
<!--mainbody end-->
<br class="spacer" />
<div class="footer">

<p>
<span class="fr">&copy; Copyright <?php echo date("Y");?> Smeniwas All Rights Reserved</span></p>

</div>
<div class="browserrecom">Best viewed in <span onclick="goBrowser('firefox')">Firefox</span>, <span onclick="goBrowser('chrome')">Chrome</span>, <span onclick="goBrowser('safari')">Safari</span> and <span onclick="goBrowser('opera')">Opera</span>.</div>
</div>
</div>

<!--wrapper end-->
</body>
</html>

