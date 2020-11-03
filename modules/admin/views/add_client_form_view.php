<form id="userData" method="post" action='' enctype="multipart/form-data" >
    <div class="input-group">
        <h3>Client Info</h3>
        <div class="form-line">
            <input type="text" class="form-control" name="name" placeholder="Name" required>
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="email" class="form-control" name="email" placeholder="Email address" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="phone" placeholder="Phone" >
        </div>
    </div>
    <div class="alert userTypesSelectorError hidden bg-pink alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        Users could not be retrieved. <b>Please contact the administrator</b>
    </div>
    <div class="input-group">
        <select class="form-control userTypesSelector" required name="user">
            <option value="">Select Sales Agent</option>
        </select>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="fiscal_code" placeholder="Fiscal Code" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="country" maxlength="3" placeholder="Country Code" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="state" placeholder="State" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="address" placeholder="Address" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="bank_account" placeholder="Bank accout" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="bank" placeholder="Bank" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="registry" placeholder="Registry Number" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="number" class="form-control" min="0" max="60" name="discount" placeholder="Discount" >
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <button id="submitUserData" class="btn btn-lg btn-block btn-success waves-effect" type="submit">Submit client data</button>
        </div>
    </div>
</form>