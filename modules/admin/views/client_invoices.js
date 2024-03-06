
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


});


