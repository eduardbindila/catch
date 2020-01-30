
$(document).ready(function() {
    var projectsTable = $('.projects_legacy').DataTable({
            "ajax": {
                "url": "/ajax/getDashboardProjects",
                "type": "POST",
                "data": function ( d ) {
                    d.legacy = true;
                },
                "dataSrc": ""
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
                        return '<a href="/project/'+data+'" class="btn btn-block" target="_blank">'+data+'</a>'
                      } 
                },
                { 
                    "data": "legacy_id"
                },
                { 
                    "data": "parent_id"
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
                    "data": "specifyer_designer"
                },
                { 
                    "data": "quote_status"
                },
                { 
                    "data": "project_status"
                },
                { 
                    "data": "project_value"
                },
                { 
                    "data": "winning_chance"
                }
                
            ],
            "initComplete": function(settings, json) {
            }

        });

    var atentionTable = $('.quotes_attention').DataTable({
            "ajax": {
                "url": "/ajax/getQuotes",
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
                    "data": "project_id",
                    "render" : function(data, type, row) {
                        return '<a href="/project/'+data+'" class="btn btn-block" target="_blank">'+data+'</a>'
                      } 
                },
                { 
                    "data": "id"
                },
                { 
                    "data": "start_date"
                },
                { 
                    "data": "quote_price"
                },
                { 
                    "data": "profit_percent"
                },
                { 
                    "data": "winning_chance"
                }
                
            ],
            "initComplete": function(settings, json) {
            }

        });

    var quotesTable = $('.quotes-table').DataTable({
            "ajax": {
                "url": "/ajax/getDashboardQuotes",
                "type": "POST",
                "data": function ( d ) {
                    d.legacy = true;
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
                    "render" : function(data, type, row) {
                        return '<a href="/quote/'+data+'" class="btn btn-block" target="_blank">'+data+'</a>'
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
                    "data": "quote_status"
                },
                
            ],
            "initComplete": function(settings, json) {
            }

        });
});

