$(document).ready(function() {

    Categories = new importArray();
    $('.generate-all').on('click', function(){
        $('.generated-items').removeClass('hidden');
        $('.categories-table button').eq(0).trigger( "click" );
    })

    $('.delete-all').on('click', function(){
        $('.generate-all').removeAttr('disabled');
        localStorage.clear();
        updateStats();
        location.reload();
    })   

    if(typeof(localStorage.fullyGenerated) !== "undefined")
    {
        if(JSON.parse(localStorage.fullyGenerated) == false) {
            localStorage.clear()
            localStorage.fullyGenerated = false;
            Categories.generateTable();
            
        }
        else {
            $('.delete-all').removeClass('hidden');
            $('.fully-generated').removeClass('hidden');
            $('.generated-items').removeClass('hidden');
            $('.categories-table').addClass('hidden');
            
        }
    }
    else {
        localStorage.fullyGenerated = false;
    }

    
    updateStats();

    $('.view-generated-categories').on('click', function(){
        $('.insert-categories').removeClass('hidden')
        showCategories();
    })

    $('.insert-categories').on('click', function(){

        JSON.parse(localStorage.categoriesArray).forEach(function(value) {
            
            $.ajax({
                url: "/ajax/insertCategory",
                type: "post",
                async: false,
                dataType: "json",
                data: {'category': value},
                success: function(json) {
                    
                }
            }).done(function(json){

                if(json) {
                    console.log('success');
                    $('#'+value.category_slug).addClass('list-group-item-success');
                } else {
                    console.log(value.category_slug);
                    $('#'+value.category_slug).addClass('list-group-item-danger'); 
                }
            });


        
        });

        
    })
   
    
});

function updateStats() {
    $('.generated-products-number').text(Categories.getProductLength());
    $('.generated-categories-number').text(Categories.getCategoriesLength());

    $('.categories-progress').css('width', Categories.getCategoryPercent()+"%").attr('aria-valuenow', Categories.getCategoryPercent());
    $('.products-progress').css('width', Categories.getProductPercent()+"%").attr('aria-valuenow', Categories.getProductPercent());
}



function showCategories(){
    $.each(JSON.parse(localStorage.categoriesArray), function (index,value) {

        var selectedEl = $('li#'+value.category_slug);
        var selectedParent = $('li#'+value.parent_slug)
        var childUl = selectedParent.find('ul');

        var li = '<li id="'+value.category_slug+'" class="list-group-item"><div class="category-info"><span class="category-title">'+value.category_name+'</span><div class="database-status"></div></div></li>';
        var ul = '<ul class="m-t-10">'+li+'</ul>';

        if(selectedEl.length == 0) {
            if(selectedParent.length == 0) {
                $('ul.show-generated-categories').append(li);
            } 
            else 
            {
                if(childUl.length == 0) {
                    selectedParent.append(ul);
                }
                else {
                    childUl.append(li);
                }
            }

        }
    });
}

Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};


class importArray {
    constructor() {
        this.categoriesArray = [];
        this.productsArray = [];
    }

    getCategoriesLength () {
        var categoriesLength;

         if (typeof(Storage) !== "undefined" && typeof(localStorage.categoriesArray) !== "undefined") {
             categoriesLength = JSON.parse(localStorage.categoriesArray).length;
        } 
        else {
            categoriesLength = 0;
        }

        return categoriesLength
    }

    getCategoryPercent() {
        var totalCategories = 1169;

        return this.getCategoriesLength()/totalCategories*100
    }

     getProductPercent() {
        var totalProducts = 7339;

        return this.getProductLength()/totalProducts*100
    }

    getProductLength () {
        var productLength;

         if (typeof(Storage) !== "undefined" && typeof(localStorage.productsArray) !== "undefined") {
             productLength = JSON.parse(localStorage.productsArray).length;
        } 
        else {
            productLength = 0;
        }

        return productLength
    }

    addCategory(newCategories) {
        this.categoriesArray = this.categoriesArray.concat(newCategories);

        this.saveCategoriesInStorage();
    }

    addProduct(newProducts) {
 
        this.productsArray = this.productsArray.concat(newProducts);

        this.saveProductInStorage();
    }

    saveProductInStorage () {
        if (typeof(Storage) !== "undefined" && localStorage.fullyGenerated) {
                localStorage.productsArray = JSON.stringify(this.productsArray);
                $('.generated-products-number').text(this.getProductLength);
                $('.products-progress').css('width', this.getProductPercent()+"%").attr('aria-valuenow', this.getProductPercent());
        } 
    }

    saveCategoriesInStorage () {
        if (typeof(Storage) !== "undefined" && localStorage.fullyGenerated) {
                localStorage.categoriesArray = JSON.stringify(this.categoriesArray);
                $('.generated-categories-number').text(this.getCategoriesLength);
                $('.categories-progress').css('width', this.getCategoryPercent()+"%").attr('aria-valuenow', this.getCategoryPercent());
        } 
    }


    getProductsArray() {
        return this.productsArray;
    }

    getCategoriesArray() {
        return this.categoriesArray;
    }

    formatChildCategory(table_id) {
      return '<table class="children-table table table-striped table-bordered table-hover dt-responsive display" id="' + table_id + '-children">' +
        '<thead><th></th><th>Category ID</th><th>Name</th><th>Image</th><th>URL</th><th>Parent ID</th><th>Actions</th></thead></table>';
    }

