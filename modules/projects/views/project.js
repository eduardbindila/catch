

$(document).ready(function() {

    $("[data-toggle=popover]").popover();

    Invoice = new Invoices();

    var quoteStatus = [];

    var quoteFlags = [];

    var profitLow = [];

    var hideDiscountDetails = undefined;

    $('.navbar-nav').append('<li class="dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><span>GO TO This Project</span><span class="caret"></span></a><ul class="dropdown-menu quote-list"></ul></li>');

    $.ajax({
        url: "/ajax/getClients",
        type: "post",
        dataType: "json",
    }).done(function(json){
       $.each(json, function (i, item) {
            $('.clientTypesSelector').append($('<option>', { 
                value: item.id,
                text : item.name
            }));
        });


    }).error(function(xhr, status, error) {
        $('.clientTypesSelectorError').removeClass('hidden');
    })

    var quoteOptions = [];



    $('.editQuoteTrigger').on('click', function(){
            var quoteId = $(this).attr('data-quote');
            $('#quoteNumberEdit').text(quoteId);
//console.log(quoteOptions[quoteId]);
     

            $("#editQuote select[name=owner_id]").val(quoteOptions[quoteId]['assignee_id']);

            $("#editQuote select[name=client_id]").val(quoteOptions[quoteId]['client_id']);

            $("#editQuote input[name=name]").val(quoteOptions[quoteId]['name']);
        })

    $('#editQuote').on('submit', function(e){
        e.preventDefault();

       var data = $(this).serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

       thisQuoteId = $('#quoteNumberEdit').text();

       

       clientId = data.client_id;

       quoteName = data.name;

       assigneeId = data.owner_id;

       var updatedOption = quoteOptions[thisQuoteId]

       updatedOption['client_id'] = data.client_id;

       updatedOption['name'] = data.name;

       updatedOption['assignee_id'] = data.owner_id;

   

       updateQuote(thisQuoteId, updatedOption);

       location.reload();

    })



    $('.nextStep').on('click', function(e){
        
         var quoteId = $(this).attr('data-quote');

         var thisIndex = $(this).closest('[data-index]').attr('data-index');

         var thisClientId = $(this).attr('data-client');

         var thisClientEmail = $(this).attr('data-email');

         var afterApprove = $(this).attr('data-afterApprove');

         $('#clientEmail').val(thisClientEmail);

         //console.log(quoteList);

          if(quoteList[thisIndex].id = quoteId) {
                quote = quoteList[thisIndex];
            } else {
                quote = 0;
            }
        

         if(thisClientId > 0) {
            $.ajax({
                url: "/ajax/changeQuoteStatus",
                type: "post",
                dataType: "json",
                data: {'quote': JSON.stringify(quote), 'quote_id': quoteId, 'quote_status': quoteStatus[quoteId], 'profit_low': getProfitLow(profitLow[quoteId]), 'afterApprove': afterApprove, 'jump_status': 0 }
           }).success(function(json){

                if(json == 3) {
                    
                    callQuoteSend(quoteId, thisClientId, 'quote')
                } else {
                   
                    location.reload();
                }


            }).error(function(xhr, status, error) {
               $('.updateError').removeClass('hidden');
            })
         }
         else {
            $(this).parents('.card').find('.noClientError').removeClass('hidden');
         }
        

    })

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = dd + '/' + mm  + '/' + yyyy;
        var table = [];

        var selectedItems = [];

        var QuotePricing = [];

        var queryDict = {};

        var projectID = $('#project').attr('data-project');

        location.search.substr(1).split("&").forEach(function(item) {queryDict[item.split("=")[0]] = item.split("=")[1]})

        $.fn.dataTable.ext.errMode = 'none';

        quoteList.forEach(function(val, index){

            $('.quote-list').append('<li><a href="#linkQuote-'+quoteList[index].id+'">Quote '+quoteList[index].id+'</a></li>')

            QuotePricing[index] = [];

            var buttonsArray = [];

            var clientButtons = [
                        // {
                        //     extend: 'selected',
                        //     className: 'acceptSelected btn btn-lg btn-success waves-effect',
                        //     text: 'Accept Selected Items',
                        //     action: function ( e, dt, button, config ) {
                        //         var selection = dt.rows( { selected: true } ).data();
                        //         var i;
                        //         for ( i = 0; i < selection.length; i++) {
                        //             selectedItems.push(selection[i].id);
                        //         }

                        //         $.ajax({
                        //             url: "/ajax/updateItems",
                        //             type: "post",
                        //             dataType: "json",
                        //             data: {'products': selectedItems, 'quote_id': val['id'], 'quote_item_status': 2, 'rejection_reason': 0}
                        //        }).success(function(json){
                        //            location.reload();

                        //         }).error(function(xhr, status, error) {
                        //            //$('.addNewTemporaryProduct').removeClass('hidden');
                        //         })
                        //     }
                        // },
                        
                        // {
                        //     extend: 'selected',
                        //     className: 'rejectSelected btn btn-lg btn-danger waves-effect',
                        //     text: 'Reject Selected Items',
                        //     action: function ( e, dt, button, config ) {

                        //         var selection = dt.rows( { selected: true } ).data();
                        //         var i;
                        //         for ( i = 0; i < selection.length; i++) {
                        //             selectedItems.push(selection[i].id);
                        //         }

                        //         //console.log(selection);

                        //     $.ajax({
                        //             url: "/ajax/getRejectionReason",
                        //             type: "post",
                        //             dataType: "json",
                        //        }).success(function(json){
                        //            $.each(json, function(key, value) {   
                        //                  $('.rejectionReason')
                        //                      .append($("<option></option>")
                        //                                 .attr("value",value['id'])
                        //                                 .text(value['name'])); 
                        //             });

                        //             $('#reject-modal').modal('show');


                        //            $('#rejectionForm').on('submit', function(e){
                        //                 e.preventDefault();

                        //                 var data = $(this).serializeArray().reduce(function(obj, item) {
                        //                     obj[item.name] = item.value;
                        //                     return obj;
                        //                 }, {});

                                              
                        //                 $.ajax({
                        //                     url: "/ajax/updateItems",
                        //                     type: "post",
                        //                     dataType: "json",
                        //                     data: {'products': selectedItems, 'quote_id': val['id'], 'quote_item_status': 3, 'rejection_reason': data.rejectionReason}
                        //                }).success(function(json){
                        //                    location.reload();

                        //                 }).error(function(xhr, status, error) {
                        //                    //$('.addNewTemporaryProduct').removeClass('hidden');
                        //                 })
                        //             })


                        //         }).error(function(xhr, status, error) {
                        //            //$('.addNewTemporaryProduct').removeClass('hidden');
                        //         })
                               
                              

                        //      }
                        // },
                    ]

                    var salesButtons = [
                    
                        {
                            extend: 'excel',
                            className: 'btn btn-lg btn-primary waves-effect',
                            exportOptions: {
                              stripHtml: true,
                              orthogonal: null,
                              columns: [ 1, 4, 5, 6, 7, 13, 14, 15, 18, 19, 20 ]
                            }, footer: true
                        },
                        {
                            extend: 'selected',
                            className: 'duplicateQuote btn btn-lg btn-success waves-effect',
                            text: 'Duplicate Quote',
                            action: function ( e, dt, button, config ) {
                                var selection = dt.rows( { selected: true } ).data();
                                var i;
                                for ( i = 0; i < selection.length; i++) {
                                    // var thisProduct = {
                                    //     'id': selection[i].quote_item_id,
                                    //     // 'temporary_product': selection[i].temporary_product 
                                    // }
                                    //console.log(selection[i],'ds');
                                    selectedItems.push(selection[i].quote_item_id);
                                }
                                selectedItems['duplicate'] = 1;
                                //console.log(projectID);

                                createQuote(projectID, selectedItems)

                            }
                        },
                        {
                            text: 'Hide Discount',
                            className: 'hideTrigger btn btn-lg btn-primary waves-effect',
                            action: function ( e, dt, node, config ) {
                      
                                hideDiscountDetails = !!+val['hide_discount'];
                                hideDiscountDetails = !hideDiscountDetails;

                                if(hideDiscountDetails == true) {
                                    $('.hideTrigger span').text('Show Discount');
                                } 
                                else
                                 {
                                    $('.hideTrigger span').text('Hide Discount');
                                }

                                //console.log(hideDiscountDetails);

                                $.ajax({
                                    url: "/ajax/updateQuote",
                                    type: "post",
                                    dataType: "json",
                                    data: {'quote_id': val['id'], 'hide_discount': hideDiscountDetails}
                               }).success(function(json){
                                   $('.updateError').addClass('hidden');
                                   location.reload();
                                }).error(function(xhr, status, error) {
                                   $('.updateError').removeClass('hidden');
                                })

                            }
                        },
                        {
                            extend: 'selected',
                            className: 'createPackage btn btn-lg btn-success waves-effect',
                            text: 'Create Package',
                            action: function ( e, dt, button, config ) {
                                selectedItems = [];
                                var selection = dt.rows( { selected: true } ).data();
                                var i;
                                for ( i = 0; i < selection.length; i++) {
                                    // var thisProduct = {
                                    //     'id': selection[i].quote_item_id,
                                    //     // 'temporary_product': selection[i].temporary_product 
                                    // }
                                    //console.log(selection[i],'ds');
                                    selectedItems.push(selection[i].quote_item_id);
                                }
                                

                                console.log(val['id']);

                                //createQuote(projectID, selectedItems)

                                console.log(selectedItems)

                                var packageDetail = {
                                    'quote_id' : val['id'],
                                    'quote_items' : selectedItems
                                }


                                $.ajax({
                                    url: "/ajax/createPackage",
                                    type: "post",
                                    dataType: "json",
                                    data: packageDetail
                                }).success(function(json){
                                   $('.updateError').addClass('hidden');

                                   packageDetail['package_id'] = json;

                                   console.log(json, packageDetail);  

                                   addItemsToPackage(packageDetail); 

                                   $('.viewPackages[data-quote='+val['id']+']').click();                                

                                }).error(function(xhr, status, error) {
                                   $('.updateError').removeClass('hidden');
                                })

                                console.log(packageDetail);

                            }
                        },

                    ]

                    buttonsArray = [
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
                            className: 'deleteSelected btn btn-lg btn-danger waves-effect',
                            text: 'Delete Selected',
                            action: function ( e, dt, button, config ) {

                                var selection = dt.rows( { selected: true } ).data();
                                var i;
                            
                                for ( i = 0; i < selection.length; i++) {
                                    selectedItems.push(selection[i].quote_item_id);
                                }
                             

                                $.ajax({
                                    url: "/ajax/removeItemsFromQuote",
                                    type: "post",
                                    dataType: "json",
                                    data: {'quote_item_id': selectedItems, 'quote_id': val['id']}
                               }).success(function(json){
                                   location.reload();

                                }).error(function(xhr, status, error) {
                                   //$('.addNewTemporaryProduct').removeClass('hidden');
                                })
                            }
                        },
                         {
                            text: 'Get Delivery Date',
                            className: 'deliveryDate btn btn-lg btn-warning waves-effect',
                            action: function ( e, dt, node, config ) {
                                //console.log(e,node,config)

                                var thisButton = $(e.currentTarget);

                                thisButton.append('<div class="loadingDeliveryData" style="float:left"><div class="preloader pl-size-vxs"> <div class="spinner-layer pl-white"> <div class="circle-clipper left"> <div class="circle"></div> </div> <div class="circle-clipper right"> <div class="circle"></div> </div> </div></div>');

                                //console.log(thisButton);

                                   var indexes = dt.rows().indexes().filter( 
                                        function ( value, index ) {    
                                            //console.log(dt.row(value).data()['saga_quantity'] < dt.row(value).data()['quantity']);
                                            return 'syl' === dt.row(value).data()['manufacturer'].toLowerCase() && dt.row(value).data()['saga_quantity'] < dt.row(value).data()['quantity'];
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

                                    //console.log(sylvaniaProducts);


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
                                            var thisElement = $('[data-id="' + e.id + '"][data-quantity="'+ e.quantity +'"]');
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
                        {
                            extend: 'pdf',
                            className: 'btn btn-lg btn-primary waves-effect',
                            filename: 'offer-' + val['id'] + '-' + today,
                            exportOptions: {
                              stripHtml: true,
                              orthogonal: null,
                               columns: [ 1, 2, 3, 4, 5, 6, 7, 13, 14, 15, 18, 19, 20]
                            },
                            customize: function (doc) {

                                doc.pageOrientation = 'landscape';

                                doc.pageSize = "A4";

                                doc.pageMargins = [ 15, 15, 15, 15 ]

                                doc.content[0] = [
                                                               
                                {
                                    image: "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAeAB4AAD/4RDmRXhpZgAATU0AKgAAAAgABAE7AAIAAAAJAAAISodpAAQAAAABAAAIVJydAAEAAAASAAAQzOocAAcAAAgMAAAAPgAAAAAc6gAAAAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGljYXRjaCA2AAAABZADAAIAAAAUAAAQopAEAAIAAAAUAAAQtpKRAAIAAAADNjMAAJKSAAIAAAADNjMAAOocAAcAAAgMAAAIlgAAAAAc6gAAAAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADIwMjA6MDE6MTMgMTY6NTM6NTkAMjAyMDowMToxMyAxNjo1Mzo1OQAAAGkAYwBhAHQAYwBoACAANgAAAP/hCxtodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvADw/eHBhY2tldCBiZWdpbj0n77u/JyBpZD0nVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkJz8+DQo8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIj48cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPjxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSJ1dWlkOmZhZjViZGQ1LWJhM2QtMTFkYS1hZDMxLWQzM2Q3NTE4MmYxYiIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIi8+PHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9InV1aWQ6ZmFmNWJkZDUtYmEzZC0xMWRhLWFkMzEtZDMzZDc1MTgyZjFiIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iPjx4bXA6Q3JlYXRlRGF0ZT4yMDIwLTAxLTEzVDE2OjUzOjU5LjYzMzwveG1wOkNyZWF0ZURhdGU+PC9yZGY6RGVzY3JpcHRpb24+PHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9InV1aWQ6ZmFmNWJkZDUtYmEzZC0xMWRhLWFkMzEtZDMzZDc1MTgyZjFiIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iPjxkYzpjcmVhdG9yPjxyZGY6U2VxIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+PHJkZjpsaT5pY2F0Y2ggNjwvcmRmOmxpPjwvcmRmOlNlcT4NCgkJCTwvZGM6Y3JlYXRvcj48L3JkZjpEZXNjcmlwdGlvbj48L3JkZjpSREY+PC94OnhtcG1ldGE+DQogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgIDw/eHBhY2tldCBlbmQ9J3cnPz7/2wBDAAcFBQYFBAcGBQYIBwcIChELCgkJChUPEAwRGBUaGRgVGBcbHichGx0lHRcYIi4iJSgpKywrGiAvMy8qMicqKyr/2wBDAQcICAoJChQLCxQqHBgcKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKir/wAARCABVBU4DASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD6RooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKgvL620+3M97OkEYONznFNJvRCbS1ZPRVPT9XsNUVjp91HPt+8FPI/A81m+JfFVv4dSNWiM9xKMrGG24HqTVKnKUuVLUlzio8zehvUV59/wtBv8AoED/AMCP/saP+FoN/wBAgf8AgR/9jW31Wt2/Ix+tUe56DRXn3/C0G/6BI/8AAj/7Gu9tpvtFrFNjb5iB8ZzjIzWdSjOn8SNKdWFT4WSUUUVkahRRRQAUUUUAFFVtSvk03TLi9lVnS3jMjKvUgVieHfGtn4kvpLW1tp4mSPeTJjBGQOx96V1sOztc6SiiimIKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACuZ8a+HrnXbOA2cqiSAk+W7YDA47+vFdNWJ4wJHhG/I4Owf+hCtaLaqKxnVScHcw/BfhO+0nUnvr50TCFBGj7s59ccVkfEr/AJD9v/17j/0I1t/DRi2iXW4k/wCkd/8AdFYnxK/5D9v/ANe4/wDQjXdTcniveOGaisN7p13h3SNNm8N2Ekun2ru0ClmaFSSceuK0v7E0r/oGWf8A34X/AAqv4ekSHwlYyysERLZWZj0AA5Ned654+1XWNR+x6AZIIWbZGIx+8k989voK8+rUcZPU9ClTUorQ9M/sTSv+gZZ/9+F/wq6qhFCqAqgYAA4ArzG08PePYEF1HqEgkxnyZbosT7YOVqhrfjnxFHJFbSF9Pu4AVnVVGHPY4IOP5Vk6j6mqpK/unr1cN8R9d1LRfsH9mXTW/mb9+0A5xjHU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",
                                    width: 805,
                                    style: 'logo' 
                                },

                                    {
                                      columns: [
                                        {
                                            width: '80%',
                                            style: "bold",
                                            text: '\nICATCH DESIGN SRL\nCommercial Offer No. ' + val['id'] + ' / ' +val['offer_date'].split('-').reverse().join('-')+'\nGenerated Date: '+today,
                                            
                                        },
                                        {
                                         text: "Company: " + clientName[val['id']] + " \nIn attention to: " + clientPoi[val['id']] + "\nProject Name: " + projectName[val['id']] + "",
                                        style: 'antent'
                                        }
                                      ],
                                   
                                    }
                                ]
                                //console.log(doc);
                                doc.styles =  {
                                    header: {
                                        fontSize: 15,
                                        bold: true
                                    },
                                    offerPrice: {
                                        fontSize: 13,
                                        bold: true,
                                        fillColor: '#dbdbdb',
                                        margin: [7,7,7,7],
                                    },
                                    subheader: {
                                        fontSize: 15,
                                        bold: true
                                    },
                                    bold: {
                                        
                                        bold: true
                                    },
                                    quote: {
                                        italics: true
                                    },
                                    link: {
                                        //color: 'blue',
                                        alignment: 'center',
                                        margin: [10,10,10,10],
                                    },
                                     logo: {
                                        //color: 'blue',
                                        alignment: 'left',
                                        margin: [0, 0, 0, 0],
                                    },
                                    small: {
                                        fontSize: 8
                                    },
                                    tableHeader: {
                                        fillColor: '#dbdbdb',
                                        margin: [7,7,7,7],
                                        bold: true,
                                        alignment: 'center',
                                        fontSize: 8
                                    
                                    },
                                    tableFooter: {
                                        fillColor: '#dbdbdb',
                                        margin: [7,7,7,7],
                                        bold: true,
                                        fontSize: 8
                                    },
                                    tableBodyEven: {
                                        alignment: 'center',
                                        fillColor: '#eeeeee',
                                        margin: [10,10,10,10],
                                        fontSize: 8
                                    },
                                    tableBodyOdd: {
                                        alignment: 'center',
                                        margin: [10,10,10,10],
                                        fontSize: 8
                                    },
                                    list: {
                                        margin: [0,10,0,20]
                                    },
                                    antent: {
                                        alignment: 'right',
                                        margin: [0,0, 7, 5],
                                    }
                                }

                                doc.content[1].table.dontBreakRows = true; 


                                var lastRow = doc.content[1].table.body.length-1;
                                //console.log(doc.content[1].table.body);
                                var priceBeforeExtraDiscount = 0;
                                var priceAfterExtraDiscount = 0;
                                for (var row = 1; row < lastRow; row++) {

                                    var productId = doc.content[1].table.body[row][3];

                                    imageBase = doc.content[1].table.body[row][1].text;

                                    if(imageBase !== 'null') {
                                        doc.content[1].table.body[row][1] = {image: imageBase, fit: [50, 50], align: 'center', valign: 'center'};
                                    }

                                    if(doc.content[1].table.body[row][4].text == "null") {
                                        doc.content[1].table.body[row][4].text  = "n/a"
                                    }

                                    if(doc.content[1].table.body[row][0].text == "null") {
                                        doc.content[1].table.body[row][0].text  = "n/a"
                                    }

                                    if(doc.content[1].table.body[row][5].text == "null") {
                                        doc.content[1].table.body[row][5].text  = "n/a"
                                    }

                                    if(doc.content[1].table.body[row][12].text == "0") {
                                        var linkID = 'https://www.sylvania-lighting.com/product/en-int/products/'+productId.text+'/';
                                        doc.content[1].table.body[row][2] = {text: "Click", link: linkID, style: 'link'};
                                    } else {
                                        doc.content[1].table.body[row][2] = {text: "n/a", style: 'link'};
                                    }

                                    priceBeforeExtraDiscount = priceBeforeExtraDiscount + parseFloat(doc.content[1].table.body[row][11].text);
                                    priceAfterExtraDiscount = parseFloat(doc.content[1].table.body[lastRow][11].text);
                                    
                                    //doc.content[1].table.body[lastRow][11] = priceBeforeExtraDiscount;

                                    doc.content[1].table.body[row][12] = {};

                                    doc.content[1].table.body[0][12] = {};

                                    doc.content[1].table.body[lastRow][12] = {};

                                    if(val['hide_discount'] == 1) {
                                         doc.content[1].table.body[row][8] = {};

                                        doc.content[1].table.body[0][8] = {};

                                        doc.content[1].table.body[lastRow][8] = {};

                                        doc.content[1].table.body[row][7] = {};

                                        doc.content[1].table.body[0][7] = {};

                                        doc.content[1].table.body[lastRow][7] = {};
                                    }

                                    


                                    //console.log(quoteList[index]['extra_discount']);
                                }

                                doc.content[1].table.body.pop();



                                var extraDiscount = parseFloat(quoteList[index]['extra_discount']);

                                var extraDiscountArray = ["",""];

                                var priceBeforeArray = ["",""];

                                if(extraDiscount) {
                                    var discountValue = parseFloat(quoteList[index]['extra_discount'])/100*priceBeforeExtraDiscount;
                                    extraDiscountArray = extraDiscount ? [{text: 'Extra Discount ('+parseFloat(quoteList[index]['extra_discount'])+'%):', style: 'bold'}, '-'+ discountValue.toFixed(2)] : ['',''];
                                    priceBeforeArray = [{text: 'Total Price:', style: 'bold'}, priceBeforeExtraDiscount];
                                }

                                

                                doc.content[1].table.layout = 'lightHorizontalLines';
                                doc.content[2] = [
                                {
                                    canvas: [
                                        {
                                            type: 'line',
                                            x1: 0,
                                            y1: 0,
                                            x2: 807,
                                            y2: 0,
                                            lineWidth: 0.5
                                        }
                                    ] 
                                },
                                {
                                      columns: [
                                        {
                                            width: '*',
                                            style: "bold",
                                            text: '',
                                            
                                        },
                                        { 
                                            width: 'auto',
                                            style: "antent",
                                            table: {
                                            body: [
                                                priceBeforeArray,
                                                extraDiscountArray,
                                                [{text: 'Final Offer Price:', style: 'offerPrice'}, {text: priceAfterExtraDiscount, style: 'offerPrice'}]
                                            ]
                                            },
                                            layout: 'noBorders'
                                        }
                                      ],
                                   
                                    },
                                
                                ];

                                doc.content[3] = [
                                    {
                                        ol: [
                                            'The prices are in EUR with Bucharest DDU Delivery',
                                            'Prices are without VAT and Green Tax',
                                            'Delivery time / confirmed on firm order',
                                            'Payment method and term: under contract',
                                            'Offer valid 30 days'
                                        ],
                                        style: 'list'
                                    },
                                    {
                                        text: assigneeName[val['id']], 
                                        style: 'bold'
                                    },
                                    {
                                        text: assigneeRole[val['id']], 
                                    },
                                    {
                                        text: "E-mail:" +assigneeEmail[val['id']],
                                        link: 'mailto:'+ assigneeEmail[val['id']],  
                                    },
                                    {
                                        text: "Mobile:" +assigneePhone[val['id']], 
                                    },

                                    'București, 077190, sector 1\n',
                                    'Str. Bd. Poligrafiei, nr. 75, etaj 3\n',
                                ];
                                

                                
                            }, footer: true
                        },
                        
                    ]

                    if(iss) {
                        buttonsArray.push(salesButtons);
                    }
                    else if(isc){
                        
                        // if(quoteList[index].quote_status == 4) {
                        //     buttonsArray = [];
                        // } else {
                        //      buttonsArray.push(clientButtons)
                        // }

                         buttonsArray.push(clientButtons)
                       
                    }

            quoteStatus[val['id']] = quoteList[index].quote_status;

            profitLow[val['id']] = { 'extra_discount':"", "rows":[]};

            quoteFlags[val['id']] = {
                    "afterApprove" : quoteList[index].afterApprove,
                    "client_approved" : quoteList[index].client_approved,
                    "offer_sent" : quoteList[index].offer_sent,
                    "offer_rejected" : quoteList[index].offer_rejected,
                    "rejected_reason" : quoteList[index].rejected_reason,
                    "contract_sent" : quoteList[index].contract_sent,
                    "invoice_sent" : quoteList[index].invoice_sent,
                    "offer_opened" : quoteList[index].offer_opened
                };

            //console.log(quoteList[index].quote_products.data);

             table[index] = $('#quote-'+val['id']).DataTable({
                footerCallback: function ( row, data, start, end, display ) {
                    var api = this.api();
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                                 
                    };



                    var totalArray = {};
                    api.columns().every(function () {
                        var elem = $(this);
                        var columnDetails = this.context[0].aoColumns[this.index()];

                        var columnDataName = columnDetails.mData;

                        //console.log(this.index, columnDataName);

                         if((this.index() > 10) && (this.index() !== 14 && this.index() !== 15)) {

                            var pageTotal = 0

                            if(columnDataName == 'initial_price') {

                                var totalInitialPrice = 0;

                                data.forEach(function(row){
                                    totalInitialPrice = totalInitialPrice + Number(row.initial_price) * Number(row.quantity); 
                                })

                                pageTotal = totalInitialPrice.toFixed(2);
                            }

                            if(columnDataName == 'quantity') {

                                var totalQuantity = 0;

                                data.forEach(function(row){
                                    totalQuantity = totalQuantity + Number(row.quantity); 
                                })

                                pageTotal = totalQuantity;
                            }

                             if(columnDataName == 'reserved_stock') {

                                var totalReservedStock = 0;

                                data.forEach(function(row){
                                    totalReservedStock = totalReservedStock + Number(row.reserved_stock); 
                                })

                                pageTotal = totalReservedStock;
                            }

                            if(columnDataName == 'min_price') {

                                var totalMinPrice = 0;

                                data.forEach(function(row){
                                    totalMinPrice = totalMinPrice + Number(row.min_price) * Number(row.quantity); 
                                })

                                pageTotal = totalMinPrice.toFixed(2);
                            }

                            if(columnDataName == 'list_price') {

                                var totalListPrice = 0;

                                data.forEach(function(row){
                                    totalListPrice = totalListPrice + Number(row.list_price) * Number(row.quantity); 
                                })

                                pageTotal = totalListPrice.toFixed(2);
                            }
                            if(columnDataName == 'final_price') {
                               

                                var totalFinalPrice = 0;

                                data.forEach(function(row){
                                    totalFinalPrice = totalFinalPrice + Number(row.final_price); 
                                })

                                totalFinalPrice = totalFinalPrice

                                if((data.length > 0) && (data[0].extra_discount > 0)) {
                                    pageTotal = totalFinalPrice - (totalFinalPrice * Number(data[0].extra_discount)/100);
                                    pageTotal = pageTotal;
                                } else {
                                    pageTotal = totalFinalPrice.toFixed(2);
                                }
                            }

                            if(columnDataName == 'profit') {
                                var totalInitialPrice = 0;
                                var totalFinalPrice = 0;

                                data.forEach(function(row){
                                    totalInitialPrice = totalInitialPrice + Number(row.initial_price) * Number(row.quantity); 
                                    totalFinalPrice = totalFinalPrice + Number(row.final_price); 
                                })

                                if((data.length > 0) && (data[0].extra_discount > 0)) {
                                    totalFinalPrice = totalFinalPrice - (totalFinalPrice * Number(data[0].extra_discount)/100);
                                } 



                                pageTotal = totalFinalPrice - totalInitialPrice;

                                pageTotal = pageTotal.toFixed(2);
    
                                
                            }

                            if(columnDataName == 'profit_percent') {

                                var totalInitialPrice = 0;
                                var totalFinalPrice = 0;
                                var totalProfit = 0;

                                data.forEach(function(row){
                                    totalInitialPrice = totalInitialPrice + Number(row.initial_price) * Number(row.quantity); 
                                    totalFinalPrice = totalFinalPrice + Number(row.final_price); 
                                })

                                if((data.length > 0) && (data[0].extra_discount > 0)) {
                                    totalFinalPrice = totalFinalPrice - (totalFinalPrice * Number(data[0].extra_discount)/100);
                                } 



                                totalProfit = totalFinalPrice - totalInitialPrice;

                                pageTotal = (totalProfit * 100 / totalFinalPrice).toFixed(2);

                                // if(pageTotal < 30){
                                //     $(this.footer()).addClass('danger');
                                //     profitLow[val['id']]['quote'] = 1;
                                // }
                                // else {
                                //     $(this.footer()).removeClass('danger');
                                //     profitLow[val['id']]['quote'] = 0;
                                // }

                                
                            }
                            

                            if((data.length > 0) && (data[0].extra_discount > 0)){
                                    $(this.footer()).addClass('danger');
                                     profitLow[val['id']]['extra_discount'] = 1;
                                }
                                else {
                                    $(this.footer()).removeClass('danger');
                                     profitLow[val['id']]['extra_discount'] = 0;
                                }

                            //pageTotal = pageTotal.toFixed(2);


                            $(this.footer()).html(pageTotal);

                            totalArray[columnDataName] = pageTotal;
                         }
                        
                    });

                   

                    totalArray['assignee_id'] = quoteList[index]['assignee_id']; 
                    totalArray['client_id'] = quoteList[index]['client_id']; 

                    totalArray['name'] = quoteList[index]['name']; 

                    // totalArray['order_stock_status'] = !(totalArray['reserved_stock'] < totalArray['quantity']); 

                    updateQuote(val['id'], totalArray);

                    quoteOptions[val['id']] = totalArray;

                    //console.log(quoteOptions);


                },
                "rowCallback": function( row, data) {

                  if ( data['profit_percent'] < 30 )
                  {
                    $('td', row).addClass('danger');
                    //console.log(data);
                    profitLow[val['id']]['rows'][data['quote_item_id']] = 1;

                  } else {
                   
                    $('td', row).removeClass('danger');
                    //console.log('no-danger');
                    profitLow[val['id']]['rows'][data['quote_item_id']] = 0;
                  }

                  //console.log(profitLow);

                  
                },
                data: quoteList[index].quote_products.data,
                pageLength: 5000,
                    "paging":   false,
                    "ordering": true,
                    "searching": true,
                dom: 'Bfrtip',
                "scrollX": true,
                order: [[ 1, 'asc' ]],
                buttons: buttonsArray,
                // fixedColumns:   {
                //     leftColumns: 2
                // },
                 language : {
                    //sLoadingRecords : '<span style="width:100%;"><img src="http://www.snacklocal.com/images/ajaxload.gif"></span>'
                },   
                responsive: true,
                "columns": [
                { 
                    "data": null, 
                    defaultContent: '' 
                },
                { 
                    "data": "criteria",

                },
                { 
                    "data": "product_image",
                    className: "product_image",
                    "render" : function(data, type, row) {
                            return '<img src="'+data+'" class="table-image" />'
                      } 

                },
                { 
                    "data": "id",
                    className: "product_info",
                    "render" : function(data, type, row, meta) {
                        //console.log(index);

                        if(parseInt(row.saga_quantity) > parseInt(row.quantity)) {
                            stockIcon = 'check_circle';
                            messageTitle = 'Local Stock';
                            messageContent = row.quantity + ' pieces available in local stock';
                            colorClass = 'col-green';

                        } else if (row.manufacturer.toLowerCase() == 'syl') {
                            stockIcon = 'flight';
                            messageTitle = 'Remote Stock';
                            colorClass = 'col-blue';
                            messageContent = '';

                        } else {
                            stockIcon = 'schedule';
                            messageTitle = 'Stock info not Available';
                            messageContent = '';
                            colorClass = '';
                        }

                            if(row.manufacturer.toLowerCase() !== 'syl') {
                                html = '<button class="btn btn-xs btn-link waves-effect editQuoteItem" data-index="'+index+'" data-toggle="modal" data-target="#editItem-modal" data-quote="'+val['id']+'" data-quoteItem="'+ row.quote_item_id +'" data-row="'+ meta.row +'"><i class="material-icons">mode_edit</i></button>'
                            }
                            else {
                                html = '<a class="btn btn-xs btn-link" href="https://www.sylvania-lighting.com/product/en-int/products/'+data+'">'+
                                '<i class="material-icons">link</i></a>'+
                                '<button class="btn btn-xs btn-link waves-effect editQuoteItem" data-index="'+index+'" data-toggle="modal"'+ 
                                    'data-target="#editItem-modal" data-quote="'+val['id']+'" data-quoteItem="'+ row.quote_item_id +'" data-row="'+ meta.row +'">'+ 
                                    '<i class="material-icons">mode_edit</i></button>';
                            }

                            html = html +'<button class="btn btn-xs btn-link waves-effect"' + 
                                    ' data-trigger="focus" data-container="body" data-toggle="popover" data-placement="right" title="'+ messageTitle + '" data-content="'+ messageContent +'">'+ 
                                    '<i class="material-icons '+ colorClass +'">' + stockIcon + '</i></button><span class="promiseDate" data-id="'+ row.id +'" data-quantity="'+ row.quantity +'"></span>';



                            return html
                            
                      }

                },
                 { 
                    "data": "id",

                },
                { 
                    "data": "customer_description",
                    "visible": islh

                },
                { 
                    "data": "destination",
                    "visible": islh

                },
               
                
                     
                    { 
                        "data": "product_name",

                    },
                    { 
                        "data": "total_power_consumption__w_",
                        "visible": false
                    },
                     { 
                        "data": "colour_temperature__k_",
                        "visible": false
                    },
                     { 
                        "data": "fixture_luminous_flux__lm_",
                        "visible": false
                    },
                    { 
                        "data": "initial_price",
                        "visible": iss
                    },
                    { 
                        "data": "min_price",
                        "visible": iss
                    },
                     { 
                        "data": "list_price",
                        "visible": iss
                    },
                     
                    { 
                        "data": "discount",
                        //"visible": !(isc == true && val['hide_discount'] == 1),
                        visible: iss,
                        className: "discount-wrapper",
                        "render" : function(data, type, row, meta) {
                            // console.log(isc, val['hide_discount'], !(isc == true && val['hide_discount'] == 1));
                            //console.log(meta, row);
                            return '<div class="form-group">' + 
                                        '<div class="form-line">' + 
                                            '<input class="form-control quote-input" " name="discount"' + 
                                                ' data-type="discount"' + 
                                                ' data-index="'+index+
                                                '" data-row="'+meta.row+
                                                '" data-col="'+meta.col+
                                                '" data-item="'+row.quote_item_id+
                                                '" placeholder="Discount" value="'+row.discount+'" type="number" min=0 '+ inputDisabledForClient + ' >' + 
                                        '</div>' + 
                                    '</div>'
                          }
                    },
                    {
                        "data": "unit_price", 
                      className: "unit-price-wrapper",
                      "render" : function(data, type, row, meta) {
                        
                            return '<div class="form-group">' + 
                                        '<div class="form-line">' + 
                                            '<input class="form-control unit-price quote-input"' + 
                                            ' data-type="unitPrice" data-index="'+index+
                                            '" data-row="'+meta.row+
                                            '" data-col="'+meta.col+
                                            '" data-item="'+row.quote_item_id+
                                            '" value="'+data+'" type="number" placeholder="Unit Price"  min=0 '+ inputDisabledForClient + '>' + 
                                        '</div>' + 
                                    '</div>'
                      }
                    },

                    {
                      "data": "profit",
                      "visible": iss,
                      "render" : function(data, type, row, meta) {
                                        
                            return '<span class="profit" data-row="'+meta.row+'" data-col="'+meta.col+'" data-type="profit">'+data+'</span>';
                            
                      }
                    },
                    {
                      "data": "profit_percent",
                      "visible": iss,
                      "render" : function(data, type, row, meta) {
                    
                            return '<span class="profit-percent" data-row="'+meta.row+'" data-col="'+meta.col+'" data-type="profitPercent">'+data+'</span>';
                            
                      }
                    },
                     { 
                        "data": "quantity",
                            "render" : function(data, type, row, meta) {
                              return '<div class="form-group">' + 
                                        '<div class="form-line">' + 
                                            '<input class="form-control quote-input"' + 
                                            ' data-type="quantity"' + 
                                            ' data-index="'+index+
                                            '" data-item="'+row.quote_item_id+
                                            '" data-row="'+meta.row+
                                            '" data-col="'+meta.col+'" name="quantity" placeholder="Quantity" value="'+row.quantity+'" type="number" min="1" step="1">' + 
                                        '</div>' + 
                                    '</div>'
                          }
                    },
                    { 
                        "data": "final_price",
                            "render" : function(data, type, row, meta) {
                            QuotePricing[index][meta.row] = new PriceDetails(
                                row.discount, row.quantity, row.initial_price, row.min_price, row.list_price, row.unit_price, row.profit, row.profit_percent, row.final_price
                            );

                                if(iss)
                                    return '<span class="final-price" data-row="'+meta.row+'" data-col="'+meta.col+'" data-type="finalPrice">' + 
                                                '<a href="#" data-toggle="modal" data-target="#lastPrices"' + 
                                                ' data-productName="'+row.product_name+
                                                '"  data-client="'+clientId+
                                                '" data-product="'+row.id+
                                                '" class="lastPricesTrigger">'+data+
                                                '</a>' + 
                                            '</span>';
                                else
                                    return '<span class="final-price" data-row="'+meta.row+'" data-col="'+meta.col+'" data-type="finalPrice">'+data +'</span>';
                          }
                    },
                     {
                        "data": "reserved_stock",
                        "visible": isl,
                        "render" : function(data, type, row, meta) {
                            //console.log(index);

                            if(parseInt(row.reserved_stock) < parseInt(row.quantity)) {
                                stockIcon = 'playlist_add';
                                messageTitle = 'Waiting for products';
                                messageContent = '';
                                colorClass = 'col-blue';

                            } else  {
                                stockIcon = 'playlist_add_check';
                                messageTitle = 'Products in stock';
                                colorClass = 'col-green';

                            } 

                             
                                    html = '<span class="reserved_stock" data-item="'+row.quote_item_id+'">'+row.reserved_stock + '</span> ';
                                

                                html = html +'<button class="btn btn-xs btn-link waves-effect"' + 
                                        ' data-trigger="focus" data-container="body" data-toggle="popover" data-placement="right" title="'+ messageTitle + 
                                        '" data-content="'+ messageContent +'">'+ 
                                        '<i class="material-icons '+ colorClass +'">' + stockIcon + '</i></button><span class="promiseDate" data-id="'+ row.id +'" data-quantity="'+ row.quantity +'"></span>';



                                return html
                                
                          }
                    },
                    {
                        "data": "saga_quantity",
                         "render" : function(data, type, row, meta) {
                                //console.log(row);
                              return '<span class="stockData" data-item="'+row.quote_item_id+'"  data-product="'+row.id+'">'+row.saga_quantity + '</span> '
                          },
 
                        "visible": isl
                    },
                    { 
                        "data": "order_number",
                            "render" : function(data, type, row, meta) {
                                //console.log(row);
                              return '<div class="form-group">' + 
                                        '<div class="form-line">' + 
                                            '<input class="form-control order-input editable"' + 
                                            ' data-type="order_number"' + 
                                            ' data-index="'+index+
                                            '" data-item="'+row.quote_item_id+
                                            '" data-row="'+meta.row+
                                            '" data-col="'+meta.col+'" name="order_number" placeholder="Order Number" value="'+row.order_number+'" type="text" min="1" step="1">' + 
                                        '</div>' + 
                                    '</div>'
                          }
                    },
                    { 
                        "data": "ordered_quantity",
                            "render" : function(data, type, row, meta) {
                              return '<div class="form-group">' + 
                                        '<div class="form-line">' + 
                                            '<input class="form-control order-input editable"' + 
                                            ' data-type="ordered_quantity"' + 
                                            ' data-index="'+index+
                                            '" data-item="'+row.quote_item_id+
                                            '" data-product="'+row.id+
                                            '" data-quantity="'+row.quantity+
                                            '" data-reserved="'+row.reserved_stock+
                                            '" data-stock="'+row.saga_quantity+
                                            '" data-row="'+meta.row+
                                            '" data-col="'+meta.col+'" name="ordered_quantity" placeholder="Order Quantity" value="'+row.ordered_quantity+'" type="number" min="0" step="1">' + 
                                        '</div>' + 
                                    '</div>'
                          }
                    },
                    { 
                        "data": "order_date",
                            "render" : function(data, type, row, meta) {
                              return '<div class="form-group">' + 
                                        '<div class="form-line">' + 
                                            '<input class="form-control order-input editable"' + 
                                            ' data-type="order_date"' + 
                                            ' data-index="'+index+
                                            '" data-item="'+row.quote_item_id+
                                            '" data-row="'+meta.row+
                                            '" data-col="'+meta.col+'" name="order_date" placeholder="Order Date" value="'+row.order_date+'" type="date" min="1" step="1">' + 
                                        '</div>' + 
                                    '</div>'
                          }
                    },
                    { 
                        "data": "promise_date",
                            "render" : function(data, type, row, meta) {
                              return '<div class="form-group">' + 
                                        '<div class="form-line">' + 
                                            '<input class="form-control order-input editable"' + 
                                            ' data-type="promise_date"' + 
                                            ' data-index="'+index+
                                            '" data-item="'+row.quote_item_id+
                                            '" data-row="'+meta.row+
                                            '" data-col="'+meta.col+'" name="promise_date" placeholder="Promise Date" value="'+row.promise_date+'" type="date" min="1" step="1">' + 
                                        '</div>' + 
                                    '</div>'
                          }
                    },
                    { 
                        "data": "temporary_product",
                        "visible": false
                    },
                     { 
                        "data": "extra_discount",
                        "visible": false
                    },
                    {
                        "data": "manufacturer",
                        "visible": false
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

                    //console.log('init',  val['hide_discount']);
                        
                    if(val['hide_discount'] == 1) {
                        $('.hideTrigger span').text('Show Discount');
                    } 
                    else
                     {
                        $('.hideTrigger span').text('Hide Discount');
                    }

                },
                "drawCallback": function(settings, json) {

                    

                    if(!isa)
                        {
                            //console.log(isa,  $('.status-wrapper[data-quote="'+val["id"]+'"]').find('button'));
                            $('.status-wrapper[data-quote="'+val["id"]+'"]').find('button').prop("disabled", true);

                        }

                    if(quoteStatus[val['id']] == 4) {
                        //$('#quote-'+val['id']).find('input, textarea, button, select').prop("disabled", false);
                        $('#quote-'+val['id']).find('.status-wrapper button').prop("disabled", false);
                        $('.status-wrapper[data-quote="'+val["id"]+'"]').find('button').prop("disabled", false);
                         
                    }  

                    //console.log(quoteStatus[val['id']] != 4 && quoteStatus[val['id']] != 1);

                    // console.log(isc == true || quoteStatus[val['id']] != 4);

                    if((isc == true &&  quoteStatus[val['id']] != 4) || (quoteStatus[val['id']] != 4 && quoteStatus[val['id']] != 1)) {
                        if(!val['locked']) {
                            $('.addNewItem[data-quote='+val['id']+']').attr('disabled','disabled');
                        }
                        
                       $('#quote-'+val['id']).find('input:not(.editable), textarea, button:not(.editable), select, .deleteSelected ').attr('disabled','disabled');

                       $('#quote-'+val['id']+'_wrapper').find('.deleteSelected ').addClass('hide');
                    } 
                  },


            });

             
        })

        $('input[type="number"]').on('keypress',function(){
            v = parseInt($(this).val());
            min = parseInt($(this).attr('min'));
            max = parseInt($(this).attr('max'));

            /*if (v < min){
                $(this).val(min);
            } else */if (v > max){
                $(this).val(max);
            }
        })

        $('body').on('change', '.quote-input', function(){
            var quoteIndex = $(this).attr('data-index');
            var rowId = $(this).attr('data-row');
            QuotePricing[quoteIndex][rowId].updateItemPricing(this);

        })


         $('body').on('change', '.order-input', function(){
            var quoteIndex = $(this).attr('data-index');
            var rowId = $(this).attr('data-row');

            var quoteItemId = $(this).attr('data-item');

            var currentStock = Number($(this).attr('data-stock'));

            var currentReserve = Number($(this).attr('data-reserved'));

            var itemStock = currentStock + currentReserve;

            var quantity = Number($(this).attr('data-quantity'));

            var name = $(this).attr('name');

            var productId = $(this).attr('data-product')

            var value = $(this).val()




            var orderDetail = {
                'item_id': $(this).attr('data-item'),
                'product_id': productId,
                'name': name,
                'value': value
            };


            if(name == 'ordered_quantity') {

                var newReserve = (quantity - value);

                var newStock = 0;
                

                if(newReserve >= 0 && itemStock >= newReserve) {
                    newReserve = newReserve
                } 
                else {
                    newReserve = 0;
                }

                if(itemStock >= newReserve) {
                    newStock = itemStock - newReserve
                } else {
                    newStock = itemStock;
                }

                console.log(newStock, newReserve);
                orderDetail['reserved_stock'] = newReserve;

                orderDetail['stock'] = newStock;

                $('span.reserved_stock[data-item='+quoteItemId+']').text(newReserve)

                $('span.stockData[data-product='+productId+']').text(newStock)
            }

             $.ajax({
                url: "/ajax/updateItemOrderDetails",
                type: "post",
                dataType: "json",
                data: orderDetail
            }).success(function(json){
               $('.updateError').addClass('hidden');
               

            }).error(function(xhr, status, error) {
               $('.updateError').removeClass('hidden');
            })

        })

        $('body').on('change', '.extraDiscount', function(){
            if(!isc) {
                var quoteID = $(this).attr('data-quote');

                $.ajax({
                    url: "/ajax/updateQuote",
                    type: "post",
                    dataType: "json",
                    data: {'quote_id': quoteID, 'extra_discount': $(this).val()}
               }).success(function(json){
                   $('.updateError').addClass('hidden');
                   location.reload()
                }).error(function(xhr, status, error) {
                   $('.updateError').removeClass('hidden');
                })
            }
            
        });

        $('.addNewItem').on('click', function(){
            var quoteId = $(this).attr('data-quote');
            $('#searchButton').removeAttr('data-project');

            $('#quoteNumber').text(quoteId);
            $('#quote-id').val(quoteId);
            $('#searchButton').attr('data-quote', quoteId);

            $('.addToQuote').removeClass('hidden');
            $('.createProject').addClass('hidden');
            $('.addToProject').addClass('hidden');

            $('.projectTitle').addClass('hidden');
            $('.quoteTitle').removeClass('hidden');
        })

        $('.addNewQuote').on('click', function(){
            var quoteId = $(this).attr('data-project');
            $('#searchButton').removeAttr('data-quote');
            $('#projectNumber').text(quoteId);
            $('#project-id').val(quoteId);
            $('#searchButton').attr('data-project', quoteId);

            $('.addToProject').removeClass('hidden');
            $('.addToQuote').addClass('hidden');
            $('.createProject').addClass('hidden');

             $('.quoteTitle').addClass('hidden');
            $('.projectTitle').removeClass('hidden');

        })

         

        $('#addTemporaryProduct').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: "/ajax/addTemporaryItemsToQuote",
                type: "post",
                dataType: "json",
                data: $(this).serializeArray()
           }).success(function(json){
               location.reload();

            }).error(function(xhr, status, error) {
                $('.addNewTemporaryProduct').removeClass('hidden');
            })
        })

        $('.grantMaster').on('click', function(e){

            var quoteID = $(this).attr('data-quote');
            var isMaster = $(this).attr('data-master');

            $.ajax({
                url: "/ajax/updateMaster",
                type: "post",
                dataType: "json",
                data: {'quote_id': quoteID, 'isMaster': isMaster}
           }).success(function(json){
               $('.updateError').addClass('hidden');
               location.reload()
            }).error(function(xhr, status, error) {
               $('.updateError').removeClass('hidden');
            })
        });

        $('.clientReject').on('click', function(e){
            var quoteID = $(this).attr('data-quote');

             $.ajax({
                url: "/ajax/getRejectionReason",
                type: "post",
                dataType: "json",
           }).success(function(json){
               $.each(json, function(key, value) {   
                     $('.rejectionReason')
                         .append($("<option></option>")
                                    .attr("value",value['id'])
                                    .text(value['name'])); 
                });

                $('#reject-modal').modal('show');


               $('#rejectionForm').on('submit', function(e){
                    e.preventDefault();

                    var data = $(this).serializeArray().reduce(function(obj, item) {
                        obj[item.name] = item.value;
                        return obj;
                    }, {});

                    //console.log(data);

                    $.ajax({
                        url: "/ajax/confirmQuote",
                        type: "post",
                        dataType: "json",
                        data: {'quote_id': quoteID, 'rejected_reason': data.rejected_reason, 'flag': 'offer_rejected'}
                   }).success(function(json){
                       location.reload();

                    }).error(function(xhr, status, error) {
                       //$('.addNewTemporaryProduct').removeClass('hidden');
                    })
                })


            }).error(function(xhr, status, error) {
               //$('.addNewTemporaryProduct').removeClass('hidden');
            })
           
        });



        $('.clientConfirm').on('click', function(e){
            var quoteID = $(this).attr('data-quote');

            $.ajax({
                url: "/ajax/confirmQuote",
                type: "post",
                dataType: "json",
                data: {'quote_id': quoteID, 'flag': 'client_approved'}
           }).success(function(json){
               $('.updateError').addClass('hidden');
               location.reload()
            }).error(function(xhr, status, error) {
               $('.updateError').removeClass('hidden');
            })
        });


        

        

        $('.editQuoteItem').on('click', function(){
            


            var itemID = $(this).attr('data-quoteItem');
            $('#quoteItemEdit').text(itemID);



            var rowIndex = $(this).attr('data-row');

            var quoteIndex = $(this).attr('data-index');

            //$('#quoteItemEdit').text(itemID);
            //console.log(quoteList[quoteIndex].quote_products.data[rowIndex]);

            var itemDetails = quoteList[quoteIndex].quote_products.data[rowIndex];

            $('#editQuoteItemForm').attr('data-quoteItem', itemID);

            $('#editQuoteItemForm input[name=index]').val(itemDetails.criteria);

            $('#editQuoteItemForm input[name=description]').val(itemDetails.customer_description);

            $('#editQuoteItemForm input[name=destination]').val(itemDetails.destination);

        })


        $('#editQuoteItemForm').on('submit', function(e){

            e.preventDefault();

            var data = $(this).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});



            var quoteID = $(this).attr('data-quote');

            var itemID = $(this).attr('data-quoteItem');

            console.log(quoteID, itemID, data);

            $.ajax({
                url: "/ajax/updateItems",
                type: "post",
                dataType: "json",
                data: {'update_description':1,'quote_id': quoteID, 'quote_item_id': itemID, 'data': data}
           }).success(function(json){
               $('.updateError').addClass('hidden');
               location.reload()
            }).error(function(xhr, status, error) {
               $('.updateError').removeClass('hidden');
            })
        })

         $('.statusHistory').on('click', function(){
            var quoteID = $(this).attr('data-quote');
            $('.quoteNumberStatus').text(quoteID);

             $('.statusHistory-modal[data-quote="'+quoteID+'"]').modal('show');



            var statusTable = $('.status_table').DataTable({
                    "ajax": {
                        "url": "/ajax/getQuoteStatusLog/",
                        "dataSrc": "",
                        "type": 'POST',
                        "data": {'quote_id': quoteID}
                    },
                
                    pageLength: 100,
                        "paging":   true,
                        "ordering": false,
                        "searching": true,
                    rowId: 'category_slug',
                      
                    responsive: true,
                    //order: [1],
                    "columns": [ 
                        { 
                            "data": "id",
                        },
                        { 
                            "data": "user_id",
                        },
                        { 
                            "data": "status_id",
                        },
                        {
                            "data": "date",
                            "render" : function(data, type, row) {
                                var date = new Date(data*1000)
                                return date.toLocaleString();
                          } 
                        },
                        { 
                            "data": "due_date",
                        },
                    ],
                    "initComplete": function(settings, json) {

                    }

                });

            $.ajax({
                url: "/ajax/getQuoteStatusLog",
                type: "post",
                dataType: "json",
                data: {'quote_id': quoteID }
           }).success(function(json){

            statusTable.clear().rows.add(json).draw();

            }).error(function(xhr, status, error) {
               $('.messageError').removeClass('hidden');
            })
        })



        $('.viewComments').on('click', function(){
            var quoteID = $(this).attr('data-quote');
            $('.quoteNumberEdit').text(quoteID);

             $('.viewComments-modal[data-quote="'+quoteID+'"]').modal('show');



            var commentsTable = $('.comments_table').DataTable({
                    "ajax": {
                        "url": "/ajax/getComments/",
                        "dataSrc": "",
                        "type": 'POST',
                        "data": {'quote_id': quoteID}
                    },
                
                    pageLength: 100,
                        "paging":   true,
                        "ordering": false,
                        "searching": true,
                    rowId: 'category_slug',
                      
                    responsive: true,
                    //order: [1],
                    "columns": [ 
                        { 
                            "data": "id",
                        },
                        { 
                            "data": "name",
                        },
                        { 
                            "data": "status",
                        },
                        { 
                            "data": "comment",
                        },
                         { 
                            "data": "package_id",
                        },
                         { 
                            "data": "package_status_id",
                        },
                        {
                            "data": "date",
                            "render" : function(data, type, row) {
                                var date = new Date(data*1000)
                                return date.toLocaleString();
                          } 
                        }
                    ],
                    "initComplete": function(settings, json) {
                    }

                });

            $.ajax({
                url: "/ajax/getComments",
                type: "post",
                dataType: "json",
                data: {'quote_id': quoteID }
           }).success(function(json){

            commentsTable.clear().rows.add(json).draw();

            }).error(function(xhr, status, error) {
               $('.messageError').removeClass('hidden');
            })
        })

        $('.viewPackages').on('click', function(){

            //console.log(quoteList);
            var quoteID = $(this).attr('data-quote');
            var quoteIndex = $(this).attr('data-index');
             var quoteName = $(this).attr('data-name');
            $('.quoteNumberEdit').text(quoteID);

             $('.viewPackages-modal[data-quote="'+quoteID+'"]').modal('show');

             $.ajax({
                url: "/ajax/getQuotePackages",
                type: "post",
                dataType: "json",
                data: { 'quote_id': quoteID}
           }).success(function(json){

            //console.log('a', json);

            var packagesObject = {
                'packages' : json,
                'container': '.packagesContainer',
                'quote_id': quoteID,
                'quoteIndex': quoteIndex,
                'quoteName': quoteName
            }

            $(packagesObject.container).html('');

            Invoice.setPackages(packagesObject);

            }).error(function(xhr, status, error) {
               
            })  

        })






        $('.lastPricesTrigger').on('click', function(e){

            var clientId = $(this).attr('data-client');
            var productId = $(this).attr('data-product');

            var productName = $(this).attr('data-productName');

            var getLastClient = $(this).parents('.card').find('.lastPriceClient').text();

            //console.log(getLastClient);

            $('#lastPriceClient').text(getLastClient);

            $('#lastPriceProduct').text(productId);

            $("#lastPriceProductName").text(productName);

            // $('#lastPriceClient').text(clientId);

            $('.lastPricesTabel').DataTable({
                     "ajax": {
                        "url": "/ajax/getLastPrices",
                        "dataSrc": "",
                        "type": 'POST',
                        "data": {'client': clientId, 'product': productId}
                    },
                    dom: 'Bfrtip',                
                    pageLength: 100,
                        "paging":   true,
                        "ordering": false,
                        "searching": true,
                    rowId: 'category_slug',
                      buttons: [],
                    responsive: true,
                    
                    //order: [1],
                    "columns": [
                        { 
                            "data": "quote_id",
                            
                        },
                        { 
                            "data": "project_name",
                            
                        },
                        { 
                            "data": "offer_date",                            
                        },
                        {
                            "data": "discount"
                        },
                        { 
                            "data": "unit_price",
                        }
                    ],
                    "initComplete": function(settings, json) {
                    }

                })
        })

        $('#lastPrices').on('hide.bs.modal', function(e){

          

           $('.lastPricesTabel').DataTable().clear();
            $('.lastPricesTabel').DataTable().destroy(); 
        })



         $('.viewComments-modal').on('hide.bs.modal', function(e){
            $('.packageId').html('');
            $('.packageStatus').html(''); 
            $('.packageText').addClass('hidden');
        })

        
        $('.viewFiles').on('click', function(){
            var quoteID = $(this).attr('data-quote');
            $('.quoteNumberEdit').text(quoteID);

            $('.viewFiles-modal[data-quote="'+quoteID+'"]').modal('show');

            var filesTable = $('.files_table').DataTable({
                     "ajax": {
                        "url": "/ajax/getQuoteFiles/",
                        "dataSrc": "",
                        "type": 'POST',
                        "data": {'quote_id': quoteID}
                    },
                    dom: 'Bfrtip',                
                    pageLength: 100,
                        "paging":   true,
                        "ordering": false,
                        "searching": true,
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
                            className: 'deleteSelectedFiles btn btn-lg btn-danger waves-effect',
                            text: 'Delete Selected',
                            action: function ( e, dt, button, config ) {
                                if(!isc) {
                                 var selection = dt.rows( { selected: true } ).data();
                                    var i;
                                
                                    for ( i = 0; i < selection.length; i++) {
                                        selectedItems.push(selection[i].file_path);
                                    }
                                 

                                    $.ajax({
                                        url: "/ajax/removeFilesFromQuote",
                                        type: "post",
                                        dataType: "json",
                                        data: {'file_path': selectedItems, 'quote_id': quoteID}
                                   }).success(function(json){
                                       location.reload();

                                    }).error(function(xhr, status, error) {
                                       //$('.addNewTemporaryProduct').removeClass('hidden');
                                    })   
                                }
                                
                            }
                        },
                      ],
                    responsive: true,
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
                    //order: [1],
                    "columns": [ 
                        { 
                            "data": null, 
                            defaultContent: '' 
                        },
                        { 
                            "data": "file_path",
                            "render" : function(data, type, row) {
                                return  '<a href="/download?f='+data+'" target="_blank" >'+data+'</a>'
                              }
                        },
                         { 
                            "data": "file_type",
                        },
                        {
                            "data": "date",
                            "render" : function(data, type, row) {
                                var date = new Date(data*1000)
                                return date.toLocaleString();
                          } 
                        },
                        { 
                            "data": "name",
                        },
                        {
                            "data": "send_to_client",
                            "visible": iss,
                            "render" : function(data, type, row) {
                                if(data == 1) {
                                    return "Yes"
                                } else {
                                    return "No"
                                }
                                
                              }
                        },
                        {
                            "data": "is_sent",
                            "visible": iss,
                            "render" : function(data, type, row) {
                                if(data == 1) {
                                    return "Yes"
                                } else {
                                    return "No <button class='triggerFileNotification' data-quote='"+quoteID+"' data-file='"+row.file_path+"' >Send</button"
                                }
                                
                              }
                        }
                    ],
                    "initComplete": function(settings, json) {
                    }

                })

            $.ajax({
                url: "/ajax/getQuoteFiles",
                type: "post",
                dataType: "json",
                data: {'quote_id': quoteID }
           }).success(function(json){

            filesTable.clear().rows.add(json).draw();

            }).error(function(xhr, status, error) {
               $('.messageError').removeClass('hidden');
            })

            
        })

        $(document).on( 'click','.triggerFileNotification', function(){
            var file = $(this).attr('data-file'); 

            var quoteId = $(this).attr('data-quote');

            tinyMCE.activeEditor.setContent('We have uploaded a new file for you. Please check your quote on the files section for: '+file);


            
            callQuoteSend(quoteId, clientId, file)

        } );

        var allComments = $('.allComments_table').DataTable({
                    "ajax": {
                        "url": "/ajax/getProjectComments/",
                        "dataSrc": "",
                        "type": 'POST',
                        "data": {'project_id': projectID}
                    },
                
                    pageLength: 100,
                        "paging":   true,
                        "ordering": false,
                        "searching": true,
                    rowId: 'category_slug',
                     rowGroup: {
                        dataSrc: 'id'
                    },
                    responsive: true,
                    //order: [1],
                    "columns": [ 
                        { 
                            "data": "id",
                        },
                        { 
                            "data": "name",
                        },
                        { 
                            "data": "status",
                        },
                        { 
                            "data": "comment",
                        },
                        {
                            "data": "date",
                            "render" : function(data, type, row) {
                                var date = new Date(data*1000)
                                return date.toLocaleString();
                          } 
                        }
                    ],
                    "initComplete": function(settings, json) {
                    }

                });

        $('.commentForm').on('submit', function(e){

            e.preventDefault();

            var data = $(this).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});



            var quoteID = $(this).attr('data-quote');
            $('#quoteNumberEdit').text(quoteId);

            var packageId = $('.packageId[data-quote="'+quoteId+'"]').html();
            var packageStatus = $('.packageStatus[data-quote="'+quoteId+'"]').html();


            //console.log(quoteID);

            $.ajax({
                url: "/ajax/addComment",
                type: "post",
                dataType: "json",
                data: {'quote_id': quoteID,'package_id': packageId,'package_status_id': packageStatus, 'quote_status': quoteStatus[quoteId], 'data': data}
           }).success(function(json){
               $('.updateError').addClass('hidden');
               location.reload()
            }).error(function(xhr, status, error) {
               $('.updateError').removeClass('hidden');
            })
        })

        updateStatus(quoteStatus);

        readFlags(quoteFlags, quoteStatus);

        $('.flags-wrapper button').on('click', function(){
            var quoteId = $(this).closest('[data-quote]').attr('data-quote');
            var flag = $(this).attr('data-flag');

            if(flag == "offer_sent") {
                var quoteId = $(this).attr('data-quote');

         var thisClientId = $(this).attr('data-client');

         var thisClientEmail = $(this).attr('data-email');

         var afterApprove = $(this).attr('data-afterApprove');

         $('#clientEmail').val(thisClientEmail);

                
                callQuoteSend(quoteId, thisClientId, 'quote')
            } else {



                var updatedFlag = !$(this).is(':disabled');

                var flagOptions = {
                    "flag": flag, 
                    "flag_value": + updatedFlag // Bool to numnber
                }

                updateQuote(quoteId, flagOptions );
                location.reload();
            }
        });

        $('.status-wrapper button').on('click', function(){
            var quoteId = $(this).closest('[data-quote]').attr('data-quote');
            var thisIndex = $(this).closest('[data-index]').attr('data-index');
            var afterApprove = $(this).closest('[data-afterApprove]').attr('data-afterApprove');

             var selfCustomer = $(this).closest('[data-selfCustomer]').attr('data-selfCustomer');

                var thisStatus = $(this).attr('data-status');

                var el = $(this);

            if(quoteList[thisIndex].id = quoteId) {
                quote = quoteList[thisIndex];
            } else {
                quote = 0;
            }

            // console.log(quoteList[index])

            // console.log(index)
            // console.log(quoteList)

            $.ajax({
                url: "/ajax/changeQuoteStatus",
                type: "post",
                dataType: "json",
                data: {'quote': JSON.stringify(quote), 'quote_id': quoteId, 'quote_status': quoteStatus[quoteId], 'profit_low': getProfitLow(profitLow[quoteId]), 'afterApprove': afterApprove, 'jump_status': thisStatus, 'selfCustomer' : selfCustomer }
           }).success(function(json){

                if(json == 3) {


            var quoteId = el.attr('data-quote');

             var thisClientId = el.attr('data-client');

             var thisclientEmail = el.attr('data-email');

             var afterApprove = el.attr('data-afterApprove');

             $('#clientEmail').val(thisclientEmail);

                    
                    callQuoteSend(quoteId, thisClientId, 'quote')
                } else {
                   
                    location.reload();
                }


            }).error(function(xhr, status, error) {
               $('.updateError').removeClass('hidden');
            })
        })



    $('body').on('change', '.package-quantity-input', function(){
       
        var packageItem = {
            'package_item_id': $(this).attr('data-package_item'),
            'quote_item_id':  $(this).attr('data-quote_item'),
            'product_id':  $(this).attr('data-product'),
            'package_item_quantity': $(this).val()
        }

        console.log(packageItem);


         $.ajax({
                url: "/ajax/updatePackageItem",
                type: "post",
                dataType: "json",
                data: packageItem
           }).success(function(json){
               
              if(json==0) {
                  $('.updatePackageItemError').removeClass('hidden');
              } else {
                $('.updatePackageItemError').addClass('hidden');
              }
            }).error(function(xhr, status, error) {
                $('.updatePackageItemError').removeClass('hidden');
            })

        
    });







    $('body').on('click', '.removePackage', function(){
            console.log('a');

        var itemId = $(this).attr('data-package');
        
         $.ajax({
            url: "/ajax/removePackage",
            type: "post",
            dataType: "json",
            data: {'id':itemId}
        }).success(function(json){
            $('.updatePackageItemError').addClass('hidden');
            $('.package_line.package-'+itemId).remove();
        }).error(function(xhr, status, error) {
           $('.updatePackageItemError').removeClass('hidden');
        })


        })

     $('body').on('click', '.package_status_change', function(){

         var params = {
                'nextStatus': $(this).attr('data-nextStatus'),
                'packageId': $(this).attr('data-package')
            }


            Invoice.changeStatus(params);

         $.ajax({
                url: "/ajax/updatePackageStatus",
                type: "post",
                dataType: "json",
                data: params
           }).success(function(json){
               
              if(json==0) {
                  $('.updatePackageItemError').removeClass('hidden');
              } else {
                $('.updatePackageItemError').addClass('hidden');
                location.reload();
              }
            }).error(function(xhr, status, error) {
                $('.updatePackageItemError').removeClass('hidden');
            })

        
    });



