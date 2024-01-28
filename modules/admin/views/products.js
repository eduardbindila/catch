
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
        order: [[ 7, "asc" ]],
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
                    return '<a href="../cart/product?id='+encodeURIComponent(data)+'" target="_blank">'+data+'</a>'
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
                "data": "initial_price"
            },
             { 
                "data": "list_price"
            },
            { 
                "data": "green_tax_value"
            },
            { 
                "data": "reserved_quantity"
            },
            { 
                "data": "saga_quantity"
            },
            { 
                "data": "last_crawled_status"
            },
            {
                "data": "merged_id"
            },
            {
                "data": "legacy_id"
            },
            {
                "data": "nc_code"
            },
            {
                "data": "active"
            },
            {
                "data":"null",
                "render" : function(data,type,row){

                                var label = (parseInt(row.isService) == 0) ? "Mark as Service" : "Mark as Product";

                                var labelType = (parseInt(row.isService) == 0) ? "Product" : "Service";

                                console.log(parseInt(row.isService) == 0, row.isService);

                                var value = labelType + 

                                        ' <div class="btn-group">'+
                                            '<button class="btn btn-default btn-xs "' + 
                                            
                                            '" data-product="'+row.id+'" data-toggle="dropdown'+
                                            '" aria-haspopup="true" aria-expanded="true">'+
                                                    '<i class="material-icons">edit</i>'+ 
                                            '</button>'+
                                            '<div class="preloader pl-size-vxs hidden exchange_rate_preloader">' +
                        '<div class="spinner-layer pl-red-grey">' +
                            '<div class="circle-clipper left">' +
                                '<div class="circle"></div>' +
                            '</div>' +
                            '<div class="circle-clipper right">' +
                                '<div class="circle"></div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                                            '<ul class="dropdown-menu"'+
                                            
                                            
                                            '" data-product="'+row.id+'" data-toggle="dropdown">'+
                                                 '<li class="">' + 
                                                 
                                                    '<a class="markAsService waves-effect waves-block" data-isService="'+row.isService+'">' +
                                                        label +
                                                    '</a>'+
                                                '</li>'
                                            '</ul>'
                                        '</div>';

                        return value
                }
            }
        ],
        "initComplete": function(settings, json) {
            $('.exchange_rate_preloader').addClass('hidden');
        }

    });


$('body').on('click', '.markAsService', function(e){

      itemTypesData = {
        'product_id' : $(this).parents('ul').attr('data-product'),
        'isService' : +!parseInt($(this).attr('data-isService')),
      }

      //console.log(itemTypesData)

      $('.exchange_rate_preloader').removeClass('hidden');


      $.ajax({
            url: "/ajax/updateProductType",
            type: "post",
            dataType: "json",
            data: itemTypesData
        }).success(function(json){
           $('.updatePackageItemError').addClass('hidden');
           //console.log(json);

           productsTable.ajax.reload()
            


        }).error(function(xhr, status, error) {
            $('.updatePackageItemError').removeClass('hidden');
        })

    })

});