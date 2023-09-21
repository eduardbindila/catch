$(document).ready(function() {
    var projectsTable = $('.projects_table').DataTable({
        "ajax": {
            "url": "/ajax/getOptions/",
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
                "visible": false
            },
            { 
                "data": "name"
            },
            { 
                "data": "option_key"
            },
             { 
                "data": "value"
            },
            { 
                "data": "null",
                "render" : function(data, type, row) {
                    if((row.id == 1 || row.id == 5) && !isa) {

                        return 'Only SuperAdmin can change this.'
                        
                    } else {
                        return '<button class="btn btn-default waves-effect editOption" data-toggle="modal" data-key="'+row.option_key+'" data-id="'+row.id+'" data-name="'+row.name+'" data-value="'+row.value+'" data-target="#editOption-modal">Edit</button>'
                    }
                    
                  } 
            },
        ],
        "drawCallback": function(settings, json) {
            $('.editOption').on('click', function() {
                var typeId = $(this).attr('data-id');
                var typeName = $(this).attr('data-name');
                var typeKey = $(this).attr('data-key');
                var typeValue = $(this).attr('data-value');


                $('#optionName').val(typeName);

                $('#optionKey').val(typeKey);

                $('#optionId').val(typeId);

                $('#optionValue').val(typeValue);

        	})
        }
    })

console.log(insertResult);

     if(insertResult) {
        $('.addUserSuccess').removeClass('hidden')
    } else if(insertResult == 0) {
        $('.addUserError').removeClass('hidden')
    }
});