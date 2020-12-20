$('#form_validation').validate({
    rules: {
        'checkbox': {
            required: true
        },
        'gender': {
            required: true
        }
    },
    highlight: function (input) {
        $(input).parents('.form-line').addClass('error');
    },
    unhighlight: function (input) {
        $(input).parents('.form-line').removeClass('error');
    },
    errorPlacement: function (error, element) {
        $(element).parents('.form-group').append(error);
    }
});

var queryDict = {};

location.search.substr(1).split("&").forEach(function(item) {queryDict[item.split("=")[0]] = item.split("=")[1]})

$('.search').on('click', function(){
    if($(this).attr('data-quote')) {
        var quoteNumber = $(this).attr('data-quote')
        window.history.pushState("object or string", "Title", "?quote="+quoteNumber);
    } else  {
        var projectNumber = $(this).attr('data-project')
        window.history.pushState("object or string", "Title", "?project="+projectNumber);
    }
    
})


$.ajax({
    url: "/ajax/getUsers",
    type: "post",
    dataType: "json",
}).done(function(json){
   $.each(json, function (i, item) {
        $('.usersSelector').append($('<option>', { 
            value: item.id,
            text : item.name 
        }));

        $('.usersSelector option[value="'+ clientIs +'"]').attr('selected','selected')
    });

}).error(function(xhr, status, error) {
    $('.usersSelectorError').removeClass('hidden');
})

$(document).ready(function() {

    var selectedProducts = [];
    

    if(typeof(searchResult) != "undefined") {
        $('.show-table').removeClass('hidden');

        //console.log(searchResult);

        var table = $('.results-table').DataTable({
            dom: 'Blfrtip',
            data: searchResult,
            pageLength: 5000,
                "paging":   false,
                "ordering": true,
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
                    extend: 'selected',
                    className: 'createProject btn btn-lg btn-success waves-effect',
                    text: 'Create Quote',
                    action: function ( e, dt, button, config ) {

                        var selection = dt.rows( { selected: true } ).data();
                        var i;
                        for ( i = 0; i < selection.length; i++) {
                            selectedProducts.push(selection[i].id);
                        }
                    }
                },
                {
                    extend: 'selected',
                    className: 'addToQuote btn btn-lg btn-success waves-effect hidden',
                    text: 'Add to Quote',
                    action: function ( e, dt, button, config ) {
                        var selection = dt.rows( { selected: true } ).data();
                        var i;
                        for ( i = 0; i < selection.length; i++) {
                            selectedProducts.push(selection[i].id);
                        }

                        var quoteID = $('#quoteNumber').text();

                        addItemsToQuote(0, quoteID, selectedProducts)
                    }
                },
                {
                    extend: 'selected',
                    className: 'addToProject btn btn-lg btn-success waves-effect hidden',
                    text: 'Add to Project',
                    action: function ( e, dt, button, config ) {
                        var selection = dt.rows( { selected: true } ).data();
                        var i;
                        for ( i = 0; i < selection.length; i++) {
                            selectedProducts.push(selection[i].id);
                        }

                        var projectID = $('#projectNumber').text();

                        createQuote(projectID, selectedProducts)
                    }
                }
            ],
            language: {
                buttons: {
                    selectAll: "Select all items",
                    selectNone: "Select none",
                }
            },   
            responsive: true,
            "columns": [
                { 
                    "data": null, 
                    defaultContent: ''
                    
                },
                { 
                    "data": "product_image",
                    className: "product_image",
                    "render" : function(data, type, row) {
                         if(!data){
                            return '<img src="http://ideyafoana.com/api/public/storage/photo/no-image.png" class="table-image" />'
                            
                        } else {
                            if(searchTemporary){
                                return  '<img src="/uploads/'+data+'" class="table-image" />'
                            } else {

                              return '<img src="'+data+'" class="table-image" />'
                            
                            }
                        }                       
                      } 

                },
                { 
                    "data": "id",
                    className: "product_id",
                      "render" : function(data, type, row, meta) {
                        if(row.from_db) {
                            return data;
                        }
                        else {
                            return '<div class="form-group"><div class="form-line"><input class="form-control" data-type="id" name="row['+meta.row+'][id]" placeholder="Add an Id" value="'+data+'" required></div></div>'
                          }
                    }

                },
                { 
                    "data": "product_name",
                    className: "product_name",
                    "render" : function(data, type, row, meta) {
                        if(row.from_db) {
                            return data;
                        }
                        else {
                            return '<div class="form-group"><div class="form-line"><input class="form-control" data-type="id" name="row['+meta.row+'][name]" placeholder="Add a Name" value="'+data+'" required></div></div>'
                          }
                    }

                },
                { 
                    "data": "initial_price",
                    className: "initial_price",
                    "render" : function(data, type, row, meta) {

                        if(row.from_db) {
                            return Number(data).toFixed(2)
                        }
                        else {
                            return '<div class="form-group"><div class="form-line"><input class="form-control" data-type="id" name="row['+meta.row+'][price]" placeholder="Price" value="'+data+'" required></div></div>'
                          }
                         
                          
                      }

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

                $('.dt-buttons a').removeClass('dt-button');
                $('.createProject').attr({"data-toggle": "modal", "data-target": "#categories-modal"});

                if(queryDict.quote && queryDict.quote !== 'undefined') {
                    

                    $('.addToQuote').removeClass('hidden');
                    $('.createProject').addClass('hidden');
                    $('.addToProject').addClass('hidden');

                    $('.projectTitle').addClass('hidden');
                    $('.quoteTitle').removeClass('hidden');

                     $('.addNewItem[data-quote="'+queryDict.quote+'"]').trigger('click');
                }

                 if(queryDict.project && queryDict.project !== 'undefined') {
                   //console.log('a')

                    $('.addToProject').removeClass('hidden');
                    $('.addToQuote').addClass('hidden');
                    $('.createProject').addClass('hidden');

                     $('.quoteTitle').addClass('hidden');
                    $('.projectTitle').removeClass('hidden');

                     $('.addNewQuote[data-project="'+queryDict.project+'"]').trigger('click');
                }
              },

              "createdRow": function( row, data, dataIndex ) {
                //console.log(row, data['from_db'], dataIndex);
                if ( data['from_db'] === 0 ) {
                  $(row).addClass( 'danger' );
                }
              }

        });
    }

   table.on( 'select', function ( e, dt, type, indexes ) {
    console.log(e);
        var row = table.row( indexes ).data();

        if ( row.from_db === 0 ) {
            dt.row(indexes, { page: 'current' }).deselect();
        }

    } );


    var projectsTable = $('.projects_table').DataTable({
            "ajax": {
                "url": "/ajax/getProjects",
                "dataSrc": ""
            },
            dom: 'lfrtipB',
            pageLength: 5,
                "paging":   true,
                "ordering": false,
                "searching": true,
            rowId: 'category_slug',
             buttons: [
                 {
                    extend: 'selected',
                    className: 'selectProject btn btn-block m-t-10 btn-lg btn-success waves-effect',
                    text: 'Choose selected Project & Continue',
                    action: function ( e, dt, button, config ) {
                        var selectedRow = dt.rows( { selected: true } ).data();
                        createQuote(selectedRow[0].id, selectedProducts);
                        $('.projectProgress').css('width', "100%").attr('aria-valuenow', 100);
                    }
                }
            ],   
            responsive: true,
            order: [2],
            columnDefs : [
                {
                    orderable : false,
                    className : 'select-checkbox',
                    targets : 0
                },
            ],
             select: {
                style:    'os',
                selector: 'tr'
            },
            "columns": [ 
                { 
                    "data": null, 
                    defaultContent: '' 
                },
                { 
                    "data": "id"
                },
                { 
                    "data": "project_name"
                },
                { 
                    "data": "project_description"
                },
                { 
                    "data": "owner_id"
                }
                
            ],
            "initComplete": function(settings, json) {
                $('.dt-buttons a').removeClass('dt-button');
                //$('.selectProject').attr({"data-toggle": "modal", "data-target": "#status-modal"})

            }

        });


    $("#addProject").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);

        $.ajax({
            url: "/ajax/addProject",
            type: "post",
            dataType: "json",
            data: form.serialize()
        }).done(function(json){
           createQuote(json, selectedProducts);
        }).error(function(xhr, status, error) {
             $('.addProjectForm').removeClass('hidden');
        })


    }); 



    $('input[name="searchType"]').on('change', function(e) { // Select the radio input group

    if($(this).val() == 'product-id') {
        $('#searchBulk').removeClass('hidden');
        $('#searchSingle').addClass('hidden');
    } else {
        $('#searchSingle').removeClass('hidden');
        $('#searchBulk').addClass('hidden');
    }


});  
   
});

