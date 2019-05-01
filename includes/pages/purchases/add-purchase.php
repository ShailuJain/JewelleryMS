<?php

require_once ('db/models/Purchase.class.php');
require_once ('db/models/Supplier.class.php');
require_once ('db/models/PurchaseProduct.class.php');
require_once ('db/models/Product.class.php');
require_once ('db/models/Category.class.php');
    require_once 'constants.php';
    require_once ('helpers/redirect-helper.php');
    if(isset($_POST[ADD_PURCHASE])){
        try
        {
            //data to be inserted in purchase table
            $purchase = new Purchase();
            $purchase->supplier_id = $_POST['supplier_id'];
            $purchase->purchase_title = $_POST['purchase_title'];
            $purchase->date_of_purchase = $_POST['date_of_purchase'];

            //data to be inserted in purchase_product table and to be updated in product table
            $i = 0;
            $purchase_products = array();
            foreach ($_POST['product_id'] as $product_id) {
                $category_id = $_POST['category_id'][$i];
                $purchase_products[$i] = new PurchaseProduct();
                $purchase_products[$i]->product_id = $product_id;
                $purchase_products[$i]->rate_of_purchase = $_POST['rate_of_purchase'];
            }
//            unset($arr[ADD_PURCHASE]);
//            $arrayKeys = array_keys($arr);
//
//            //creating a new purchase object and adding the fields.
//            $purchase = new Purchase();
//
//            foreach ($arrayKeys as $item) {
//                $purchase->$item = $arr[$item];
//            }
//            if($purchase->insert()){
//                //showing acknowledgement when a purchase is successfully added
//                setStatusAndMsg("success","Purchase added successfully");
//            }
//            else{
//                setStatusAndMsg("error","Purchase already exists");
//            }
        }catch (Exception $ex){
            setStatusAndMsg("error","Something went wrong");
        }
    }

?>


<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="post" role="form" enctype="multipart/form-data">

            <h3>Purchase details</h3>
            <hr>
            <div class="form-row">

                <div class="form-group col-md-6">
                    <label for="product_title" data-toggle="tooltip" data-placement="right" title="" >Purchase Title <i class="fa fa-question-circle"></i></label>
                    <input type="text" class="form-control" name="product_title" id="product_title" min="0" placeholder="Enter Purchase title">
                </div>
                <div class="form-group col-md-6">
                    <label for="purchase_date" data-toggle="tooltip" data-placement="right" title="" >Date Of Purchase <i class="fa fa-question-circle"></i></label>
                    <input type="date" class="form-control" name="purchase_date" id="purchase_date" required value="<?php echo date('Y-m-d'); ?>">
                </div>

            </div>
            <h3>Supplier details</h3>
            <hr>
            <div class="form-group">
                <label for="supplier_id" data-toggle="tooltip" data-placement="right" title="" >Select Supplier <i class="fa fa-question-circle"></i></label>
                <select name="supplier_id" id="supplier_id" class="form-control supplier selectize" required>
                    <option value="">Select Supplier</option>
                    <?php
                    $result = Supplier::select();
                    foreach ($result as $supplier){
                        echo "<option value='$supplier->supplier_id'>$supplier->supplier_name ($supplier->supplier_shopname)</option>";
                    }
                    ?>
                </select>
            </div>
            <?php
                require_once ('includes/pages/commons/add-product-details.php');
            ?>
            <button type="submit" name="add_purchase" id="add_purchase" class="btn btn-primary">Add Purchase</button>
        </form>
    </div>
</div>
<style>
    .select2-results__options{
        font-size:14px !important;
    }
</style>