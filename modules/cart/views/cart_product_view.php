<?php 

    if(isset($productFeaturesQuery)) {

?>

    <script type="text/javascript">

        //var productFeaturesQuery = <?php echo json_encode($productFeaturesQuery); ?>;
        var productFeaturesQuery = [];

        var parent_id = '<?php echo $productParentID?>';

        var product_id = '<?php echo $productID?>';

    </script>

<?php
    }
?>

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Product #<?php echo $productID ?></h2>
		</div>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2><?php echo $productName?></h2>
                        <ol class="breadcrumb">
                          <li><a href="/cart/catalog/">Catalog</a></li>
                        </ol>
                        <div class="clearfix">
                            <ul class="m-l-0 p-l-0 m-t-10 header-dropdown">
                                 <li>
                                 
                                     <h2>Total Stock: <span class="label label-lg label-primary"><?php echo intval($stock) + intval($reservedStock)?> (F: <?php echo intval($stock)?> + R: <?php echo intval($reservedStock)?>)</span></h2>
                                </li>

                                <li >
                                    <h2>Price: <span class="label label-lg label-warning"><?php echo number_format((float)$productPrice, 2, '.', ''); ?></span></h2>
                                </li>
                                <?php 
                                    if($_pageName != "quote" && !isset($_SESSION['user_access']['client-grid']) && isset($_SESSION['user_access']['sales-grid'])) 
                                    {
                                ?>
                                <li >
                                    <h2>Aquisition Price: <span class="label label-lg label-warning"><?php echo $aquisitionPrice?></span></h2>
                                </li>
                                <li>
                                    <button class="btn btn-lg btn-default waves-effect editProduct" data-toggle="modal" data-target="#edit-modal" >
                                    Edit
                                </button>
                                 <li>
                                    <button class="btn btn-lg btn-primary waves-effect editProduct" data-toggle="modal" data-target="#product_quotes-modal" >
                                    View Product Quotes
                                </button>
                                </li>
                                <?php }?>
                            </ul> 
                        </div>
                        
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h2>Product History</h2>
                                <table class="product_history_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>Date</th>
                                        <th>Document Number</th>
                                        <th>Document Type</th>
                                        <th>Id</th>
                                        <th>Units</th>
                                        <th>Unit Price</th>
                                        <th>Total Value</th>
                                        <th>Intermediate Stock</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <img class="product-image" src="<?php echo $productImage?>" />
                            </div>
                            <div class="col-lg-5 col-lg-offset-1">
                                <?php echo $productDescription?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if(!isset($_GET['temp'])) {?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Product Diagrams</h2>
                    </div>
                    <div class="body">
                         <div class="row">
                            <?php echo $productDiagrams?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Product Features</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <table class="features-table table table-striped table-bordered table-hover dt-responsive display">
                                <thead>
                                    <th>Feature</th>
                                    <th>Value</th>

                                </thead>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    <?php }?>
	</div>
</section>

<!-- Large Size -->
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Edit Product #<?php echo $productID ?></h4>
                    </div>
                    <div class="modal-body">
                        <form id="editProductForm" method="post" action='' enctype="multipart/form-data" >
                            <div class="input-group">
                                <input type="text" class="form-control" name="product_name" placeholder="Product Name" value="<?php echo $productName?>" required>
                            </div>
                            <div class="input-group">
                                <input type="number" class="form-control" step="any" name="initial_price" placeholder="Aquisition Price" value="<?php echo $aquisitionPrice?>" required>
                            </div>
                            <div class="input-group">
                                <input type="number" class="form-control" name="stock" placeholder="Stock" value="<?php echo $stock?>" required>
                            </div>
                            <textarea class="tinymce" name="product_description" placeholder="Product Description">
                                    <?php echo $productDescription?>
                                </textarea>
                            <div class="input-group">
                                <button id="updateQuoteButton" class="btn btn-lg btn-block btn-success waves-effect" type="submit" >Update Product</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Large Size -->
        <div class="modal fade" id="product_quotes-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >View Product Quotes for  #<?php echo $productID ?></h4>
                    </div>
                    <div class="modal-body">
                        <table class="product_quotes_table table table-striped table-bordered table-hover dt-responsive display">
                            <thead>
                                <th>Quote ID</th>
                                <th>Quote Name</th>
                                <th>Quote Status</th>
                                <th>Project ID</th>
                                <th>Project Name</th>
                                <th>Reserved Stock</th>
                            </thead>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>