<script type="text/javascript">
    
    var isDisabled = <?php echo is_numeric($userId) ?>;

    var insertResult = <?php echo $insertResult?>;

    var userDetails = <?php echo json_encode($userQuery)?>;


</script>

<section class="content projectPage">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Clients</h2>
		</div>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Client Details</h2>
                        <ul class="header-dropdown m-r-0">
                            <li>
                                <div class="switch">
                                    Edit: <label>OFF<input name="edit" class="editSwitch" type="checkbox"><span class="lever"></span>ON</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert addUserError hidden bg-pink alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    Client could not be added. <b>Please contact the administrator</b>
                                </div>
                                <div class="alert addUserSuccess hidden alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    Client has been succesfully added.
                                </div>
                                <?php 
                                    include($_MPATH['ADMIN_VIEWS'].'add_client_form_view.php');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <h2>Client Details</h2>
                        <ul class="header-dropdown m-r-0">
                            <li>
                               
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="comments_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>ID</th>
                                        <th>User Name</th>
                                        <th>Comment</th>
                                        <th>Date</th>

                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <form class="commentForm" method="post" action='' enctype="multipart/form-data" >
                                    <textarea name="comment" class="form-control" placeholder="Comment"></textarea>
                                    <!-- <input type="hidden" name="quote_id" value="<?php echo $quote['id']?>"> -->
                                    <div class="row m-t-10">
                                        <div class="col-xs-12">
                                            <button class="btn btn-lg btn-block btn-success waves-effect addComment" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</section>

