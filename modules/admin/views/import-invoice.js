$(document).ready(function() {

     $('#sagaButtons button').on('click', function(e){

        var type = $(this).parent().attr('data-type');
        var invoice = $(this).parent().attr('data-invoice');
        var code = $(this).parent().attr('data-code');
        var request = $(this).parent().attr('data-request');
        var notification = $(this).parent().attr('data-notification');
        var processId = $(this).parent().attr('data-process');


        if(processId !== 0) {
            showProcessID = "&processId="+processId; 
        } else
        {
            showProcessID = "";
        }

        switch($(this).attr('id')) {
          case 'verifySagaInvoiceDetails':
            thisUrl = "/cron/verifySagaInvoiceDetails?type="+type+"&invoice="+invoice+"&code="+code;
            break;
          case 'exportInvoiceToSaga':
            thisUrl = "/cron/exportInvoiceToSaga?type="+type+"&invoice="+invoice+"&code="+code+showProcessID;
            break;

        }

        if($(this).attr('id') == 'verifySagaInvoiceDetails') {

            $.ajax({
                url: thisUrl,
                beforeSend: function() {
                    // Înainte de a face request-ul AJAX, afișăm preloader-ul și ascundem eventuala eroare
                    $('.verify_preloader').removeClass('hidden');
                },
            }).success(function(json){
                if(json !== 0) {
                $('.addUserError').addClass('hidden');

                obj = JSON.parse(json);


                if(obj.checkJson.status == 'KO') {

                    var verifyTable = $('.verifyResult').DataTable({
                         "data" : obj.checkJson.message,
                    
                        pageLength: 100,
                            "paging":   true,
                            "ordering": true,
                            "searching": true,
                        rowId: 'category_slug',
                          
                        responsive: true,
                        order: [1],
                        "columns": [ 
                            { 
                                "data": "error"
                            },
                            { 
                                "data": "cod"
                            }
                            ,
                            { 
                                "data": "status",
                                "render" : function(data, type, row) {
                                    var statusLabel = getStatus(data );
                                    console.log(data);

                                    return statusLabel
                                  } 
                            },
                            {
                                "data": null,
                                "render" : function(data, type, row) {
                                    var label = '';
                                    if(row.status == 'KO') {
                                        console.log(obj);
                                        url = "/cron/sendSelected"
                                        switch(row.error) {
                                          case 'CLI':
                                           label = "Send Client to Saga";
                                           postJson = obj.clientJson;
                                            break;
                                          case 'ART':
                                           label = "Send All Products to Saga";
                                           postJson = obj.productsJson;
                                           
                                            break;
                                          case 'FUR':
                                            label = "Send Vendor to Saga";
                                            postJson = obj.vendorJson;
                                            break;
                                        }

                                             // Stringify JSON-ul pentru a-l trece ca argument într-o funcție
                                            var postJsonString = JSON.stringify(postJson);

                                        return `<button type="button" class="btn btn-primary waves-effect" onclick='sendDetailsToSaga("${url}", ${postJsonString})'>${label}</button>`;
                                    } else {
                                        return '';
                                    }

                                    
                                  } 
                            }
                        ],
                        "initComplete": function(settings, json) {

                            $('.verify_preloader').addClass('hidden');
                            $('.verifyWrapper').removeClass('hidden');
                        }

                    });
                }
                else {
                    $('.verify_preloader').addClass('hidden');

                    $('#verifySagaInvoiceDetails').addClass('hidden');

                    $('#exportInvoiceToSaga').removeClass('hidden');
                }
            } else {
                $('.addUserError').removeClass('hidden');
                 $('.verify_preloader').addClass('hidden');
            }
              
            }).error(function(xhr, status, error) {
               $('.addUserError').removeClass('hidden');
                $('.verify_preloader').addClass('hidden');
            })

        };


        if($(this).attr('id') == 'exportInvoiceToSaga') { 

            $.ajax({
                url: thisUrl,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    // Înainte de a face request-ul AJAX, afișăm preloader-ul și ascundem eventuala eroare
                    $('.verify_preloader').removeClass('hidden');
                },
                success: function(response) {
                    $('.verify_preloader').addClass('hidden');

                    if(response.status == 'OK') {
                        $('.invoiceImported').removeClass('hidden');
                        $('#exportInvoiceToSaga').addClass('hidden');
                    } else {
                        $('.addUserError').removeClass('hidden');
                    }
                },
                error: function(xhr, status, error) {
                   $('.addUserError').removeClass('hidden');
                    $('.verify_preloader').addClass('hidden');
                }
            });
                }

            
    })



window.sendDetailsToSaga = function(url, postData) {
    // Adaugă postData într-o variabilă json


    if(postData == undefined) {
        type = 'GET';
        data = '';
    } else 
    {
        type = 'POST';
        data = {"json": postData}
    }

    $.ajax({
        url: url,
        type: type,
        dataType: 'json',
        data:  data,
        beforeSend: function() {
            // Înainte de a face request-ul AJAX, afișăm preloader-ul și ascundem eventuala eroare
            $('.verify_preloader').removeClass('hidden');
            $('.verifyWrapper').addClass('hidden');
        },
        success: function(response) {
            $('.verify_preloader').addClass('hidden');

            obj = JSON.parse(response);

            var sendTable = $('.sendResult').DataTable({
                     "data" : obj.message,
                
                    pageLength: 100,
                        "paging":   true,
                        "ordering": true,
                        "searching": true,
                    rowId: 'category_slug',
                      
                    responsive: true,
                    order: [1],
                    "columns": [ 
                        
                        { 
                            "data": "cod"
                        }
                        ,
                        { 
                            "data": "status",
                            "render" : function(data, type, row) {
                                var statusLabel = getStatus(data, 'send' );
                                console.log(data);

                                return statusLabel
                              } 
                        },
                        { 
                            "data": "error"
                        },
                    ],
                    "initComplete": function(settings, json) {

                        $('.verify_preloader').addClass('hidden');
                        $('.sendWrapper').removeClass('hidden');
                    }

                });
        },
        error: function(xhr, status, error) {
           $('.addUserError').removeClass('hidden');
            $('.verify_preloader').addClass('hidden');
        }
    });
}


function getStatus(data, type='verify') {

    if(data == "OK") 
    {
        statusClass = '';
        statusIcon = 'check_circle';
        statusLabel =  type == 'verify' ?'Found' : 'Imported';
    }else {
        statusClass = 'bg-red';
        statusIcon = 'error';
        statusLabel = 'Not'
    }

     statusLabel = '<div class="info-box info-box-xs ' + statusClass + ' small-width hover-expand-effect">'+
                    '<div class="icon">'+ 
                        '<i class="material-icons">'+ statusIcon +'</i>'+
                    '</div>'+
                    '<div class="content">'+
                        '<div >'+ statusLabel +'</div>'+
                    '</div>'+
                '</div>';

    return statusLabel
}

    
    
});