<?php 
require_once('config/helpers.php'); 
require_once($_PATH['COMMON_BACKEND'].'functions.php');
?>

<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="/dashboard"><img src="/common/interface/images/icatch-b2b.png"></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            
        </div>
    </div>
</nav>
<!-- #Top Bar -->
<section>
        <!-- Left Sidebar -->
        <?php 
            if(isset($_SESSION['user_access']['menu'])) 
            {
        ?>
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="https://www.stickpng.com/assets/images/580b57fbd9996e24bc43c051.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['name']?></div>
                    <div class="email"></div>
                    <!-- <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div> -->
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li >
                        <a href="/dashboard">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>

                    <?php 
                        if(isset($_SESSION['user_access']['admin'])) 
                        {
                    ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">settings</i>
                            <span>Admin</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle toggled">
                                    <span>Imports</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="/admin/import/categories">Categories</a>
                                    </li>
                                    <li>
                                        <a href="/admin/import/products">Products</a>
                                    </li>
                                    <li>
                                        <a href="/admin/import/users">Users</a>
                                    </li>
                                    <li>
                                        <a href="/admin/import/clients">Clients</a>
                                    </li>
                                    <li>
                                        <a href="/admin/import/designers">Designers</a>
                                    </li>
                                    <li>
                                        <a href="/admin/import/projects">Projects</a>
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
                        </ul>
                    </li>
                    <?php }?>

                    <?php 
                        if(isset($_SESSION['user_access']['supervisor'])) 
                        {
                    ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">settings</i>
                            <span>Settings</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="/admin/users">
                                    <span>Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="/admin/clients">
                                    <span>Clients</span>
                                </a>
                            </li>
                            <li>
                                <a href="/admin/designers">
                                    <span>Designers</span>
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
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle toggled">
                            <i class="material-icons">shopping_cart</i>
                            <span>Cart</span>
                        </a>
                        <ul class="ml-menu">
                            <?php 
                                if(isset($_SESSION['user_access']['projects'])) 
                                {
                            ?>
                            <li>
                                <a href="/projects/">
                                    <span>Projects</span>
                                </a>
                            </li>
                            <?php }?>

                            <?php 
                                if(isset($_SESSION['user_access']['search'])) 
                                {
                            ?>
                            <li>
                                <a href="/cart/search">
                                    <span>Search</span>
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
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2019 <a href="javascript:void(0);">iCatch B2B</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 0.2
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <?php }?>
        <!-- #END# Left Sidebar -->
    </section>
