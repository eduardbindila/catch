<?php 

    if(isset($productFeaturesQuery)) {

?>

    <script type="text/javascript">

        var productFeaturesQuery = <?php echo json_encode($productFeaturesQuery); ?>;

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
                        <small><?php echo $productParentID?></small>

                    </div>
                    <div class="body">
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
	</div>
</section>

