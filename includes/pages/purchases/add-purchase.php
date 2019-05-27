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
            //Starting transactions
            CRUD::setAutoCommitOn(false);
            $totalAmount = 0.0;
            $flag = true;

            //data to be inserted in purchase table
            $purchase = new Purchase();
            $purchase->supplier_id = $_POST['supplier_id'];
            $purchase->purchase_no = $_POST['purchase_no'];
            $purchase->date_of_purchase = $_POST['date_of_purchase'];

            //inserting in purchase table
            if($purchase->insert())
            {
                //data to be inserted in purchase_product table
                $i = 0;
                $purchase_id = CRUD::lastInsertId();
                $purchase_product = "";
                foreach ($_POST['product_id'] as $product_id) {
                    $category_id = $_POST['category_id'][$i];
                    $purchase_product = new PurchaseProduct();
                    $purchase_product->purchase_id = $purchase_id;
                    $purchase_product->product_id = $product_id;
                    $purchase_product->product_rate = doubleval($_POST['product_rate'][$i]);
                    $purchase_product->product_quantity = doubleval($_POST['product_quantity'][$i]);
                    $purchase_product->unit = "gm";


//                    $gst_rate = CRUD::query("SELECT gst_rate from gst WHERE gst_id = (SELECT gst_id from categories WHERE category_id = 3 AND deleted = 0) AND deleted = 0");

//                    $gst_rate = CRUD::query("SELECT gst_rate FROM gst INNER JOIN (SELECT gst_id FROM categories WHERE category_id = 1 AND deleted = 0) AS categories ON gst.gst_id = categories.gst_id WHERE gst.deleted = 0");

                    $gst_rate = CRUD::query("SELECT gst_rate FROM gst INNER JOIN categories ON gst.gst_id = categories.gst_id WHERE categories.category_id = ? AND gst.deleted = 0 AND categories.deleted = 0", $category_id)->fetch()->gst_rate;

                    $amount = ($purchase_product->product_quantity * $purchase_product->product_rate);
                    $gst_amount = $amount * $gst_rate / 100;
                    $totalAmount += $amount + $gst_amount;

                    //data to be updated in the product table
                    $product = Product::find("product_id = ?", $product_id);
                    $product->product_quantity += $purchase_product->product_quantity;

                    if($purchase_product->insert() && $product->update())
                    {
                        $flag = true;
                    }else{
                        $flag = false;
                        break;
                    }
                    $i++;
                }
                if($flag){
                    $purchase = Purchase::find("purchase_id = ?", $purchase_id);
                    $purchase->total_purchase_amount = $totalAmount;
                    if($purchase->update()){
                        CRUD::commit();
                        setStatusAndMsg("success","Purchase created successfully");
                    }else{
                        throw new Exception('purchase amount not updated');
                    }
                }else{
                    CRUD::rollback();
                    setStatusAndMsg("error","Purchase-Product cannot be created. Purchase cannot be created");
                }
            }else{
                CRUD::rollback();
                setStatusAndMsg("error","Purchase cannot be created");
            }
        }catch (Exception $ex){
            CRUD::rollback();
            setStatusAndMsg("error","Something went wrong".$ex);
        }
        //ending transactions
        CRUD::setAutoCommitOn(true);
    }
$pur_no = CRUD::query("SELECT purchase_id FROM purchases ORDER BY purchase_id DESC LIMIT 1")->fetch()->purchase_id;
?>
<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <h3>New Purchase - Purchase details</h3>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="purchase_no" data-toggle="tooltip" data-placement="right" title="" >Purchase No <i class="fa fa-question-circle"></i></label>
                    <input type="text" class="form-control" name="purchase_no" id="purchase_no" min="0" placeholder="Enter Purchase no" value="PURSJ-<?php echo $pur_no+1; ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="date_of_purchase" data-toggle="tooltip" data-placement="right" title="" >Date Of Purchase <i class="fa fa-question-circle"></i></label>
                    <input type="date" class="form-control" name="date_of_purchase" id="date_of_purchase" required value="<?php echo date('Y-m-d'); ?>">
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
                require_once('includes/pages/commons/add-product-details-purchase.php');
            ?>
            <button type="submit" name="add_purchase" id="add_purchase" class="btn btn-primary">Add Purchase</button>
        </form>
    </div>
</div>