Dropzone.autoDiscover = false;

});

$(function() {
    //Dropzone class
    if($('.dropzone-image').length) {
        var myDropzone = new Dropzone(".dropzone-image", {
            url: "/ajax/uploadFile",
            paramName: "file",
            maxFilesize: 2,
            maxFiles: 1,
            acceptedFiles: "image/*",
            autoProcessQueue: true,
            init: function () {
                this.on("success", function (file, response) {
                   
                    $('#file-name').val(response.trim());
                });
            }
        });
    }


     if($('.dropzone-doc').length) {
        $(".dropzone-doc").each(function() {
             $(this).dropzone(
             {
                url: "/ajax/uploadFile",
                paramName: "file",
                maxFilesize: 2,
                maxFiles: 5,
                acceptedFiles: ".doc, .pdf, image/*",
                autoProcessQueue: true,
                init: function () {
                    this.on("success", function (file, response) {

                        console.log(this.element.attributes);

                        var quoteId = this.element.attributes['data-quote'].value;

                       
                        $(this.element).find('[name="file_name"]').val(response.trim());
                        $(this.element).find('[name="quote_id"]').val(quoteId);
                         $(this.element).find('.filesToDB').removeClass('hidden');
                         $(this.element).find('.quoteFilesForm').on('submit', function(e){
                            e.preventDefault();
                           

                            var data = $(this).serializeArray().reduce(function(obj, item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {});

                            $.ajax({
                                url: "/ajax/saveFilesToQuote",
                                type: "post",
                                dataType: "json",
                                data: data
                            }).success(function(json){
                                $('.updateError').addClass('hidden');
                                location.reload();
                            }).error(function(xhr, status, error) {
                               $('.updateError').removeClass('hidden');
                            })
                        })
                    });
                }  
             })

        })
     }
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


function getBase64FromImageUrl(url) {
    var img = new Image();

    img.setAttribute('crossOrigin', 'anonymous');

    img.onload = function () {
        var canvas = document.createElement("canvas");
        canvas.width =this.width;
        canvas.height =this.height;

        var ctx = canvas.getContext("2d");
        ctx.drawImage(this, 0, 0);

        var dataURL = canvas.toDataURL("image/png");

        alert(dataURL.replace(/^data:image\/(png|jpg);base64,/, ""));
    };

    img.src = url;
}

class PriceDetails {
    constructor(discount, quantity, initialPrice, minPrice, listPrice, unitPrice, profit, profitPercent, finalPrice) {
       
        this.discount = discount;
        this.initialPrice = initialPrice;
        this.minPrice = minPrice;
        this.listPrice = listPrice;
        this.quantity = quantity;
        this.unitPrice = unitPrice;
        this.profit = profit;
        this.profitPercent = profitPercent;
        this.finalPrice = finalPrice;
    }

    getPricingDetails() {
        return {
            "discount": this.discount,
            "initialPrice": this.initialPrice,
            "minPrice": this.minPrice,
            "listPrice": this.listPrice,
            "quantity": this.quantity,
            "unitPrice": this.unitPrice,
            "profit": this.profit,
            "profitPercent": this.profitPercent,
            "finalPrice": this.finalPrice
        }
    }


    updateItemPricing(el) {
        var that = $(el);

        var type = that.attr('data-type');

        if(type == 'discount') {

            this.discount = that.val();
            this.unitPrice =  (this.listPrice - (this.listPrice*this.discount/100)).toFixed(2);

        } else if(type == 'unitPrice') {
            this.unitPrice = that.val();
            this.discount = 100 - (this.unitPrice*100/this.listPrice).toFixed(2);
            this.discount = isFinite(this.discount) ? this.discount : 0;
        } else if(type == 'quantity') {

            this.quantity = that.val();
        }

        this.profit = (this.unitPrice - this.initialPrice).toFixed(2);
        this.profitPercent = (this.profit * 100 / this.unitPrice).toFixed(2)
        this.finalPrice = (this.quantity * this.unitPrice).toFixed(2)

        this.updateDomPrices(that);
        this.updateDB(el);


    }

    updateDomPrices(el) {
        var tr = el.closest('tr');
        this.updateEl(tr, "discount", this.discount);
        this.updateEl(tr, "unitPrice", this.unitPrice);
        this.updateEl(tr, "profit", this.profit);
        this.updateEl(tr, "profitPercent", this.profitPercent);
        this.updateEl(tr, "quantity", this.quantity);
        this.updateEl(tr, "finalPrice", this.finalPrice);       
    }

    updateEl(tr, type, newValue) {
        var tableID = tr.closest('table').attr('id')

        var updatedEl = tr.find("[data-type='" + type + "']");

        var rowId = updatedEl.attr('data-row');

        var colId = updatedEl.attr('data-col');

        var tagName = updatedEl.prop("tagName");

        if (tagName == "INPUT") {
            updatedEl.val(newValue)
        }
        else {
            updatedEl.text(newValue);
        }

        $('#'+tableID).dataTable().api().cell({ row: rowId, column: colId }).data(newValue).draw();
        

    }

    updateDB(el){


        var quoteItem = {
            'item_id': $(el).attr('data-item'),
            'discount': this.discount,
            'quantity': this.quantity,
            'unit_price': this.unitPrice,
        };


         $.ajax({
            url: "/ajax/updateQuantity",
            type: "post",
            dataType: "json",
            data: quoteItem
        }).success(function(json){
           $('.updateError').addClass('hidden');

        }).error(function(xhr, status, error) {
           $('.updateError').removeClass('hidden');
        })


    }

}

function updateQuote(quoteID, options){

    $.ajax({
        url: "/ajax/updateQuote",
        type: "post",
        dataType: "json",
        data: {'quote_id': quoteID, 'options': options}
   }).success(function(json){
       $('.updateError').addClass('hidden');

    }).error(function(xhr, status, error) {
       $('.updateError').removeClass('hidden');
    })
}


function sendQuoteToClient(quoteID, clientId, data, type) {

//console.log('a');
    $.ajax({
        url: "/ajax/sendQuoteToClient",
        type: "post",
        dataType: "json",
        data: {'quote_id': quoteID, 'client_id': clientId, 'data': data, 'type': type }
   }).success(function(json){
       $('.messageError').addClass('hidden');
       $('.messageSent').removeClass('hidden');
       location.reload();

    }).error(function(xhr, status, error) {
       $('.messageError').removeClass('hidden');
    })

}



function callQuoteSend(quoteId, clientId, type)
{

    //console.log(quoteId, isClientValid[quoteId], clientEmail);

    $('.clientNameError').text(clientName[quoteId]);
    $('.updateClientLink').attr('href', '/client/'+ clientId);

    $('.clientToName').text(clientName[quoteId]);  

    $("#clientEmail").email_multiple({
          reset: true,
          data : [clientEmail[quoteId]]
      });
    $('#sendMail-modal').modal('show');


    //Client Validation

    //  if(isClientValid[quoteId] == 0) {
    //     $('.clientInvalidError').removeClass('hidden');
    //     $('.modal-body').addClass('hidden');
    // } else {
    //     $('.modal-body').removeClass('hidden');
    //     $('.clientInvalidError').addClass('hidden');
    // }

    $('#sendQuoteForm').keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });
    $('#sendQuoteForm').on('submit', function(e){
        e.preventDefault()

        if($("#clientEmail").val() == "") {
             $('.enter-mail-id').css('border', '1px solid red')
        } else {
            var data = $(this).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});
            //console.log(data);

            sendQuoteToClient(quoteId, clientId, data, type);
            }
     })
}