function createQuote(projectID, products) {

    $('#categories-modal').modal('hide');

    $('#addNew-modal').modal('show');

    $('#status-modal').modal('show');

    var quote = {
        'project': projectID,
    }

    //console.log(products);
    $.ajax({
        url: "/ajax/createQuote",
        type: "post",
        dataType: "json",
        data: quote
    }).done(function(json){
        $('.quote-progress').css('width', "100%").attr('aria-valuenow', 100);
        $('.item-progress').css('width', "40%").attr('aria-valuenow', 40);
        if(products['duplicate']) {
            duplicateQuoteItems(projectID, json, products);
        } else {
            addItemsToQuote(projectID, json, products)
        }
        

    }).error(function(xhr, status, error) {
        $('.quoteCreation').removeClass('hidden');
    })

}

function duplicateQuoteItems(projectID, quoteID, quote_items){
    //console.log('its on');

    var quote = {
            'quote_items': quote_items,
            'quote_id': quoteID
        }

     $.ajax({
        url: "/ajax/duplicateQuoteItems",
        type: "post",
        dataType: "json",
        data: quote
    }).done(function(json){
            $('.items-progress').css('width', "100%").attr('aria-valuenow', 100);
            redirectCounter(projectID)
        
    }).error(function(xhr, status, error) {
        $('.quoteItemsCreation').removeClass('hidden');
    })
}

function addItemsToQuote(projectID, quoteID, products) {
    if(products[0].id) {
         $('#status-modal').modal('show');
        var quote = {
            'products': products,
            'quote_id': quoteID,
            'isMulti': 1
        }
         
    } else {
        var quote = {
            'products': products,
            'temporary_products' : searchTemporary,
            'quote_id': quoteID,
            'isMulti': 0
        }
    }
     
    $.ajax({
        url: "/ajax/addItemsToQuote",
        type: "post",
        dataType: "json",
        data: quote
    }).done(function(json){
        if($('#quoteNumber').text()) {
            window.history.pushState("object or string", "Title", "?");
            location.reload();
        } else {
            $('.items-progress').css('width', "100%").attr('aria-valuenow', 100);
            redirectCounter(projectID)
        }
        

    }).error(function(xhr, status, error) {
        $('.quoteItemsCreation').removeClass('hidden');
    })
}

function redirectCounter(projectID){ 
    var timeleft = 3;
    var downloadTimer = setInterval(function(){
      document.getElementById("countdown").innerHTML = timeleft + " seconds ";
      timeleft -= 1;
      if(timeleft <= 0){
        clearInterval(downloadTimer);
        window.location.href = "/project/"+projectID;
      }
    }, 1000);
};

