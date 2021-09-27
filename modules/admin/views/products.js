
$(document).ready(function() {
    
    var productsTable = $('.products_table').DataTable({
        "processing": true,
        "serverSide": true,
        'serverMethod': 'post',
        "ajax": "/ajax/getProducts/",
        pageLength: 10,
            "paging":   true,
            "ordering": true,
            "searching": true,
        rowId: 'category_slug',
          
        responsive: true,
        order: [[ 1, "asc" ]],
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
                    return '<a href="../cart/product/'+data+'" target="_blank">'+data+'</a>'
                  } 
            },
            { 
                "data": "product_name"
            }
            ,
            { 
                "data": "manufacturer"
            } ,
            { 
                "data": "is_temporary"
            },
            { 
                "data": "initial_price"
            },
            { 
                "data": "last_crawled_status"
            },
            {
                "data": "merged_id"
            }
        ],
        "initComplete": function(settings, json) {
        }

    });

});