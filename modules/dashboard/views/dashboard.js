$(document).ready(function() {
    var projectsTable = $('.projects_legacy').DataTable({
            "ajax": {
                "url": "/ajax/getDashboardProjects",
                "type": "POST",
                "data": function ( d ) {
                    d.legacy = true;
                },
                "dataSrc": ""
            },
           // buttons: [
           //      {
           //          extend: 'searchPanes',
           //          config: {
           //              cascadePanes: true
           //          }
           //      }
           //  ],
           //  dom: 'Bfrtip',
            searchPanes:{
                cascadePanes: true,
                viewTotal: true,
                layout: 'columns-1',
                dataLength: 20,
                // preSelect: [
                //     {
                //         column: 11,
                //         rows: ['2022']
                //     },
                //     {
                //         column: 4,
                //         rows: [ownerName]
                //     },

                // ]

            },
            
            dom: '<"dtsp-verticalContainer"<"dtsp-verticalPanes"P><"dtsp-dataTable"frtip>>',
            columnDefs: 
            [
                {
                    searchPanes: {
                        show: false
                    },
                    targets: ['hideFromfilters'],
                },

                // {
                //     searchPanes: {
                //         show: true
                //     },
                //     targets: [11, 4],
                // }             
            ],
            pageLength: 50,
                "paging":   true,
                "ordering": true,
                "searching": true,
            rowId: 'category_slug',
              rowGroup: {
                startRender: function ( rows, group ) {
               
               var projectName = rows.data()[0].project_name;
               var projectId = rows.data()[0].project_id;
               var projectStatus = rows.data()[0].project_status;

               var projectValue = rows.data().pluck('quote_price').reduce(function(a, b, i){
                var isMaster = rows.data().pluck('isMaster');
                var quoteId = rows.data().pluck('id');
                //console.log(quoteId[i], isMaster[i]);

                if(isMaster[i] > 0) {

                    a = a + parseFloat(b);
                }

                return a;

               }, 0);

 
                return $('<tr/>')
                    .append( '<td> Project:'+ projectId +'</td>')
                    .append( '<td>'+ projectName +'</td>')
                    .append( '<td colspan="4"></td>')
                    .append( '<td>'+ projectStatus +'</td>')
                    .append( '<td>'+ projectValue +'</td>')
                    .append( '<td></td>')
                    .append( '<td>Is Master</td>')
            },
                dataSrc: "project_id"
            },
            responsive: true,
            order: [0],
            "columns": [ 
                { 
                    "data": "project_id",
                    "render" : function(data, type, row) {
                        return '<a href="/project/'+data+'" class="btn btn-link" target="_blank">'+data+'</a>'
                      },
                },
                
                { 
                    "data": "name"
                },
                { 
                    "data": "project_name",
                    
                    "visible": false
                },
                { 
                    "data": "id",
                     "render" : function(data, type, row) {
                        return '<a href="/quote/'+data+'" class="btn btn-block" target="_blank">'+data+'</a>'
                      },
                },
                { 
                    "data": "owner",
                },
                { 
                    "data": "client"
                },
                { 
                    "data": "start_date",
                     "render" : function(data, type, row) {
                        return convertMysqlDate(data)
                      },

                },
                { 
                    "data": "quote_status"
                },
                { 
                    "data": "quote_price"
                },
                { 
                    "data": "winning_chance"
                },
                { 
                    "data": "isMaster",
                    "render" : function(data, type, row) {

                        if(data > 0)
                            return '<div ><strong>Yes</strong></div>'
                        else
                            return '<div ><strong>No</strong></div>'

                      },
                },
                { 
                    "data": "start_year",
                    "visible": false
                },
                { 
                    "data": "start_quarter",
                    "visible": false
                },
                { 
                    "data": "start_month",
                    "visible": false
                },
                { 
                    "data": "project_status",
                    "visible": false
                },
                
            ],
            "initComplete": function(settings, json) {
                
            },
           
                
                

        });

$('.projects_legacy').dataTable().fnFilterOnReturn();

    var atentionTable = $('.quotes_attention').DataTable({
            "ajax": {
                "url": "/ajax/getQuotes",
                "dataSrc": ""
            },
        
            pageLength: 100,
                "paging":   true,
                "ordering": true,
                "searching": true,
            rowId: 'category_slug',
              
            responsive: true,
            order: [2],
            "columns": [
                { 
                    "data": "project_id",
                    
                },
                { 
                    "data": "project_name"
                },
                { 
                    "data": "id",
                    "render" : function(data, type, row) {
                        return '<a href="/quote/'+data+'" class="btn btn-block" target="_blank">'+data+'</a>'
                      } 
                },
                { 
                    "data": "client_name",
                     "render" : function(data, type, row) {
                        var successClass = '';

                        if(row.quote_status == 3 && row.client_approved == 1) {
                            successClass="label label-success"
                        }

                        return '<div class="' + successClass + '">' + data + '</div>'
                      } 
                },
                { 
                    "data": "start_date",
                     "render" : function(data, type, row) {
                        return convertMysqlDate(data)
                      },
                },
                { 
                    "data": "offer_date",
                     "render" : function(data, type, row) {
                        return convertMysqlDate(data)
                      },
                },
                { 
                    "data": "quote_price"
                },
                { 
                    "data": "status",
                    "render" : function(data, type, row) {
                        var dangerClass = '';

                        if(row.quote_status == 5) {
                            dangerClass="label label-primary"
                        } else {
                            dangerClass = "";
                        }

                        return '<div class="' + dangerClass + '">' + data + '</div>'
                      } 
                },
                { 
                    "data": "profit_percent",
                    "render" : function(data, type, row) {
                        var dangerClass = '';

                        if(row.quote_status == 7 && data < 30) {
                            dangerClass="label label-danger"
                        }

                        return '<div class="' + dangerClass + '">' + data + '</div>'
                      } 
                },
                { 
                    "data": "winning_chance"
                }
                
            ],
            "initComplete": function(settings, json) {
            }

        });

    var fileAtentionTable = $('.files_attention').DataTable({
            "ajax": {
                "url": "/ajax/getQuoteFiles",
                "dataSrc": "",
            },
        
            pageLength: 5,
                "paging":   true,
                "ordering": true,
                "searching": true,
            rowId: 'category_slug',
              
            responsive: true,
            order: [2],
            "columns": [ 
                { 
                    "data": "project_id",
                },
                { 
                    "data": "project_name",
                },
                { 
                    "data": "quote_id",
                    "render" : function(data, type, row) {
                        return '<a href="/project/'+row.project_id+'#linkQuote-'+data+'" class="btn btn-block" target="_blank">'+data+'</a>'
                      } 
                },
                { 
                    "data": "client_name"
                },
                { 
                    "data": "file_path"
                },
                { 
                    "data": "file_type"
                },
                { 
                    "data": "name",
                },
                { 
                    "data": "date",
                    "render" : function(data, type, row) {
                        var date = new Date(data*1000)
                        return date.toLocaleDateString();
                  } 
                },
                { 
                    "data": "sent_date",
                     "render" : function(data, type, row) {
                        
                        var rowDate = new Date(row.date*1000) 

                        // To calculate the time difference of two dates 
                        var Difference_In_Time = new Date() - rowDate.getTime(); 
                          
                        // To calculate the no. of days between two dates 
                        var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);                         
                        
                        return Math.trunc(Difference_In_Days);
                      } 
                }
                
            ],
            "initComplete": function(settings, json) {
            }

        });

    var quotesTable = $('.quotes-table').DataTable({
            "ajax": {
                "url": "/ajax/getDashboardQuotes",
                "type": "POST",
                "data": function ( d ) {
                    d.legacy = true;
                },
                "dataSrc": ""
            },
        
            pageLength: 5,
                "paging":   true,
                "ordering": true,
                "searching": true,
            rowId: 'category_slug',
              
            responsive: true,
            order: [2],
            "columns": [ 
                { 
                    "data": "id",
                    "render" : function(data, type, row) {
                        return '<a href="/quote/'+data+'" class="btn btn-block" target="_blank">'+data+'</a>'
                      } 
                },
                { 
                    "data": "start_date",
                     "render" : function(data, type, row) {
                        return convertMysqlDate(data)
                      },
                },
                { 
                    "data": "offer_date",
                     "render" : function(data, type, row) {
                        return convertMysqlDate(data)
                      },
                },
                 { 
                    "data": "name"
                },
                 { 
                    "data": "project_value"
                },
                { 
                    "data": "owner"
                },
                { 
                    "data": "quote_status"
                },
                
            ],
            "initComplete": function(settings, json) {
            }

        });

var collapsedGroups = {};


         var logisticTable = $('.logistic_details-table').DataTable({
            "ajax": {
                "url": "/ajax/getDashboardLogisticData",
                "type": "POST",
                "dataSrc": ""
            },
            pageLength: 500,
                "paging":   true,
                "ordering": true,
                "searching": true,
            rowId: 'category_slug',
rowGroup: {
  startRender: function (rows, group) {
    var quoteId = rows.data()[0].quote_id;
    var quoteName = rows.data()[0].quote_name;
    var quoteStatus = rows.data()[0].quote_status;
    var owner = rows.data()[0].owner;
    var clientName = rows.data()[0].client_name;
    var childRows = rows.nodes().to$();
    var totalChildRows = childRows.length;
    var totalFullfilledRatio = 0;
    var totalInTransitRatio = 0;
    var totalInTransitQuantity = 0;
    var totalOrderedQuantity = 0;
    var totalReceivedRatio = 0;
    var totalInvoicedRatio = 0;
    var fullfilledColor = '';
    var inTransitColor = '';
    var receivedColor = '';
    var invoicedColor = '';

    childRows.each(function () {
     var rowData = rows.row(this).data();
      if (parseInt(rowData.quote_fullfilled_ratio) === 100) {
        totalFullfilledRatio += 1;
      }

      if (parseInt(rowData.totalInTransitRatio) === 100 ) {
        totalInTransitRatio += 1;
      }

      if (parseInt(rowData.in_transit_quantity) ) {
        totalInTransitQuantity += parseInt(rowData.in_transit_quantity);
      }

      if(totalInTransitQuantity == 0) totalInTransitQuantity = "-";

      if (parseInt(rowData.ordered_quantity)) {
        totalOrderedQuantity += parseInt(rowData.ordered_quantity);
      }

      if (parseInt(rowData.received_order_ratio) === 100) {
        totalReceivedRatio += 1;
      }
      if (parseInt(rowData.invoiced_order_ratio) === 100) {
        totalInvoicedRatio += 1;
      }
      $(this).attr('data-child-quote-id', quoteId); // Add data attribute to child rows
    });

    //console.log(totalFullfilledRatio, totalInTransitRatio, totalReceivedRatio, totalInvoicedRatio);

    // Calculate the fraction ratios
    var fullfilledRatio = totalFullfilledRatio + '/' + totalChildRows;
    var inTransitRatio = totalInTransitRatio + '/' + totalChildRows;
    var receivedRatio = totalReceivedRatio + '/' + totalChildRows;
    var invoicedRatio = totalInvoicedRatio + '/' + totalChildRows;

// Calculate the ratio percent
var totalFullfilledRatioPercent = (totalFullfilledRatio / totalChildRows) * 100;
var totalInTransitRatioPercent = (totalInTransitRatio / totalChildRows) * 100;
var totalReceivedRatioPercent = (totalReceivedRatio / totalChildRows) * 100;
var totalInvoicedRatioPercent = (totalInvoicedRatio / totalChildRows) * 100;

// Get the ratio icon and color class
var fullfilledRatio = getRatio(totalFullfilledRatioPercent, totalFullfilledRatio + '/' + totalChildRows);
var inTransitRatio = getRatio(totalInTransitQuantity, totalInTransitQuantity + '/' + totalOrderedQuantity,"full", 1);
var receivedRatio = getRatio(totalReceivedRatioPercent, totalReceivedRatio + '/' + totalChildRows);
var invoicedRatio = getRatio(totalInvoicedRatioPercent, totalInvoicedRatio + '/' + totalChildRows);

// Create the parent row
var parentRow = $('<tr/>')
  .addClass('parent-row collapsible_group')
  .append('<td colspan="">' + quoteId + '</td>')
  .append('<td colspan="">' + quoteName + '</td>')
  .append('<td colspan="2">' + quoteStatus + '</td>')
  .append('<td colspan="2">' + owner + '</td>')
  .append('<td colspan="">' + clientName + '</td>')
  .append('<td>'+ fullfilledRatio.label + '</td>')
  .append('<td>'+ inTransitRatio.label + '</td>')
  .append('<td>'+ receivedRatio.label + '</td>')
  .append('<td>'+ invoicedRatio.label + '</td>')

    // Hide the child rows initially
    childRows.hide();

    // Attach click event to parent row for toggling child rows visibility
    parentRow.on('click', function () {
      childRows.toggle();
    });

    // Add data attribute to parent row
    parentRow.attr('data-parent-quote-id', quoteId);

    return parentRow;
  },
  dataSrc: "quote_id"
},       
            responsive: true,
            "columns": [ 
                { 
                    "data": "quote_id",
                    "render" : function(data, type, row) {
                        return '<a href="/quote/'+data+'" class="btn btn-block" target="_blank">'+data+'</a>'
                      } 
                },
                { 
                    "data": "quote_name"
                },
                { 
                    "data": "quote_status"
                },
                 { 
                    "data": "product_id"
                },
                 { 
                    "data": "date_added",
                     "render" : function(data, type, row) {
                        return convertMysqlDate(data)
                      },
                },
                { 
                    "data": "owner"
                },
                { 
                    "data": "client_name"
                },

                {
                    "data": 'quote_fullfilled_ratio',
                    "render" : function(data, type, row) {

                        var ratio = getRatio(data,row.quote_fulfilled_quantity + '/' + row.quantity,"" );
                        //console.log(row);

                        return ratio.label
                      } 

                },
                {
                    "data": 'order_in_transit_ratio',
                    "render" : function(data, type, row) {

                         var ratio = getRatio(data,row.in_transit_quantity + '/' + row.ordered_quantity,"", 1 );
                        //console.log(data);

                        return ratio.label
                      } 

                },
                {
                    "data": 'received_order_ratio',
                    "render" : function(data, type, row) {

                         var ratio = getRatio(data,row.received_quantity + '/' + row.quantity,""  );
                        //console.log(data);

                        return ratio.label
                      } 

                },
                {
                    "data": 'invoiced_order_ratio',
                    "render" : function(data, type, row) {

                        var ratio = getRatio(data,row.invoiced_quantity + '/' + row.quantity,"" );
                        //console.log(data);

                        return ratio.label
                      } 

                },




                
            ],
            "initComplete": function(settings, json) {
                //console.log(json);
            },
             "rowCallback": function( row, data, index ) {
                              
    // if (data["quote_fullfilled_ratio"] == '100' && data["order_in_transit_ratio"] == '100' && data["received_order_ratio"] == '100' && data["invoiced_order_ratio"] == '100') {
    //     $(row).hide();
    // }
                 },

        });

    var invoicesTable = $('.invoices-table').DataTable({
            "ajax": {
                "url": "/ajax/getInvoicedPackages",
                "type": "POST",
                "dataSrc": ""
            },
        
            pageLength: 5,
                "paging":   true,
                "ordering": true,
                "searching": true,
            rowId: 'category_slug',
              
            responsive: true,
            "columns": [ 
                { 
                    "data": "quote_id",
                    "render" : function(data, type, row) {
                        return '<a href="/quote/'+data+'" class="btn btn-block" target="_blank">'+data+'</a>'
                      } 
                },
                { 
                    "data": "quote_name"
                },
                { 
                    "data": "id"
                },
                 { 
                    "data": "invoice_number"
                },
                 { 
                    "data": "invoice_date",
                     "render" : function(data, type, row) {
                        return convertMysqlDate(data)
                      },
                },
                { 
                    "data": "owner"
                },
                { 
                    "data": "client_name"
                },
                  { 
                    "data": "file_path",
                    "render" : function(data, type, row) {
                        return  '<a href="/viewFile?f='+data+'" target="_blank" >'+data+'</a>'
                      }
                },
                
            ],
            "initComplete": function(settings, json) {
                //console.log(json);
            }

        });
});


