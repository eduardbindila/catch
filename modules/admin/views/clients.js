
$(document).ready(function() {
    var projectsTable = $('.projects_table').DataTable({
        "ajax": {
            "url": "/ajax/getClients/",
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
                    return '<a href="client/'+data+'" target="_blank">'+data+'</a>'
                  } 
            },
            { 
                "data": "name"
            }
            ,
            { 
                "data": "email"
            },
            { 
                "data": "phone"
            }
        ],
        "initComplete": function(settings, json) {
        }

    });

    $.ajax({
        url: "/ajax/getUsers",
        type: "post",
        dataType: "json",
    }).done(function(json){
       $.each(json, function (i, item) {
            $('.userTypesSelector').append($('<option>', { 
                value: item.id,
                text : item.name
            }));
        });
       if(isDisabled)
        $("#userData select[name=user]").val(userDetails.user_id);

    }).error(function(xhr, status, error) {
        $('.userTypesSelectorError').removeClass('hidden');
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
        $("#userData input[name=fiscal_code]").val(userDetails.fiscal_code);
        $("#userData input[name=email]").val(userDetails.email);
        $("#userData input[name=phone]").val(userDetails.phone);
        $("#userData input[name=country]").val(userDetails.country);
        $("#userData input[name=state]").val(userDetails.state);
        $("#userData input[name=address]").val(userDetails.address);
        $("#userData input[name=bank_account]").val(userDetails.bank_account);
        $("#userData input[name=bank]").val(userDetails.bank);
        $("#userData input[name=registry]").val(userDetails.registry);
        $("#userData input[name=discount]").val(userDetails.discount);
    }

     $('.editSwitch').change(function() {
        isDisabled = !isDisabled;
        if(!isDisabled) {
            $('#userData').find('input, textarea, button, select').prop("disabled", false);;
        } else {
            $('#userData').find('input, textarea, button, select').attr('disabled','disabled');
        }      
    })

    var commentsTable = $('.comments_table').DataTable({
        "ajax": {
            "url": "/ajax/getClientComments/",
            "dataSrc": "",
            "type": 'POST',
            "data": {'client_id': userDetails.user_id}
        },
    
        pageLength: 100,
            "paging":   true,
            "ordering": false,
            "searching": true,
        rowId: 'category_slug',
          
        responsive: true,
        //order: [1],
        "columns": [ 
            { 
                "data": "id",
            },
            { 
                "data": "name",
            },
            { 
                "data": "comment",
            },
            {
                "data": "date",
                "render" : function(data, type, row) {
                    var date = new Date(data*1000)
                    return date.toLocaleString();
              } 
            }
        ],
        "initComplete": function(settings, json) {
        }

    });

    $('.commentForm').on('submit', function(e){

            e.preventDefault();

            var data = $(this).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});


            $.ajax({
                url: "/ajax/addClientComment",
                type: "post",
                dataType: "json",
                data: {'client_id': userDetails.user_id, 'data': data}
           }).success(function(json){
               $('.updateError').addClass('hidden');
               location.reload()
            }).error(function(xhr, status, error) {
               $('.updateError').removeClass('hidden');
            })
        })

});