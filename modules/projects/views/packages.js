
$(document).ready(function() {

var quoteID = getLastFolderFromUrl(window.location.href);

$('.quoteId').text(quoteID);

    var quotesTable = $('.packages-table').DataTable({
            "ajax": {
                "url": "/ajax/getQuotePackages",
                "type": "POST",
                 "dataSrc": "",
                data: { 'quote_id': quoteID}
            },
        
            pageLength: 100,
                "paging":   true,
                "ordering": true,
                "searching": true,
            rowId: 'category_slug',
              
            responsive: true,
            "columns": [ 
                { 
                    "data": "id",
                    
                },
                { 
                    "data": "created_date",
                    
                },
                { 
                    "data": "name",
                    
                },
                { 
                    "data": null,
                    defaultContent: '',
                    "render" : function(data, type, row, meta) {
                          },
  
                }
                
            ],
            "initComplete": function(settings, json) {
            }

        });

});

