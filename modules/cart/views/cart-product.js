

$(document).ready(function() {
    $('.product-overview__copy').find('.button').remove();

     $('.product-overview__copy').find('li').prepend('<i class="material-icons">check</i>');

     $('.show-table').removeClass('hidden');

     $('.col-3-large').addClass("col-lg-3")

        var table = $('.features-table').DataTable({
            data: productFeaturesQuery,
            pageLength: 5000,
                "paging":   false,
                "ordering": false,
                "searching": true,
            rowId: 'category_slug',
             language : {
                //sLoadingRecords : '<span style="width:100%;"><img src="http://www.snacklocal.com/images/ajaxload.gif"></span>'
            },
            rowGroup: {
                dataSrc: 'feature_category_name'
            },    
            responsive: true,
            "columns": [
                { 
                    "data": "feature_name",
                    className: "feature_name",
                },
                { 
                    "data": "feature_value",
                    className: "feature_value",

                },
                { 
                    "data": "feature_category_name",
                    className: "feature_category_name",
                    visible: false
                    

                },
            ],
            "initComplete": function(settings, json) {
              }

        });

});