<?php 
// $quoteLockedClass = $quote['locked']  ? 'hidden' : '';


$quoteLockedClass = "";
   
    $masterQuoteClass = ($quote['isMaster'] ? 'bg-green' : ''); 

    $disableNonMaster = ($quote['isMaster'] ? '' : 'disabled');   


  if(isset($quote)) {

    if(isset($quote['client_id'])) {
        $client_id = $quote['client_id'];
    }
    else {
        $client_id = 0;
    }

    if(isset($quote['client_email'])) {
        $client_email = $quote['client_email'];
    }
    else {
        $client_email = 0;
    }
?>

    <script type="text/javascript">

        var index = <?php echo json_encode($key); ?>;

        quoteList[index] = <?php echo json_encode($quote); ?>;

        var quoteId = <?php echo $quote['id']?>;

        var clientId =  "<?php echo $client_id ?>" ;

        var assigneeId = <?php echo $quote['assignee_id']?>;

        //var clientEmail = <?php echo json_encode($client_email) ?>;

        assigneeEmail['<?php echo $quote['id']?>'] = "<?php echo $quote['agent_email']?>";
        assigneeRole['<?php echo $quote['id']?>'] = "<?php echo $quote['agent_role']?>";
        assigneePhone['<?php echo $quote['id']?>'] = "<?php echo $quote['agent_phone']?>";
        assigneeName['<?php echo $quote['id']?>'] = "<?php echo $quote['agent_name']?>";

        projectName['<?php echo $quote['id']?>'] = "<?php echo $quote['project_name']?>";

        clientEmail['<?php echo $quote['id']?>'] = "<?php echo $quote['client_email']?>";
        clientName['<?php echo $quote['id']?>'] = "<?php echo $quote['client_name']?>";
        clientPoi['<?php echo $quote['id']?>'] = "<?php echo $quote['client_poi']?>";

        isClientValid['<?php echo $quote['id']?>'] = '<?php echo $GetDetails->isClientValid($client_id); ?>';

    </script>

<?php
    }
?>

