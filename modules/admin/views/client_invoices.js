
$(document).ready(function() {

    $('#invoiceData').find('input, textarea, button, select').attr('disabled','disabled');

    var projectsTable = $('.invoices_table').DataTable({
        "ajax": {
            "url": "/ajax/getInvoicesList/",
            "dataSrc": "",
        },
    
        pageLength: 100,
            "paging":   true,
            "ordering": true,
            "searching": true,
        rowId: 'category_slug',
          
        responsive: true,
        order: [0],
        "columns": [ 
            { 
                "data": "id",
                "render" : function(data, type, row) {
                    return '<a href="client-invoices/'+data+'" target="_blank">'+data+'</a>'
                  } 
            },
            { 
                "data": "quote_id",
                "render" : function(data, type, row) {
                    return '<a href="/quote/'+data+'" target="_blank">'+data+'</a>'
                  } 
            },
            { 
                "data": "invoice_number"
            },
            { 
                "data": "name"
            },
            { 
                "data": "invoice_date"
            },
            { 
                "data": "invoice_due_date"
            },
            { 
                "data": "saga_code"
            },
            { 
                "data": "status_name"
            }
        ],
        "initComplete": function(settings, json) {
        }

    });
    


    var packageId = $('.packageId').attr('data-package-id');

    console.log(packageId);

    var invoiceItem = $('.invoice_items_table').DataTable({
        "ajax": {
            "url": "/ajax/getPackageData/",
            "dataSrc": "",
            "type": 'POST',
            "data": {'package_id': packageId}
        },
    
        pageLength: 100,
            "paging":   true,
            "ordering": true,
            "searching": true,
        rowId: 'category_slug',
          
        responsive: true,
        order: [],
        "columns": [ 
            { 
                "data": "no_crt",
            },
            { 
                "data": "product_id", 
            },
            { 
                "data": "product_name"
            },
            { 
                "data": "quantity"
            },
            { 
                "data": "unit_price_with_exchange_rate"
            },
            { 
                "data": "green_tax"
            },
            { 
                "data": "total_novat_line_price"
            },
            { 
                "data": "total_line_vat"
            },
            { 
                "data": "total_line_price"
            }
        ],
        "initComplete": function(settings, json) {
        },
        "footerCallback": function(row, data, start, end, display) {
            var api = this.api();
            
            // Calcularea totalurilor pentru fiecare coloană
            var totalQuantity = api.column(3, { page: 'current' }).data().reduce(function(a, b) {
                return parseFloat(a || 0) + parseFloat(b || 0);
            }, 0);
            
            var totalUnitPrice = api.column(4, { page: 'current' }).data().reduce(function(a, b) {
                return parseFloat(a || 0) + parseFloat(b || 0);
            }, 0);
            
            var totalGreenTax = api.column(5, { page: 'current' }).data().reduce(function(a, b) {
                return parseFloat(a || 0) + parseFloat(b || 0);
            }, 0);
            
            var totalNovatLinePrice = api.column(6, { page: 'current' }).data().reduce(function(a, b) {
                return parseFloat(a || 0) + parseFloat(b || 0);
            }, 0);
            
            var totalLineVat = api.column(7, { page: 'current' }).data().reduce(function(a, b) {
                return parseFloat(a || 0) + parseFloat(b || 0);
            }, 0);
            
            var totalLinePrice = api.column(8, { page: 'current' }).data().reduce(function(a, b) {
                return parseFloat(a || 0) + parseFloat(b || 0);
            }, 0);

            // Afișarea totalurilor în footer
            $(api.column(3).footer()).html(totalQuantity.toFixed(2));
            $(api.column(4).footer()).html(totalUnitPrice.toFixed(2));
            $(api.column(5).footer()).html(totalGreenTax.toFixed(2));
            $(api.column(6).footer()).html(totalNovatLinePrice.toFixed(2));
            $(api.column(7).footer()).html(totalLineVat.toFixed(2));
            $(api.column(8).footer()).html(totalLinePrice.toFixed(2));
        }
    });


});


