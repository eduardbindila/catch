<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Import Users</h2>
		</div>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>File Upload</h2>

                    </div>
                    <div class="body">
                        <div class="alert hidden importPricesSuccess alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                The prices have been succesfully updated.</b>
                            </div>
                        <form id="importPrices" method="post" action='/ajax/updatePrices' enctype="multipart/form-data" class="">
                            <div class="alert hidden importPricesError bg-pink alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                There was a problem with the import. <b>Please contact the administrator.</b>
                            </div>
                            
                            <div class="input-group">
                                <div class="dropzone dz-clickable">
                                    <div class="dz-message">
                                        <div class="drag-icon-cph">
                                            <i class="material-icons">touch_app</i>
                                        </div>
                                        <h3>Drop files here or click to upload.</h3>
                                         <input type="hidden" id="file-name" name="file_name" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button id="submitImportPrices" class="btn btn-lg btn-block btn-success waves-effect" type="submit">Import Users</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>
</section>

