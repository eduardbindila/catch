
$(document).ready(function() { 


 var importLists = $('.importLists_table').DataTable({
        "ajax": {
            "url": "/ajax/getImportProductsFromList/",
            "type": "POST",
            "data": {
                "listID": listID
            },
            "dataSrc": ""
        },    
        pageLength: 100,
            "paging":   true,
            "ordering": false,
            "searching": true,
        rowId: 'category_slug',
        responsive: true,
        order: [10],
        "columns": [ 
            { 
                "data": "id", 
            },
            { 
                "data": "product_id"
            },
            { 
                "data": "product_name"
            },
            { 
                "data": "saga_stock"
            },
            { 
                "data": "saga_comment"
            },
            { 
                "data": "new_product_id"
            },
            { 
                "data": "manufacturer"
            },
            { 
                "data": "old_price"
            },
            { 
                "data": "comment"
            },
            { 
                "data": "status",
                "visible": false
            },
            { 
                "data": "status_name"
            }
        ],
        "initComplete": function(settings, json) {
        }

    });

})


