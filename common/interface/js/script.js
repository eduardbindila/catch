﻿
$(document).ready(function() {


	$('textarea, input:not([type="radio"]):not([type="checkbox"]):not([type="hidden"]):not([type="button"]):not([type="submit"])').before(function(){
		var placeholder = $(this).attr('placeholder');

		$(this).removeAttr('placeholder');
		
		return '<label>'+placeholder+'</label>';
	})

	$('select').before(function(){
		if(!$(this).hasClass('ms'))
			return '<label>'+$(this).find("option:first-child").text()+'</label>';
	})

	$('input:not([type="password"])').keyup(function() {
            if (this.value.match(/[^a-zA-Z0-9,.!?@()_-\s]/g)) {
                this.value = this.value.replace(/[^a-zA-Z0-9,.!?@()_-\s]/g, '');
            }

	});

	createWishlist();
});

var wishlist = [];

function createWishlist() {
		$.ajax({
            url: "/ajax/getWishlist",
            type: "post",
            dataType: "json",
        }).success(function(json){
           wishlist = json == "" ? [] : json;
           	 if(json !== "") {
           	 	var wishlistArray = JSON.parse(json);
		        wishlistArray.forEach(function(item) {
				    var li = '<li>'+item+'</li>';

		            //console.log(li);
		            $('.wishlist').append(li)
				});
           	 }
	        
        })
}
