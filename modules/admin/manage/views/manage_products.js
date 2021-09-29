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

                    var loader = "";

                    percent.pending =  100 * row.pending / row.total;

                    percent.updated =  100 * row.updated / row.total;

                   percent.new =  100 * row.new / row.total;

                   percent.error =  100 * row.error / row.total;

                   percent.processed = percent.error + percent.updated + percent.new;

                   console.log(percent);

                   if(type === 'display' && percent.processed !== 100 ) {
 

                    $.ajax({
                        url: "/ajax/updateProductsFromList",
                        type: "post",
                        dataType: "json",
                        data: {"import_product_list_id": row.id}
                    }).success(function(json){
                                                  

                    }).error(function(xhr, status, error) {
                       
                    }).complete( function (data) {
                        console.log('reload'+row.id)
                        importLists.ajax.reload();
                    })
                        

                    loader = 'Processing...<div class="text-center"><h6 class="loader-progress">'+percent.processed.toFixed(2)+'%</h6><div class="preloader pl-size-sm"> <div class="spinner-layer pl-red-grey"> <div class="circle-clipper left"> <div class="circle"></div> </div> <div class="circle-clipper right"> <div class="circle"></div> </div> </div> </div></div>';
                   }

                    return loader+'<div class="progress"> <div class="progress-bar progress-bar-success" style="width: '+percent.updated+'%"> <span class="sr-only">'+percent.updated+'% Complete (success)</span> </div> <div class="progress-bar progress-bar-primary progress-bar-striped active" style="width: '+percent.new+'%"> <span class="sr-only">'+percent.new+'% Complete (warning)</span> </div> <div class="progress-bar progress-bar-danger" style="width: '+percent.error+'%"> <span class="sr-only">'+percent.error+'% Complete (danger)</span> </div> </div>'
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

      $.ajax({
            url: "/ajax/importProductList",
            type: "post",
            dataType: "json",
            data: {'file_name': data.file_name, 'name': data.name}
        }).success(function(importedId){


           var file_name = data.file_name;

           if(importedId) {

                $('.importingProducts').removeClass('hidden');


                $.ajax({
                    url: "/ajax/importListProducts",
                    type: "post",
                    dataType: "json",
                    data: {'file_name': data.file_name, 'import_product_list_id': importedId}
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


