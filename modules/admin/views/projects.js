
$(document).ready(function() {

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
        $(".userTypesSelector[name=owner_id]").val(userDetails.owner_id);

    }).error(function(xhr, status, error) {
        $('.userTypesSelectorError').removeClass('hidden');
    })


    $.ajax({
        url: "/ajax/getProjectCategories",
        type: "post",
        dataType: "json",
    }).done(function(json){
       $.each(json, function (i, item) {
            $('.categorySelector').append($('<option>', { 
                value: item.id,
                text : item.category_name
            }));
        });
       if(isDisabled)
        $("#userData select[name=project_category]").val(userDetails.category_id);

    }).error(function(xhr, status, error) {
        $('.userTypesSelectorError').removeClass('hidden');
    })

    $.ajax({
        url: "/ajax/getProjectStatus",
        type: "post",
        dataType: "json",
    }).done(function(json){
       $.each(json, function (i, item) {
            $('.projectStatusSelector').append($('<option>', { 
                value: item.id,
                text : item.name
            }));
        });
       if(isDisabled)
        $("#userData select[name=project_status]").val(userDetails.project_status);

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
        $("#userData input[name=project_name]").val(userDetails.project_name);
        $("#userData input[name=project_description]").val(userDetails.project_description);
        $("#userData input[name=project_category]").val(userDetails.category_id);
        console.log(userDetails);
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