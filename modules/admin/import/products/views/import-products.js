$(document).ready(function() {


$('.sync-products').on('click', function(){
  $.ajax({
      url: "/ajax/getProducts",
        type: "post",
      dataType: "json",
      data: {"sync_products": true},
      success: function(json) {
      }
  })
})


// var remainingProducts = [];

//       $('.diff-inserted').on('click', function(){
//             console.log('a');
//             $.ajax({
//                 url: "/ajax/getInsertedProductIDs",
//                   type: "post",
//                 dataType: "json",
//                 success: function(json) {
//                     console.log(json);

//                     JSON.parse(localStorage.productsArray).forEach(function(value){
//                         var productID = value.productID;
//                         console.log((productID in json), json[productID], productID)

//                         if(!(productID in json)) {
//                               console.log(productID);

//                               remainingProducts.push(value);
//                         }
                        
//                     })

//                     console.log(remainingProducts);

//                     localStorage.remainingProducts = JSON.stringify(remainingProducts);

//                 }
//             })
//       })


//  if (typeof(Storage) !== "undefined" && typeof(localStorage.remainingProducts) !== "undefined") {
//     var allProducts = JSON.parse(localStorage.remainingProducts);

//       var pageSize = 300;
// }
// else {
//    var allProducts = JSON.parse(localStorage.productsArray);

// var pageSize = 500;
   
// }


// var pageNumbers = Math.ceil(allProducts.length/pageSize);

// for (var i = pageNumbers; i >= 1; i--) {
   
//       $('.product-split').append('<button class="insert-products btn bg-blue btn-lg btn-block waves-effect" type="button" data-page="'+ i +'">Page'+i+'</button>')
// }

// $('.insert-products').on('click', function(){
//       var pageNumber = $(this).attr('data-page');

//       paginate(pageNumber);
// });


function paginate (page_number) {
  --page_number; // because pages logically start with 1, but technically with 0
  var pagedArray = allProducts.slice(page_number * pageSize, (page_number + 1) * pageSize);

      $.ajax({
          url: "/ajax/getProducts",
          type: "post",
          dataType: "json",
          data: {"all_products": pagedArray},
          success: function(json) {
              
          }
      }).done(function(json){
            console.log('done for ', page_number)
      });

}


//                   $.ajax({
//                       url: "/ajax/getProducts",
//                       type: "post",
//                       async: false,
//                       dataType: "json",
//                       data: {"all_products": allProducts},
//                       success: function(json) {
                          
//                       }
//                   })

 //      Products = new importProduct();

 //      $('.generate-all').on('click', function(){
 //        $('.generated-items').removeClass('hidden');
 //    })

 //    $('.delete-all').on('click', function(){
 //        $('.generate-all').removeAttr('disabled');
 //        localStorage.clear();
 //        updateStats();
 //        location.reload();
 //    })  

 //    updateStats();

 //      if(typeof(localStorage.productsfullyGenerated) !== "undefined")
 //    {
 //        if(JSON.parse(localStorage.productsfullyGenerated) == false) {
 //            localStorage.productsfullyGenerated = false;
 //            Products.generateTable();
            
 //        }
 //        else {
 //            $('.delete-all').removeClass('hidden');
 //            $('.fully-generated').removeClass('hidden');
 //            $('.generated-items').removeClass('hidden');
            
 //        }
 //    }
 //    else {
 //        localStorage.productsfullyGenerated = false;
 //    }



	// if(typeof(localStorage) !== "undefined") {

            
	// }

});

// function updateStats() {
//     $('.generated-products-number').text(Products.getProductsLength());
//     $('.generated-features-number').text(Products.getFeaturesLength());

//     // $('.features-progress').css('width', features.getCategoryPercent()+"%").attr('aria-valuenow', features.getCategoryPercent());
//     // $('.products-progress').css('width', features.getProductPercent()+"%").attr('aria-valuenow', features.getProductPercent());
// }

// class importProduct {
//     constructor() {
        
//             this.productArrayToInsert = [];
//             this.featuresCategory = {};
//             this.features = [];
//             this.featuresValue = {};
//             this.productFeatures = [];
//     }

//     addProduct(newProduct) {
//         this.productArrayToInsert = this.productArrayToInsert.concat(newProduct);

//         this.saveProductInStorage();
//     }


//     saveProductInStorage () {
//         if (typeof(Storage) !== "undefined") {
//                 localStorage.productArrayToInsert = JSON.stringify(this.productArrayToInsert);
//         } 
//     }

//     addFeature(newFeature) {
//         this.features = this.features.concat(newFeature);

//         this.saveFeature();
//     }


//     saveFeature () {
//         if (typeof(Storage) !== "undefined") {
//                 localStorage.features = JSON.stringify(this.features);
//         } 
//     }

//     addFeatureValue(key, newFeatureValue) {
//          this.featuresValue[key] = newFeatureValue;