<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header <?php echo $masterQuoteClass?> <?php echo $quoteLockedClass?>">
                <h2 id="linkQuote-<?php echo $quote['id']?>">
                    <a href="/quote/<?php echo $quote['id']?>" class="btn btn-default btn-lg">Quote #<?php echo $quote['id']?> - <?php echo $quote['name']?></a>
                    <?php 

                    //if(!$quote['order_stock_status'] && $_logisticsView && $quote['quote_status'] == 2) {
                        
                    ?>

                      <!-- <a href="#<?php echo $quote['id']?>" class="btn btn-warning btn-lg">Waiting for Products.</a> -->

                    <?php
                    //}

                    ?>
                  
                    <div class="quote-info">
                    <ul class="m-l-0 p-l-0 m-t-10 small">
                        <?php  if(!isset($_SESSION['user_access']['client-grid'])) {?>
                        <li >
                            Assigned to: <?php echo $GetDetails->userName($quote['assignee_id'])?>
                        </li>
                        <li class="m-t-5">

                            <span class="lastPriceClient">Client: <?php echo $GetDetails->clientDetails($quote['client_id'])?></span>
                        </li>
                        <?php }?>
                    </ul> 
                </div>
                </h2>
                <div class="clearfix">
                    <ul class="header-dropdown m-r-0">
                        <?php  if(!isset($_SESSION['user_access']['client-grid'])) {?>
                        <li>
                            <button class="btn btn-lg btn-default waves-effect editQuoteTrigger" data-toggle="modal" data-target="#edit-modal" data-quote="<?php echo $quote['id']?>">
                                Edit
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-lg btn-default waves-effect addNewItem"  data-toggle="modal"data-target="#addNew-modal" data-quote="<?php echo $quote['id']?>">
                                Add New Product
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-lg btn-default waves-effect grantMaster" data-quote="<?php echo $quote['id']?>" data-master="<?php echo $quote['isMaster']?>">
                            Grant as Master
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-lg btn-default waves-effect viewComments" data-quote="<?php echo $quote['id']?>">
                            Comments
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-lg btn-default waves-effect viewPackages"  data-index="<?php echo $key?>"
                            data-name="<?php echo  $quote['name']?>"  data-quote="<?php echo $quote['id']?>">
                            Packages
                            </button>
                        </li>
                        
                        <!--  <li>
                            <button class="btn btn-lg btn-default waves-effect offerConditions" data-toggle="modal"data-target="#offerConditions-modal">
                            Update conditions
                            </button>
                        </li> -->
                        <?php }
                        //var_dump($quote['quote_status']);

                       //if (!($_SESSION['user_type'] == 3) && ($quote['quote_status'] == 4)) {

                        // if ($quote['quote_status'] <> 4 && $quote['quote_status'] <> 7 ) {
                        if ($quote['quote_status'] <> 7 ) {

                            ?>
                       
                        <li>
                            <button class="btn btn-lg btn-default waves-effect viewFiles"  data-quote="<?php echo $quote['id']?>">
                            Files
                            </button>
                        </li>
                        <?php  
                        
                            if(!$quote['client_approved'] && !$quote['offer_rejected'] && isset($_SESSION['user_access']['client-grid'])) 
                            {
                        ?>
                        <li>
                            <button class="btn btn-lg btn-success waves-effect clientConfirm" data-quote="<?php echo $quote['id']?>">
                            Click here to Approve Offer
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-lg btn-default waves-effect clientReject" data-quote="<?php echo $quote['id']?>" >
                            Reject Offer
                            </button>
                        </li>
                        <?php

                            }
                        }?>
                        <?php  if (($_SESSION['user_type'] == 3) && ($quote['quote_status'] == 4)) {
                            ?>
                       <!--  <li>
                            <div class="">
                                    <div class="status-wrapper" data-quote="<?php echo $quote['id']?>" data-afterApprove = '<?php echo $quote['afterApprove']?>' data-selfCustomer="1">
                                        <div class="btn-group btn-group-lg" role="group">
                                            <button type="button" data-status="7" class="btn btn-default waves-effect">Send for Approval</button>
                                        </div>
                                    </div>
                                </div>
                        </li> -->
                        <?php }?>
                    </ul> 
                </div>
                
            
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-lg-12">
                        <table id="quote-<?php echo $quote['id']?>" class="results-table table table-striped table-bordered table-hover dt-responsive responsive display">
                            <thead>
                                <th></th>
                                <th>Index</th>
                                <th>Image</th>
                                <th>Link Datasheet</th>
                                <th>Product ID</th>
                                <th>Customer Description</th>
                                <th>Destination</th>
                                <th>Product Name</th>
                                <th>Total power consumption (W)</th>
                                <th>Colour temperature (K)</th>
                                <th>Fixture luminous flux (lm)</th>
                                <th>Aq Price</th>
                                <th>Min Price</th>
                                <th>List Price</th>
                                <th>%Discount</th>
                                <th>Price/pcs</th>
                                <th>Profit</th>
                                <th>Profit %</th>
                                <th>QTY</th>
                                <th>Final Price</th>
                                <th>Reserved Stock</th>
                                <th>Invoiced Quantity</th>
                                <th>Saga Quantity</th>
                                <th>Order Number</th>
                                <th>Order Quantity</th>
                                <th>Order Date</th>
                                <th>Promise Date</th>
                                <th></th>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="10" rowspan="2"></th>
                                    <th  rowspan="2" style="text-align:right; vertical-align: middle; padding-right: 10px;">Total/Quote:</th>
                                    
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <div class="form-group">
                                            <div class="form-line">
                                                 <input type="number"min=0 class="form-control extraDiscount" name="extradiscount" placeholder="" data-quote="<?php echo $quote['id'] ?>" value ="<?php echo $quote['extra_discount'] ?>"/></th>
                                            </div>
                                        </div>
                                    <th>N/A</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>

                                </tr>
                                <tr>
                                    
                                    <th >Aq</th>
                                    <th>Min Price</th>
                                    <th>Euro</th>
                                    <th>Extra Discount</th>
                                    <th>E/pcs</th>
                                    <th>Profit</th>
                                    <th>Profit %</th>
                                    <th>QTY</th>
                                    <th>Final Price</th>
                                    
                                </tr>
                            </tfoot>
                        </table>
                        <?php 
                            if(isset($_SESSION['user_access']['sales-grid'])) 
                            {
                        ?>
                        <div class="alert bg-red updateError hidden">
                            Quote has not been updated! Please contact the administrator.
                        </div>
                    <?php }?>
                        <div class="alert bg-orange noClientError hidden">
                            Please add client to Quote!
                        </div>
                    </div>
                </div>
            </div>
            <div class="header bg-blue-grey">
                <h2>Quote Status: <?php echo $GetDetails->quoteStatus($quote['quote_status'])?></h2>
                <ul class="header-dropdown m-r-0">
                            <li>
                                <button class="btn btn-default waves-effect statusHistory" data-quote='<?php echo $quote['id']?>' data-toggle="modal" data-target="#statusHistory-modal" >
                                View Status History
                            </button>
                            </li>
                            <li>
                                <button class="btn btn-default waves-effect nextStep" data-afterApprove = '<?php echo $quote['afterApprove']?>' data-client="<?php echo $client_id?>" data-email="<?php echo $client_email
                            ?>" data-index="<?php echo $key?>" data-quote='<?php echo $quote['id']?>' >
                                Next status
                            </button>
                            </li>
                        </ul>


                            

                 <?php 
                 //var_dump($_SESSION);
                    if($_SESSION['name'] !== "Visitor" && $_SESSION['user_type'] <> 3) 
                    {
                ?>
                    <div class="status-date-wrapper">Status Date: <span class="status-date"></span> 
                        <!-- | Due Date: <span class="due-date"></span> <button type="button" data-status-id="" class="btn btn-default btn-xs waves-effect">Change due date</button> -->
                    </div>
                    <div class="row m-t-10">
                        <div class="col-lg-12">
                            <div class="status-wrapper" data-index="<?php echo $key ?>" data-quote="<?php echo $quote['id']?>" data-afterApprove = '<?php echo $quote['afterApprove']?>'>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" data-status="4" class="btn btn-default waves-effect">Work in progress</button>
                                    <button type="button" data-status="7" disabled class="btn btn-default waves-effect">Admin Approval</button>
                                    <button type="button" data-status="3" class="btn btn-default waves-effect" data-afterApprove = '<?php echo $quote['afterApprove']?>' data-client="<?php echo $client_id?>" data-email="<?php echo $client_email
                            ?>" data-quote='<?php echo $quote['id']?>'>Solution Finalized</button>
                                    <button type="button" data-status="1" class="btn btn-default waves-effect">Calibrating Budget</button>
                                    <button type="button" data-status="5" class="btn btn-default waves-effect">Order Confirmed</button>
                                    <button type="button" data-status="2" class="btn btn-default waves-effect" <?php echo $disableNonMaster ?>>Processing Order</button>
                                    <button type="button" data-status="10" class="btn btn-default waves-effect" <?php echo $disableNonMaster ?>>Supplier Order Sent</button>
                                    <button type="button" data-status="11" class="btn btn-default waves-effect" <?php echo $disableNonMaster ?>>Supplier Order Arrived</button>
                                    <button type="button" data-status="13" class="btn btn-default waves-effect" <?php echo $disableNonMaster ?>>Order Invoiced</button>  
                                    <button type="button" data-status="12" class="btn btn-default waves-effect" <?php echo $disableNonMaster ?>>Order Completed</button>
                                                                      <button type="button" data-status="8" class="btn btn-danger waves-effect" >Lost Quote</button>
                                    <button type="button" data-status="9" class="btn btn-danger waves-effect">Quote Canceled</button>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <?php if( $quote['quote_status'] != 0 ) { ?>

                        <div class="m-t-20">
                            <h2 >Quote Flags</h2>
                            <small >Press on the button to activate the flag.</h2>
                        </div>
                        
                        <div class="row m-t-10">
                            <div class="col-lg-9">
                                <div class="flags-wrapper" data-quote="<?php echo $quote['id']?>" data-afterApprove = '<?php echo $quote['afterApprove']?>'>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" data-flag="afterApprove" class="btn btn-default waves-effect"><i class="material-icons">check_box_outline_blank</i>Admin Approved</button>
                                        <button type="button" data-flag="offer_sent" class="btn btn-default waves-effect" data-afterApprove = '<?php echo $quote['afterApprove']?>' data-client="<?php echo $client_id?>" data-email="<?php echo $client_email
                            ?>" data-quote='<?php echo $quote['id']?>'><i class="material-icons" >check_box_outline_blank</i>Offer Sent</button>
                                        <button type="button" data-flag="offer_opened" class="btn btn-default waves-effect" disabled><i class="material-icons">check_box_outline_blank</i>Offer Opened</button>
                                        <button type="button" data-flag="client_approved" class="btn btn-default waves-effect"><i class="material-icons">check_box_outline_blank</i>Offer Approved</button>
                                        <button type="button" data-flag="offer_rejected" class="btn btn-default waves-effect"><i class="material-icons">check_box_outline_blank</i>Offer Rejected</button>
                                        <button type="button" data-flag="contract_sent" class="btn btn-default waves-effect" disabled><i class="material-icons">check_box_outline_blank</i>Contract Sent</button>
                                        <button type="button" data-flag="invoice_sent" class="btn btn-default waves-effect" disabled><i class="material-icons">check_box_outline_blank</i>Invoice Sent</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 text-center">
                                <?php if($quote['rejection_info']) { ?>

                                 <div class="alert bg-red">
                                    <b>Rejection Reason:</b> <?php echo $quote['rejection_info']; ?>
                                </div>

                                <?php } ?>
                            </div>
                        </div> 
                    <?php }?>                    
                <?php }?>
            </div>
        </div>
    </div>
