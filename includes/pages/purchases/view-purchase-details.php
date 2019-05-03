<?php
require_once('db/models/Customer.class.php');
require_once('db/models/Purchase.class.php');
require_once('db/models/PurchaseProduct.class.php');

require_once('db/models/Product.class.php');
require_once('db/models/Category.class.php');
require_once 'constants.php';
require_once('helpers/redirect-helper.php');
if (isset($id)) {
    $purchase_to_edit = Purchase::find("purchase_id = ?", $id);
    $purchase_products_to_edit = PurchaseProduct::select("*", "purchase_id = ?", $id);
    ?>
    <div class="row">
        <div class="offset-1 col-md-10">
            <h3>Purchase Details</h3>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="invoice_date" data-toggle="tooltip" data-placement="right" title="">Purchase Date <i
                                class="fa fa-question-circle"></i></label>
                    <input disabled type="date" class="form-control" name="invoice_date" id="invoice_date"
                           value="<?php echo $purchase_to_edit->invoice_date; ?>">
                </div>

                <div class="form-group col-md-4 offset-1">
                    <label for="invoice_no" data-toggle="tooltip" data-placement="right" title="">Purchase No. <i
                                class="fa fa-question-circle"></i></label>
                    <input disabled type="text" class="form-control" name="invoice_no" id="invoice_no"
                           placeholder="Enter Purchase No. " value="<?php echo $purchase_to_edit->invoice_no; ?>">
                </div>

                <div class="form-group col-md-3 offset-1">
                    <label for="due_date" data-toggle="tooltip" data-placement="right" title="">Due Date <i
                                class="fa fa-question-circle"></i></label>
                    <input disabled type="date" class="form-control" name="due_date" id="due_date"
                           value="<?php echo $purchase_to_edit->due_date; ?>">
                </div>
            </div>
            <h3>Customer Details</h3>
            <hr>
            <div class="form-group">
                <?php
                $customer = Customer::find("customer_id = ?", $purchase_to_edit->customer_id);
                echo "<input value='$customer->customer_name' disabled type='text' class='form-control'>";
                ?>
            </div>
            <h3>Product Details</h3>
            <hr>
            <?php
            $model_name = "Purchase";
            require_once "db/models/{$model_name}.class.php";
            $rs = Purchase::viewProductDetails($id);
            //This array will store the table headers for the columns we are selecting from database
            $column_names_as = array(
                "category_name" => "Category Name",
                "gst_rate" => "GST Rate",
                "product_name" => "Product Name",
                "product_quantity" => "Product Quantity",
            );
            ?>
            <div class="row">
                    <div class="table-responsive">
                        <table id="tables" class="table table-bordered">
                            <thead>
                            <tr>
                                <?php
                                foreach ($column_names_as as $column_name_as) {
                                    echo "<th>{$column_name_as}</th>";
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $column_names = array_keys($column_names_as);
                            while($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                foreach ($column_names as $column_name) {
                                    if(empty($row[$column_name])) {
                                        echo "<td>NULL</td>";
                                    }
                                    else {
                                        echo "<td>$row[$column_name]</td>";
                                    }
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
    <?php
}
?>