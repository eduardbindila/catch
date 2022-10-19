<?php 
require_once('config/helpers.php'); 
require_once($_PATH['COMMON_BACKEND'].'functions.php');
?>

<div class="code-version text-center small col-blue-grey">Code Version: <?php echo $_VERSION?></div>

<!-- Jquery Core Js -->
    <script src="<?php echo $_WPATH['COMMON_INTERFACE']?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo $_WPATH['COMMON_INTERFACE']?>plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo $_WPATH['COMMON_INTERFACE']?>plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo $_WPATH['COMMON_INTERFACE']?>plugins/node-waves/waves.js"></script>

    <script src="<?php echo $_WPATH['COMMON_INTERFACE']?>js/admin.js"></script>

    <!-- Imported Scripts -->
    <?php $LoadHTMLArtefacts->printScripts();?>

 
</body>

</html>
