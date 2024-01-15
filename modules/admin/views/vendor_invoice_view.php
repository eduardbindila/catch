<script type="text/javascript">
    
    var isDisabled = <?php echo is_numeric($userId) ?>;

    var insertResult = <?php echo $insertResult?>;

    var invoiceData = <?php echo json_encode($invoiceQuery)?>;

    var invoiceId = <?php echo $userId ?>;

</script>

<section class="content projectPage">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Vendor Invoices</h2>
		</div>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Vendor Invoice Details</h2>
                        <ul class="header-dropdown m-r-0">
                            <li>
                                <div class="switch">
                                    Edit: <label>OFF<input name="edit" class="editSwitch" type="checkbox"><span class="lever"></span>ON</label>
                                </div>
                            </li>
                            <li>
                                <div class="switch">
                                    Inventory: <label>NO<input name="inventory" class="inventorySwitch" type="checkbox"><span class="lever switch-col-green"></span>YES</label>
                                </div>
                            </li>
                           
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert addUserError hidden bg-pink alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    Vendor invoice could not be added. <b>Please contact the administrator</b>
                                </div>
                                <div class="alert addUserSuccess hidden alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    Vendor invoice has been succesfully added.
                                </div>
                                <?php 
                                    include($_MPATH['ADMIN_VIEWS'].'add_vendor_invoice_form_view.php');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="header">
                        <h2>Vendor Invoice Items</h2>
                        <ul class="header-dropdown m-r-0">
                             <li>
                                <button class="btn btn-lg btn-primary waves-effect addNewItem"  data-toggle="modal"data-target="#addNew-modal">
                                    Add New Invoice Items
                                </button>
                            </li>
                            <li>
                                <button class="btn btn-lg btn-primary waves-effect addInventoryData hidden"  data-toggle="modal"data-target="#addInventoryData-modal">
                                    Add Inventory Data
                                </button>
                            </li>
                            <li>
                                <button class="addExternal btn btn-lg btn-default waves-effect" data-invoice="<?php echo $userId ?>" >
                                    Add External Items
                                </button>
                            </li>
                            <li>
                                <button class="activateInventory btn btn-lg btn-success waves-effect hidden" data-invoice="<?php echo $userId ?>" >
                                    Activate Inventory
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="invoice_items_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th></th>
                                        <th>Product</th>
                                        <th>Type</th>
                                        <th>Free Stock</th>
                                        <th>Reserved Stock</th>
                                        <th><span class="showInventory hidden">Inventory </span>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th><span class="showInventory hidden">Inventory Difference </span>Delivered Quantity</th>
                                        <th>Connected Quantity</th>
                                        <th>Connect Orders</th>
                                        <th>Remove</th>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</section>

   <!-- Large Size -->
    <div class="modal fade" id="addNew-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title quoteTitle hidden" >Add new item to Invoice #<span id="quoteNumber"></span></h4>
                </div>
                <div class="modal-body">
                            <?php include($_MPATH['CART_CONTROLLERS'].'cart_search_controller.php');?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Large Size -->
    <div class="modal fade" id="addInventoryData-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title quoteTitle" >Add inventory data</h4>
                </div>
                <div class="modal-body">
                            <h4>Copy here from XLS Product id and Quantity<h4>
                              <textarea id="excel_data" rows="10" cols="50" placeholder=""></textarea>
                            <br>
                            <button id="submitBtn" class="btn btn-lg btn-primary waves-effect">Show Data</button>

                            <button id="confirmBtn" class="btn btn-lg btn-success waves-effect " style="display: none;">Confirm and Add Inventory</button>

                            <div id="tableContainer" ></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Large Size -->
    <div class="modal fade" id="addConnection-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" >Add new connection </h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box bg-red">
                                    <div class="icon">
                                        <i class="material-icons">star</i>
                                    </div>
                                    <div class="content">
                                        <div class="text">PRODUCT</div>
                                        <div class="number info-box-productID">-</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <div class="info-box bg-blue">
                                    <div class="icon">
                                        <i class="material-icons">folder</i>
                                    </div>
                                    <div class="content">
                                        <div class="text">STOCK</div>
                                        <div class="number info-box-stock">-</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <div class="info-box bg-light-green">
                                    <div class="icon">
                                        <i class="material-icons">create_new_folder</i>
                                    </div>
                                    <div class="content">
                                        <div class="text">DELIVERED</div>
                                        <div class="number  info-box-deliveredQuantity">-</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <div class="info-box bg-green">
                                    <div class="icon">
                                        <i class="material-icons">forward</i>
                                    </div>
                                    <div class="content">
                                        <div class="text">CONNECTED</div>
                                        <div class="number  info-box-connected">-</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <div class="info-box bg-orange">
                                    <div class="icon">
                                        <i class="material-icons">forward</i>
                                    </div>
                                    <div class="content">
                                        <div class="text">FROM STOCK</div>
                                        <div class="number  info-box-from-stock">-</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <div class="info-box bg-orange">
                                    <div class="icon">
                                        <i class="material-icons">forward</i>
                                    </div>
                                    <div class="content">
                                        <div class="text">TO STOCK</div>
                                        <div class="number  info-box-to-stock">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="connections_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>Quote Item ID</th>
                                        <th>Quote ID</th>
                                        <th>Quote Quantity</th>
                                        <th>Reserved Quantity</th>
                                        <th>Order Number</th>
                                        <th>Ordered Quantity</th>
                                        <th>Needed for Quote</th>
                                        <th>Distributed</th>
                                        <th>Line Status</th>
                                        <th>Connect</th>
                                    </thead>
                                </table>
                            </div>
                        </div>

                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