//         this.saveFeatureValue();
//     }


//     saveFeatureValue () {

//         if (typeof(Storage) !== "undefined") {
//                 localStorage.featuresValue = JSON.stringify(this.featuresValue);
//         } 
//     }

//     addProductFeatures(newProductFeature) {
//         this.productFeatures = this.productFeatures.concat(newProductFeature);

//         this.saveProductFeatures();
//     }


//     saveProductFeatures () {
//         if (typeof(Storage) !== "undefined") {
//                 localStorage.productFeatures = JSON.stringify(this.productFeatures);
//         } 
//     }


//     addFeaturesCategory(key, value) {
//         this.featuresCategory[key] = value;

//         this.saveFeatureCategoryInStorage();
//     }

//     saveFeatureCategoryInStorage () {
//         if (typeof(Storage) !== "undefined") {
//                 localStorage.featuresCategory = JSON.stringify(this.featuresCategory);
//         } 
//     }

//      getFeaturesLength () {
//         var featuresLength;

//          if (typeof(Storage) !== "undefined" && typeof(localStorage.features) !== "undefined") {
//              featuresLength = JSON.parse(localStorage.features).length;
//         } 
//         else {
//             featuresLength = 0;
//         }

//         return featuresLength
//     }

//     getCategoryPercent() {
//         var totalfeatures = 1169;

//         return this.getFeaturesLength()/totalfeatures*100
//     }

//      getProductPercent() {
//         var totalProducts = 848;

//         return this.getProductsLength()/totalProducts*100
//     }

//     getProductsLength () {
//         var productLength;

//          if (typeof(Storage) !== "undefined" && typeof(localStorage.productArrayToInsert) !== "undefined") {
//              productLength = JSON.parse(localStorage.productArrayToInsert).length;
//         } 
//         else {
//             productLength = 0;
//         }

//         return productLength
//     }

//     formatChildCategory(table_id) {
//       return '<table class="children-table table table-striped table-bordered table-hover dt-responsive display" id="' + table_id + '-children">' +
//         '<thead><th></th><th>Product ID</th><th>Name</th><th>Image</th><th>URL</th><th>Parent ID</th></thead></table>';
//     };

//     generateTable(){

//       var _this = this;

//       var productArray = JSON.parse(localStorage.productsArray);

//             var table = $('.products-table').DataTable({
//             data: productArray,
//             pageLength: 5000,
//                 "paging":   false,
//                 "ordering": false,
//                 "searching": false,
//             rowId: 'productID',
//              language : {
//                 //sLoadingRecords : '<span style="width:100%;"><img src="http://www.snacklocal.com/images/ajaxload.gif"></span>'
//             },    
//             responsive: true,
//            order: [1, 'asc'],
//             "columns": [
//                 {
//                   className: 'details-control',
//                   orderable: false,
//                   data: null,
//                   defaultContent:"", 

//                   "render" : function(data, type, row) { 
//                     return '<button class="children-generate btn btn-default btn-circle waves-effect waves-circle waves-float not-generated"><i class="material-icons">subdirectory_arrow_right</i></a>'
//                     }
//                 },  
//                 { 
//                     "data": "parentID",
//                     className: "parentID",

//                 },
//                 { "data": "productID",
//                     className: "productID", },
//             ],
//             "initComplete": function(settings, json) {
                   
//               }

//         });

//         $(document).on('click', '.children-generate', function() {
//            $(this).addClass('generating');

//            _this.generateProduct($(this));
//         });
//     }

//       generateProduct(el) {

//         var    _this= this;

//         var parent = $(el).parent().siblings('.parentID').text();
//         var product = $(el).parent().siblings('.productID').text();

//             JSON.parse(localStorage.categoriesArray).forEach(function(value) {
                  
//                   $.ajax({
//                       url: "/ajax/getProduct",
//                       type: "post",
//                       async: false,
//                       dataType: "json",
//                       data:  {"parent_id": parent, "product_id": product},
//                       success: function(json) {
                          
//                       }
//                   }).done(function(json){

//                         console.log(json);

//                      $(el).addClass('list-group-item-success');

//                      var productArray = json.data[0];

//                         var arrayToInsert = {
//                               "parent_id": productArray.parent_id,
//                               "product_id": productArray.product_id,
//                               "product_name": productArray.product_name,
//                               "product_description": productArray.product_description,
//                               "product_diagrams": productArray.product_diagrams,
//                               "product_image": productArray.product_image,                   
//                         };

//                               _this.addProduct(arrayToInsert);

//                               productArray.features_list.forEach(function(features_list, index) {
                                    
//                                     var feature_category_slug = features_list.feature_category.feature_category_slug;
//                                     var feature_category_name = features_list.feature_category.feature_category_name;

//                                     _this.addFeaturesCategory(feature_category_slug, feature_category_name);

//                                      features_list.features.forEach(function(feature, i) {

