<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="shortcut icon" href="<?php echo base_url() ?>assets/front/images/fevicon.ico" type="image/x-icon"/>
  <title>Welcome to myloanassocham.com</title>
  <link href="<?php echo base_url() ?>assets/front/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>assets/front/css/style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/front/font-awesome-4.6.3/css/font-awesome.min.css">
  <script src="<?php echo base_url() ?>assets/front/js/jquery.js"></script>
  <script src="<?php echo base_url() ?>assets/front/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {

     $('#carousel-example-generic').carousel({
      interval: 10000
    })
     $('#myCarousel1, #carousel-example-generic').carousel();



     $("a.jQueryBookmark").click(function(e){
    e.preventDefault(); // this will prevent the anchor tag from going the user off to the link
    var bookmarkUrl = this.href;
    var bookmarkTitle = this.title;

    if (window.sidebar) { // For Mozilla Firefox Bookmark
      window.sidebar.addPanel(bookmarkTitle, bookmarkUrl,"");
    } else if( window.external || document.all) { // For IE Favorite
      window.external.AddFavorite( bookmarkUrl, bookmarkTitle);
    } else if(window.opera) { // For Opera Browsers
      $("a.jQueryBookmark").attr("href",bookmarkUrl);
      $("a.jQueryBookmark").attr("title",bookmarkTitle);
      $("a.jQueryBookmark").attr("rel","sidebar");
    } else { // for other browsers which does not support
     alert('Your browser does not support this bookmark action');
     return false;
   }
 });

   });
 </script>
 <script>$(document).ready(function(){
  $('.modal-footer button').click(function(){
    var button = $(this);

    if ( button.attr("data-dismiss") != "modal" ){
     var inputs = $('form input');
     var title = $('.modal-title');
     var progress = $('.progress');
     var progressBar = $('.progress-bar');

			//inputs.attr("disabled", "disabled");

			button.hide();

			progress.show();

			progressBar.animate({width : "100%"}, 100);

			progress.delay(1000)
     .fadeOut(600);

			//button.text("Close") //commented on 02-09-2016
			button.text("OK")
     .removeClass("login-ok-button")
     .addClass("btn-success")
     .blur()
     .delay(1600)
     .fadeIn(function(){
      title.text("LOG IN ");
						//button.attr("data-dismiss", "modal");
					});
   }
 });

  $('#myModal').on('hidden.bs.modal', function (e) {
    var inputs = $('form input');
    var title = $('.modal-title');
    var progressBar = $('.progress-bar');
    var button = $('.modal-footer button');

    inputs.removeAttr("disabled");

    title.text("Log in");

    progressBar.css({ "width" : "0%" });

    button.removeClass("btn-success")
    .addClass("login-ok-button")
    .text("Ok")
    .removeAttr("data-dismiss");

  });
  $('form#login').bind('submit',function(){

   var emailReg = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;

   var emailaddress = $("#email_id").val();

   var password=$("#password").val();

   if(!emailReg.test(emailaddress)){

    alert("Please enter valid Email address");

    return false;

  }
  if(password==""){
    alert("Please Enter Password");
    return false;
  }

});
	 /* $('#loginForm').click(function(){
			//alert('<?php echo current_url(); ?>');
			var current_url='<?php echo current_url(); ?>';
				$.ajax({
				  type: "POST",
				  url: "<?php echo base_url(); ?>user/updateUrl/",
				  data: { current_url: current_url},
				  context: document.body,
				  success: function(data){
				  }
				});

     });  */
     $('#remember').click(function(){
       if ($(this).is(':checked')){
        $(this).val(1);
      }
      else{
        $(this).val(0);
      }
    });

     $('#login').keydown(function(e) {
      if (e.keyCode == 13) {


        var email_id = $("#email_id").val();
        var password = $("#password").val();
        var remember = $("#remember").val();


        jQuery.ajax({
         type: "POST",
			//url: "<?php echo base_url() . 'home/ajax_login' ?>",
			url: "<?php echo base_url() . 'user/login' ?>",
			data: "email_id="+email_id+"&password="+password+"&remember="+remember,
			dataType: 'json',
			success: function(response){
				$('#email_id').prev().remove();
				//$('<p class="'+response.class+'">'+response.message+'</p>' ).insertBefore( "#email_id" );
				$(".display_message").html('<p class="'+response.class+'">'+response.message+'</p>');

				//console.log(response); return;
				if (response.class=="succ") {
					window.location.href=response.redirect;
				}
			}
		});
        return false;
      }
    });




     $("#loginForm").click(function(){

		//var id = $("#h_id").val();
		var email_id = $("#email_id").val();
		var password = $("#password").val();
		var remember = $("#remember").val();


		jQuery.ajax({
			type: "POST",
			//url: "<?php echo base_url() . 'home/ajax_login' ?>",
			url: "<?php echo base_url() . 'user/login' ?>",
			data: "email_id="+email_id+"&password="+password+"&remember="+remember,
			dataType: 'json',
			success: function(response){
				$('#email_id').prev().remove();
				//$('<p class="'+response.class+'">'+response.message+'</p>' ).insertBefore( "#email_id" );
				$(".display_message").html('<p class="'+response.class+'">'+response.message+'</p>');

				//console.log(response); return;
				if (response.class=="succ") {
					window.location.href=response.redirect;
				}
			}
		});
	});

});</script>
</head>
<body>

  <section id="top-strip">
    <div class="container homePage">
      <div class="row">
        <div class="col-lg-3 col-sm-4 col-xs-12 white-links"><a href="#"><img src="<?php echo base_url() ?>assets/front/images/google-play-logo.jpg" width="90" height="30" alt=""/></a> <a href="#">DOWNLOAD ANDROID APP</a></div>
        <div class="col-lg-4 col-sm-5 col-xs-12 top-border white-links">
          <ul class="list-inline">
            <li class="text-center"><a href="#"><img src="<?php echo base_url() ?>assets/front/images/bookmark-icon.jpg" width="13" alt=""/> BOOKMARK THIS PAGE</a></li>
            <li><a href="#"><img src="<?php echo base_url() ?>assets/front/images/insta-alerts-icon.jpg" width="11" alt=""/> INSTA ALERTS</a></li>
          </ul>
        </div>
        <?php if (isset($sesuserId) && $sesuserId == "") {
    ?>
        <div class="col-lg-5 col-sm-3 col-xs-12 top-border">
          <ul class="list-inline white-links topBar ">
             <li> <?php $date = date_default_timezone_set('Asia/Kolkata');

//If you want Day,Date with time AM/PM
    echo $today = date("l, F j, Y, g:i a");?> </li>
            <li class="text-center "><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="font-weight: 800;">
            <img src="<?php echo base_url() ?>assets/front/images/login-icon.jpg" width="15" alt=""/> LOGIN</a></li>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">

                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title" id="myModalLabel">LOG IN</h5>
                  </div>
                  <!-- /.modal-header -->
                  <form  name="login" id="login" method="post" action="<?php echo base_url() ?>user/login">
                    <div class="modal-body">

                      <span class="error"><?php echo form_error('email_id'); ?></span>
                      <span class="error"><?php echo form_error('password'); ?></span>
                      <div class="form-group">
                       <div class="display_message"></div>
                       <div class="input-group">
                        <input type="text" class="form-control" id="email_id" name="email_id" value="<?php echo @$username = ($username) ? $username : ""; ?>" placeholder="Username">
                        <label for="uLogin" class="input-group-addon glyphicon glyphicon-user"></label>
                        <span style="color:#F00" class="requirederror"><?php echo form_error('email_id'); ?></span>
                      </div>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                      <div class="input-group">
                        <input type="password" class="form-control" name="password" id="password" value="<?php echo @$password = ($password) ? $password : ""; ?>" placeholder="Password">
                        <label for="uPassword" class="input-group-addon glyphicon glyphicon-lock"></label>
                        <span style="color:#F00" class="requirederror"><?php echo form_error('password'); ?></span>
                      </div>
                      <!-- /.input-group -->
                    </div>
                    <!-- /.form-group -->

                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="remember" id="remember" value="0">
                        Remember me </label>
                      </div>
                      <!-- /.checkbox -->
                      <div class="forgot"><a href="<?php echo base_url() ?>home/forgetpass" class="forgot">Forgot Password</a></div>

                    </div>
                    <!-- /.modal-body -->

                    <div class="modal-footer">
                      <button class="form-control btn login-ok-button" type="button" id="loginForm">OK</button>
                      <!--<input type="submit" class="form-control btn login-ok-button" id="loginForm" value="OK">-->

                      <div class="progress">
                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="100" style="width: 0%;"> <span class="sr-only">progress</span> </div>
                      </div>
                    </div>
                  </form>
                  <!-- /.modal-footer -->

                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <li>
            <a href="<?php echo base_url() ?>Register" style="font-weight: 800;" ><img src="<?php echo base_url() ?>assets/front/images/register-icon.jpg" style="margin-top: 12px;"  width="20" alt="" /> REGISTER</a>
             </li>

            </ul>
          </div>
          <?php } else if (@$sesuserId != "") {?>
          <div class="col-lg-3 col-sm-3 col-xs-12 top-border">
            <ul class="list-inline white-links">
              <li><a href="<?php echo base_url() ?>manage/dashboard"><?php echo "Hi " . $sesuserName ?></a></li>
              <li><a href="<?php echo base_url() ?>user/login/user_logout/">Log Out</a></li>
            </ul>
          </div>
          <?php }?>
        </div>
      </div>
    </section>
    <header>
      <div class="container mainPage">
        <div class="row">
          <?php
