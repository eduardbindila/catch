<script type="text/javascript">
    var listID = '<?php echo $listID?>';
</script>


<section class="content projectPage">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Manage Products</h2>
		</div>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Products from import list id: <?php echo $listID?> </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                               <table class="importLists_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>ID</th>
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>Saga Stock</th>
                                        <th>Saga Comment</th>
                                        <th>New Product ID</th>
                                        <th>Manufacturer</th>
                                        <th>New Price</th>
                                        <th>Old Price</th>
                                        <th>Comment</th>
                                        <th>Status ID </th>
                                        <th>Status</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</section>