$(document).ready(function() {

    $.ajax({
        url: "/ajax/getCategoryBreadcrumbs",
        type: "post",
        dataType: "json",
        data: {'parent_id': parent_id}
    }).done(function(json){
        console.log(json);

    }).error(function(xhr, status, error) {

    })


});
