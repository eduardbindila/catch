
$(document).ready(function() {
    var projectsTable = $('.projects_table').DataTable({
        "ajax": {
            "url": "/ajax/getUserTypes/",
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
            },
            { 
                "data": "user_type_name"
            },
            { 
                "data": "null",
                "render" : function(data, type, row) {
                    if((row.id == 1 || row.id == 5) && !isa) {

                        return 'Only SuperAdmin can change this.'
                        
                    } else {
                        return '<button class="btn btn-default waves-effect editAccess" data-toggle="modal" data-id="'+row.id+'" data-name="'+row.user_type_name+'" data-target="#editAccess-modal">Edit</button>'
                    }
                    
                  } 
            },
        ],
        "drawCallback": function(settings, json) {
            $('.editAccess').on('click', function() {
                var typeId = $(this).attr('data-id');
                var typeName = $(this).attr('data-name');


                $('#accessName, #user-type-id').text(typeName);
                $('#user-type-id').val(typeId);

                $.ajax({
                    url: "/ajax/getAccess",
                    type: "post",
                    dataType: "json",
                    data: {'user_type': typeId}
               }).success(function(json){
                console.log(json)
                
                  for(el in json) {
                    var val = json[el];
                    console.log(val['access_type']);
                        $('#accessElements').find('#access_'+val['access_type']).prop('checked', true);
                  
                   }
                }).error(function(xhr, status, error) {
                    //$('.addNewTemporaryProduct').removeClass('hidden');
                })
            });
        }
    });

    
});