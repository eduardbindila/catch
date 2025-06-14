<?php 
require_once('config/helpers.php'); 
require_once($_PATH['COMMON_BACKEND'].'functions.php');
?>

<!-- Top Bar -->
        <nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
          <div class="container-fluid">
            <div class="navbar-header">
               <a class="navbar-brand" href="/dashboard"><img src="/common/interface/images/icatch-logo.png"></a>
            </div>
            <?php 
                if(isset($_SESSION['user_access']['menu'])) 
                {
            ?>
            <p class="navbar-text navbar-right">Welcome, <?php echo $_SESSION['name']?>!</p>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                    
                    <li>
                        <a href="/dashboard">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    <?php 
                        if(isset($_SESSION['user_access']['sales-grid'])) 
                        {
                    ?>
                    <li>
                                <a href="/admin/products">
                                    <span>Products</span>
                                </a>
                            </li>
                    <?php }?>

                    <?php 
                        if(isset($_SESSION['user_access']['admin'])) 
                        {
                    ?>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="material-icons">settings</i>
                            <span>Admin</span><span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                                    <li>
                                        <a href="/admin/manage/products">Manage Products</a>
                                    </li>
                                    <li>
                                        <a href="/admin/saga-processes">DRAFT Saga Processes Overview</a>
                                    </li>
                                    <li>
                                        <a href="/admin/import/categories">Import Categories</a>
                                    </li>
                                    <li>
                                        <a href="/admin/import/products">Import Products</a>
                                    </li>
                                    <li>
                                        <a href="/admin/import/users">Import Users</a>
                                    </li>
                                    <li>
                                        <a href="/admin/import/clients">Import Clients</a>
                                    </li>
                                    <li>
                                        <a href="/admin/import/designers">Import Designers</a>
                                    </li>
                                    <li>
                                        <a href="/admin/import/projects">Import Projects</a>
                                    </li>
                                    <li>
                                        <a href="/admin/import/scrapping">Scrapping List</a>
                                    </li>
                                    <li>
                                        <a href="/cart/import-prices">
                                            <span>Prices</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/admin/control-panel">
                                            <span>Control Panel</span>
                                        </a>
                                    </li>
                        </ul>
                    </li>
                    <?php }?>
                    <li class="dropdown">
                         <?php 
                            if(isset($_SESSION['user_access']['logistics'])) 
                            {
                        ?>
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="material-icons">settings</i>
                            <span>Logistics</span><span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/logistics/stocks">
                                    <span>Stocks</span>
                                </a>
                            </li>
                            <li>
                                <a href="/logistics/stock_locations">
                                    <span>Stock Locations</span>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="/logistics/import_stocks">
                                    <span>Import Stocks</span>
                                </a>
                            </li> -->
                            <li>
                                <a href="/logistics/vendor-invoices">
                                    Vendor Invoices
                                </a>
                            </li>
                            <li>
                                <a href="/logistics/client-invoices">
                                    Client Invoices
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php }?>

                     <?php 
                        if(isset($_SESSION['user_access']['sales-grid'])) 
                        {
                    ?>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="material-icons">settings</i>
                            <span>Settings</span><span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php 
                                if(isset($_SESSION['user_access']['supervisor'])) 
                                {
                            ?>
                            <li>
                                <a href="/admin/users">
                                    <span>Users</span>
                                </a>
                            </li>
                           
                            <li>
                                <a href="/admin/designers">
                                    <span>Designers</span>
                                </a>
                            </li>
                             <li>
                                <a href="/admin/pcategories">
                                    <span>Project Categories</span>
                                </a>
                            </li>
                           <!--  <li>
                                <a href="/admin/products">
                                    <span>Products</span>
                                </a>
                            </li> -->
                            <li>
                                <a href="/admin/countries">
                                    <span>Countries</span>
                                </a>
                            </li>
                             <li>
                                <a href="/admin/vendors">
                                    <span>Vendors</span>
                                </a>
                            </li>
                            <?php }?>
                             <li>
                                <a href="/clients">
                                    <span>Clients</span>
                                </a>
                            </li>
                            <?php 
                                if(isset($_SESSION['user_access']['access'])) 
                                {
                            ?>
                            <li>
                                <a href="/admin/access">
                                    <span>Access</span>
                                </a>
                            </li>
                            <?php }?>
                            
                        </ul>
                    </li>
                    <?php }?>

                    <?php 
                        if(isset($_SESSION['user_access']['cart'])) 
                        {
                    ?>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="material-icons">shopping_cart</i>
                            <span>Cart</span><span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php 
                                if(isset($_SESSION['user_access']['projects'])) 
                                {
                            ?>
                            <li>
                                <a href="/projects/">
                                    <span>Projects</span>
                                </a>
                            </li>
                             <li>
                                <a href="/quotes/">
                                    <span>Quotes</span>
                                </a>
                            </li>
                            <?php }?>

                            <?php 
                                if(isset($_SESSION['user_access']['search'])) 
                                {
                            ?>
                            <li>
                                <a href="/cart/create/">
                                    <span>Create Quote</span>
                                </a>
                            </li>
                             <li>
                                <a href="/cart/catalog/">
                                    <span>Catalog</span>
                                </a>
                            </li>
                            <?php }?>
                        </ul>
                    </li>
                    <?php }?>
                    <!-- <li>
                        <a href="/ajax/logout">
                            <span>Logout</span>
                        </a>
                    </li> -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar viewWishlistProducts" data-close="true">Wishlist<i class="material-icons">more_vert</i> <span class="label-count">7</span></a></li>
                </ul>
            </div>
            <?php }?>
          </div>
        </nav>





        <aside id="rightsidebar" class="right-sidebar wishlist-view">
                <h4 class="text-center">My wishlist</h4>
               <ul class="list-group wishlistProducts pre-scrollable">
               </ul>
               <a href="/cart/create/?project=undefined&searchFromWishlist=1" class="btn btn-success waves-effect waves-block">Search these products</a>    
               <a href="#" class="btn btn-danger waves-effect waves-block m-t-5 clearWishlist">Clear list</a>          
        </aside>
        <div class="overlay"></div>