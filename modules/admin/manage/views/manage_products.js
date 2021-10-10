Dropzone.autoDiscover = false;

$(document).ready(function() { 


 var importLists = $('.importLists_table').DataTable({
        "ajax": {
            "url": "/ajax/getImportProductLists/",
            "dataSrc": ""
        },
         "deferRender": true,
    
        pageLength: 100,
            "paging":   true,
            "ordering": false,
            "searching": true,
        rowId: 'category_slug',
          
        responsive: true,
        order: [1],
        "columns": [ 
            { 
                "data": "id",
                // "render" : function(data, type, row) {
                //     return '<a href="user/'+data+'" target="_blank">'+data+'</a>'
                //   } 
            },
            { 
                "data": "name"
            }
            ,
            { 
                "data": "date_uploaded",
                "render" : function(data, type, row) {

                    return beatifyTimestamp(data);
                  } 
            }
            ,
            { 
                "data": "date_started",
                "render" : function(data, type, row) {

                    return beatifyTimestamp(data);
                  } 
            }
            ,
            { 
                "data": "date_finished",
                "render" : function(data, type, row) {

                    return beatifyTimestamp(data);
                  } 
            },
            { 
                "data": "file_url"
            }
            ,
            { 
                "data": "status"
            }
            ,
            { 
                "data": "user"
            }, 
            {
                "data": null,
                 "render" : function(data, type, row) {

                    var percent = {
                        "pending" : "",
                        "update" : "",
                        "new" : "",
                        "error" : "",
                        "processed" : "",
                        "total" : row.total
                    }

                    var showLoader = 0;

                    percent.pending =  100 * row.pending / row.total;

                    percent.updated =  100 * row.updated / row.total;

                   percent.new =  100 * row.new / row.total;

                   percent.error =  100 * row.error / row.total;

                   percent.processed = percent.error + percent.updated + percent.new;

                   
                   if(type === 'display' && percent.processed !== 100 && parseInt(row.status_id) !== 6 ) {
 
                    showLoader = 1;

                    $.ajax({
                        url: "/ajax/updateProductsFromList",
                        type: "post",
                        dataType: "json",
                        data: {"import_product_list_id": row.id}
                    }).success(function(json){
                                                  

                    }).error(function(xhr, status, error) {
                       
                    }).complete( function (data) {
                        // console.log('reload'+row.id)
                        importLists.ajax.reload();
                    })
                        console.log(percent, row.id, row.status_id);

                    
                   } else if(type === 'display' && parseInt(row.status_id) !== 4 && parseInt(row.status_id) !== 6 && percent.processed == 100 ) {
                        

                        showLoader = 0;
                        
                        $.ajax({
                            url: "/ajax/updateImportListStatus",
                            type: "post",
                            dataType: "json",
                            data: {"id": row.id, "new_status": 4 }
                        }).success(function(json){
                                                      

                        }).error(function(xhr, status, error) {
                           
                        }).complete( function (data) {
                            importLists.ajax.reload();
                        })
                   }

                    return showProgressBar(percent, showLoader)
                  } 
            },

        ],
        "initComplete": function(settings, json) {
        }

    });



    $('.importProductList').on('submit', function(e){
        e.preventDefault();

       var data = $(this).serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

      $('.importFormWrapper').addClass('hidden');
      $('.loader-wrapper').removeClass('hidden');

      fileStatus = data.status;

      $.ajax({
            url: "/ajax/importProductList",
            type: "post",
            dataType: "json",
            data: {'file_name': data.file_name, 'name': data.name, 'status': data.status}
        }).success(function(importedId){


           var file_name = data.file_name;

           if(importedId) {

                $('.importingProducts').removeClass('hidden');


                $.ajax({
                    url: "/ajax/importListProducts",
                    type: "post",
                    dataType: "json",
                    data: {'file_name': data.file_name, 'import_product_list_id': importedId, 'status': fileStatus}
                }).success(function(json){
                   

                     if(json) {
                        $('.noSavedProducts').text(json);
                        $('.importingProductsSuccess').removeClass('hidden');
                        $('.loader-container').addClass('hidden');
                     } else {
                         $('.importingProductsError').removeClass('hidden');
                     }
                   

                }).error(function(xhr, status, error) {
                   
                })

           } else {
                $('.importProductListWarning').addClass('hidden');
                $('.importProductListError').removeClass('hidden');
           }

        }).error(function(xhr, status, error) {
            $('.importProductListWarning').addClass('hidden');
            $('.importProductListError').removeClass('hidden');
        })

    })

    $('.identifyDuplicates').on('click', function(e){
        $.ajax({
            url: "/ajax/setMergeId",
            type: "post",
            dataType: "json",
        }).success(function(json){           

        }).complete( function (data) {
            console.log(data);
                getDuplicatesStatus(1);
                $('.identifyDuplicates').trigger('click');                
        })
    })

    getDuplicatesStatus(0);

    getLegacyStatus(0);

   $('.identifyDuplicates').on('click', function(e){
        $.ajax({
            url: "/ajax/setMergeId",
            type: "post",
            dataType: "json",
        }).success(function(json){           

        }).complete( function (data) {
            console.log(data);
                getDuplicatesStatus(1);
                $('.identifyDuplicates').trigger('click');                
        })
    })


   $('.updateLegacyProducts').on('click', function(e){
        updateLegacyProducts();
    })

   $('.updateQuoteItemsProduct').on('click', function(e){
       updateQuoteItemsProduct('merge', '.updateQuoteProductsProgress', '.updateQuoteItemsProduct'); 
    })

   $('.legacyUpdateQuoteItemsProduct').on('click', function(e){
       updateQuoteItemsProduct('legacy', '.legacyUpdateQuoteProductsProgress', '.legacyUpdateQuoteItemsProduct'); 
    })

   $('.deactivateOldProducts').on('click', function(e){
       deactivateOldProducts('merge', '.deactivateOldProductsProgress', '.deactivateOldProducts'); 
    })

   $('.deactivateLegacyOldProducts').on('click', function(e){
       deactivateOldProducts('legacy', '.deactivateLegacyOldProductsProgress', '.deactivateLegacyOldProducts'); 
    })


})

