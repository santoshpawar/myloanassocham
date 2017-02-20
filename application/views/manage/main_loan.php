<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">   
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to myloanassocham.com</title>
<!--<link rel="icon" type="image/x-icon" href="<?php echo base_url()?>assets/admin/images/favicon.ico" />-->
<!--<link href="<?php echo $this->assets->load_url('style.css','admin');?>" rel="stylesheet" type="text/css" />-->
<link href="<?php echo base_url()?>assets/front/css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/shared/css/jquery.countdown.css" type="text/css" />
<link href="<?php echo $this->assets->load_url('reset.css','admin');?>" rel="stylesheet" type="text/css" />	
<script src="<?php echo base_url()?>assets/shared/js/jquery-1.4.2.min.js"></script>


	
   <!-- JS AND CSS END -->
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/shared/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<link href="<?php echo base_url()?>assets/front/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/front/css/style.css" rel="stylesheet" type="text/css">

<link href="<?php echo base_url()?>assets/front/css/style_owner_details.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="<?php echo base_url()?>assets/front/font-awesome-4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">


<script src="<?php echo base_url()?>assets/front/js/jquery.js"></script> 
<script src="<?php echo base_url()?>assets/front/js/bootstrap.min.js"></script> 
<script>
$(document).ready(function() {
	
	$('#carousel-example-generic').carousel({
  interval: 10000
})
$('#myCarousel1, #carousel-example-generic').carousel();

});
</script> 




<script src="<?php echo base_url()?>assets/front/js/classie.js"></script> 
<script>
			(function() {
				// trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
				if (!String.prototype.trim) {
					(function() {
						// Make sure we trim BOM and NBSP
						var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
						String.prototype.trim = function() {
							return this.replace(rtrim, '');
						};
					})();
				}

				[].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
					// in case the input is already filled..
					if( inputEl.value.trim() !== '' ) {
						classie.add( inputEl.parentNode, 'input--filled' );
					}

					// events:
					inputEl.addEventListener( 'focus', onInputFocus );
					inputEl.addEventListener( 'blur', onInputBlur );
				} );

				function onInputFocus( ev ) {
					classie.add( ev.target.parentNode, 'input--filled' );
				}

				function onInputBlur( ev ) {
					if( ev.target.value.trim() === '' ) {
						classie.remove( ev.target.parentNode, 'input--filled' );
					}
				}
			})();
		</script>



