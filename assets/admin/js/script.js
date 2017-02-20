var tooltip=function(){
	var id = 'tt';
	var top = 3;
	var left = 3;
	var maxw = 300;
	var speed = 10;
	var timer = 20;
	var endalpha = 95;
	var alpha = 0;
	var tt,t,c,b,h;
	var ie = document.all ? true : false;
	return{
		show:function(v,w){
			if(tt == null){
				tt = document.createElement('div');
				tt.setAttribute('id',id);
				t = document.createElement('div');
				t.setAttribute('id',id + 'top');
				c = document.createElement('div');
				c.setAttribute('id',id + 'cont');
				b = document.createElement('div');
				b.setAttribute('id',id + 'bot');
				tt.appendChild(t);
				tt.appendChild(c);
				tt.appendChild(b);
				document.body.appendChild(tt);
				tt.style.opacity = 0;
				tt.style.filter = 'alpha(opacity=0)';
				document.onmousemove = this.pos;
			}
			tt.style.display = 'block';
			c.innerHTML = v;
			tt.style.width = w ? w + 'px' : 'auto';
			if(!w && ie){
				t.style.display = 'none';
				b.style.display = 'none';
				tt.style.width = tt.offsetWidth;
				t.style.display = 'block';
				b.style.display = 'block';
			}
			if(tt.offsetWidth > maxw){tt.style.width = maxw + 'px'}
			h = parseInt(tt.offsetHeight) + top;
			clearInterval(tt.timer);
			tt.timer = setInterval(function(){tooltip.fade(1)},timer);
		},
		pos:function(e){
			var u = ie ? event.clientY + document.documentElement.scrollTop : e.pageY;
			var l = ie ? event.clientX + document.documentElement.scrollLeft : e.pageX;
			tt.style.top = (u - h) + 'px';
			tt.style.left = (l + left) + 'px';
		},
		fade:function(d){
			var a = alpha;
			if((a != endalpha && d == 1) || (a != 0 && d == -1)){
				var i = speed;
				if(endalpha - a < speed && d == 1){
					i = endalpha - a;
				}else if(alpha < speed && d == -1){
					i = a;
				}
				alpha = a + (i * d);
				tt.style.opacity = alpha * .01;
				tt.style.filter = 'alpha(opacity=' + alpha + ')';
			}else{
				clearInterval(tt.timer);
				if(d == -1){tt.style.display = 'none'}
			}
		},
		hide:function(){
			clearInterval(tt.timer);
			tt.timer = setInterval(function(){tooltip.fade(-1)},timer);
		}
	};
}();


