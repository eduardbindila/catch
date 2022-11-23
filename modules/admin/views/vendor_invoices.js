
$(document).ready(function() {


    var connectedQuotes = [];

    var connected;

    var projectsTable = $('.invoices_table').DataTable({
        "ajax": {
            "url": "/ajax/getVendorInvoicesList/",
            "dataSrc": "",
        },
    
        pageLength: 100,
            "paging":   true,
            "ordering": true,
            "searching": true,
        rowId: 'category_slug',
          
        responsive: true,
        order: [],
        "columns": [ 
            { 
                "data": "id",
                "render" : function(data, type, row) {
                    return '<a href="vendor-invoices/'+data+'" target="_blank">'+data+'</a>'
                  } 
            },
            { 
                "data": "invoice_no"
            },
            { 
                "data": "vendor"
            },
            { 
                "data": "date"
            },
            { 
                "data": "due_date"
            },
            { 
                "data": "invoice_value"
            }
        ],
        "initComplete": function(settings, json) {
        }

    });


    $.ajax({
        url: "/ajax/getVendors",
        type: "post",
        dataType: "json",
    }).done(function(json){
       $.each(json, function (i, item) {
        //console.log(json, $('.vendorTypesSelector'));
            $('.vendorTypesSelector').append($('<option>', { 
                value: item.id,
                text : item.id
            }));
        });
       if(isDisabled)
        $("#invoiceData select[name=vendor]").val(invoiceData.vendor);

    }).error(function(xhr, status, error) {
        $('.vendorTypesSelectorError').removeClass('hidden');
    })


    if(insertResult) {
        $('.addUserSuccess').removeClass('hidden')
    } else if(insertResult == 0) {
        $('.addUserError').removeClass('hidden')
    }

    if(isDisabled) {
        $('#invoiceData').find('input, textarea, button, select').attr('disabled','disabled');
        invoiceData = invoiceData[0];
        //console.log(invoiceData);
        $("#invoiceData input[name=invoice_no]").val(invoiceData.invoice_no);
        $("#invoiceData input[name=vendor]").val(invoiceData.vendor);
        $("#invoiceData input[name=date]").val(invoiceData.date);
        $("#invoiceData input[name=due_date]").val(invoiceData.due_date);
        $("#invoiceData input[name=exchange_rate]").val(invoiceData.exchange_rate);
        $("#invoiceData input[name=vat_value]").val(invoiceData.vat_value);
        $("#invoiceData input[name=invoice_value]").val(invoiceData.invoice_value);

        $("input[name=currency][value=" + invoiceData.currency + "]").prop('checked', true);
    }

     $('.editSwitch').change(function() {
        isDisabled = !isDisabled;
        if(!isDisabled) {
            $('#invoiceData').find('input, textarea, button, select').prop("disabled", false);;
        } else {
            $('#invoiceData').find('input, textarea, button, select').attr('disabled','disabled');
        }      
    })
    

    if(isDisabled) {
         var itemsTable = $('.invoice_items_table').DataTable({
            "ajax": {
                "url": "/ajax/getVendorInvoiceItemsList/",
                "dataSrc":"",
                "type": "POST",
                "data": {'vendor_invoice_id': invoiceId}
            },
        
            pageLength: 100,
                "paging":   true,
                "ordering": false,
                "searching": false,
            rowId: 'category_slug',
              
            responsive: true,
            order: [],
            "columns": [ 

                { 
                    "data": "reception",
                    "render" : function(data, type, row, meta) {

                        var btnClass = 'btn-default';
                        var icon = 'lock_open';
                        var disabled = '';
                        var editClass = 'hidden';

                        if(data == 1) {
                            btnClass = 'btn-success';
                            icon = 'lock'
                            disabled = 'disabled';
                            editClass = '';

                        }

                        if(row.connected_total > (row.saga_quantity + row.delivered_quantity)) {
                            btnClass = 'btn-danger';
                            icon = 'lock'
                            disabled = 'disabled';
                            
                        }

                            
                        return '<button type="button" '+disabled+' class="reception btn '+btnClass+' btn-xs waves-effect"'+
                                 ' data-item='+row.id+' data-stock="'+row.saga_quantity+'" data-product='+row.product_id+' data-delivered='+row.delivered_quantity+'>'+
                                    '<i class="material-icons">'+icon+'</i>'+
                                '</button> ' +
                                '<button type="button" class="reverseReception '+editClass+' btn btn-default btn-circle waves-effect waves-circle waves-float"'+
                                 ' data-item='+row.id+' data-stock="'+row.saga_quantity+'" data-product='+row.product_id+' data-delivered='+row.delivered_quantity+'>'+
                                    '<i class="material-icons">refresh</i>'+
                                '</button>'
                  }
                },
                { 
                    "data": "product_id", 
                    "className": 'invoiceTableInput',
                    "render" : function(data, type, row, meta) {
                        var product = data;

                        if(product == 0 && row.external_item_name=='') {
                            console.log('asd')
                            product = '<div class="form-group">' + 
                                    '<div class="form-line">' + 
                                        '<input class="form-control vendor-invoice-external-input"' + 
                                        ' data-type="quantity" data-row="'+meta.row+
                                        '" data-col="'+meta.col+
                                        '" data-item="'+row.id+
                                        '" value="" type="text" name="external_item_name" placeholder="New Item" required>' + 
                                    '</div>' + 
                                '</div>'
                        } else if(!product) { product = row.external_item_name }

                        return product
                  }

                },
                { 
                    "data": "saga_quantity",
                    
                },
                { 
                    "data": "quantity", 
                    "className": 'invoiceTableInput',
                    "render" : function(data, type, row, meta) {

                        var disabled = ""

                        if(data > 0 && row.unit_price > 0 ) {
                            disabled = "disabled"
                        }
                            
                        return '<div class="form-group">' + 
                                    '<div class="form-line">' + 
                                        '<input class="form-control vendor-invoice-input"' + 
                                        ' data-type="external_item_name" data-row="'+meta.row+
                                        '" data-col="'+meta.col+
                                        '" data-item="'+row.id+
                                        '" value="'+data+'" type="number" '+disabled+' name="quantity" placeholder="Quantity"  min=0 required>' + 
                                    '</div>' + 
                                '</div>'
                  }
                },
                { 
                    "data": "unit_price",
                    "className": 'invoiceTableInput',
                    "render" : function(data, type, row, meta) {
                        var disabled = "disabled"

                        if(row.quantity > 0) {
                            disabled = ""
                        }

                        if(row.delivered_quantity !== "" ) {
                            disabled = "disabled"
                        }
                            
                        return '<div class="form-group">' + 
                                    '<div class="form-line">' + 
                                        '<input class="form-control vendor-invoice-input"' + 
                                        ' data-type="unit_price" data-row="'+meta.row+
                                        '" data-col="'+meta.col+
                                        '" data-item="'+row.id+
                                        '" value="'+data+'" type="number" '+disabled+' placeholder="Unit Price" name="unit_price"  min=0 required>' + 
                                    '</div>' + 
                                '</div>'
                        }
                },
                { 
                    "data": "total_price",
                    "className": 'invoiceTableInput',
                    "render" : function(data, type, row, meta) {
                            
                        return '<div class="form-group">' + 
                                    '<div class="form-line">' + 
                                        '<input class="form-control vendor-invoice-input"' + 
                                        ' data-type="total_price" data-row="'+meta.row+
                                        '" data-col="'+meta.col+
                                        '" data-item="'+row.id+
                                        '" value="'+data+'" type="number" placeholder="Total Price" name="total_price" disabled  min=0 required>' + 
                                    '</div>' + 
                                '</div>'
                  }
                },

                { 
                    "data": "delivered_quantity", 
                    "className": 'invoiceTableInput',
                    "render" : function(data, type, row, meta) {

                        var disabled = "disabled"

                        if(row.unit_price > 0) {
                            disabled = ""
                        }
                            
                        return '<div class="form-group">' + 
                                    '<div class="form-line">' + 
                                        '<input class="form-control vendor-invoice-input delivery"' + 
                                        ' data-type="external_item_name" data-row="'+meta.row+
                                        '" data-col="'+meta.col+
                                        '" data-item="'+row.id+
                                        '" value="'+data+'" type="number" '+disabled+' name="delivered_quantity" placeholder="Delivered Quantity" min=0>' + 
                                    '</div>' + 
                                '</div>'
                  }
                },
                {
                    "data": "connected_total"
                },

                { 
                        "data": null,
                        className: 'connect_quotes_td',
                        "render" : function(data, type, row, meta) {

                               //OrderSplit[row.id] = new OrderSplit(row.id, row.product_id);

                            // return OrderSplit[row.id].setWrapper(this);

                                    return '<button type="button" class="btn addConnection btn-default btn-xs waves-effect"'+
                                            ' data-product="'+row.product_id+'" data-item="'+row.id+'" data-delivered="'+row.delivered_quantity+'" data-toggle="modal "data-target="#addConnection-modal">'+
                                                '<i class="material-icons">add</i>'+
                                            '</button>'
                      }
                },
                {
                    "data": null,
                    "render" : function(data, type, row, meta) {

                        var disabled = ""

                        if(row.connected_total > 0 ) {
                            disabled = "disabled"
                        }

                       
                            return  ' <button type="button" data-item='+row.id+'  '+disabled+' class="removeItem  btn btn-danger btn-xs waves-effect">'+
                                    '<i class="material-icons">close</i>'+
                                '</button>'
                        

                         
                      }

                }
            ],
            "initComplete": function(settings, json) {
                //console.log(json);
                
            }, 
            "drawCallback": function(settings, json) {
                // var api = this.api();
                // var json = api.ajax.json();
                // //console.log(settings, json);
                // $.each(json, function (i, item) {
                //    // OrderSplit[item.id].setOrders(item);
                // });
            }

        });

    }

    var table = $('.invoice_items_table').DataTable();
 
    $('.addExternal').on('click', function () {

        var invoiceId = $(this).attr('data-invoice');

        var rowNode = table
        .row.add( {
            "id": "",
            "vendor_invoice_id": "10000",
            "product_id": "0",
            "quantity": "1",
            "unit_price": "",
            "total_price": "",
            "date_added": "",
            "reception": "0",
            "remaining_stock": "",
            "external_item_name": ""
        } )
            .draw()
            .node();
         
        $( rowNode )
            .css( 'color', 'red' )
            .animate( { color: 'black' } );
    });



    // $('.body').on('click', '.removeLine', function(){
    //     //console.log(this);
    //     var thisSplitId = $(this).attr('data-split');
    //     var orderNumber = $(this).attr('data-order');
    //     var quoteItemId = $(this).attr('data-quoteItem');
    //     var itemId = $(this).attr('data-item');
    //     OrderSplit[itemId].removeLine(itemId, thisSplitId, orderNumber,quoteItemId, this);
    // });

    $('.body').on('click', '.removeItem', function(){
        var itemId = $(this).attr('data-item');

        //console.log(itemId);
        
         $.ajax({
            url: "/ajax/removeInvoiceItem",
            type: "post",
            dataType: "json",
            data: {'id':itemId}
        }).success(function(json){

        }).error(function(xhr, status, error) {
           
        }).complete(function(data){

            table.ajax.reload();
            

        })
    });

    $('body').on('change', '.vendor-invoice-input', function(){

        //console.log($(this).attr('name'));
       

        var parent = $(this).closest('tr');

        var quantityElement = parent.find('input[name="quantity"]');

        var unitPriceElement = parent.find('input[name="unit_price"]');

        var deliveredQuantityElement = parent.find('input[name="delivered_quantity"]');


        var quantity = quantityElement.val();;

        var unitPrice = unitPriceElement.val();

        var totalPrice = quantity*unitPrice;

         if($(this).attr('name') != 'total_price') {

            parent.find('input[name="total_price"]').val(totalPrice).change()
        }


        if(quantity !== "") {
            unitPriceElement.prop('disabled', false)
        } else {
            unitPriceElement.prop('disabled', true)
        }

        if(unitPrice !== "") {
            deliveredQuantityElement.prop('disabled', false)
        } else {
            deliveredQuantityElement.prop('disabled', true)
        }


        var name = $(this).attr('name');

        var value = $(this).val()



        var orderDetail = {
            'item_id': $(this).attr('data-item'),
            'name': name,
            'value': value
        };


        //console.log(orderDetail);

         $.ajax({
            url: "/ajax/updateVendorInvoiceItems",
            type: "post",
            dataType: "json",
            data: orderDetail
        }).success(function(json){
           //$('.updateError').addClass('hidden');

           table.ajax.reload()

        }).error(function(xhr, status, error) {
           //$('.updateError').removeClass('hidden');
        })



    })


    $('body').on('change', '.invoice-date', function(){

        var date = $(this).val();

         $.ajax({
            url: "/ajax/getExchangeRate",
            type: "post",
            dataType: "json",
            data: {'date': date}
        }).success(function(json){
           //$('.updateError').addClass('hidden');
           $("#invoiceData input[name=exchange_rate]").val(json[0]);

        }).error(function(xhr, status, error) {
           //$('.updateError').removeClass('hidden');
        })
    })

    $('body').on('change', '.reserve-new-stock', function(){

        var quantity = $(this).val();

        var splitId = $(this).attr('data-split_id');

        var connectionsTable = $('.connections_table').DataTable();

        $.ajax({
            url: "/ajax/updateOrderLine",
            type: "post",
            dataType: "json",
            data: {'id':splitId,'quantity': quantity}
        }).success(function(json){

            connectionsTable.ajax.reload();

        }).error(function(xhr, status, error) {
           
        }).complete(function(data){

        })

    })


    $('body').on('change', '.toggleConnect', function(){


        var splitId = $(this).attr('data-split_id');

        var invoiceItemId = $(this).attr('data-vendor-item');

        var quoteItemId = $(this).attr('data-item');

        var needed_quantity = $(this).attr('data-neededQuantity');

        var connectionsTable = $('.connections_table').DataTable();

        console.log(splitId, invoiceItemId, quoteItemId, needed_quantity)

        var orderLine = {
            "vendor_invoice_item_id": invoiceItemId,
            "quote_item_id": quoteItemId,
            "quantity": needed_quantity ? needed_quantity : 0
        }


        if(this.checked) {
            $.ajax({
                url: "/ajax/addOrderLine",
                type: "post",
                dataType: "json",
                data: orderLine
            }).success(function(json){
                 connectionsTable.ajax.reload();
            }).error(function(xhr, status, error) {
               $('.updateError').removeClass('hidden');
            })
        } else {
             $.ajax({
                url: "/ajax/removeOrderLine",
                type: "post",
                dataType: "json",
                data: {'id':splitId}
            }).success(function(json){
                connectionsTable.ajax.reload();
            }).error(function(xhr, status, error) {
               $('.updateError').removeClass('hidden');
            })
        }

    })


    $('#addConnection-modal').on('hide.bs.modal', function(e){
console.log('a')
             table.ajax.reload()
        })


    $('body').on('click', '.addConnection', function(){

        var product_id = $(this).attr('data-product');

        var delivered_quantity = $(this).attr('data-delivered');

        var vendor_invoice_item_id = $(this).attr('data-item');

        $('#addConnection-modal').modal('show')

        $('.connections_table').DataTable({
            "ajax": {
                "url": "/ajax/getVendorInvoiceItemQuotes/",
                "dataSrc": "",
                "type": 'POST',
                data: {'product_id': product_id, 'vendor_invoice_item_id': vendor_invoice_item_id}
            },
            "bDestroy": true,
            pageLength: 100,
                "paging":   true,
                "ordering": true,
                "searching": true,
            rowId: 'category_slug',
              
            responsive: true,
            order: [],
            "columns": [ 
                { 
                    "data": "id"
                },
                { 
                    "data": "quote_id"
                },
                { 
                    "data": "quoteQuantity"
                },
                { 
                    "data": "reserved_stock"
                },
                { 
                    "data": "order_number"
                },
                { 
                    "data": "ordered_quantity"
                },
                {
                    "data": null,
                    "render" : function(data, type, row, meta) {

                        return '<span class="label label-warning">' +
                             row.needed_quantity +
                        '</label>'
                    }
                },
                { 
                    "data": "split_quantity",
                    "render" : function(data, type, row, meta) {

                        var disabled = "disabled"

                            if(row.split_id ) {
                                disabled = ""
                            }
                                
                            return '<div class="form-group">' + 
                                        '<div class="form-line">' + 
                                            '<input class="form-control reserve-new-stock"' + 
                                            ' data-type="reserve-new-stock" data-row="'+meta.row+
                                            '" data-col="'+meta.col+
                                            '" data-quote_item_id="'+row.id+
                                            '" data-split_id="'+ row.split_id +
                                            '" value="'+ data +'" type="number" '+ disabled +' name="reserve-new-stock" placeholder="Add" min=0>' + 
                                        '</div>' + 
                                    '</div>'
                      }
                },
                {
                    "data": null,
                    "className": "line-status",
                    "render" : function(data, type, row, meta) {

                        var possibleQuantity = Number(row.saga_quantity) + Number(row.delivered_quantity) - Number(connected);
                        
                        var infoBoxClass = "";
                        var infoBoxIcon = "";

                        var split_quantity = Number(row.split_quantity);
                        var needed_quantity = Number(row.needed_quantity);

                        var delivered = Number(row.delivered_quantity);

                        console.log(possibleQuantity);

                        if (row.split_id == "") {
                            return ""
                        } else {

                            if( split_quantity > possibleQuantity) {
                                infoBoxClass = "bg-red";
                                infoBoxIcon = "error";
                                infoBoxMessage = "Stock unavailable";
                            } else {
                                if(split_quantity < needed_quantity) {
                                    infoBoxClass = "bg-blue";
                                    infoBoxIcon = "arrow_downward";
                                    infoBoxMessage = "Less than quote";
                                } else if (split_quantity > needed_quantity){
                                    infoBoxClass = "bg-orange";
                                    infoBoxIcon = "arrow_upward";
                                    infoBoxMessage = "More than quote";
                                } else if (split_quantity == needed_quantity){
                                    infoBoxClass = "bg-green";
                                    infoBoxIcon = "check_circle";
                                    infoBoxMessage = "As in quote";
                                }  
                            }

                             return '<div class="info-box info-box-xs">' +
                                    '<div class="icon '+ infoBoxClass +'">' +
                                        '<i class="material-icons">'+ infoBoxIcon +'</i>' +
                                    '</div>' +
                                    '<div class="content">' +
                                        '<div class="text">'+ infoBoxMessage +'</div>' +
                                    '</div>' +
                                '</div>'
                        }
                    }
                },
                {
                    "data": null,
                    "render" : function(data, type, row, meta) {

                        var checked = "";

                            if(row.split_id ) {
                                checked = "checked"
                            }
                                
                            return '<input type="checkbox" id="connectItem-'+ row.id +
                            '" data-item = "'+ row.id +'" data-vendor-item="'+ vendor_invoice_item_id +'" " data-split_id = "'+ row.split_id +'" data-neededQuantity = "'+ row.needed_quantity +'" class="filled-in chk-col-light-green toggleConnect" '+ checked +' >' +
                            '<label for="connectItem-'+ row.id +'">Connect</label>'

                      }
                }
            ],
            "initComplete": function(settings, json) {
                
                
            },

            "drawCallback": function(settings, json) {
                var api = this.api();
                var json = api.ajax.json();
                connected = 0;
                //console.log(settings, json);

                $.each(json, function (i, item) {
                    connected = connected + Number(item['split_quantity']);
                });

                console.log(json)

                if(json) {
                    $('.info-box-productID').html(product_id);
                    $('.info-box-stock').html(json[0]['saga_quantity']);
                    $('.info-box-deliveredQuantity').html(delivered_quantity);


                    $('.info-box-connected').html(connected);

                    var usedFromDelivery = delivered_quantity - connected;

                    if(usedFromDelivery < 0) {
                        $('.info-box-from-stock').html(-usedFromDelivery);
                        $('.info-box-to-stock').html(0);
                    }else {
                        $('.info-box-to-stock').html(usedFromDelivery);
                        $('.info-box-from-stock').html(0);
                    }
                }
                

                console.log(connected)
            }

                   

        });

        

        // $.ajax({
        //     url: "/ajax/getVendorInvoiceItemQuotes",
        //     type: "post",
        //     dataType: "json",
        //     data: {'product_id': product_id, 'vendor_invoice_item_id': vendor_invoice_item_id},
        //     async: false
        // }).success(function(json){
        //    //$('.updateError').addClass('hidden');

       


        //     console.log(totalConnected);


        //    table.clear().rows.add(json).draw()
          

        // }).error(function(xhr, status, error) {
        //    //$('.updateError').removeClass('hidden');
        // })
    })


     $('body').on('change', '.vendor-invoice-external-input', function(){

        //console.log($(this).attr('name'));
       

        var parent = $(this).closest('tr');

        var name = $(this).attr('name');

        var value = $(this).val()

        var inv



        var itemDetail = {
            'vendor_invoice_id': invoiceId,
            'external_item_name': value,
        };


        //console.log(orderDetail);

         $.ajax({
            url: "/ajax/addVendorInvoiceItems",
            type: "post",
            dataType: "json",
            data: itemDetail
        }).success(function(json){
           //$('.updateError').addClass('hidden');
           location.reload()

        }).error(function(xhr, status, error) {
           //$('.updateError').removeClass('hidden');
        })



    })
    
    // $('body').on('click', '.orderItem', function(){

    //     var that = $(this);

    //     var invoiceItemId = $(this).attr('data-item');

    //     var quoteItemId = $(this).attr('data-quoteItem');

    //     var orderNumber = $(this).attr('data-order')

    //     var quoteId = $(this).attr('data-quoteId')
    //     var quoteQuantity = $(this).attr('data-quoteQuantity')
    //     var reservedStock = $(this).attr('data-reservedStock')


    //     var quantity = $(this).attr('data_neededquantity');


    //     OrderSplit[invoiceItemId].addOrderLine(invoiceItemId, quoteItemId, quantity, orderNumber, quoteId, quoteQuantity, reservedStock);

    // });


    // $('.body').on('change', '.reserve_custom', function(){

    //     var invoiceItemId = $(this).attr('data-item');

    //     if($(this).is(':checked')) {
    //         $(this).siblings('input[name="reserve_custom"]').prop('disabled', false);
    //     } else {
    //         $(this).siblings('input[name="reserve_custom"]').prop('disabled', true);
           
            

    //         var splitId = $(this).attr('data-split');

    //         var quantity = $(this).attr('data-neededQuantity');

    //         var oldQuantity = $(this).siblings('input[name="reserve_custom"]').val()

    //         $(this).siblings('input[name="reserve_custom"]').val(quantity).change();
    //     }

       
    // });

//     $('.body').on('click', '.reception', function(){

//         var invoiceItemId = $(this).attr('data-item');

//         var product = $(this).attr('data-product');

//         var delivered = Number($(this).attr('data-delivered'));

//         var stock = $(this).attr('data-stock');

//         var freeStock = $('.list-total[data-item='+invoiceItemId+'] .freeStock').text();

//         var splitLines = $('.list-inline[data-item='+invoiceItemId+']');

//         if(freeStock == 0 && splitLines.length == 0) {
//             freeStock = delivered;
//         }

//         var itemDetails = {
//             'itemId': invoiceItemId,
//             'newStock': Number(stock) + Number(freeStock),
//             'freeStock': freeStock,
//             'quoteItems' :{},
//             'product': product
//         }

//         var splitTotal = 0;

//         splitLines.each(function(index, item){

            

//              var itemInput = $(item).find('input[name="reserve_custom"]');

//              var itemQuantity = itemInput.val();

//              var quoteItemId = itemInput.attr('data-quoteItem');
//              var reservedStock = $(item).attr('data-reserved');

//              //console.log(splitTotal, itemQuantity);

//              splitTotal = splitTotal + Number(itemQuantity);

//              var quantities = {
//                 'splitQuantity' : itemQuantity,
//                 'reservedStock': reservedStock
//              }

//              //console.log(itemQuantity);

//              //console.log(quantities);

//              itemDetails.quoteItems[quoteItemId] = quantities;
//         })

//         console.log(splitTotal, Number(delivered), itemDetails);


//         if(delivered < splitTotal) {

//             $(this).removeClass('btn-default').addClass('btn-warning');


//         } else {

//             $.ajax({
//                 url: "/ajax/itemReception",
//                 type: "post",
//                 dataType: "json",
//                 data: itemDetails
//             }).success(function(json){
//                //$('.updateError').addClass('hidden');

//                table.ajax.reload();

//                $(this).removeClass('btn-warning');

//                OrderSplit[invoiceItemId].disableActions(invoiceItemId);
                
               

//             }).error(function(xhr, status, error) {
//                //$('.updateError').removeClass('hidden');
//             })
//         }

        

        
//     });

//     $('.body').on('click', '.reverseReception', function(){

//         var invoiceItemId = $(this).attr('data-item');

//         var product = $(this).attr('data-product');

//         var stock = $(this).attr('data-stock');

//         var delivered = Number($(this).attr('data-delivered'));


//         var freeStock = $('.list-total[data-item='+invoiceItemId+'] .freeStock').text() ;



//         var splitLines = $('.list-inline[data-item='+invoiceItemId+']');

//         if(freeStock == 0 && splitLines.length == 0) {
//             freeStock = delivered;
//         }

//         var itemDetails = {
//             'itemId': invoiceItemId,
//             'newStock': Number(stock) - Number(freeStock),
//             'freeStock': 0,
//             'quoteItems' :{},
//             'product': product
//         }

//         splitLines.each(function(index, item){

//             //console.log(item);
             

//              var itemInput = $(item).find('input[name="reserve_custom"]');

//              var itemQuantity = itemInput.val();

//              var quoteItemId = itemInput.attr('data-quoteItem');

//              var quantities = {
//                 'splitQuantity' : itemQuantity
//              }

//              //console.log(quantities);

//              itemDetails.quoteItems[quoteItemId] = quantities;
//         })

//         $.ajax({
//             url: "/ajax/itemReverseReception",
//             type: "post",
//             dataType: "json",
//             data: itemDetails
//         }).success(function(json){
//            //$('.updateError').addClass('hidden');

//            table.ajax.reload();

//              OrderSplit[invoiceItemId].enableActions(invoiceItemId);     

//         }).error(function(xhr, status, error) {
//            //$('.updateError').removeClass('hidden');
//         })

        
//     });

//      $('.body').on('change', 'input[name="reserve_custom"]', function(){

//         var invoiceItemId = $(this).attr('data-item');

//         var splitId = $(this).attr('data-split');

//         var quantity = $(this).val();

//         var oldQuantity = $(this).siblings('.reserve_custom').attr('data-neededquantity');

//         var invoicedQuantity = Number($('.vendor-invoice-input[name="quantity"][data-item='+invoiceItemId+']').val())

//         var deliveredQuantity = Number($('.vendor-invoice-input[name="delivered_quantity"][data-item='+invoiceItemId+']').val());

//             if(deliveredQuantity > 0) {
//                 invoicedQuantity = deliveredQuantity;
//             }

//         var splitTotal = OrderSplit[invoiceItemId].getSplitTotal(invoiceItemId);

//         //console.log(oldQuantity, quantity);

//         if(splitTotal > invoicedQuantity)
//         {
//             $('.list-total[data-item='+invoiceItemId+'] .quantityError').removeClass('hidden')
//             $('.reception[data-item='+invoiceItemId+']').addClass('btn-danger').removeClass('btn-default').removeClass('btn-warning').prop('disabled', true)
//         } else {
//             $('.list-total[data-item='+invoiceItemId+'] .quantityError').addClass('hidden');
//             $('.reception[data-item='+invoiceItemId+']').removeClass('btn-danger').removeClass('btn-warning').addClass('btn-default').prop('disabled', false)
//         }

//         OrderSplit[invoiceItemId].setTotal(invoiceItemId, invoicedQuantity, splitTotal)
//         OrderSplit[invoiceItemId].updateLine(splitId, quantity, oldQuantity); 

//     });

 });

$(function () {
    
    //Bootstrap datepicker plugin
    $('#bs_datepicker_container input').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        container: '#bs_datepicker_container'
    });
});


function getPossibleQuantity(params){

    return Number(params.stock) + Number(params.delivered) - Number(params.connected)

}