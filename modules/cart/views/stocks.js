

var searchTemporary = 0;


var queryDict = {};

location.search.substr(1).split("&").forEach(function(item) {queryDict[item.split("=")[0]] = item.split("=")[1]})

$('.search').on('click', function(){
    if($(this).attr('data-quote')) {
        var quoteNumber = $(this).attr('data-quote')
        window.history.pushState("object or string", "Title", "?quote="+quoteNumber);
    } else  {
        var projectNumber = $(this).attr('data-project')
        window.history.pushState("object or string", "Title", "?project="+projectNumber);
    }
    
})


$.ajax({
    url: "/ajax/getUsers",
    type: "post",
    dataType: "json",
}).done(function(json){
   $.each(json, function (i, item) {
        $('.usersSelector').append($('<option>', { 
            value: item.id,
            text : item.name 
        }));

        $('.usersSelector option[value="'+ clientIs +'"]').attr('selected','selected')
    });

}).error(function(xhr, status, error) {
    $('.usersSelectorError').removeClass('hidden');
})



var stockLocationSelector = []


$.ajax({
        url: "/ajax/getStockAvailableLocations",
        type: "post",
        dataType: "json",
    }).success(function(json){
        stockLocationSelector = json;
    });

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

    }).error(function(xhr, status, error) {
        $('.categorySelectorError').removeClass('hidden');
    })




