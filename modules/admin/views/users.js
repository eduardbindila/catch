
$(document).ready(function() {
    var projectsTable = $('.projects_table').DataTable({
        "ajax": {
            "url": "/ajax/getUsers/",
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
                    return '<a href="user/'+data+'" target="_blank">'+data+'</a>'
                  } 
            },
            { 
                "data": "name"
            }
            ,
            { 
                "data": "user_type_name"
            }
        ],
        "initComplete": function(settings, json) {
        }

    });

    $.ajax({
        url: "/ajax/getUserTypes",
        type: "post",
        dataType: "json",
    }).done(function(json){
        $.each(json, function (i, item) {
            $('.userTypesSelector').append($('<option>', { 
                value: item.id,
                text : item.user_type_name 
            }));

        });
       if(isDisabled)
        $("#userData select[name=user_type]").val(userDetails.type_id);

    }).error(function(xhr, status, error) {
        $('.userTypesSelectorError').removeClass('hidden');
    })

     $.ajax({
        url: "/ajax/getClients",
        type: "post",
        dataType: "json",
    }).done(function(json){
        $.each(json, function (i, item) {
            $('.clientSelector').append($('<option>', { 
                value: item.id,
                text : item.name 
            }));
       
        });
       if(isDisabled)
        $("#userData select[name=client_id]").val(userDetails.isClient);

    }).error(function(xhr, status, error) {
        $('.clientSelector').removeClass('hidden');
    })


    if(insertResult) {
        $('.addUserSuccess').removeClass('hidden')
    } else if(insertResult == 0) {
        $('.addUserError').removeClass('hidden')
    }

    if(isDisabled) {
        $('#userData').find('input, textarea, button, select').attr('disabled','disabled');
        userDetails = userDetails[0];
        $("#userData input[name=name]").val(userDetails.name);
        $("#userData input[name=username]").val(userDetails.username);
        $("#userData input[name=email]").val(userDetails.email);
        $("#userData input[name=phone]").val(userDetails.phone);
        $("#userData input[name=password]").val(userDetails.password);
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