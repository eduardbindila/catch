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

    </script><script src="/common/interface/plugins/chartjs/Chart.bundle.js?v=0.1.3"></script>
</script><script src="/common/interface/plugins/chartjs/Chart.BarFunnel.js?v=0.1.3"></script>

    


    

    <!-- Imported Styles -->
    <?php $LoadHTMLArtefacts->printLinks();?>

    <script type="text/javascript">
        
        var isc = <?php echo json_encode($_clientView)?>;
        var iss = <?php echo json_encode($_salesView)?>;
        var issv = <?php echo json_encode($_supervisorView)?>;
        var isa = <?php echo json_encode($_adminView)?>;

    </script>

</head>

<body class="<?php $LoadHTMLArtefacts->printBodyClasses()?>">
