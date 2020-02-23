<script type="text/javascript">
    var quoteId = <?php echo $quoteID?>;
    var quote = <?php echo json_encode($quote)?>;
</script>
`

<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Quote</h2>
		</div>    
        <div class="row">
		   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		        <div class="card">
		            <div class="header ">
		                <h2>Quote #<?php echo $quote['id']?> - <?php echo $quote['name']?>
		                    <div class="quote-info">
		                    <!-- <ul class="m-l-0 p-l-0 m-t-10 small">
		                        <?php  if($_pageName == 'project' && !isset($_SESSION['user_access']['client-grid'])) {?>
		                        <li >
		                            Assigned to: <?php echo $GetDetails->userName($quote['assignee_id'])?>
		                        </li>
		                        <li class="m-t-5">

		                            Client: <?php echo $GetDetails->clientDetails($quote['client_id'])?>
		                        </li>
		                        <?php }?>
		                    </ul>  -->
		                </div>
		                </h2>
		                <div class="clearfix">
		                    <!-- <ul class="header-dropdown m-r-0">
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
		                            <button class="btn btn-lg btn-default waves-effect offerConditions" data-toggle="modal"data-target="#offerConditions-modal">
		                            Update conditions
		                            </button>
		                        </li>
		                        <?php }?>
		                        <li>
		                            <button class="btn btn-lg btn-default waves-effect viewFiles"  data-quote="<?php echo $quote['id']?>">
		                            Files
		                            </button>
		                        </li>
		                        <?php 
		                        //var_dump($quote['']);
		                            if(!$quote['client_approved'] && !$quote['offer_rejected'] && isset($_SESSION['user_access']['client-grid'])) 
		                            {
		                        ?>
		                        <li>
		                            <button class="btn btn-lg btn-success waves-effect clientConfirm" data-quote="<?php echo $quote['id']?>">
		                            Click here to Accept Offer
		                            </button>
		                        </li>
		                        <li>
		                            <button class="btn btn-lg btn-default waves-effect clientReject" data-quote="<?php echo $quote['id']?>" >
		                            Reject Offer
		                            </button>
		                        </li>
		                        <?php
		                        }?>
		                    </ul>  -->
		                </div>
		                
		            
		            </div>
		            <div class="body">
		                <div class="row">
		                    <div class="col-lg-12">
		                        <table id="quote-<?php echo $quote['id']?>" class="quote-table table table-striped table-bordered table-hover dt-responsive responsive display">
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
		                                <th>Euro</th>
		                                <th>Discount</th>
		                                <th>Eur/pcs</th>
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
		            <!-- <div class="header bg-blue-grey">
		                <h2>Quote Status: <?php echo $GetDetails->quoteStatus($quote['quote_status'])?></h2>
		                 <?php 
		                 //var_dump($_SESSION);
		                    if($_SESSION['name'] !== "Visitor") 
		                    {
		                ?>
		                    <div class="row m-t-10">
		                        <div class="col-lg-7">
		                            <div class="status-wrapper" data-quote="<?php echo $quote['id']?>" data-afterApprove = '<?php echo $quote['afterApprove']?>'>
		                                <div class="btn-group btn-group-sm" role="group">
		                                    <button type="button" data-status="4" class="btn btn-default waves-effect">Work in progress</button>
		                                    <button type="button" data-status="7" disabled class="btn btn-default waves-effect">Admin Approval</button>
		                                    <button type="button" data-status="3" class="btn btn-default waves-effect">Solution Finalized</button>
		                                    <button type="button" data-status="1" class="btn btn-default waves-effect">Calibrating Budget</button>
		                                    <button type="button" data-status="5" class="btn btn-default waves-effect">Contracting</button>
		                                    <button type="button" data-status="2" class="btn btn-default waves-effect">Delivering</button>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-lg-5 text-right">
		                            <button class="btn btn-default waves-effect nextStep" data-afterApprove = '<?php echo $quote['afterApprove']?>' data-client="<?php echo $client_id?>" data-email="<?php echo $client_email
		                            ?>" data-quote='<?php echo $quote['id']?>' >
		                                Next status
		                            </button>
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
		                                        <button type="button" data-flag="offer_sent" class="btn btn-default waves-effect"><i class="material-icons">check_box_outline_blank</i>Offer Sent</button>
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
		            </div> -->
		        </div>
		    </div>
		</div>
	</div>
</section>