<script type="text/javascript">
$(function(){
	var winhgt=$(window).height();
	var wrphgt=$('.outerwrapper').outerHeight()+parseInt($('.outerwrapper').css('margin-top'))+parseInt($('.outerwrapper').css('margin-bottom'));
	if(winhgt>wrphgt)
	{
		//$('.outerwrapper').css('margin-top',(winhgt-wrphgt)*.5+parseInt($('.outerwrapper').css('margin-top')));
	}
	
	if($('.grouplist').length==1){
		$('.grouplist').css('margin-bottom',0);
	}
	
	/* $('.grouplist span').live('click', function(){
        $(this).parent('.grouplist').siblings('.grouplist').find('.nav:visible').siblings('span').removeClass('opend');
        $(this).parent('.grouplist').siblings('.grouplist').find('.nav:visible').slideUp();
		$(this).siblings('ul.nav').slideToggle();
        $(this).toggleClass('opend');
	}); 
	$('li.submenuhd').live('click', function(){
        $(this).siblings('.submenuhd.active').removeClass('active');
        $(this).siblings('.submenuhd').find('ul:visible').slideUp();
		$(this).children('ul').slideToggle();
        $(this).toggleClass('active');
	});*/
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
</head>



<div class="header">

	<div class="container">
		<div class="row">
		  <div class="col-lg-5 col-md-4 logo-module"><a href="<?php echo base_url() ?>manage/dashboard"><img src="<?php echo base_url();?>assets/front/images/logo.png" width="325" alt=""/></a></div>
		  <div class="col-lg-7 col-md-8 text-right grey-text top-margin20">
			Welcome <strong><?php echo $sesuserName; ?></strong> in <em><span class="dashyellow">myloan</span><span class="dashred">assocham</span><span class="dashyellow">.com</span><br>
      </em><br>
			<a href="<?php echo base_url();?>user/login/user_logout">Logout</a>
		  </div>
		</div>
	  </div>


</div>
 <?php $url=$this->uri->segment(3);?>
<?php  $loan_url=explode("/",$_SERVER["REQUEST_URI"]);if(isset($loan_url[4])){ echo $loan_url[4];}?>
<section id="inner-pages">
  <div class="container">
  
	 <?php  if($utype_id==4){ ?>
	 <div class="row">
      <h2 class="module-head text-center">Bank</h2>
    <div class="col-sm-12 module-steps bottom-margin20">
    <div class="col-sm-3 steps-button <?php if($url==""){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/loan_application_list">Loan Application</a></div>
    <div class="col-sm-3 steps-button <?php if($url=="mydetails"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/mydetails">My Details</a></div>
    <div class="col-sm-3 steps-button <?php if($url=="inbox"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/inbox">Inbox</a><?php if(count_message($utype_id)>0){?><span class="inbox-counter"><?php echo count_message($utype_id); ?></span><?php }?></div>
    </div>
      
    </div>
	 <?php }else if($utype_id==1 ){ ?>
	 <div class="row">
      <h2 class="module-head text-center">User Registration</h2>
	  </div>
	 
	  <div class="row">
    <div class="col-lg-12 module-steps bottom-margin20">
    <div class="col-lg-3 steps-button <?php if($url==""){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard">Loan Application</a></div>
    <div class="col-lg-3 steps-button <?php if($url=="mydetails"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/mydetails">My Details</a></div>
    <div class="col-lg-3 steps-button <?php if($url=="inbox"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/inbox">Inbox</a><?php  if(count_message($utype_id)>0){?><span class="inbox-counter"><?php echo count_message($utype_id); ?></span><?php } ?></div>
    </div>
      
    </div>
	 <?php } else if($utype_id==3){?>
	  <div class="row">
      <h2 class="module-head text-center">Analyst</h2>
	  </div>
	  <?php $url=$this->uri->segment(3);?>
	  <div class="row">
    <div class="col-lg-12 module-steps bottom-margin20">
    <div class="col-lg-3 steps-button <?php if($url==""){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard">Loan Application</a></div>
    <div class="col-lg-3 steps-button <?php if($url=="mydetails"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/mydetails">My Details</a></div>
    <div class="col-lg-3 steps-button <?php if($url=="inbox"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/inbox">Inbox</a><?php  if(count_message($utype_id)>0){?><span class="inbox-counter"><?php echo count_message($utype_id); ?></span><?php } ?></div>
    </div>
      
    </div>
	<?php } else if($utype_id==2){?>
    <div class="row">
      <h2 class="module-head text-center">Channel Partner</h2>
	  </div>
	  <div class="row">
    <div class="col-lg-12 module-steps bottom-margin20">
	<div class="col-sm-3 steps-button <?php if($url=="channel_partner_msme_list"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/channel_partner_msme_list">USER</a></div>
    <div class="col-lg-3 steps-button <?php if($url==""){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard">Loan Application</a></div>
    <div class="col-lg-3 steps-button <?php if($url=="mydetails"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/mydetails">My Details</a></div>
    <div class="col-lg-2 steps-button <?php if($url=="inbox"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/inbox">Inbox</a><?php  if(count_message($utype_id)>0){?><span class="inbox-counter"><?php echo count_message($utype_id); ?></span><?php } ?></div>
    </div>
      
    </div>


 <?php } else if($utype_id==5){?>
     <div class="row">
      <h2 class="module-head text-center">Admin</h2>
    <div class="col-sm-12 module-steps bottom-margin20">
    <div class="col-sm-2 steps-button-in <?php if($url=="bank_list"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/bank_list">Bank</a></div>
    <div class="col-sm-2 steps-button-in <?php if($url=="analyst_list"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/analyst_list">Analyst</a></div>
    <div class="col-sm-2 steps-button-in <?php if($url=="channel_partner_list"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/channel_partner_list">Channel Partner</a></div>
    <div class="col-sm-2 steps-button-in <?php if($url=="msme_list"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/msme_list">User</a></div>
    <div class="col-sm-2 steps-button-in <?php if($url=="loan_application_list"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/loan_application_list">Loan Application</a></div>
    <div class="col-sm-2 steps-button-in <?php if($url=="mis_report"){ echo "current";} ?>"><a href="<?php echo base_url() ?>manage/dashboard/mis_report">MIS Report</a></div>
    </div>
     
    </div>

	 <?php } ?>

	 <?php if($url!='inbox' && $url!='sent_query' && $url!='compose_query') {?>
    <div class="row bottom-margin15">
    <div class="col-sm-3 col-xs-4 arrow_box <?php if($url=="loan_application" || $url=="loan_requirement" || $url=="enterprise_background" || $url=="owner_details"){ echo "current";}else{ echo "second"; } ?> "><a href="<?php echo base_url() ?>manage/dashboard/loan_application/<?php  $loan_url=explode("/",$_SERVER["REQUEST_URI"]);if(isset($loan_url[4])){ echo $loan_url[4];}?>">STEP 1</a></div>
    <div class="col-sm-3 col-xs-4 arrow_box <?php if($url=="banking_credit_facilities"){ echo "current";}else{ echo "third"; } ?>"><a href="<?php echo base_url() ?>manage/dashboard/banking_credit_facilities/<?php  $loan_url=explode("/",$_SERVER["REQUEST_URI"]);if(isset($loan_url[4])){ echo $loan_url[4];}?>">STEP 2</a></div>
    <div class="col-sm-3 col-xs-4 arrow_box <?php if($url=="upload_documents" || $url=="analyst_documents" || $url=="bank_application_status" ){ echo "current";} ?>" ><a href="<?php echo base_url() ?>manage/dashboard/upload_documents/<?php  $loan_url=explode("/",$_SERVER["REQUEST_URI"]);if(isset($loan_url[4])){ echo $loan_url[4];}?>">STEP 3</a></div>
	</div>
	  <?php } ?>
   <div class="row">
   <?php //echo $url;?>
    <div class="comman-wrapper <?php if($url=="loan_application"){ echo "enterprise-details";}else if($url=="loan_requirement"){ echo "loan-requirement";}else if($url=="enterprise_background"){ echo "enterprise-background";}else if($url=="owner_details"){ echo "owner-details2";}else if($url=="banking_credit_facilities"){ echo "banking-credit";}else if($url=="analyst_documents"){ echo "analyst";}else if($url=="upload_documents"){ echo "upload-documents";} else if($url=="bank_application_status"){ echo "application-status";}else if($url=="inbox"){ echo "loan-requirement";}else if($url=="sent_query"){ echo "loan-requirement";}else if($url=="compose_query"){ echo "compose-query";}?>"> 
		<?php echo $contents;?>
		<?php if($url!='inbox' && $url!='sent_query' && $url!='compose_query') {?>
		<?php if($url!="banking_credit_facilities" && $url!="upload_documents" && $url!="analyst_documents" && $url!="bank_application_status"){?>
		<a href="<?php echo base_url() ?>manage/dashboard/loan_application/<?php  $loan_url=explode("/",$_SERVER["REQUEST_URI"]);if(isset($loan_url[4])){ echo $loan_url[4];}?>" class="common-heading <?php if($url=="loan_application"){ echo "select";} ?>"> <span class="yellow-line"></span>ENTERPRISE PROFILE<span class="arrow extra-sprite"></span> </a>
		<a href="<?php echo base_url() ?>manage/dashboard/loan_requirement/<?php  $loan_url=explode("/",$_SERVER["REQUEST_URI"]);if(isset($loan_url[4])){ echo $loan_url[4];}?>" class="common-heading <?php if($url=="loan_requirement"){ echo "select";} ?>"> <span class="yellow-line"></span>LOAN REQUIREMENT<span class="arrow extra-sprite"></span></a>
		<div class="content-wrapper">LOAN REQUIREMENT</div>
		<a href="<?php echo base_url() ?>manage/dashboard/enterprise_background/<?php  $loan_url=explode("/",$_SERVER["REQUEST_URI"]);if(isset($loan_url[4])){ echo $loan_url[4];}?>" class="common-heading <?php if($url=="enterprise_background"){ echo "select";} ?>"> <span class="yellow-line"></span>ENTERPRISE BACKGROUND<span class="arrow extra-sprite"></span> </a>
		<div class="content-wrapper">ENTERPRISE BACKGROUND</div>
		<a href="<?php echo base_url() ?>manage/dashboard/owner_details/<?php  $loan_url=explode("/",$_SERVER["REQUEST_URI"]);if(isset($loan_url[4])){ echo $loan_url[4];}?>" class="common-heading <?php if($url=="owner_details"){ echo "select";} ?>"> <span class="yellow-line"></span>OWNER DETAILS<span class="arrow extra-sprite"></span> </a>
		<div class="content-wrapper">OWNER DETAILS</div>
		<?php } else if($url=="banking_credit_facilities") {?>
		<a href="<?php echo base_url() ?>manage/dashboard/banking_credit_facilities/<?php  $loan_url=explode("/",$_SERVER["REQUEST_URI"]);if(isset($loan_url[4])){ echo $loan_url[4];}?>" class="common-heading select"> <span class="yellow-line"></span>Banking / Credit Facilities<span class="arrow extra-sprite"></span> </a>
		<?php } else if($url=="upload_documents" || $url=="analyst_documents" || $url=="bank_application_status"){ ?>
		<a href="<?php echo base_url() ?>manage/dashboard/upload_documents/<?php  $loan_url=explode("/",$_SERVER["REQUEST_URI"]);if(isset($loan_url[4])){ echo $loan_url[4];}?>" class="common-heading <?php if($url=="upload_documents"){ echo "select";} ?>"> <span class="yellow-line"></span>UPLOAD DOCUMENTS<span class="arrow extra-sprite"></span> </a>
		<?php if ($utype_id == 3 || $utype_id == 4 || $utype_id == 5){?>
		<a href="<?php echo base_url() ?>manage/dashboard/analyst_documents/<?php  $loan_url=explode("/",$_SERVER["REQUEST_URI"]);if(isset($loan_url[4])){ echo $loan_url[4];}?>" class="common-heading <?php if($url=="analyst_documents"){ echo "select";} ?>"> <span class="yellow-line"></span>ANALYST<span class="arrow extra-sprite"></span> </a>
		<?php if($utype_id == 4 || $utype_id == 5){?>
		<a href="<?php echo base_url() ?>manage/dashboard/bank_application_status/<?php  $loan_url=explode("/",$_SERVER["REQUEST_URI"]);if(isset($loan_url[4])){ echo $loan_url[4];}?>" class="common-heading <?php if($url=="bank_application_status"){ echo "select";} ?>"> <span class="yellow-line"></span>BANK<span class="arrow extra-sprite"></span> </a>
		<?php } }} } else{?>
		<?php if($utype_id==3 || $utype_id==4 || $utype_id==5){?>
		<a href="<?php echo base_url() ?>manage/dashboard/compose_query" class="common-heading <?php if($url=="compose_query"){ echo "select"; } ?>"> <span class="yellow-line"></span>COMPOSE QUERY<span class="arrow extra-sprite"></span></a>
		<?php } ?>
		<a href="<?php echo base_url() ?>manage/dashboard/inbox" class="common-heading <?php if($url=="inbox"){ echo "select"; } ?>"> <span class="yellow-line"></span>INBOX<span class="arrow extra-sprite"></span> </a>
      <div class="content-wrapper">INBOX</div>
    <a href="<?php echo base_url() ?>manage/dashboard/sent_query" class="common-heading <?php if($url=="sent_query"){ echo "select"; } ?>"> <span class="yellow-line"></span>SENT MESSAGE<span class="arrow extra-sprite"></span></a>
      <div class="content-wrapper">SENT MESSAGE</div>
		<?php } ?>
	</div>
	
    </div>
	
	
  </div>
</section>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12 top-padding"><a href="#"><img src="<?php echo base_url();?>assets/front/images/logo.png" width="300" alt=""/></a></div>
      <div class="col-lg-4 col-md-4 col-sm-12 text-center">
        <ul class="list-inline top-margin10">
          <li><a href="https://www.facebook.com/My-Loan-Assocham-1755532301367900/" target="_blank"><i class="fa fa-facebook-official fa-3x fb"></i></a></li>
          <li><a href="https://twitter.com/MyLoanAssocham" target="_blank"><i class="fa fa-twitter-square fa-3x tw"></i></a></li>
          <li><a href="#"><i class="fa fa-linkedin-square fa-3x in"></i></a></li>
          <li><a href="http://assocham.tv/" target="_blank"><i class="fa  fa-youtube-square fa-3x yt"></i></a></li>
        </ul>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12 grey-text text-right top-margin10"><a href="<?php echo base_url() ?>Privacy-Policy">Privacy Policy</a> | <a href="<?php echo base_url() ?>Terms-Conditions">Terms &amp; Conditions</a><br>
        © 2016 <a href="#">MyLoanAssocham.com</a>. All Rights Reserved</div>
    </div>
  </div>
</footer>

	
	
</body>
</html>
