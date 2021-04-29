
$(document).ready(function() {
    
    var productsTable = $('.products_table').DataTable({
        "ajax": {
            "url": "/ajax/getProducts/",
            "dataSrc": ""
        },
        dom: 'lfrtip',
        pageLength: 100,
            "paging":   true,
            "ordering": true,
            "filtering": true,
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
                "data": "last_crawled_date"
            }
        ],
        "initComplete": function(settings, json) {
            console.log('a');
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }

    });

});