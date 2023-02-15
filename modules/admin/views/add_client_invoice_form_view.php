<?php

$invoiceData = array(
    "invoiceDate" => "",
    "dueDate" => "",
    "exchangeRate" => "",
    "invoiceNumber" => "",
    "packageId" => "",
    "otherDetails" => ""

);

//print_R($_POST['isStorno']);

if(isset($_POST['invoiceNumber']))
{
    $invoiceData = array(
        "invoiceDate" => $_POST['invoiceDate'],
        "dueDate" => $_POST['dueDate'],
        "exchangeRate" => $_POST['exchangeRate'],
        "invoiceNumber" => $_POST['invoiceNumber'],
        "packageId" => $_POST['packageId'],
        "otherDetails" =>  $_POST['other_details']
    );


    if($invoiceData['exchangeRate'] == 1) {
        $exchange_rate_class = "hidden";
    }
    else {
        $exchange_rate_class = '';
    }
}

?>

<form id="invoiceData" method="post" class="<?php echo 'form-package-'.$_POST['packageId']?>" action='' enctype="multipart/form-data" >
    <div class="row">
        <div class="col-lg-12">
             <h3>Client Invoice Details</h3>
        </div>
    </div>
    <div class="row">
         <div class="col-lg-6">
            <div class="input-group">
                <div class="form-line">
                    <input type="text" class="form-control" name="invoice_no" placeholder="Invoice Number" value="<?php echo $invoiceData['invoiceNumber']?>">
                    <input type="hidden" class="form-control" name="package_id" value="<?php echo $invoiceData['packageId']?>">
                </div>
            </div>
            
            <div class="input-group">
                <div class="form-line" id="bs_datepicker_container">
                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control invoice-date" data-isStorno="<?php echo $_POST['isStorno']?>" name="date" value="<?php echo $invoiceData['invoiceDate']?>" required placeholder="Invoicing Date">
                </div>
            </div>
            
        </div>
        <div class="col-lg-6">
            <div class="input-group">
                <div class="form-line" id="bs_datepicker_container">
                    <input type="text" onfocus="(this.type='date')"  onblur="(this.type='text')" class="form-control due-date" name="due_date" required placeholder="Due Date" value="<?php echo $invoiceData['dueDate']?>">
                </div>
            </div>
             <div class="input-group">
                <div class="form-line">
                    <div class="preloader pl-size-vxs hidden exchange_rate_preloader">
                        <div class="spinner-layer pl-red-grey">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>
                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                    <input type="text" class="form-control <?php echo $exchange_rate_class?>" placeholder="Exchange Rate" name="exchange_rate" value="<?php echo $invoiceData['exchangeRate']?>" >
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="input-group">
                <div class="form-line">
                    <textarea name="other_details" class="form-control" placeholder="Aditional Details"><?php echo $invoiceData['otherDetails']?></textarea>
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