if ($this->session->userdata('login_message')) {
    ?>
          <script>
            $(document).ready(function(){
             $("#search_error").show().delay(5000).fadeOut('slow');
           })
         </script>
         <?php echo "<span id='search_error' style='color:#1797a2; padding-left:50px;'><strong>You can now login</strong></span>";
    $this->session->set_userdata('login_message', '');
} ?>
       <div class="col-lg-4 col-md-4 logo"><a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>assets/front/images/logo.png" width="325" alt=""/></a></div>
       <div class="col-lg-8 col-md-8">
        <ul class="list-inline allLogo">
          <li><a href="http://msme.gov.in/mob/home.aspx" target="_blank"><img src="<?php echo base_url() ?>assets/front/images/msme-logo.png" width="120" class="top-padding10" alt=""/></a></li>
          <li><a href="http://www.telangana.gov.in/" target="_blank"><img src="<?php echo base_url() ?>assets/front/images/telanganaLogo.png" width="120" class="top-padding10" alt=""/></a></li>
          <li><a href="http://www.mudra.org.in/" target="_blank"><img src="<?php echo base_url() ?>assets/front/images/mudra-logo.png" width="140" alt=""/></a></li>
          <li><a href="http://www.assocham.org/" target="_blank"><img src="<?php echo base_url() ?>assets/front/images/assocham-logo.png" width="170" alt=""/></a></li>
        </ul>
      </div>
    </div>
  </div>
