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
            pageLength: 100,
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
                        return '<a href="/project/'+data+'" class="btn btn-block" target="_blank">'+data+'</a>'
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
                    "data": "id"
                },
                { 
                    "data": "owner",
                },
                { 
                    "data": "client"
                },
                { 
                    "data": "specifyer_designer"
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
                    "data": "start_date"
                },
                { 
                    "data": "offer_date"
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
        
            pageLength: 100,
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
                    "data": "start_date"
                },
                { 
                    "data": "offer_date"
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



    var logisticTable = $('.logistic_details-table').DataTable({
            "ajax": {
                "url": "/ajax/getDashboardLogisticData",
                "type": "POST",
                "dataSrc": ""
            },
        
            pageLength: 100,
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
                    "data": "quote_value"
                },
                 { 
                    "data": "quote_status"
                },
                 { 
                    "data": "start_date"
                },
                { 
                    "data": "owner"
                },
                { 
                    "data": "client_name"
                },

                {
                    "data": 'supplier_order_sent_ratio',
                    "render" : function(data, type, row) {

                        var ratio = getRatio(data);

                        return '<i class="material-icons '+ ratio.colorClass +'">'+ ratio.icon +'</i>'
                      } 

                },
                {
                    "data": 'quote_delivered_ratio',
                    "render" : function(data, type, row) {

                        var ratio = getRatio(data);

                        return '<i class="material-icons '+ ratio.colorClass +'">'+ ratio.icon +'</i>'
                      } 

                },
                {
                    "data": 'quote_invoiced_ratio',
                    "render" : function(data, type, row) {

                        var ratio = getRatio(data);

                        //console.log(ratio);

                        return '<i class="material-icons '+ ratio.colorClass +'">'+ ratio.icon +'</i>'
                      } 

                }


                
            ],
            "initComplete": function(settings, json) {
                //console.log(json);
            }

        });

    var invoicesTable = $('.invoices-table').DataTable({
            "ajax": {
                "url": "/ajax/getInvoicedPackages",
                "type": "POST",
                "dataSrc": ""
            },
        
            pageLength: 100,
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
                    "data": "invoice_date"
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
                        return  '<a href="/download?f='+data+'" target="_blank" >'+data+'</a>'
                      }
                },
                
            ],
            "initComplete": function(settings, json) {
                //console.log(json);
            }

        });
});


function getRatio(value){

    //console.log(value);

    var ratioObject = {
        "icon": "",
        "colorClass": ""
    };

    switch(Number(value)) {
      case 0:

        ratioObject.icon = "error";
        ratioObject.colorClass = "col-red";
        
        break;

      case 1:

        ratioObject.icon = icon = "warning";
        ratioObject.colorClass = "col-yellow";
        
        break;

    case 100:

        ratioObject.icon =  "check_circle";
        ratioObject.colorClass = "col-green";
        
        break;
    }

    return ratioObject
}