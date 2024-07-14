 <div class="alert invoiceImported hidden alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    Invoice Imported Succesfully
</div>
<div class="card">
    <div class="header">
        <h2>Invoice Import </h2>
        <ul class="header-dropdown m-r-0">
            <li>
                Saga Code: <span class="clientCode label label-success"><?php echo $invoiceGET['code']?>   
            </li>
            <?php

            if(!isset($statusQuery[0]['status_id']))
            {
            ?>
            <li>
                <span id="sagaButtons" class="btn-group btn-group-sm" role="group" data-type="<?php echo $invoiceGET['typeNo']?>" data-invoice="<?php echo $invoiceGET['invoice']?>" data-code="<?php echo $invoiceGET['code']?>" data-request="<?php echo $requestId?>" data-process="<?php echo $processId?>">

                    <button id="verifySagaInvoiceDetails" type="button" class="btn btn-primary waves-effect">
                    Verify Saga Invoice Details
                    </button>

                    <button id="exportInvoiceToSaga" type="button" class="btn hidden btn-primary waves-effect" data-type="<?php echo $invoiceGET['typeNo']?>" data-invoice="<?php echo $invoiceGET['invoice']?>" data-code="<?php echo $invoiceGET['code']?>" data-request="<?php echo $requestId?>" data-process="<?php echo $processId?>">
                    All the details exist in Saga! Click here to Send the invoice to Saga
                    </button>

                </span>
            </li>
            <?php 
            } else if($statusQuery[0]['status_id'] == '2') {
                ?>
                <li>
                    </span> Import Status: <span class="clientCode label label-default"><?php echo $statusQuery[0]['name']?></span>
                </li>

                <?php
            }
            ?>
        </ul>
    </div>
    <div class="body">
        
        <div class="row">
            <div class="col-lg-12">
        <div class="preloader hidden pl-size-l verify_preloader">
            <div class="spinner-layer pl-red-grey">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <div class="verifyWrapper hidden">
            <h3 class="verificationH3">Verification Results</h3>
            <table class="verifyResult table table-striped table-bordered table-hover dt-responsive display">
                <thead>
                    <th>Type</th>
                    <th>Code</th>
                    <th>Status</th>
                    <th>Action</th>
            </table>
        </div>
        <div class="sendWrapper hidden">
            <h3 class="">Send Results</h3>
            <table class="sendResult table table-striped table-bordered table-hover dt-responsive display">
                <thead>
                    <th>Code</th>
                    <th>Status</th>
                    <th>Error</th>
            </table>
        </div>

<?php
?>
            </div>
        </div>
    </div>
</div>
