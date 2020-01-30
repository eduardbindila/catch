`

<section class="content projectPage">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Dashboard</h2>
		</div>
        <?php 
            if(isset($_SESSION['user_access']['sales-grid'])) 
            {
        ?>
        <div class="row">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Quotes profit under 30%</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                               <table class="quotes_attention table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>Project ID</th>
                                        <th>Quote ID</th>
                                        <th>Start Date</th>
                                        <th>Project Value</th>
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
                        <h2>Projects Details</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                               <table class="projects_legacy table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <th>Project ID</th>
                                        <th>Legacy ID</th>
                                        <th>Parent ID</th>
                                        <th>Start Date</th>
                                        <th>Offer Date</th>
                                        <th>Owner</th>
                                        <th>Client</th>
                                        <th>Designer</th>
                                        <th>Quote Status</th>
                                        <th>Project Status</th>
                                        <th>Project Value</th>
                                        <th>Winning Chance</th>
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
                                        <th>Sales Owner</th>
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