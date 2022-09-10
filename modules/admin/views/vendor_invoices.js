
$(document).ready(function() {
    var projectsTable = $('.projects_table').DataTable({
        "ajax": {
            "url": "/ajax/getVendorInvoicesList/",
            "dataSrc": ""
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
        $(".vendorTypesSelector[name=vendor]").val(invoiceData.vendor);

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
        $("#invoiceData input[name=currency]").val(invoiceData.currency);
        $("#invoiceData input[name=exchange_rate]").val(invoiceData.exchange_rate);
        $("#invoiceData input[name=vat_value]").val(invoiceData.vat_value);
        $("#invoiceData input[name=invoice_value]").val(invoiceData.invoice_value);
    }

     $('.editSwitch').change(function() {
        isDisabled = !isDisabled;
        if(!isDisabled) {
            $('#invoiceData').find('input, textarea, button, select').prop("disabled", false);;
        } else {
            $('#invoiceData').find('input, textarea, button, select').attr('disabled','disabled');
        }      
    })


    $('#invoiceData').on('submit',function(){
        console.log('as');
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