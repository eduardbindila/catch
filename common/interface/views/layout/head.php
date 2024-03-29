<?php 
require_once('config/helpers.php'); 
require_once($_PATH['COMMON_BACKEND'].'functions.php');
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>iCatch B2B</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">


    <!-- Bootstrap Core Css -->
    <link href="<?php echo $_WPATH['COMMON_INTERFACE']?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    
    <link href="<?php echo $_WPATH['COMMON_INTERFACE']?>plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo $_WPATH['COMMON_INTERFACE']?>plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo $_WPATH['COMMON_INTERFACE']?>css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo $_WPATH['COMMON_INTERFACE']?>css/themes/all-themes.css" rel="stylesheet" />

    </script><script src="/common/interface/plugins/chartjs/Chart.bundle.js?v=0.1.4"></script>
</script><script src="/common/interface/plugins/chartjs/chart.funnel.bundled.js?v=0.1.4"></script>
<script data-jsd-embedded data-key="6a7789fb-0d09-46bf-af29-7bbbf7fec541" data-base-url="https://jsd-widget.atlassian.com" src="https://jsd-widget.atlassian.com/assets/embed.js"></script>    

    <!-- Imported Styles -->
    <?php $LoadHTMLArtefacts->printLinks();?>

    <script type="text/javascript">
        
        var isc = <?php echo json_encode($_clientView)?>;
        var iss = <?php echo json_encode($_salesView)?>;
        var isl = <?php echo json_encode($_logisticsView)?>;
        var islh = <?php echo json_encode($_hideForLogistic)?>;
        var issv = <?php echo json_encode($_supervisorView)?>;
        var isa = <?php echo json_encode($_adminView)?>;
        var inputDisabledForClient = isc ? 'Disabled' : ''; 

        

        var clientIs = <?php echo json_encode($_SESSION['user_id']); ?>;

        var ownerName = <?php echo json_encode($_SESSION['name']); ?>;

    </script>

</head>

<body class="<?php $LoadHTMLArtefacts->printBodyClasses()?>">
