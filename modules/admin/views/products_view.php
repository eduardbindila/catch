<section class="content projectPage">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Products</h2>
        </div>
        <div class="row">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Products Details</h2>
                        <!-- <ul class="header-dropdown m-r-0">
                            <li>
                                <button class="btn btn-success waves-effect" data-toggle="modal"data-target="#addNew-modal">
                                    Add Products
                                </button>
                            </li>
                        </ul> -->
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert addUserError hidden bg-pink alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    Product could not be added. <b>Please contact the administrator</b>
                                </div>
                                <div class="alert addUserSuccess hidden alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    Product has been succesfully added.
                                </div>
                               <table class="products_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>Image</th>
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>Product Manufacturer</th>
                                        <th>Temp</th>
                                        <th>Initial Price</th>

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
                        <h4 class="modal-title">Add new Product</span></h4>
                    </div>
                    <div class="modal-body">
                        <?php 
                            include($_MPATH['ADMIN_VIEWS'].'add_designer_form_view.php');
                         ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
</section>