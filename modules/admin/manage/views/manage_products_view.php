<script type="text/javascript">
    
 	var insertResult = <?php echo $insertResult?>;

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
                         <div class="dropzone dz-clickable">
				            <div class="dz-message">
				                <div class="drag-icon-cph">
				                    <i class="material-icons">touch_app</i>
				                </div>
				                <h3>Drop files here or click to upload.</h3>

				            </div>
				            <form class="quoteFilesForm" method="post" action='' enctype="multipart/form-data" >
				                <input type="hidden" id="file-name" name="file_name" value="">
				                <div class="input-group">
									        <div class="form-line">
									            <input type="text" class="form-control" name="name" placeholder="Import List Name" required>
									        </div>
									    </div>
				                <button class="btn btn-lg btn-block btn-success waves-effect filesToDB hidden" type="submit">Import Product List</button>
				            </form>
				        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>        