
$(document).ready(function() {


    var connectedQuotes = [];

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
        order: [1, 'asc'],
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
                "ordering": true,
                "searching": true,
            rowId: 'category_slug',
              
            responsive: true,
            order: [1, 'asc'],
            "columns": [ 
                { 
                    "data": "reception"
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
                    "data": "quantity", 
                    "className": 'invoiceTableInput',
                    "render" : function(data, type, row, meta) {
                            
                        return '<div class="form-group">' + 
                                    '<div class="form-line">' + 
                                        '<input class="form-control vendor-invoice-input"' + 
                                        ' data-type="external_item_name" data-row="'+meta.row+
                                        '" data-col="'+meta.col+
                                        '" data-item="'+row.id+
                                        '" value="'+data+'" type="number" name="quantity" placeholder="Quantity"  min=0 required>' + 
                                    '</div>' + 
                                '</div>'
                  }
                },
                { 
                    "data": "unit_price",
                    "className": 'invoiceTableInput',
                    "render" : function(data, type, row, meta) {
                            
                        return '<div class="form-group">' + 
                                    '<div class="form-line">' + 
                                        '<input class="form-control vendor-invoice-input"' + 
                                        ' data-type="unit_price" data-row="'+meta.row+
                                        '" data-col="'+meta.col+
                                        '" data-item="'+row.id+
                                        '" value="'+data+'" type="number" placeholder="Unit Price" name="unit_price"  min=0 required>' + 
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
                        "data": null,
                        className: 'connect_quotes_td',
                        "render" : function(data, type, row, meta) {

                               OrderSplit[row.id] = new OrderSplit(row.id, row.product_id);

                            return OrderSplit[row.id].setWrapper(this);
                      }
                    }
            ],
            "initComplete": function(settings, json) {
                //console.log(json);
                $.each(json, function (i, item) {
                    OrderSplit[item.id].setOrders(item);
                });



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



    $('.body').on('click', '.removeLine', function(){
        console.log(this);
        var thisSplitId = $(this).attr('data-split');
        var orderNumber = $(this).attr('data-order');
        var quoteItemId = $(this).attr('data-quoteItem');
        var itemId = $(this).attr('data-item');
        OrderSplit[itemId].removeLine(itemId, thisSplitId, orderNumber,quoteItemId, this);
    });

    $('body').on('change', '.vendor-invoice-input', function(){

        //console.log($(this).attr('name'));
       

        var parent = $(this).closest('tr');

        var quantity = parent.find('input[name="quantity"]').val();;

        var unitPrice = parent.find('input[name="unit_price"]').val();

        var totalPrice = quantity*unitPrice;

         if($(this).attr('name') != 'total_price') {

            parent.find('input[name="total_price"]').val(totalPrice).change()
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

        }).error(function(xhr, status, error) {
           //$('.updateError').removeClass('hidden');
        })



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
    
    $('body').on('click', '.orderItem', function(){



        var that = $(this);

        var invoiceItemId = $(this).attr('data-item');

        var quoteItemId = $(this).attr('data-quoteItem');

        var orderNumber = $(this).attr('data-order')

        var quantity = $(this).attr('data_neededquantity');

        OrderSplit[invoiceItemId].addOrderLine(invoiceItemId, quoteItemId, quantity, orderNumber);

    });


    $('.body').on('change', '.reserve_custom', function(){

        if($(this).is(':checked')) {
            $(this).siblings('input[name="reserve_custom"]').prop('disabled', false);
        } else {
            $(this).siblings('input[name="reserve_custom"]').prop('disabled', true);
            $(this).siblings('input[name="reserve_custom"]').val('');

            var invoiceItemId = $(this).attr('data-item');

            var splitId = $(this).attr('data-split');

            var quantity = $(this).attr('data-neededQuantity');

            OrderSplit[invoiceItemId].updateLine(splitId, quantity);
        }

       
    });

     $('.body').on('change', 'input[name="reserve_custom"]', function(){

        var invoiceItemId = $(this).attr('data-item');

        var splitId = $(this).attr('data-split');

        var quantity = $(this).val();

        OrderSplit[invoiceItemId].updateLine(splitId, quantity);


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