$(document).ready(function(){
	/*---------proposer_name character start------------*/
	var maxLengthofTxt1=100;
	$('#proposer_name').live('focus', function(e){
		$(this).removeAttr('maxlength');
//		var typedLetter=$(this).val().length;
//		var leftW=maxLengthofTxt1-typedLetter;
//		var exceedClass="";
//		if(typedLetter>maxLengthofTxt1){
//			exceedClass='exced';
//		}
//		if($(this).parent('p').find('.wordLeft').length==0){
//			$(this).parent('p').append('<div class="wordLeft '+exceedClass+'">Total: <i>'+typedLetter+'</i></div>');
//			$(this).parent('p').find('.wordLeft').slideDown();
//		}
	});
	$('#proposer_name').live('blur', function(e){
		$(this).parent('p').find('.wordLeft').slideUp(500, function(){
			$(this).remove();
		});
	});
	$('#proposer_name').live('keyup input', function(e){
		var typedLetter=$(this).val().length;
		var leftW=maxLengthofTxt1-typedLetter;
		if($(this).parent('p').find('.wordLeft').length==0){
			$(this).parent('p').append('<div class="wordLeft">Total: <i>'+typedLetter+'</i></div>');
			$(this).parent('p').find('.wordLeft').slideDown();
		}
		else{
			$(this).parent('p').find('.wordLeft').find('i').html(typedLetter);
		}

		//if(typedLetter>=maxLengthofTxt){
			//$(this).val($(this).val().slice(0, maxLengthofTxt));
		//}
		if(typedLetter>maxLengthofTxt1){
			$(this).parents('li[id]').find('.nextbutton, .submit_bt').attr('disabled', 'disabled');
			if($(this).parent('p').next('.warning').length==0){
				$(this).parent('p').after('<div class="warning important_notes"><strong>WARNING!</strong>You have exceeded the maximum limit of 100 characters for this text box. Please modify your text to ensure that all pertinent data has been entered before you can continue to the next page.</div>');
			}
			if($(this).parents('li[id]').find('.nextbutton, .submit_bt').next('.nextdisberr').length==0){
				$(this).parents('li[id]').find('.nextbutton, .submit_bt').after('<div class="nextdisberr">Please reduce text where highlighted above</div>');
			}			
			
			//$(this).parent('p').find('.wordLeft').find('i').html(typedLetter);
			$(this).parent('p').find('.wordLeft').addClass('exced');
		}
		else{			
			$(this).parent('p').next('.warning').remove();
			var statArr=[];
			if($(this).parents('li[id]').find('#proposer_name').length==1){
				if($(this).parents('li[id]').find('#proposer_name').val().length>maxLengthofTxt1){
					statArr.push('error');
				}
			}
			$(this).parents('li[id]').find('textarea').each(function(){
				var typedLt=$(this).val().length;
				if(typedLt>maxLengthofTxt1){
					statArr.push('error');
				}
			});
			if(statArr.length==0){
				$(this).parents('li[id]').find('.nextbutton, .submit_bt').removeAttr('disabled');
				$(this).parents('li[id]').find('.nextbutton, .submit_bt').next('.nextdisberr').remove();
			}			
			
			//$(this).parent('p').find('.wordLeft').find('i').html(typedLetter);
			$(this).parent('p').find('.wordLeft').removeClass('exced');
		}
	});	
	/*---------proposer_name character start------------*/
	
	/*---------textarea character start------------*/
	var maxLengthofTxt=500;	
	$('fieldset textarea').live('focus', function(e){
		$(this).removeAttr('maxlength');
//		var typedLetter=$(this).val().length;
//		var leftW=maxLengthofTxt-typedLetter;
//		var exceedClass="";
//		if(typedLetter>maxLengthofTxt){
//			exceedClass='exced';
//		}
//		if($(this).parent('p').find('.wordLeft').length==0){
//			$(this).parent('p').append('<div class="wordLeft '+exceedClass+'">Total: <i>'+typedLetter+'</i></div>');
//			$(this).parent('p').find('.wordLeft').slideDown();
//		}
	});
	$('fieldset textarea').live('blur', function(e){
		$(this).parent('p').find('.wordLeft').slideUp(500, function(){
			$(this).remove();
		});
	});	
	$('fieldset textarea').live('keyup input', function(e){
		var typedLetter=$(this).val().length;
		var leftW=maxLengthofTxt-typedLetter;
		if($(this).parent('p').find('.wordLeft').length==0){
			$(this).parent('p').append('<div class="wordLeft">Total: <i>'+typedLetter+'</i></div>');
			$(this).parent('p').find('.wordLeft').slideDown();
		}
		else{
			$(this).parent('p').find('.wordLeft').find('i').html(typedLetter);
		}
		//if(typedLetter>=maxLengthofTxt){
			//$(this).val($(this).val().slice(0, maxLengthofTxt));
		//}
		if(typedLetter>maxLengthofTxt){
			if($(this).parents("#stepForm")){
				$(this).parents('li[id]').find('.nextbutton, .submit_bt').attr('disabled', 'disabled');
				if($(this).parent('p').next('.warning').length==0){
					$(this).parent('p').after('<div class="warning important_notes"><strong>WARNING!</strong>You have exceeded the maximum limit of 500 characters for this text box. Please modify your text to ensure that all pertinent data has been entered before you can continue to the next page.</div>');
				}
				if($(this).parents('li[id]').find('.nextbutton, .submit_bt').next('.nextdisberr').length==0){
					$(this).parents('li[id]').find('.nextbutton, .submit_bt').after('<div class="nextdisberr">Please reduce text where highlighted above</div>');
				}
			}
			else{
				//non DCF
				$(this).parents('form').find('input[type=submit]').attr('disabled', 'disabled');
				if($(this).parent('p').next('.warning').length==0){
					$(this).parent('p').after('<div class="warning important_notes"><strong>WARNING!</strong>You have exceeded the maximum limit of 500 characters for this text box. Please modify your text to ensure that all pertinent data has been entered before you can continue to the next page.</div>');
				}
				if($(this).parents('form').find('input[type=submit]').next('.nextdisberr').length==0){
					$(this).parents('form').find('input[type=submit]').after('<div class="nextdisberr right">Please reduce text where highlighted above</div>');
				}
			}
			//$(this).parent('p').find('.wordLeft').find('i').html(typedLetter);
			$(this).parent('p').find('.wordLeft').addClass('exced');
		}
		else{
			if($(this).parents("#stepForm")){
				$(this).parent('p').next('.warning').remove();
				var statArr=[];
				$(this).parents('li[id]').find('textarea').each(function(){
					var typedLt=$(this).val().length;
					if(typedLt>maxLengthofTxt){
						statArr.push('error');
					}
				});
				if(statArr.length==0){
					$(this).parents('li[id]').find('.nextbutton, .submit_bt').removeAttr('disabled');
					$(this).parents('li[id]').find('.nextbutton, .submit_bt').next('.nextdisberr').remove();
				}
			}else{
				//non DCF
				$(this).parent('p').next('.warning').remove();
				var statArr=[];
				$(this).parents('form').find('textarea').each(function(){
					var typedLt=$(this).val().length;
					if(typedLt>maxLengthofTxt){
						statArr.push('error');
					}
				});
				if($(this).parents('li[id]').find('#proposer_name').length==1){
					if($(this).parents('li[id]').find('#proposer_name').val().length>maxLengthofTxt1){
						statArr.push('error');
					}
				}
				if(statArr.length==0){
					$(this).parents('form').find('input[type=submit]').removeAttr('disabled');
					$(this).parents('form').find('input[type=submit]').next('.nextdisberr').remove();
				}
			}
			
			//$(this).parent('p').find('.wordLeft').find('i').html(typedLetter);
			$(this).parent('p').find('.wordLeft').removeClass('exced');
		}
	});	
	
	$('input[type=radio]').live('click', function(){
		if($(this).parents("#stepForm")){
			var statArr=[];
			$(this).parents('li[id]').find('textarea').each(function(){
				var typedLt=$(this).val().length;
				if(typedLt>maxLengthofTxt){
					statArr.push('error');
				}
			});
			if($(this).parents('li[id]').find('#proposer_name').length==1){
				if($(this).parents('li[id]').find('#proposer_name').val().length>maxLengthofTxt1){
					statArr.push('error');
				}
			}
			if(statArr.length==0){
				$(this).parents('li[id]').find('.nextbutton, .submit_bt').removeAttr('disabled');
				$(this).parents('li[id]').find('.nextbutton, .submit_bt').next('.nextdisberr').remove();
			}
		}else{
			var statArr=[];
			$(this).parents('form').find('textarea').each(function(){
				var typedLt=$(this).val().length;
				if(typedLt>maxLengthofTxt){
					statArr.push('error');
				}
			});
			if(statArr.length==0){
				$(this).parents('form').find('input[type=submit]').removeAttr('disabled');
				$(this).parents('form').find('input[type=submit]').next('.nextdisberr').remove();
			}
		}
	});
	
	/*---------textarea character end------------*/
	
	
	$('input#proposer_name:not(.onlyview)').focus();
	
	$('select').focus(function(){
		$(this).parent('p').find('.selectwrapper').addClass("focusborder");
	});
	
	$('select').blur(function(){
		$(this).parent('p').find('.selectwrapper').removeClass("focusborder");
	});
	
		
	//custom select box styling
	$("select").css({opacity:0});
			
	$('select').each(function(){
		var attr = $(this).find("option:selected").text();
		$(this).parents('p').find("span.selectwrapper").text(attr);
	});
	$('select').change(function(){
		var attr = $(this).find("option:selected").text();
		$(this).parents('p').find("span.selectwrapper").text(attr);
	});
	
	// add * to required field labels
	$('label.required').append('&nbsp;<strong>*</strong>&nbsp;');
	
	
	//step 2 step form validation
	$('#sf2').hide();
	$('#sf3').hide();
	$('#sf4').hide();
	$('#sf5').hide();
	
	
	// back buttons do not need to run validation
	$("#sf2 .prevbutton").click(function(){
	//accordion.activate(0);
		current = 0;
		$('#sf2').hide();
		$('#sf1').fadeIn();
	});
	 
	$("#sf3 .prevbutton").click(function(){
		current = 1;
		$('#sf3').hide();
		$('#sf2').fadeIn();
	});
	
	$("#sf4 .prevbutton").click(function(){
		current = 2;
		$('#sf4').hide();
		$('#sf3').fadeIn();
	});
	
	$("#sf5 .prevbutton").click(function(){
		current = 3;
		$('#sf5').hide();
		$('#sf4').fadeIn();
	});
	
	$("#postcode1").live('focus', function(){
		$('#tick').html('<span class="wrong">Allowing a maximum of 4 characters</span>');
	});
	$("#postcode1").live('blur', function(){
		$('#tick').html('<span class="wrong">Please Complete Full Postcode</span>');
	});
	$("#cor_postcode1").live('focus', function(){
		$('#cor_tick').html('<span class="wrong">Allowing a maximum of 4 characters</span>');
	});
	$("#cor_postcode1").live('blur', function(){
		$('#cor_tick').html('<span class="wrong">Please Complete Full Postcode</span>');
	});
	
	$("#postcode2").attr('maxlength', 3);
	// postcode format checking
	$("#postcode2").blur(function(){
		var postcode=$("#postcode1").val()+" "+$(this).val(); 
		var prod_id=$('#prod_id').val();
		if(postcode.match(' ')){
			$("#error").html('');
			
			// ajax check for rates availability
			
				$.ajax({
						   type: "POST",
						   url: base_url+"policy/manage/policy/post_check",
						   data: {postcode:postcode,prod_id:prod_id},
						   success: function(data){
							   
								if(data=="<span class='right'>Rates Available</span>")
								{
 									$("#tick").html('<span class=right>Rates Available</span>');
									$("#postcode").val(postcode);
									StartTest();
								}
								else if(data=="<span class='right'>Rates Available</span>no")
								{
									$("#tick").html('<span class=right>Rates Available</span>');
									$("#postcode").val(postcode);
								}
								else if(data=="<span class='right'>Rates Available</span>")
								{
									$("#tick").html('<span class=right>Rates Available</span>');
									$("#postcode").val(postcode);
								}
								else
								{	
									$("#postcode1").val("");
									$("#postcode2").val("");
									$("#tick").html(data);
									$("#postcode").val(postcode);
								}
						   } 
					});
			
           	return true;
        }
		else
		{
			$("#tick").html('');
			$("#error").html("Incorrect postcode format. Please provide correct postcode format");
			$('#postcode1').val('');
			$(this).val('');
			return false;
		}
	 });
	 
	// correspondence risk address
	$("#cor_risk_addr_yes").click(function(){ 
		$("#CA-2").html('<label>Postcode Lookup<span>*</span></label><p><input name="cor_postcode1" maxlength="4" id="cor_postcode1" class="text required" type="text" value="" /><input name="cor_postcode2" id="cor_postcode2" maxlength="3" class="text required" type="text" value="" /><input name="cor_postcode" id="cor_postcode" type="hidden" value="" /><input class="find_btn" type="button" name="find_btn" value="" onclick="corStartTest()" /><br class="spacer" /><span id="cor_tick"></span></p><span class="for_eg" style="margin-right: 130px;">for e.g.- <strong>AB10 7AY</strong></span>');
		$("#CA-3").html('<label>Address Filled By Lookup<span>*</span></label><p id="cor_pnlResults"><input name="" id="" class="required" type="text" value="" /></p>');
		$("#CA-4").html('<label>Postcode Lookup results<span>*</span></label><p><input name="cor_risk_address" id="cor_risk_address" class="required" type="text" value="" /></p>');
		$('#CA-6').html('<label>Town<span>*</span></label><p><input name="cor_risk_town" id="cor_risk_town" class="" type="text" value="" readonly="readonly" /></p>');
		$('#CA-7').html('<label>County<span>*</span></label><p><input name="cor_risk_county" id="cor_risk_county"  type="text" value=""  /></p>');
		$("#CA-5").html('<label>Postcode Filled By Lookup<span>*</span></label><p><input name="cor_risk_postcode" id="cor_risk_postcode" class="" type="text" value="" readonly="readonly" /></p>');
		
		$("#cor_postcode2").blur(function(){
			$("#cor_tick").html('');			
			var cor_postcode=$("#cor_postcode1").val()+' '+$(this).val(); 
			var prod_id=$('#prod_id').val();
			if(cor_postcode.match(' '))
			{
						$("#cor_error").remove();
							// ajax check for rates availability
							$.ajax({
								   type: "POST",
								   url: base_url+"policy/manage/policy/post_check",
								   data: {postcode:cor_postcode,prod_id:prod_id},
								   success: function(data){ 
									if(data=="<span class='right'>Rates Available</span>")
									{
										//$("#cor_tick").html(data);
										$("#cor_postcode").val(cor_postcode);
									}
									else
									{	
										$("#cor_postcode1").val("");
										$("#cor_postcode2").val("");
										$("#cor_tick").html(data);
										$("#cor_postcode").val(cor_postcode);
									}
								   }
								});
			   	return true;
			}
			else
			{
				$("#cor_tick").html('<span id="cor_error">Incorrect postcode format. Please provide correct postcode format</span>');
				$("#cor_postcode1").val("");
				$(this).val("");
				return false;
			}
		 });
		 
		
		 
	});
	
	$("#cor_risk_addr_no").click(function(){ 
		$("#CA-2").html('');
		$("#CA-3").html('');
		$("#CA-4").html('');
		$("#CA-5").html('');
		$("#CA-6").html('');
		$("#CA-7").html('');
	});
	
	$('#property_loss_yes').click(function(){
		var product_id=$('#prod_id').val();
		$('#claim').show();
		$('#claim').append('<input type="button" class="add_button" name="add_button" id="add_button"  value="Add">');
		 var created_by=$('#created_by').val();
		 var i=0;
		$("#add_button").click(function(){
			i++; 
			if(i>4)
			{
				referable.push("Claims History");
			}
			else
			{
				referable.splice(referable.indexOf("Claims"), 1);
			}
		$.fancybox({
			'width'				: 450,
			'height'			: 600,
			'autoScale'			: true,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'href'		        : base_url+'policy/manage/policy/claim_details/'+product_id,
			'type'				: 'iframe',
			"onClosed"          : function(){
										$.ajax({
												 type: "POST",
												 url: base_url+"policy/manage/policy/claimList",
												 data: "created_by="+created_by,
												 success: function(data){ 
												 if(data)
												 {
													$("#claim").find('table.add_table').remove();
													$("#claim").prepend(data);
												 }
												}
										});//ajax end	
								  }//fancybox end
		});
		});//click end
			
			
	});
	
	
	$("#property_loss_no").click(function(){
		$('#claim').hide();
		$('#claim').html('');
		referable.splice(referable.indexOf("Claims"), 1);
	});
	
	$('input.com_num').keyup(function(event){
		if(event.which >= 8 && event.which <= 46){			
		}
		else{
			$(this).val(function(index, value) {
				return value
					.replace(/\D/g, '')
					.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
				;
			});
		}
	});
	
	$.fn.selectRange = function(start, end) {
		return this.each(function() {
			if (this.setSelectionRange) {
				this.focus();
				this.setSelectionRange(start, end);
			} else if (this.createTextRange) {
				var range = this.createTextRange();
				range.collapse(true);
				range.moveEnd('character', end);
				range.moveStart('character', start);
				range.select();
			}
		});
	};
	
	
	$('input.com_num#buildings_sum').keyup(function(event){
		var inpVal=$(this).val();
		var firstPos=inpVal.charAt(0);
		var secondPos=inpVal.charAt(1);
		if(secondPos==","){
			var startPos=2;
		}
		else{
			var startPos=1;
		}
		
		
		var inpLen=inpVal.length;
		var extVal=inpVal.slice(startPos, inpLen);

		if(firstPos=='0'){
			$(this).val(extVal).focus().selectRange(0,0);
			//$("#question_input_field_id").get(0).setSelectionRange(0,0);
		}
		else{
			//if($(this).val().length)
			if(event.which >= 8 && event.which <= 46){			
			}
			else{
				$(this).val(function(index, value) {
					return value
						.replace(/\D/g, '')
						.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
					;
				});
			}
		}
	});
	
	$('input.com_num').each(function() {
		$(this).val(function(index, value) {
			return value
				.replace(/\D/g, '')
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
			;
		});        
    });
	
	$('input.com_num').live('blur',function(){
		$(this).val(function(index, value) {
			return value
				.replace(/\D/g, '')
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
			;
		});
		
		
		
		if($(this).attr('readonly')){
			if($(this).val()=='' && $(this).attr('readonly')==''){
				$(this).val(0);
			}
		}
		else{
			if($(this).val()==''){
				$(this).val(0);
			}
		}
	});
	
	$('input.com_num').live('focus',function(){
		if($(this).attr('readonly')){
			if($(this).val()==0 && $(this).attr('readonly')==''){
				$(this).val('');
			}
		}
		else{
			if($(this).val()==0){
				$(this).val('');
			}
		}
	});
	
	
	$('input#unit_agreement').blur(function(){
		if($(this).val()==''){
			$(this).val(0);
		}
	});	
	$('input#unit_agreement').focus(function(){
		if($(this).val()==0){
			$(this).val('');
		}
	});	
});

