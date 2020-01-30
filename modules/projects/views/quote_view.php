<?php 
// $quoteLockedClass = $quote['locked']  ? 'hidden' : '';

$quoteLockedClass = "";

if($_pageName == 'project')
    $masterQuoteClass = ($quote['id'] == $projectQuery['master_quote'] ? 'bg-green' : '');
else 
    $masterQuoteClass = '';

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

        var clientId =  <?php echo $client_id ?> ;

        var assigneeId = <?php echo $quote['assignee_id']?>;

        var clientEmail = <?php echo json_encode($client_email) ?>;

        assigneeEmail['<?php echo $quote['id']?>'] = "<?php echo $quote['agent_email']?>";
        assigneeRole['<?php echo $quote['id']?>'] = "<?php echo $quote['agent_role']?>";
        assigneePhone['<?php echo $quote['id']?>'] = "<?php echo $quote['agent_phone']?>";
        assigneeName['<?php echo $quote['id']?>'] = "<?php echo $quote['agent_name']?>";

        projectName['<?php echo $quote['id']?>'] = "<?php echo $quote['project_name']?>";

        clientEmail['<?php echo $quote['id']?>'] = "<?php echo $quote['client_email']?>";
        clientName['<?php echo $quote['id']?>'] = "<?php echo $quote['client_name']?>";
        clientPoi['<?php echo $quote['id']?>'] = "<?php echo $quote['client_poi']?>";

    </script>

<?php
    }
?>

<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header <?php echo $masterQuoteClass?> <?php echo $quoteLockedClass?>">
                <h2>Quote #<?php echo $quote['id']?> - <?php echo $quote['name']?>
                    <div class="quote-info">
                    <ul class="m-l-0 p-l-0 m-t-10 small">
                        <?php  if($_pageName == 'project' && !isset($_SESSION['user_access']['client-grid'])) {?>
                        <li >
                            Assigned to: <?php echo $GetDetails->userName($quote['assignee_id'])?>
                        </li>
                        <li class="m-t-5">

                            Client: <?php echo $GetDetails->clientDetails($quote['client_id'])?>
                        </li>
                        <?php }?>
                    </ul> 
                </div>
                </h2>
                <div class="clearfix">
                    <ul class="header-dropdown m-r-0">
                        <?php  if($_pageName == 'project' && !isset($_SESSION['user_access']['client-grid'])) {?>
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
                            <button class="btn btn-lg btn-default waves-effect grantMaster" data-quote="<?php echo $quote['id']?>">
                            Grant as Master
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-lg btn-default waves-effect viewComments" data-toggle="modal"data-target="#viewComments-modal" data-quote="<?php echo $quote['id']?>">
                            Comments
                            </button>
                        </li>
                        <?php }?>

                        <?php 
                            if(!$quote['client_approved']) 
                            {
                        ?>
                        <li>
                            <button class="btn btn-lg btn-success waves-effect clientConfirm" data-quote="<?php echo $quote['id']?>">
                            Client Confirm & Send To Sales
                            </button>
                        </li>
                        <?php } else { ?>
                        <li>
                            <button class="btn btn-lg btn-success waves-effect clientConfirm" data-quote="<?php echo $quote['id']?>" disabled>
                            Client has Confirmed quote
                            </button>
                        </li>
                        <?php
                        }?>
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
                                <th>Acquisition Price</th>
                                <th>Min Price</th>
                                <th>List Price</th>
                                <th>Discount</th>
                                <th>Unit Price</th>
                                <th>Profit</th>
                                <th>Profit %</th>
                                <th>QTY</th>
                                <th>Final Price</th>
                                <th></th>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="10" rowspan="2"></th>
                                    <th  rowspan="2" style="text-align:right; vertical-align: middle; padding-right: 10px;">Total/Quote:</th>
                                    
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>N/A</th>
                                    <th>N/A</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>

                                </tr>
                                <tr>
                                    
                                    <th >Acquisition Price</th>
                                    <th>Min Price</th>
                                    <th>List Price</th>
                                    <th>Discount</th>
                                    <th>Unit Price</th>
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
                <h2>Quote Status: <?php echo $GetDetails->quoteStatus($quote['quote_status'])?>
                    <div class="status-wrapper m-t-10" data-quote="<?php echo $quote['id']?>" data-afterApprove = '<?php echo $quote['afterApprove']?>'>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" data-status="4" class="btn btn-default waves-effect">Work in progress</button>
                            <button type="button" data-status="7" disabled class="btn btn-default waves-effect">Admin Approval</button>
                            <button type="button" data-status="3" disabled class="btn btn-default waves-effect">Sent to Client</button>
                            <button type="button" data-status="1" class="btn btn-default waves-effect">Calibrating Budget</button>
                            <button type="button" data-status="5" class="btn btn-default waves-effect">Contracting</button>
                            <button type="button" data-status="2" class="btn btn-default waves-effect">Delivering</button>
                        </div>
                    </div>
                </h2>
                <?php 
                    if(isset($_SESSION['user_access']['sales-grid'])) 
                    {
                ?>
                <ul class="header-dropdown m-r-0">
                    <li>
                        <button class="btn btn-lg btn-default waves-effect nextStep" data-afterApprove = '<?php echo $quote['afterApprove']?>' data-client="<?php echo $client_id?>" data-email="<?php echo $client_email
                        ?>" data-quote='<?php echo $quote['id']?>' >
                            Next Step
                        </button>
                    </li>
                    
                </ul>
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
                                  <select class="form-control rejectionReason" required name="rejectionReason">
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
        <div class="modal fade" id="viewComments-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Quote #<?php echo $quote['id']?> Comments</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="comments_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>ID</th>
                                        <th>User Name</th>
                                        <th>Comment</th>
                                        <th>Quote Status</th>
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
                                <input type="text" class="form-control" name="description" placeholder="Customer Description" required>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" name="destination" placeholder="Product Destination" required>
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