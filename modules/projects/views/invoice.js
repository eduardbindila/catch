class Invoices {
    constructor() { 
    }

    setPackageLine(params) {

      var packageId = params.packageId;

      var packageDate = params.packageDate;

      var packageStatus = params.packageStatus

      var collapserId = 'collapse-'+packageId;

      var packageLine = '<div class="package_line m-t-10">'+
                           '<div class="package_wrapper">'+
                               '<button class="btn btn-default collapser"'+
                               ' type="button" data-toggle="collapse"'+
                               ' href="#'+collapserId+'" aria-expanded="true"'+
                               ' aria-controls="'+collapserId+'">'+
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
                                   '<button type="button" '+
                                   ' class="btn btn-info waves-effect">'+
                                   'Generate POS</button>'+
                               '<button type="button" class="btn btn-primary waves-effect">'+
                               'Generate Delivery Notice</button>'+
                               '<button type="button" class="btn btn-success waves-effect">'+
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
                                       '<th>Package Quantity</th>'+
                                   '</thead>'+
                               '</table>'+
                           '</div>'+
                       '</div>';

         return packageLine

    }

    setPackages(params){

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
      });
      

    }
}