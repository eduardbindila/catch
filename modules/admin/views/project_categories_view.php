
<script type="text/javascript">
    var isDisabled = 0;
    var insertResult = <?php echo $insertResult?>;

</script>


<section class="content projectPage">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Project Categories</h2>
		</div>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Project Categories</h2>
                         <ul class="header-dropdown m-r-0">
                            <li>
                                <button class="btn btn-success waves-effect" data-toggle="modal"data-target="#addNew-modal">
                                    Add Category
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">

                                <table class="projects_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>Category ID</th>
                                        <th>Category Name</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
    <!-- Large Size -->
        <div class="modal fade" id="addNew-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add new Category</span></h4>
                    </div>
                    <div class="modal-body">
                        <?php 

                            include($_MPATH['ADMIN_VIEWS'].'add_project_categories_form_view.php');

                         ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
</section>