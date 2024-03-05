
$(document).ready(function() {

    selectedClients = [];

    var projectsTable = $('.projects_table').DataTable({
        "ajax": {
            "url": "/ajax/getAllClients/",
            "dataSrc": ""
        },
        dom: 'Blfrtip',
        pageLength: 100,
            "paging":   true,
            "ordering": true,
            "searching": true,
        rowId: 'category_slug',
          
        responsive: true,
        buttons: [
        {
            extend: 'selectAll',
            className: 'btn btn-lg btn-primary waves-effect',
            action: function () {
                    var count = projectsTable.rows( { search: 'applied' } ).count();
                    projectsTable.rows({ search: 'applied' }).select();
                    console.log(count);
 
                    //events.prepend( '<div>'+count+' row(s) selected</div>' );
                }
        },
        {
            extend: 'selectNone',
            className: 'btn btn-lg btn-primary waves-effect',
        },
         {
            extend: 'selected',
            className: 'deactivateClients btn btn-lg btn-success waves-effect',
            text: 'Deactivate clients',
            action: function ( e, dt, button, config ) {

                var selection = dt.rows( { selected: true } ).data();
                var i;
                for ( i = 0; i < selection.length; i++) {
                    selectedClients.push(selection[i].id);
                }

                updateClients(selectedClients, 0);
            },
        },
        {
            extend: 'selected',
            className: 'activateClients btn btn-lg btn-success waves-effect',
            text: 'Activate clients',
            action: function ( e, dt, button, config ) {

                var selection = dt.rows( { selected: true } ).data();
                var i;
                for ( i = 0; i < selection.length; i++) {
                    selectedClients.push(selection[i].id);
                }

                updateClients(selectedClients, 1);
            }
        }],
        order: [2, 'asc'],
        "columns": [
            { 
                "data": null, 
                defaultContent: '' 
            }, 
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
            },
            { 
                "data": "country"
            },
            { 
                "data": "active",
                 "render" : function(data, type, row) {
                    if(data == 1)
                        return 'Yes'
                    else 
                        return "No"
                  } 
            }
        ],
        select: {
            style:    'multi',
            selector: 'td:first-child'
        },
        columnDefs : [
            {
                orderable : false,
                className : 'select-checkbox',
                targets : 0
            },
        ],
        "initComplete": function(settings, json) {
        }

    });

    $.ajax({
        url: "/ajax/getAgentUsers",
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

    $.ajax({
        url: "/ajax/getCountries",
        type: "post",
        dataType: "json",
    }).done(function(json){
       $.each(json, function (i, item) {
            $('.countryTypesSelector').append($('<option>', { 
                value: item.id,
                text : item.name
            }));
        });
       if(isDisabled)
        $("#userData select[name=country]").val(userDetails.country);

    }).error(function(xhr, status, error) {
        $('.countryTypesSelectorError').removeClass('hidden');
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
        $("#userData input[name=poi]").val(userDetails.poi);
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
        $("#userData input[name=saga_code]").val(userDetails.saga_code);
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


function updateClients(clientsList, action){
    console.log(clientsList, action)

    $.ajax({
        url: "/ajax/updateClientsActive",
        type: "post",
        dataType: "json",
        data: {"clients_list": clientsList, "value": action}
    }).done(function(json){
       location.reload();

    }).error(function(xhr, status, error) {
        $('.addUserError').removeClass('hidden')
    })

    
}