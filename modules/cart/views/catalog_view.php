
<script type="text/javascript">

        var parent_id = '<?php echo $_pageName; ?>';
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
	</div>
</section>

