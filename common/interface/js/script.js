
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

	$('.clearWishlist').on('click', function(e){

        $.ajax({
            url: "/ajax/updateWishlist",
            type: "post",
            dataType: "json",
            data: {'clear':1}
        }).success(function(json){
            createWishlist();
            $('.wishlistProducts').empty();
        })
        
    })


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
	             	//console.log(item, productId);
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


           		var wishlistLength;

           	 	if(wishlist.length == 0) {
           	 		wishlistLength = wishlist.length
           	 	} else {
           	 		var wishlistArray = JSON.parse(json);

           	 		wishlistLength = wishlistArray.length;
           	 	}
           	 	
           	 	//console.log(wishlistLength);

           	 	$('.viewWishlistProducts .label-count').html(wishlistLength);


           	 if(json !== "") {
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

function convertMysqlDate(date){
    
    var date = new Date(date);
    var yyyy = date.getFullYear();
    let mm = date.getMonth() + 1; // Months start at 0!
    let dd = date.getDate();

    if (dd < 10) dd = '0' + dd;
    if (mm < 10) mm = '0' + mm;

    var formatteDate = dd + '/' + mm + '/' + yyyy;

    return formatteDate
}

function saveGeneratedFileToServer(params) {

    var fd = new FormData();
    fd.append('file_name', params.file_name);
    fd.append('file_extension', params.file_extension);
    fd.append('data', params.blob);
    $.ajax({
        type: 'POST',
        url: '/ajax/saveBlob',
        data: fd,
        processData: false,
        contentType: false
    }).done(function(data) {
           //console.log(data);

           //"values" => [$_POST['quote_id'], $_POST['file_name'], strtotime('now'), $_SESSION['user_id'], $_POST['file_type'], $_POST['send_to_client']]

           var saveFileDetails = {
            "quote_id": params.quote_id,
            "file_name": params.file_name+'.'+params.file_extension,
            "file_type": params.file_type,
            "file_extension": params.file_extension,
            "send_to_client": 0
           }

           $.ajax({
                url: "/ajax/saveFilesToQuote",
                type: "post",
                dataType: "json",
                data: saveFileDetails
            }).success(function(json){
               
            }).error(function(xhr, status, error) {
               
            })


    });
        
}

function getLatestInvoiceNumber(params) {
    var latestInvoiceNumber;

    $.ajax({
            url: "/ajax/getLatestInvoiceNumber",
            type: "post",
            dataType: "json",
            data: params,
            async: false
        }).success(function(json){
           
            latestInvoiceNumber = json
        })
    return latestInvoiceNumber
}


function waitForElm(selector) {
    return new Promise(resolve => {
        if (document.querySelector(selector)) {
            console.log("Element found immediately:", selector);
            return resolve(document.querySelector(selector));
        }

        console.log("Observing for element:", selector);
        const observer = new MutationObserver(mutations => {
            if (document.querySelector(selector)) {
                console.log("Element found:", selector);
                resolve(document.querySelector(selector));
                observer.disconnect();
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    });
}

function getLastFolderFromUrl(url) {
     url = url.replace(/\/+$/, "");
     
    // Divizează URL-ul în bucăți folosind "/"
    var urlParts = url.split("/");
    
    // Parcurge bucățile URL-ului de la dreapta la stânga
    for (var i = urlParts.length - 1; i >= 0; i--) {
        // Verifică dacă bucata curentă este un număr
        if (!isNaN(urlParts[i])) {
            // Returnează numărul găsit (posibil ID)
            return parseInt(urlParts[i]);
        }
        // Dacă nu este un număr și nu este un șir gol, se consideră că este ultimul folder
        else if (urlParts[i].trim() !== "") {
            return urlParts[i];
        }
    }
    // Dacă nu se găsește niciun folder sau număr, se returnează null
    return null;

}