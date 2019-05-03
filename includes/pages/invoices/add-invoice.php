<?php
require_once('db/models/Customer.class.php');
require_once('db/models/Invoice.class.php');
require_once('db/models/InvoiceProduct.class.php');

require_once('db/models/Product.class.php');
require_once('db/models/Category.class.php');
require_once 'constants.php';
require_once('helpers/redirect-helper.php');
if (isset($_POST[ADD_INVOICE])) {
    try {
        //Starting transactions
        CRUD::setAutoCommitOn(false);
        $totalAmount = 0.0;
        $flag = true;

        //data to be inserted in invoice table
        $invoice = new Invoice();
        $invoice->customer_id = $_POST['customer_id'];
        $invoice->invoice_no = 'INVSJ-' . $_POST['invoice_no'];
        $invoice->invoice_date = $_POST['invoice_date'];
        $invoice->due_date = $_POST['due_date'];

        //inserting in invoice table
        if ($invoice->insert()) {
            //data to be inserted in invoice_product table
            $i = 0;
            $invoice_id = CRUD::lastInsertId();
            $invoice_product = "";
            foreach ($_POST['product_id'] as $product_id) {
                $category_id = $_POST['category_id'][$i];
                $invoice_product = new InvoiceProduct();
                $invoice_product->invoice_id = $invoice_id;
                $invoice_product->product_id = $product_id;
                $cat = Category::find('category_id = ?', $category_id);
                $invoice_product->product_rate = doubleval($_POST[str_replace(" ", "_", $cat->category_name)]);
                $invoice_product->product_quantity = doubleval($_POST['product_quantity'][$i]);
                $invoice_product->unit = "gm";


//                    $gst_rate = CRUD::query("SELECT gst_rate from gst WHERE gst_id = (SELECT gst_id from categories WHERE category_id = 3 AND deleted = 0) AND deleted = 0");

//                    $gst_rate = CRUD::query("SELECT gst_rate FROM gst INNER JOIN (SELECT gst_id FROM categories WHERE category_id = 1 AND deleted = 0) AS categories ON gst.gst_id = categories.gst_id WHERE gst.deleted = 0");

                $gst_rate = CRUD::query("SELECT gst_rate FROM gst INNER JOIN categories ON gst.gst_id = categories.gst_id WHERE categories.category_id = ? AND gst.deleted = 0 AND categories.deleted = 0", $category_id)->fetch()->gst_rate;

                $amount = ($invoice_product->product_quantity * $invoice_product->product_rate);
                $gst_amount = $amount * $gst_rate / 100;
                $totalAmount += $amount + $gst_amount;

                //data to be updated in the product table
                $product = Product::find("product_id = ?", $product_id);
                if($invoice_product->product_quantity <= $product->product_quantity){
                    $product->product_quantity -= $invoice_product->product_quantity;
                }else{
                    throw new Exception('Invoice could not be created, as product quantity is not available');
                }

                if ($invoice_product->insert() && $product->update()) {
                    $flag = true;
                } else {
                    $flag = false;
                    break;
                }
                $i++;
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
    } catch (Exception $ex) {
        CRUD::rollback();
        setStatusAndMsg("error", $ex->getMessage());
    }
    //ending transactions
    CRUD::setAutoCommitOn(true);
}
?>
<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <h3>New Invoice - Invoice Details</h3>
            <hr>
            <div class="form-row">

                <div class="form-group col-md-3">
                    <label for="invoice_date" data-toggle="tooltip" data-placement="right" title="">Invoice Date <i
                                class="fa fa-question-circle"></i></label>
                    <input type="date" class="form-control" name="invoice_date" id="invoice_date" value="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="form-group col-md-4 offset-1">
                    <label for="invoice_no" data-toggle="tooltip" data-placement="right" title="">Invoice No. <i
                                class="fa fa-question-circle"></i></label>
                    <input type="number" class="form-control" name="invoice_no" id="invoice_no"
                           placeholder="Enter Invoice No. ">
                </div>

                <div class="form-group col-md-3 offset-1">
                    <label for="due_date" data-toggle="tooltip" data-placement="right" title="">Due Date <i
                                class="fa fa-question-circle"></i></label>
                    <input type="date" class="form-control" name="due_date" id="due_date" value="">
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
                        echo "<option value='$customer->customer_id'>$customer->customer_name</option>";
                    }
                    ?>
                </select>
            </div>
            <?php
            require_once('includes/pages/commons/add-product-details.php');
            ?>
            <button type="submit" name="add_invoice" id="add_invoice" class="btn btn-primary">Add Invoice</button>
        </form>
    </div>
</div>
