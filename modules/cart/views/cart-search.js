// $('#form_validation').validate({
//     rules: {
//         'checkbox': {
//             required: true
//         },
//         'gender': {
//             required: true
//         }
//     },
//     highlight: function (input) {
//         $(input).parents('.form-line').addClass('error');
//     },
//     unhighlight: function (input) {
//         $(input).parents('.form-line').removeClass('error');
//     },
//     errorPlacement: function (error, element) {
//         $(element).parents('.form-group').append(error);
//     }
// });

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
    var selectedProductsAllData = {}
            //console.log(searchResult);

        var resultsTable = $('#results-table').DataTable({
            dom: 'Blfrtip',
            data: [],
            pageLength: 5000,
                "paging":   false,
                "ordering": false,
                "searching": false,
            rowId: 'category_slug',
             buttons: [
                {
                    extend: 'selectAll',
                    className: 'btn btn-lg btn-primary waves-effect',
                },
                {
                    extend: 'selectNone',
                    className: 'btn btn-lg btn-primary waves-effect',
                },
                 {
                    extend: 'selected',
                    className: 'createProject btn btn-lg btn-success waves-effect',
                    text: 'Create Quote',
                    action: function ( e, dt, button, config ) {

                        var selection = dt.rows( { selected: true } ).data();
                        var i;
                        for ( i = 0; i < selection.length; i++) {
                            var thisId = selection[i].id;
                            selectedProducts.push(selection[i].id);
                            selectedProductsAllData[thisId] = selection[i];
                        }
                    }
                },
                 {
                            text: 'Get Delivery Date',
                            className: 'deliveryDate btn btn-lg btn-warning waves-effect',
                            action: function ( e, dt, node, config ) {
                                console.log(dt.data())

                                var thisButton = $(e.currentTarget);

                                thisButton.append('<div class="loadingDeliveryData" style="float:left"><div class="preloader pl-size-vxs"> <div class="spinner-layer pl-white"> <div class="circle-clipper left"> <div class="circle"></div> </div> <div class="circle-clipper right"> <div class="circle"></div> </div> </div></div>');

                                //console.log(thisButton);

                                   var indexes = dt.rows().indexes().filter( 
                                        function ( value, index ) {    
                                            //console.log(dt.row(value).data()['saga_quantity'] < dt.row(value).data()['quantity']);
                                            return 'syl' === dt.row(value).data()['manufacturer'].toLowerCase() && dt.row(value).data()['saga_quantity'] < dt.row(value).data()['quantity'];
                                            //return 'syl' === dt.row(value).data()['manufacturer'].toLowerCase();
                                        }
                                    );

                                    var sylvaniaProducts = dt.rows( indexes ).data().toArray();

                                    var productsForDeliveryDate = [];

                                    for (let index in sylvaniaProducts) {
                                        // productsForDeliveryDate[sylvaniaProducts[index].id] = {
                                        //     'quantity' : sylvaniaProducts[index].quantity
                                        // }

                                        productsForDeliveryDate[index] = {'id': sylvaniaProducts[index].id, 'quantity': sylvaniaProducts[index].quantity};

                                    }

                                    console.log(sylvaniaProducts);


                                    $.ajax({
                                        url: "https://aws.icatch.ro:3131/getPromiseDate",
                                        type: "post",
                                        dataType: "json",
                                        //data: {products: productsForDeliveryDate}
                                         data: {'products': JSON.stringify(productsForDeliveryDate)}
                                   }).success(function(json){
                                       $('.updateError').addClass('hidden');

                                        console.log(json);

                                        json.forEach(function(e){
                                            //var thisElement = $('[data-id="' + e.id + '"][data-quantity="'+ e.quantity +'"]');
                                            var thisElement = $('[data-id="' + e.id + '"]');
                                            thisElement.html(e.promiseDate);
                                        })

                                    }).error(function(xhr, status, error) {
                                       $('.updateError').removeClass('hidden');
                                    }).done(function() {
                                        console.log(thisButton);
                                        thisButton.find('.loadingDeliveryData').remove();
                                    })

                                
                            } 
                        },
                // {
                //     className: 'addNewProducts btn btn-lg btn-success waves-effect',
                //     text: 'Insert New Products to DataBase',
                //     action: function ( e, dt, button, config ) {
                        
                //         $('#newProducts').find(':submit').click();

                //         $('#newProducts').on('submit', function(e){
                //             e.preventDefault();

                //             var ser = $(this).serialize();

                //             var tes = $(this).serializeArray();

                //             console.log(ser, tes);
                            
                //          })
                //     }
                // },
                {
                    extend: 'selected',
                    className: 'addToProject btn btn-lg btn-success waves-effect hidden',
                    text: 'Add to Project',
                    action: function ( e, dt, button, config ) {
                        var selection = dt.rows( { selected: true } ).data();
                        var i;
                        for ( i = 0; i < selection.length; i++) {
                            selectedProducts.push(selection[i].id);
                            selectedProductsAllData[selection[i].id] = selection[i];
                        }

                        var projectID = $('#projectNumber').text();

                        createQuote(projectID, selectedProducts)
                    }
                }, 
                {
                    extend: 'selected',
                    className: 'addToQuote btn btn-lg btn-success waves-effect hidden',
                    text: 'Add to Quote',
                    action: function ( e, dt, button, config ) {
                        var selection = dt.rows( { selected: true } ).data();
                        var i;
                        for ( i = 0; i < selection.length; i++) {
                            selectedProducts.push(selection[i].id);
                            selectedProductsAllData[selection[i].id] = selection[i];
                        }

                        var quoteID = $('#quoteNumber').text();

                        addItemsToQuote(0, quoteID, selectedProducts, selectedProductsAllData)
                    }
                },
            ],
            language: {
                buttons: {
                    selectAll: "Select all items",
                    selectNone: "Select none",
                }
            },   
            responsive: true,
            "columns": [
                { 
                    "data": null, 
                    defaultContent: ''
                    
                },
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
                    "data": "id",
                    className: "product_id",
                      "render" : function(data, type, row, meta) {
                        if(row.from_db) {
                            return data;
                        }
                        else {
                            return '<form id="newProducts-'+meta.row+'" class="newProduct" method="post" action="" enctype="multipart/form-data"></form><div class="form-group"><div class="form-line"><input class="form-control" form="newProducts-'+meta.row+'" data-type="id" name="id" placeholder="Add an Id" value="'+data+'" required></div></div>'
                          }
                    }

                },
                { 
                    "data": "product_name",
                    className: "product_name",
                    "render" : function(data, type, row, meta) {
                        if(row.from_db) {
                            return data;
                        }
                        else {
                            return '<div class="form-group"><div class="form-line"><input class="form-control" data-type="id" name="product_name" placeholder="Add a Name" value="'+data+'" form="newProducts-'+meta.row+'" required></div></div>'
                          }
                    }

                },
                { 
                    "data": null, 
                     "render" : function(data, type, row, meta) {
                        //console.log(index);

                         if(!row.from_db) {
                            return "-";
                        }
                        else {
                            if(parseInt(row.saga_quantity) > parseInt(row.quantity)) {
                                stockIcon = 'check_circle';
                                messageTitle = 'Local Stock';
                                messageContent = row.quantity + ' pieces available in local stock';
                                colorClass = 'col-green';

                            } else if (row.manufacturer.toLowerCase() == 'syl' ) {
                                stockIcon = 'flight';
                                messageTitle = 'Remote Stock';
                                messageContent = 'Click Get Delivery Date';
                                colorClass = 'col-blue';

                            } else {
                                stockIcon = 'schedule';
                                messageTitle = 'Stock info not Available';
                                messageContent = '';
                                colorClass = '';
                            }

                                if(row.manufacturer.toLowerCase() !== 'syl') {
                                    html = '<button class="btn btn-xs btn-link waves-effect editQuoteItem" data-toggle="modal" data-target="#editItem-modal"  data-row="'+ meta.row +'"><i class="material-icons">mode_edit</i></button>'
                                }
                                else {
                                    html = '<a class="btn btn-xs btn-link" href="https://www.sylvania-lighting.com/product/en-int/products/'+data+'">'+
                                    '<i class="material-icons">link</i></a>'+
                                    '<button class="btn btn-xs btn-link waves-effect editQuoteItem"  data-toggle="modal"'+ 
                                        'data-target="#editItem-modal"  data-row="'+ meta.row +'">'+ 
                                        '<i class="material-icons">mode_edit</i></button>';
                                }

                                html = html +'<button class="btn btn-xs btn-link waves-effect"' + 
                                        ' data-trigger="focus" data-container="body" data-toggle="popover" data-placement="right" title="'+ messageTitle + '" data-content="'+ messageContent +'">'+ 
                                        '<i class="material-icons '+ colorClass +'">' + stockIcon + '</i></button><span class="promiseDate" data-id="'+ row.id +'" data-quantity="'+ row.quantity +'"></span>';



                                return html
                                
                          }

                        }
                        
                    
                },
                { 
                    "data": "manufacturer"
                },
                { 
                    "data": "initial_price",
                    className: "initial_price",
                    "render" : function(data, type, row, meta) {

                        if(row.from_db) {
                            return Number(data).toFixed(2)
                        }
                        else {
                            return '<div class="form-group"><div class="form-line"><input class="form-control" data-type="id" name="initial_price" placeholder="Price" value="'+Number(data).toFixed(2)+'" form="newProducts-'+meta.row+'" required></div></div><input class="submitProducts hidden"  form="newProducts-'+meta.row+'" type="submit">'
                          }
                         
                          
                      }

                },
                { 
                        "data": "quantity",
                            "render" : function(data, type, row, meta) {
                              return '<div class="form-group">' + 
                                        '<div class="form-line">' + 
                                            '<input class="form-control quote-input"' + 
                                            ' data-type="quantity"' + 
                                            //' data-index="'+index+
                                            //'" data-item="'+row.quote_item_id+
                                            '" data-row="'+meta.row+
                                            '" data-col="'+meta.col+'" name="quantity" placeholder="Quantity" value="'+row.quantity+'" type="number" min="1" step="1">' + 
                                        '</div>' + 
                                    '</div>'
                          }
                    },
                {
                    "data": "saga_quantity",
                     //className: "existing_stocks",
                    "render" : function(data, type, row, meta) {
                        if(row.from_db) {
                            return data;
                        } else {
                            return "";
                        }
                    }
                    //"visible": iss

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

              

                $('.dt-buttons a').removeClass('dt-button');
                $('.createProject').attr({"data-toggle": "modal", "data-target": "#categories-modal"});

                if(queryDict.quote && queryDict.quote !== 'undefined') {
                    

                    $('.addToQuote').removeClass('hidden');
                    $('.createProject').addClass('hidden');
                    $('.addToProject').addClass('hidden');

                    $('.projectTitle').addClass('hidden');
                    $('.quoteTitle').removeClass('hidden');

                     $('.addNewItem[data-quote="'+queryDict.quote+'"]').trigger('click');
                }

                 if(queryDict.project && queryDict.project !== 'undefined') {
                   //console.log('a')

                    $('.addToProject').removeClass('hidden');
                    $('.addToQuote').addClass('hidden');
                    $('.createProject').addClass('hidden');

                     $('.quoteTitle').addClass('hidden');
                    $('.projectTitle').removeClass('hidden');

                     $('.addNewQuote[data-project="'+queryDict.project+'"]').trigger('click');
                }
              },

              "createdRow": function( row, data, dataIndex ) {
                //console.log(row, data['from_db'], dataIndex);
                if ( data['from_db'] === 0 ) {
                  $(row).addClass( 'warning' );
                }

                
                //Decomment this when using stocks
                //=================================
                // $.ajax({
                //     url: "/ajax/getProductStocks",
                //     type: "post",
                //     dataType: "json",
                //     data: {"product_id":data['id'] }
                // }).success(function(json){
                //     html = "<ul class='list-group'>";

                // $.each(json, function (i, item) {
                       
                //     html = html + "<li class='list-group-item'>" + item.row_name+item.column_name + " - " + item.quantity + "pcs<li>"
                //  });

                // html = html + "</ul>"
                // $('td', row).eq(5).html(html);
                                    
                // });      
              }

        });

        var saveAjaxCall;

        $('.addFromWishlist').on('click', function(e){
            $.ajax({
                url: "/ajax/searchProducts",
                type: "post",
                dataType: "json",
                data: {"wishlist": JSON.parse(wishlist) }
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

        if(queryDict.searchFromWishlist) {

            setTimeout(function () {
               $('.addFromWishlist').trigger('click');
            }, 1000);

            
        }

        $('#searchForm').on('submit', function(e){
            e.preventDefault();

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
            e.preventDefault();
           
           var newProduct = $(this).serializeArray();

           var tr = $(this).parents('tr');

           //console.log(tr);

           $.ajax({
                url: "/ajax/addProduct",
                type: "post",
                dataType: "json",
                data: {"id": newProduct[0]['value'], "product_name": newProduct[1]['value'], "initial_price": newProduct[2]['value'] }
           }).success(function(json){
                if(json === 0){
                    tr.removeClass('warning').addClass('danger');
                } else {
                    //console.log('productAdded')
                    $.ajax({
                        url: "/ajax/searchProducts",
                        type: "post",
                        dataType: "json",
                        data: saveAjaxCall
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
                }
            
            }).error(function(xhr, status, error) {
               tr.removeClass('warning').addClass('danger');
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


    var projectsTable = $('.projects_table').DataTable({
            "ajax": {
                "url": "/ajax/getProjects",
                "dataSrc": ""
            },
            dom: 'lfrtipB',
            pageLength: 5,
                "paging":   true,
                "ordering": false,
                "searching": true,
            rowId: 'category_slug',
             buttons: [
                 {
                    extend: 'selected',
                    className: 'selectProject btn btn-block m-t-10 btn-lg btn-success waves-effect',
                    text: 'Choose selected Project & Continue',
                    action: function ( e, dt, button, config ) {
                        var selectedRow = dt.rows( { selected: true } ).data();
                        createQuote(selectedRow[0].id, selectedProducts);
                        $('.projectProgress').css('width', "100%").attr('aria-valuenow', 100);
                    }
                }
            ],   
            responsive: true,
            order: [2],
            columnDefs : [
                {
                    orderable : false,
                    className : 'select-checkbox',
                    targets : 0
                },
            ],
             select: {
                style:    'os',
                selector: 'tr'
            },
            "columns": [ 
                { 
                    "data": null, 
                    defaultContent: '' 
                },
                { 
                    "data": "id"
                },
                { 
                    "data": "project_name"
                },
                { 
                    "data": "project_description"
                },
                { 
                    "data": "owner_id"
                }
                
            ],
            "initComplete": function(settings, json) {
                $('.dt-buttons a').removeClass('dt-button');
                //$('.selectProject').attr({"data-toggle": "modal", "data-target": "#status-modal"})

            }

        });


    $("#addProject").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);

        $.ajax({
            url: "/ajax/addProject",
            type: "post",
            dataType: "json",
            data: form.serialize()
        }).done(function(json){
           createQuote(json, selectedProducts, selectedProductsAllData);
        }).error(function(xhr, status, error) {
             $('.addProjectForm').removeClass('hidden');
        })


    }); 



    $('input[name="searchType"]').on('change', function(e) { // Select the radio input group

        if($(this).val() == 'product-id') {
            $('#searchBulk').removeClass('hidden');
            $('#searchSingle').addClass('hidden');
        } else {
            $('#searchSingle').removeClass('hidden');
            $('#searchBulk').addClass('hidden');
        }


    });  


    $('body').on('change', '.quote-input', function(){
            var rowId = $(this).attr('data-row');
            updateQuantity(this);

        })

    
   
});


function updateQuantity(el) {

    el = $(el);

    var type = el.attr('data-type');


    var tr = el.closest('tr');
    var quantity = el.val();

    var tableID = tr.closest('table').attr('id')

    var updatedEl = tr.find("[data-type='" + type + "']");

    var rowId = updatedEl.attr('data-row');

    var colId = updatedEl.attr('data-col');

    var tagName = updatedEl.prop("tagName");

    if (tagName == "INPUT") {
        updatedEl.val(quantity)
    }
    else {
        updatedEl.text(quantity);
    }

    $('#'+tableID).dataTable().api().cell({ row: rowId, column: colId }).data(quantity).draw();
    

}


function createQuote(projectID, products, allProductsData) {

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
            addItemsToQuote(projectID, json, products, allProductsData)
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

function addItemsToQuote(projectID, quoteID, products, allProductsData) {
    //console.log(products);
    if(products[0].id) {
         $('#status-modal').modal('show');
        var quote = {
            'products': products,
            'quote_id': quoteID,
            'isMulti': 1,
            'allProductsData' : allProductsData
        }
         
    } else {
        var quote = {
            'products': products,
            'temporary_products' : searchTemporary,
            'quote_id': quoteID,
            'isMulti': 0,
            'allProductsData' : allProductsData
        }
    }

    console.log(quote);
     
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

