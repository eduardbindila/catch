class Invoices {
    constructor() { 
      this.packageTable = [];

      this.packageDetails;
    }

    setPackageLine(params) {

      var that = this;

      var packageId = params.packageId;

      var packageDate = params.packageDate;

      var packageStatus = params.packageStatus;

      var packageStatusName = params.packageStatusName;

      var country = params.country;

      var quote_id = params.quote_id;

      var collapserId = 'collapse-'+packageId;

      var statusClass = "";

      var nextStatus = "";

      var prevStatus = "";

       var nextStatusClass = "";

      var nextStatusAction = ""

      var revertInvoiceClass = ""

      var removePackageClass = ""
      var backButtonClass = ""

        switch(parseInt(packageStatus)) {
            case 1:
                statusClass = 'btn-default';
                nextStatusClass = 'btn-info';
                nextStatus = 2;
                nextStatusAction = "Generate POS";
                revertInvoiceClass = "hidden"
                removePackageClass = "";
                backButtonClass = "hidden";

            break;

              case 2:
                statusClass = 'btn-info';
                nextStatusClass = 'btn-primary';
                nextStatus = 3;
                prevStatus = 1;
                nextStatusAction = "Generate Delivery Note";
                revertInvoiceClass = "hidden"
                removePackageClass = "";
            break;

            case 3:
                statusClass = 'btn-primary';
                nextStatusClass = 'btn-success';
                nextStatus = 4;
                prevStatus = 2;
                nextStatusAction = "Generate Invoice";
                revertInvoiceClass = "hidden"
                removePackageClass = "";
            break;

            case 4:
                statusClass = 'btn-success';
                 nextStatusClass = 'hidden';
                 revertInvoiceClass = ""
                removePackageClass = "hidden";
                backButtonClass = "hidden";
        }

        //console.log(nextStatusClass, packageStatus);

       var invoiceForm = '';

       if(packageStatus > 2) {
        invoiceForm = that.getInvoiceDetailsForm(params);
       }

       //console.log(params);

      var packageLine = '<div class="package_line m-t-10 package-'+packageId+'">'+
                           '<div class="package_wrapper">'+
                               '<button class="btn btn-default collapser triggerPackageItems"'+
                               ' type="button" data-toggle="collapse"'+
                               ' href="#'+collapserId+'" aria-expanded="false"'+
                               ' aria-controls="'+collapserId+'" data-package='+packageId+'>'+
                                   '<span class="packageId">'+
                                       '<i class="material-icons package-icon">folder</i>'+
                                       'Package <b>'+packageId+'</b>'+ 
                                   '</span>'+
                                   '<span class="packageDate">'+
                                       'created on <b>'+packageDate+'</b>'+
                                   '</span>'+
                                   // '<span class="packageStatus">'+
                                   //     'Status: <b>'+packageStatusName+'</b>'+
                                   // '</span>'+
                               '</button>'+
                               '<div class="btn-group btn-group-sm right"'+
                               ' role="group" aria-label="Large button group">'+
                                '<button type="button" data-type="generate_pos" data-package='+packageId+ 
                                    ' data-nextStatus="'+prevStatus+
                                                    '" class="btn btn-default prevStatusButton '+backButtonClass+
                                    ' waves-effect package_status_change">' +
                                    '<i class="material-icons">chevron_left</i>'+
                                '</button>'+

                                '<button type="button" data-type="generate_pos" disabled data-package='+packageId+ 
                                                    ' class="btn '+statusClass+' waves-effect package_status_change">'+
                                                        packageStatusName + 
                                                    
                                '</button>'+

                                 '<button type="button" data-package='+packageId+
                                                ' data-nextStatus="'+nextStatus+
                                                '" data-country="'+country+
                                                    '" class="btn '+nextStatusClass+
                                                    ' waves-effect package_status_change">'+
                                                            nextStatusAction+
                                '</button>'+

                               '<button type="button" data-package='+packageId+' class="'+removePackageClass+
                                ' btn btn-danger waves-effect removePackage">'+
                                 '<i class="material-icons">close</i>'+
                                '</button>'+

                                '<button type="button" data-package='+packageId+' class="'+revertInvoiceClass+
                                    ' btn btn-primary waves-effect revertInvoice">'+
                                 '<i class="material-icons">subdirectory_arrow_left</i>'+
                                '</button>'+
                               '</div>'+
                               
                           '</div>'+
                           '<div class="collapse in" id="'+collapserId+'" aria-expanded="true"'+
                           ' style="">'+
                           '<div class="row m-t-10 m-b-10">'+
                                    '<div class="col-lg-12">'+
                                         invoiceForm +
                                    '</div>'+ 
                           '</div>'+
                            
                               '<table class="packages_table-'+packageId+' table table-striped table-bordered table-hover dt-responsive display">'+
                                   '<thead>'+
                                        '<th></th>'+
                                        '<th>'+that.getTranslation('Quote_Id',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Index',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Client_Name',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Warehouse',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Quote_Item_Id',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Product_Id',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Product_Name',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Quote_Quantity',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Reserved',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Stock',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Invoiced',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Extra_Discount',params.currency)+' (%)</th>'+
                                        '<th>'+that.getTranslation('Unit_Price',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Package_Quantity',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Package_Quantity',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Value',params.currency)+' ('+ params.currency +')</th>'+
                                        '<th>'+that.getTranslation('Green_Tax_Total',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Green_Tax_PC',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('VAT',params.currency)+' ('+ params.vat +')</th>'+
                                        '<th>'+that.getTranslation('Item_Total',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Owner',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Type',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Green_Tax_PC',params.currency)+'</th>'+
                                        '<th>ID</th>'+
                                   '</thead>'+
                                   '<tfoot>'+
                                        '<th colspan=16>'+that.getTranslation('Subtotals',params.currency)+' ('+ params.currency +')</th>'+
                                        '<th></th>'+
                                        '<th></th>'+
                                        '<th></th>'+
                                        '<th></th>'+
                                        '<th></th>'+
                                        '<th></th>'+
                                        '<th></th>'+
                                        '<th></th>'+
                                   '</tfoot>'+
                               '</table>'+
                               '<table class="advanceTable-'+ quote_id + ' table ">'+
                                   '<thead>'+
                                        '<th>'+that.getTranslation('Total_Advance',params.currency)+'('+ params.currency +')</th>'+
                                        '<th>'+that.getTranslation('Total_Reversal',params.currency)+'</th>'+
                                        '<th>'+that.getTranslation('Remaining',params.currency)+'</th>'+
                                   '</thead>'+
                                   '<tr>'+
                                        '<td class="totalAdvance">-</td>'+
                                        '<td class="totalReversal">-</td>'+
                                        '<td class="remaining">-</td>'+
                                   '</tr>'+
                               '</table>'+
                           '</div>'+
                       '</div>';

         return packageLine

    }

    setPackages(params){



      var that = this;

      var packages = params.packages;

      var packageContainer = params.container;

      packages.forEach(function(val, index){

         var thisPackage = val;
         var editDisabled = '';
         var showForInvoice = false;
         var hideForInvoice = true;

         if(packages[index].package_status_id > 1) {
            editDisabled = 'disabled';
            showForInvoice = true;
            hideForInvoice = false;
         }

         if(quoteList[params.quoteIndex].client_details.country == "RO") {
            if(packages[index].exchange_rate) {
                packages[index].exchange_rate = packages[index].exchange_rate
            } else 
            {
                packages[index].exchange_rate = 4.99;
            }
         }

         
         //console.log(thisPackage, params);

         var packageDetails = {
            'packageId': thisPackage.id,
            'packageDate': thisPackage.created_date,
            'packageStatusName': thisPackage.name,
            'quote_id': packages[index].quote_id,
            'packageStatus': packages[index].package_status_id,
            'clientDetails': quoteList[params.quoteIndex].client_details,
            'invoiceDate': packages[index].invoice_date,
            'pos_date': packages[index].pos_date,
            'awb_date': packages[index].awb_date,
            'other_details': packages[index].other_details,
            'dueDate': packages[index].invoice_due_date,
            'exchangeRate': quoteList[params.quoteIndex].client_details.country == "RO" ? packages[index].exchange_rate : 1,
            'invoiceNumber': packages[index].invoice_number,
            'country': quoteList[params.quoteIndex].client_details.country,
            'showRon':  (quoteList[params.quoteIndex].client_details.country == "RO"),
            'currency':   quoteList[params.quoteIndex].client_details.country == "RO" && packages[index].exchange_rate !== '' ? "Ron" : "Euro",
            'vat':   quoteList[params.quoteIndex].client_details.country == "RO" ? "19" : "0%",
            'vat_value':   quoteList[params.quoteIndex].client_details.country == "RO" ? 0.19 : 0,
            'totals' : {}
         }
        
        that.packageDetails = packageDetails;

            var greenTaxDropDown = that.getGreenTaxlist();

            var itemTypesDropDown = that.itemTypesList();

            

//console.log(packageDetails);
         var packageLine = Invoice.setPackageLine(packageDetails);

         $(packageContainer).append(packageLine);

         var columnsArrayParams = {
            "euro": !packageDetails.showRon,
            "ron": packageDetails.showRon,
            "extra_discount": thisPackage.extra_discount >  0
         }

         //console.log(columnsArrayParams);

         var columnsObject =  that.getColumnsArray(columnsArrayParams);


        var invoiceColumns = columnsObject.columns_order;
        //[ 
         //                            2,//Index
         //                            6,//Product Id
         //                            7,//Product Name
         //                            // 12,//Discount
         //                            15,//Package Quantity
         //                            13,//Unit Price
         //                            23, //Green Tax 
         //                            16,//Value
         //                            19,//Vat
         //                            20,//Item Total
         //                            17, //Green Tax Total
         //                            ]


         // if(packageDetails.currency == "Euro") {
         //    invoiceColumns = [ 
         //                            2,//Index
         //                            6,//Product Id
         //                            7,//Product Name
         //                            // 12,//Discount
         //                            15,//Package Quantity
         //                            13,//Unit Price
         //                            16,//Value
         //                            19,//Vat
         //                            20,//Item Total
                                    
         //                            ] 
         // }

         var enableInvoiceCreation = false;

         if( packageDetails.packageStatus > 2) {
            enableInvoiceCreation = $(".form-package-"+packageDetails.packageId).valid()
         }

         var fileNameData = thisPackage.quote_id + '-' + thisPackage.id;

         that.packageTable[thisPackage.id] = $('.packages_table-'+thisPackage.id).DataTable({
                     "ajax": {
                        "url": "/ajax/getPackageItems/",
                        "dataSrc": "",
                        "type": 'POST',
                        "data": {
                            'package_id': thisPackage.id, 
                            'country': quoteList[params.quoteIndex].client_details.country,
                            'exchange_rate': packageDetails.exchangeRate == '' ? 1 : packageDetails.exchangeRate,
                            'vat': packageDetails.vat
                        }
                    },
                    dom: 'Bfrtip',                
                    pageLength: 100,
                        "paging":   true,
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
                            text: 'Add External Item',
                            className: 'btn btn-lg btn-primary waves-effect',
                            action: function ( e, dt, node, config ) {

                                dt.row.add( 
                                {
                                    "id": "",
                                    "quote_item_id": "",
                                    "package_quantity": "",
                                    "package_id": "",
                                    "external_item_name": "",
                                    "product_id": "",
                                    "product_name": "",
                                    "saga_quantity": "",
                                    "reserved_stock": "",
                                    "quantity": "",
                                    "invoiced_quantity": "",
                                    "quote_id": "",
                                    "unit_price": "",
                                    "value": "",
                                    "vat_value": "",
                                    "green_tax_total": "",
                                    "total": ""
                                }).draw().node();
                                                      
                            }
                        },
                        {
                            extend: 'csv',
                            className: 'btn btn-lg btn-primary waves-effect',
                            name:"2",
                            enabled: thisPackage.package_status_id > 1,
                            text:'Generate POS',
                            filename: 'POS-'+ fileNameData + '-' + Date.now(),
                            exportOptions: {
                              stripHtml: true,
                              orthogonal: true,
                              saveToServer: true,
                              fileData: {
                                 "quote_id": thisPackage.quote_id,
                                "file_name": 'POS-'+ fileNameData + '-' + Date.now(),
                                "file_type": 2,
                                "file_extension": "csv"
                              },
                              columns: [ 
                                  24,//Quote ID
                                  2,//Index
                                  3,//Client Name
                                  4,//Warehous
                                  6,//Product ID
                                  15,//Package Quantity
                                  21 //Owner
                              ]
                            }, footer: false,

                            action: function ( e, dt, node, config ) {
                                
                               this.ajax.reload(() => {
                                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, node, config);
                                   });
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            name:"3", 
                            enabled: thisPackage.package_status_id > 2,
                            text: 'Generate AWB',
                            filename: 'AWB-'+ fileNameData + '-' + Date.now(),
                            className: 'btn btn-lg btn-primary waves-effect',
                             exportOptions: {
                              stripHtml: true,
                              orthogonal: true,
                                saveToServer: true,
                              fileData: {
                                 "quote_id": thisPackage.quote_id,
                                "file_name": 'AWB-'+ fileNameData + '-' + Date.now(),
                                "file_type": 5,
                                "file_extension": "pdf"
                              },
                              columns: [ 
                                    2,//Index
                                    6,//Product Id
                                    7,//Product Name
                                    //12,//Discount
                                    15,//Package Quantity
                                    ]
                            }, footer: false,
                            customize: function ( doc ) {
                               //that.setInvoiceObject();

                               //console.log(params);

                               var thisPDFData = that.getPDFData(packageDetails, params, "awb");

                               //console.log(thisPDFData);

                               doc.content[0] = thisPDFData.invoiceDetails;
                                
                                doc.styles =  thisPDFData.docStyles;
                                
                                 doc.defaultStyle = 
                                 {
                                    fontSize: 8
                                };

                                doc.content[1].layout = 'lightHorizontalLines';

                                var tableLength = doc.content[1].table.body.length;

                                
                            },
                        },
                         {
                            extend: 'pdfHtml5',
                            name:"4", 
                            enabled: enableInvoiceCreation,
                            text: 'Generate Invoice',
                            //filename: 'Invoice-'+ packageDetails.invoiceNumber + '-' + Date.now(),
                            filename: function () {
         return that.getExportFileName(params);
      },
                            className: 'btn btn-lg btn-primary waves-effect',
                             exportOptions: {
                              stripHtml: true,
                              orthogonal: true,
                              columns: invoiceColumns,
                              saveToServer: true,
                              fileData: {
                                 "quote_id": thisPackage.quote_id,
                                //"file_name": 'Invoice-'+ packageDetails.invoiceNumber + '-' + Date.now(),
                                "file_name": that.getExportFileName(),
                                "file_type": 1,
                                "file_extension": "pdf"
                              },
                            }, footer: true,
                            customize: function ( doc ) {

                               //  var invoiceNumber = packageDetails.invoiceNumber;

                               //  if(packageDetails.invoiceNumber == "" ) {
                               //      invoiceNumber = getLatestInvoiceNumber(packageDetails)
                               //  }

                               //  // console.log(invoiceNumber)

                               // params['fileNumber'] = invoiceNumber;


                               //that.setInvoiceObject();

                               //console.log(that.packageDetails, packageDetails);
                                
                                var thisPDFData = that.getPDFData(packageDetails, params, "invoice");

                               //console.log(thisPDFData);

                               doc.content[0] = thisPDFData.invoiceDetails;

                               //console.log(doc);
                               
                                
                                doc.styles =  thisPDFData.docStyles;
                                
                                 doc.defaultStyle = 
                                 {
                                    fontSize: 8
                                };

                                doc.content[1].layout =  {
                hLineWidth: function (i, node) {
                    return (i === 0 || i === node.table.body.length) ? 2 : 1;
                },
                vLineWidth: function (i, node) {
                    return 0;
                },
                hLineColor: function (i, node) {
                    return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';
                },

                // vLineColor: function (i, node) {
                //     return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';
                // },
                // hLineStyle: function (i, node) { return {dash: { length: 10, space: 4 }}; },
                // vLineStyle: function (i, node) { return {dash: { length: 10, space: 4 }}; },
                // paddingLeft: function(i, node) { return 4; },
                // paddingRight: function(i, node) { return 4; },
                // paddingTop: function(i, node) { return 2; },
                // paddingBottom: function(i, node) { return 2; },
                // fillColor: function (rowIndex, node, columnIndex) { return null; }
            }

                                var tableLength = doc.content[1].table.body.length;

                                doc.content[1].table.widths = columnsObject.widths

                                //console.log(doc.content[1]);

                                //Hide SubFooter Cell Content
                                //doc.content[1].table.body[tableLength-1][0] = "";
                                doc.content[1].table.body[tableLength-1][0]['colSpan'] = "2";
                                doc.content[1].table.body[tableLength-1][1] = "";
                                doc.content[1].table.body[tableLength-1][2] = "";
                                doc.content[1].table.body[tableLength-1][3] = "";
                                doc.content[1].table.body[tableLength-1][4] = "";

                                

                                var columnPosition = columnsObject.columns_data;

                                var totalGreenTaxWithVat = 0;

                                var totalExtraDiscount = 0

                                    //console.log(columnsObject.widths);

                                var colspan = columnsObject.widths.length-4; 

                                 ;
                                var extraDiscountArray = [];
                                var greenTaxArray = []

                                for (var i = 0; i < columnsObject.widths.length; i++) {
                                        extraDiscountArray[i] = {text: ''};
                                        greenTaxArray[i] = {text: ''};
                                       
                                    }

                               

                                

                                 doc.content[1].table.body[tableLength] = extraDiscountArray;

                                  doc.content[1].table.body[tableLength+1] = greenTaxArray;

                               

                                if(packageDetails.totals.extra_discount > 0) {


                                    var extraDiscountValue = -1 * parseFloat(packageDetails.totals.extra_discount);

                                    var extraDiscountVAT = -1 * parseFloat(packageDetails.vat_value) * parseFloat(packageDetails.totals.extra_discount) ;
                                    var totalExtraDiscount = parseFloat(extraDiscountValue) + parseFloat(extraDiscountVAT)

                                    extraDiscountArray[0] = {text: that.getTranslation('Extra_Discount',packageDetails.currency)+
                                                            ' ('+ packageDetails.currency +'):', colSpan: colspan,alignment: 'left' };
                                    extraDiscountArray[colspan+1] = {text: extraDiscountValue.toFixed(2), alignment: 'center'};
                                    extraDiscountArray[colspan+2] = {text: extraDiscountVAT.toFixed(2), alignment: 'center'};
                                    extraDiscountArray[colspan+3] = {text: totalExtraDiscount.toFixed(2), alignment: 'center'};


                                    
                                    //tableLength = tableLength + 1
                                }



                                if(packageDetails.totals.green_tax_total > 0) {
                                    doc.content[1].table.body[tableLength-1][5] = "";
                                    var totalGreenTax = parseFloat(packageDetails.totals.green_tax_total);

                                    var totalGreenTaxVat = totalGreenTax * parseFloat(packageDetails.vat_value);

                                    totalGreenTaxWithVat = (parseFloat(totalGreenTax) + parseFloat(totalGreenTaxVat));

                                    totalGreenTaxWithVat = parseFloat(totalGreenTaxWithVat);

                                    //console.log(columnsObject.widths);


                                    greenTaxArray[0] = {text: that.getTranslation('Green_Tax_Total',packageDetails.currency)+
                                                        ' ('+ packageDetails.currency +'):', colSpan: colspan,alignment: 'left' };

                                    greenTaxArray[colspan+1] = {text: totalGreenTax.toFixed(2), alignment: 'center'};

                                    greenTaxArray[colspan+2] = {text: totalGreenTaxVat.toFixed(2), alignment: 'center'};

                                    greenTaxArray[colspan+3] = {text: totalGreenTaxWithVat.toFixed(2), alignment: 'center'};



                                    //console.log(greenTaxArray);


                                     //doc.content[1].table.body[tableLength+1] = greenTaxArray;
                                }

                                // doc.content[1].table.body.push(extraDiscountArray) ;

                                //console.log(extraDiscountArray, greenTaxArray);


                               //console.log(tableLength);

                                // var total = parseFloat(doc.content[1].table.body[tableLength-1][columnPosition.item_total].text) + totalGreenTaxWithVat;

                                var total = parseFloat(doc.content[1].table.body[tableLength-1][columnPosition.item_total].text) + totalExtraDiscount + totalGreenTaxWithVat;

                                //console.log(doc.content[1].table.body[tableLength-1][columnPosition.item_total].text);

            

                                doc.content[2] = [
                                    // {canvas: [ { type: 'line', x1: 0, y1: 0, x2: 515, y2: 0, lineWidth: 0.5 } ]},
                                    { 
                                       
                                        table: 
                                        {
                                            widths: [250, 250],
                                            body: [
                                                
                                                    
                                                    [
                                                        {text: that.getTranslation('Invoice_Total',packageDetails.currency)+
                                                        ' ('+ packageDetails.currency +'):', style: 'offerPrice'}, 
                                                        {text: total.toFixed(2), style: 'offerPriceValue'}
                                                    ],
                                                    [
                                                        {text: that.getTranslation('Due_Date',packageDetails.currency)+
                                                        ": " + convertMysqlDate(packageDetails.dueDate), style: 'dueDate'}, 
                                                        {text: that.getTranslation('Exchange_Rate',packageDetails.currency) +
                                                         ": " + packageDetails.exchangeRate, style: 'dueDateValue'}
                                                    ],
                                                     [
                                                        {text:packageDetails.other_details, colSpan: 2}, 
                                                        {}
                                                    ]
                                            ]
                                        },
                                        layout: 'lightHorizontalLines'
                                    }
                                ];


                                //console.log(doc.content);
                               
                            },
                        },
                        // {
                        //     extend: 'selected',
                        //     className: 'deleteSelectedFiles btn btn-lg btn-danger waves-effect',
                        //     text: 'Delete Selected',
                        //     action: function ( e, dt, button, config ) {
                        //         if(!isc) {
                        //          var selection = dt.rows( { selected: true } ).data();
                        //             var i;
                                
                        //             for ( i = 0; i < selection.length; i++) {
                        //                 selectedItems.push(selection[i].file_path);
                        //             }
                                 

                        //            //  $.ajax({
                        //            //      url: "/ajax/removeFilesFromQuote",
                        //            //      type: "post",
                        //            //      dataType: "json",
                        //            //      data: {'file_path': selectedItems, 'quote_id': quoteID}
                        //            // }).success(function(json){
                        //            //     location.reload();

                        //            //  }).error(function(xhr, status, error) {
                        //            //     //$('.addNewTemporaryProduct').removeClass('hidden');
                        //            //  })   
                        //         }
                                
                        //     }
                        // },
                        {
                            className: 'comments btn btn-lg btn-danger waves-effect',
                            text: ' Add Comments',
                            action: function ( e, dt, button, config ) {
                                $('.viewPackages-modal[data-quote="'+thisPackage.quote_id+'"]').modal('hide'); 
                                $('.viewComments-modal[data-quote="'+thisPackage.quote_id+'"]').modal('show');
                                $('.packageText[data-quote="'+thisPackage.quote_id+'"]').removeClass('hidden');
                                $('.packageId[data-quote="'+thisPackage.quote_id+'"]').html(thisPackage.id);
                                $('.packageStatus[data-quote="'+thisPackage.quote_id+'"]').html(thisPackage.package_status_id);
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
                            "data": "quote_id",
                            "visible": false
                        },
                        { 
                            "data": null, 
                             "render" : function(data, type, row, meta) {
                                return meta.row+1
                              }
                        },
                        { 
                            "data": "null",
                            "visible": false,
                            "render" : function(data, type, row, meta) {
                                return clientName[row.quote_id]
                              }
                        },
                        { 
                            "data": "null",
                            "visible": false,
                            "render" : function(data, type, row, meta) {
                                return 'Central'
                              }
                        },
                        { 
                            "data": "quote_item_id",
                            "name": "quote_item_id",
                        },
                         { 
                            "data": "product_id",
                        },
                        { 
                            "data": "product_name",
                            "render" : function(data, type, row, meta) {
                                
                            var product = data;

                             var disabled = (thisPackage.package_status_id > 1) ? 'disabled' : '';

                             disabled = false //added to keep this field editable

                            // if(product == 0 && row.external_item_name =='') {//added to keep this field editable
                                if(product == 0 && thisPackage.package_status_id < 2) {
                                //console.log('asd')
                                product = '<div class="form-group">' + 
                                        '<div class="form-line">' + 
                                            '<input class="form-control invoice-external-name"' + 
                                            ' data-type="external-name" data-row="'+meta.row+
                                            '" data-col="'+meta.col+
                                            '" data-package="'+thisPackage.id+
                                            '" data-quote_item="'+row.quote_item_id+
                                            '" data-package_item="'+row.id+
                                            '" data-product="'+row.product_id+
                                            '" value="'+row.external_item_name+'" type="text" name="external_item_name" placeholder="New Item" '+ disabled +'  required>' + 
                                        '</div>' + 
                                    '</div>'
                            } else if(!product) { product = row.external_item_name }

                            return product
                        },
                        }
                        ,
                        { 
                            "data": "quantity",
                        },
                        { 
                            "data": "reserved_stock",
                            "render" : function(data, type, row, meta) {
                                //console.log(meta.col);
                                var disabled = '';

                                if(row.external_item_name !=='') {
                                        disabled = "disabled"
                                }

                                return '<div class="form-group">' + 
                                            '<div class="form-line">' + 
                                                '<input class="form-control reserved_stock-input"' + 
                                                ' data-type="reserved_stock" data-row="'+meta.row+
                                                '" data-col="'+meta.col+
                                                '" data-package="'+thisPackage.id+
                                                '" data-quote_item="'+row.quote_item_id+
                                                '" data-package_item="'+row.id+
                                                '" data-product="'+row.product_id+
                                                
                                                '" value="'+row.reserved_stock+'" type="number" name="reserved_stock"'+
                                                ' placeholder=Reserved Stock"  min=0 required '+ disabled +'>' + 
                                            '</div>' + 
                                        '</div>'
                              }
                        },
                        { 
                            "data": "saga_quantity",
                            "render" : function(data, type, row, meta) {
                                //console.log(meta.col);
                                var disabled = '';

                                if(row.external_item_name !=='') {
                                        disabled = "disabled"
                                }

                               return '<div class="form-group">' + 
                                            '<div class="form-line">' + 
                                                '<input class="form-control saga_quantity-input"' + 
                                                ' data-type="saga_quantity" data-row="'+meta.row+
                                                '" data-col="'+meta.col+
                                                '" data-package="'+thisPackage.id+
                                                '" data-quote_item="'+row.quote_item_id+
                                                '" data-package_item="'+row.id+
                                                '" data-product="'+row.product_id+
                                                
                                                '" value="'+row.saga_quantity+'" type="number" name="saga_quantity"'+
                                                ' placeholder=Stock"  min=0 required '+ disabled +'>' + 
                                            '</div>' + 
                                        '</div>'
                              }
                        },
                        { 
                            "data": "invoiced_quantity",
                        },

                        { 
                            "data": "extra_discount_value",
                            "name": "extra_discount",
                            // "visible": Number(thisPackage.extra_discount) > 0 ? true : false
                            "visible": false
                        },
                       
                        { 
                            "data": "unit_price_before_discount",

                            "render" : function(data, type, row, meta) {
                                //console.log(row);
                                var price = row.unit_price_before_discount;

                                var product = row.product_id;

                                var disabled = (thisPackage.package_status_id > 1) ? 'disabled' : '';

                                if(product == 0 && thisPackage.package_status_id < 2 )  {

                                    // if(row.external_item_unit_price =='') {

                                    //     if(row.external_item_name =='') {
                                    //         disabled = "disabled"
                                    //     }

                                        
                                    // } else {
                                    //     price = row.unit_price_before_discount
                                    // }

                                    disabled = false //added to keep this field editable

                                        price = '<div class="form-group">' + 
                                                '<div class="form-line">' + 
                                                    '<input class="form-control invoice-external-unit-price"' + 
                                                    ' data-type="ùnit_price" data-row="'+meta.row+
                                                    '" data-col="'+meta.col+
                                                    '" data-package="'+thisPackage.id+
                                                    '" data-quote_item="'+row.quote_item_id+
                                                    '" data-package_item="'+row.id+
                                                    '" data-product="'+row.product_id+
                                                    '" value="'+row.unit_price_before_discount+'" type="text" name="external_item_price" placeholder="Unit Price" '+ disabled +' required>' + 
                                                '</div>' + 
                                            '</div>'

                                    //console.log('asd')

                                }

                                return price
                            }, 
                        },
                        { 
                            "data": "null",
                             "render" : function(data, type, row, meta) {
                                //console.log(meta.col);
                                var disabled = (thisPackage.package_status_id > 1) ? 'disabled' : '';

                                if(row.product == 0 && row.external_item_name =='') {
                                        disabled = "disabled"
                                }

                                return '<div class="form-group">' + 
                                            '<div class="form-line">' + 
                                                '<input class="form-control package-quantity-input"' + 
                                                ' data-type="external_item_name" data-row="'+meta.row+
                                                '" data-col="'+meta.col+
                                                '" data-package="'+thisPackage.id+
                                                '" data-quote_item="'+row.quote_item_id+
                                                '" data-package_item="'+row.id+
                                                '" data-product="'+row.product_id+
                                                '" data-external-price="'+row.external_item_unit_price+
                                                '" value="'+row.package_quantity+'" type="number" name="package_quantity"'+
                                                ' placeholder="Package Quantity"  min=0 required '+disabled+'>' + 
                                            '</div>' + 
                                        '</div>'
                              }
                        },
                        { 
                            "data": "package_quantity",
                            'visible': false
                        },

                         
                        
                        { 
                            "data": "value_before_discount",
                        },
                        { 
                            "data": "green_tax_value",
                            'visible': false
                        },
                        { 
                            "data": "green_tax_value",
                            "visible":packageDetails.currency == "Euro" ? false : true,
                            "render" : function(data, type, row, meta) {
                               //console.log(meta.col);
                                var value = row.green_tax_value;

                                var product = row.product_id;

                                var disabled = (thisPackage.package_status_id > 1) ? 'disabled' : '';

                                //console.log(thisPackage.exchange_rate);

                                if(
                                    (Number(row.green_tax_value) == 0 && row.type == 1 && thisPackage.exchange_rate !== "")
                                     || (row.green_tax_id == 0 && row.type == 1) 
                                )  {

                                    value =  
                                            '<div class="btn-group">'+
                                                '<button class="btn btn-default btn-xs "' + 
                                                ' data-row="'+meta.row+
                                                '" data-col="'+meta.col+
                                                '" data-package="'+thisPackage.id+
                                                '" data-quote_item="'+row.quote_item_id+
                                                '" data-package_item="'+row.id+
                                                '" data-product="'+row.product_id+'" data-toggle="dropdown'+
                                                '" aria-haspopup="true" aria-expanded="true">'+
                                                        '<i class="material-icons">add</i>'+ 
                                                '</button>'+
                                                '<ul class="dropdown-menu"'+
                                                ' data-row="'+meta.row+
                                                '" data-col="'+meta.col+
                                                '" data-package="'+thisPackage.id+
                                                '" data-quote_item="'+row.quote_item_id+
                                                '" data-package_item="'+row.id+
                                                '" data-product="'+row.product_id+'" data-toggle="dropdown">'+
                                                        greenTaxDropDown
                                                '</ul>'
                                            '</div>';
                                } 

                                    //console.log('asd')


                                return value
                            }, 
                        },
                        { 
                            "data": "vat_value_before_discount",
                        },
                        
                        { 
                            "data": "total_before_discount",
                        },
                        { 
                            "data": "null",
                            "visible": false,
                            "render" : function(data, type, row, meta) {
                                return 'Icatch'
                              }
                        },
                         { 
                            "data": "type_name",
                            "render" : function(data, type, row, meta) {
                               //console.log(meta.col);
                                var value = row.type_name;

                                var product = row.product_id;

                                // var disabled = (thisPackage.package_status_id > 1) ? 'disabled' : '';

                                // //console.log(product !== "");

                                if(!product )  {

                                    value = row.type_name + 
                                            ' <div class="btn-group">'+
                                                '<button class="btn btn-default btn-xs "' + 
                                                ' data-row="'+meta.row+
                                                '" data-col="'+meta.col+
                                                '" data-package="'+thisPackage.id+
                                                '" data-quote_item="'+row.quote_item_id+
                                                '" data-package_item="'+row.id+
                                                '" data-product="'+row.product_id+'" data-toggle="dropdown'+
                                                '" aria-haspopup="true" aria-expanded="true">'+
                                                        '<i class="material-icons">edit</i>'+ 
                                                '</button>'+
                                                '<ul class="dropdown-menu"'+
                                                ' data-row="'+meta.row+
                                                '" data-col="'+meta.col+
                                                '" data-package="'+thisPackage.id+
                                                '" data-quote_item="'+row.quote_item_id+
                                                '" data-package_item="'+row.id+
                                                '" data-product="'+row.product_id+'" data-toggle="dropdown">'+
                                                        itemTypesDropDown
                                                '</ul>'
                                            '</div>';
                                } 

                                    //console.log('asd')


                                return value
                            }, 

                        },
                        { 
                            "data": "green_tax_total",
                             "name": "green_tax_total",
                             "render" : function(data, type, row, meta) {
                                return data == "" ? 0 : data
                              },
                            "visible": false
                        },
                        { 
                            "data": "null",
                            "visible": false,
                            "render" : function(data, type, row, meta) {
                                return thisPackage.quote_id + '-' + thisPackage.id
                              }
                        },

                    ],
                    "initComplete": function(settings, json) {

                        

                    },
                     "drawCallback": function( settings ) {
                        //console.log(that.packageDetails);
                    },
                    "footerCallback": function( row, data, start, end, display ) {
                        // console.log(packageDetails, '.advanceTable-'+packageDetails.quote_id+' .totalAdvance')

                        $.ajax({
                            url: "/ajax/getAdvanceStatus",
                            type: "post",
                            dataType: "json",
                            data: packageDetails,
                        }).success(function(json){
                           $('.updateError').addClass('hidden');

                           json = json[0];

                           $('.advanceTable-'+packageDetails.quote_id+' .totalAdvance').html(json.advance_sum)
                           $('.advanceTable-'+packageDetails.quote_id+' .totalReversal').html(json.reversal_sum)
                           $('.advanceTable-'+packageDetails.quote_id+' .remaining').html(Number(json.advance_sum) + Number(json.reversal_sum) )
                          
                           
                        }).error(function(xhr, status, error) {
                           $('.updateError').removeClass('hidden');
                        })

                        var api = this.api();

                        var totalArray = {};
                        api.columns().every(function () {

                           packageDetails.totals['extra_discount'] = api.column('extra_discount:name' ).data().reduce( function ( a, b ) {
                                    return (parseFloat(a) + parseFloat(b)).toFixed(2);
                                }, 0 )


                           packageDetails.totals['green_tax_total'] = api.column('green_tax_total:name' ).data().reduce( function ( a, b ) {
                                    return (parseFloat(a) + parseFloat(b)).toFixed(2);
                                }, 0 )

                           //Total for Package Quantity Web
                            // $( api.column( 14 ).footer() ).html(
                            //     api.column( 15 ).data().reduce( function ( a, b ) {
                            //         return (parseFloat(a) + parseFloat(b)).toFixed(2);
                            //     }, 0 )
                            // ); 


                            // $( api.column( 15 ).footer() ).html(
                            //     api.column( 15 ).data().reduce( function ( a, b ) {
                            //         return (parseFloat(a) + parseFloat(b)).toFixed(2);
                            //     }, 0 )
                            // ); 

                            $( api.column( 16 ).footer() ).html(
                                api.column( 16 ).data().reduce( function ( a, b ) {
                                    return (parseFloat(a) + parseFloat(b)).toFixed(2);
                                }, 0 )
                            );  

                             $( api.column( 17 ).footer() ).html(
                                api.column( 17 ).data().reduce( function ( a, b ) {
                                    return (parseFloat(a) + parseFloat(b)).toFixed(2);
                                }, 0 )
                            );                         

                            // //Total for Green Tax Web
                            // $( api.column( 18 ).footer() ).html(
                            //     api.column( 17 ).data().reduce( function ( a, b ) {
                            //         return (parseFloat(a) + parseFloat(b)).toFixed(2);
                            //     }, 0 )
                            // ); 



                            $( api.column( 19 ).footer() ).html(
                                api.column( 19 ).data().reduce( function ( a, b ) {
                                    return (parseFloat(a) + parseFloat(b)).toFixed(2);
                                }, 0 )
                            ); 

                            $( api.column( 20 ).footer() ).html(
                                api.column( 20 ).data().reduce( function ( a, b ) {
                                    return (parseFloat(a) + parseFloat(b)).toFixed(2);
                                }, 0 )
                            ); 

                        });

                        //console.log(packageDetails);
                    }

            })

    
        //  $('.packages_table-'+thisPackage.id).dataTable( {

        // } );

      });

        
      

    }

    changeStatus(params){

        //console.log( params);
       

        //this.packageTable[params.packageId].draw();

        if(params.nextStatus == 4) {
             if(params.invoiceNumber == "" ) {
              var invoiceNumber = getLatestInvoiceNumber(params);

              this.packageDetails['invoiceNumber'] = invoiceNumber;
            }
        }



        this.packageTable[params.packageId].ajax.reload();

        console.log(this.packageTable[params.packageId]);


        this.packageTable[params.packageId].buttons(params.nextStatus+':name').trigger();
    }

    getInvoiceDetailsForm(params){
        //console.log( params);

        var orderDetail = params;

        var form = ''
       
       $.ajax({
            url: "/ajax/getInvoiceDetailsForm",
            type: "post",
            dataType: "text",
            data: orderDetail,
            async:false
        }).success(function(json){
           $('.updateError').addClass('hidden');

           form = json;

           
        }).error(function(xhr, status, error) {
           $('.updateError').removeClass('hidden');
        })


        return form



    }

    getGreenTaxlist(){

        var greenTaxDropDown = "";

        $.ajax({
            url: "/ajax/getGreenTaxList",
            type: "post",
            dataType: "text",
            async:false
        }).success(function(json){
           $('.updateError').addClass('hidden');

            JSON.parse(json).forEach(function(val, index){
                greenTaxDropDown = greenTaxDropDown + 
                  '<li class=""><a class="addGreenTax waves-effect waves-block" data-green_tax_id="'+ val.id +'">'+
                             val.ee_category+' '+ val.name + ': '+ val.value +
                                '</a>'+
                            '</li>'
           })
           
        }).error(function(xhr, status, error) {
           $('.updateError').removeClass('hidden');
        })

        //console.log(greenTaxDropDown);

        return greenTaxDropDown
    }


    itemTypesList(){

        var itemTypesList = "";

        $.ajax({
            url: "/ajax/getItemTypesList",
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

    getPDFData(packageDetails, params, type){

        var that = this;


        //console.log(packageDetails)

        var typeName = "Invoice"

        var generatedDate = packageDetails.invoiceDate

        var fileNumber = packageDetails.invoiceNumber

        if (type == "awb")
        {
            typeName = "AWB"
            generatedDate = packageDetails.awb_date
            fileNumber = packageDetails.quote_id+"-"+packageDetails.packageId
        } else {

                var prefix = "RON";

                if(packageDetails.country !== "RO") {
                        prefix = "EXT"
                }

            fileNumber = prefix+'-'+ packageDetails.invoiceNumber
        }





            var invoiceDetails = [
             
                                        {
                                            columns: 
                                            [
                                                [
                                                    {
                                                        image: "data:image/png;base64,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AAAAABSxirol0rrZvT6lOs65b2yqgEJz4nZrx0lLDpZ6ddK8OPeBcamCprf1uh3jikM3TBUAAAC0rFdeeSXeeuutGDduXMydOzcWL16cH7W1tfnxcevGfmx2lLqKiopo27ZttGnT5gPH6vRW1s962dG+ffvo06dPDBgwIPbaa6/0vwQAAKDpHHvssXHbbbelClbsG9/4Rlx++eWpAgDKQYuG0WdUL4rj/jkiVUCh+fn+vWPPDddKFcLoNDdhdAAAAFrDL3/5y/jTn/4U7777bupQatZdd904+eST44c//GF07tw5dQEAAFaPMDr1cfbZZ8cVV1yRKgCgHLRJry2iZ8c1osMaLfqvBBpg054d0goAAACAUvPaa6/FNttsE9///vcF0Uvc1KlT46KLLoqtt946nnjiidQFAACA5pftFgYAlJcWT4b37tIurYBC0qNj21iv8xqpAgAAAKCUDBkyJPbdd9/8lfIxevToOOigg+K5555LHQAAgMarq6tLK1i52tratAIAykWLh9H791gzrYBCMsDXJrQ4l2oAAABoCePHj4/9998/KisrU4dyUlNTE5/61Kdi5MiRqQMAANA4Jl5THz5PAKD8tHgYfat1O6QVUEgG9PC1CQAAAFCKPv/5z8fUqVNTRTmaNWtWnHDCCakCAAAAAICm0wph9I5pBRSSzXqajA4tz2x0AAAAmtc111wT//3vf1NFOXvuuefi6quvThUAAAA0D5PRAaD8tHgYPQu8tmvrTQcUmk3XFkYHAAAAKCV1dXVxySWXpAoirrvuurQCAABouOzvmfBxamtr0woAKBctHkbPbLVOh7QCCkGPjm1jw67tUwUAAABAKXjiiSdi5MiRqYKIV199NV577bVUAQAANIyJ19RHmzatEkcDAFpR64TR1+2YVkAhGNDDVHQAAACAUvPss8+mFbzv0UcfTSsAAICGMRmd+jAZHQDKTyuF0U1Gh0LSXxgdAAAAoOQMGTIkreB9L774YloBAAA0jMno1IfPEwAoPyajA8LoAAAAACXIttisyNy5c9MKAACgYUxGpz5MRgeA8tMqdyO6d2gbvbu0SxXQ2gYIo0OrcKkGAACA5tS5c+e0gvctXrw4rQAAABrGxGsAAFak1UbjbN+rU1oBralPl3YmowMAAACUIJPRWRET6gAAgMYyGR0AgBVptbsRu/YxlQcKwS6+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H5vW+Y9rXH+Zdkv+R6zdaY1Yu+MacWD/LrH3RmtFzyVryoMwOs1NGB2Kx4wZM/Kn+++66658Avq8efPSGaC5bLvttnHCCSfEF7/4xdhoo41SF4CVufnmm+Pzn/98qgCgYZ544on45Cc/mSqg2L322mvx6KOPxkMPPRSPP/54VFZWpjPQMjbccMP3gum777577LHHHtG1a9d0FihmwujUx9e+9rW4+uqrU0WxygZzZfdH//GPf8TcuXNTFyhnnTt3zu/ffuELX8gnp8PyhNGbwMjK+XHzGzPjPyNmpw6lql3bijh6YPc4bad1U4dSJoxOcxNGh8L2xhtv5NvM3XHHHfHkk0+mLtAadt555/jc5z4Xxx9/vGB6kckm79133315uGn+/Pl5r3v37vk23tmDypSHbEpGnz59YrPNNstDCDSPXXbZJV544YVUAUDDZDsUZX8HBorT22+/HQ8//HA88sgjeQh92rRp6QwUjmzwwJ577hm77bZbHk4fOHBgOgMUE2F06sNk9OKVPcj4l7/8JW699daoqqpKXYCP6tu3b3zpS1+KL3/5y/n9HxBGX00vTJgXP3l0QlQvyuZqUy527t0pvrbzerFJ9/apQykSRqe5CaND4ckmoP/tb3+LP/7xj/kEKaDwZNMajzvuuDycvsEGG6QuheanP/1p/P73v4/p06enDiy10047xa9+9as46KCDUoemkH2trbPOOqkCgMbJggZrrbVWqoBCNmbMmHz3vix8nk0/nzx5cjoDxaNHjx55OD07snB69vByx44d01mgUAmjUx9nnHFGXHXVVami0E2ZMiUPoGf3R4cNG5a6APV38MEHx9lnnx2HH3546lCOhNFXw+1vV8bvn5uSKspNFkT/4T69BdJLmDA6zW2DLu3iJmF0KAh33XVX/PWvf82f8geKx957751PS//85z8fPXv2TF1a0zPPPBMnnniiC9Z8rOyBhR/96EepYnVlW+Z+5jOfSRUANE72d2M3DaEw1dTU5BPPH3zwwXz3qTfffDOdgdKy44475oMIsunpWUi9Xz/3UKDQCKNTHyajF4fsfeWf/vSn+Oc//5k6AKtn0003jbPOOitOPvnk6NKlS+pSLtqkVxpo2Iz58YcXp6aKcjSqckH8/PEJMXXeotQBAIrJO++8E+eff3707t07jjjiCEF0KEL//e9/8wsaa6+9dgwaNCiuu+66mDVrVjpLS/vDH/6QTzITRKc+fvzjH+dTMmgaWTgJAFbXzJkz0wooBFng/LLLLssnzGXTog899NC49NJLBdEpaS+99FK+09oXv/jF6N+/f358+9vfzh/GAABW3/jx4+NnP/tZbLzxxvn7S0F0oCkNHz48zjnnnOjVq1d8/etfjxEjRqQzlANh9Ea6a2hlLFxsqHy5ywLpg99ygR4AikW25fi1116bb/k6cODAuOSSS2LixInpLFDMsm3JTzvttOjevXt86UtfiqeeeiqdoSX8/e9/j6997WupgvrJpiNlD5EAAIWhuro6rYDWkF23yibNnnHGGXk4aOutt45zzz03HnjggfQRUH5GjhwZv/3tb2P//fePHj16xP/8z//E4MGDY968eekjAID6uP322+Owww6Lvn375oNCxowZk84ANL3s/Xr2kOmAAQPywYDZgDFKnzB6IwydXhN3DTVtj6UGv1WZT8oHaDDPNEGLeeWVV+KUU07Jn8A9/fTT49lnn01ngFJ000035Vs6Z1s733DDDUI1zSy7oPSNb3wjVdAw2e4G48aNSxWNVVFRkVYA0HiCfdDyZsyYEddff30+/bxnz55x7LHHxjXXXCMcBCtQWVkZf/3rX+OYY47Jd8nLQi3ZdZ9p06aljwBaQl2dG5xQLGbPnp3vrJOFQY8++ui499570xmAlnPXXXfFPvvsE3vttVe+pnQJozfCcMFjlrOoti6eGjsnVQBAoaipqYk//elPscsuu8QOO+yQ35hwYx3Ky8svv5w/iLL++uvHN7/5TVvBNZMrrrgipk6dmipomIULF8YPf/jDVAEAralNG7eMoCVMmTIlrrrqqjjggAPyQO2pp56aTz9ftGhR+gjg42TXfrMgS3bdZ911140999wzLr744nj77bfTRwDNxQPxUPjeeeedfDhXdm/kW9/6lnsjQEF48skn8wdKt9lmm7jxxhtTl1LiymIjjJ61IK1gqefHz00rAKC1DR06NM4+++x8CvpXvvKVeOGFF9IZoFxlW51ffvnl+fSPQw45JO644450hqaQPfgDq+Mvf/lLPuEOAABKVbYbUPb30r333jsPBWU7BD3yyCPpLLC6nn766fjOd74TW265ZQwcODDOP//8eOaZZ9JZACgP//rXv/IHHrPvhddee23+8BZAoRkyZEicdNJJ0a9fv7j66qv9WVVChNEbYdh0XwB80FvTfE4AQGu79dZb8wssW2yxRVx55ZUxa9asdAbgfffff38ceeSRsfHGG8fvf/97FzhW05w5c2LYsGGpgsa7++6704rGsEU2AE1h8eLFaQU0hbFjx8Yll1wSu+++e2y44Yb5jl1PPPFEOgs0l2wabPa1t8cee8Qmm2ySh9RfeumldBaAlmDXpZYzY8aM+OUvfxkbbbRRfPazn/XAI1A0Ro0aFWeeeWb0798/3+We4ue7fyMMnTE/rQAAaE3Tp0+Pn/3sZ7HBBhvEcccd5wILUG9jxoyJr3/96/kF2gsvvNADLI00d65domgaDz30UFoBAEDxqq6ujptuuikGDRqU/30zm8787LPPprNASxs9enRcfPHFsdNOO+VT07NrycOHD09nAWguFRUVaUVzmTp1apx33nn5Q4/f//738wchAYrRxIkT45RTTsnfr2c7PFC8hNEbqGZRbVQvrE0VADSe2YXQeG+++Wb+F5K+ffvGj3/845g0aVI6A9Aw2QXbH/zgB/mk9O9973t5Tf1VVVWlFayed999N61ojNpa16oAAFrT008/Haeeemr06tUrvvSlL3nYEgrQ22+/nV9L3myzzfJwejY9XXAPGs7ubNSHa1XNJwttfuMb38jvafzmN7+JefPmpTMAxS17v57t8JDtLvbCCy+kLsVEGL2B5i7whgkAoLXcdddd8alPfSq23nrrfKummpqadAZg9WST0X/1q1/FeuutF+ecc06MGzcunWFVTEanqUyYMCGtaAzTpgAAWt748ePj17/+dWy66aax5557xvXXXx+zZ89OZ4FC9tJLL+U7F2Q7GHzyk5+MK6+8MqZMmZLOAqviGgT14fOk6WW7vZ5++unRu3fvuOKKK/IdeQBKUba72C677JLvjG+QUXERRm+gOaaiAwC0qOxiyrXXXptvy3TEEUfEgw8+mM4ANI/f/e53+daWX/7yl23d/DFMXaGptGvXLq1oDNOmAABazt///vc45JBD8h37vvvd77o5DkXuqaeeirPPPjvWX3/9GDRoUPzxj3/MhxYA0HjC6E0nu0dx0kkn5ZPQs/ulAOXi1ltvzR/+znaD8OB3cRBGbyCT0QEAWkY2ieb73/9+/oR/9qR/ti0TQEv6y1/+km/dnIXSs4l3fJTJ6DSVjh07phUAABSebPesCy64ILp37x5f+MIX4v77709ngFLy0EMPxVe/+tX8a/3EE0+Mxx9/PJ0BgJY1dOjQ/H1ndo/ixhtvTF2A8pPtBjFgwID8vi2FTRi9gRbW1qUVAADNIQuhf+tb34pNNtkkfvnLX0ZlZWU6A9A6sosb2ZP33/nOdzx5/yFVVVVpBavHtKTVU1fnehUAq89OG/BRjz32WBx77LH5daqLLrrItGQoI//7v/8b++67bwwcODAuvfTSmDFjRjoD5c01COrD50njTZ06NR/StfXWW+c78gAQMW3atHx42G677RYvvfRS6lJohNEBACgIy4fQs4v71dXV6QxA66upqYmLL744/zPqN7/5TV5jMjoUCjf4AACazvz58+OGG26I7bffPvbbb7+47bbbYvHixeksUG7eeeed/Lp1toNnNqH20UcfTWcAWBmDJxouu9b+k5/8JPr37x/XXnttLFq0KJ0BYJnnnnsudtlll/yhnenTp6cuhUIYHQCAVpWF0L/5zW/GxhtvLIQOFLyZM2fGeeedF5tvvnn89a9/Td3yJYwOhcENPgCagu8nlLvx48fHd7/73ejbt2+ccsop8eqrr6YzAEsfVMkm1O6///75daHrrrsunYHy4j0j9eHzpGGy8PmAAQPipz/9acyZMyd1AViRbGe/7M/N7D159krhEEYHAKBVLB9Cv/zyy00ZBorK2LFj43/+539i2223jXvuuSd1y8+8efPSCgAAoDg9/fTTceyxx+Yh9F//+tf59t8AqzJs2LA47bTTolevXvkOelVVVekMANTfHXfcEVtssUU+4Xfy5MmpC0B9zJgxI//zc4899sh3M6L1CaMDQCuxkT7lKruhJ4QOlIo33ngjDj/88Nh3333j7bffTt3y4c9wKAx1df52AQDQUA8//HAccMABseeee8Ztt92WugD1lwUHsx30sodZvv3tbwsSAlAvzz77bHzyk5+MI488MoYOHZq6ADTGM888EwMHDowLL7wwdWgtwugAALSIBQsWxEUXXZRvMyeEDpSaxx9/PD7xiU/E9773PX++AS0u25YSAFaX7yeUi7vvvjufnHbggQfGI488kroAjTd79uz47W9/mw9g+drXvhYjR45MZ6D0eCAeGi/bNfrEE0/M34s+9dRTqQtAU/jBD36Q36t95ZVXUoeWJowOAECzu+WWW/Jt5i644IL8wjxAKVq4cGH86le/is033zzuv//+1C1tbdq4rAAAUCoEiyhl2ef34MGDY8cdd4xPf/rT+eQ0gKY2f/78+MMf/hCbbbZZnHTSSULpAOSyewcXX3xxbLrppvG///u//u4F0Exef/312HnnneM73/lO/t6cluWuMQC0Fn/HpAy88MIL+VbHJ5xwQowaNSp1AUrb2LFj45BDDoljjz02X5cyYXQAAKDQ3XjjjfmW3cccc0y8/PLLqQvQfBYvXpz/2dO/f//4yle+EmPGjElnoPhVVFSkFayc68bvu/fee/OBXVkwsqqqKnUBaC7Ze/HsAaAtt9wynn766dSlJfjuDwBAk8vCl5///Odjl1128QYfKFu33XZbHnjILngsWrQodUuLmwpQGGpra9MKAIBM9newP//5z/nOVdl04qFDh6YzAC3rT3/6Uz4J99RTTxVKpySY6Ex9+DyJGDFiRL4jz2GHHWanDIBWkP3Zu88++8RFF13k+1ILcdcYAIAmkz3R/93vfje/0XfzzTenLkD5mjdvXj7xZJtttomnnnoqdUuHMDoAQOlwY45S8e9//zu22mqrOPnkk2PYsGGpC9B6Fi5cGNdff31sttlmccYZZ8T48ePTGQBKzdy5c/N7AtlE3rvvvjt1AWgN2YPqF1xwQRx44IExbdq01KW5uGvcQDYcAgBYsRtuuCEGDBgQv/71r6OmpiZ1Aci888478clPfjLOOuuskvozUhgdCoMtsgFoCr6fUOyGDBkSgwYNiqOOOkoIHShICxYsiGuuuSb69u0b5513XsyePTudgeLhPSP1Ua7Xje+44478waNst9Tsz3wACsMjjzwSn/jEJ+Kxxx5LHZqDu8YAAKyW1157LXbbbbc45ZRTYurUqakLwIpcddVV+cWO559/PnWKmzA6FIba2tq0AoDGMxmdYpVNNzv99NNju+22i4ceeih1AQrbb37zm+jXr19cfvnl+eR0KBbeM1If5fZ5kr0fPeGEE+LII4+MiRMnpi4AhST78zmbkP6zn/3MPZVm4q4xALSSuiX/gWI2a9asfMJvdqPvueeeS10APk42oW/XXXeNn/zkJ6lTvNq2bZtWQGtyIxgAKFeXXnppbLrppnHttdfG4sWLUxegOMyYMSO++c1vxhZbbBG33HJL6kJhMxmd+iinz5N//OMfMXDgQH+OAxSB7LrBj3/849h///1j8uTJqUtTEUYHAKDBbrzxxvwCeTbhF4DG+elPfxo77rij7eMBACgIHm6imNx+++2x2Wabxbe+9a18YAJAMRs5cmQ+UXeXXXaJJ598MnWhMHnPSH2Uw+fJlClT4tOf/nQcf/zxMX369NQFoBg8/vjj+T3al19+OXVoCsLoAADU25tvvhn77rtvnHTSSZ4UBWgC2UWOzTffPK644orUKS4mowMAlA5TLikGQ4YMiUGDBsXRRx8dw4cPT12A0vDCCy/EXnvtFcccc0xMnDgxdaGweM9IfbRpU9pxtD//+c/50K677747dQAoNhMmTMgD6TfddFPqsLqE0QEA+Fhz5syJc889N7bbbrv8KVEAmtY3vvGNPFAxfvz41CkObj5BYaitrU0rAGg8308oZNm1qa9//ev5tamHHnoodQFK0+DBg/OQ45VXXmkKNQXH5yT1UaqfJ+PGjYsDDjggTj755KisrExdAIrZl770pTj//PNdF2sCwugAAKzSAw88EAMHDozLLrssFi1alLoANLUsULHNNtvEvffemzqFz2R0KAweDAGgKZT69EKK19///vfYbLPN4ve//30sXrw4dQFKW1VVVZx99tmx++67x+uvv5660Ppcg6A+SvHz5IYbboitttoqHnnkkdQBoFRccsklceihh8bs2bNTh8ZwZREAgBWaO3dunHrqqXHwwQcX3aRegGKVTVP59Kc/HRdddFHqFDY3n6AwmNgBQFPw/YRCM2rUqDjwwAPjC1/4QkyaNCl1AcrLc889FzvuuGN85zvfierq6tSF1mMyOuUmu2b/mc98Jk455ZT8QSEASlM2pHGnnXaKt99+O3VoKGF0AAA+Inuqf+utt47rr78+dQBoKVkI6IILLojjjz8+5s2bl7qFyWR0KAwm2QLQFDxoSCH54Q9/GP369YuHH344dQDKV7Zj6cUXXxxbbrll3H///akLrcN7RsrJgw8+mE9Dv/POO1MHgFI2fPjw2HXXXePRRx9NHRrCnSoAaCXmBlCIsskqZ555Zj51avTo0akLQGv4xz/+EbvttluMHTs2dQqPm09QGBYvXpxWANB4JqNTCLLweRZC/8UvfpE6ACyTXbM/5JBD4ktf+lLMnDkzdaFlmYxOOViwYEGcc845+e7REydOTF0AykG2C0b2nvvf//536lBfwugAAOSeffbZ/On+q6++2sVEgALxxhtvxA477BBPPfVU6hQW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APV1/PHHx7333puq1XfZZZelFQAAUC6+//3vx2mnnZYqAErNL37xizj11FNTBdA4CxcuTKvmVV1dHYMGDYo77rgjdQCgMHzrW98qu+GSwugA0FoMm6IR7rnnnthnn31i6tSpqQMA9XfMMcfEU089larGe/755+OWW25JFdDaKioq0goAGs/3Ez7O//zP/8Qvf/nLVAFQqq6//vr47Gc/myqAhlu8eHFaNZ+qqqo8iP7QQw+lDgAUli9+8Ysxbdq0VJU+YXQAgCKRbYF8+OGH2wIZgEbLJsVk30tGjhyZOg03Y8aMfMo6UDjq6jzpCsDq8/2ElZkzZ04cfPDB8de//jV1ACh1//rXv2KvvfaKysrK1AGov9ra2rRqHjNnzoz999+/SQavAEBzmThxYv5gf7kQRgcAKALf/e53bYEMQJPIbiJmgfQsVN5QTz/9dGy99darFWYHAACKx5QpU2LvvfeOBx54IHUAKBdPPvlk/j1g0qRJqQNQP80ZRs92j852kX7xxRdTBwAK19133x1XXnllqkqbMDoAQIH7/Oc/H7/+9a9TBQCr76233ortt98+nnnmmdRZtVmzZsW5554be+65pxuQAABQJoYPHx677bZbvPLKK6kDQLl544038utBY8eOTR2Aj5ft0NkcJkyYkP+ZlP3ZBADF4uyzz44hQ4akqnQJowMAFKgs+Jc92X/zzTenDgA0newm4h577BEnnXRS3Hnnnan7QQ899FB+gWSDDTaIyy67LHUBAChFFRUVaQWRP7iaBdFHjRqVOgCUq2yHvOwa0tChQ1MHYNWqqqrSqulkfxZlQfTsgUkAKDaf+9znoqamJlWlSRgdAFpJXXqFFcm2QM4uqPz3v/9NHQBoHjfeeGN85jOfycNHHz4GDRqUbx3XXJNsAACAwnPXXXfFAQccEDNmzEgdAMrd+PHjY6+99orXX389dQBWrql313znnXfyP4NGjx6dOgBQXN5888345je/marSJIwOAFBgxowZk08Zyd6MAgDAx6mr86grANA07rjjjjjiiCM8kArAR0ydOjX23nvveP7551MHYMWGDRuWVqvvlVdeyQd4TZgwIXUAoDj94Q9/iH//+9+pKj3C6AAABeStt96K3XffPUaMGJE6AACwam3auMQHAKy+22+/PY488shUAcBHzZo1K98947HHHksdgI/KJqNPmzYtVY339NNPx3777WfHHgBKxqmnnlqy39fcqQIAKBAvvfRSvsXcxIkTUwcAAAAAml8WRD/66KNTBQArN2fOnDwc+uCDD6YOwEc98MADadU4//nPf/KHX7KHYACgVEyZMiW++tWvpqq0CKMDABQAT/YDAAAA0BoE0QFojE996lPx7LPPpgrgg/71r3+lVcP9+9//joMOOihqampSBwBKx+DBg+OWW25JVekQRm+givQKANBUHnrooTjwwAOjqqoqdQAAoP7q6urSCgAar6LCHZBylIWEjj322FQBQMMccsghMWTIkFRRDlyDoL5uvfXWeP7551NVf9lEde9PASh1Z5xxRj4lvZQIowMAtKLsicdBgwZFdXV16gAAQMMIDwLQFNq0ccuo3Pzzn/+Mz372s7F48eLUAYCGqayszO9xjBw5MnUoda5B0BBf/OIXY/Lkyan6eHfffXccddRRsWjRotQBgNI0Y8aM+PKXv5yq0uDKIgBAK7n55pvjmGOOSRUAAABA6xEsKi/ZdtCf+9znUgUAjTdp0qQ46KCDGhQ4BcrD0KFDY6+99ooRI0akzoplQ7suvPDC+PSnP22AFwBl45577okbb7wxVcVPGB0AWkndkv9Qvm677bb4/Oc/nyoAAGg84UEAmkJdnWtV5SIbkHDCCSekCgBW37vvvpsH0mfNmpU6AEsNHz48BgwYEN/4xjdi5syZqbvUtGnT4ic/+UlsuOGG8YMf/CB1AaB8nHXWWTFhwoRUFTdh9IZybw8AWE233357HHvssakCAIDV06aNS3wAQP3cfffdBiQA0Cxef/31OOyww6KmpiZ1AN53xRVXRM+ePWO33XaLfffdN/r37x/rrrtu/PSnP43p06enjwKA8lJVVRXnn39+qoqbO1UAAC3ovvvui+OOOy5VAACw+mpra9MKABrPZPTS9/LLLxuQAECzeuqpp+L444/3vqKE+b1ldT333HPx+OOPx8iRI1MHAMrb3/72t3jmmWdSVbyE0QGgtbhWU3YefvjhOPLII2PRokWpAwAAAFAYKipsDVvKxowZEwcddJBptQA0uzvuuCMuuOCCVAEAAB/njDPOSKviJYwOANACsiD64YcfHgsWLEgdAABoGsKDAMCqTJ8+PQ444ID8FQBawsUXXxw33XRTqgAAgFXJdrP7v//7v1QVJ2F0AIBm9sQTT+RBdJOnAAAAAGhJ2fWobCL6u+++mzoA0DJOPvnkePLJJ1MFAACsynnnnRfz589PVfERRgcAaEbPPPNMfOpTnxJEBwCg2ZiMDkBT8P2kNH3uc5/Lp2sBQEtbuHBhfPrTn/ZAVInxnhEAoHlMmDAhLr300lQVH2F0AGgldemV0vXOO+/EoYceGtXV1akDAAAAAC3jlFNOiTvvvDNVANDyKisr47DDDovZs2enDsWurs4dTgCA5nLJJZcUbcZIGB0AoBlMmjQpBg0alF9oBQCA5mQqGQDwYRdddFHccMMNqQKA1jN06NA49thjU0Wxcw0CAKD5zJw5M6655ppUFRdhdACAJlZVVRX77bdfjBs3LnUAAKD5mEoGACzvn//8Z1xwwQWpAoDW9+CDD/reVCJcgwAAaF6//e1vY8GCBakqHhVL3ih6p9gAb06tjrPvHZsqeN9DJ26eVpSKVyfNi3MfECSl+XTv0DZu+9yAVFEqampq4qCDDoonnngidQAA+Dg77bRTvPDCC6miof7whz/E1772tVQBQONk2wB/+9vfThXF6sUXX4ydd945VVA+OnbsGBtuuGH06dMnX3fq1OkDx1prrRUdOnT4QK9z5875a/v27dPP8lG1tbXRps1H57vNnz8/5s6dmx9z5sx5bz116tSYPHly/prtnjllypR8sh2w1F133RWHH354qihG2ZT72267LVUAADSHa6+9Nk499dRUFQdh9AYSRmdlhNFLjzA6zU0YvTQdffTRcfvtt6cKAID6EEZfPcLoADSFiy++OM4777xUUYyy0Gv2vspufZSqjTfeOAYOHBjbbLNNbLTRRh841llnnfRRhWn27NkfCa9nofWRI0fGiBEj3juGDh2afgSUpu7du8fLL78cm2yySepQbITRAQCaX/Z+Ofv7YjERRm8gYXRWRhi99Aij09yE0UtPFgDKgkAAADSMMPrqySZknH766akCgMYxGb347bfffvHYY4+lCopTNr08C5xvscUWseWWW+avm222Wf53hnIxduzYPHTw7rvvvveaHa+++mq+MycUO9cAipswOlAKevXqFT179syP7EGp7LVHjx7vvS5bd+nSJd91Jzuy96kfXjeFbEed7MHF7KiqqopZs2blr8t62YOMy16XP7IHG7OdeCorK9PPBJSav//973HCCSekqvAJozfQm1Nr4ux7x6QK3ieMXnqE0Wluwuil5cILL4wf/OAHqQIAoCF22223eOaZZ1JFQ/3xj3+Mr371q6kCgMYRRi9u55xzTvzud79LFRSHDTbYIPbaa6/YY4893gue9+vXL51lRYYNGxZvvvlmvPLKK/l06SFDhsTw4cPTWSgeZ555Zlx55ZWpopgIowOFqHPnztG7d+/o06dP/tq3b988cJ6ts/ecy4fMO3XqlH5U6Rg9enQeTF92ZLtmTZw4MV9PmDAhfw85Y8aM9NFAsdh7773j8ccfT1XhE0ZvIGF0VkYYvfQIo9PchNFLR3bRLbv4BgBA4+y6667x7LPPpoqGuv766+PUU09NFQA0zsUXXxznnXdeqigm2aSsL3zhC6mCwrXNNtvkN9Oz8Hn2mm07zuqrrq7Op6a/9tpreVD9xRdfjCeeeCKdhcJ18803x/HHH58qioUwOtBasmD5pptuGv379893zsleBwwYkB9Z2JxVy6arDx06NH+QcdmR7b6TBdWzKetAYXrrrbfy3cOKgTB6AwmjszLC6KVHGJ3m1q1D2xgsjF70sskzWXhq3rx5qQMAQEMJo68eYXQAmoIwenHKAqi777571NTUpA4Ujm7dusVBBx0URx99dP667rrrpjO0hOeeey6eeuqp/MjC6dl0TCgk2RTbbMJ/FiikeAijA80tC51vu+22sfXWW+cPMy47/j979wFmVXn1C/ylqFQBBaWJDUXsoqBYsXcj9hZr7FGMGnvsNTH2ktg1Bjt2xIIlRiyImqixYBe7FOmfZebefVwGjYAMnH5+v+/hmf96Z/J9z83ds+fsvddeb/PmzeMnyLes1+H111/P/ct24MmuM1944YX05Zdfxk8ApXLooYdWzE54mtEbSDM6M6IZvfpoRqfQNKNXvrFjx6ZevXql9957L1YAAJgdmtHnjGZ0APLhT3/6UzryyCOjohKMHj06rbjiimnUKPexKR/ZZ/tNN900bbzxxrkJ6JSPrLnokUceSQ8//HDuqwErlINVVlklDR8+PCoqgWZ0IF+yFxdXWGGFnzScL7/88rl1ysPHH3/838b0rEk9e4ksm6YOFE/btm1zLxY3a9YsVsqXZvQG0ozOjGhGrz6a0Sk0zeiVL3ug8tBDD0UFMOtatGiR5pprrjT33HPn/k0v/9IFZbYFc/Yve3D4w9dx48bFdwEqy6qrrpqeeeaZqGioq666Ku27775RAcDs0YxeeTbYYIM0dOjQqKB01lhjjbTNNtuk7bffPi200EKxSrl74okn0gMPPJD+9re/5RqNoFROOeWUdOKJJ0ZFudOMDsyOnj17ppVWWik36C1rOM+mnmcT0Kk8EydOzDWlP/nkk7ndd7J/EyZMiO8ChXD99den3XffParypRm9gTSjMyOa0auPZnQKTTN6ZTv66KNz21cDtaVdu3ZpwQUXTJ06dcptLZ3l9u3b57aUbdWq1U++Ti9n/4rhiy++yE3I+99/2Y4OP3xvzJgxue31smybZqDUTEafMyajA5APmtEri3tTlFq/fv1S//790w477JA6duwYq1SqIUOGpBtuuCHddNNNsQLF9fzzz6eVV145KsqZZnTgl2TP0LKdL1ZbbbXUu3fv3CCSeeedN75LNcqmpmdN6dkOPNm/bIgWkD/ZrmPDhg2LqnxpRm8gzejMiGb06qMZnUJrM0+TNGhHzeiV6Pbbb89N+QGqS/fu3dPiiy+eFltssbTwwgunBRZYINds/sO/rl27xk9Wp88++yy9+eabuX/ZFnuvvfZaLv/nP/+JnwAonOyhxHPPPRcVDWUyOgD5oBm9cjzyyCNpww03jAqKJ7s3stdee+U+e5qAXp2yqZbZpPTsn92rKKallloqdz+S8qcZHfhf2W7A6667btpoo43S1ltvnbp16xbfoVZlu8tnO/Dcd9996a233opVYE5kv0tZL0M504zeQJrRmRHN6NVHMzqFphm9Mr3yyiu5yZ3e5oXK06ZNm/82m2dff5yzG2ONGzeOn+THskvG999//7+N6m+88cZ/8wcffJDq6uriJwFmXzYpZ/jw4VHRUCajA5APmtErQ7bDVbbFffYViiHb7W3bbbdNe+65Z24aeqNGjeI7VLvsHtC1116bm5huVz2K4bDDDkvnn39+VJSr7G/CoEGDogJq1XLLLZc23njjtMkmm6S11147zTXXXPEd+Kl333033XPPPen+++9PTzzxRPr666/jO0BDnHDCCem0006LqjxpRm8gzejMiGb06qMZnULTjF55xowZk9sm8r333osVoBx17tw592B+mWWWST169Mjl7J8towvj5Zdf/kmj+g/N6tk5E2BWmYw+Z0xGByAfNKNXhs022yw3YQ4KrX379rnG0N/+9re5F/ypbdlUy+wl2KyRCArpH//4R1prrbWiohyZjA61ad55500bbLBBrvl8iy22SJ06dYrvwKybNGlSbmr6nXfemduJB5h1iyyySO7ljnKmGb2BNKMzI5rRq49mdApNM3rl2XzzzdPgwYOjAsrBwgsvnFZfffXUt2/f3K4FSy+9dGrdunV8l1LKpqY/++yz6Z///Gd66qmn0ogRI+I7AD+XncOzcwazRzM6APlw3nnnpd/97ndRUY4uvfTSXGMwFNJCCy2Ujj766LTPPvukZs2axSp87+23304XXHBBbmJ61kwE+ZbtYPmf//wntysD5UkzOtSOlVZaKdd8nr0Qu+aaa8Yq5Me4ceNyDemXXHJJbsgV8Muy5+5rrLFGVOXHPvQNZOM5APLF22CVJbvBrhEdSi9rOs8m9d1+++3ps88+y+1UMHDgwHTIIYekVVddVSN6GckeHG2//fbpwgsvTM8//3yaPHlyeuyxx9KZZ56Zu3HZtm3b+EkAAAB+SdaYpxGdQlpqqaXS9ddfn3u5/OCDD9aIznQtvvji6eKLL04ff/xxbkeN7OUFyKfsHHTsscdGBUCxrbvuurnnOp988kl64YUXcs90NKJTCNlzwuz5brbjctZgu8cee8R3gBm58cYbI5UnzegAAL/gpZdeMhkMSmS11VZLxx13XHrkkUdStqnTsGHDcg+6tt1227TAAgvET1EJmjdvnvr165d7mHT//fensWPHpldeeSVdccUVac8990w9e/aMnwQAAODHpk6dmnbYYYeoIL+yl8lvuOGG9Nprr6Xdd989VmHm5p133tzAiKxx+Oqrr87tXgj5kr3w8OKLL0YFQKFlA4SyXU9Gjx6dHn300XTooYemjh07xneh8LJJz9ddd11uWnq2I1j2oizwczfffHOk8qQZHQBgJrJJvtmWg0BxLLfccrmXP+655540YcKE9PTTT6czzjgjrb/++vETVJNlllkm7bvvvrmbnNmUvw8//DBddNFFaaONNoqfAGBWNGnSJBIAUI2OOuqo9Oqrr0YF+dGuXbvcbpDvv/9++vWvfx2r0HB77713bvfCrCndpHTyZf/9948EQL5lw4P69++f/v73v+eexWUDhLKhQfPNN1/8BJRGmzZt0kEHHZR7UfaJJ55IO+20U3wHyGQvbDz88MNRlR/N6A3VKL4CADUha5J8++23owLyrUWLFulXv/pV7m33zz//PP373/9O5513Xtpyyy1Tq1at4qeoFV27ds1tyffggw/mboDedtttuel/rVu3jp8AAACoLYMHD85NiIV8yZqPTj755NxE6wEDBsQqzLmsKT07ri6//HLNbMyx4cOH53ZUBCA/WrZsmXvecscdd6Qvv/wyDRo0KO2yyy6exVG21l577XTTTTelt956K/c5E/jefffdF6n8aEYHAJiBbHvagQMHRgXky2KLLZZ72Jk1HE+aNCndddddaY899kgdOnSIn4CUuwGa7Uxxyy23pPHjx+fe8v7tb3+ba1gHqk+jRt7+nxP++wMgH/w9KT9jx45Ne+21V1Qw53bcccc0cuTIdNJJJ2k8omAOOOCA3HGWfYU5cfTRR+caJgGYfdlk6bvvvjtNnDgx97xlm222yQ2Kgkqx+OKL53bg+fTTT3OfDbIXK6CW3XvvvZHKj2Z0AIDpePPNN9OBBx4YFTCnunXrlv7whz+kl19+ObfbQLYN9EYbbRTfhV+2wQYb5KYBfvjhh+nZZ59Nxx9/fFpmmWXiu0Clq6+vj8Ts8N8fAFSnww47LLeLGMyp7t27p0cffTTdfPPNqUuXLrEKhZNNRs8mpL/44oupb9++sQoNM27cuHTMMcdEBcCsyp7JnXPOOblriWyy9FZbbRXfgcq14IILprPPPju9//776fDDD49VqD3vvvtueu2116IqL5rRAQCmI5sSNHny5KiA2ZFN2Npvv/3SE088kbsxcOqpp6Zll102vguzr0+fPun0009Pr7zySnr99ddzLzosssgi8V0AAIDKl+0Ole3aB3Mim3p53nnn5aZUr7vuurEKxbPiiiumYcOGpSuuuCI1b948VmHWZZNQn3766agAmJlsCnp2HZE9kzvqqKPsSExVmn/++dOf//znNGrUqNxzaKhF9913X6TyohkdAOB//O53v0svvfRSVEBDbbrpprlJWxMmTEh//etf09prrx3fgfzr0aNH7kWH7C3wp556Kh166KG5G1EAAACVasqUKWnfffeNCmbPmmuumXuBO7vXCaWWndP+9a9/pV69esUKzLoDDjggEgD/K9uN5JRTTkmffvppbgp6tsss1IJsx6fsOXR2zbPxxhvHKtQGzegAwE/YSL88Pf744+mCCy6ICphVnTt3zt3s+vjjj9PgwYNzuwtAsa2++urpwgsvTF9++WW6//770zbbbBPfAahujRo1igQAVIPjjz8+N80QZtcZZ5yRnnzyybTQQgvFCpTeEksskUaMGJGOOeaYWIFZ8+9//ztde+21UQGQWXLJJdOVV16ZRo8enU488cS04IILxnegtmRDq4YMGZIGDRqUunbtGqtQ3f7xj3+kSZMmRVU+NKMDAITx48enXXbZJSrglzRu3Dhtttlm6Z577kkffvhh7mZXp06d4rtQWtmxeccdd6RPPvkknXbaaWnhhReO7wDlqK6uLhKzo77eq64AUC2y3foMSmB2Zde+zz33XDruuONiBcrPWWedlR5++OHcJFeYVdlLDFOnTo0KoHZtuOGG6YEHHkhvvPFG+s1vfhOrQP/+/dPIkSNzz6ubNWsWq1C9sh3Dy41mdACAMGDAgFzTIjBz2XSFY489Nr3zzju56dNbbrllrjEdylHHjh3TCSeckN57773c8br55pvHd4By4u/InDEZHQCqx2677eZFM2bLzjvvnF5++eXUu3fvWIHytcEGG+SO1759+8YKzNznn3+ezj///KgAas92222X+9v50EMPpU022SRWgR/LmtCznbyzXVV8zqTaZbuhlRtP+gCgVDxTKit33XVXuu6666ICpmfZZZdNN9xwQ/r000/TmWeeadI0FSebln7fffelt99+Ox144IGpefPm8R0AAKBJkyaRKJUzzjgjvfrqq1HBrLv44ovTwIEDU+vWrWMFyl/nzp3TsGHD0hFHHBErMHPZVP3Ro0dHBVAbsib07Brhtttuyz2nA37ZEksskfuceeGFF5qSTtX6xz/+Eal8aEZvIHOmAKD6fPHFF2nvvfeOCvhfG220UXrwwQdzExd+/etfxypUrsUWWyxddtllud0wzj777NSlS5f4DlAqdXV1kQCAUvH3uLTeeuutdOqpp0YFs2b++efPPYD+7W9/GytQec4999x09dVX2zGLXzRhwoR08sknRwVQvbJdEHfYYYf/NqEvvfTS8R2gIQ499ND02muvpX79+sUKVI/shYtvv/02qvLgig4AqHlZI/rYsWOjAn6w1157pVdeeSXXiJ41pEO1adOmTTr66KPTqFGjclP/e/bsGd8Bis0k1jmTPaACgDnl73Fp7bPPPunrr7+OCn7ZyiuvnF566aW01lprxQpUruwe/T333JNatGgRKzB9l1xySW7XQ4Bq1b9//9yzuVtuuUUTOuTBIosskh577LF0yimnxApUh6wR/ZlnnomqPGhGBwBq2jXXXJPuu+++qIBMNk0rmxid/X4ss8wysQrVLZv6/5///McNXqAiaR4EgMp2xx13lOX2ypSv7Br2+eefT127do0VqHybb755evLJJ3MT/2Fmjj322EgA1aNv377pqaeeSoMGDfKMAgrgxBNPTHfeeWdq2bJlrEDlK7d7SZrRAYCa9eGHH6YBAwZEBey+++7p3XffTRdffHHq2LFjrEJt+WHry6wZxKR0KJ76+vpIzI5vvvkmEgDMvqZNm0ai2I444ohI8Muyreaz3b2gGvXq1SsNGTLEhHRm6rbbbsu9kANQDZZYYolcA/qwYcPS6quvHqtAIWy99da5lz681Eu1eO655yKVB83oAFAi9f//fyit7MHNxIkTo4LatdVWW6WXX345XX/99bmtyoCUttlmm9yk9KwpvXv37rEKUJ7atGkTCQBmn8a/0jjrrLPS+++/HxXM3AknnJAuvPDCqKA6rbLKKumuu+6KCqbvjDPOiARQmVq3bp0uueSS9Oabb6b+/fvHKlBoK6ywQnrhhRe8/EFVKLcXNDWjAwA16YEHHnBDm5q3xhprpKeffjrdfffdadlll41V4MeypvSRI0fmHva3bds2VgHKS7aNLwDMKX9Piu/TTz9Np59+elQwc2effXY67bTTooLqtuGGG6aBAwdGBT+XPd957bXXogKoLLvttlt666230sEHHxwrQDF16NAhNyF9r732ihWoTB999FH67LPPoio9zegAQM2ZOnWqi3tq2lJLLZW7Wf/Pf/4zrbbaarEKzEy2m0Z2c3j//fePFSCfGjVqFInZ0alTp9zfdwCYXV26dMltD09xHXvssWny5MlRwYxlUzOPPvroqKA27LzzzumPf/xjVPBz55xzTiSAyrDMMsukJ598Mv3tb39LCyywQKwCpXLNNdek/fbbLyqoTMOHD49UeprRAYCak00Revfdd6OC2pHd2LriiityE2N+9atfxSowq+aff/70l7/8Jf373/9O/fr1i1UgH+rr6yMxuw455JBIANBwXrosvmwr5euuuy4qmLErr7zSYA1q1u9//3sTK5mh66+/Pn3wwQdRAZSv5s2bpz//+c/plVdeSWuuuWasAuXgr3/9q8+bVLTs/lK50IwOANSUd955J51yyilRQW1o0aJF7rh/77330r777hurwOxabrnl0mOPPZZuueUW00uAsrHnnnum+eabLyoAmHVZY8Rvf/vbqCiWbPcl+CUXXHBB+s1vfhMV1KZsYqWhAMzIn/70p0gA5SkbDjVy5Mh0+OGHxwpQbrLPm7vuumtUUFlMRgcAKJGDDjooEtSGAw44INeEfuKJJ+YaDID82WGHHdKbb76pMQAoC9nLZ1dffXVUADDrLrrootSuXbuoKIabbropPf3001HB9J122mlpwIABUUFtGzRoUOrevXtUMM0ll1ySRo8eHRVA+Vh44YXT4MGD01133ZW6dOkSq0C5uvHGG9P2228fFVSOf/3rX5FKTzM6AFAzshvWDz74YFRQ3RZbbLH01FNPpcsvvzx16NAhVoF8a9OmTW7L9Oz3rWfPnrEKNFSjRo0iMSe23nrrdPDBB0cFAL/ssMMO83JlCRx11FGRYPqOPvrodMIJJ0QFZC9NZc182Uu48L+uuuqqSADlIdsF6fXXX0+bbrpprACV4NZbb03bbLNNVFAZPvroo/TVV19FVVqa0QGgROrjK8UxefJkW05TMw455JD0yiuvpNVXXz1WgELLft/+85//pDPOOCNWgIaor/fpOF+yqXDHHntsVAAwY6effno6//zzo6JYLr744jRq1Kio4OcOPPDAdPbZZ0cF/GCZZZZJ11xzTVQwTbbLC0A5aNu2bbrnnnvShRdemJo1axarQCW544470iqrrBIVVIaXX345UmlpRgcAakK2re0nn3wSFVSnrl27pkcffTR387158+axChTTcccdl0aOHJl69+4dKwDFd+aZZ6Y777wzderUKVYAYJrs2vGBBx5Ixx9/fKxQLFOnTvUCKzO1/vrrp8suuywq4H/tuOOOacCAAVHB9z7++OPcNTBAKfXt2zf9+9//TltuuWWsAJUq+1yR7cwDlSIbmFYONKM3kE2jAaDyfPDBB6YJUfX22Wef3EXGuuuuGytAqXTv3j0999xz6eSTT44V4Jc0auSOS75tvfXW6a233kqnnHJKWnzxxWMVgFq25JJL5hqhs5cnN9lkk1ilmC6//PL02WefRQU/1a1bt3TLLbdEBczIBRdckHr16hUVfO/SSy+NBFB82S6Fw4YNSwsttFCsAJUse4l/0KBBUUH5K5dm9Eb19kFukDe+nJoOGvxBVDDN0N2XjES1+Nenk9PhD9kulcJpOXfjdM9O3aOikHbeeed08803RwXVpUOHDum6665Lm222WawA5WT48OFpl112yTWEAjPWp0+f9Oyzz0ZFIbz00kvpzTffzO0WNHbs2Fil2t13331pxIgRUcH3shdUdtttt6iodm3atEldunRJSy+9dFp22WVjlVLIpqJnzcZffPFFrMBPvfDCC2mllVaKCpiZ7DPuKqusEhV8L2vC6dmzZ1QUynbbbZfuuOOOqKC2ZZOTs2fQG220UawA1eS8885LRxxxRFRQvtZbb700dOjQqEpHM3oDaUZnRjSjVx/N6BRay7kap3t21oxeaM8880xuWzSoRtlWf9dee22af/75YwUoR1nTye9///t0ySWXxArwv3r37p3bUQDIrwMOOCD99a9/jQq+t/HGG6chQ4ZEBRTLOeeck4455pio4KeyQQN77LFHVMCsOPzww9P5558fFaR00EEHmZBeBJrR4XvZ8+fbbrst9/IvUL383aMSdOrUKX388cdRlU7j+AoAUJUGDBgQCapHy5Yt01VXXZXuuecejehQAZo1a5YuvvjiNHjw4NykFODnGjVqFAkAoPpMnDgxnX322VHBT2XNkxrRoeFOP/30tNBCC0UFKV1//fVpypQpUQEUzpFHHpmGDRumER1qQPb5YqmllooKylO2I+6kSZOiKh3N6A3l2SgAVIyBAweasEnV6dOnT/rXv/6V9tlnn1gBKsWmm26a+/21jTQAANSWiy66KI0bNy4qmGbVVVc1xRdmU4sWLdIVV1wRFaRcA87NN98cFUD+NW/ePN11113pT3/6U6wA1S4bEnfDDTdEBeXrnXfeiVQ6mtEBgKo0derUdPTRR0cF1eHEE09Mzz77bFp88cVjBag02cSu4cOH5ybfAQAA1W/ChAnpj3/8Y1QwTevWrdNNN90UFTA7Ntlkk7TddttFBSldc801kQDyq3Pnzunpp59Ov/rVr2IFqBW9e/e2Iz9l7+23345UOprRAaBE6uMrhfHnP/85jRo1KiqobPPOO28aMmRIOuWUU2IFqHTZ5LvbbrstN0kFSKmuri4SAIVWX++OBBRTdo/qq6++igqmueyyy9Kiiy4aFTC7Lr744tzLHZD55z//mV5//fWoAPJjpZVWSi+++GJaYYUVYgWoNaeffnrq2rVrVFB+3nrrrUiloxkdAKg6n332WTrrrLOigsrWvXv3NGLEiLTxxhvHClAtssldL7zwQlpyySVjBWpX48ZuUQEUS6NGjSIBhTZ58uR04YUXRgXT7Lzzzmm33XaLCpgTHTt2TGeccUZUkNK1114bCWDO7bDDDmnYsGFpgQUWiBWgFrVq1Sr95S9/iQrKj8noAAAFkL2VOmnSpKigcq233nq5RvSsIR2oTksttVR67rnn0iqrrBIrUJtMRgcoHpPRoXiuueaaNG7cuKjgewsttFD661//GhWQDwcffHBaYokloqLWZc3o7jMA+XD00UenW265JTVr1ixWgFq2+eab515QgXJkMjoAQJ598skn6ZJLLokKKtdRRx2Vhg4dmuadd95YAapVmzZt0pNPPpm22mqrWIHaY0ovQPE450LxnH/++ZFgmttuuy21bt06KiAfst22jjvuuKiodV988UW69957owKYPVdccUU6++yzowL4Xrb7WfZcD8rNBx98EKl0NKMDAFXl3HPPjQSVa+DAgemcc86JCqgF2WSVu+++O+2///6xArVFYyQAUG3uuuuu9M4770QF38uaZVddddWogHzac88908ILLxwVtS67xw4wO1q2bJkGDx6c9t1331gBmKZjx47ppJNOigrKx4cffhipdDSjAwBV48svv0yXX355VFB5shtcjz32WNp5551jBag1f/nLX9Jpp50WFQAAUKn+/Oc/R4LvdenSJZ1wwglRAYWgMYgf3HPPPWnixIlRAcyaDh065HYx3XTTTWMF4Od+97vfpc6dO0cF5WHKlClpzJgxUZWGZnQAoGr86U9/yn3AgkrUrl27XCN6v379YgWoVVlzwrXXXhsVAABQaYYPH57++c9/RgXfu+CCC1Lz5s2jAgphr732yr34AVOnTs3tQggwq+abb770xBNPpJVWWilWAGbs9NNPjwTlY9SoUZFKQzN6A9k0GgDK07hx49LFF18cFVSWBRZYIA0bNiz17t07VoBal20tfdttt6UmTZrEClS3urq6SAAUWn19fSSgUM4999xI8L3VV189bbfddlEBhXT44YdHotYNHDgwEsDMtWnTJjcwqmfPnrECMHN77LFH6tGjR1RQHj744INIpaEZHQBKxKPf/PrjH/9oKjoVaaGFFkrPPvtsWmqppWIF4HtZo8LNN9+cmjZtGisAAEC5++ijj9Ltt98eFaTcS8bXXHNNVECh7bvvvql169ZRUcsefPDBNHbs2KgApq9FixZp6NChafnll48VgF/WuHHjdOaZZ0YF5cFkdACAOZTdTLzooouigsqRNaBnjeiLLLJIrAD8VNaQfuutt0YF1atRI3vRARSLcy4U1nnnnWfXF37isMMOMzEPiihrRD/wwAOjopZ999137qsBv2jIkCFp5ZVXjgpg1m2zzTbOH5SVjz/+OFJpaEYHACrehRdemCZNmhQVVIZswsI///nP1KlTp1gBmL7+/funu+++OyqoTtkUEQCASjdhwoR0xRVXRAUpLbjggunkk0+OCiiWAQMGRKLWDRo0KBLAzz3wwANprbXWigqg4c4555xIUHqff/55pNLwpA8AqGhTpkzJNaNDJVlhhRXSY489luaff/5YAZi5rbbaKt13331RQfWpr6+PBABQuW666aY0ceLEqCClE088MbVq1SoqoFg6d+6ce7kfHnroIX+bgekaOHBg2mSTTaICmD3rr79+7tk/lAPN6ABQq/Tb5EU2bWrcuHFRQflbccUVc43o8803X6wAzJrNN988NyHdBGmqUV1dXSQACs0LQFA4pqLzY4ssskjaf//9owKKbb/99otErcsa0gF+7PLLL08777xzVABz5rDDDosEpaUZHQBgNmVNS3/605+igvKXNaI/8cQTqV27drEC0DDZhHQNLgAAUH5efvnlNGLEiKggpdNPPz01adIkKqDYNt5447TwwgtHRS2z2yDwY8cdd1w64IADogKYc9nLLQbRUQ6++OKLSKWhGR0AqFiDBg1KH330UVRQ3nr16pUef/zxNO+888YKwOzZZ5990qmnnhoVVAcT/wGKp1GjRpGAfPLSKD+WbdO+6667RgWUQvaZ58ADD4yKWjZ48OBIQK3bfffd0xlnnBEVQH7MM888acCAAVFB6Xz55ZeRSsOTPgCgYpmKTqXo3bt3evTRR1ObNm1iBWDO/OEPf0gHHXRQVAAAQClNnTo13XjjjVFBSmeddVYkoJR22223SNSyzz77LD3//PNRAbVqlVVWSddff31UAPnlJUjKwZgxYyKVhmZ0ACiR+vjK7HnqqafSc889FxWUr+7du6chQ4ZoRAfy7tJLL0077rhjVAAAQKnccccdady4cVFR69Zcc8206aabRgWUUpcuXdL6668fFbXsvvvuiwTUoo4dO6Z77703KoD869ChQ9prr72igtLJXsQsFc3oAEBFOu+88yJB+Wrbtm168MEH03zzzRcrAPl18803p/XWWy8qAACgFK6++upIkNIJJ5wQCSgHu+66ayRq2SOPPBIJqEV33313riEdoJB++9vfRoLSGTt2bKTi04wOAFSct956Kw0aNCgqKE/NmjVLDzzwQFpsscViBaAwbr/99rTIIotEBQAAFFN2n+qxxx6Lilq3zDLLpI033jgqoBxsv/32uXu11LZst90pU6ZEBdSS6667LvXp0ycqgMLp1atX6tmzZ1RQGmPGjIlUfJrRAYCKc/7550eC8tSoUaM0cODAtNpqq8UKQOG0a9cuDRkyJLVq1SpWoPLU1dVFAqDQ6uvrIwH5cNVVV0WClI488shIQLnI7pdstNFGUVHLnnzyyUjMiez5B1SKffbZJ+2xxx5RARTer3/960hQGprRK4iP1QBQWuPGjUvXXHNNVFCezjvvvNS/f/+oAAqvR48e6e9//3tUUHkaN3aLCqBYNI9AfmWTFiHTqVOntOeee0YFlJMtttgiErXsiSeeiMSccA+HSrHccst5cRQoul133TUSlEbWU1UqPiUCABUla7SbOnVqVFB+Dj744HTYYYdFBVA8W221VTr99NOjAgAACu2RRx5Jn332WVTUut/97neRgHKz+eabR6KWPf7445GAateyZcs0aNCgqACKp1u3bqlfv35RQfGZjA4AMIv+8pe/RILy06dPn3TJJZdEBVB8xx9/fNp+++2jAgAACumWW26JRK1r1apV2m+//aICyk3nzp1Tr169oqJWDRs2LE2cODEqoJpluxd17949KoDi2m233SJB8Y0dOzZS8WlGbzBbmAJAqTz33HPplVdeiQrKS/bQ0UNooBxkN9p79uwZFQAAUCimLfKDvffeO7Vp0yYqoBxtttlmkahlWUM6UN1+85vfpO222y4qgOIzNIpSGj9+fKTi04zeUHrRAciT+v//PzTMVVddFQnKz5VXXpkWWWSRqABKp0WLFun222+PCgAAKIQhQ4aUdOtjyssBBxwQCShX6623XiRq2fDhwyMB1ahLly7pvPPOiwqgNOadd960zTbbRAXFVcqdgDSjAwAVYfLkyenvf/97VFBe9txzz7TTTjtFBVB6Sy+9dLr88sujgvJXX+9FTYBicc6F/Lj11lsjUevWWGMNu1NBBejbt29q2rRpVNSq559/PhKzq66uLhKUnxtuuCG1bt06KoDS6d+/fyQorgkTJkQqPs3oAEBFuPHGG3MN6VBullhiiXTppZdGBVA+ssl82267bVQAAEC+fPPNN3Yj4r/233//SEA5a9asWe7lEWqbZnSoXtngKLtgAOViq622Sk2aNIkKikczOgDUIoPIGuTKK6+MBOVj7rnnTnfeeWdq0aJFrACUl2uvvTYttNBCUQEAAPnw0EMPlfThHuUj2359hx12iAood+uuu24katWoUaPSZ599FhVQLRZYYIF04YUXRgVQetm1ohdkKIWJEydGKj7N6ABA2Xv55ZdNq6AsnXXWWWmZZZaJCqD8ZFuS3nrrrVFB+WrUqFEkAArNORfm3G233RaJWrf33nuneeaZJyqg3K211lqRqGUvvvhiJGZH48bajCg/F110Ua7xE6Cc2L2YUpg0aVKk4vMpEQAoe1dccUUkKB/ZFJ3DDz88KoDytdpqq6WTTz45KihPGiMBgEpy1113RaLW7b///pGAStCnT59I1LIRI0ZEYna4h0O5WX311dOOO+4YFUD5+NWvfhUJisdkdACAmbjxxhsjQXnIJg1ff/31UQGUv5NOOiktvfTSUUH5qauriwQAUN7uvffe9NVXX0VFLVtppZXSUkstFRVQCVq1amWnSzSjzyH3cCg32VR0gHLUsWPH1Ldv36igOExGBwCYgXvuuSeNGzcuKigPl112WVpooYWiAqgMXqKhnJmqBQBUClPR+cFOO+0UCagkq666aiRq1SuvvBKJ2eEeDuVkjz32SCuvvHJUAOVniy22iATFMXny5EjFpxkdAEqkPr4ycwMHDowE5aF///5pt912iwqgcqyyyirpiCOOiArKS329T8cAQGXIJqNDZocddogEVJI+ffpEolaNHDkyTZkyJSoayj0cykXz5s3TWWedFRVAeVp77bUjQXFoRq8g3vEEgOKZOHFiuvvuu6OC0uvQoUO6+uqrowKoPKeddlpaZJFFogIAapHmEZh9zz//fPriiy+iopZlzayuraAy9e7dOxK17LXXXotEQ7meoFwMGDAgderUKSqA8rTaaqulZs2aRQWFpxkdAGA67rzzzjR16tSooPRuvPHG1K5du6gAKk82Leb666+PCgAAaIj7778/ErVuxx13jARUmuWWWy7NNddcUVGrXn311UhAJcruc9sFFKgETZs2tTMPRVeqXYA0owMAZWvgwIGRoPT22muvtNFGG0UFULmyLQF/85vfRAXloVEje9EBFItzLsy+wYMHR6LW7bTTTpGASpM1oq+00kpRUav+85//RKKhGjfWZkTpHXDAAal9+/ZRAZS3fv36RYLi0IwOAPAj2ZbHQ4YMiQpKq1WrVumss86KCqDynXnmmal169ZRQenZ4hkAKHdffvlleu6556Kilq2xxhqpc+fOUQGVaJVVVolErXrllVci0VDu4VAOjjzyyEgA5W+ttdaKBMUxefLkSMWlGR0AKEu33nprJCi9k08+OS244IJRAVS+Dh065M5tUC5M6QUAyt39998fiVq32WabRQIq1XLLLReJWjVq1KhINJR7OJTagQce6MVAoKKsvvrqkaA4vv7660jFpRkdAChLAwcOjASltcQSS6QjjjgiKoDqcfjhh6fFFlssKgAAYGYGDx4ciVq36aabRgIqVffu3SNRq9q0aRMJqDRHH310JIDK0KJFi9SnT5+ooPCmTp0aqbg0owNAidjEbsY++OCDNGzYsKigtC688MJIANXnggsuiASlZYtnAKDcDRkyJBK1rH379mmllVaKCqhUmoHo0qVLJBrKPRxKKXspcOGFF44KoHKsvfbakaDwNKMDAIR77rknEpRWdlPLtCugmm255ZZpww03jApKxxbPAEA5e/zxx9P48eOjopZtvvnmkYBKNu+886b+/ftHRS3aaaedItFQ7uFQSgcccEAkgMqyzjrrRILC04wOABDuvffeSFBapqIDteCiiy6KBAAATM+DDz4YiVq3ySabRAIq3VFHHRWJWtO9e/fcgAagsmQ7Gmy11VZRAVSWNddcMxIU3v/93/9FKi7N6ABAWZk0aVJ66KGHooLSOfLII9MSSywRFUD1WmqppdK+++4bFQAA8L/+8Y9/RKLWbbTRRpGASrfaaqulzTbbLCpqyRVXXBEJqCT77bdfJIDK07Zt27TCCitEBYVlMjoA1Jr6+MpPaESnHLRu3Tode+yxUQFUvxNPPDESAADwY5MnT07Dhg2LilrWp0+fNN9880UFVIPLL788tWjRIipqwdlnn53WXXfdqIBKYqAKUOnWWmutSFBY2RDQUtCMDgCUlXvvvTcSlM7vf/97DxeBmtK1a9c0YMCAqAAAgB88++yzkah1/fr1iwRUi27duqWbbropKqrdOeeck44++uiogEqSvUTSqVOnqAAqU9++fSNBYWlGrxCN4isAUBj3339/JCiN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E9NJj38cFeRf22ZN0h07LB4VP7jooovSgAEDooLiatWqVa4xc/75548VgOr0wQcfpKWWWipNmTIlVqC01llnnfT4449HBeTLb3/723TppZdGBd/beOON05AhQ6ICfsnuu++e/va3v0VFLXvjjTfSkkt6FgTVbsyYMenpp5/O/c6PHz8+1dXVpe++++4n/6a3NqP1ma2RX82aNUsLL7xwWmaZZVK/fv3S8ssvH98hn3bbbbf097//PSqYfQcffHC65JJLogKobf6+kk/rr79+euSRR6IqHs3oDaQZnRnRjF59nvxgYjpZMzoFpBl9+l5//fXUs2fPqKD4jjrqqHTOOedEBVCdNt988zR48OCooPTWXnvt9MQTT0QF5ItmdKZno402Sg8++GBUwC+57LLLco0ykDVLORaget1xxx3pggsuSP/85z9jhUqXvUCUXRPtu+++uUZ18mPXXXdNAwcOjApm30EHHeSeBUDQjE4+laoZvXF8BQCKrFF85aeyKa1du3aNCorv4osvTl988UVUANXn9ttv14gOAACzaPXVV49ErXvooYciAdXkrbfeSn369EnbbbedRvQq8+abb6ZDDz0099zp4YcfjlUAAKAQNKM3kMZBACi8TTbZJBIU35QpU9Jpp50WFUB1mThxYjrssMOiAgAAfsmKK66YWrVqFRW17LHHHosEVItnn3029erVKw0fPjxWqEbvv/9+bnegbLcTAACgMDSjN5h2dAAotI033jgSlEY2HT2bmgJQbY4//vj00UcfRQUAAMyKfv36RaKWTZgwIQ0bNiwqoNJ98MEHacMNN8z9blMbDj744HTTTTdFBQAA1alRo9L0OGtGBwDKTjahAkrtyCOPjARQHUaMGJEuuuiiqAAAgFmVNStC5uGHH44EVLq9995bI3oN2meffdKHH34YFQAAVJ/GjUvTFq4ZHQAoO/POO2/adNNNo4LSuPfee9Pjjz8eFUDl22+//SIBAAANscEGG0Si1j300EORgEr22GOPpaFDh0ZFLZkyZUr605/+FBUAAJAvmtEBoFRKsytKxdh2220jQekceuihkQAq2+mnn55eeOGFqAAAgIZYeumlU8eOHaOilg0bNiyNHz8+KqBSXXPNNZGoRf7/HwAA8k8zOgBQln71q19FgtJ5+eWX3ZgGKt7zzz+f/vCHP0QFAADMjg033DASte6RRx6JBFSqf//735GoRZMmTUpPPvlkVAAAQD5oRgeYkfr4CgVjNPrMtG/fPq277rpRQekcf/zxaeLEiVEBVJapU6em3XbbLSoAAGB2bbDBBpGodXfeeWckoFJpRue1116LBAAA5INmdIAZ0ItOoWlF/2Vbb711JCidTz/9NB111FFRAVSWI488Mr3xxhtRQfmqr3cFBlAsdXV1kYCG2GSTTSJR6+6555709ddfRwVUmmwHOejWrVskGsr1BPnifiDANM6J5FOpPq9pRgcAytZ2220XCUrr8ssvT08//XRUAJXh4YcfTpdeemlUUN4aNfKqJkCxNG7ssQDMjgUWWCAtu+yyUVHLxo8fnx577LGogEozYsSISNSy7t27R6KhXE+QL+4HAkzjnEg+lerzmk+JAEDZ6ty5c+rdu3dUUFp77bVX+vbbb6MCKG9jx45Ne+yxR1RQ/kz9ACgekwxh9m255ZaRqHW33357JKDSmIxOZtFFF41EQ7meIF/cDwSYxjmRfDIZHQBgOrbddttIUFpvvPFGOvPMM6MCKG9ZI/onn3wSFQAAkA9bbbVVJGrdnXfeqVkAKpTJ6HTr1i01adIkKgAAIB80owMAZW2HHXaIBKV30kkn5ZrSAcrZddddl+69996ooDLYghKgeGyrD7NvtdVWSwsuuGBU1LLRo0enJ598Miqgkrz44ouRqFVLLLFEJGaH6wnyxf1AACiMUn1e8ykRAChr2VaJ66yzTlRQenvvvXckgPLzwgsvpL322isqqBymSgIUj3MuzJktttgiErVu0KBBkYBKMXz48EjUsuy5E7PP9QT54lgCmMY5kXwq1fGkGb2BvJcHtcQfeigX++yzTyQovWHDhqUzzzwzKoDyMWbMmNS/f/+ooLKYhARQPM65MGe22mqrSNS62267LRJQKZ555plI1LLFF188ErPD9QT54lgCmMY5kXwq1fGkGR0AKHvbb799atmyZVRQeieddFJu+jBAufjuu+9yjegffPBBrEBlMfUDoHjq6uoiAbNjgw02SHPPPXdU1LKPP/44DR48OCqgEjzyyCORqGU9e/aMxOxwPQEA+ecZCflkMjoA1BjvNc66Zs2apZ122ikqKL1vv/0295LEpEmTYgWgtI488sj0j3/8IyoAAKBQWrRokTbaaKOoqHVXX311JKDcZS/yDx06NCpq2UorrRQJAADIF83oADPgnTMoL3vttVckKA/vvPNOOvDAA6MCKJ2BAwemCy64ICoAAKDQtt1220jUunvvvTd98cUXUQHl7NlnnzVchNSmTZvUrVu3qJgdjRoZtwUAwM9pRgcAKsIaa6yRFl100aigPPztb39Lt912W1QAxffyyy+nvffeOyoA+ClNAgCFkTWjzz333FFRy7755pt0ww03RAWUs4cffjgStWyVVVaJBAAA5JNm9Iby/AYASma//faLBOVjn332SSNHjowKoHhGjx6dttpqq/R///d/sQKVS8MsFEbjxm7/8nOOC5hzrVu3TptttllU1Lqrr746ElDOhg4dGola1qtXr0jMLvdwyBfHEsA0zonkU6mOJ3edAaBUfJZssKzp10Nzys2ECRNyzaATJ06MFYDCy84966+/fnrvvfdiBSpbfX19JCCf6urqIsE0jgvIjx122CESte61115LTz/9dFRAOZo0aVIaNmxYVNSyFVdcMRKzyz0c8sWxBDCNcyL5VKrjSTcXAFAxOnTokDbffPOooHy8/vrraeedd44KoPCyl2D+9a9/RQWVz9QPKAwv8zI9jgvIj+wzebNmzaKi1l1zzTWRgHL08MMPp++++y4qatnKK68cidnlHg754lgCmMY5kXwyGR0AYBYcdNBBkaC83HfffemUU06JCqBwtt566/T4449HBdXBjVYAoNK0bNky/epXv4qKWnfTTTel8ePHRwWUm9tvvz0StSz7292jR4+oAACgOmlGByg3dkChwLTbzJ6NN944devWLSooL1kz+v333x8VQP7ttdde6e67744KqoctKKEw6urqIsE0jgvInx133DEStW7SpEnp2muvjQooJ998800aNGhQVNSyNdZYIxJzwj0c8sWxBDCNcyL5VKrjSTM6AFBRsjf4fvvb30YF5SX7UL/TTjulN998M1YA8ueEE05I1113XVRQXUxGh8Jo3NjtX37OcQH5079//9S6deuoqHWXXnppJKCcZMNDpkyZEhW1rF+/fpGYE+7hkC+OJYBpnBPJp1IdT+46A8yAd86gfO29996padOmUUF5mThxYm6C/5dffhkrAHPuL3/5SzrjjDOigupj6gcUhgnYTI9zLuTXr3/960jUupEjR6YHHnggKqBc3HbbbZGodWuttVYk5oTrCfLFsQQwjXMi+VSq40kzegN5BwUASm/++edPO++8c1RQft577720+eabRwUwZ66//vp04IEHRgXVydQPKAwTsJke51zILzv48WMXXXRRJKBc3HvvvZGoZc2aNUtrrrlmVMwJ1xPki2MJYBrnRPKpVMeTpxEAQEU64IADIkF5eu6559J2223nLWZgjtxwww1pr732igqql7+XUBgmozM9zrmQXz179kxrr712VNS6IUOGpFdeeSUqoNTuuuuuNGHChKioZauuumok5pTrCfLFsQQwjfu45FOp/sZqRgcAKtLqq6+ell9++aigPN1xxx3p+OOPjwqgYa655pq0xx57uClPTTD1AwrDZHSmxzkX8u/ggw+OBCmddtppkYBSGzhwYCRqXb9+/SIxp1xPkC+OJYBp3Mcln0xGBwBooIMOOigSlK+zzjorXXvttVEBzJpsIvpvfvObqKD6eekCCsNEHabHORfyb5tttknzzz9/VNS622+/Pb333ntRAaXy2WefpTvvvDMqat1aa60ViTnlegIA8s99XPLJZHQAgAbabbfdUtu2baOC8rX33nune++9NyqAmbvqqqtMRKfmmIQEhdGkSZNIMI1JS5B/TZs2TQceeGBU1LqsieDMM8+MCiiVK664In377bdRUctatGiR1l9//aiYU64nACD/3Mcln0xGB4Aao91mzrVs2TLtv//+UUF5y6ak3XPPPVEBTN+VV16Z9ttvv6igdnj5AgrDRB2mx3EBhbHvvvtqzuK/rrnmmvTOO+9EBRRb9nnn0ksvjYpat95660UiH1xPAED+fffdd5FgzpmMDgAwGw477LBIUN6yKTy/+tWvNKQDM3TZZZflGtE15VKLTEaHwvC7xfQ4LqAwunXrlrvuh0zWSHDSSSdFBRTboEGD0meffRYVtW7LLbeMRD64ngCA/PNyO/lkMjoAwGzo2LFj2muvvaKC8rfttttqSAd+5rjjjksHH3xwVFB7vIQBheF3i+lxXEDhHHLIIZEgpYEDB6bXX389KqCYTEXnx7bYYotI5IPrCQDIPzuPUA00owPMgMtoqBxHH320SQxUjGxCuoZ04Adff/117pxw1llnxQoAAFCp1l133bT00ktHRa3LmgmOOeaYqIBiefvtt9Pjjz8eFbVu+eWXT507d44KAAAoFM3oAEDF69GjR9p8882jgvKXNaRnW3fffPPNsQLUoq+++iptsMEGua2jodZ5sRAKw+8W0+O4gMI6/PDDI0FKd999d3riiSeiAorh1FNPjQQpbbnllpHIF9cTAJB/jRtr46XyOYoBoFTcq8mr3//+95Ggcuyyyy7pvPPOiwqoJR988EHq06dPevLJJ2MFAPLP9ulMj+MCCmu33XZL8803X1SQ0gEHHJC+++67qIBCeuedd9KNN94YFaS06aabRiJfXE8AQP5lO2tBpdOMDgBUhbXXXjv16tUrKqgM2U3bI444Iv3ud7+LFaAWPPfcc7m/WW+++WasAAAA1WKeeeZJ++23X1SQ0uuvv54uuOCCqIBCOv744zXy8F/t27dPa6yxRlQAAOXLziNUA83oAEDVOPbYYyNBZckeSO68885RAdXszjvvTP369UujR4+OFQAoHA8xmB7HBRTeIYccEgm+d9JJJ6VPP/00KqAQXn311XTzzTdHBSnttNNOkcgn1xMAkH/+vlINNKM3kF97APLF35T822677VL37t2jgsqSPSjJGlQnTJgQK0C1+f3vf5+22WabNGXKlFgBAACqUefOndP2228fFaQ0adKktO+++0YFFEL20gf8mAEwAABQPJrRAYCqcvLJJ0eCyvPEE0+k3r17pzfeeCNWgGqQTb/LtgQ+99xzYwUAiqO+vj4STOO4gOI49NBDI8H37rvvvnTVVVdFBeTTv/71r3THHXdEBSl17do1rb766lGRT64nACD/6urqIkHl0owOMCOuo6Ei7brrrmnZZZeNCipP1ojeq1evdNddd8UKUMmGDh2alltuuTRs2LBYAYDisb0r0+O4gOJYc80100orrRQVfG/AgAHpvffeiwrIl2OOOSYSfG/33XePRL65ngCA/POyF/lUqs9rmtEBZsCfeahc55xzTiSoTJMnT079+/f3EAUqXLZbxwYbbJC+/PLLWAGA4tIkAFBaxx57bCT4XnbPZ7fddosKyIc777wzDRkyJCr4nnMtAAC1qnHj0rSFa0YHAKrOZpttlps+BZUue7Eia2QdPXp0rACVIGs+z353TznllFgBAABq0fbbb5+WWmqpqOB7Tz31lOtFyJOJEyemgw8+OCr43oorrph69uwZFVCuStUoB1COnBOpBo7ihjJMCAAqgunoVIuhQ4fmbp4//fTTsQKUs+x3doUVVsh9BQAoRybmQ3Edd9xxkWCabCetJ554Iipgdp1wwgnpk08+iQq+t+uuu0aiEFxPkC8aLwGmcU4kn0r1ec1RDABUpdVXXz1tueWWUUFlGzVqVFprrbXS8ccfn7799ttYBcrJ1KlT06GHHpo23HDD9PHHH8cqAJRWfX19JJimrq4uElAMO++8c1pkkUWigml22mmn3M5awOwZMWJEuuiii6KC7zVt2jTtvffeUVEIrifIl++++y4SAM6J5FOpjifN6ABQMiYHFNpZZ50VCSpfdsFw5plnplVXXTWNHDkyVoFy8MILL6TlllsuXXzxxZr+ACgrJtYBlF7WFHfsscdGBdN8+umn6de//nVUQEPts88+7sPwMzvuuGOab775ogLKmXsWANM4J5JPJqMDQI3xUbLwlllmmbT77rtHBdUha3pdcsklTf2BMpG9JLLyyiunt956K1YAAMqbh1tQfPvtt1/q1KlTVDDNkCFD0qmnnhoVMKvOP//89K9//SsqmObggw+ORKG4niBfHEsA0zgnkk+a0QEACsDDHKrVgAED0sYbb5ybogUU3zvvvJNWX331dPzxx8cKAEBlMEEUSuPoo4+OBD910kknpQcffDAq4JdkwzoOP/zwqGCaFVZYIfXt2zcqCsX1BPniWAKYxjmRfCrV8aQZHQCoagsvvHA67rjjooLq8tBDD6UePXqkK6+8MlaAYrj44ovTsssum55++ulYAQAAmLlsOnqHDh2igp/aYYcd0rvvvhsVMCNjxoxJ/fv3jwp+6pBDDokEAAAUm2Z0AKDqZVNrbYVMtRo/fnzugfb666+fm9QMFE42eatPnz7p0EMPTVOmTIlVIB+aNGkSCYBCs+0vlEbz5s3TkUceGRX8VHZ/Z+utt859BWZsxx13TB988EFUME3btm3TLrvsEhWF5HqCfHEsAUzjnEg+lep40owOMAM2QIHq0aJFi/THP/4xKqhOjz76aFp88cXTOeecEytAvowbNy7tv//+aeWVV07Dhw+PVQAAgIY5+OCDU/v27aOCn/r3v/+dttlmm6iA//WHP/whPfLII1HBT+299965F78AAIDS0IzeQN5BASBv/FEpqt122y2tuuqqUUH1OuaYY9Lyyy+fXnrppVgB5sT111+fevToka644opYAQqhrq4uEpBP9fVetefnHBdQOi1btkxnnHFGVPBzQ4cOTTvttJNzNfyP+++/P51++ulRwU81bdo0HXHEEVFRaP5GkS+OJYBpnBPJp1IdT5rRAYCacfHFF0eC6vbyyy+nlVZaKR122GHpq6++ilWgIf7zn/+ktddeO+25557p888/j1WgUJo0aRIJyCfbuzI9jRt7LACltN9++6XlllsuKvi5W265JR111FFRAa+//nraZZddooKfy46Pzp07R0WhuZ4gXxxLANM4J5JPpTqeHMUAQM3o3bt32mOPPaKC6nfhhRem7t27p7/85S+xAvySsWPH5l7kWGaZZdKTTz4Zq0ChmfoBUDzOuVB62fU6zMy5556bTjjhhKigdr399ttp3XXXTePHj48V+Lmjjz46EsXgeoJ8cSwBTOOcSD6V6njSjA4AJWI+XWn86U9/Si1atIgKqt+XX36ZDjzwwLTiiiumESNGxCrwv7755pv05z//OS2++OIaQ6AE6urqIgFQaB5uQelljZWbbbZZVDB9Z5xxRjr22GOjgtrz4Ycf5s6Xn376aazAz22++eZp6aWXjopicD1BvjiWAKZxTiSfNKMDlB1/6KEadejQwVQhatK//vWv/+4O8Pnnn8cqkLntttvSUkstlY488sjcZHQAAIBCy16CbdKkSVQwfWeffbaGdGrSJ598ktZZZ51cQzrMzDHHHBMJAAAoJc3oAEDNyR7gdO/ePSqoHdkbsDfccENadNFF04knnpjGjRsX34Ha9Pzzz6c11lgj7bDDDumdd96JVaAUGjd2iwqgWBo1slcblIPs3lS2kxn8kqwh/Xe/+11UUP3GjBmT1ltvvfTuu+/GCkxf375905prrhkVxeJ6gnxxLAFM45xIPpXqePKkD2BGDEaHqnbttddGgtozefLkdNppp6Vu3brldgrQlE6teeutt9I222yT2y1g2LBhsQoAAFBcp556amrTpk1UMGMXXHBB2m+//aKC6pXtWNevX7/0+uuvxwrM2PHHHx8JqEQaLwGmcU6kGmhGB5gBvehQ3bJpGR7gUOsmTJiQzjjjjNyk9OwB+Pjx4+M7UJ2eeuqpXBN6jx490p133hmrQDmoq6uLBEChZTsmAeWhXbt26Q9/+ENUMHNXXnllbmevb7/9Nlagunz66ae5Sdcvv/xyrMCMrbDCCmnzzTePimJyPUG+OJYApnFOJJ9KdTxpRgcAata5556bOnbsGBXUrmwy+kknnZQWXnjhdPrpp5uUTtW544470mqrrZZ7ESlrQtf0CuWncWO3qACKxaQlKC9HHHFE7oVZmBW33XZb2mKLLXIDBqCaZLvY9enTJ73xxhuxAjN39tlnR6LYXE+QL44lgGmcE8mnUh1PnvQBADWrdevW6dJLL40KyJrQs4lsnTt3Tvvss48pRFS0KVOmpEsuuSR17949bbfddunZZ5+N7wDlyEsiAMVj0hKUn2uvvTYS/LIHH3ww17T74YcfxgpUtpdeeimtuuqqjmlmWXYO3GSTTaICKpVrU4BpnBOpBprRAYCats0226Stt946KiCTNfFec801afnll89tjXv99dfHd6D8ZQ8ujzvuuNxLFYccckh6++234ztAOTP1AwCoZdm197777hsV/LLXX389rbjiimnYsGGxApXpr3/9a1pppZXSmDFjYgV+2VlnnRWJUnAPh3xxLAFM45xIPpmMDgA1xkfJ8nHZZZflpqQDP/fMM8+kPffcMy244ILphBNOMKGIsjVkyJC01VZbpW7duuUeSGWT/oHK4UYrQPE450J5+uMf/5jat28fFfyyrHl3jTXWsPMjFWn8+PFp2223TQcccECswKxZZ5110nrrrRcVAABQLjSjAwA1r1OnTuncc8+NCpiezz//PJ1xxhm5Rt8NNtgg3XTTTbkJ6lBKo0ePzjVsLL744mnTTTdN9957b3wHAACgsrRt21ZTMbPlt7/9bW73x6+++ipWoLw9//zzaYUVVkiDBg2KFZh12T1qAACg/GhGbyAzYwCgOu23335p7bXXjgqYmaFDh6ZddtklLbDAAuk3v/lNbno6FFN2zO2+++65qYFHH310euedd+I7AMCPmYDN9DguoHztsMMOabPNNosKZt2dd96Zll9++TR8+PBYgfJ05plnpt69e6f33nsvVmDWbbLJJrkdIQAAgPKjGb3B3KgHgGr1t7/9LbVq1Soq4JdMnDgxXX311alv376pR48euak0H3zwQXwX8uvLL7/M7WKx5JJL5o657JwNVI/6+vpIQD5pOgaoPJdffnlq1qxZVDDrsnsyffr0SaeddlqsQPn46KOP0lprrZWOP/74WIGGO//88yMBAADlRjM6AEDo1q1buv7666MCGuLNN99MJ5xwQlp44YXTKqusks4555w0atSo+C7MvoEDB6bNN988dejQIf3+979PI0eOjO8AAABUn+z+VDY5GGbXiSeemNZcc830/vvvxwqUVjbMomfPnumf//xnrEDDHXXUUWmppZaKCgAAKDea0QFmwFw+Cs6AurK0zTbbpH333TcqYHaMGDEiHXPMMWmhhRZKq622WjrvvPM0ptMgzz77bNpvv/1SmzZt0q677poGDx4c3wGqlenNUBh+twAq0+9+97u08sorRwUN99RTT6Xll18+94I3lEo2UGDddddNv/nNb9KECRNiFRquU6dO6aSTTooKAAAoR5rRAQD+x4UXXph69OgRFTAnsqbiI444IteYnm0Vfeqpp+aa1eF/PfHEE7mtmpdeeuncSwxXXnllGj9+fHwXAACgttxwww2RYPZk19TZC95rrLFGev7552MViuMPf/hDWnLJJdPjjz8eKzD7LrrootSiRYuoAACAcqQZvaEMEwIgT/xJKV/NmzdPt99+e5p77rljBciH4cOH5ybYrLLKKqlr167pgAMOSPfdd1+aMmVK/AS15KOPPkpXXXVV2m677VLbtm1Tv379clvRv/baa/ETQC2pr7c3FRRCXV1dJJjGORcqQ/ai7vnnnx8VzL5hw4al3r17p5133jl9+OGHsQr5l33GyKbxL7bYYun000+PVZgz2XT97P4h5cP1BABAeSvV5zXN6AAA07Hsssum8847Lyog37JG5L/+9a9pyy23zE212WyzzXIPqR577DHN6VVq6tSp6dFHH02///3vc1uFZy8k7LvvvumOO+5IX331VfwUUKsaNfKqJhRC48Zu//JzzrlQOQ477LC0/vrrRwVz5uabb07dunVLAwYMSGPHjo1VyI/snl6vXr1y0/jffffdWIU5l+2eSHlxPQEAUN5K9XnN0wgAgBk4+OCD0xZbbBEVUEgPPPBAbvve9dZbL9ec3qdPn3T44YenW2+9NX366afxU1SabCvmbBr+Ouusk9t1ImuiOPfcc9PLL78cPwEAAMDM/O1vf8vtJgX5ctFFF+UmV//xj3/MvTgOcyJrQt9oo41y9/ReeumlWIX8yO4rLr744lEB1cYL9ABQXfxlBwCYiRtuuCF16tQpKqBYhg8fntuOfMcdd8z9Di6yyCJpl112SZdcckl64YUX4qcoN08++WQ65ZRTctvnZm9cZ19PPfXU9I9//CN+AgAAgIbIromvueaaqCA/xo0bl44++ui0xBJLpMsuuyxNnjw5vgOz5q677soNk8ia0B9++OFYhfzp0aNHOvnkk6MCqpEp+wDTOCdSDTSjAwDMRLt2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0+LPf/5z9OvXL1UBqDR77LFHHtIYP358qlSGN954I40AAACK6927d5x66qlx7bXXxujRo1MVgLnZfffd4/7774+tt946VQAAAMpHGL0gC9sCALVos802y09cb7/99qkCQCUYMGBAXH755XH88cdHfX19qlaOt956K40AAADm36qrrpqfm/rJT36SKgDMyZJLLhk33HBDnHDCCdHY2JiqANWnrk4CCwBqiTB6Yb4MAVAiPlKoMFln9LPOOiuuuOKKWGihhVIVgHKZPHly3HvvvTFp0qRUqTwvv/xyGkHLNDU1pRFQSl5bAFSbH//4x/HAAw/EaqutlioAZBoaGuLII4+MO+64IyZMmJCqAAAAn1au3wWE0QEA+JT1118/Dz9OmTIlVQBoSz169Ij/9//+X1xyySX5hUKV7LXXXksjaBmdkKB1eG0BUI1GjRoV//rXv+L000+Pvn37pipA+/WVr3wlXz1iv/32i44dO6YqQHXr0EFkDQBaQ7l+F/DJDgDA5/Tq1SvOOOOMuOqqq2LYsGGpCkBrmzhxYtx1113xzW9+M1Uq24svvphGAAAApbXDDjvk4csshAnQHq266qpx2223xdlnnx1DhgxJVQAAgMojjA4AZaI/HdVgrbXWiunTp8dee+2VKgC0lqOPPjqmTZtWVRcBvfTSS2kEAABQev37989DmNddd10svfTSqQpQ24YPHx5//vOf49prr41x48alKgAAQOUSRgcA4As1NDTEMcccEzfeeGMst9xyqQpAqWy44YYxY8aM2HvvvVOlerzwwgtpBC1TriUDAQCoDqusskrceeedccopp0S/fv1SFaC29O3bN44//vh4+OGHY7PNNktVAABqXceOHdMIqpcwOgAA82TFFVeMW265Jc4666wYPHhwqgIwvxZccME499xz47LLLouhQ4emanV5/vnn0whapqmpKY2AUvLaAqDW7LzzzvHoo4/mq/h16tQpVQGqW319fey3337x2GOPxR577JGqALVt5syZaQSA90RKqVy/CwijAzTDz7UAn5d1Ld1+++3jwQcfjEMPPTS6deuW9gAwr7L30t122y3uv//+2HbbbVO1OgmjAwAAba1nz575Kn733HNPrLPOOqkKUH06d+4cu+66azzyyCNx5JFH5u9vAAAA1UgYHQCAwrJOLQcddFA89NBD8bWvfS0PVgIwd0sssUTccMMNceKJJ0ZjY2OqVq+XXnopjQCoRL6nA1DLRo0aFX//+9/jkksuiREjRqQqQOXr2LFj7LDDDvn59ZNOOikWWmihtAeg/XDOAgBqizA6AADzLTtJfuaZZ8bNN98cEyZMSFUAPquhoSEOP/zwuOuuu2LFFVdM1er3yiuvpBEAAEB5TJ48Oe6777449dRTY/jw4akKUHmy4GW2Sl72nnX66afH0KFD0x4AAIDqJowOAECLLb/88nmn3/POO08nKoDP2HzzzWP69OlxwAEH5J2vasmrr76aRtAyOiFB6/DaAqC96NSpU+y0007x8MMPx1lnnRWjR49OewAqQ3Z+KGtScO6558bIkSNTFaD9cs4CYLYOHcR4KZ1yPZ88iwGa1ZS2AMyrbbbZJl9a9De/+U0MGDAgVQHap/Hjx8f1118fF154YQwbNixVa8ubb76ZRgAAAJVh++23j/vvvz8uuOCCGDt2bKoClMdGG20Ut956a35+aMkll0xVAACA2iKMDgBl4lpvatm3vvWtePTRR+Oggw6K7t27pypA+7DIIovEOeecEzfffHOstNJKqVqb3nrrrTSClmlqcjEwtAavLQDas6222ir+85//xEUXXZRfLAzQVrp06RJf//rX85Xypk6dGsstt1zaA8AszlkAzDZz5sw0gpYr12esMHpBgoMAAPMmC6Efeuiheaf03XbbLVUBalePHj3iqKOOisceeyy22267VK1tH3zwQRpBy1iWF1qH1xYARHzpS1/KLxb+y1/+EqusskqqApReY2NjHHjggTFjxoz43e9+F0sssUTaA8BnOWcBMFuHDmK8lE65PmM9iwGa40JcgJJYcMEF48QTT8yXR95iiy1SFaB2dOrUKfbYY488hL7vvvumavvQuXPnNIKW0QkJWofXFgDMtvHGG8d1110X06ZNy8cApTJ8+PD49a9/HU8//XQcdthh+TlxAL6YcxYAs3lPpJR0RgeoMD7mAUpr9OjR8ac//SluuOGGmDRpUqoCVLesw1625PLxxx8f/fr1S9X2o2vXrmkELaMTErQOry0A+LyJEyfmXdKzY7mvfvWrqQpQ3IorrhjnnXdePPzww/Htb387unXrlvYAMDe6AAPM5jwupaQzOgAA7cKECRPi8ssv//gHP111gWo0efLkuO222+Kiiy7KL7ZprwYOHJhG0DK6fkDr8NoCgOYtscQS8fvf/z5mzJgRu+++e9TX16c9AM3LLsyfMmVK3nTlxhtvjG222SbtAaAI5ywAZvOeSCnpjA4A7Y0LG2nnZv3g98gjj8See+4Z3bt3T3sAKtcmm2wSt99+e1xyySUxbty4VG2/hgwZkkYAVCIddQBg7oYOHRonnHBCHkrfb7/9orGxMe0BmG3RRReNI444Ip588sk444wz8qYrAMw/5ywAZvOeSCnpjF4tvO4BAEpq8ODBcdxxx8VTTz0VRx55ZAwaNCjtAagM2QH75ptvHnfddVdceumlseyyy6Y9LL744mkELaPrB7QOry0AmHfZyk/Zuamnn346Tj311FhhhRXSHqC9ys4JTZo0KT8flDVV2X///aN///5pLwAt4ZwFwGzeEyklndEBoJ1xfRN8WtZ1Kus+9dhjj8Vvf/vbvHM6QDllPzhuueWW8Z///CcuvPDCWGqppdIeZtEFjFLp1KlTGgHQ2nRaAvhi3bp1i5122iluuumm/KLkPfbYQ7d0aGf69u0b3//+9+Ohhx6Kyy+/PF8pz3co+IjXAgAAcyKMDgBARencuXN84xvfiOnTp+cn+tdaa620B6DtzAqh//GPf3RxzBdYffXVo6GhIc1g/g0fPjyNgFISEmBOOnTwswDAvMouSj7++OPjmWeeiTPOOMMFuVDjJk+eHBdccEG8+OKL8ctf/tKxKsyB4wlKxTkLgNl8vlJK5fqM9SwGAKBiZUugXnXVVXkXqq9+9at5UB2gtdTX18euu+4aDz/8sBB6AZtuumkawfxbY4010giA1jZz5sw0AmBeZRfhTpkyJW644Ya8gcJ3v/vdvHMyUN2ykMaqq64aJ510Urz00ktxySWXxFZbbZX2AnPieIJSaWpqSiMAvCdSC4TRAQCoeFkXqt///vfx6KOPxn777Rc9e/ZMewBaLltu/cADD4wZM2bkPz7qelXMDjvskEYwf7p16xbrrbdemgHQ2nRaAmiZ7MLl//u//8s7J5999tkurIQqNGrUqPjpT3+an2++9tpr8+YEffr0SXuBL+J4glLRGR1gNu+J1ALfEgEAqBoLL7xwHHnkkfHUU0/FMccck88B5tdCCy2Uv5c8/fTTcdhhh8XAgQPTHorYcMMNY6WVVkozKO4HP/hB9O7dO80AaG06LQGUzle+8pW4+uqr8xW2sgYK/fr1S3uASpOdS953333jlltuiQceeCB+9KMfxSKLLJL2AvPK8QQAAHMijA7QDIfRAJWrR48esddee8WTTz4Z5557bqy11lppD8DcLb744vlqC9mFLdl7SdaVmZY57rjj0giKybrRff/7308zANqCTksApZetsJU1UHjhhRfiyiuvjD322CMGDBiQ9gLlkoXNswugb7rppvxc8lFHHRXLL7982gvMD8cTAADMiTB6Qb5WAwBUlm233Tauuuqq+O9//5svrTpixIi0B+DTNthgg7jooovinnvuia9+9aupSilkP+RmgQsoonv37nHppZfmF5kB0HZ0MgRoXeuuu24cf/zx8dxzz8U111wT3/ve9/KVuYC2kV0ccuCBB8att94ajz32WPz85z+PFVZYIe0FWsrxBAAAcyKMDgBATRg0aFC+tOpDDz0U06ZNi9133z0aGxvTXqC9WmCBBfKl0h9//PH461//Gl/60pfSHkotC1xk779CFsyLpZZaKm688cYYM2ZMqgDQVoRHANrO6quvHscee2y+Mld2vLTvvvvmQVmgtJZeeuk46KCD4s4774yHH344DjvssFhuueXSXqCUdEYHAGBOhNEBoEycqoHWM3HixDjhhBPi1VdfjQsuuCA22WSTtAdoL9Zaa60477zz4plnnsmXSh8yZEjaQ2vK3n9vv/322HLLLVMFPq1Pnz5x+OGHx1133RVjx45NVaC1zJw5M41gNs8LgPLIjpeOOuqoPCh72223xY9//ONYYokl0l6giP79+8d2220Xp59+ejz77LN5CP3QQw/NQ+kAAAC0PWF0AABq2lZbbRWXXnppvjRy1olq/PjxaQ9Qa3r16hV77rlnPPDAA3HVVVfFNttsk/bQlrJu9H/84x/zcEUWSl955ZXz5bCXXXbZPHw8evToGDZsWAwePDi/b9++faNnz55RX1+fHoFatMoqq+QXimWrFBxwwAGpCrS29957L41gNmF0gPIbN25c/OQnP4np06fH/fffn1+wmR03Ac3LGg9kr5Vbbrklnn/++TjnnHNihx12iIEDB6Z7AAAAUC51TdbkLOTN92bG5D88lGYw2z+mjE4jasXF978Sv77xuTSD0hvVt2uctMkiaQa0pfvuuy/OPPPM+P3vfx9PPvlkqgLVatVVV43ddtsttt9++1ShFrz55pt5iHJebu+//376U62vQ4cO+a1jx44fjz95K1rPbnPaVw3h/DfeeCPeeuutePvttz93y/6bZP8/sgsOxowZk/4E0Nay1UFcAMJn7bjjjnHaaaelGQCVJGumkF1cnd2uvvrqePDBB9MeaH+WW265PIC+9tprx5prrhndunVLe4By+sY3vpGvSgAtla0Sk12cB0DErrvuGqecckqaQctsscUW8ac//SnN2o4wekHC6DRHGL32CKPT2oTRofyyr8L//Oc/82B69mX89ddfT3uASpctu/yVr3wlvw0ZMiRVAYBP+vvf/x7rrbdemsFHTj311Nhpp53SDIBKljVRmBVOz85hZSsNQS3KLtLOVlTLQudrrLFGfmtsbEx7gUqSNQTJViaAltp///3jiCOOSDOA9i37vfMPf/hDmkHLZMdV2TmEttYhbQH4LJfqANS8urq6vLNO1sUj6zx11llnCetABRs2bFj88Ic/jHvuuSfuvPPO2G+//QTRAeALrLzyytGrV680g4+ss846aQRApRs8eHBMmTIlP3c1Y8aMvFP6ySefHNttt12+ChFUs4kTJ8a+++4bU6dOjVdeeSVuueWW+OUvfxmTJ08WRIcK9u6776YRtIzeqQCzteUKwNS+7PiqHITRAZrh0AegfWloaMg7evztb3+LF198MQ+mZ1cg9+vXL90DKIeBAwfGnnvuGddff3088sgj8bOf/SwWX3zxtBcA+CLdunWLnXfeOc0gYsstt8wv8AOgOo0cOTJ22WWXvCPtM888E/fff3+cdNJJse222+bHz1CpsufnpptumnfAzTr0vfHGGzFt2rQ46qijYqONNooePXqkewKVbvjw4WkELePYFGC20aNHpxG03IILLphGbauuyaVmhbz53syY/IeH0gxm+8cUHwq15qL7XonjbnouzaD0RvXrGidtvEiaAZUsC8Fedtll8de//jVuvfXWVAVaS+/evWPzzTePL3/5y7H++uunKgAwP5599tlYcskl44UXXkgV2jnJUAEAAB4TSURBVLNsdZmll146zQCoNY8++mjcddddcdttt8Xtt98ed9xxRzzxxBNpL7Sd8ePH553PV1pppZgwYUKMGDEi7QGq3cUXXxybbbZZmsH8y1ZA1XgG4CNXXHFFTJo0Kc2gZQ444IA4/PDD06ztCKMXJIxOc4TRa48wOq1tVL/6OGnjoWkGVIvnn38+Xzo2u2Vd1F977bW0B2iJAQMGxNZbb52H0Nddd91UBQBK4e9//3ust956aUZ7lXXO3XXXXdMMgPbipZdeykPpWUA922a36dOnp73QMn379s0vfFxmmWViscUWyy96y4Lo9fX16R5ALVpiiSXi3nvvTTMobq211oqrrroqzQDIZN+jNcajFLIL1RdddNE0azvC6AUJo9McYfTaI4xOaxvdrz5OFEaHqpctJ5uFe7KTZldffXWqAvNi4YUXjm222Sa22GKLWHXVVVMVAGgNZ555Zuywww5pRntz8MEHxyGHHJJmABBx880358H0WZ3Us9Uz3njjjbQXPq1nz555+DQLnmfbLHyebRdaaKF0D6A9ue6662K11VZLMyimoaEh/x4yduzYVAEg85///CeWWmqpNIP588Mf/jB+9rOfpVnbEkYvSBid5gij1x5hdFqbMDrUnrfffjuuvfbaPJj+j3/8Iz+ZBnzayJEj8/D5VlttFSussEKqAgBt4S9/+UseSM86pNJ+HH300bH33nunGQA0b8aMGfHggw/mwfSHHnoo7r///rzz7TPPPJPuQa3LAuYjRoyIxRdfPD+HM3r06HybNRQA+KSTTz45dttttzSDeXfRRRfFl770pTQD4JPOP//82HbbbdMMislWH7/yyivTrO0JoxckjE5zhNFrjzA6rU0YHWrfq6++mgfT//nPf+a37GpmaG+yDllrrrlmrL322vk2+wETACif5557Lr773e/GueeemyrUqokTJ+Yd0SdNmpQqADB/so7pWQf1LKj+wAMP5OMsrJ4F1aku/fv3z8PmWbg8O0czdOjQGDNmTD4uxzLuQHXLmvPsvPPO+cVLMDfZbwUnnniiIDrAXGT5gu222y4/jwvzor6+Pg444IA46KCDUqU8hNELeuu9mbGJMDpzIIxee4TRaW3C6ND+vPzyy/nyldkJ2mw7bdq0tAdqx6zw+axb1kELAKg8L7zwQt5pJ1vRJ/te+vTTT6c9VLPhw4fnP+xvs802eRgdAFpbFlDPbnfffXc89dRTeRf1Z599Nv9ukW2zZg20jYaGhvy8TBY0HzJkSAwbNizfZt8PBg8enHc7B2gNl156aZx99tn58WV2rAmflH027bvvvnkn/eyzCoB587vf/S4uuOCCuOaaa+LNN99MVZht5ZVXjk022SR22WWX6NevX6qWjzB6QcLoNEcYvfYIo9PahNGBTHbwOCuc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",
                                                        width: 150
                                                    },
                                                    {
                                                        text: 'Icatch Design S.R.L.',
                                                        style: 'company'
                                                        
                                                    },
                                                
                                                    {
                                                        text: 'Str. Bulevardul Poligrafiei, nr. 75, Sectorul 1, Bucuresti'
                                                        
                                                    },
                                                    {
                                                        text: that.getTranslation('Warehouse',packageDetails.currency)+': Str. Virginia nr.3, km 13, A1, Bussiness Park,'
                                                    },
                                                    {
                                                        text: 'Neamtiu Spedition, 077096, Dragomiresti Deal, Jud.Ilfov',
                                                    },
                                                    {
                                                        columns: 
                                                        [
                                                            {text: that.getTranslation('Share_Capital',packageDetails.currency)+':',  width: 100 },
                                                            {text: '200 RON'},
                                                        ],
                                                        style: 'separator'
                                                    },
                                                    {
                                                        columns: 
                                                        [
                                                            {text: that.getTranslation('VAT_Number',packageDetails.currency)+':',  width: 100},
                                                            {text: 'RO33302129'},
                                                        ]
                                                    },
                                                    {
                                                        columns: 
                                                        [
                                                            {text: that.getTranslation('Registration_Number',packageDetails.currency)+':',  width: 100},
                                                            {text: 'J40/7381/2014'},
                                                        ]
                                                    },
                                                    {
                                                        columns: 
                                                        [
                                                            {text: that.getTranslation('Bank',packageDetails.currency)+':', width: 100},
                                                            {text: 'BRD - Groupe Societe Generale S.A.'},
                                                            
                                                        ],
                                                        style: 'separator'
                                                    },
                                                    {
                                                        columns: 
                                                        [
                                                            {text: 'IBAN RON:',  width: 100},
                                                            {text: 'RO11BRDE441SV22383144410'},
                                                            
                                                        ]
                                                    },
                                                    {
                                                        columns: 
                                                        [
                                                            {text: 'SWIFT:',  width: 100},
                                                            {text: 'BRDEROBUXXX'},
                                                            
                                                        ]
                                                    },
                                                    {
                                                        columns: 
                                                        [
                                                            {text: 'IBAN EUR:',  width: 100},
                                                            {text: 'RO07BRDE441SV22383224410'},
                                                            
                                                        ]
                                                    },

                                                ],
                                    
                                                [
                                                    {
                                                        columns: 
                                                        [
                                                            {text: that.getTranslation(typeName+'_Number',packageDetails.currency) + ':',  width: 100},
                                                            {text: fileNumber},
                                                            
                                                        ],
                                                        style: 'boldInfoRight'
                                                    },
                                                    {
                                                        columns: 
                                                        [
                                                            {text: that.getTranslation('Date',packageDetails.currency)+':',  width: 100},
                                                            {text: convertMysqlDate(generatedDate)},
                                                            
                                                        ],
                                                        style: 'boldInfoRight'
                                                    },
                                                    {
                                                        columns: 
                                                        [
                                                            {text: that.getTranslation('Quote_Number',packageDetails.currency)+':',  width: 100},
                                                            {text: packageDetails.quote_id},
                                                            
                                                        ],
                                                        style: 'boldInfoRight'
                                                    },
                                                    {
                                                        columns: 
                                                        [
                                                            {text: that.getTranslation('Quote_Name',packageDetails.currency)+':',  width: 100},
                                                            {text: params.quoteName},
                                                            
                                                        ],
                                                        style: 'boldInfoRight'
                                                    },
                                                    {
                                                        text: packageDetails.clientDetails.name,
                                                        style: 'companyRight'
                                                    },
                                                    {
                                                        text:  packageDetails.clientDetails.address,
                                                        style: 'columnRight'                                                   
                                                    },
                                                    {
                                                        columns: 
                                                        [
                                                            {text: that.getTranslation('VAT_Number',packageDetails.currency)+':',  width: 100 },
                                                            {text: packageDetails.clientDetails.fiscal_code},
                                                        ],
                                                        style: 'columnRight'
                                                    },
                                                    {
                                                        columns: 
                                                        [
                                                            {text: that.getTranslation('Registration_Number',packageDetails.currency)+':',  width: 100 },
                                                            {text: packageDetails.clientDetails.registry},
                                                        ],
                                                        style: 'columnRight'
                                                    },
                                                    {
                                                        columns: 
                                                        [
                                                            {text: that.getTranslation('Bank',packageDetails.currency)+':', width: 100},
                                                            {text: packageDetails.clientDetails.bank},
                                                            
                                                        ],
                                                        style: 'columnRightBank'
                                                    },
                                                    {
                                                        columns: 
                                                        [
                                                            {text: 'IBAN:',  width: 100},
                                                            {text: packageDetails.clientDetails.bank_account},
                                                            
                                                        ],
                                                        style: 'columnRight'
                                                    },
                                                ], 
                                            ], 
                                            style: 'marginBottom20'
                                        },

                                    ];

                                var docStyles = {
                                       company: 
                                       {
                                           fontSize: 20,
                                           bold: true,
                                           margin:[0, 30, 0, 10]
                                       },
                                       companyRight: 
                                       {
                                           fontSize: 20,
                                           bold: true,
                                           margin:[10, 30, 0, 10]
                                       },
                                        separator : {
                                            margin:[0, 15, 0, 0]        
                                       },

                                       marginBottom20 : {
                                            margin:[0, 0, 0, 20]        
                                       },

                                       marginBottom10 : {
                                            margin:[0, 0, 0, 10]        
                                       },

                                       marginBottom5 : {
                                            margin:[0, 0, 0, 5]        
                                       },
                                       
                                        boldInfoStart: 
                                       {
                                           fontSize: 12,
                                           bold: true,
                                           margin:[0, 15, 0, 0]
                                       },
                                        boldInfo: 
                                       {
                                           fontSize: 12,
                                           bold: true,
                                       },
                                       boldInfoRight: 
                                       {
                                           fontSize: 12,
                                           bold: true,
                                           margin:[10,0,0,0]
                                       },
                                       columnRight: {
                                        margin:[10,0,0,0]
                                       },
                                       columnRightBank: {
                                        margin:[10,15,0,0]
                                       },
                                       tableHeader: {
                                            //fillColor: '#dbdbdb',
                                            margin: [1,1,1,1],
                                            bold: true,
                                            alignment: 'center',
                                            fontSize: 7
                                        
                                        },
                                        tableFooter: {
                                            //fillColor: '#dbdbdb',
                                            margin: [1,1,1,1],
                                            bold: true,
                                            fontSize: 7,
                                            alignment:'center'
                                        },
                                        tableBodyEven: {
                                            alignment: 'center',
                                            //fillColor: '#eeeeee',
                                            margin: [1,1,1,1],
                                            fontSize: 7
                                        },
                                        tableBodyOdd: {
                                            alignment: 'center',
                                            margin: [1,1,1,1],
                                            fontSize: 7
                                        },
                                        offerPrice: {
                                            fontSize: 12,
                                            bold: true,
                                            margin: [0,5,0,5]
                                        },
                                        offerPriceValue: {
                                            fontSize: 12,
                                            bold: true,
                                            alignment: 'right',
                                            margin: [0,5,0,5]
                                        },
                                        offerTotal: {
                                            fontSize: 8,
                                            margin: [0,5,0,5]
                                        },
                                        offerTotalValue: {
                                            fontSize:8,
                                            alignment: 'right',
                                            margin: [0,5,0,5]
                                        },
                                        dueDateValue: {
                                            alignment: 'right',
                                            margin: [0,5,0,5] 
                                        },
                                        dueDate: {
                                            margin: [0,5,0,5] 
                                        }
                                    };

       var pdfData = {
            "invoiceDetails": invoiceDetails,
            "docStyles": docStyles
        };

        return pdfData
    }


    getTranslation(key, currency){
        var translation = {
            "Warehouse": {
                "Ron": "Depozit",
                "Euro": "Warehouse"
            },
            "Share_Capital": {
                "Ron": "Capital Social",
                "Euro": "Share Capital"
            },
            "VAT_Number": {
                "Ron": "Numar TVA",
                "Euro": "VAT Number"
            },
            "Registration_Number": {
                "Ron": "Numar Inregistrare:",
                "Euro": "Registration Number"
            },
            "Bank": {
                "Ron": "Banca",
                "Euro": "Bank"
            },
            "Date": {
                "Ron": "Data",
                "Euro": "Date"
            },
            "Quote_Number": {
                "Ron": "Numar Oferta",
                "Euro": "Quote Number"
            },
            "Quote_Name": {
                "Ron": "Nume Oferta",
                "Euro": "Quote Name"
            },
            "Quote_Id": {
                "Ron": "Numar Oferta",
                "Euro": "Quote Id"
            },
            "Index": {
                "Ron": "Nr. Crt",
                "Euro": "Index"
            },
            "Client_Name": {
                "Ron": "Nume Client",
                "Euro": "Client Name"
            },
            "Quote_Item_Id": {
                "Ron": "Quote Item Id",
                "Euro": "Quote Item Id"
            },
            "Product_Id": {
                "Ron": "Cod Produs",
                "Euro": "Product Id"
            },
            "Product_Name": {
                "Ron": "Nume Produs",
                "Euro": "Product Name"
            },
            "Quote_Quantity": {
                "Ron": "Cantitate Oferta",
                "Euro": "Quote Quantity"
            },
            "Reserved": {
                "Ron": "Rezervat",
                "Euro": "Reserved"
            },
            "Stock": {
                "Ron": "Stoc",
                "Euro": "Stock"
            },
            "Invoiced": {
                "Ron": "Facturat",
                "Euro": "Invoiced"
            },
            "Extra_Discount": {
                "Ron": "Discount",
                "Euro": "Discount"
            },
            "Unit_Price": {
                "Ron": "Pret / buc fara TVA",
                "Euro": "Unit Price"
            },
            "Package_Quantity": {
                "Ron": "Cant.",
                "Euro": "Qty."
            },
            "Value": {
                "Ron": "Valoare fara TVA",
                "Euro": "Value"
            },
            "Green_Tax_Total": {
                "Ron": "Total Taxa Verde",
                "Euro": "Green Tax Total"
            },
            "Green_Tax_PC": {
                "Ron": "Taxa Verde / buc",
                "Euro": "Green Tax / pc"
            },
            "VAT": {
                "Ron": "TVA",
                "Euro": "VAT"
            },
             "Item_Total": {
                "Ron": "Total + TVA",
                "Euro": "Item Total"
            },
            "Owner": {
                "Ron": "Responsabil",
                "Euro": "Owner"
            },
            "Type": {
                "Ron": "Tip",
                "Euro": "Type"
            },
             "Subtotals": {
                "Ron": "Subtotal",
                "Euro": "Subtotals"
            },
            "Total_Advance": {
                "Ron": "Total Avans",
                "Euro": "Total Advance"
            },
            "Total_Reversal": {
                "Ron": "Total Storno",
                "Euro": "Total Reversal"
            },
             "Remaining": {
                "Ron": "Ramas",
                "Euro": "Remaining"
            },
            "Invoice_Total": {
                "Ron": "Total Factura",
                "Euro": "Invoice Total"
            },
             "Due_Date": {
                "Ron": "Data Scadenta",
                "Euro": "Due Date"
            },
            "Exchange_Rate": {
                "Ron": "Curs Valutar",
                "Euro": "Exchange Rate"
            },
            "AWB_Number": {
                "Ron": "Numar Aviz",
                "Euro": "AWB Number"
            },
             "Invoice_Number": {
                "Ron": "Numar Factura",
                "Euro": "Invoice Number"
            },
            "Bank": {
                "Ron": "Banca",
                "Euro": "Bank"
            },

        };

        //console.log(key, currency, translation[key][currency]);


        return translation[key][currency]
    }

    getColumnsArray(params){

        var columnMapping = {
                "index" : {
                    "column_id": 2,
                    "initial_position": 1,
                    "position_increment": {
                        "euro" : 0,
                        "extra_discount": 0,
                        "ron": 0
                    },
                    "width": 12

                },
                "product_id" : {
                    "column_id": 6,
                    "initial_position": 2,
                    "position_increment": {
                        "euro" : 0,
                        "extra_discount": 0,
                        "ron": 0
                    },
                    "width": 45

                },
                "product_name" : {
                    "column_id": 7,
                    "initial_position": 3,
                    "position_increment": {
                        "euro" : 0,
                        "extra_discount": 0,
                        "ron": 0
                    },
                    "width": "*"

                },
                // "extra_discount_value" : {
                //     "column_id": 12,
                //     "initial_position": 0,
                //     "position_increment": {
                //         "euro" : 0,
                //         "extra_discount": 0,
                //         "ron": 0
                //     },
                //     "width": 30
                // },
                "package_quantity" : {
                    "column_id": 15,
                    "initial_position": 4,
                    "position_increment": {
                        "euro" : 0,
                        "extra_discount": 1,
                        "ron": 0
                    },
                    "width": 'auto'
                },
                "unit_price_before_discount" : {
                    "column_id": 13,
                    "initial_position": 5,
                    "position_increment": {
                        "euro" : 0,
                        "extra_discount": 1,
                        "ron": 0
                    },
                    "width": 40
                },
                "green_tax" : {
                    "column_id": 17,
                    "initial_position": 0,
                    "position_increment": {
                        "euro" : 0,
                        "extra_discount": 1,
                        "ron": 6
                    },
                    "width": 21
                },
                "value_before_discount" : {
                    "column_id": 16,
                    "initial_position": 6,
                    "position_increment": {
                        "euro" : 0,
                        "extra_discount": 1,
                        "ron": 1
                    },
                    "width": 45
                },
                "vat_value_before_discount" : {
                    "column_id": 19,
                    "initial_position": 7,
                    "position_increment": {
                        "euro" : 0,
                        "extra_discount": 1,
                        "ron": 1
                    },
                    "width": 35
                },
                "item_total" : {
                    "column_id": 20,
                    "initial_position": 8,
                    "position_increment": {
                        "euro" : 0,
                        "extra_discount": 1,
                        "ron": 1
                    },
                    "width": 45
                },
                // "green_tax_total" : {
                //     "column_id": 17,
                //     "initial_position": 0,
                //     "position_increment": {
                //         "euro" : 0,
                //         "extra_discount": 1,
                //         "ron": 10
                //     },
                //     "width": 25
                // },

            }

            var columnsArray = {
                "columns_order": [],
                "widths": [],
                "columns_data": {}
            }

            Object.keys(columnMapping).forEach(function(key, index){

                var val = columnMapping[key];

                var euro_increment = params.euro ? val.position_increment.euro : 0;

                var extra_discount_increment = params.extra_discount ? val.position_increment.extra_discount : 0;

                extra_discount_increment =  0; //Removed from line position

                var ron_increment = params.ron ? val.position_increment.ron : 0;


                var final_position_increment = euro_increment + extra_discount_increment + ron_increment

                var arrayPosition = (val.initial_position - 1) + final_position_increment;

                //console.log(val.column_id, arrayPosition)

                if( (arrayPosition == 0 && columnsArray.columns_order.length == 0) || arrayPosition > 0)
                {
                    columnsArray.columns_order[arrayPosition] = val.column_id
                    columnsArray.widths[arrayPosition] = val.width
                }

                columnsArray.columns_data[key] = arrayPosition

                
            });

            //console.log(columnsArray);

            return columnsArray

    }

    getExportFileName(params){
        //console.log('a',this, params )

        var prefix = "RON";

        if(this.packageDetails.country !== "RO") {
                prefix = "EXT"
        }

        return prefix+'-'+this.packageDetails.invoiceNumber+'-'+Date.now();
    }
}

