`

<section class="content projectPage">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Dashboard</h2>
		</div>
        <?php 
            if(isset($_SESSION['user_access']['logistics'])) 
            {
        ?>

        <div class="row">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Logistic Details</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                               <table class="logistic_details-table table table-striped table-bordered table-hover dt-responsive display"> 
                                    <thead>
                                        <th>Quote ID</th>
                                        <th>Quote Name</th>
                                        <th>Quote Status</th>
                                        <th>Product ID</th>
                                        <th>Action Date</th>
                                        <th>Owner</th>
                                        <th>Client</th>
                                       <th>Quote Fullfiled</th>
                                        <th>Order in Transit</th>
                                        <th>Received Order</th>
                                        <th>Invoiced Order</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Client Invoices</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                               <table class="invoices-table table table-striped table-bordered table-hover dt-responsive display"> 
                                    <thead>
                                        <th>Quote ID</th>
                                        <th>Quote Name</th>
                                        <th>Package ID</th>
                                        <th>Invoice Number</th>
                                        <th>Invoice Date</th>
                                        <th>Owner</th>
                                        <th>Client</th>
                                        <th>File</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php }?>
        <?php 
            if(isset($_SESSION['user_access']['sales-grid'])) 
            {
        ?>
        <div class="row">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Quotes that need attention</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                               <table class="quotes_attention table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>Project ID</th>
                                        <th>Project Name</th>
                                        <th>Quote ID</th>
                                        <th>Client Name</th>
                                        <th>Start Date</th>
                                        <th>Offer Date</th>
                                        <th>Project Value</th>
                                        <th>Status</th>
                                        <th>Profit Percent</th>
                                        <th>Winning Chance</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Files that need Atention</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                               <table class="files_attention table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>Project ID</th>
                                        <th>Project Name</th>
                                        <th>Quote ID</th>
                                        <th>Client Name</th>
                                        <th>File</th>
                                        <th>File Type</th>
                                        <th>Agent</th>
                                        <th>Upload Date</th>
                                        <th>Days since</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="row">
	       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Projects Details</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                               <table class="projects_legacy table table-striped table-bordered table-hover dt-responsive display"> 
                                    <thead>
                                        <th>Project ID</th>
                                        <th class="hideFromfilters">Name</th>
                                        <th>Project Name</th>
                                        <th>Quote ID</th>
                                        <th >Owner</th>
                                        <th>Client</th>
                                        <th class="hideFromfilters">Start Date</th>
                                        <th>Status</th>
                                        <th>Project Value</th>
                                        <th class="hideFromfilters">Winning Chance</th>
                                        <th>Is Master</th>
                                        <th>Year</th>
                                        <th class="hideFromfilters">Quarter</th>
                                        <th class="hideFromfilters">Month</th>
                                        <th>Project Status</th>
                                        
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>


        <?php 
            if(isset($_SESSION['user_access']['client-grid'])) 
            {
        ?>
        <div class="row">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>My Quotes</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                               <table class="quotes-table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>Quote ID</th>
                                        <th>Start Date</th>
                                        <th>Offer Date</th>
                                        <th>Quote Name</th>
                                        <th>Quote Price</th>
                                        <th>Created by</th>
                                        <th>Quote Status</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
	</div>
</section>