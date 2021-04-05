
<?php if(!isset($quote)){
    $quote['project_id'] = $projectID;
}?>

<script type="text/javascript">
    var quoteList = [];

    var assigneeEmail = [];

    var assigneeEmail = []; 
    var assigneeRole = []; 
    var assigneePhone = []; 
     var assigneeName  = []; 

    var projectName = []; 

    var clientEmail = []; 
    var clientName = []; 
    var clientPoi = []; 
</script>

<section class="content projectPage">
	<div class="container-fluid">
		<div class="block-header">
			<h2 id="project" data-project="<?php echo $quote['project_id'] ?>"><a href="/project/<?php echo $quote['project_id'] ?>/">Project #<?php echo $quote['project_id'] ?></a></h2>
		</div>
        <?php 
            if($_pageName != "quote" && !isset($_SESSION['user_access']['client-grid']) && isset($_SESSION['user_access']['sales-grid'])) 
            {
        ?>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Project Details</h2>
                        <ul class="header-dropdown m-r-0">
                            <li>
                                <div class="switch">
                                    Edit: <label>OFF<input name="edit" class="editSwitch" type="checkbox"><span class="lever"></span>ON</label>
                                </div>
                            </li>
                            <li>
                                <button class="btn btn-xs btn-default waves-effect addNewQuote"  data-toggle="modal"data-target="#addNew-modal" data-project="<?php echo $projectID?>">
                                    Add New Quote
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                                 <?php 

                                    include($_MPATH['ADMIN_CONTROLLERS'].'projects_controller.php');

                                 ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <h2>Project Revenue Details</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                                 <ul> <b>Delivered Quotes</b>
                                    <li>
                                        Project Profit: <?php echo $projectRevenue['project_profit']  ?>
                                    </li>
                                    <li>
                                        Project Revenue: <?php echo $projectRevenue['project_revenue']  ?>
                                    </li>
                                </ul>

                                <div class="table-responsive">
                                    <table class="table table-hover dashboard-task-infos">
                                        <thead>
                                            <tr>
                                                <th>Winning Chance</th>
                                                <th>Ammount</th>
                                                <th>Quote Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $oldRevenue = 0;
                                                foreach ($revenueByStatus as $revenueStatus => $revenueStatusValue) {

                                                    if($revenueStatus == 4) {
                                                        $oldRevenue = $revenueStatusValue;
                                                        continue;
                                                    }

                                                    if($revenueStatus == 7) {
                                                        $revenueStatusValue = $oldRevenue + $revenueStatusValue;
                                                    }
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $winning_chance[$revenueStatus]?>%
                                                </td>
                                                <td>
                                                    <?php echo $revenueStatusValue?> Euro
                                                </td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $winning_chance[$revenueStatus]?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $winning_chance[$revenueStatus]?>%"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                            </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <h2>Project Comments</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="allComments_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>ID</th>
                                        <th>User Name</th>
                                        <th>Quote Status</th>
                                        <th>Comment</th>
                                        <th>Date</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php

        }
        

        foreach ($quoteQuery as $key => $quote) {
        
        

            # code...

            include($_MPATH['PROJECTS_VIEWS'].'quote_view.php');
        }


        ?>
	</div>
    <!-- Large Size -->
        <div class="modal fade" id="addNew-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title quoteTitle hidden" >Add new item to Quote #<span id="quoteNumber"></span></h4>
                        <h4 class="modal-title projectTitle hidden" >Add new item to Project #<span id="projectNumber"></span></h4>
                    </div>
                    <div class="modal-body">
                        <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <li role="presentation" class="active"><a href="#existingProduct" data-toggle="tab">Add existing product</a></li>
                                <!-- <li role="presentation"><a href="#temporaryProduct" data-toggle="tab">Add temporary product</a></li> -->
                            </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="existingProduct">
                                <?php include($_MPATH['CART_CONTROLLERS'].'cart_search_controller.php');?>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="temporaryProduct">
                                <form id="addTemporaryProduct" method="post" action='' enctype="multipart/form-data" >
                                        <div class="alert hidden addNewTemporaryProduct bg-pink alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            The product could not be added. The id might be duplicate. <b>Please try searching your id firs or contact the administrator..</b>
                                        </div>
                                        <div class="input-group">
                                            <h3>Add new Temporary Product</h3>
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="product_name" placeholder="Product Name" required>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="product_description" placeholder="Product Description" required>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="id" maxlength="24" placeholder="Product ID" required>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="form-line">
                                                <input type="number" class="form-control" step=".01" name="initial_price" placeholder="Initial Price" required>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="dropzone dropzone-image dz-clickable">
                                                <div class="dz-message">
                                                    <div class="drag-icon-cph">
                                                        <i class="material-icons">touch_app</i>
                                                    </div>
                                                    <h3>Drop files here or click to upload.</h3>
                                                    <input type="hidden" id="file-name" name="file_name" value="">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <input type="hidden" id="quote-id" name="quote_id" value="">
                                                <button id="submitTemporaryProduct" class="btn btn-lg btn-block btn-success waves-effect" type="submit">Add Temporary product</button>
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
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Edit Quote #<span id="quoteNumberEdit"></span></h4>
                    </div>
                    <div class="modal-body">
                        <form id="editQuote" method="post" action='' enctype="multipart/form-data" >
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" placeholder="Name">
                            </div>
                            <div class="alert usersSelectorError hidden bg-pink alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                Users could not be retrieved. <b>Please contact the administrator</b>
                            </div>
                            <div class="input-group">
                                <select class="form-control usersSelector" required name="owner_id">
                                    <option value="">Select user</option>
                                </select>
                            </div>
                            <div class="alert clientTypesSelectorError hidden bg-green alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                Clients could not be retrieved.</b>
                            </div>
                            <div class="input-group">
                                <select class="form-control clientTypesSelector" required name="client_id">
                                    <option value="">Select client</option>
                                </select>
                            </div>
                            <!-- <textarea class="tinymce" name="offer_conditions" placeholder="Offer conditions">
                            'Prețurile sunt în EUR cu Livrare DDU București',
                                            'Preturile sunt fara TVA si Taxa Verde',
                                            'Termen de livrare/confirmat la comandă fermă',
                                            'Modalitate și termen de plată: conform contract',
                                            'Valabilitate ofertă 30 zile'
                            </textarea> -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <button id="submitUserData" class="btn btn-lg btn-block btn-success waves-effect" type="submit">Submit quote data</button>
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

        <div class="modal fade" id="lastPrices" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Last Prices of Product: <span id="lastPriceProduct"></span> for <span id="lastPriceClient" ></span> </h4>
                    </div>
                    <div class="modal-body">

                        <h4 id="lastPriceProductName"></h4>

                        <table class="lastPricesTabel table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>Quote Id</th>
                                        <th>Project Name</th>
                                        <th>Offer Date</th>
                                        <th>Discount</th>
                                        <th>Final Price</th>
                                    </thead>
                                </table>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
      
       
        <!-- Large Size -->
        <div class="modal fade" id="sendMail-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Send Mail</span></h4>
                    </div>
                    <div class="modal-body">
                         <form id="sendQuoteForm" method="post" action='' enctype="multipart/form-data" >
                        <p><b>From:</b> office@icatch.ro<br/>
                            <b>To:</b> <input id="clientEmail" type="text" class="form-control" name="clientEmail" placeholder="Client Email"></p>
                        <p>Dear client, <br/><br/>
                        <textarea class="tinymce" name="email_body" placeholder="Email body">
                            <p>
                                We have finalized your quote. Please click the link attached to check it out and accept it. 
                            </p>
                        </textarea>
                        <p><a href='#'>Review quote here</a></p>
                        <div class="alert messageSent hidden bg-green alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                Message has been sent to client.</b>
                            </div>
                            <div class="alert messageError hidden bg-pink alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                Message has nont been sent to client. Please contact the administrator.</b>
                            </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button id="sendQuoteButton" class="btn btn-lg btn-block btn-success waves-effect" type="submit">Send Quote</button>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
        
</section>
