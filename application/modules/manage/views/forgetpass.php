<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smeniwas</title>
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery-latest.js"></script>
<link href="<?php echo base_url()?>assets/admin/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>assets/admin/css/lightbox_form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
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
});
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
table.forgotpasstbl td{
	padding-bottom:10px;
}
</style>

</head>
    <body class="main">
    <div class="outerwrapper">   
	<div class="wrapper">

<div class="header">
<a href="<?php echo base_url();?>manage/dashboard"><img src="<?php echo base_url();?>assets/front/images/logo.png" class="logo" alt=""></a>
</div>
<br />
    <div class="mainbody">

<div class="middleform" style="margin:0 auto; width:53%; float:none;">
<form id="forgetpass" action="<?php echo base_url()?>manage/login/insertfor_pass_record" method="post">
<fieldset class="bottomskywrapepr forgotpasswrp">
<legend><strong>Forgot Password</strong></legend>
    <table cellpadding="0" cellspacing="0" border="0" class="forgotpasstbl">
        <tr>
        <td align="right" valign="middle"><strong>Please Enter Your Email ID</strong> &nbsp;</td>
        <td align="left" valign="middle"><p><input type="text" name="email_id" id="email_id"/></p></td>
        </tr>
        <tr>
        <td align="left" valign="middle">&nbsp;</td>
        <td align="left" valign="middle"><input type="submit" id="for_pass" name="for_pass" class="submit_bt fg_sent_bt" value="Send" style="border-left:3px solid #68CEED; line-height:14px;" /></td>
        </tr>
    </table>
</fieldset> 
<a href="<?php echo base_url()?>manage/login" class="exitbtn backbtn" style="float:right; margin:15px 0;">Back</a>   
</form>
</div>
        <br class="spacer" />
<div class="footer">

<p><span class="fl">Authorised and regulated by the Smeniwas</span>
<span class="fr">&copy; Copyright <?php echo date("Y");?> Smeniwas. All Rights Reserved</span></p>

</div>
		<div class="browserrecom">Best viewed in <span onclick="goBrowser('firefox')">Firefox</span>, <span onclick="goBrowser('chrome')">Chrome</span>, <span onclick="goBrowser('safari')">Safari</span> and <span onclick="goBrowser('opera')">Opera</span>.</div>
</div>
</div>
</body>
</html>