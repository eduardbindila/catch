
$(document).ready(function() {
    var projectsTable = $('.projects_table').DataTable({
        "ajax": {
            "url": "/ajax/getVendors/",
            "dataSrc": ""
        },
    
        pageLength: 100,
            "paging":   true,
            "ordering": true,
            "searching": true,
        rowId: 'category_slug',
          
        responsive: true,
        order: [1, 'asc'],
        "columns": [ 
            { 
                "data": "id",
                "render" : function(data, type, row) {
                    return '<a href="vendor?id='+encodeURIComponent(data)+'" target="_blank">'+data+'</a>'
                  } 
            },
            { 
                "data": "name"
            },
             { 
                "data": "code"
            }
        ],
        "initComplete": function(settings, json) {
        }

    });


    if(insertResult) {
        $('.addUserSuccess').removeClass('hidden')
    } else if(insertResult == 0) {
        $('.addUserError').removeClass('hidden')
    }

    if(isDisabled) {
        $('#userData').find('input, textarea, button, select').attr('disabled','disabled');
        userDetails = userDetails[0];
        $("#userData input[name=name]").val(userDetails.name);
        $("#userData input[name=id]").val(userDetails.id);
        $("#userData input[name=code]").val(userDetails.code);
    }

     $('.editSwitch').change(function() {
        isDisabled = !isDisabled;
        if(!isDisabled) {
            $('#userData').find('input, textarea, button, select').prop("disabled", false);;
        } else {
            $('#userData').find('input, textarea, button, select').attr('disabled','disabled');
        }      
    })

});