    generateTable(){

        var _this = this;

        var table = $('.categories-table').DataTable({
            "ajax": "/ajax/getMainCategories",
            pageLength: 5000,
                "paging":   false,
                "ordering": false,
                "searching": false,
            rowId: 'category_slug',
             language : {
                //sLoadingRecords : '<span style="width:100%;"><img src="http://www.snacklocal.com/images/ajaxload.gif"></span>'
            },    
            responsive: true,
            order: [[5, 'asc'],[1, 'asc']],
            "columns": [
                {
                  className: 'details-control',
                  orderable: false,
                  data: null,
                  defaultContent:"", 

                  "render" : function(data, type, row) { 
                    return '<button class="children-generate btn btn-default btn-circle waves-effect waves-circle waves-float not-generated"><i class="material-icons">subdirectory_arrow_right</i></a>'
                    }
                },  
                { 
                    "data": "category_slug",
                    className: "category_slug",

                },
                { "data": "category_name",
                    className: "category_name", },
                { "data": "category_image",
                    className: "category_image",
                    "render" : function(data, type, row) {
                      return '<div class="table-image" style="background-image: url('+data+')"></div>'
                  }  
                },
                { "data": "category_url",
                    className: "category_url",
                    "render" : function(data, type, row) {
                          return '<a class="btn btn-default btn-circle waves-effect waves-circle waves-float" href="https://www.sylvania-lighting.com'+data+'" data-url="'+data+'" target="_blank"><i class="material-icons">link</i></a>'
                      } 
                },
                { "data": "parent_slug", className: "parent_slug" },
            ],
            "initComplete": function(settings, json) {
                    _this.addCategory(json.data);
                    $('.generate-all').removeClass('hidden');
              }

        });

        $(document).on('click', '.children-generate', function() {
            var parent = $(this).parent().siblings('.category_slug').text();
            $(this).addClass('generating');
            _this.generateChild(this);
        });
            
    } 

    generateChild(el){
    
        var parent = $(el).parent().siblings('.category_slug').text();
        var childURL = $(el).parent().siblings('.category_url').children('a').attr('data-url');

        var tr = $(el).closest('tr');
        var closestTable = tr.closest("table");
        var row = closestTable.DataTable().row(tr);

        var _this = this;

        if (row.child.isShown()&&tr.hasClass('shown')) {
          // This row is already open - close it    
          row.child.hide();
          tr.removeClass('shown');
        } else {
            // Open this row
            row.child(_this.formatChildCategory(parent)).show();
            tr.addClass('shown');

            var childTable = $('#'+parent+'-children').DataTable({
                "ajax": {
                    "url": "/ajax/getCategories",
                    "type": "POST",
                    "data": {"childURL": childURL, "parent": parent}
                },
                pageLength: 5000,
                "paging":   false,
                "ordering": false,
                "searching": false,
                rowId: 'category_slug',
                 language : {
                    "emptyTable": "No Subcategories found. Product list:"
                    //sLoadingRecords : '<span style="width:100%;"><img src="http://www.snacklocal.com/images/ajaxload.gif"></span>'
                },    
                responsive: true,
                order: [[5, 'asc'],[1, 'asc']],
                "columns": 
                [
                    {
                      className: 'details-control',
                      orderable: false,
                      data: null,
                      defaultContent:"", 

                      "render" : function(data, type, row) { 
                        return '<button class="children-generate btn btn-default btn-circle waves-effect waves-circle waves-float not-generated"><i class="material-icons">subdirectory_arrow_right</i></a>'
                        }
                    },  
                    { 
                        "data": "category_slug",
                        className: "category_slug",

                    },
                    { "data": "category_name",
                        className: "category_name", },
                    { "data": "category_image",
                        className: "category_image",
                        "render" : function(data, type, row) {
                          return '<div class="table-image" style="background-image: url('+data+')"></div>'
                      }  
                    },
                    { "data": "category_url",
                        className: "category_url",
                        "render" : function(data, type, row) {
                              return '<a class="btn btn-default btn-circle waves-effect waves-circle waves-float" href="https://www.sylvania-lighting.com'+data+'" data-url="'+data+'" target="_blank"><i class="material-icons">link</i></a>'
                          } 
                    },
                    { "data": "parent_slug", className: "parent_slug" },
                ],
                "initComplete": function(settings, json) {

                    _this.addCategory(json.data);

                    if(json.data === undefined || json.data.length == 0){

                        var table = settings.nTable;
                        var tableID = table.id;
                        var selectTable = $("#"+ table.id);
                        var tr = $("#" + tableID + " tbody tr:first");

                        $(tr).after('<tr><td><table id="'+ tableID +'-products" class="table table-striped table-bordered table-hover dt-responsive display">');

                        var childURL = $("#"+tableID).closest('tr').prev().find('.category_url').find('a').attr('data-url');

                        var parentID = $("#"+tableID).closest('tr').prev().attr('id');

                        $.ajax({
                            url: "/ajax/getCategoryProducts",
                            type: "post",
                            dataType: "json",
                            data: {"childURL": childURL},
                            success: function(json) {

                                
                            }
                        }).done(function(json){

                            

                            $.each(json.data, function( index, product ) {

                                var productArray = {
                                    'parentID': parentID, 
                                    "productID": json.data[index].product_id
                                }

                                _this.addProduct(productArray);


                                var productID = product['product_id'];
                                $('#'+ tableID +'-products').append('<tr><td>'+productID+'</td></tr>')
                            });
                        });

                        
                    }

                    $('.generating').addClass('generated');
                    $('.generated').removeClass('generating');
                    $('.generated').removeClass('not-generated');

                    if($('.not-generated').length > 0 ) {
                        $('.not-generated').eq(0).trigger('click');
                    }
                    else {
                        if (typeof(Storage) !== "undefined") {
                            localStorage.fullyGenerated = true;
                        } 
                    }
                  }
            });
        };

    }
}