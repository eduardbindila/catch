<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Import Categories</h2>
		</div>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Get Categories from Sylvania</h2>

                    </div>
                     <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                         <button class="btn bg-red waves-effect delete-all hidden">
                                            <i class='material-icons'>remove_circle</i>
                                            <span>Delete Generated Data</span>
                                        </button>
                                         <button class="btn bg-indigo waves-effect generate-all hidden">
                                            <i class='material-icons'>all_out</i>
                                            <span>Generate all subcategories</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="row fully-generated hidden">
                                    <div class="col-lg-12">
                                        <div class="alert alert-info">
                                            <strong>Heads up!</strong> You've already generated all the categories and product lists.
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
                                                        Categories Generated: <span class="badge generated-categories-number">--</span>
                                                    </button>
                                                    <div class="progress m-t-10">
                                                        <div class="categories-progress progress-bar bg-cyan progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="1" aria-valuemax="100" style="width: 75%"></div>
                                                    </div>
                                                </div>
                                                 <div class="col-lg-12">
                                                     <button class="btn bg-blue btn-lg btn-block waves-effect" type="button" data-toggle="modal" data-target="#products-modal">
                                                        Product Families Generated: <span class="badge generated-products-number">--</span>
                                                    </button>
                                                     <div class="progress m-t-10">
                                                        <div class="products-progress progress-bar bg-blue progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="1" aria-valuemax="100" style="width: 75%"></div>
                                                    </div>
                                                </div>
                                            </div>                                  
                                        </div>
                                    </div>
                                </div>                                
                                <table class="categories-table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th></th>
                                        <th>Category ID</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>URL</th>
                                        <th>Parent ID</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- Large Size -->
        <div class="modal fade" id="categories-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="largeModalLabel">Sylvania Generated Categories</h4>
                    </div>
                    <div class="modal-body">
                        <button type="button" class="btn bg-indigo waves-effect view-generated-categories">Generate Categories</button>
                        <button type="button" class="btn bg-green waves-effect insert-categories hidden">Insert categories into Database</button>
                        
                        <ul class="show-generated-categories m-t-20 list-group">
                        </ul>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
	</div>
</section>

