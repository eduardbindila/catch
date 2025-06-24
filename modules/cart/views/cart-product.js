

$(document).ready(function() {

    $.ajax({
        url: "/ajax/getCategoryBreadcrumbs",
        type: "post",
        dataType: "json",
        data: {'parent_id': parent_id}
    }).done(function(json){
        //console.log(json);

        var urlPrefix = '';
        jQuery.each(json, function(index, item) {
            // do something with `item` (or `this` is also `item` if you like)
            
            urlPrefix = urlPrefix + item.parent_id;
            //console.log(urlPrefix);
            var li = '<li><a href="/cart/catalog/'+urlPrefix+'/'+item.id+'/">'+item.category_name+'</a></li>';

            //console.log(li);
            $('.breadcrumb').append(li)
        });

    }).error(function(xhr, status, error) {

    })

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

        var product_quotes_table = $('.product_quotes_table').DataTable({
            "ajax": {
                "url": "/ajax/getproductQuotes/",
                "dataSrc": "",
                "type": 'POST',
                "data": {'product_id': product_id}
            },
        
            pageLength: 100,
                "paging":   true,
                "ordering": true,
                "searching": true,
            rowId: 'category_slug',
              
            responsive: true,
            order: [1],
            "columns": [ 
                { 
                    "data": "quote_id",
                    "render" : function(data, type, row) {
                        return '<a href="/quote/'+data+'" target="_blank">'+data+'</a>'
                      } 
                },
                { 
                    "data": "name"
                }
                ,
                { 
                    "data": "quote_status"
                },
                { 
                    "data": "project_id",
                    "render" : function(data, type, row) {
                        return '<a href="/project/'+data+'" target="_blank">'+data+'</a>'
                      } 
                },
                { 
                    "data": "project_name"
                },
                { 
                    "data": "reserved_stock"
                }
            ],
            "initComplete": function(settings, json) {
            }
        });

 var product_history_table = $('.product_history_table_2024').DataTable({
            "ajax": {
                "url": "/ajax/getProductHistory/",
                "dataSrc": function(json) {
                    return json.history || []; // dacă history nu e setat, întoarce un array gol
                },

                "type": 'POST',
                "data": {'product_id': product_id, 'year': 2024}
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
                    "data": "date"
                },
                 { 
                    "data": "document_number"
                },
                 { 
                    "data": "document_type",
                    "visible": false
                },
                 { 
                    "data": "id",
                     "render" : function(data, type, row) {


                        if(row.document_type == "client_invoice") {
                            icon = 'account_circle';
                            iconClass = 'col-green';
                            path = "quote/"+data+"?package_id="+row.sub_id;
                        } else {
                            icon = "local_shipping";
                            iconClass = 'col-blue';
                            path = "logistics/vendor-invoices/"+data;
                        }

                        return '<i class="material-icons document-type-position '+ iconClass +'">'
                            +icon+
                            '</i><a href="/'+path+'" target="_blank">'+row.document_type+': '+data+'</a>'
                      } 

                },
                 { 
                    "data": "units"
                },
                 { 
                    "data": "unit_price"
                },
                 { 
                    "data": "total_value"
                },
                 { 
                    "data": "intermediate_stock"
                },

            ],
            "initComplete": function(settings, json) {
            }
        });

 var product_history_table = $('.product_history_table').DataTable({
            "ajax": {
                "url": "/ajax/getProductHistory/",
                "dataSrc": function(json) {
                    return json.history || []; // dacă history nu e setat, întoarce un array gol
                },

                "type": 'POST',
                "data": {'product_id': product_id, 'year': 2025}
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
                    "data": "date"
                },
                 { 
                    "data": "document_number"
                },
                 { 
                    "data": "document_type",
                    "visible": false
                },
                 { 
                    "data": "id",
                     "render" : function(data, type, row) {


                        if(row.document_type == "client_invoice") {
                            icon = 'account_circle';
                            iconClass = 'col-green';
                            path = "quote/"+data+"?package_id="+row.sub_id;
                        } else {
                            icon = "local_shipping";
                            iconClass = 'col-blue';
                            path = "logistics/vendor-invoices/"+data;
                        }

                        return '<i class="material-icons document-type-position '+ iconClass +'">'
                            +icon+
                            '</i><a href="/'+path+'" target="_blank">'+row.document_type+': '+data+'</a>'
                      } 

                },
                 { 
                    "data": "units"
                },
                 { 
                    "data": "unit_price"
                },
                 { 
                    "data": "total_value"
                },
                 { 
                    "data": "intermediate_stock"
                },

            ],
            "initComplete": function(settings, json) {
            }
        });

    //TinyMCE
    tinymce.init({
        selector: "textarea.tinymce",
        theme: "modern",
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true
    });
    tinymce.suffix = ".min";
    tinyMCE.baseURL = '../../common/interface/plugins/tinymce';
});