$(document).ready(function() {

    var selectedProducts = [];
            //console.log(searchResult);

        var resultsTable = $('#results-table').DataTable({
            dom: 'Blfrtip',
            data: [],
            pageLength: 5000,
                "paging":   false,
                "ordering": false,
                "searching": false,
            rowId: 'category_slug',
            responsive: true,
            buttons: [],
            "columns": [
                { 
                    "data": "product_image",
                    className: "product_image",
                    "render" : function(data, type, row) {
                         if(!data){
                            return '<img src="http://ideyafoana.com/api/public/storage/photo/no-image.png" class="table-image" />'
                            
                        } else {
                            if(searchTemporary){
                                return  '<img src="/uploads/'+data+'" class="table-image" />'
                            } else {

                              return '<img src="'+data+'" class="table-image" />'
                            
                            }
                        }                       
                      } 

                },
                { 
                    "data": "stock_id",
                    className: "stock_id",
                      "render" : function(data, type, row, meta) {
                        
                            return '<input class="form-control" form="newProducts-'+meta.row+'" data-type="id" name="stock_id" placeholder="Add an Id" value="'+data+'" type="hidden">'+data;
                      },
                      "visible": !$('.results-table').hasClass("viewAll")

                },
                { 
                    "data": "id",
                    className: "product_id",
                      "render" : function(data, type, row, meta) {
                        
                            return '<form id="newProducts-'+meta.row+'" class="newProduct" method="post" action="" enctype="multipart/form-data"></form><input class="form-control" form="newProducts-'+meta.row+'" data-type="id" name="id" placeholder="Add an Id" value="'+data+'" type="hidden">'+data;
                      }

                },
                { 
                    "data": "product_name",
                    className: "product_name",
                    "render" : function(data, type, row, meta) {
                       
                            return data;
                        
                    }

                },
                { 
                    "data": "initial_price",
                    className: "initial_price",
                    "render" : function(data, type, row, meta) {

                        
                            return Number(data).toFixed(2)
                       
                          
                      }

                },
                { 
                    "data": "quantity",
                    className: "quantity",
                    "render" : function(data, type, row, meta) {
                       
                            return '<div class="form-group"><div class="form-line"><input  class="form-control" data-type="id" name="stock_quantity" value="'+data+'" placeholder="Add quantity" type="number" form="newProducts-'+meta.row+'" required></div></div>'
                    }

                },
                { 
                    "data": "stock_location",
                    className: "stock_location",
                    "render" : function(data, type, row, meta) {

                        

                        var options = "";

                         $.each(stockLocationSelector, function (i, item) {
                           
                            options = options + "<option value="+ item.id + ">" + item.row_name + item.column_name +"</option>"
                        });

                        
                       
                            return '<div class="form-group"><div class="form-line"><select class="form-control stockLocationSelector" required name="location" form="newProducts-'+meta.row+'"><option>Select Stock Location</option>' + options + '</select></div></div>'
                    }

                },
                {
                    "data": null,
                     className: "existing_stocks",
                    "render" : function(data, type, row, meta) {


                       
                            return ''
                    }

                }
            ],
            columnDefs : [
                {
                    orderable : false,
                    className : 'select-checkbox',
                    targets : 0
                },
            ],
             select: {
                style:    'multi',
                selector: 'td:first-child'
            },
            "initComplete": function(settings, json) {

               
              },

              "createdRow": function( row, data, dataIndex ) {
                //console.log(row, data['from_db'], dataIndex,);
                if ( data['from_db'] === 0 ) {
                  $(row).hide();
                }

                $.ajax({
                    url: "/ajax/getProductStocks",
                    type: "post",
                    dataType: "json",
                    data: {"product_id":data['id'] }
                }).success(function(json){
                    var html, defaultValue = "";

                    if($('.results-table').hasClass('viewAll')) {
                        html = data['row_name']+data['column_name'];
                         $('td', row).eq(7).html('<button class="btn btn-danger waves-effect removeFromLocation" data-stock-product="'+data['stock_id']+'" data-stock-location="'+data['location_id']+'">x</button>');
                         $('td', row).eq(6).find("select").html("");
                         $('td', row).eq(6).find("select").append('<option value="'+data.location_id+'" selected>'+data.row_name+data.column_name+'</option>');

                         $('.removeFromLocation').on('click', function(){

                            var stock_id = $(this).attr('data-stock-product');
                            var location_id = $(this).attr('data-stock-location');
                           
                             $.ajax({
                                url: "/ajax/removeFromStockLocation",
                                type: "post",
                                dataType: "json",
                                data:{"stock_id":stock_id, "location_id": location_id}
                                
                           }).success(function(json){
                                if(json === 0){
                                    $('.searchError').removeClass('hidden');
                                } else {
                                   location.reload();
                                }
                            
                            }).error(function(xhr, status, error) {
                               $('.searchError').removeClass('hidden');
                            })
                            
                        });

                    } else {
                        html = "<ul class='list-group'>";

                        $.each(json, function (i, item) {
                               
                            html = html + "<li class='list-group-item'>" + item.row_name+item.column_name + " - " + item.quantity + "pcs<li>"
                         });

                        html = html + "</ul>"
                        $('td', row).eq(7).html(html);
                    }                    
                });      
              }

        });

        var saveAjaxCall;

        $('#searchForm').on('submit', function(e){
            e.preventDefault();

            $('.results-table').removeClass('viewAll');

            var formValues = $(this).serializeArray();
            //console.log($(this).attr('id'));
            if($(this).attr('id') == "searchForm2")
                searchCriteria = "searchCriteria"
            else 
                searchCriteria = "searchBulk"

            //console.log( searchCriteria);
            $.ajax({
                url: "/ajax/searchProducts",
                type: "post",
                dataType: "json",
                data: {"searchBulk": formValues[0]['value'], }
           }).success(function(json){
                if(json === 0){
                    $('.searchError').removeClass('hidden');
                } else {
                    saveAjaxCall =  {"searchBulk": formValues[0]['value'] };
                    
                    resultsTable.clear().draw();
                    resultsTable.rows.add(json); // Add new data
                    resultsTable.columns.adjust().draw(); // Redraw the DataTable
                }
            
            }).error(function(xhr, status, error) {
               $('.searchError').removeClass('hidden');
            })          
         })

        $("#searchForm2 input").focus(function(){
            $(this).parent().closest('.input-group').siblings().find('input').val('');
        })

        $('#searchForm2').on('submit', function(e){
            e.preventDefault();


            var formValues = $(this).serializeArray();
            $.ajax({
                url: "/ajax/searchProducts",
                type: "post",
                dataType: "json",
                data: {"searchCriteria": formValues[0]['value'], "product_name": formValues[1]['value'], }
           }).success(function(json){
                if(json === 0){
                    $('.searchError').removeClass('hidden');
                } else {
                    resultsTable.clear().draw();
                    resultsTable.rows.add(json); // Add new data
                    resultsTable.columns.adjust().draw(); // Redraw the DataTable
                }
            
            }).error(function(xhr, status, error) {
               $('.searchError').removeClass('hidden');
            })
            
         })

        $(document).on('submit', '.newProduct', function(e){
            e.stopImmediatePropagation();
            e.preventDefault();
           
           var newProduct = $(this).serializeArray();

           //console.log(newProduct);

           var tr = $(this).parents('tr');

           //console.log(tr);

           var method, dataParams = "";

           if($('.results-table').hasClass('viewAll')) {

                method = "updateStockQuantity";

            } else {
                method = "addStock";
            }

           $.ajax({
                url: "/ajax/"+method,
                type: "post",
                dataType: "json",
                data: {"stock_id": newProduct[0]['value'],"id": newProduct[1]['value'], "quantity": newProduct[2]['value'], "location_id": newProduct[3]['value'] }
           }).success(function(json){
                if(json === 0){
                    tr.removeClass('warning').addClass('danger');
                } else {
                     tr.removeClass('warning').addClass('success');
                     tr.find('input, select').attr('disabled', 'disabled');
                    $.ajax({
                        url: "/ajax/getStockAvailableLocations",
                        type: "post",
                        dataType: "json",
                    }).done(function(json){
                         $('.stockLocationSelector').html("");
                       $.each(json, function (i, item) {
                             $('.stockLocationSelector').append($('<option>', { 
                                value: item.id,
                                text : item.row_name+item.column_name
                            }));
                        });

                    }).error(function(xhr, status, error) {
                        $('.categorySelectorError').removeClass('hidden');
                    })

                }

            
            }).error(function(xhr, status, error) {
               tr.removeClass('warning').addClass('danger');
            })
        });

        $('.viewAllStocks').on('click', function(){
            
             $.ajax({
                url: "/ajax/getAllStocks",
                type: "post",
                dataType: "json",
                
           }).success(function(json){
                if(json === 0){
                    $('.searchError').removeClass('hidden');
                } else {
                    resultsTable.clear().draw();
                    resultsTable.rows.add(json); // Add new data
                    resultsTable.columns.adjust().draw(); // Redraw the DataTable
                    $('.results-table').addClass('viewAll');
                }
            
            }).error(function(xhr, status, error) {
               $('.searchError').removeClass('hidden');
            })
            
        });

        

   resultsTable.on( 'select', function ( e, dt, type, indexes ) {
        var row = resultsTable.row( indexes ).data();

        if ( row.from_db === 0 ) {
            dt.row(indexes, { page: 'current' }).deselect();
        }

    } );

   resultsTable
    .on( 'user-select', function ( e, dt, type, cell, originalEvent ) {
        

        if ( $(originalEvent.currentTarget).parent('tr').hasClass('danger') ) {
            e.preventDefault();
        }
    } );




    $('input[name="searchType"]').on('change', function(e) { // Select the radio input group

    if($(this).val() == 'product-id') {
        $('#searchBulk').removeClass('hidden');
        $('#searchSingle').addClass('hidden');
    } else {
        $('#searchSingle').removeClass('hidden');
        $('#searchBulk').addClass('hidden');
    }


});  
   
});

