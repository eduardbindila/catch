
<script type="text/javascript">
    var isDisabled = 0;
    var insertResult = <?php echo $insertResult?>;

</script>


<section class="content projectPage">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Client Invoices</h2>
		</div>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Client Invoices List</h2>
                        <ul class="header-dropdown m-r-0">
                            <!-- <li>
                                <button class="btn btn-success waves-effect" data-toggle="modal"data-target="#addNew-modal">
                                    Add Vendor Invoice
                                </button>
                            </li> -->
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert addUserError hidden bg-pink alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    Vendor Invoice could not be added. <b>Please contact the administrator</b>
                                </div>
                                <div class="alert addUserSuccess hidden alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    Vendor Invoice has been succesfully added.
                                </div>
                               <table class="invoices_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>Package ID</th>
                                        <th>Package Status</th>
                                        <th>Quote ID</th>
                                        <th>Invoice No</th>
                                        <th>Client </th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Due Date</th>
                                        <th>Client Saga Code</th>
                                        <th>Saga Import Status</th>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</section>