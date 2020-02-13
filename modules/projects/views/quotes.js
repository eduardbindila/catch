
$(document).ready(function() {
    var quotesTable = $('.quotes-table').DataTable({
            "ajax": {
                "url": "/ajax/getDashboardQuotes",
                "type": "POST",
                "data": function ( d ) {
                    return {"client_id": 0}
                },
                "dataSrc": ""
            },
        
            pageLength: 100,
                "paging":   true,
                "ordering": true,
                "searching": true,
            rowId: 'category_slug',
              
            responsive: true,
            order: [2],
            "columns": [ 
                { 
                    "data": "id",
                    
                },
                { 
                    "data": "project_id",
                    "render" : function(data, type, row) {
                        return '<a href="/project/'+data+'" class="btn btn-block">'+data+'</a>'
                      } 
                },
                { 
                    "data": "start_date"
                },
                { 
                    "data": "offer_date"
                },
                { 
                    "data": "owner"
                },
                { 
                    "data": "client"
                },
                { 
                    "data": "quote_status"
                },
                
            ],
            "initComplete": function(settings, json) {
            }

        });

});