function closeFB()
{	
	$.fancybox.close();
}

function refress()
{
	$('#claim').load();
}
// postcode api

function StartTest()
{
	var _scriptTag = document.getElementById('twsScript');
	var _headTag = document.getElementsByTagName('head').item(0);
	var _strUrl = '';
	var _strUrl = '';
	_strUrl = 'https://services.postcodeanywhere.co.uk/POSTCODEANYWHERE/INTERACTIVE/FIND/1.1/json.ws?';
	_strUrl += 'key=' + encodeURIComponent('TA79-RX96-FZ96-PC48');
	_strUrl += '&SearchTerm=' + encodeURIComponent($('#postcode1').val() + ' '+ $('#postcode2').val());
	_strUrl += '&PreferredLanguage=' + encodeURIComponent('English');
	_strUrl += '&CallbackFunction=TestCallBack';

	//Add a waiting message
	//document.getElementById('pnlResults').style.display='none';
	//document.getElementById('btnTest').innerHTML = 'Running...';
	//document.getElementById('btnTest').disabled = true;
	//Make the request
	if (_scriptTag)
	{
		try
		{
			_headTag.removeChild(_scriptTag);
		}
		catch (e)
		{
			//Ignore
		}
	}
	_scriptTag = document.createElement('script');
	_scriptTag.src = _strUrl;
	_scriptTag.type = 'text/javascript';
	_scriptTag.id = 'twsScript';
	_headTag.appendChild(_scriptTag);
}



