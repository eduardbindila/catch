
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
                    "data": "id"
                },
                { 
                    "data": "owner"
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
                               
                               
                                
                                
                            } 

                // var values = { 
                //     "total": 0,
                //     1:0,
                //     2:0,
                //     3:0,
                //     4:0,
                //     5:0,
                //     7:0,
                // };

                // for (row in filteredData) {
                //     thisRow = filteredData[row];

                //     if(Number.isInteger(parseInt(row))) {
                //         // values.total = ~~parseFloat(values.total) + ~~parseFloat(thisRow.quote_price);
                //         values[thisRow.quote_status_id] = ~~parseFloat(values[thisRow.quote_status_id]) + ~~parseFloat(thisRow.quote_price)
                //     }
                // }

                 for (row in filteredData) {
                    var thisRow = filteredData[row];

                    if(Number.isInteger(parseInt(row))) {
                      
                        
                        
                        // values.total = ~~parseFloat(values.total) + ~~parseFloat(thisRow.quote_price);
                        var thisValue = ~~parseFloat(chartValues[thisRow.quote_status_id].value) + ~~parseFloat(thisRow.quote_price);
                        // console.log(chartValues[thisRow.quote_status_id].value, ~~parseFloat(thisRow.quote_price), thisValue)

                        chartValues[thisRow.quote_status_id].label = thisRow.quote_status;
                        chartValues[thisRow.quote_status_id].value = thisValue;
              
                        //console.log(chartValues[thisRow.quote_status_id])
                    }
                }

                console.log(chartValues);
                if(!jQuery.isEmptyObject(chartValues)) {

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

                //     var ctx = document.getElementById('myChart').getContext('2d');

                // var myChart = new Chart(ctx, {
                //   type: 'horizontalBar',
                //   data: {
                //     labels: ['Quote Value by Quote Status'],
                //     datasets: [
                //       {
                //         label: chartValues[1].label,
                //         data: [chartValues[1].value],
                //         backgroundColor: '#D6E9C6',
                //       },
                //       {
                //         label: chartValues[2].label,
                //         data: [chartValues[2].value],
                //         backgroundColor: '#FAEBCC',
                //       },
                //       {
                //         label: chartValues[3].label,
                //         data: [chartValues[3].value],
                //         backgroundColor: '#EBCCD1',
                //       },
                //       {
                //         label: chartValues[4].label,
                //         data: [chartValues[4].value],
                //         backgroundColor: 'red',
                //       },
                //       {
                //         label: chartValues[5].label,
                //         data: [chartValues[5].value],
                //         backgroundColor: 'blue',
                //       },
                //       {
                //         label: chartValues[7].label,
                //         data: [chartValues[7].value],
                //         backgroundColor: 'green',
                //       }
                //     ]
                //   },
                //   options: {
                //     scales: {
                //       xAxes: [{ stacked: true }],
                //       yAxes: [{ stacked: true }]
                //     },
                //     showDatapoints: true,
                //   }
                // });

              }

              // myChart.update();  
            }
                

        });

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
                    "data": "id"
                },
                { 
                    "data": "start_date"
                },
                { 
                    "data": "quote_price"
                },
                { 
                    "data": "profit_percent"
                },
                { 
                    "data": "winning_chance"
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


