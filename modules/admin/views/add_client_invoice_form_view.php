<?php

// $invoiceData = array(
//     "invoiceDate" => "",
//     "dueDate" => "",
//     "exchangeRate" => "",
//     "invoiceNumber" => "",
//     "packageId" => "",
//     "otherDetails" => ""

// );

//print_R($_POST['isStorno']);

//print_r($_POST);



if(isset($_POST['invoiceNumber']))
{


$invoiceDate = $_POST['invoiceDate'];
$dueDate = $_POST['dueDate'];

$clientExchangeRate = '';

// Accesăm invoice_due_days din sub-array-ul clientDetails
$invoiceDueDays = isset($_POST['clientDetails']['invoice_due_days']) ? intval($_POST['clientDetails']['invoice_due_days']) : 0;

// Setăm data curentă dacă invoiceDate este gol
if (empty($invoiceDate)) {
    $invoiceDate = date('Y-m-d'); // Formatul standard SQL (YYYY-MM-DD)
    // Calculăm dueDate pe baza lui invoiceDate și a invoice_due_days
$dueDate = date('Y-m-d', strtotime($invoiceDate . ' + ' . $invoiceDueDays . ' days'));
}

if($_POST['packageStatus'] == 4 && (empty($_POST['exchange_rate_deviation']) || floatval($_POST['exchange_rate_deviation']) == 0)) {
    $exchangeRateDeviation = 0;
} else {
    if(empty($_POST['exchange_rate_deviation']) || floatval($_POST['exchange_rate_deviation']) == 0  && !empty($_POST['clientDetails']['exchange_rate_deviation'])) {
        $exchangeRateDeviation = $_POST['clientDetails']['exchange_rate_deviation'];
    } else 
    {
        if(!empty($_POST['exchange_rate_deviation']) && floatval($_POST['exchange_rate_deviation']) != 0) {
            $exchangeRateDeviation = $_POST['exchange_rate_deviation'];
        }
        else {
            $exchangeRateDeviation = 0;   
        }
    }
}


 $clientExchangeRate = round($_POST['exchangeRate'] * (1 + ($exchangeRateDeviation / 100)), 4);


    $invoiceData = array(
        "invoiceDate" => $invoiceDate,
        "dueDate" => $dueDate,
        "exchangeRate" => $_POST['exchangeRate'],
        "invoiceNumber" => $_POST['invoiceNumber'],
        "packageId" => $_POST['packageId'],
        "otherDetails" =>  $_POST['other_details'],
        "clientExchangeRate" => $clientExchangeRate,
        "exchangeRateDeviation" => $exchangeRateDeviation
    );
}


//print_r($invoiceData);

?>

<script type="text/javascript">
    

$('textarea, input:not([type="radio"]):not([type="checkbox"]):not([type="hidden"]):not([type="button"]):not([type="submit"])').before(function(){


        var placeholder = $(this).attr('placeholder');
        
        if(placeholder !== undefined) {
           $(this).removeAttr('placeholder'); 
            return '<label>'+placeholder+'</label>';
        } else {
            return;
        }

    })


</script>

<form id="invoiceData" method="post" class="<?php echo 'form-package-'.$_POST['packageId']?>" data-package-id="<?php echo $_POST['packageId']?>" action='' enctype="multipart/form-data" >
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
                <div class="form-line">
                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control invoice-date" data-isStorno="<?php echo $_POST['isStorno']?>" name="date" value="<?php echo $invoiceData['invoiceDate']?>" required placeholder="Invoicing Date">
                </div>
            </div>
            <div class="input-group">
                <div class="form-line">
                    <textarea name="other_details" class="form-control" placeholder="Aditional Details"><?php echo $invoiceData['otherDetails']?></textarea>
                </div>
            </div>
            
        </div>
        <div class="col-lg-6">
            <div class="input-group">
                <div class="form-line">
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
                    <input type="text" class="form-control" placeholder="BNR Exchange Rate" name="exchange_rate" value="<?php echo $invoiceData['exchangeRate']?>" >
                </div>
            </div>
            <?php
                if($clientExchangeRate) {

            ?>
            <div class="input-group">
                <div class="form-line">
                    <input type="hidden" class="form-control" placeholder="Exchange Rate Deviation" name="exchange_rate_deviation" value="<?php echo $invoiceData['exchangeRateDeviation']?>" >

                    <input type="text" class="form-control" placeholder="Client Exchange Rate" name="client_exchange_rate" disabled value="<?php echo $clientExchangeRate?>" >
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    if($_POST['packageStatus'] <> 4) {
    ?>
    <div class="row">
        <div class="col-xs-12">
            <button  class="btn btn-lg btn-block btn-success waves-effect submitInvoiceData" type="submit">Submit Invoice  data</button>
        </div>
    </div>
    <?php
    }
    ?>
</form>