<?php

$invoiceData = array(
    "invoiceDate" => "",
    "dueDate" => "",
    "exchangeRate" => "",
    "invoiceNumber" => "",

);

if(isset($_POST['invoiceNumber']))
{
    $invoiceData = array(
        "invoiceDate" => $_POST['invoiceDate'],
        "dueDate" => $_POST['dueDate'],
        "exchangeRate" => $_POST['exchangeRate'],
        "invoiceNumber" => $_POST['invoiceNumber'],
    );
}

?>

<form id="invoiceData" method="post" action='' enctype="multipart/form-data" >
    <div class="row">
        <div class="col-lg-12">
             <h3>Client Invoice Details</h3>
        </div>
    </div>
    <div class="row">
         <div class="col-lg-6">
            <div class="input-group">
                <div class="form-line">
                    <input type="text" class="form-control" name="invoice_no" placeholder="Invoice Number" value="<?php echo $invoiceData['invoiceNumber']?>" required>
                </div>
            </div>
            
            <div class="input-group">
                <div class="form-line" id="bs_datepicker_container">
                    <input type="date" class="form-control invoice-date" name="date" value="<?php echo $invoiceData['invoiceDate']?>" required placeholder="Invoicing Date">
                </div>
            </div>
            
        </div>
        <div class="col-lg-6">
            <div class="input-group">
                <div class="form-line" id="bs_datepicker_container">
                    <input type="date" class="form-control due-date" name="due_date" required placeholder="Due Date" value="<?php echo $invoiceData['dueDate']?>">
                </div>
            </div>
             <div class="input-group">
                <div class="form-line">
                    <input type="text" class="form-control" placeholder="Exchange Rate" name="exchange_rate" value="<?php echo $invoiceData['exchangeRate']?>" required>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <button  class="btn btn-lg btn-block btn-success waves-effect submitInvoiceData" type="submit">Submit Invoice  data</button>
        </div>
    </div>
</form>