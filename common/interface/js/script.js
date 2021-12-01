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

	$('.viewWishlistProducts').on('click', function(e){

        $.ajax({
            url: "/ajax/viewWishlistProducts",
            type: "post",
            dataType: "json",
            data: {'wishlist': wishlist}
        }).success(function(json){

        	 wishlistProductsArray = json == "" ? [] : json;

        	 var wishlistArray = JSON.parse(wishlist);

           	 if(json !== "") {

           	 	$('.wishlistProducts').empty();
            
	             wishlistArray.forEach(function(productId) {
	             	var item = wishlistProductsArray[productId];
	             	console.log(item, productId);
				    var li =   '<li class="list-group-item clearfix">'+
					                '<img src="'+item.product_image+'" class="table-image pull-left">'+
					                '<div class="product-title pull-left">'+item.product_name+'</div>'+
					               '<div class="price pull-right">'+parseFloat(item.initial_price).toFixed(2)+'</div>'+
					            '</li>';
		           
		            $('.wishlistProducts').append(li)
				});
            }

          
        })
        
    })
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

           	 	var wishlistLength = wishlistArray.length;
           	 	//console.log(wishlistLength);

           	 	$('.viewWishlistProducts .label-count').html(wishlistLength);


		        wishlistArray.forEach(function(item) {
				    var li = '<li>'+item+'</li>';

		            //console.log(li);
		            $('.wishlist').append(li)
				});
           	 }
	        
        })
}



function showNotification(colorName, text, placementFrom, placementAlign, animateEnter, animateExit, time, delay) {

    if (colorName === null || colorName === '') { colorName = 'bg-black'; }
    if (text === null || text === '') { text = 'Turning standard Bootstrap alerts'; }
    if (animateEnter === null || animateEnter === '') { animateEnter = 'animated fadeInDown'; }
    if (animateExit === null || animateExit === '') { animateExit = 'animated fadeOutUp'; }
    if (time === null || time === '') { time = '10000'; }
    if (delay === null || delay === '') { delay = '10000'; }
    var allowDismiss = true;
    $.notify({
        message: text
    },
        {
            type: colorName,
            allow_dismiss: allowDismiss,
            newest_on_top: true,
            delay: delay,
            timer: time,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            animate: {
                enter: animateEnter,
                exit: animateExit
            },
            template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
        });
}