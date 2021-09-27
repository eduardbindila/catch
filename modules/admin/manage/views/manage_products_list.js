
$(document).ready(function() { 


 var importLists = $('.importLists_table').DataTable({
        "ajax": {
            "url": "/ajax/getImportProductLists/",
            "dataSrc": ""
        },
    
        pageLength: 100,
            "paging":   true,
            "ordering": false,
            "searching": true,
        rowId: 'category_slug',
          
        responsive: true,
        order: [1],
        "columns": [ 
            { 
                "data": "id",
                // "render" : function(data, type, row) {
                //     return '<a href="user/'+data+'" target="_blank">'+data+'</a>'
                //   } 
            },
            { 
                "data": "name"
            }
            ,
            { 
                "data": "date_uploaded",
                "render" : function(data, type, row) {

                    return beatifyTimestamp(data);
                  } 
            }
            ,
            { 
                "data": "date_started",
                "render" : function(data, type, row) {

                    return beatifyTimestamp(data);
                  } 
            }
            ,
            { 
                "data": "date_finished",
                "render" : function(data, type, row) {

                    return beatifyTimestamp(data);
                  } 
            },
            { 
                "data": "file_url"
            }
            ,
            { 
                "data": "status"
            }
            ,
            { 
                "data": "user"
            }, 
            {
                "data": null,
                 "render" : function(data, type, row) {
                    return ''
                  } 
            }
        ],
        "initComplete": function(settings, json) {
        }

    });



})

function beatifyTimestamp(inputDate){
    if(inputDate == 0 ) {
        return "n/a"
    } else {
        var date = new Date(inputDate*1000)
        return beautyfullDate = date.toLocaleDateString();  
    }
              
}


