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
			<h2 id="project" data-project="<?php echo $projectID ?>">Quote Details </h2>
		</div>
        <?php

        foreach ($quoteQuery as $key => $quote) {
            # code...

            //include($_MPATH['PROJECTS_VIEWS'].'quote_view.php');
        }
        ?>
	</div>
</section>