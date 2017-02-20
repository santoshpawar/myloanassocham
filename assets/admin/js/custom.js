$(function(){
	$("select").css({opacity:0});
			
	$('select').change(function(){
		var attr = $(this).find("option:selected").text();
		$(this).parents('p').find("span.selectwrapper").text(attr);
	});
	$('select').each(function(){
		var attr = $(this).find("option:selected").text();
		$(this).parents('p').find("span.selectwrapper").text(attr);
	});
});