</header>
<nav class="navbar navbar-default navigation">
  <div class="container mainPage">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header page-scroll">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav nav-list text-center">
        <li><a href="<?php echo base_url() ?>">Home</a></li>
        <!--<li><a href="<?php echo base_url() ?>About-Us">About Us</a></li>-->
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">About Us <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url() ?>About-Us">Why myloanassocham.com</a></li>
            <li><a href="<?php echo base_url() ?>vision">Vision</a></li>
            <li><a href="<?php echo base_url() ?>mission">Mission</a></li>
            <li><a href="<?php echo base_url() ?>quote"> Quote of secretery, MSME</a></li>

            <li><a href="<?php echo base_url() ?>assocham_quoteSecretery">Quote of President, ASSOCHAM</a></li>
            <li><a href="<?php echo base_url() ?>assocham_quote">Quote of Secretery General, ASSOCHAM</a></li>
            <li><a href="<?php echo base_url() ?>mudra_quote">Quote of CEO, MUDRA</a></li>

          </ul>
        </li>
        <!--<li><a href="#">Products</a></li>-->
        <li><a href="<?php echo base_url() ?>type-of-loan">Types of Loan</a></li>
        <!--<li><a href="#">Partner Banks</a></li>-->
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Partner <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url() ?>lead-bank-partners">Lead Bank Partners</a></li>
            <li><a href="<?php echo base_url() ?>participating-bank-partners">Participating Bank Partners</a></li>
            <li><a href="<?php echo base_url() ?>nbfc">NBFCs</a></li>
            <li><a href="<?php echo base_url() ?>insurance">Insurance</a></li>
          </ul>
        </li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Application Process <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url() ?>how-to-apply">How to Apply</a></li>
            <li><a href="<?php echo base_url() ?>information-required">Information Required</a></li>
            <li><a href="<?php echo base_url() ?>documents-required">Documents Required</a></li>
            <li><a href="<?php echo base_url() ?>track-your-application">Track your Application</a></li>
          </ul>
        </li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Knowledge Center <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url() ?>Faq">FAQs</a></li>
            <li><a href="<?php echo base_url() ?>download-form">Download Forms</a></li>
            <li><a href="<?php echo base_url() ?>offer-from-partner">Offers from Partners</a></li>
            <li><a href="<?php echo base_url() ?>emi-calculator">EMI Calculator</a></li>
            <li><a href="<?php echo base_url() ?>circular">Circulars</a></li>
          </ul>
        </li>
        <li><a href="<?php echo base_url() ?>contact-us">Contact Us</a></li>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container-fluid -->
</nav>
<?php echo $contents; ?>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12 top-padding"><a href="#"><img src="<?php echo base_url() ?>assets/front/images/logo.png" width="300" alt=""/></a></div>
      <div class="col-lg-4 col-md-4 col-sm-12 text-center">
        <ul class="list-inline top-margin10">
          <li><a href=" https://www.facebook.com/My-Loan-Assocham-1755532301367900/" target="_blank"><i class="fa fa-facebook-official fa-3x fb"></i></a></li>
          <li><a href="https://twitter.com/MyLoanAssocham" target="_blank"><i class="fa fa-twitter-square fa-3x tw"></i></a></li>
          <li><a href="#"><i class="fa fa-linkedin-square fa-3x in"></i></a></li>
          <li><a href="http://assocham.tv/" target="_blank"><i class="fa  fa-youtube-square fa-3x yt"></i></a></li>
        </ul>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12 grey-text text-right top-margin10"><a href="<?php echo base_url() ?>Privacy-Policy">Privacy Policy</a> | <a href="<?php echo base_url() ?>Terms-Conditions">Terms &amp; Conditions</a><br>
        © 2016 <a href="#"><em><span class="dashyellow">myloan</span><span class="dashred">assocham</span><span class="dashyellow">.com</span><br>
      </em></a>. All Rights Reserved</div>
    </div>
  </div>
</footer>
</body>
</html>
