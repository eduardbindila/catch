
<?php 

    if(isset($searchResult)) {

?>

    <script type="text/javascript">

        var searchResult = <?php echo json_encode($searchResult); ?>;

        var searchTemporary = <?php echo $searchTemporary ?>

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
                        <ul class="header-dropdown m-r-0">
                            <li>
                                <button class="addFromWishlist btn btn-primary waves-effect" >
                                    Search from wishlist
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                          <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <li role="presentation" class="active"><a href="#bulk" data-toggle="tab">Bulk Search</a></li>
                                <li role="presentation" ><a href="#single" data-toggle="tab">Single Search</a></li>
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
                            <div role="tabpanel" class="tab-pane fade in" id="single">
                                <form id="searchForm2" method="">
                                    <div class="row m-t-10" id="searchBulk">
                                        <div class="col-lg-12">
                                           <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="criteria" placeholder="Search by Id" >
                                                </div>
                                            </div>
                                            <div class="input-group">OR</div>
                                             <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="product_name" placeholder="Search by Name" >
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="row m-t-10">
                                        <div class="col-lg-12">
                                            <button type="submit" id="searchButton2" class="btn btn-block btn-lg btn-primary waves-effect search">Search</button>
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

                    </div>
                    <div class="body">
                            <div class="alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                Press "Enter" key when you finish adding a new product.
                            </div>
                            <table class="results-table table table-striped table-bordered table-hover dt-responsive display" id="results-table">
                                <thead>
                                    <th></th>
                                    <th>Image</th>
                                    <th>Image URL</th>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <!-- <th>Product Description</th>
                                    <th>Energy Label</th> -->
                                      <th>Stock</th>
                                    <th>Manufacturer</th>
                                     <th>Price</th>
                                     <th>Quantity</th>
                                    <th>Existing Stock</th>

                                </thead>
                            </table>
                            <input class="hidden" onClick="javascript:void(0)" type="submit">
                    </div>
                </div>
            </div>
            
        </div>
         <!-- Large Size -->
        <div class="modal fade" id="categories-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="largeModalLabel">Add Quote to Project</h4>
                    </div>
                    <div class="modal-body">
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <?php 
                                    if(!isset($_SESSION['user_access']['client-grid'])) 
                                    {
                                ?>
                                <li role="presentation"><a href="#existingProject" data-toggle="tab">Choose existing project</a></li>

                                <?php }?>
                                <li role="presentation"  class="active"><a href="#newProject" data-toggle="tab">Add to new project</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade" id="existingProject">
                                    <table class="projects_table table table-striped table-bordered table-hover dt-responsive display">
                                        <thead>
                                            <th></th>
                                            <th>Project ID</th>
                                            <th>Project Name</th>
                                            <th>Project Description</th>
                                            <th>Owner Id</th>
                                        </thead>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane fade in active" id="newProject">
                                    <form id="addProject" method="POST" action="">
                                        <div class="alert hidden addProjectForm bg-pink alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            The project could not be added. <b>Please contact the administrator.</b>
                                        </div>
                                        <div class="input-group">
                                            <h3>Add new project</h3>
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="project_name" placeholder="Project Name" required>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="project_description" placeholder="Project Description" required>
                                            </div>
                                        </div>
                                        <div class="alert usersSelectorError hidden bg-pink alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            Users could not be retrieved. <b>Please contact the administrator</b>
                                        </div>
                                        <div class="input-group">
                                            <select class="form-control usersSelector" required name="owner_id">
                                                <option value="">Select Owner</option>
                                            </select>
                                        </div>
                                        <div class="alert categorySelectorError hidden bg-pink alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            Categories could not be retrieved. <b>Please contact the administrator</b>
                                        </div>
                                        <div class="input-group">
                                            <select class="form-control categorySelector" required name="category_name">
                                                <option value="">Select Category</option>
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <button class="btn btn-lg btn-block btn-success waves-effect" type="submit">Add New Project & Continue</button>
                                            </div>
                                        </div>
                                    </form>
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

         <!-- Large Size -->
        <div class="modal fade" id="status-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="statusModalLabel">Quote Creation Status</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert hidden quoteCreation bg-pink alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                           The quote could not be created. <b>Please contact the administrator</b>
                        </div>
                        <div class="alert hidden quoteItemsCreation bg-pink alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                           The products could not be added to quote. <b>Please contact the administrator</b>
                        </div>
                        <div class="row m-t-20">
                            <div class="col-lg-4">
                                <div class="step-wrapper">
                                    <span class="step-number">1</span>
                                    <span class="step-label">Project has been chosen</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="step-wrapper">
                                    <span class="step-number">2</span>
                                    <span class="step-label">Create Quote</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="step-wrapper">
                                    <span class="step-number">3</span>
                                    <span class="step-label">Assign Items to Quote</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-info progress-bar-striped active" style="width: 100%">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-warning quote-progress progress-bar-striped active" style="width: 30%">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                               <div class="progress">
                                    <div class="progress-bar items-progress progress-bar-danger progress-bar-striped active" style="width: 3%">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar items-progress progress-bar-info progress-bar-striped active" style="width: 3%">
                                    
                                </div>
                                <div class="progress-bar progress-bar-warning progress-bar-striped active" style="width: 3%">
                                    
                                </div>
                                <div class="progress-bar progress-bar-danger progress-bar-striped active" style="width: 3%">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="countdown"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
	</div>
</section>

<div class="modal fade" id="getDeliveryStatus-modal" tabindex="-1" role="dialog" data-quote="<?php echo $quote['id']?>">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Quote #<span class="quoteNumberStatus"> - Delivery Status <span id=""></span></h4>
                    </div>
                    <div class="modal-body">

                         <div class="preloader pl-size-l verify_preloader">
                            <div class="spinner-layer pl-red-grey">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>

                         <ul id="timeline" class="timeline"></ul>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
