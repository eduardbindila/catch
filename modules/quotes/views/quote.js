
$(document).ready(function() {
    console.log(quoteId, quote);

    var selectedItems = [];

    var QuotePricing = {};

    var queryDict = {};

    location.search.substr(1).split("&").forEach(function(item) {queryDict[item.split("=")[0]] = item.split("=")[1]})

    $.fn.dataTable.ext.errMode = 'none';

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    var quoteTable = $('.quote-table').DataTable({
            data: quote.quote_items,
                pageLength: 5000,
                    "paging":   false,
                    "ordering": true,
                    "searching": true,
                dom: 'Bfrtip',
                "scrollX": true,
                order: [[ 1, 'asc' ]],
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
                        extend: 'excel',
                        className: 'btn btn-lg btn-primary waves-effect',
                        exportOptions: {
                          stripHtml: true,
                          orthogonal: null,
                          columns: [ 1, 4, 5, 6, 7, 13, 14, 15, 18, 19, 20 ]
                        }, footer: true
                    },
                ],
                // fixedColumns:   {
                //     leftColumns: 2
                // },
                 language : {
                    //sLoadingRecords : '<span style="width:100%;"><img src="http://www.snacklocal.com/images/ajaxload.gif"></span>'
                },   
                responsive: true,
                "columns": [
                { 
                    "data": null, 
                    defaultContent: '' 
                },
                { 
                    "data": "criteria",

                },
                { 
                    "data": "product_image",
                    className: "product_image",
                    "render" : function(data, type, row) {
                            return '<img src="'+data+'" class="table-image" />'
                      } 

                },
                { 
                    "data": "id",
                    className: "product_id",
                    "render" : function(data, type, row, meta) {
                        //console.log(index);

                            if(row['temporary_product']) {
                                return '<button class="btn btn-xs btn-link waves-effect editQuoteItem" data-toggle="modal" data-target="#editItem-modal" data-quoteItem="'+ row.quote_item_id +'" data-row="'+ meta.row +'"><i class="material-icons">mode_edit</i></button>'
                            }
                            else {
                                return '<a class="btn btn-xs btn-link" href="https://www.sylvania-lighting.com/product/en-int/products/'+data+'"><i class="material-icons">link</i></a><button class="btn btn-xs btn-link waves-effect editQuoteItem" data-toggle="modal" data-target="#editItem-modal" data-quoteItem="'+ row.quote_item_id +'" data-row="'+ meta.row +'"><i class="material-icons">mode_edit</i></button>'
                            }
                            
                      }

                },
                 { 
                    "data": "product_id",

                },
                { 
                    "data": "customer_description",

                },
                { 
                    "data": "destination",

                },
               
                
                     
                    { 
                        "data": "product_name",

                    },
                    { 
                        "data": "total_power_consumption__w_",
                        "visible": false
                    },
                     { 
                        "data": "colour_temperature__k_",
                        "visible": false
                    },
                     { 
                        "data": "fixture_luminous_flux__lm_",
                        "visible": false
                    },
                    { 
                        "data": "initial_price",
                        "visible": iss
                    },
                    { 
                        "data": "min_price",
                        "visible": iss
                    },
                     { 
                        "data": "list_price",
                    },
                     
                    { 
                        "data": "discount",
                        className: "discount-wrapper",
                        "render" : function(data, type, row, meta) {
                            //console.log(meta, row);
                            return '<div class="form-group"><div class="form-line"><input class="form-control quote-input" data-type="discount" name="discount" data-row="'+meta.row+'" data-col="'+meta.col+'" data-item="'+row.quote_item_id+'" placeholder="Discount" value="'+row.discount+'" type="number" min=0 ></div></div>'
                          }
                    },
                    {
                        "data": "unit_price", 
                      className: "unit-price-wrapper",
                      "render" : function(data, type, row, meta) {
                        
                            return '<div class="form-group"><div class="form-line"><input class="form-control unit-price quote-input" data-type="unitPrice" placeholder="Unit Price" data-row="'+meta.row+'" data-col="'+meta.col+'" data-item="'+row.quote_item_id+'" value="'+data+'" type="number" min=0></div></div>'
                      }
                    },

                    {
                      "data": "profit",
                      "visible": iss,
                      "render" : function(data, type, row, meta) {
                                        
                            return '<span class="profit" data-row="'+meta.row+'" data-col="'+meta.col+'" data-type="profit">'+data+'</span>';
                            
                      }
                    },
                    {
                      "data": "profit_percent",
                      "visible": iss,
                      "render" : function(data, type, row, meta) {
                    
                            return '<span class="profit-percent" data-row="'+meta.row+'" data-col="'+meta.col+'" data-type="profitPercent">'+data+'</span>';
                            
                      }
                    },
                     { 
                        "data": "quantity",
                            "render" : function(data, type, row, meta) {
                              return '<div class="form-group"><div class="form-line"><input class="form-control quote-input" data-type="quantity" name="quantity" data-item="'+row.quote_item_id+'" data-row="'+meta.row+'" data-col="'+meta.col+'" placeholder="Quantity" value="'+row.quantity+'" type="number" min="1" step="1"></div></div>'
                          }
                    },
                    { 
                        "data": "final_price",
                            "render" : function(data, type, row, meta) {
                            QuotePricing = new PriceDetails(
                                row.discount, row.quantity, row.initial_price, row.min_price, row.list_price, row.unit_price, row.profit, row.profit_percent, row.final_price
                            );
                              return '<span class="final-price" data-row="'+meta.row+'" data-col="'+meta.col+'" data-type="finalPrice">'+data+'</span>';
                          }
                    },
                    { 
                        "data": "temporary_product",
                        "visible": false
                    },
                     { 
                        "data": "extra_discount",
                        "visible": false
                    },

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
            }

        });


});