function TestCallBack(response)
{
	var _strHtml='';
	var _intColumn=0;
	var _intRow=0;
	var _strColumns=new Array('Id','StreetAddress','Place');
	var _strColumn='';
	//Hide the waiting panel
	//document.getElementById('btnTest').innerHTML = 'Start the test';
	//document.getElementById('btnTest').disabled = false;
	//Test for an error
	if (response.length==1 && typeof(response[0].Error) != 'undefined')
	{
		//Show the error message
		_strHtml = '<table cellpadding="0" cellspacing="0" class="error-table" style="width: 100%;">';
		/*_strHtml += '<thead><tr><th><span class="cboxtl"></span>Error</th><th>Description</th><th>Cause</th><th><span class="cboxtr"></span>Resolution</th></tr></thead>';*/
		_strHtml += '<tr><td>* &nbsp;' + response[0].Description + '</td></tr><tr><td>* &nbsp;' + response[0].Cause + '</td></tr>';
		_strHtml += '</table>';
		$('#pnlResults').html(_strHtml);
		//Update the DIV
	}
	else
	{
	//Check if there were any items found
		if (response.length==0)
		{
			_strHtml = '<h2>Sorry, no matching items found</h2>';
		}
		else
		{
			//Add the headings to the table
			_strHtml += '<span class="selectwrapper">Please select the correct address</span><span class="select_icon"></span><select name="lookup_result" id="lookup_result">';
			_strHtml += '<option value="">Please select the correct address</option>';
	
			//Add the rows
			for (_intRow=0; _intRow<response.length; _intRow++)
			{
				_strHtml += '<option value="'+response[_intRow].Id+'">'
				if (response[_intRow].StreetAddress=='') { _strHtml += '&nbsp;' } else  { _strHtml += response[_intRow].StreetAddress };
				if (response[_intRow].Place=='') { _strHtml += '&nbsp;' } else  { _strHtml += '&nbsp;'+response[_intRow].Place  };
				_strHtml += '</option>'
			}
			_strHtml += '</select>'
		}
		//Update the DIV
		$('#pnlResults').html(_strHtml);
		$("select").css({opacity:0});
				
		$('select').change(function(){
			var attr = $(this).find("option:selected").text();
			$(this).parents('p').find("span.selectwrapper").text(attr);
		});
		$('select').each(function(){
			var attr = $(this).find("option:selected").text();
			$(this).parents('p').find("span.selectwrapper").text(attr);
		});
		
		$('#lookup_result').change(function(){
			//$('#risk_address').val($('#lookup_result').find("option:selected").text());
			//$('#risk_postcode').val($('#postcode').val());
			retriveDetails($('#lookup_result').val());
		});
	
	}
}