function getRatio(value, rate="", type="full", inTransit = "0"){

    //console.log(value);

    var ratioObject = {
        "icon": "",
        "colorClass": "",
        "fullClass": "",
        "label" : "",
        "rate": rate,
        "checkedClass": ""
    };

    switch(true) {

        case inTransit == 1 && value != "-" :

            ratioObject.icon =  "local_shipping";
            ratioObject.colorClass = "bg-blue";
            ratioObject.checkedClass = ""

        break; 

        case value == "-":

        ratioObject.icon = "local_shipping";
        ratioObject.colorClass = "bg-grey";
        ratioObject.checkedClass = "checked"
        ratioObject.rate = "-"
        
        break;

      case Number(value) == 0:

        ratioObject.icon = "error";
        ratioObject.colorClass = "bg-red";
        
        break;

      case Number(value) > 0 &&  Number(value) < 100:

        ratioObject.icon = icon = "warning";
        ratioObject.colorClass = "bg-orange";
        
        break;

    case Number(value) == 100:

        ratioObject.icon =  "check_circle";
        ratioObject.colorClass = "bg-green";
        ratioObject.checkedClass = "checked"
                
        break;
    }

    if(type == 'full') {
        ratioObject.colorClassFull = ratioObject.colorClass;
        ratioObject.colorClass = "";
        ratioObject.checkedClass = ""
    } 


    ratioObject.label = '<div class="info-box info-box-xs ' + ratioObject.checkedClass + ' small-width ' + ratioObject.colorClassFull + ' hover-expand-effect">'+
                    '<div class="icon '+ ratioObject.colorClass +'">'+ 
                        '<i class="material-icons">'+ ratioObject.icon +'</i>'+
                    '</div>'+
                    '<div class="content">'+
                        '<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">'+ ratioObject.rate +'</div>'+
                    '</div>'+
                '</div>'

    return ratioObject
}

