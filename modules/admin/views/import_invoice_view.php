<h3 style="display: inline"><span class="label bg-pink"><?php echo $importStatus?></span></h3>

<div id="sagaButtons" class="btn-group btn-group-sm" role="group" data-type="<?php echo $invoiceGET['typeNo']?>" data-invoice="<?php echo $invoiceGET['invoice']?>" data-code="<?php echo $invoiceGET['code']?>" data-request="<?php echo $requestId?>" data-notification="<?php echo $notificationId?>">

    <button id="generateSagaFormat" type="button" <?php echo $generateDisabled?> class="btn btn-primary waves-effect">
    Generate Saga Format
    </button>

    <button id="sendToSaga" type="button" <?php echo $sendDisabled?> class="btn btn-success waves-effect">
    Send to Saga
    </button>

    <button id="checkRequest" type="button" <?php echo $checkDisabled?> class="btn btn-default waves-effect">
    Check Saga Request
    </button>
</div>