class PriceDetails {
    constructor(discount, quantity, initialPrice, minPrice, listPrice, unitPrice, profit, profitPercent, finalPrice) {
       
        this.discount = discount;
        this.initialPrice = initialPrice;
        this.minPrice = minPrice;
        this.listPrice = listPrice;
        this.quantity = quantity;
        this.unitPrice = unitPrice;
        this.profit = profit;
        this.profitPercent = profitPercent;
        this.finalPrice = finalPrice;
    }

    getPricingDetails() {
        return {
            "discount": this.discount,
            "initialPrice": this.initialPrice,
            "minPrice": this.minPrice,
            "listPrice": this.listPrice,
            "quantity": this.quantity,
            "unitPrice": this.unitPrice,
            "profit": this.profit,
            "profitPercent": this.profitPercent,
            "finalPrice": this.finalPrice
        }
    }


    updateItemPricing(el) {
        var that = $(el);

        var type = that.attr('data-type');

        if(type == 'discount') {

            this.discount = that.val();
            this.unitPrice =  (this.listPrice - (this.listPrice*this.discount/100)).toFixed(2);

        } else if(type == 'unitPrice') {
            this.unitPrice = that.val();
            this.discount = 100 - (this.unitPrice*100/this.listPrice).toFixed(2);
            this.discount = isFinite(this.discount) ? this.discount : 0;
        } else if(type == 'quantity') {

            this.quantity = that.val();
        }

        this.profit = (this.unitPrice - this.initialPrice).toFixed(2);
        this.profitPercent = (this.profit * 100 / this.unitPrice).toFixed(2)
        this.finalPrice = (this.quantity * this.unitPrice).toFixed(2)

        this.updateDomPrices(that);
        this.updateDB(el);


    }

    updateDomPrices(el) {
        var tr = el.closest('tr');
        this.updateEl(tr, "discount", this.discount);
        this.updateEl(tr, "unitPrice", this.unitPrice);
        this.updateEl(tr, "profit", this.profit);
        this.updateEl(tr, "profitPercent", this.profitPercent);
        this.updateEl(tr, "quantity", this.quantity);
        this.updateEl(tr, "finalPrice", this.finalPrice);       
    }

    updateEl(tr, type, newValue) {
        var tableID = tr.closest('table').attr('id')

        var updatedEl = tr.find("[data-type='" + type + "']");

        var rowId = updatedEl.attr('data-row');

        var colId = updatedEl.attr('data-col');

        var tagName = updatedEl.prop("tagName");

        if (tagName == "INPUT") {
            updatedEl.val(newValue)
        }
        else {
            updatedEl.text(newValue);
        }

        $('#'+tableID).dataTable().api().cell({ row: rowId, column: colId }).data(newValue).draw();
        

    }

    updateDB(el){


        var quoteItem = {
            'item_id': $(el).attr('data-item'),
            'discount': this.discount,
            'quantity': this.quantity,
            'unit_price': this.unitPrice,
        };


         $.ajax({
            url: "/ajax/updateQuantity",
            type: "post",
            dataType: "json",
            data: quoteItem
        }).success(function(json){
       $('.updateError').addClass('hidden');

    }).error(function(xhr, status, error) {
       $('.updateError').removeClass('hidden');
    })


    }

}

