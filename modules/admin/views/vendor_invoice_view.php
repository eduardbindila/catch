<script type="text/javascript">
    
    var isDisabled = <?php echo is_numeric($userId) ?>;

    var insertResult = <?php echo $insertResult?>;

    var invoiceData = <?php echo json_encode($invoiceQuery)?>;


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
            </div>
        </div>
	</div>
</section>