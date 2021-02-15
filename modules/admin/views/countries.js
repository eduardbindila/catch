
$(document).ready(function() {
    var projectsTable = $('.projects_table').DataTable({
        "ajax": {
            "url": "/ajax/getCountries/",
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
            },
            { 
                "data": "name"
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

});