function beatifyTimestamp(inputDate){
    if(inputDate == 0 ) {
        return "n/a"
    } else {
        var date = new Date(inputDate*1000)
        return beautyfullDate = date.toLocaleDateString();  
    }
              
}

$(function() {
    //Dropzone class
    var myDropzone = new Dropzone(".dropzone", {
        url: "/ajax/uploadFile",
        paramName: "file",
        maxFilesize: 5,
        maxFiles: 1,
        acceptedFiles: ".csv",
        autoProcessQueue: true,
        init: function () {
            this.on("success", function (file, response) {
                console.log("sucesso", response, file);
                $(this.element).find('.filesToDB').removeClass('hidden');
                $('#file-name').val(response.trim());           
            });
        }
    });
});


function showProgressBar(percent, showLoader){
    var loader = 'Processing...<div class="text-center"><h6 class="loader-progress">'+percent.processed.toFixed(2)+'%</h6><div class="preloader pl-size-sm"> <div class="spinner-layer pl-red-grey"> <div class="circle-clipper left"> <div class="circle"></div> </div> <div class="circle-clipper right"> <div class="circle"></div> </div> </div> </div></div>';
    
    if(showLoader == 0) {
        loader = '';
    }

    return loader + '<div class="progress"> <div class="progress-bar progress-bar-success" style="width: '+percent.updated+'%"> <span class="sr-only">'+percent.updated+'% Complete (success)</span> </div> <div class="progress-bar progress-bar-primary progress-bar-striped active" style="width: '+percent.new+'%"> <span class="sr-only">'+percent.new+'% Complete (warning)</span> </div> <div class="progress-bar progress-bar-danger" style="width: '+percent.error+'%"> <span class="sr-only">'+percent.error+'% Complete (danger)</span> </div> </div>'

}

function duplicatesProgressBarr(row, showLoader) {

    var percent = {
        "pending" : "",
        "update" : "",
        "new" : "",
        "error" : "",
        "processed" : "",
        "total" : row.total
    }


    percent.updated =  100 * row.not_needed / row.total;

    percent.new =  100 * row.needed / row.total;

    percent.quotes_modified = 100 * row.quotes_modified / row.total;

    percent.products_deactivated = 100 * row.products_deactivated / row.total

    percent.error = 100 * row.quotes_error / row.total

    percent.processed = percent.updated + percent.new + percent.quotes_modified + percent.products_deactivated + percent.error;
    
    console.log(percent);

    //console.log(Math.floor(percent.processed));

    if(percent.processed.toFixed() == 100) {   
        $('.duplicatesActions').removeClass('hidden');
    }

    $('.duplicatesProcessed').html(percent.processed.toFixed());

    $('.duplicatesProgressBarr').html(showProgressBar(percent, showLoader));
       
}


