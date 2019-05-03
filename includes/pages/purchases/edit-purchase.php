<?php
require_once ('db/models/Purchase.class.php');
require_once ('db/models/Supplier.class.php');
require_once ('db/models/PurchaseProduct.class.php');
require_once ('db/models/Product.class.php');
require_once ('db/models/Category.class.php');
require_once 'constants.php';
require_once ('helpers/redirect-helper.php');
if(isset($_POST[EDIT_PURCHASE])){
    try
    {
        //Starting transactions
        CRUD::setAutoCommitOn(false);
        $totalAmount = 0.0;
        $flag = true;
        $product_flag = true;

        $purchase_id = $_POST['purchase_id'];
        //first remove all products previously inserted (this purchase entry)
        $res = PurchaseProduct::select("*","purchase_id = ?", $purchase_id);
        $purchase_products = $res->fetchAll();
        $purchase_products_count = $res->rowCount();
        $purchase_products_To_be_deleted = array();

        foreach ($purchase_products as $p_p){
            $product = Product::find("product_id = ?",$p_p->product_id);
            if($p_p->product_quantity <= $product->product_quantity){
                $product->product_quantity -= $p_p->product_quantity;
            }else{
                throw new Exception('Invoice could not be created, as product quantity is not available');
            }
            if(!$product->update()){
                $product_flag = false;
            }

        }

        if($product_flag) {

            //data to be inserted in purchase table
            $purchase = Purchase::find("purchase_id = ?", $purchase_id);
            $purchase->supplier_id = $_POST['supplier_id'];
            $purchase->purchase_title = $_POST['purchase_title'];
            $purchase->date_of_purchase = $_POST['date_of_purchase'];

            //updating in purchase table
            if ($purchase->update()) {
                //data to be inserted in purchase_product table
                $i = 0;
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

                    if ($purchase_product->update() && $product->update()) {
                        $flag = true;
                    } else {
                        $flag = false;
                        break;
                    }
                    $i++;
                }
                if ($flag) {
                    $purchase = Purchase::find("purchase_id = ?", $purchase_id);
                    $purchase->total_purchase_amount = $totalAmount;
                    if ($purchase->update()) {
                        CRUD::commit();
                        setStatusAndMsg("success", "Purchase updated successfully");
                    } else {
                        throw new Exception('purchase amount not updated');
                    }
                } else {
                    CRUD::rollback();
                    setStatusAndMsg("error", "Purchase cannot be updated");
                }
            } else {
                CRUD::rollback();
                setStatusAndMsg("error", "Purchase cannot be updated");
            }
        }
    }catch (Exception $ex){
        CRUD::rollback();
        setStatusAndMsg("error",$ex->getMessage());
    }
    //ending transactions
    CRUD::setAutoCommitOn(true);
}

if(isset($id)) {
    $purchase_to_edit = Purchase::find("purchase_id = ?", $id);
    $purchase_products_to_edit = PurchaseProduct::select("*","purchase_id = ?", $id);
    ?>
    <div class="row">
        <div class="offset-1 col-md-10">
            <form action="" method="post" role="form" enctype="multipart/form-data">

                <h3>Edit Purchase - Purchase details</h3>
                <hr>
                <div class="form-row">

                    <input type="hidden" name="purchase_id" value="<?php echo $purchase_to_edit->purchase_id; ?>">
                    <div class="form-group col-md-6">
                        <label for="purchase_title" data-toggle="tooltip" data-placement="right" title="">Purchase Title
                            <i class="fa fa-question-circle"></i></label>
                        <input type="text" class="form-control" name="purchase_title" id="purchase_title" min="0"
                               placeholder="Enter Purchase title" value="<?php echo $purchase_to_edit->purchase_title; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="date_of_purchase" data-toggle="tooltip" data-placement="right" title="">Date Of
                            Purchase <i class="fa fa-question-circle"></i></label>
                        <input type="date" class="form-control" name="date_of_purchase" id="date_of_purchase" required
                               value="<?php echo $purchase_to_edit->date_of_purchase; ?>">
                    </div>

                </div>
                <h3>Supplier details</h3>
                <hr>
                <div class="form-group">
                    <label for="supplier_id" data-toggle="tooltip" data-placement="right" title="">Select Supplier <i
                            class="fa fa-question-circle"></i></label>
                    <select name="supplier_id" id="supplier_id" class="form-control supplier selectize" required>
                        <option value="">Select Supplier</option>
                        <?php
                        $result = Supplier::select();
                        foreach ($result as $supplier) {
                            if($supplier->supplier_id === $purchase_to_edit->supplier_id)
                                $selected = "selected";
                            else
                                $selected = "";
                            echo "<option value='$supplier->supplier_id' $selected>$supplier->supplier_name ($supplier->supplier_shopname)</option>";
                        }
                        ?>
                    </select>
                </div>
                <?php
                $script_var = array();
                $i = 0;
                foreach ($purchase_products_to_edit->fetchAll() as $purchase_product){
                    $prod_id = $purchase_product->product_id;
                    $script_var[$i++] = array(Product::find("product_id = ?", $prod_id)->category_id, $prod_id, $purchase_product->product_quantity, $purchase_product->product_rate);
                }
                $script_var = json_encode($script_var);
                require_once('includes/pages/commons/add-product-details.php');
                ?>
                <button type="submit" name="edit_purchase" id="edit_purchase" class="btn btn-primary">Edit Purchase
                </button>
            </form>
        </div>
    </div>
    <?php
}
    ?>