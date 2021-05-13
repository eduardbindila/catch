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
                            <li>
                                <a href="/admin/products">
                                    <span>Products</span>
                                </a>
                            </li>
                            <li>
                                <a href="/admin/countries">
                                    <span>Countries</span>
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
                                <a href="/cart/create">
                                    <span>Create Quote</span>
                                </a>
                            </li>
                            <?php }?>
                        </ul>
                    </li>
                    <?php }?>
                    <li>
                        <a href="/ajax/logout">
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
            <?php }?>
          </div>
        </nav>