</div>
<!-- Large Size -->
        <div class="modal fade" id="reject-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Rejection Reason</span></h4>
                    </div>
                    <div class="modal-body">
                        <form id="rejectionForm" method="post" action='' enctype="multipart/form-data" >
                            <div class="input-group">
                                  <select class="form-control rejectionReason" required name="rejected_reason">
                                    <option value="">Select rejection Reason</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button id="sendRejection" class="btn btn-lg btn-block btn-success waves-effect" type="submit">Send Rejection</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Large Size -->
        <div class="modal fade viewComments-modal" tabindex="-1" role="dialog" data-quote="<?php echo $quote['id']?>">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >
                            Quote #<span class="quoteNumberEdit"></span> Comments 
                            <span class="packageText hidden" data-quote="<?php echo $quote['id']?>">- for package</span>
                            <span data-quote="<?php echo $quote['id']?>" class="packageId"></span>
                            <span class="packageText hidden" data-quote="<?php echo $quote['id']?>"> in status </span>
                            <span data-quote="<?php echo $quote['id']?>" class="packageStatus"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="comments_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>ID</th>
                                        <th>User Name</th>
                                        <th>Quote Status</th>
                                        <th>Comment</th>
                                        <th>Package ID</th>
                                        <th>Package Status ID</th>
                                        <th>Date</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                               <form class="commentForm" method="post" action='' enctype="multipart/form-data" >
                                    <textarea name="comment" class="form-control" placeholder="Comment"></textarea>
                                    <input type="hidden" name="quote_id" value="<?php echo $quote['id']?>">
                                    <div class="row m-t-10">
                                        <div class="col-xs-12">
                                            <button class="btn btn-lg btn-block btn-success waves-effect addComment" type="submit" data-quote="<?php echo $quote['id']?>">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Large Size -->
        <div class="modal fade viewFiles-modal" tabindex="-1" role="dialog" data-quote="<?php echo $quote['id']?>">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Quote #<span class="quoteNumberEdit"></span>  Files</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <?php  if( !isset($_SESSION['user_access']['client-grid'])) {?>
                            <div class="col-lg-12">
                                <div class="dropzone dropzone-doc dz-clickable" data-quote="<?php echo $quote['id']; ?>">
                                    <div class="dz-message">
                                        <div class="drag-icon-cph">
                                            <i class="material-icons">touch_app</i>
                                        </div>
                                        <h3>Drop files here or click to upload.</h3>

                                    </div>
                                    <form class="quoteFilesForm" method="post" action='' enctype="multipart/form-data" >
                                        <input type="hidden" class="file-name" name="file_name" value="">
                                        <input type="hidden" class="quote-id" name="quote_id" value="">
                                        <div class="input-group">
                                            <select class="form-control" required name="file_type">
                                                <option value="">Select File Type*</option>
                                                <option value="1">Invoice</option>
                                                <option value="2">Delivery Invoice</option>
                                                <option value="3">Order Confirmation</option>
                                                <option value="4">Other</option>
                                            </select>
                                        </div>
                                        <div class="input-group">
                                            <label>Must be sent to client?*:</label>
                                            <input type="radio" name="send_to_client" id="<?php echo $quote['id'] ?>-send-1" value="1" required="">
                                            <label for="<?php echo $quote['id'] ?>-send-1">Yes</label>
                                            <input type="radio" name="send_to_client"  id="<?php echo $quote['id'] ?>-send-0" value="0" required="">
                                            <label for="<?php echo $quote['id'] ?>-send-0">No</label>
                                        </div>
                                        <button class="btn btn-lg btn-block btn-success waves-effect filesToDB hidden" type="submit">Click to save files on Quote</button>
                                    </form>
                                </div>
                            </div>
                        <?php }?>
                            <div class="col-lg-12 m-t-40">
                                <table class="files_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                         <th></th>
                                        <th>File</th>
                                        <th>File Type</th>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Must be sent to Client</th>
                                        <th>Was sent to Client</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Large Size -->
        <div class="modal fade viewPackages-modal" tabindex="-1" role="dialog" data-quote="<?php echo $quote['id']?>">
            <div class="modal-dialog modal-xxl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Quote #<span class="quoteNumberEdit"></span>  Packages</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert bg-red updatePackageItemError hidden">
                                    Package item has not been updated! Please contact the administrator.
                                </div>
                                <div class="packagesContainer"></div>
                            </div>
                        </div>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>

            </div>
        </div>


         <!-- Large Size -->
        <div class="modal fade" id="editItem-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Quote #<?php echo $quote['id']?> - Edit Item #<span id="quoteItemEdit"></span></h4>
                    </div>
                    <div class="modal-body">
                        <form id="editQuoteItemForm" method="post" action='' data-quote="<?php echo $quote['id']?>" enctype="multipart/form-data" >
                            <div class="input-group">
                                <input type="text" class="form-control" name="index" placeholder="Index" required>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" name="description" placeholder="Customer Description"  maxlength="100" required>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" name="destination" placeholder="Product Destination"  maxlength="100" required>
                            </div>
                            <div class="input-group">
                                <button id="updateQuoteButton" class="btn btn-lg btn-block btn-success waves-effect" type="submit" >Update Quote</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="statusHistory-modal" tabindex="-1" role="dialog" data-quote="<?php echo $quote['id']?>">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Quote #<span class="quoteNumberStatus"> - Status History<span id="statusHistoryFormHeaer"></span></h4>
                    </div>
                    <div class="modal-body">

                        <table class="status_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>ID</th>
                                        <th>User </th>
                                        <th>Quote Status</th>
                                        <th>Date</th>
                                        <th>Due Date</th>
                                    </thead>
                                </table>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>

        