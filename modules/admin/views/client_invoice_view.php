<script type="text/javascript">
    
  


</script>

<section class="content projectPage">
    <div class="container-fluid">
        <div class="block-header">
            <h2 class="packageId" data-package-id="<?php echo $packageID?>">Client Invoice</h2>
        </div>
        <div class="row">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <?php include($_MPATH['ADMIN_CONTROLLERS'].'import_invoice_controller.php');?>

                <div class="card">
                    <div class="header">
                        <h2>Client Invoice <?php echo $invoiceNumber?> Details:</h2>
                        <ul class="header-dropdown m-r-0">
                            <!-- <li>
                                <div class="switch">
                                    Edit: <label>OFF<input name="edit" class="editSwitch" type="checkbox"><span class="lever"></span>ON</label>
                                </div>
                            </li> -->
                             <li>
                                
                            </li>
                           
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert addUserError hidden bg-pink alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <b>Please contact the administrator</b>
                                </div>
                                <div class="alert addUserSuccess hidden alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    Client has been succesfully added.
                                </div>
                               
                                <?php 
                                    include($_MPATH['ADMIN_VIEWS'].'add_client_invoice_form_view.php');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="card">
                    <div class="header">
                        <h2>Invoice Items </h2>
                        <ul class="header-dropdown m-r-0">
                            <!-- <li>
                                <div class="switch">
                                    Edit: <label>OFF<input name="edit" class="editSwitch" type="checkbox"><span class="lever"></span>ON</label>
                                </div>
                            </li> -->
                        </ul>
                    </div>
                    <div class="body">
                        
                        <div class="row">
                            <div class="col-lg-12">
                              <table class="invoice_items_table table table-striped table-bordered table-hover dt-responsive display">
                                    <thead>
                                        <tr>
                                            <th>No. CRT</th>
                                            <th>Product Id</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Green Tax</th>
                                            <th>Value</th>
                                            <th>Vat</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3">Total:</th>
                                            <th></th> <!-- Celulă pentru cantitate - se va completa din JS -->
                                            <th></th> <!-- Celulă pentru pret/buc fara tva - se va completa din JS -->
                                            <th></th> <!-- Celulă pentru taxa verde - se va completa din JS -->
                                            <th></th> <!-- Celulă pentru valoare fara TVA (Ron) - se va completa din JS -->
                                            <th></th> <!-- Celulă pentru TVA (19%) - se va completa din JS -->
                                            <th></th> <!-- Celulă pentru total + TVA - se va completa din JS -->
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>