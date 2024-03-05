<form id="userData" method="post" action='' enctype="multipart/form-data" >
    <div class="input-group">
        <h3>Client Info</h3>
        <div class="form-line">
            <input type="text" class="form-control" name="name" placeholder="Name*" required>
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="poi" required placeholder="Person of Contact*" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="email" class="form-control" name="email" required placeholder="Email address*" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="phone" required placeholder="Phone*" >
        </div>
    </div>
    <div class="alert userTypesSelectorError hidden bg-pink alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        Users could not be retrieved. <b>Please contact the administrator</b>
    </div>
    <div class="input-group">
        <select class="form-control userTypesSelector" required name="user">
            <option value="">Select Sales Agent*</option>
        </select>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="fiscal_code" required placeholder="Fiscal Code*" >
        </div>
    </div>
     <div class="alert countryTypesSelectorError hidden bg-pink alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        Countries could not be retrieved. <b>Please contact the administrator</b>
    </div>
    <div class="input-group">
        <select class="form-control countryTypesSelector" required name="country">
            <option value="">Select Country*</option>
        </select>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="state" required placeholder="State*" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="address" required placeholder="Address*" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="bank_account" required placeholder="Bank accout*" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="bank" required placeholder="Bank*" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="registry" required placeholder="Registry Number*" >
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="number" class="form-control" min="0" max="72" required name="discount" placeholder="Discount*" >
        </div>
    </div>
     <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control"  name="saga_code" placeholder="Saga Code" >
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <button id="submitUserData" class="btn btn-lg btn-block btn-success waves-effect" type="submit">Submit client data</button>
        </div>
    </div>
</form>