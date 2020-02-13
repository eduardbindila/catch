<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Import Products</h2>
		</div>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Get Products from Sylvania</h2>

                    </div>
                     <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div col-lg-12>
                                        <button class="btn bg-green btn-lg btn-block waves-effect sync-products" type="button" >Sync Products</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div col-lg-12>
                                        <div class="card">
                                            <div class="header">
                                                <h2>File Upload</h2>

                                            </div>
                                            <div class="body">
                                                <div class="alert hidden importPricesSuccess alert-success alert-dismissible" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        The products have been succesfully updated.</b>
                                                    </div>
                                                <form id="importProducts" method="post" action='/ajax/imprtProductsCSV' enctype="multipart/form-data" class="">
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
                                                            <button id="submitImportPrices" class="btn btn-lg btn-block btn-success waves-effect" type="submit">Import Products</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                         <button class="btn bg-red waves-effect delete-all hidden">
                                            <i class='material-icons'>remove_circle</i>
                                            <span>Delete Generated Data</span>
                                        </button>
                                         <button class="btn bg-indigo waves-effect generate-all hidden">
                                            <i class='material-icons'>all_out</i>
                                            <span>Generate all Products</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="row fully-generated hidden">
                                    <div class="col-lg-12">
                                        <div class="alert alert-info">
                                            <strong>Heads up!</strong> You've already generated all products.
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="well generated-items hidden m-t-20">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div>Generation status:</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button class="btn bg-cyan btn-lg btn-block waves-effect" type="button" data-toggle="modal" data-target="#categories-modal">
                                                        Products Generated: <span class="badge generated-products-number">--</span>
                                                    </button>
                                                    <!-- <div class="progress m-t-10">
                                                        <div class="categories-progress progress-bar bg-cyan progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="1" aria-valuemax="100" style="width: 75%"></div>
                                                    </div >-->
                                                </div>
                                                 <div class="col-lg-12">
                                                     <button class="btn bg-blue btn-lg btn-block waves-effect" type="button" data-toggle="modal" data-target="#products-modal">
                                                        Features Generated: <span class="badge generated-features-number">--</span>
                                                    </button>
                                                     <!-- <div class="progress m-t-10">
                                                        <div class="products-progress progress-bar bg-blue progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="1" aria-valuemax="100" style="width: 75%"></div>
                                                    </div> -->
                                                </div>
                                            </div>                                  
                                        </div>
                                    </div>
                                </div>
                               <!--  <button class="btn bg-blue btn-lg btn-block waves-effect diff-inserted" type="button" >Diff inserted</button> -->
                                <div class="product-split">
                                    
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- Large Size -->
	</div>
</section>