function corStartTest()
{
	var _scriptTag = document.getElementById('twsScript');
	var _headTag = document.getElementsByTagName('head').item(0);
	var _strUrl = '';
	var _strUrl = '';
	_strUrl = 'https://services.postcodeanywhere.co.uk/POSTCODEANYWHERE/INTERACTIVE/FIND/1.1/json.ws?';
	_strUrl += 'key=' + encodeURIComponent('TA79-RX96-FZ96-PC48');
	_strUrl += '&SearchTerm=' + encodeURIComponent($('#cor_postcode1').val()+ ' '+ $('#cor_postcode2').val());
	_strUrl += '&PreferredLanguage=' + encodeURIComponent('English');
	_strUrl += '&CallbackFunction=corTestCallBack';

	//Add a waiting message
	//document.getElementById('pnlResults').style.display='none';
	//document.getElementById('btnTest').innerHTML = 'Running...';
	//document.getElementById('btnTest').disabled = true;
	//Make the request
	if (_scriptTag)
	{
		try
		{
			_headTag.removeChild(_scriptTag);
		}
		catch (e)
		{
			//Ignore
		}
	}
	_scriptTag = document.createElement('script');
	_scriptTag.src = _strUrl;
	_scriptTag.type = 'text/javascript';
	_scriptTag.id = 'twsScript';
	_headTag.appendChild(_scriptTag);
}


