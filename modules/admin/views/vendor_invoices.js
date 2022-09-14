
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
            },
            { 
                "data": "quantity", 
                "render" : function(data, type, row, meta) {
                        
                    return '<div class="form-group">' + 
                                '<div class="form-line">' + 
                                    '<input class="form-control vendor-invoice-input"' + 
                                    ' data-type="quantity" data-row="'+meta.row+
                                    '" data-col="'+meta.col+
                                    '" data-item="'+row.id+
                                    '" value="'+data+'" type="number" name="quantity" placeholder="Quantity"  min=0 required>' + 
                                '</div>' + 
                            '</div>'
              }
            },
            { 
                "data": "unit_price",
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
                "render" : function(data, type, row, meta) {
                        
                    return '<div class="form-group">' + 
                                '<div class="form-line">' + 
                                    '<input class="form-control vendor-invoice-input"' + 
                                    ' data-type="total_price" data-row="'+meta.row+
                                    '" data-col="'+meta.col+
                                    '" data-item="'+row.id+
                                    '" value="'+data+'" type="number" placeholder="Total Price" name="total_price"  min=0 required>' + 
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
            console.log(json);
            $.each(json, function (i, item) {
                OrderSplit[item.id].setOrders(item);
            });



        }

    });


    $('.body').on('click', '.removeLine', function(){
        console.log(this);
        var thisSplitId = $(this).attr('data-split');
        var itemId = $(this).attr('data-item');
        OrderSplit[itemId].removeLine(itemId, thisSplitId, this);
    });

    $('body').on('change', '.vendor-invoice-input', function(){

        var name = $(this).attr('name');

        var value = $(this).val()



        var orderDetail = {
            'item_id': $(this).attr('data-item'),
            'name': name,
            'value': value
        };


        console.log(orderDetail);

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