$(function(){	
	
	$("#gr_form").validate({
		rules: {
			grp_name: {
				required: true,
				minlength: 1
			},
			company: {
				required: true
			},
			phone: {
				required: true,
				number: true,
				minlength: 5
			},
			email: {
				required: true,
				email: true
			},
			message: {
				required: true
			},
			prod_id:{
				required:true
			}
		},
		messages: {
			grp_name: {
				required: 'This field irequired',
				minlength: 'Minimum length: 1'
			},
			company: {
				required: 'This field is required'
			},
			phone: {
				required: 'This field is required',
				number: 'Invalid phone number',
				minlength: 'Minimum length: 5'
			},
			email: 'Invalid e-mail address',
			message: {
				required: 'This field is required'
			},
			prod_id:{
				required:'This field irequired'
			}
		},
		
		success: function(label) {
			label.html('OK').removeClass('error').addClass('ok');
			setTimeout(function(){
				label.fadeOut(500);
			}, 2000)
		}
	});
		
});