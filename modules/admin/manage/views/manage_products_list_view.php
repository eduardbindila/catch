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

