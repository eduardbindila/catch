
$(document).ready(function() {


	$('textarea, input:not([type="radio"]):not([type="checkbox"]):not([type="hidden"]):not([type="button"]):not([type="submit"])').before(function(){
		var placeholder = $(this).attr('placeholder');

		$(this).removeAttr('placeholder');
		
		return '<label>'+placeholder+'</label>';
	})

	$('select').before(function(){
		return '<label>'+$(this).find("option:first-child").text()+'</label>';
	})
});

