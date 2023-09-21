<section class="content projectPage">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Control Panel</h2>
        </div>
        <div class="row">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Options List</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert addUserError hidden bg-pink alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    Option could not be updated. <b>Please contact the administrator</b>
                                </div>
                                <div class="alert addUserSuccess hidden alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    Option has been succesfully updated.
                                </div>
                               <table class="projects_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Key</th>
                                        <th>Value</th>
                                        <th>Action</th>
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
        <div class="modal fade" id="editOption-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Option</h4>
                    </div>
                    <div class="modal-body">
                        <div class="editWrapper">
                            <form id="optionData" method="post" action='' enctype="multipart/form-data" >
                                    <div class="input-group">
                                        <h3>Options Details</h3>
                                        
                                    </div>
                                    <div class="input-group">
                                         <div class="form-line hidden">
                                            <input id="optionId" type="text" class="form-control" name="id" disabled placeholder="
                                            Id" required>
                                        </div>
                                        <div class="form-line">
                                            <input id="optionName" type="text" class="form-control" name="name" placeholder="Name" required>
                                        </div>
                                        <div class="form-line hidden">
                                            <input id="optionKey" type="text" class="form-control" disabled name="key" placeholder="Key" required>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="form-line">
                                            <input id="optionValue" type="text" class="form-control" name="value" placeholder="Value" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <button id="submitOptionData" class="btn btn-lg btn-block btn-success waves-effect" type="submit">Submit options data</button>
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