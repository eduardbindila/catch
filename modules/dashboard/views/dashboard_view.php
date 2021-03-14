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
                        <h2>Quotes for Approval</h2>
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
                                        <th>Quote ID</th>
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
                                <canvas id="myChart" width="400" height="50"></canvas>
                                 <canvas id="myFunnel" height="100"></canvas>
                               <table class="projects_legacy table table-striped table-bordered table-hover dt-responsive display"> 
                                    <thead>
                                        <th>Project ID</th>
                                        <th>Name</th>
                                        <th>Project Name</th>
                                        <th>Quote ID</th>
                                        <th>Owner</th>
                                        <th>Client</th>
                                        <th>Designer</th>
                                        <th>Status</th>
                                        <th>Project Value</th>
                                        <th>Winning Chance</th>
                                        <th>Is Master</th>
                                        <th>Year</th>
                                        <th>Quarter</th>
                                        <th>Month</th>
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
<script >
     var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
                  type: 'horizontalBar',
                  data: {
                    labels: ['Quote Value by Quote Status'],
                    datasets: [
                      
                    ]
                  },
                  options: {
                    scales: {
                      xAxes: [{ stacked: true }],
                      yAxes: [{ stacked: true }]
                    },
                    showDatapoints: true,
                  }
                });

        var ctx2 = document.getElementById("myFunnel").getContext("2d");

        var myFunnel = new Chart(ctx2, 

{
        type: 'funnel',
        data: {
                   datasets: [{
                data: [10, 35, 90],
                backgroundColor: [
                    "#FF6384",
                    "#36A2EB",
                    "#FFCE56"
                ],
                hoverBackgroundColor: [
                    "#FF6384",
                    "#36A2EB",
                    "#FFCE56"
                ]
            }],
            labels: [
                "Red",
                "Blue",
                "Yellow"
            ]
                  },
        options: {
            responsive: true,
            sort: 'desc',
            legend: {
                position: 'top'
            },
            title: {
                display: true,
                text: 'Chart.js Funnel Chart'
            },
            animation: {
                animateScale: true,
                animateRotate: true,
                onComplete: function () {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;
                        ctx.textAlign = 'center';
                        ctx.fillStyle = "rgba(0, 0, 0, 1)";
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function (dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function (bar, index) {
                                var data = dataset.data[index];
                                ctx.fillText(data.toLocaleString(), bar._model.x, bar._model.y+50);

                            });
                        });
                    }
            }
        }
    }
            );
</script>

