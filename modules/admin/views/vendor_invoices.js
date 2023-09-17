
$(document).ready(function() {


    function itemTypesList(){

        var itemTypesList = "";

        $.ajax({
            url: "/ajax/getVendorItemTypesList",
            type: "post",
            dataType: "text",
            async:false
        }).success(function(json){
           $('.updateError').addClass('hidden');

            JSON.parse(json).forEach(function(val, index){
                itemTypesList = itemTypesList + 
                  '<li class=""><a class="setItemType waves-effect waves-block" data-item_type_id="'+ val.id +'">'+
                            val.name +
                                '</a>'+
                            '</li>'
           })
           
        }).error(function(xhr, status, error) {
           $('.updateError').removeClass('hidden');
        })

        //console.log(itemTypesList);

        return itemTypesList
    }

    $('body').on('click', '.setItemType', function(e){

      itemTypesData = {
        'product_id' : $(this).parents('ul').attr('data-product'),
        'item_type_id' : $(this).attr('data-item_type_id'),
        
        'vendor_item' : $(this).parents('ul').attr('data-vendor_item')
      }

      //console.log(itemTypesData)


      $.ajax({
            url: "/ajax/updateVendorItemType",
            type: "post",
            dataType: "json",
            data: itemTypesData
        }).success(function(json){
           $('.updatePackageItemError').addClass('hidden');
           //console.log(json);
           itemsTable.ajax.reload()

        }).error(function(xhr, status, error) {
            $('.updatePackageItemError').removeClass('hidden');
        })

    })


    var itemTypesDropDown = itemTypesList();

    var connectedQuotes = [];

    //var connected;

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
        order: [0],
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
        console.log(invoiceData);
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
                "searching": true,
            rowId: 'category_slug',
              
            responsive: true,
            order: [],
            "columns": [ 

                { 
                    "data": "reception",
                    "className": "invoiceTableInput",
                    "render" : function(data, type, row, meta) {

                        //console.log(data)

                        var btnClass = 'btn-default';
                        var icon = 'lock_open';
                        var disabled = '';
                        var editClass = 'hidden';

                        if(data == 1) {
                            btnClass = 'btn-success';
                            icon = 'lock'
                            disabled = 'disabled';
                            editClass = '';

                        } else {
                            if(Number(row.connected_total) > (Number(row.saga_quantity) + Number(row.delivered_quantity)) && Number(row.saga_quantity) > 0) {
                                btnClass = 'btn-danger';
                                icon = 'lock'
                                disabled = 'disabled';
                                
                            }
                        }

                        

                            
                        return '<button type="button" '+disabled+' class="reception btn '+btnClass+' btn-xs waves-effect"'+
                                 ' data-item='+row.id+' data-invoice='+invoiceId+' data-stock="'+row.saga_quantity+'" data-product="'+row.product_id+'" data-delivered='+row.delivered_quantity+'>'+
                                    '<i class="material-icons">'+icon+'</i>'+
                                '</button> ' +
                                '<button type="button" class="reverseReception '+editClass+' btn btn-default btn-circle waves-effect waves-circle waves-float"'+
                                 ' data-item='+row.id+' data-invoice='+invoiceId+' data-stock="'+row.saga_quantity+'" data-product="'+row.product_id+'" data-delivered='+row.delivered_quantity+'>'+
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
                    "data": "type_name",
                    "render" : function(data, type, row, meta) {

                        var value = data;

                         if(!row.product_id )  {

                             value = value + 
                                            ' <div class="btn-group">'+
                                                '<button class="btn btn-default btn-xs "' + 
                                                ' data-row="'+meta.row+
                                                '" data-col="'+meta.col+
                                                '" data-package="'+invoiceId+
                                               
                                                '" data-vendor_item="'+row.id+
                                                '" data-product="'+row.product_id+'" data-toggle="dropdown'+
                                                '" aria-haspopup="true" aria-expanded="true">'+
                                                        '<i class="material-icons">edit</i>'+ 
                                                '</button>'+
                                                '<ul class="dropdown-menu"'+
                                                ' data-row="'+meta.row+
                                                '" data-col="'+meta.col+
                                                '" data-package="'+invoiceId+
                                                
                                                '" data-vendor_item="'+row.id+
                                                '" data-product="'+row.product_id+'" data-toggle="dropdown">'+
                                                        itemTypesDropDown
                                                '</ul>'
                                            '</div>';
                        }
                       
                            return  value
                         
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

                        if(row.reception > 0  ) {
                            disabled = "disabled"
                        }   
                        return '<div class="form-group">' + 
                                    '<div class="form-line">' + 
                                        '<input class="form-control vendor-invoice-input"' + 
                                        ' data-type="external_item_name" data-row="'+meta.row+
                                        '" data-col="'+meta.col+
                                        '" data-item="'+row.id+
                                        '" value="'+data+'" type="number" '+disabled+' name="quantity" placeholder="Quantity" required>' + 
                                    '</div>' + 
                                '</div>'
                  }
                },
                { 
                    "data": "unit_price",
                    "className": 'invoiceTableInput, invoiceTableInput-unitPrice',
                    "render" : function(data, type, row, meta) {
                        var disabled = "disabled"

                        // if(row.quantity > 0) {
                        //     disabled = ""
                        // }

                        // if(row.delivered_quantity !== "" ) {
                        //     disabled = "disabled"
                        // }

                        // console.log(row.reception, row.reception > 0);


                         if(row.reception > 0  ) {
                            disabled = "disabled"
                        } else {
                            disabled = "";
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
                    "className": 'invoiceTableInput, invoiceTableInput-totalPrice',
                    "render" : function(data, type, row, meta) {
                            
                        return '<div class="form-group">' + 
                                    '<div class="form-line">' + 
                                        '<input class="form-control vendor-invoice-input"' + 
                                        ' data-type="total_price" data-row="'+meta.row+
                                        '" data-col="'+meta.col+
                                        '" data-item="'+row.id+
                                        '" value="'+data+'" type="number" placeholder="Total Price" name="total_price" disabled required>' + 
                                    '</div>' + 
                                '</div>'
                  }
                },

                { 
                    "data": "delivered_quantity", 
                    "className": 'invoiceTableInput',
                    "render" : function(data, type, row, meta) {

                        var disabled = "disabled"

                        //console.log(row.unit_price > 0 && row.reception == 0)

                        if(row.unit_price > 0 && row.reception == 0) {
                            disabled = ""
                        }

                        if(row.reception > 0  ) {
                            disabled = "disabled"
                        } 
                            
                        return '<div class="form-group">' + 
                                    '<div class="form-line">' + 
                                        '<input class="form-control vendor-invoice-input delivery"' + 
                                        ' data-type="external_item_name" data-row="'+meta.row+
                                        '" data-col="'+meta.col+
                                        '" data-item="'+row.id+
                                        '" value="'+data+'" type="number" '+disabled+' name="delivered_quantity" placeholder="Delivered Quantity">' + 
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

                },
                 
            ],
            "initComplete": function(settings, json) {
                //console.log(json);
                
            }, 
            "drawCallback": function(settings, json) {
                calculateInvoiceValue();
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




        //console.log($('input[name="total_price"]'));

        calculateInvoiceValue();

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

        //console.log(splitId, invoiceItemId, quoteItemId, needed_quantity)

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
//console.log('a')
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

                            if(row.split_id && row.reception == 0) {
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
                    "data": "split_quantity",
                    "className": "line-status",
                    "render" : function(data, type, row, meta) {


                        var possibleQuantity = Number(row.saga_quantity) + Number(row.delivered_quantity) - Number(row.connected_total);
                        
                        var infoBoxClass = "";
                        var infoBoxIcon = "";

                        var split_quantity = Number(data);
                        var needed_quantity = Number(row.needed_quantity);

                        var delivered = Number(row.delivered_quantity);

                        //console.log(connected);
                        

                        if (row.split_id == "" || row.reception == 1) {
                            return ""
                        } else {

                            if(possibleQuantity < 0) {
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
                        var disabled = "";

                            if(row.split_id ) {
                                checked = "checked"
                            }

                            if(row.reception == 1) {
                                disabled = "disabled";
                            }
                                
                            return '<input '+ disabled +' type="checkbox" id="connectItem-'+ row.id +
                            '" data-item = "'+ row.id +'" data-vendor-item="'+ vendor_invoice_item_id +'" " data-split_id = "'+ row.split_id +'" data-neededQuantity = "'+ row.needed_quantity +'" class="filled-in chk-col-light-green toggleConnect" '+ checked +' >' +
                            '<label for="connectItem-'+ row.id +'">Connect</label>'
                      }
                }
            ],
            "preDraw": function(settings, json) {
                
                //console.log('a')
            },

            "drawCallback": function(settings, json) {
                var api = this.api();
                var json = api.ajax.json();
                //connected = 0;
                //console.log(settings, json);

                // $.each(json, function (i, item) {
                //     connected = connected + Number(item['split_quantity']);
                // });

                //console.log(json)

                if(json) {
                    $('.info-box-productID').html(product_id);
                    $('.info-box-stock').html(json[0]['saga_quantity']);
                    $('.info-box-deliveredQuantity').html(delivered_quantity);


                    $('.info-box-connected').html(json[0]['connected_total']);

                    var usedFromDelivery = delivered_quantity - json[0]['connected_total'];

                    if(usedFromDelivery < 0) {
                        $('.info-box-from-stock').html(-usedFromDelivery);
                        $('.info-box-to-stock').html(0);
                    }else {
                        $('.info-box-to-stock').html(usedFromDelivery);
                        $('.info-box-from-stock').html(0);
                    }
                }
                

                //console.log(connected)
            }

                   

        });
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

    $('.body').on('click', '.reception, .reverseReception', function(){

        var vendor_invoice_item_id = $(this).attr('data-item');

        var product_id = $(this).attr('data-product');

        var invoice_id = $(this).attr('data-invoice');

        var isInverse = 0;

        if($(this).hasClass('reverseReception')) {
            isInverse = 1;
        }

        $.ajax({
            url: "/ajax/getVendorInvoiceItemQuotes",
            type: "post",
            dataType: "json",
            async: false,
            data: {'product_id': product_id, 'vendor_invoice_item_id': vendor_invoice_item_id}
        }).success(function(json){
           $('.updateError').addClass('hidden');

           var quoteItems = json;

           var itemDetails = {
            "item_id": vendor_invoice_item_id,
            "product_id": product_id,
            "quoteItems": quoteItems,
            "is_inverse": isInverse
           }

           $.ajax({
                url: "/ajax/itemReception",
                type: "post",
                dataType: "json",
                data: itemDetails
            }).success(function(json){
               $('.updateError').addClass('hidden');

               table.ajax.reload();
  

            }).error(function(xhr, status, error) {
               $('.updateError').removeClass('hidden');
            })

        }).error(function(xhr, status, error) {
           $('.updateError').removeClass('hidden');
        }) 

        
    });

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


function calculateInvoiceValue() {
    var sum = 0;
            
    $('input[name="total_price"]').each(function() {
        sum += parseFloat($(this).val()) || 0;
    });


    sum = sum.toFixed(2);

    $('input[name="calculated_invoice_value"]').val(sum);

    if($('input[name="invoice_value"]').val() == sum) {
        $('input[name="invoice_value"]').addClass('validTotalPrice');
        $('input[name="invoice_value"]').removeClass('invalidTotalPrice');

    } else {
        $('input[name="invoice_value"]').addClass('invalidTotalPrice');
        $('input[name="invoice_value"]').removeClass('validTotalPrice');
    }
}
