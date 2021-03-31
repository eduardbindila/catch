
$(document).ready(function() {
    var projectsTable = $('.projects_table').DataTable({
        "ajax": {
            "url": "/ajax/getProjectCategories/",
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
                "render" : function(data, type, row) {
                    return '<a href="pcategory/'+data+'" target="_blank">'+data+'</a>'
                  } 
            },
            { 
                "data": "category_name"
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
        $("#userData input[name=name]").val(userDetails.category_name);
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