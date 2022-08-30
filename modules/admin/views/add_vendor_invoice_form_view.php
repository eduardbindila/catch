<form id="userData" method="post" action='' enctype="multipart/form-data" >
    <div class="input-group">
        <h3>Country Info</h3>
        <div class="form-line">
            <input type="text" class="form-control" name="invoice_no" placeholder="Invoice Number" required>
        </div>
    </div>
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" name="invoice_no" placeholder="Invoice Number" required>
        </div>
    </div>
     <div class="input-group">
        <select class="form-control vendorTypesSelector" required name="vendor_id">
            <option value="">Select Vendor</option>
        </select>
    </div>
    <div class="form-group">
        <div class="form-line" id="bs_datepicker_container">
            <input type="text" class="form-control" placeholder="Invoicing Date">
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <button id="submitUserData" class="btn btn-lg btn-block btn-success waves-effect" type="submit">Submit Invoice  data</button>
        </div>
    </div>
</form>