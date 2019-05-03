<?php
require_once('db/models/Customer.class.php');
require_once('db/models/Invoice.class.php');
require_once('db/models/InvoiceProduct.class.php');

require_once('db/models/Product.class.php');
require_once('db/models/Category.class.php');
require_once 'constants.php';
require_once('helpers/redirect-helper.php');
if (isset($_POST[EDIT_INVOICE])) {
    try {
        //Starting transactions
        CRUD::setAutoCommitOn(false);
        $totalAmount = 0.0;
        $flag = true;
        $product_flag = true;

        $invoice_id = $_POST['invoice_id'];
        //first remove all products previously inserted (this purchase entry)
        $res = InvoiceProduct::select("*","invoice_id = ?", $invoice_id);
        $invoice_products = $res->fetchAll();
        $invoice_products_count = $res->rowCount();
        $invoice_products_to_be_deleted = array();

        foreach ($invoice_products as $i_p){
            $product = Product::find("product_id = ?",$i_p->product_id);
            $product->product_quantity += $i_p->product_quantity;
            if(!$product->update()){
                $product_flag = false;
            }
            $invoice_products_to_be_deleted[$i_p->invoice_id . ',' . $i_p->product_id] = 1;
        }

        if($product_flag) {
            //data to be updated in invoice table
            $invoice = Invoice::find("invoice_id = ?", $invoice_id);
            $invoice->customer_id = $_POST['customer_id'];
            $invoice->invoice_no = $_POST['invoice_no'];
            $invoice->invoice_date = $_POST['invoice_date'];
            $invoice->due_date = $_POST['due_date'];

            //updating in invoice table
            if ($invoice->update()) {
                //data to be inserted in invoice_product table
                $i = 0;
                foreach ($_POST['product_id'] as $product_id) {
                    $category_id = $_POST['category_id'][$i];
                    $invoice_product = new InvoiceProduct();
                    $invoice_product->invoice_id = $invoice_id;
                    $invoice_product->product_id = $product_id;
                    $cat = Category::find('category_id = ?', $category_id);
                    $invoice_product->product_rate = doubleval($_POST['product_rate'][$i]);
                    $invoice_product->product_quantity = doubleval($_POST['product_quantity'][$i]);
                    $invoice_product->unit = "gm";


                    //data to be removed from the invoice_product table if it is deleted while editing invoice
                    unset($invoice_products_to_be_deleted[$invoice_id . ',' . $product_id]);

//                    $gst_rate = CRUD::query("SELECT gst_rate from gst WHERE gst_id = (SELECT gst_id from categories WHERE category_id = 3 AND deleted = 0) AND deleted = 0");

//                    $gst_rate = CRUD::query("SELECT gst_rate FROM gst INNER JOIN (SELECT gst_id FROM categories WHERE category_id = 1 AND deleted = 0) AS categories ON gst.gst_id = categories.gst_id WHERE gst.deleted = 0");

                    $gst_rate = CRUD::query("SELECT gst_rate FROM gst INNER JOIN categories ON gst.gst_id = categories.gst_id WHERE categories.category_id = ? AND gst.deleted = 0 AND categories.deleted = 0", $category_id)->fetch()->gst_rate;

                    $amount = ($invoice_product->product_quantity * $invoice_product->product_rate);
                    $gst_amount = $amount * $gst_rate / 100;
                    $totalAmount += $amount + $gst_amount;

                    //data to be updated in the product table
                    $product = Product::find("product_id = ?", $product_id);
                    if ($invoice_product->product_quantity <= $product->product_quantity) {
                        $product->product_quantity -= $invoice_product->product_quantity;
                    } else {
                        throw new Exception('Invoice could not be created, as product quantity is not available');
                    }

                    if ($invoice_product->update() && $product->update()) {
                        $flag = true;
                    } else {
                        $flag = false;
                        break;
                    }
                    $i++;
                }
                foreach ($invoice_products_to_be_deleted as $key => $value)
                {
                    $invoice_product_to_delete_ids = explode(",", $key);
                    $invoice_product_to_delete = InvoiceProduct::find("invoice_id = ? AND product_id = ?",$invoice_product_to_delete_ids[0], $invoice_product_to_delete_ids[1]);
                    if(!$invoice_product_to_delete->delete()){
                        $flag = false;
                        break;
                    }
                }
                if ($flag) {
                    $invoice = Invoice::find("invoice_id = ?", $invoice_id);
                    $invoice->total_amount = $totalAmount;
                    $invoice->pending_amount = $totalAmount;
                    if ($invoice->update()) {
                        CRUD::commit();
                        setStatusAndMsg("success", "Invoice created successfully");
                    } else {
                        throw new Exception('Invoice cannot be created, please ensure values are correct.');
                    }
                } else {
                    CRUD::rollback();
                    setStatusAndMsg("error", "Invoice cannot be created");
                }
            } else {
                CRUD::rollback();
                setStatusAndMsg("error", "Invoice cannot be created");
            }
        }
    } catch (Exception $ex) {
        CRUD::rollback();
        setStatusAndMsg("error", $ex->getMessage());
    }
    //ending transactions
    CRUD::setAutoCommitOn(true);
}

