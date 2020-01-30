<script type="text/javascript">
    var isDisabled = <?php echo is_numeric($userId) ? is_numeric($userId) : 'undefined' ?>;
    var userDetails = <?php echo json_encode($userQuery)?>;
    var insertResult = <?php echo $insertResult?>;

</script>

<form id="userData" method="post" action='' enctype="multipart/form-data" >
    <div class="input-group">
        <h3>Project Info</h3>
        <div class="form-line">
            <input type="text" class="form-control" name="project_name" placeholder="Project Name" required>
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="project_description" placeholder="Project Description" >
        </div>
    </div>
    <div class="alert userTypesSelectorError hidden bg-pink alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        Users could not be retrieved. <b>Please contact the administrator</b>
    </div>
    <div class="input-group">
        <select class="form-control userTypesSelector" required name="owner_id">
            <option value="">Select user</option>
        </select>
    </div>
    <div class="alert projectStatusSelectorError hidden bg-pink alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        Project status could not be retrieved. <b>Please contact the administrator</b>
    </div>
    <div class="input-group">
        <select class="form-control projectStatusSelector" required name="project_status">
            <option value="">Select project status</option>
        </select>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <button id="submitUserData" class="btn btn-lg btn-block btn-success waves-effect" type="submit">Submit client data</button>
        </div>
    </div>
</form>

<?php $LoadHTMLArtefacts->setScript($_WMPATH['ADMIN_VIEWS'].'projects.js'); ?>