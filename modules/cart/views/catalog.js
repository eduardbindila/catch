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
                "data": "initial_price"
            },
            { 
                "data": "aquisition_price",
                "visible": iss
            },
        ],
        "drawCallback": function(settings, json) {
        }
    });


});
