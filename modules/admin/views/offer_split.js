class OrderSplit {
    constructor(itemId, productId) {
       this.itemId = itemId;
       this.productId = productId;
       this.orderSplit = [];
    }

    setWrapper() {

        var wrapper = '<div class="row">'+
                        '<div class="col-lg-1">'+
                            '<div class="btn-group">'+
                                '<button type="button" class="btn addLineButton btn-default btn-xs waves-effect"'+
                                 ' data-toggle="dropdown" aria-haspopup="true" data-item='+this.itemId+' aria-expanded="true">'+
                                    '<i class="material-icons">add</i>'+
                                '</button>'+
                                '<ul class="dropdown-menu orderSplitorders item-'+this.itemId+'"'+
                                ' data-item='+this.itemId+' data-product="'+this.productId+'">'+
                                '</ul>'+
                           '</div>'+
                        '</div>'+
                        '<div class="col-lg-11 orderSplitLines" data-item='+this.itemId+' data-product="'+this.productId+'">'+
                            '<ul class="list-total hidden"  data-item="'+this.itemId+'">'+
                                '<li> <span>Total: <span class="invoicedQuantity">x</span> invoiced'+
                                    ' - <span class="totalSplitQuantity">y</span> split'+
                                    ' = <span class="freeStock">y</span> free stock</span>'+
                                    '<span class="quantityError hidden">'+
                                        '<i class="material-icons">error</i>'+
                                    '</span>'+
                                ' </li>'+
                            '</ul>'+
                        '</div>'+
                        '<div class="col-lg2">'+
                            '<button type="button" data-item='+this.itemId+' class="removeItem  btn btn-danger btn-xs waves-effect">'+
                                 'Remove Item'+
                                '</button>'+
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
                    ////console.log(quoteItem, invoiceItem.id)
                    thisClass.loadOrderLine(invoiceItem.id, quoteItem.order_number, quoteItem.needed_quantity, quoteItem.id, quoteItem.quoteQuantity, quoteItem.reserved_stock );
                    $('.item-'+invoiceItem.id).append(
                            '<li class=""><a data-item="'+invoiceItem.id+'"'+
                                ' data-quoteItem="'+quoteItem.id+'"'+
                                ' data_neededQuantity="'+quoteItem.needed_quantity+'"'+
                                ' data-order="'+quoteItem.order_number+'"'+
                                ' data-quoteQuantity="'+quoteItem.quoteQuantity+'"'+
                                ' data-reservedStock="'+quoteItem.reserved_stock+'"'+
                                ' data-quoteId="'+quoteItem.quote_id+'"'+
                                ' class="orderItem waves-effect waves-block">'+
                                '<span class="order-selected hidden"><i class="material-icons">check_circle</i></span>'+
                                    quoteItem.order_number +
                                    ' <span class="order-pcs">(N:'+quoteItem.needed_quantity+'/O:'+quoteItem.ordered_quantity+'pcs)</span>'+
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

    setOrderActions(order_number, split_id, quoteItemId, invoiceItemId, needed_quantity, quantity, quoteId, quoteQuantity, reserved_stock){
        if(quantity == needed_quantity) {
            var checked = '';
            var disabled = 'disabled';
            var displayQuantity = quantity;
        } else {
            var checked = 'checked';
            var disabled = '';
            var displayQuantity = quantity;
        }

        var invoiceQuantity = $('.vendor-invoice-input[name="quantity"][data-item='+invoiceItemId+']').val();

        var totalLine = $('.orderSplitLines[data-item='+invoiceItemId+']');


        var actionsList = '<ul class="list-inline" data-split='+split_id+' data-order="'+order_number+'" data-item='+invoiceItemId+' data-quoteItem="'+quoteItemId+'" data-reserved="'+reserved_stock+'">'+
                                '<li>Order: <b class="splitLineInfo">'+order_number+'</b> Quote: <a href="/quote/'+quoteId+'" target="_blank" ><b class="splitLineInfo">'+quoteId+'</b></a> QQty: <b class="splitLineInfo" title="Quote Quantity">'+
                                quoteQuantity+'</b> RQty: <b class="splitLineInfo" title="Reserved Quantity">'+reserved_stock+'</b></li>'+
                                '<li>'+
                                    '<div class="switch">'+
                                        '<label>'+
                                            'Fill<input type="checkbox" data-item='+invoiceItemId+' data-splitQuantity="'+quantity+'" data-neededQuantity="'+needed_quantity+'"'+
                                            ' data-split='+split_id+' class="reserve_custom" '+checked+'>'+
                                            '<span class="lever green-tick-left"></span>'+
                                            '<input class="small-input" value="'+displayQuantity+'" type="number"'+ 
                                            'placeholder="Custom" data-split='+split_id+' data-quoteItem='+quoteItemId+' data-item='+invoiceItemId+' '+disabled+' name="reserve_custom" min=0 >'+
                                        '</label>'+
                                    '</div>'+
                                '</li>'+
                                '<li>'+
                                    '<button type="button" data-split='+split_id+' data-quoteItem="'+quoteItemId+'" data-order="'+order_number+
                                        '" data-item='+invoiceItemId+' class="removeLine btn btn-danger btn-xs waves-effect">'+
                                    '<i class="material-icons">close</i>'+
                                '</button>'+
                                '</li>'+
                            '</ul>';

        return actionsList
    }

    addOrderLine(invoiceItemId, quoteItemId, quantity, orderNumber, quoteId, quoteQuantity, reserved_stock, thisClass=this){

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

               thisClass.setOrderLine(invoiceItemId, orderNumber, splitId, quoteItemId, quantity, quantity, quoteId, quoteQuantity, reserved_stock)

            }).error(function(xhr, status, error) {
               $('.updateError').removeClass('hidden');
            }).complete(function(data){
                orderLine['id']=data.responseJSON;
                //console.log(data.responseJSON);
                    thisClass.orderSplit = orderLine;
            })
        }

    }

    setOrderLine(invoiceItemId, orderNumber, splitId, quoteItemId, needed_quantity, quantity, quoteId, quoteQuantity, reserved_stock) {

        //console.log(quoteItemId);

        var splitlines = $('.orderSplitLines[data-item='+invoiceItemId+']')

        $('.orderSplitorders[data-item='+invoiceItemId+'] .orderItem[data-order="'+orderNumber+'"][data-quoteItem="'+quoteItemId+'"] .order-selected').removeClass('hidden');

        splitlines.prepend(this.setOrderActions(orderNumber, splitId, quoteItemId, invoiceItemId, needed_quantity, quantity, quoteId, quoteQuantity, reserved_stock));

        //console.log(invoiceItemId, $('.line-total[data-item='+invoiceItemId+']'));

        //console.log($('.reception[data-item='+invoiceItemId+']').prop('disabled'))

        if($('.reception[data-item='+invoiceItemId+']').prop('disabled') == true) {
            this.disableActions(invoiceItemId);    
        }
        

       if($('.orderSplitLines[data-item='+invoiceItemId+'] .list-inline').length > 0) {
            splitlines.parent('.row').find('.removeItem').addClass('hidden');

            $('.list-total[data-item='+invoiceItemId+']').removeClass('hidden');
            $('.vendor-invoice-input[data-item='+invoiceItemId+']').prop('disabled', true);


            //console.log('why');


            var splitTotal = Number(this.getSplitTotal(invoiceItemId));

            var invoicedQuantity = Number($('.vendor-invoice-input[name="quantity"][data-item='+invoiceItemId+']').val())

            if((invoicedQuantity - splitTotal + quantity) < 0 ) {
                //console.log('nope');
                $('.list-total[data-item='+invoiceItemId+'] .quantityError').removeClass('hidden');
                $('.reception[data-item='+invoiceItemId+']').addClass('btn-danger').removeClass('btn-default').prop('disabled', true)
                this.setTotal(invoiceItemId, invoicedQuantity, splitTotal);
            } else {
                this.setTotal(invoiceItemId, invoicedQuantity, splitTotal);
            }
       }
    }

    loadOrderLine(invoiceItem, orderNumber, needed_quantity, quoteItemId, quoteQuantity, reserved_stock, thisClass=this) {

        $.ajax({
            url: "/ajax/getOrderLines",
            type: "post",
            dataType: "json",
            data: {'vendor_invoice_item_id':invoiceItem, 'order_number':orderNumber, 'quote_item_id': quoteItemId}
        }).success(function(json){

            thisClass.orderSplit = json

            //console.log(json)

           $.each(json, function (x, itemSplit) {

            //console.log(itemSplit);
 
              //thisClass.setOrderLine(invoiceItem, orderNumber, itemSplit.id, itemSplit.quote_item_id, needed_quantity, itemSplit.quantity);

              thisClass.setOrderLine(invoiceItem, orderNumber, itemSplit.id, itemSplit.quote_item_id, needed_quantity, itemSplit.quantity, itemSplit.quote_id, itemSplit.quoteQuantity, itemSplit.reserved_stock, );
            });

        }).error(function(xhr, status, error) {
           $('.updateError').removeClass('hidden');
        }).complete(function(data){
            
        })

        
    }


    removeLine(itemId, splitId, orderNumber, quoteItemId, that){

        var thisClass = this;
        //console.log(splitId)
        $.ajax({
            url: "/ajax/removeOrderLine",
            type: "post",
            dataType: "json",
            data: {'id':splitId}
        }).success(function(json){

        }).error(function(xhr, status, error) {
           
        }).complete(function(data){
            //console.log($(that));
            $(that).closest('ul[data-split='+splitId+']').remove();



             if($('.orderSplitLines[data-item='+itemId+'] .list-inline').length == 0) {
                $('.orderSplitLines[data-item='+itemId+']').parent('.row').find('.removeItem').removeClass('hidden');
                $('.list-total[data-item='+itemId+']').addClass('hidden');
                $('.vendor-invoice-input[data-item='+itemId+']').prop('disabled', false);
            }

            var splitTotal = Number(thisClass.getSplitTotal(itemId));

            var invoicedQuantity = Number($('.vendor-invoice-input[name="quantity"][data-item='+itemId+']').val())

            thisClass.setTotal(itemId, invoicedQuantity, splitTotal);

            if(invoicedQuantity >= splitTotal) {
                $('.list-total[data-item='+itemId+'] .quantityError').addClass('hidden');
                $('.reception[data-item='+itemId+']').removeClass('btn-danger').addClass('btn-default').prop('disabled', false)
            }

            

            //console.log($('.orderSplitorders[data-item='+itemId+'] .orderItem[data-order="'+orderNumber+'"] .order-selected'))
            $('.orderSplitorders[data-item='+itemId+'] .orderItem[data-order="'+orderNumber+'"][data-quoteItem="'+quoteItemId+'"] .order-selected').addClass('hidden');

        })
    }

    updateLine(splitId, quantity){
        //console.log(splitId, quantity)

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

    getSplitTotal(itemId){
        //console.log(splitId, quantity)

        var splitItemsQuantities = $('input[name="reserve_custom"][data-item='+itemId+']');

        var splitTotal = 0;

        //console.log(splitItemsQuantities.val());

        splitItemsQuantities.each(function(index, item){

             //console.log(item);

            var itemQuantity = $(item).val();

            splitTotal = Number(splitTotal) + Number(itemQuantity);
        })

        //console.log(splitTotal, $('.list-total[data-item='+itemId+'] .totalSplitQuantity'));

        return splitTotal;
    }

    setTotal(itemId, invoicedQuantity, splitTotal) {

        $('.list-total[data-item='+itemId+'] .invoicedQuantity').text(invoicedQuantity);
        $('.list-total[data-item='+itemId+'] .totalSplitQuantity').text(splitTotal);
        $('.list-total[data-item='+itemId+'] .freeStock').text(invoicedQuantity - splitTotal);
    }


    disableActions(itemId) {
        $('input[name="reserve_custom"][data-item='+itemId+']').prop('disabled', true);
        $('.reserve_custom[data-item='+itemId+']').prop('disabled', true);
        $('.addLineButton[data-item='+itemId+']').prop('disabled', true);
        $('.removeLine[data-item='+itemId+']').prop('disabled', true);
    }

    enablections(itemId) {
        $('input[name="reserve_custom"][data-item='+itemId+']').prop('disabled', false);
        $('.reserve_custom[data-item='+itemId+']').prop('disabled', false);
        $('.addLineButton[data-item='+itemId+']').prop('disabled', false);
        $('.removeLine[data-item='+itemId+']').prop('disabled', false);
    }
}