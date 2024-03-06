<script type="text/javascript">
    
  


</script>

<section class="content projectPage">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Client Invoice</h2>
        </div>
        <div class="row">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Client Invoice Details</h2>
                        <ul class="header-dropdown m-r-0">
                            <!-- <li>
                                <div class="switch">
                                    Edit: <label>OFF<input name="edit" class="editSwitch" type="checkbox"><span class="lever"></span>ON</label>
                                </div>
                            </li> -->
                             <li>
                                <?php include($_MPATH['ADMIN_CONTROLLERS'].'import_invoice_controller.php');?>
                            </li>
                           
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert addUserError hidden bg-pink alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <b>Please contact the administrator</b>
                                </div>
                                <div class="alert addUserSuccess hidden alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    Client has been succesfully added.
                                </div>
                                <?php 
                                    include($_MPATH['ADMIN_VIEWS'].'add_client_invoice_form_view.php');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>