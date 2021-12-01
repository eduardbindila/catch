$(document).ready(function() {

    $.ajax({
        url: "/ajax/getCategoryBreadcrumbs",
        type: "post",
        dataType: "json",
        data: {'parent_id': parent_id}
    }).done(function(json){
        //console.log(json);

        var urlPrefix = '';
        jQuery.each(json, function(index, item) {
            // do something with `item` (or `this` is also `item` if you like)
            
            urlPrefix = urlPrefix + item.parent_id;
            //console.log(urlPrefix);
            var li = '<li><a href="/cart/catalog/'+urlPrefix+'/'+item.id+'/">'+item.category_name+'</a></li>';

            //console.log(li);
            $('.breadcrumb').append(li)
        });

    }).error(function(xhr, status, error) {

    })


    var projectsTable = $('.results-table ').DataTable({
       data: productList,
        pageLength: 100,
            "paging":   true,
            "ordering": false,
            "searching": true,
        rowId: 'category_slug',
          
        responsive: true,
        order: [1],
        "columns": [ 
            { 
                "data": "product_image",
                className: "product_image",
                "render" : function(data, type, row) {
                     if(!data){
                        return '<img src="http://ideyafoana.com/api/public/storage/photo/no-image.png" class="table-image" />'
                        
                    } else {
                          return '<img src="'+data+'" class="table-image" />'
                    }                       
                  } 

            },
             { 
                "data": "id",
                "render" : function(data, type, row) {
                    return '<a href="/cart/product/'+data+'" target="_blank">'+data+'</a>'
                  } 
            },
            { 
                "data": "product_name"
            },
            { 
                "data": "initial_price",
                "render" : function(data, type, row) {
                    return parseFloat(data).toFixed(2);
                  } 
            },
            { 
                "data": "aquisition_price",
                "visible": iss
            },
             { 
                "data": null, 
               "render" : function(data, type, row) {
                    return '<button class="addToWishlist btn btn-success waves-effect notificationTrigger" data-placement-from="top" data-delay="600"  data-show-time="600" data-placement-align="center"data-animate-enter="" data-text="Product added to wishlist" data-animate-exit=""data-color-name="alert-success" data-id="'+row.id+'">Add to Wishlist</button>'
                  } 
            }, 
        ],
        "drawCallback": function(settings, json) {
        }
    });

    $('.addToWishlist').on('click', function(e){
        var productId = $(this).attr('data-id');

        var existingWishlist = wishlist.length > 0 ? wishlist : JSON.stringify(wishlist)

        $.ajax({
            url: "/ajax/updateWishlist",
            type: "post",
            dataType: "json",
            data: {'productId': productId, 'existingWishlist': existingWishlist}
        }).success(function(json){
            createWishlist();
        })
        
    })

    $('.notificationTrigger').on('click', function () {
       
        var placementFrom = $(this).data('placement-from');
        var placementAlign = $(this).data('placement-align');
        var animateEnter = $(this).data('animate-enter');
        var animateExit = $(this).data('animate-exit');
        var colorName = $(this).data('color-name');
        var time = $(this).data('show-time');
        var delay = $(this).data('delay');
        var text = $(this).data('text');

        showNotification(colorName, text, placementFrom, placementAlign, animateEnter, animateExit, time, delay);
    });




});