function corTestCallBack(response)
{
	var _strHtml='';
	var _intColumn=0;
	var _intRow=0;
	var _strColumns=new Array('Id','StreetAddress','Place');
	var _strColumn='';
	//Hide the waiting panel
	//document.getElementById('btnTest').innerHTML = 'Start the test';
	//document.getElementById('btnTest').disabled = false;
	//Test for an error
	if (response.length==1 && typeof(response[0].Error) != 'undefined')
	{
		//Show the error message
		_strHtml = '<table cellpadding="0" cellspacing="0" class="error-table" style="width: 100%;">';
		/*_strHtml += '<thead><tr><th><span class="cboxtl"></span>Error</th><th>Description</th><th>Cause</th><th><span class="cboxtr"></span>Resolution</th></tr></thead>';*/
		_strHtml += '<tr><td>* &nbsp;' + response[0].Description + '</td></tr><tr><td>* &nbsp;' + response[0].Cause + '</td></tr>';
		_strHtml += '</table>';
		$('#cor_pnlResults').html(_strHtml);
		//Update the DIV
	}
	else
	{
		//Check if there were any items found
		if (response.length==0)
		{
			_strHtml = '<h2>Sorry, no matching items found</h2>';
		}
		else
		{
			//Add the headings to the table
			_strHtml += '<span class="selectwrapper">Please select the correct address</span><span class="select_icon"></span><select name="cor_lookup_result" id="cor_lookup_result">';
			_strHtml += '<option value="">Please select the correct address</option>';
			
			//Add the rows
			for (_intRow=0; _intRow<response.length; _intRow++)
			{
				_strHtml += '<option value="'+response[_intRow].Id+'">'
				if (response[_intRow].StreetAddress=='') { _strHtml += '&nbsp;' } else  { _strHtml += response[_intRow].StreetAddress };
				if (response[_intRow].Place=='') { _strHtml += '&nbsp;' } else  { _strHtml += '&nbsp;'+response[_intRow].Place  };
				_strHtml += '</option>'
			}
			_strHtml += '</select>'
		}
		//Update the DIV
		$('#cor_pnlResults').html(_strHtml);
		$("select").css({opacity:0});
				
		$('select').change(function(){
			var attr = $(this).find("option:selected").text();
			$(this).parents('p').find("span.selectwrapper").text(attr);
		});
		$('select').each(function(){
			var attr = $(this).find("option:selected").text();
			$(this).parents('p').find("span.selectwrapper").text(attr);
		});
		
		$('#cor_lookup_result').change(function(){
			//$('#cor_risk_address').val($('#cor_lookup_result').find("option:selected").text());
			//$('#cor_risk_postcode').val($('#cor_postcode').val());
			CorRetriveDetails($('#cor_lookup_result').val());
		});
	
	}
}



