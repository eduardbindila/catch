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
                                <button class="btn btn-lg btn-default waves-effect addNewItem"  data-toggle="modal"data-target="#addNew-modal">
                                    Add New Invoice Items
                                </button>
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
                                <button class="addExternal btn btn-lg btn-default waves-effect" data-invoice="<?php echo $userId ?>" >
                                    Add External Items
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
                                        <th>Free Stock</th>
                                        <th>Quantity</th>
                                        <th>Delivered Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th>Connect Orders</th>
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