
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
            searchPanes:{
                cascadePanes: true,
                viewTotal: true,
                 layout: 'columns-1',
                 dataLength: 20
            },
            
            dom: '<"dtsp-verticalContainer"<"dtsp-verticalPanes"P><"dtsp-dataTable"frtip>>',
            columnDefs: [
            {
                searchPanes: {
                    preSelect: ['2021']
                },
                targets: [11]
            }
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
            "headerCallback": function( settings) {
                // $(thead).closest('table').before( 'Displaying '+(end-start)+' records' );
                var api = this.api();
                var filteredData = api.rows( { filter : 'applied'} ).data();


                var arrayValues = [0,0,0,0,0,0,0,0];

                var funnelValues = [];

                var chartValues = {
                                4: {
                                    "label": "",
                                    "value": 0
                                    },
                                7: {
                                    "label": "",
                                    "value": 0
                                    },
                                3: {
                                    "label": "",
                                    "value": 0
                                    },
                                1: {
                                    "label": "",
                                    "value": 0
                                    },
                                5: {
                                    "label": "",
                                    "value": 0
                                    },
                                2: {
                                    "label": "",
                                    "value": 0
                                    },
                                    8: {
                                    "label": "",
                                    "value": 0
                                    },
                                    9: {
                                    "label": "",
                                    "value": 0
                                    },
                               
                               
                                
                                
                            } 


                 for (row in filteredData) {
                    var thisRow = filteredData[row];

                    if(Number.isInteger(parseInt(row))) {
                      
                        
                        
                        // values.total = ~~parseFloat(values.total) + ~~parseFloat(thisRow.quote_price);
                        //console.log(thisRow);
                        var thisValue = ~~parseFloat(chartValues[thisRow.quote_status_id].value) + ~~parseFloat(thisRow.quote_price);
                        // console.log(chartValues[thisRow.quote_status_id].value, ~~parseFloat(thisRow.quote_price), thisValue)

                        chartValues[thisRow.quote_status_id].label = thisRow.quote_status;
                        chartValues[thisRow.quote_status_id].value = thisValue;

                        arrayValues[thisRow.quote_status_id] = thisValue;
                    }
                }

                

                funnelValues = [
                    arrayValues[4]+arrayValues[7]+arrayValues[3]+arrayValues[1]+arrayValues[5]+arrayValues[2],
                    arrayValues[3]+arrayValues[1]+arrayValues[5]+arrayValues[2],
                    arrayValues[1]+arrayValues[5]+arrayValues[2],
                    arrayValues[5]+arrayValues[2],
                    arrayValues[2],
                ]

                


                ///console.log(chartValues);
                if(!jQuery.isEmptyObject(chartValues)) {

                    ///console.log(myChart, myFunnel);

                    data = [
                      {
                        label: chartValues[1].label,
                        data: [chartValues[1].value],
                        backgroundColor: '#D6E9C6',
                      },
                      {
                        label: chartValues[2].label,
                        data: [chartValues[2].value],
                        backgroundColor: '#FAEBCC',
                      },
                      {
                        label: chartValues[3].label,
                        data: [chartValues[3].value],
                        backgroundColor: '#EBCCD1',
                      },
                      {
                        label: chartValues[4].label,
                        data: [chartValues[4].value],
                        backgroundColor: 'red',
                      },
                      {
                        label: chartValues[5].label,
                        data: [chartValues[5].value],
                        backgroundColor: 'blue',
                      },
                      {
                        label: chartValues[7].label,
                        data: [chartValues[7].value],
                        backgroundColor: 'green',
                      }
                    ]

                    myChart.data.datasets = data;

                    myChart.update();

                    //console.log(funnelValues);
                    //console.log(arrayValues);

                    myFunnel.data.datasets = [{
                    data: funnelValues,
                    backgroundColor: [
                        "#FFF9C4",
                        "#FFEB3B",
                        "#8BC34A",
                        "#4CAF50",
                        "#388E3C",
                    ],
                    hoverBackgroundColor: [
                        "#FF6384",
                        "#FFCE56",
                        "#FF6384",
                        "#36A2EB",
                        "#FFCE56",
                    ]
                }];

                myFunnel.data.labels =  [
                   "Total Pipeline",
                    "Offer Sent",
                    "Advanced, Calibrating",
                    "Final Negociation",
                    "Delivering",
                ];


                    myFunnel.update();
              }

            }
                

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
                    "render" : function(data, type, row) {
                        return '<a href="/project/'+data+'" class="btn btn-block" target="_blank">'+data+'</a>'
                      } 
                },
                { 
                    "data": "project_name"
                },
                { 
                    "data": "id",
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
                            dangerClass="label label-danger"
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

                        if(data < 30) {
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
                    "data": "quote_id",
                    "render" : function(data, type, row) {
                        return '<a href="/quote/'+data+'" class="btn btn-block" target="_blank">'+data+'</a>'
                      } 
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
                        return date.toLocaleString();
                  } 
                },
                { 
                    "data": "sent_date",
                     "render" : function(data, type, row) {
                        
                        var rowDate = new Date(row.date*1000)
                        var date1 = rowDate.toLocaleString();

                        var uploadDate = new Date(date1); 

                        // To calculate the time difference of two dates 
                        var Difference_In_Time = new Date() - uploadDate.getTime(); 
                          
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
                    "data": "owner"
                },
                { 
                    "data": "quote_status"
                },
                
            ],
            "initComplete": function(settings, json) {
            }

        });
});


