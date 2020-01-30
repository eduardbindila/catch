
<section class="content projectPage">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Access</h2>
		</div>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>User Types</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                               <table class="projects_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>User Type ID</th>
                                        <th>User Type</th>
                                        <th></th>
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
        <div class="modal fade" id="editAccess-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Access for <span id="accessName"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="editWrapper">
                            <form id="accessElements" method="post" action='' enctype="multipart/form-data" >
                                <?php

                                foreach ($accessElements as $key => $element) {
            
                                ?>
                                    <div class="input-group">
                                        <div class="form-line">
                                            <input type="checkbox" id="access_<?php echo $key ?>" name="access[]" value="
                                            <?php echo $key ?>" class="filled-in chk-col-light-green">
                                            <label for="access_<?php echo $key ?>"><?php echo $element['name'] ?></label>
                                        </div>
                                    </div>
                                <?php 
                                }
                                ?>
                                 <div class="row">
                                    <div class="col-xs-12">
                                        <input type="hidden" id="user-type-id" name="user_type_id" value="">
                                        <button id="submitEdit" class="btn btn-lg btn-block btn-success waves-effect" type="submit">Save settings</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
</section>