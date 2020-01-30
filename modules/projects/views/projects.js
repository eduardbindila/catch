
$(document).ready(function() {
    var projectsTable = $('.projects_table').DataTable({
            "ajax": {
                "url": "/ajax/getProjects",
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
                    "data": "project_name"
                },
                { 
                    "data": "project_description"
                }
                
            ],
            "initComplete": function(settings, json) {
            }

        });

});

