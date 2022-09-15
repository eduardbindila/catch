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
                    //console.log(quoteItem, invoiceItem)
                    //console.log(quoteItem, invoiceItem.id)
                    thisClass.loadOrderLine(invoiceItem.id, quoteItem.order_number, quoteItem.needed_quantity);
                    $('.item-'+invoiceItem.id).append(
                            '<li class=""><a data-item="'+invoiceItem.id+'"'+
                                ' data-quoteItem="'+quoteItem.id+'"'+
                                ' data_neededQuantity="'+quoteItem.needed_quantity+'"'+
                                ' data-order="'+quoteItem.order_number+'"'+
                                ' class="orderItem waves-effect waves-block">'+
                                '<span class="order-selected hidden"><i class="material-icons">check_circle</i></span>'+
                                    quoteItem.order_number +
                                    ' <span class="order-pcs">('+quoteItem.needed_quantity+'pcs)</span>'+
                                    '</a>'+
                            '</li>'
                        );
                });
            }).error(function(xhr, status, error) {
               //$('.updateError').removeClass('hidden');
            }).done(function(json){

            })
    }

    getOrderSplit(){
        return this.orderSplit;
    }


    setOrderActions(order_number, split_id, quoteItemId, invoiceItemId, needed_quantity, quantity){
        if(quantity == needed_quantity) {
            var checked = '';
            var disabled = 'disabled';
            var displayQuantity = '';
        } else {
            var checked = 'checked';
            var disabled = '';
            var displayQuantity = quantity;
        }

        //console.log(order_number);

        var actionsList = '<ul class="list-inline" data-split='+split_id+' data-order="'+order_number+'" data-quoteItem="'+quoteItemId+'">'+
                                '<li>Order: <b class="orderName">'+order_number+'</b></li>'+
                                '<li>'+
                                    '<div class="switch">'+
                                        '<label>'+
                                            'Fullfill<input type="checkbox" data-item='+invoiceItemId+' data-splitQuantity="'+quantity+'" data-neededQuantity="'+needed_quantity+'"'+
                                            ' data-split='+split_id+' class="reserve_custom" '+checked+'>'+
                                            '<span class="lever green-tick-left"></span>'+
                                            '<input class="small-input" value="'+displayQuantity+'" type="number"'+ 
                                            'placeholder="Custom" data-split='+split_id+' data-item='+invoiceItemId+' '+disabled+' name="reserve_custom" min=0 >'+
                                        '</label>'+
                                    '</div>'+
                                '</li>'+
                                '<li>'+
                                    '<button type="button" data-split='+split_id+' data-order="'+order_number+'" data-item='+invoiceItemId+' class="removeLine btn btn-danger btn-xs waves-effect">'+
                                    '<i class="material-icons">close</i>'+
                                '</button>'+
                                '</li>'+
                            '</ul>';

        return actionsList
    }

    addOrderLine(invoiceItemId, quoteItemId, quantity, orderNumber, thisClass=this){

        if($('.orderSplitLines[data-item='+invoiceItemId+'] ul[data-quoteItem='+quoteItemId+']').length == 0) {
        
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
               thisClass.setOrderLine(invoiceItemId, orderNumber, splitId, quoteItemId, quantity, quantity)

            }).error(function(xhr, status, error) {
               $('.updateError').removeClass('hidden');
            }).complete(function(data){
                orderLine['id']=data.responseJSON;
                console.log(data.responseJSON);
                    thisClass.orderSplit = orderLine;
            })
        }

    }

    setOrderLine(invoiceItemId, orderNumber, splitId, quoteItemId, needed_quantity, quantity) {
    //console.log(orderNumber);    
            $('.orderSplitorders[data-item='+invoiceItemId+'] .orderItem[data-order="'+orderNumber+'"] .order-selected').removeClass('hidden');

        $('.orderSplitLines[data-item='+invoiceItemId+']').append(this.setOrderActions(orderNumber, splitId, quoteItemId, invoiceItemId, needed_quantity, quantity));
    }

    loadOrderLine(invoiceItem, orderNumber, needed_quantity, thisClass=this) {

        console.log('a')

        $.ajax({
            url: "/ajax/getOrderLines",
            type: "post",
            dataType: "json",
            data: {'vendor_invoice_item_id':invoiceItem, 'order_number':orderNumber}
        }).success(function(json){

            thisClass.orderSplit = json

            console.log(json)

           $.each(json, function (x, itemSplit) {
                // if(($('.orderSplitLines[data-item='+invoiceItem+'] ul[data-split='+itemSplit.id+']').length == 0 )) {

                //     console.log(orderNumber);

                //     thisClass.setOrderLine(invoiceItem, orderNumber, itemSplit.id, itemSplit.quote_item_id, needed_quantity, itemSplit.quantity,)
                // }



                    thisClass.setOrderLine(invoiceItem, orderNumber, itemSplit.id, itemSplit.quote_item_id, needed_quantity, itemSplit.quantity,)
            });

        }).error(function(xhr, status, error) {
           $('.updateError').removeClass('hidden');
        }).complete(function(data){
            
        })

        
    }


    removeLine(itemId, splitId, orderNumber, that){
        console.log(splitId)
        $.ajax({
            url: "/ajax/removeOrderLine",
            type: "post",
            dataType: "json",
            data: {'id':splitId}
        }).success(function(json){

        }).error(function(xhr, status, error) {
           
        }).complete(function(data){
            $(that).closest('ul[data-split='+splitId+']').remove();
            console.log($('.orderSplitorders[data-item='+itemId+'] .orderItem[data-order="'+orderNumber+'"] .order-selected'))
            $('.orderSplitorders[data-item='+itemId+'] .orderItem[data-order="'+orderNumber+'"] .order-selected').addClass('hidden');

        })
    }

    updateLine(splitId, quantity){
        console.log(splitId, quantity)

        $.ajax({
            url: "/ajax/updateOrderLine",
            type: "post",
            dataType: "json",
            data: {'id':splitId,'quantity': quantity}
        }).success(function(json){

        }).error(function(xhr, status, error) {
           
        }).complete(function(data){

        })
    }
}