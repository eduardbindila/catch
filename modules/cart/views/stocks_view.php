
<?php 

    if(isset($searchResult)) {

?>

    <script type="text/javascript">

        var searchResult = <?php echo json_encode($searchResult); ?>;

        var searchTemporary = <?php echo $searchTemporary ?>;

    </script>

<?php
    }
?>



<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Search Product</h2>
		</div>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Search Criteria</h2>
                       
 
                    </div>
                    <div class="body">
                          <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <li role="presentation" class="active"><a href="#bulk" data-toggle="tab">Bulk Search</a></li>
                               
                            </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="bulk">
                                <form id="searchForm" method="">
                                    <div class="row m-t-10" id="searchBulk">
                                            <div class="col-lg-12">
                                               <textarea name="searchBulk" height="80" class="form-control" placeholder="Bulk Search " ></textarea> 
                                            </div>
                                    </div>
                                    <div class="row m-t-10">
                                        <div class="col-lg-12">
                                            <button type="submit" id="searchButton" class="btn btn-block btn-lg btn-primary waves-effect search">Search</button>
                                        </div>
                                    </div>
                                    <div class="row  loggin-error >" >
                                        <div class="col-lg-12">
                                            <div class="alert login-error-alert searchError hidden bg-pink alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                No product has been found
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row show-table">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Search Result</h2>
                        <ul class="header-dropdown m-r-0">
                            <li>
                                <button class="btn btn-success waves-effect viewAllStocks" >
                                    View All Stocks
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                            <div class="alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                Press "Enter" key when you finish adding a new product.
                            </div>
                            <table class="results-table table table-striped table-bordered table-hover dt-responsive display" id="results-table">
                                <thead>
                                    <th>Image</th>
                                    <th>Stock ID</th>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                     <th>Price</th>
                                     <th>Stock Quantity</th>
                                     <th>Stock Location</th>
                                     <th>Existing Stock</th>

                                </thead>
                            </table>
                            <input class="hidden" onClick="javascript:void(0)" type="submit">
                    </div>
                </div>
            </div>
            
        </div>

	</div>
</section>

