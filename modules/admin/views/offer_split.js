

class OrderSplit {
    constructor(itemId, productId) {
       this.itemId = itemId;
       this.productId = productId;
       this.orderSplit = []

    }

    setWrapper() {

        var wrapper = '<div class="row">'+
                        '<div class="col-lg-1">'+
                            '<div class="btn-group">'+
                                '<button type="button" class="btn btn-default btn-xs waves-effect"'+
                                 ' data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'+
                                    '<i class="material-icons">add</i>'+
                                '</button>'+
                                '<ul class="dropdown-menu orderSplitorders item-'+this.itemId+'"'+
                                ' data-item='+this.itemId+' data-product="'+this.productId+'">'+
                                '</ul>'+
                           '</div>'+
                        '</div>'+
                        '<div class="col-lg-11 orderSplitLines" data-item='+this.itemId+' data-product="'+this.productId+'">'+
                        '</div>'+
                    '</div>';
        return wrapper
    }


    setOrders(invoiceItem, thisClass=this) {

        $.ajax({
                url: "/ajax/getVendorInvoiceItemQuotes",
                type: "post",
                dataType: "json",
                data: {'product_id': this.productId}
            }).success(function(json){
                
               $.each(json, function (x, quoteItem) {
                    console.log(quoteItem, invoiceItem)

                    thisClass.loadOrderLine(invoiceItem.id);

                    $('.item-'+invoiceItem.id).append('<li><a href="#" data-item="'+invoiceItem.id+'" data-quoteItem="'+quoteItem.id+'" data_neededQuantity="'+quoteItem.needed_quantity+'" data-order="'+quoteItem.order_number+'"'+
                        ' class="orderItem waves-effect waves-block">'+quoteItem.order_number+' <span>('+quoteItem.needed_quantity+'pcs)</span></a></li>');
                });
            }).error(function(xhr, status, error) {
               //$('.updateError').removeClass('hidden');
            }).done(function(json){

            })
    }

    getOrderSplit(){
        return this.orderSplit;
    }


    setOrderActions(order_number, split_id){
        var actionsList = '<ul class="list-inline" data-split='+split_id+'>'+
                                '<li>Order: <b>'+order_number+'</b></li>'+
                                '<li>'+
                                    '<div class="switch">'+
                                        '<label>'+
                                            'Fullfill<input type="checkbox">'+
                                            '<span class="lever green-tick-left"></span>'+
                                            '<input class="small-input" value="" type="number"'+ 
                                            'placeholder="Custom" disabled name="reserve_custom" min=0 >'+
                                        '</label>'+
                                    '</div>'+
                                '</li>'+
                                '<li>'+
                                    '<button type="button" data-split='+split_id+' class="btn btn-danger btn-xs waves-effect">'+
                                    '<i class="material-icons">close</i>'+
                                '</button>'+
                                '</li>'+
                            '</ul>';

        return actionsList
    }
    

    // updateDB(el){


    //     var quoteItem = {
    //         'item_id': $(el).attr('data-item'),
    //         'discount': this.discount,
    //         'quantity': this.quantity,
    //         'unit_price': this.unitPrice,
    //     };


    //      $.ajax({
    //         url: "/ajax/updateQuantity",
    //         type: "post",
    //         dataType: "json",
    //         data: quoteItem
    //     }).success(function(json){
    //        $('.updateError').addClass('hidden');

    //     }).error(function(xhr, status, error) {
    //        $('.updateError').removeClass('hidden');
    //     })

    // id   vendor_invoice_item_id  quote_item_id   quantity    

    // }





    addOrderLine(invoiceItemId, quoteItemId, quantity, orderNumber, thisClass=this){

        var orderLine = {
            'vendor_invoice_item_id': invoiceItemId, 
            'quote_item_id': quoteItemId, 
            'quantity': quantity
        }

        $.ajax({
            url: "/ajax/addOrderLine",
            type: "post",
            dataType: "json",
            data: orderLine
        }).success(function(json){
            var splitId = json;
           $('.updateError').addClass('hidden');

           $('.orderSplitLines[data-item='+invoiceItemId+']').append(thisClass.setOrderActions(orderNumber, splitId))

        }).error(function(xhr, status, error) {
           $('.updateError').removeClass('hidden');
        }).complete(function(data){
            orderLine['id']=data.responseJSON;
            console.log(data.responseJSON);
                thisClass.orderSplit = orderLine;
        })

    }

    loadOrderLine(invoiceItem, thisClass=this) {

        $.ajax({
            url: "/ajax/getOrderLines",
            type: "post",
            dataType: "json",
            data: {'vendor_invoice_item_id':invoiceItem}
        }).success(function(json){

            console.log(json)

            thisClass.orderSplit = data.responseJSON


               // $.each(json, function (x, itemSplit) {
                    
               //      ('.orderSplitLines[data-item='+invoiceItemId+']').append(thisClass.setOrderActions(orderNumber, splitId))

                    
               //  });

            

        }).error(function(xhr, status, error) {
           $('.updateError').removeClass('hidden');
        }).complete(function(data){
            
        })

        
    }

}

