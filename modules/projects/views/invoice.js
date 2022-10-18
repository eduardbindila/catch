class Invoices {
    constructor() { 
      this.packageTable = [];
    }

    setPackageLine(params) {

      var packageId = params.packageId;

      var packageDate = params.packageDate;

      var packageStatus = params.packageStatus

      var collapserId = 'collapse-'+packageId;

      var packageLine = '<div class="package_line m-t-10">'+
                           '<div class="package_wrapper">'+
                               '<button class="btn btn-default collapser triggerPackageItems"'+
                               ' type="button" data-toggle="collapse"'+
                               ' href="#'+collapserId+'" aria-expanded="false"'+
                               ' aria-controls="'+collapserId+'" data-package='+packageId+'>'+
                                   '<span class="packageId">'+
                                       '<i class="material-icons">folder</i>'+
                                       'Package <b>'+packageId+'</b>'+ 
                                   '</span>'+
                                   '<span class="packageDate">'+
                                       'created on <b>'+packageDate+'</b>'+
                                   '</span>'+
                                   '<span class="packageStatus">'+
                                       'Status: <b>'+packageStatus+'</b>'+
                                   '</span>'+
                               '</button>'+
                               '<div class="btn-group btn-group-sm right"'+
                               ' role="group" aria-label="Large button group">'+
                                   '<button type="button" data-type="generate_pos" data-package='+packageId+' '+
                                   ' class="btn btn-info waves-effect package_status_change">'+
                                   'Generate POS</button>'+
                               '<button type="button" data-package='+packageId+' data-type="generate_delivery_note"  class="btn btn-primary waves-effect package_status_change">'+
                               'Generate Delivery Note</button>'+
                               '<button type="button" data-package='+packageId+' data-type="generate_invoice"  class="btn btn-success waves-effect package_status_change">'+
                               'Generate Invoice</button>'+
                               '</div>'+
                               
                           '</div>'+
                           '<div class="collapse" id="'+collapserId+'" aria-expanded="true"'+
                           ' style="">'+
                               '<table class="packages_table-'+packageId+' table table-striped table-bordered table-hover dt-responsive display">'+
                                   '<thead>'+
                                        '<th></th>'+
                                       '<th>Id</th>'+
                                       '<th>Product Id</th>'+
                                       '<th>Product Name</th>'+
                                       '<th>QQuantity</th>'+
                                       '<th>Reserved</th>'+
                                       '<th>Stock</th>'+
                                       '<th>Invoiced</th>'+
                                       '<th>Package Quantity</th>'+
                                   '</thead>'+
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
         
         var packageDetails = {
            'packageId': thisPackage.id,
            'packageDate': thisPackage.created_date,
            'packageStatus': thisPackage.name

         }
         var packageLine = Invoice.setPackageLine(packageDetails);

         $(packageContainer).append(packageLine);

         that.packageTable[thisPackage.id] = $('.packages_table-'+thisPackage.id).DataTable({
                     "ajax": {
                        "url": "/ajax/getPackageItems/",
                        "dataSrc": "",
                        "type": 'POST',
                        "data": {'package_id': thisPackage.id}
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
                            extend: 'csv',
                            className: 'btn btn-lg btn-primary waves-effect hidden',
                            name:"generate_pos",
                            text:'Generate POS',
                            exportOptions: {
                              stripHtml: true,
                              orthogonal: null,
                              //columns: [ 1, 4, 5, 6, 7, 13, 14, 15, 18, 19, 20 ]
                            }, footer: true
                        }
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
                            "data": "quote_item_id",
                        },
                         { 
                            "data": "product_id",
                        },
                        { 
                            "data": "product_name",
                        }
                        ,
                        { 
                            "data": "quantity",
                        },
                        { 
                            "data": "reserved_stock",
                        },
                        { 
                            "data": "saga_quantity",
                        },
                        { 
                            "data": "invoiced_quantity",
                        },
                        { 
                            "data": "package_quantity",
                             "render" : function(data, type, row, meta) {
                                return '<div class="form-group">' + 
                                            '<div class="form-line">' + 
                                                '<input class="form-control package-quantity-input"' + 
                                                ' data-type="external_item_name" data-row="'+meta.row+
                                                '" data-col="'+meta.col+
                                                '" data-quote_item="'+row.quote_item_id+
                                                '" data-package_item="'+row.id+
                                                '" data-product="'+row.product_id+
                                                '" value="'+data+'" type="number" name="package_quantity"'+
                                                ' placeholder="Package Quantity"  min=0 required>' + 
                                            '</div>' + 
                                        '</div>'
                              }
                        }
                    ],
                    "initComplete": function(settings, json) {
                    }

                })
      });
      

    }

    changeStatus(params){
        console.log( params);
        this.packageTable[3].buttons(params.statusType+':name').trigger();
    }
}