function updateStatus(quoteStatus){



    $.each($('.status-wrapper'), function (i, item) {


        var quoteID = $(item).attr('data-quote');
        var status = quoteStatus[quoteID];

        var statusLog = {};

        var statusButton = $(item).find('button[data-status='+ status +']');

        statusButton.removeClass('btn-default').addClass('btn-primary');

         $.ajax({
            url: "/ajax/getQuoteStatusLog",
            type: "post",
            dataType: "json",
            data: {"quote_id": quoteID}
        }).done(function(json){

           for(var statusItem in json) {

                var date = new Date(json[statusItem].date*1000)
                var statusDate = date.toLocaleDateString();
                statusLog[json[statusItem].status_id] = statusDate
            }

             statusButton.closest('.header').find('status-date-wrapper .status-date'). html(statusLog[status]);

             $(item).parents('.header').find('.status-date').html(statusLog[status]);


        }).error(function(xhr, status, error) {
            
        })
    });
}

function readFlags(quoteFlags, quoteStatus){

    $.each($('.flags-wrapper'), function (i, item) {
        var quoteID = $(item).attr('data-quote');
        var buttons = $(item).find('button');
        var thisFlagList = quoteFlags[quoteID];
        var status = quoteStatus[quoteID];
        $.each(buttons, function (i, item) {
            var flagButton = $(item);
            var flag = $(item).attr('data-flag');
            var flagValue = thisFlagList[flag];

            if(flagValue > 0) {
                flagButton.removeClass('btn-default').addClass('btn-success').attr('disabled', 'disabled');
                flagButton.find('i').text('check_box')
            } else {
                flagButton.find('i').text('check_box_outline_blank')
            }

        })

    });
}

function getProfitLow(profitLowValues) {

    var rowsProfitLow = 0;

    if(profitLowValues['extra_discount'] > 0 || rowsProfitLow > 0) {
        return 1;
    }
    else
    {
        for (key in profitLowValues['rows']) {
          if(profitLowValues['rows'][key] == 1)
           {
             rowsProfitLow = 1;
             return 1;
           }
        }
        return 0;
    }
} 

function addItemsToPackage(packageDetail) {
    $.ajax({
        url: "/ajax/addItemsToPackage",
        type: "post",
        dataType: "json",
        data: packageDetail
    }).success(function(json){
       $('.updateError').addClass('hidden');
       

    }).error(function(xhr, status, error) {
       $('.updateError').removeClass('hidden');
    })
}