//                                           var featureInfo = {
//                                                 "feature_id" : feature.feature_slug,
//                                                 "feature_name" : feature.feature_name,
//                                                 "feature_category_id" : feature_category_slug
//                                           }

//                                           _this.addFeature(featureInfo);

//                                           _this.addFeatureValue(feature.feature_value_slug, feature.feature_value_name);

//                                           var productFeature = {
//                                                 "product_id" : productArray.product_id,
//                                                 "feature_id" : feature.feature_slug,
//                                                 "feature_value_id" : feature.feature_value_slug,

//                                           }

//                                            _this.addProductFeatures(productFeature);
//                                     });
//                               });

//                               $('.generating').addClass('generated');
//                               $('.generated').removeClass('generating');
//                               $('.generated').removeClass('not-generated');

//                               if($('.not-generated').length > 0 ) {
//                                     $('.not-generated').eq(0).trigger('click');
//                               }
//                               else {
//                                     if (typeof(Storage) !== "undefined") {
//                                         localStorage.productsfullyGenerated = true;
//                                     } 
//                               }
//                         });              
//             });

//       }

//     generateChild(el){

//         var parent = $(el).parent().siblings('.parentID').text();
//         var product = $(el).parent().siblings('.productID').text();

//         var tr = $(el).closest('tr');
//         var closestTable = tr.closest("table");
//         var row = closestTable.DataTable().row(tr);

//         var _this = this;

//         if (row.child.isShown()&&tr.hasClass('shown')) {
//           // This row is already open - close it    
//           row.child.hide();
//           tr.removeClass('shown');
//         } else {
//             // Open this row
//             row.child(_this.formatChildCategory(product)).show();
//             tr.addClass('shown');

//             var childTable = $('#'+product+'-children').DataTable({
//                 "ajax": {
//                     "url": "/ajax/getProduct",
//                     "type": "POST",
//                     "data": {"parent_id": parent, "product_id": product}
//                 },
//                 pageLength: 5000,
//                 "paging":   false,
//                 "ordering": false,
//                 "searching": false,
//                 rowId: 'parentID',
//                   language : {
//                     "emptyTable": "No Products found."
//                     //sLoadingRecords : '<span style="width:100%;"><img src="http://www.snacklocal.com/images/ajaxload.gif"></span>'
//                 },    
//                 responsive: true,
//                 order: [1, 'asc'],
//                 "columns": 
//                 [
//                   { 
//                         "data": "product_id",
//                         className: "product_id-child", 
//                   },
//                   { 
//                         "data": "product_name",
//                         className: "product_name", 
//                   },
//                   { 
//                         "data": "product_image",
//                         className: "product_image",

//                         "render" : function(data, type, row) {
//                           return '<div class="table-image" style="background-image: url(\''+data+'\')"></div>'
//                         },
//                   },
//                   { 
//                         "data": "parent_id",
//                         className: "parent_id-child", 
//                   },
                    
//                 ],
//                 "initComplete": function(settings, json) {

//                         var productArray = json.data[0];

//                         var arrayToInsert = {
//                               "parent_id": productArray.parent_id,
//                               "product_id": productArray.product_id,
//                               "product_name": productArray.product_name,
//                               "product_description": productArray.product_description,
//                               "product_diagrams": productArray.product_diagrams,
//                               "product_image": productArray.product_image,                   
//                         };

//                               _this.addProduct(arrayToInsert);

//                         productArray.features_list.forEach(function(features_list, index) {
                              
//                               var feature_category_slug = features_list.feature_category.feature_category_slug;
//                               var feature_category_name = features_list.feature_category.feature_category_name;

//                               _this.addFeaturesCategory(feature_category_slug, feature_category_name);

//                                features_list.features.forEach(function(feature, i) {

//                                     var featureInfo = {
//                                           "feature_id" : feature.feature_slug,
//                                           "feature_name" : feature.feature_name,
//                                           "feature_category_id" : feature_category_slug
//                                     }

//                                     _this.addFeature(featureInfo);

//                                     _this.addFeatureValue(feature.feature_value_slug, feature.feature_value_name);

//                                     var productFeature = {
//                                           "product_id" : productArray.product_id,
//                                           "feature_id" : feature.feature_slug,
//                                           "feature_value_id" : feature.feature_value_slug,

//                                     }

//                                      _this.addProductFeatures(productFeature);
//                               });
//                         });

//                         $('.generating').addClass('generated');
//                         $('.generated').removeClass('generating');
//                         $('.generated').removeClass('not-generated');

//                         if($('.not-generated').length > 0 ) {
//                               $('.not-generated').eq(0).trigger('click');
//                         }
//                         else {
//                               if (typeof(Storage) !== "undefined") {
//                                   localStorage.productsfullyGenerated = true;
//                               } 
//                         }
//                   }
//             });
//         };

//     }


// }