if(isset($id)) {
    $invoice_to_edit = Invoice::find("invoice_id = ?", $id);
    $invoice_products_to_edit = InvoiceProduct::select("*", "invoice_id = ?", $id);

    ?>
    <div class="row">
        <div class="offset-1 col-md-10">
            <form action="" method="post" role="form" enctype="multipart/form-data">
                <h3>Edit Invoice - Invoice Details</h3>
                <hr>
                <input type="hidden" name="invoice_id" value="<?php echo $invoice_to_edit->invoice_id; ?>">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="invoice_date" data-toggle="tooltip" data-placement="right" title="">Invoice Date <i
                                    class="fa fa-question-circle"></i></label>
                        <input type="date" class="form-control" name="invoice_date" id="invoice_date"
                               value="<?php echo $invoice_to_edit->invoice_date; ?>">
                    </div>

                    <div class="form-group col-md-4 offset-1">
                        <label for="invoice_no" data-toggle="tooltip" data-placement="right" title="">Invoice No. <i
                                    class="fa fa-question-circle"></i></label>
                        <input type="text" class="form-control" name="invoice_no" id="invoice_no"
                               placeholder="Enter Invoice No. " value="<?php echo $invoice_to_edit->invoice_no; ?>">
                    </div>

                    <div class="form-group col-md-3 offset-1">
                        <label for="due_date" data-toggle="tooltip" data-placement="right" title="">Due Date <i
                                    class="fa fa-question-circle"></i></label>
                        <input type="date" class="form-control" name="due_date" id="due_date"
                               value="<?php echo $invoice_to_edit->due_date; ?>">
                    </div>
                </div>
                <h3>Customer Details</h3>
                <hr>
                <div class="form-group">
                    <label for="customer_id" data-toggle="tooltip" data-placement="right" title="">Select Supplier <i
                                class="fa fa-question-circle"></i></label>
                    <select name="customer_id" id="customer_id" class="form-control supplier selectize" required>
                        <option value="">Select Customer</option>
                        <?php
                        $result = Customer::select();
                        foreach ($result as $customer) {
                            if($customer->customer_id === $invoice_to_edit->customer_id)
                                $selected = "selected";
                            else
                                $selected = "";
                            echo "<option value='$customer->customer_id' $selected>$customer->customer_name</option>";
                        }
                        ?>
                    </select>
                </div>
                <?php
                $script_var = array();
                $i = 0;
                foreach ($invoice_products_to_edit->fetchAll() as $invoice_product){
                    $prod_id = $invoice_product->product_id;
                    $script_var[$i++] = array(Product::find("product_id = ?", $prod_id)->category_id, $prod_id, $invoice_product->product_quantity, $invoice_product->product_rate);
                }
                $script_var = json_encode($script_var);
                require_once('includes/pages/commons/add-product-details.php');
                ?>
                <button type="submit" name="edit_invoice" id="edit_invoice" class="btn btn-primary">Edit Invoice
                </button>
            </form>
        </div>
    </div>
    <?php
}
    ?>