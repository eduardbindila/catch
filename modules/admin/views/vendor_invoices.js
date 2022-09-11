
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
                        return '<div class="connect_quotes_container">'+
                                    '<ul class="list-inline ">'+
                                        '<li>'+
                                            '<select class="connected_quotes item-'+row.id+' data-item='+row.id+' show-tick" data-product="'+row.product_id+'" >'+
                                                '<option value="">Select Quote</option>'+
                                            '</select>'+
                                        '</li>'+
                                        '<li class="connect_quotes_container_list">'+
                                        '</li>'+
                                    '</ul>'+
                                '</div>';
                  }
                }
        ],
        "initComplete": function(settings, json) {
            $.each(json, function (i, item) {

                console.log(item);

                $.ajax({
                    url: "/ajax/getVendorInvoiceItemQuotes",
                    type: "post",
                    dataType: "json",
                    data: {'product_id': item.product_id}
                }).success(function(json){
                   $.each(json, function (x, quote) {
                    console.log(quote);
                        $('.item-'+item.id).append($('<option>', { 
                            value: quote.id,
                            text : quote.id+' - '+quote.name 
                        }));
                    });

                }).error(function(xhr, status, error) {
                   //$('.updateError').removeClass('hidden');
                }).done(function(json){

                })

            });

        }

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
    
    $('body').on('change', '.connected_quotes', function(){

        var that = $(this);

        var itemId = $(this).attr('data-item');

        var value = that.val();

        var ul = that.parent('li').next('.connect_quotes_container_list');

        console.log(value, that);

        var itemConnection = '<ul class="list-inline"><li class="">'+value+'</li>'+
                                '<li class="">'+
                                    '<button class="btn btn-lg btn-success">All</button>'+
                                '</li>'+
                                '<li>OR</li>'+
                                '<li class="">'+
                                    '<input class="small-input"' + 
                                    '" value="" type="number" placeholder="Few" name="reserve_custom" min=0 required>' + 
                                '</li>'+
                                '<li class="">'+
                                    '<button class="btn btn-lg btn-danger">x</button>'+
                                '</li>'+
                            '</ul>';
                         

        ul.append(itemConnection);
       

        // if((typeof connectedQuotes[itemId] !== 'undefined'))

        // connectedQuotes['']

    })


});

$(function () {
    
    //Bootstrap datepicker plugin
    $('#bs_datepicker_container input').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        container: '#bs_datepicker_container'
    });
});