//-------------retrive part-----------------------------------------

function retriveDetails(Id)
{
	var script = document.createElement("script"),
        head = document.getElementsByTagName("head")[0],
        url = "https://services.postcodeanywhere.co.uk/PostcodeAnywhere/Interactive/RetrieveById/v1.30/json3.ws?";

    // Build the query string
    url += "&Key=" + encodeURIComponent('TA79-RX96-FZ96-PC48');
    url += "&Id=" + encodeURIComponent(Id);
    url += "&PreferredLanguage=" + encodeURIComponent('English');
    url += "&callback=riskPostcodeRetrive";

    script.src = url;

    // Make the request
    script.onload = script.onreadystatechange = function () {
        if (!this.readyState || this.readyState === "loaded" || this.readyState === "complete") {
            script.onload = script.onreadystatechange = null;
            if (head && script.parentNode)
                head.removeChild(script);
        }
    }

    head.insertBefore(script, head.firstChild);
}


function riskPostcodeRetrive(response)
{
    // Test for an error
    if (response.Items.length == 1 && typeof(response.Items[0].Error) != "undefined") {
        // Show the error message
        alert(response.Items[0].Description);
    }
    else {
        // Check if there were any items found
        if (response.Items.length == 0)
            alert("Sorry, there were no results");
        else {
			//alert(response.Items[0].Department+'----'+response.Items[0].BuildingNumber+'----'+response.Items[0].SubBuilding+'----'+response.Items[0].BuildingName);
			if(response.Items[0].BuildingNumber)
			{

				if((response.Items[0].BuildingNumber) && (response.Items[0].Company))
				{
				$('#risk_address').val(response.Items[0].Company+" "+response.Items[0].BuildingName+" "+response.Items[0].BuildingNumber+" "+response.Items[0].PrimaryStreet+" "+response.Items[0].Line2);
				}
				else
				{
				$('#risk_address').val(response.Items[0].BuildingNumber+" "+response.Items[0].PrimaryStreet+" "+response.Items[0].Line2);
				}
			
			}			 
			else
			{
			$('#risk_address').val(response.Items[0].Company+" "+response.Items[0].BuildingName+" "+response.Items[0].SubBuilding+" "+response.Items[0].BuildingNumber+" "+response.Items[0].PrimaryStreet+" "+response.Items[0].Line3);
			}
		
			$("#risk_postcode").val(response.Items[0].Postcode);
			$("#risk_town").val(response.Items[0].PostTown);
			if(response.Items[0].County==""){
				$("#risk_county").val(response.Items[0].County).removeAttr('readonly');
			}else{
				$("#risk_county").val(response.Items[0].County).attr('readonly','readonly');	
			}
        }
    }
}


