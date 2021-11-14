
<script type="text/javascript">

        var parent_id = '<?php echo $_pageName; ?>';
        var productList = '';
 </script>

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Catalog</h2>

		</div>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Categories</h2>
                        <ol class="breadcrumb">
						  <li><a href="/cart/catalog/">Catalog</a></li>
						</ol>
                    </div>
                    <div class="body">
                    	<div class="row">
                    		<div class="col-lg-10 col-lg-offset-1">
		                        <?php
			                        foreach($categoriesQuery as $category) {
										include($_MPATH['CART_VIEWS'].'catalog_item_view.php');
									}
		                        ?>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if(isset($productsQuery) && $productsQuery) {?>
        	<script type="text/javascript">
		        productList = '<?php echo json_encode($productsQuery); ?>';

		        productList = JSON.parse(productList);
		 </script>
        <div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Products</h2>
                    </div>
                    <div class="body">
                    	<table class="results-table table table-striped table-bordered table-hover dt-responsive display" id="results-table">
                                <thead>
                                    <th>Image</th>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Aquisition Price</th>
                                    <th>Price</th>
                                </thead>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    	<?php }?>
	</div>
</section>

