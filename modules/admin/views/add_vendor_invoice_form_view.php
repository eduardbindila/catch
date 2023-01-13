<form id="invoiceData" method="post" action='' enctype="multipart/form-data" >
    <div class="row">
        <div class="col-lg-12">
             <h3>Vendor Invoice Details</h3>
        </div>
    </div>
     <div class="row">
         <div class="col-lg-6">
            <div class="input-group">
                <div class="form-line">
                    <input type="text" class="form-control" name="invoice_no" placeholder="Invoice Number" required>
                </div>
            </div>
            
            <div class="input-group">
                <div class="form-line" id="bs_datepicker_container">
                    <input type="text" class="form-control invoice-date" name="date" required placeholder="Invoicing Date">
                </div>
            </div>
            
        </div>
        <div class="col-lg-6">
             <div class="input-group">
                <select class="form-control vendorTypesSelector" required name="vendor">
                    <option value="" selected>Select Vendor</option>
                </select>
            </div>
            <div class="input-group">
                <div class="form-line" id="bs_datepicker_container">
                    <input type="text" class="form-control due-date" name="due_date" required placeholder="Due Date">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
         <div class="col-lg-6">
            <div class="row">
                 <div class="col-lg-4">
                     <div class="input-group">
                        <div class="form-line">
                            <label>Invoice Currency</label>
                            <br/>
                            <input type="radio" name="currency" id="currency_euro" value="Euro" required>
                            <label for="currency_euro">Euro</label>
                            <input type="radio" name="currency"  id="currency_ron" value="Ron" required>
                            <label for="currency_ron">Ron</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                     <div class="input-group">
                        <div class="form-line">
                            <input type="text" class="form-control" placeholder="Exchange Rate" value="<?php echo $exchange_rate?>" name="exchange_rate" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-6">
                     <div class="input-group">
                        <div class="form-line">
                            <input type="text" class="form-control" name="vat_value" placeholder="VAT Value">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                     <div class="input-group">
                        <div class="form-line">
                            <input type="text" class="form-control" name="invoice_value" placeholder="Invoice Value (no VAT)" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <button  class="btn btn-lg btn-block btn-success waves-effect" type="submit">Submit Invoice  data</button>
        </div>
    </div>
</form>