function CorRetriveDetails(Id)
{
	var script = document.createElement("script"),
        head = document.getElementsByTagName("head")[0],
        url = "https://services.postcodeanywhere.co.uk/PostcodeAnywhere/Interactive/RetrieveById/v1.30/json3.ws?";

    // Build the query string
    url += "&Key=" + encodeURIComponent('TA79-RX96-FZ96-PC48');
    url += "&Id=" + encodeURIComponent(Id);
    url += "&PreferredLanguage=" + encodeURIComponent('English');
    url += "&callback=corRiskPostcodeRetrive";

    script.src = url;

    // Make the request
    script.onload = script.onreadystatechange = function () {
        if (!this.readyState || this.readyState === "loaded" || this.readyState === "complete") {
            script.onload = script.onreadystatechange = null;
            if (head && script.parentNode)
                head.removeChild(script);
        }
    }

    head.insertBefore(script, head.firstChild);
}

function corRiskPostcodeRetrive(response) 
{
    // Test for an error
    if (response.Items.length == 1 && typeof(response.Items[0].Error) != "undefined") {
        // Show the error message
        alert(response.Items[0].Description);
    }
    else {
        // Check if there were any items found
        if (response.Items.length == 0)
            alert("Sorry, there were no results");
        else {
			//alert(response.Items[0].Department+'----'+response.Items[0].BuildingNumber+'----'+response.Items[0].SubBuilding+'----'+response.Items[0].BuildingName);
			/*if(response.Items[0].BuildingNumber)
			{
			$('#cor_risk_address').val(response.Items[0].BuildingNumber+" "+response.Items[0].PrimaryStreet+" "+response.Items[0].SecondaryStreet+" "+response.Items[0].Line2);
			}
			else
			{
			$('#cor_risk_address').val(response.Items[0].Company+" "+response.Items[0].BuildingName+" "+response.Items[0].PrimaryStreet+" "+response.Items[0].SecondaryStreet+" "+response.Items[0].Line3);
			}*/
			if(response.Items[0].BuildingNumber)
			{

				if((response.Items[0].BuildingNumber) && (response.Items[0].Company))
				{
				$('#cor_risk_address').val(response.Items[0].Company+" "+response.Items[0].BuildingName+" "+response.Items[0].BuildingNumber+" "+response.Items[0].PrimaryStreet+" "+response.Items[0].Line2);
				}
				else
				{
				$('#cor_risk_address').val(response.Items[0].BuildingNumber+" "+response.Items[0].PrimaryStreet+" "+response.Items[0].Line2);
				}
			
			}			 
			else
			{
			$('#cor_risk_address').val(response.Items[0].Company+" "+response.Items[0].BuildingName+" "+response.Items[0].SubBuilding+" "+response.Items[0].BuildingNumber+" "+response.Items[0].PrimaryStreet+" "+response.Items[0].Line3);
			}
			$("#cor_risk_postcode").val(response.Items[0].Postcode);
			$("#cor_risk_town").val(response.Items[0].PostTown);
			if(response.Items[0].County==""){
				$("#cor_risk_county").val(response.Items[0].County).removeAttr('readonly');
			}else{
				$("#cor_risk_county").val(response.Items[0].County).attr('readonly','readonly');	
			}
        }
    }
}

// postcode api



function killBackSpace(e) {
        e = e ? e : window.event;
        var t = e.target ? e.target : e.srcElement ? e.srcElement : null;
        if (t && t.tagName && (t.type && /(password)|(text)|(file)/.test(t.type.toLowerCase())) || t.tagName.toLowerCase() == 'textarea')
            return true;
        var k = e.keyCode ? e.keyCode : e.which ? e.which : null;
        if (k == 8) {
            if (e.preventDefault)
                e.preventDefault();
            return false;
        };
        return true;
    };
 
    if (typeof document.addEventListener != 'undefined')
        document.addEventListener('keydown', killBackSpace, false);
    else if (typeof document.attachEvent != 'undefined')
        document.attachEvent('onkeydown', killBackSpace);
    else {
        if (document.onkeydown != null) {
            var oldOnkeydown = document.onkeydown;
            document.onkeydown = function(e) {
            oldOnkeydown(e);
            killBackSpace(e);
            };
        }
 
        else
            document.onkeydown = killBackSpace;
    }
