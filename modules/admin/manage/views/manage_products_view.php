<section class="content projectPage">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Manage Products</h2>
		</div>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Price Lists</h2>
                        <ul class="header-dropdown m-r-0">
                            <li>
                                <button class="btn btn-success waves-effect" data-toggle="modal"data-target="#addNew-modal">
                                    Add Import List
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                            	<div class="alert addUserError hidden bg-pink alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    Import could not be added. <b>Please contact the administrator</b>
                                </div>
                                <div class="alert addUserSuccess hidden alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    Import has been succesfully added.
                                </div>
                               <table class="importLists_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>Import ID</th>
                                        <th>Import Name</th>
                                        <th>Uploaded Date</th>
                                        <th>Started Date</th>
                                        <th>Finished Date</th>
                                        <th>File</th>
                                        <th>Status</th>
                                        <th>User ID</th>
                                        <th>Actions</th>
                                    </thead>
                                </table>

                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" style="width: 35%">
                                        <span class="sr-only">35% Complete (success)</span>
                                    </div>
                                    <div class="progress-bar progress-bar-warning progress-bar-striped active" style="width: 20%">
                                        <span class="sr-only">20% Complete (warning)</span>
                                    </div>
                                    <div class="progress-bar progress-bar-danger" style="width: 10%">
                                        <span class="sr-only">10% Complete (danger)</span>
                                    </div>
                                </div>
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
                        <h4 class="modal-title" >Add New Import List</span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="importFormWrapper dropzone dz-clickable">
                            <form class="importProductList" method="post" action='' enctype="multipart/form-data" >
                                <input type="hidden" id="file-name" name="file_name" value="">
                                <div class="input-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="name" placeholder="Import List Name" required>
                                            </div>
                                        </div>
                                <button class="btn btn-lg btn-block btn-success waves-effect filesToDB hidden" type="submit">Import Product List</button>
                            </form>
				            <div class="dz-message">
				                <div class="drag-icon-cph">
				                    <i class="material-icons">touch_app</i>
				                </div>
				                <h3>Drop files here or click to upload.</h3>

				            </div>
				            
				        </div>
                        <div class="loader-wrapper hidden">
                            <div class="loader-container">
                                <div class="preloader pl-size-xl">
                                    <div class="spinner-layer">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="loader-messages">
                                <div class="importProductListWarning alert alert-warning">
                                    <strong>Step 1:</strong> We're importing your file. <strong>DO NOT refresh the page.</strong>
                                </div>
                                <div class="importProductListError alert alert-danger hidden">
                                    <strong>Error!</strong> We could not import the file.
                                </div>

                                 <div class="importingProducts alert alert-warning hidden">
                                    <strong>Step 2:</strong> We're saving the products in the database. It could take a few minutes. <strong>DO NOT refresh the page.</strong>
                                </div>

                                <div class="importingProductsSuccess alert alert-success hidden">
                                    <strong>Finished!</strong> <span class="noSavedProducts"></span> products have been saved. Click here to check the product list before updating the prices. 
                                </div>
                                <div class="importingProductsError alert alert-danger hidden">
                                    <strong>Error!</strong> We could not save the products. 
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