function createQuote(projectID, products) {

    $('#categories-modal').modal('hide');

    $('#addNew-modal').modal('show');

    $('#status-modal').modal('show');

    var quote = {
        'project': projectID,
    }

    //console.log(products);
    $.ajax({
        url: "/ajax/createQuote",
        type: "post",
        dataType: "json",
        data: quote
    }).done(function(json){
        $('.quote-progress').css('width', "100%").attr('aria-valuenow', 100);
        $('.item-progress').css('width', "40%").attr('aria-valuenow', 40);
        if(products['duplicate']) {
            duplicateQuoteItems(projectID, json, products);
        } else {
            addItemsToQuote(projectID, json, products)
        }
        

    }).error(function(xhr, status, error) {
        $('.quoteCreation').removeClass('hidden');
    })

}

function duplicateQuoteItems(projectID, quoteID, quote_items){
    //console.log('its on');

    var quote = {
            'quote_items': quote_items,
            'quote_id': quoteID
        }

     $.ajax({
        url: "/ajax/duplicateQuoteItems",
        type: "post",
        dataType: "json",
        data: quote
    }).done(function(json){
            $('.items-progress').css('width', "100%").attr('aria-valuenow', 100);
            redirectCounter(projectID)
        
    }).error(function(xhr, status, error) {
        $('.quoteItemsCreation').removeClass('hidden');
    })
}

function addItemsToQuote(projectID, quoteID, products) {
    //console.log(products);
    if(products[0].id) {
         $('#status-modal').modal('show');
        var quote = {
            'products': products,
            'quote_id': quoteID,
            'isMulti': 1
        }
         
    } else {
        var quote = {
            'products': products,
            'temporary_products' : searchTemporary,
            'quote_id': quoteID,
            'isMulti': 0
        }
    }
     
    $.ajax({
        url: "/ajax/addItemsToQuote",
        type: "post",
        dataType: "json",
        data: quote
    }).done(function(json){
        if($('#quoteNumber').text()) {
            window.history.pushState("object or string", "Title", "?");
            location.reload();
        } else {
            $('.items-progress').css('width', "100%").attr('aria-valuenow', 100);
            redirectCounter(projectID)
        }
        

    }).error(function(xhr, status, error) {
        $('.quoteItemsCreation').removeClass('hidden');
    })
}

function redirectCounter(projectID){ 
    var timeleft = 3;
    var downloadTimer = setInterval(function(){
      document.getElementById("countdown").innerHTML = timeleft + " seconds ";
      timeleft -= 1;
      if(timeleft <= 0){
        clearInterval(downloadTimer);
        window.location.href = "/project/"+projectID;
      }
    }, 1000);
};