function getDuplicatesStatus(showLoader){
     $.ajax({
        url: "/ajax/getDuplicatesStatus",
        type: "post",
        dataType: "json",
    }).success(function(json){


        duplicatesProgressBarr(json[0], showLoader);

        getAffectedQuoteItems("merge", ".updateQuoteProductsProgress span");

        getNeedDeactivationProducts("merge", ".deactivateOldProductsProgress span");

        console.log('get duplicates');

    }).error(function(xhr, status, error) {
       
    })
}

function getAffectedQuoteItems(type, textElement) {

    $.ajax({
        url: "/ajax/getAffectedQuoteItems",
        type: "post",
        dataType: "json",
        data: {"type": type}
    }).success(function(json){
    console.log($(textElement));           
        $(textElement).text(json[0]['total']);
    })
}


function getNeedDeactivationProducts(type, textElement) {

    $.ajax({
        url: "/ajax/getNeedDeactivationProducts",
        type: "post",
        dataType: "json",
        data: {"type": type}
    }).success(function(json){
    console.log($(textElement));           
        $(textElement).text(json[0]['total']);
    })
}

function updateQuoteItemsProduct(type, status, trigger){
    $( status +' .loader').removeClass('hidden');
     $.ajax({
        url: "/ajax/replaceQuoteItemsOldProduct",
        type: "post",
        dataType: "json",
        data: {"type": type}
    }).success(function(json){

    }).complete( function (data) {
       
                getAffectedQuoteItems(type, status +" span");
                $(trigger).trigger('click');                
        })
}

function deactivateOldProducts(type, status, trigger){
    $(status +' .loader').removeClass('hidden');
     $.ajax({
        url: "/ajax/deactivateNeededProducts",
        type: "post",
        dataType: "json",
        data: {"type": type}
    }).success(function(json){

    }).complete( function (data) {
       
                getNeedDeactivationProducts(type, status +" span");
                $(trigger).trigger('click');                
        })
}

function legacyProgressBarr(row, showLoader) {


    row.legacy_updated = parseInt(row.legacy_updated);
    row.total = parseInt(row.total);
    row.waiting_update = parseInt(row.waiting_update);
    row.error = parseInt(row.error);
    row.waiting_merge = parseInt(row.waiting_merge);



    var percent = {
        "pending" : 0,
        "updated" : 0,
        "new" : 0,
        "error" : 0,
        "processed" : 0,
        "total" : row.total
    }



    percent.updated =  100 * row.legacy_updated / row.total;

    percent.pending =  100 * row.waiting_update / row.total;

    percent.error =  100 * row.error / row.total;

    percent.new =  100 * row.waiting_merge / row.total;

    // percent.quotes_modified = 100 * row.quotes_modified / row.total;

    // percent.products_deactivated = 100 * row.products_deactivated / row.total

    percent.processed = percent.updated + percent.error + percent.new;
    
    console.log(percent);

    //console.log(Math.floor(percent.processed));

    if(percent.processed.toFixed() == 100) {   
        $('.legacyActions').removeClass('hidden');
    }

    $('.legacyProcessed').html(percent.processed.toFixed());

    $('.legacyProgressBarr').html(showProgressBar(percent, showLoader));
       
}


function getLegacyStatus(showLoader){
     $.ajax({
        url: "/ajax/getLegacyUpdateStatus",
        type: "post",
        dataType: "json",
    }).success(function(json){


        legacyProgressBarr(json[0], showLoader);

        getAffectedQuoteItems("legacy", ".legacyUpdateQuoteProductsProgress span");

        getNeedDeactivationProducts("legacy", ".deactivateLegacyOldProductsProgress span");

        // console.log('get duplicates');

    }).error(function(xhr, status, error) {
       
    })
}


function updateLegacyProducts(){
    getLegacyStatus(1);

     $.ajax({
        url: "/ajax/updateLegacyProducts",
        type: "post",
        dataType: "json",
    }).success(function(json){

    }).complete( function (data) {
       
                getAffectedQuoteItems("legacy", ".legacyUpdateQuoteProductsProgress span");
                $('.updateLegacyProducts').trigger('click');                
    })
}