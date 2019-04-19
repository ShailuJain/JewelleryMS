<?php

    require_once ('db/models/Supplier.class.php');
    require_once ('db/models/Product.class.php');
    require_once ('db/models/Purchase.class.php');
    require_once ('db/models/Category.class.php');
    require_once 'constants.php';
    require_once ('helpers/redirect-helper.php');
    if(isset($_POST[ADD_PURCHASE])){
        try
        {
            $arr = $_POST;
            unset($arr[ADD_PURCHASE]);
            $arrKeys = array_keys($arr);

            //creating a new purchase object and adding the fields.
            $purchase = new Purchase();

            foreach ($arrayKeys as $item) {
                $purchase->$item = $array[$item];
            }
            if($purchase->insert()){
                //showing acknowledgement when a purchase is successfully added
                setStatusAndMsg("success","Purchase added successfully");
            }
            else{
                setStatusAndMsg("error","Purchase already exists");
            }
        }catch (Exception $ex){
            setStatusAndMsg("error","Something went wrong");
        }
    }

?>


<div class="row">

    <div class="offset-1 col-md-10">
        <form action="" method="post" role="form" enctype="multipart/form-data">

            <h3>Supplier details</h3>
            <hr>
            <div class="form-group">
                <label for="supplier">Select Product</label>
                <select name="supplier" id="supplier" class="form-control supplier" required>
                    <option value="">Select Supplier Name</option>
                    <?php
                    $result = Supplier::select();
                    foreach ($result as $supplier){
                        echo "<option value='$supplier->supplier_id'>$supplier->supplier_name ($supplier->supplier_shopname)</option>";
                    }
                    ?>
                </select>
            </div>


            <h3>Product details</h3>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="category">Select Category</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php
                        $result = Category::select();
                        foreach ($result as $category){
                            echo "<option value='$category->category_id'>$category->category_name</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="product">Select Product</label>
                    <select name="product" id="product" class="form-control" required>
                        <option value="">Select Product</option>
                        <?php
                        $result = Product::select();
                        foreach ($result as $product){
                            echo "<option value='$product->product_id'>$product->product_name</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="product_quantity">Enter quantity</label>
                    <input type="number" class="form-control">
                </div>
            </div>

            <h3>Purchase details</h3>
            <hr>
            <div class="form-group">
                <label for="purchase_date">Date Of Purchase</label>
                <input type="date" class="form-control" name="purchase_date" id="purchase_date">
            </div>

            <div class="form-group">
                <label for="purchase_date">Quantity</label>
                <input type="number" class="form-control" name="product_quantity" id="product_quantity" min="0" placeholder="Enter Quantity">
            </div>

            <div class="form-group">
                <label for="pur_hsn">Hsn Code</label>
                <input type="text" class="form-control" name="pur_hsn" id="pur_hsn" placeholder="Enter Hsn-code">
            </div>


            <button type="submit" name="add_purchase" id="add_purchase" class="btn btn-primary">Add Purchase</button>
        </form>
    </div>
</div>
<style>
    .select2-results__options{
        font-size:14px !important;
    }
</style>