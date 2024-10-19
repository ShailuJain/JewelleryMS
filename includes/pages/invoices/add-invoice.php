<?php
require_once('db/models/Customer.class.php');
require_once('db/models/Invoice.class.php');
require_once('db/models/InvoiceProduct.class.php');
require_once ('db/models/Shop.class.php');
require_once('db/models/Product.class.php');
require_once('db/models/Category.class.php');
require_once 'constants.php';
require_once('helpers/redirect-helper.php');
require_once('helpers/InvoiceTemplate.class.php');
if (isset($_POST[ADD_INVOICE])) {
    try {
        //Starting transactions
        CRUD::setAutoCommitOn(false);
        $totalAmount = 0.0;
        $flag = true;

        //data to be inserted in invoice table
        $invoice = new Invoice();
        $invoice->customer_id = $_POST['customer_id'];
        $invoice->invoice_no = $_POST['invoice_no'];
        $invoice->invoice_date = $_POST['invoice_date'];

        //inserting in invoice table
        if ($invoice->insert()) {
            //data to be inserted in invoice_product table
            $i = 0;
            $invoice_id = CRUD::lastInsertId();
            $invoice_product = "";
            $j = 0;
            foreach ($_POST['product_id'] as $product_id) {
                $category_id = $_POST['category_id'][$i];
                $invoice_product = new InvoiceProduct();
                $invoice_product->invoice_id = $invoice_id;
                $invoice_product->product_id = $product_id;
                $cat = Category::find('category_id = ?', $category_id);
                $invoice_product->product_rate = doubleval($_POST['product_rate'][$i]);
                $invoice_product->making_charges = doubleval($_POST['making_charges'][$i]);


//                    $gst_rate = CRUD::query("SELECT gst_rate from gst WHERE gst_id = (SELECT gst_id from categories WHERE category_id = 3 AND deleted = 0) AND deleted = 0");

//                    $gst_rate = CRUD::query("SELECT gst_rate FROM gst INNER JOIN (SELECT gst_id FROM categories WHERE category_id = 1 AND deleted = 0) AS categories ON gst.gst_id = categories.gst_id WHERE gst.deleted = 0");

                $gst_rate = CRUD::query("SELECT gst_rate FROM gst INNER JOIN categories ON gst.gst_id = categories.gst_id WHERE categories.category_id = ? AND gst.deleted = 0 AND categories.deleted = 0", $category_id)->fetch()->gst_rate;


                //data to be updated in the product table
                $product = Product::find("product_id = ?", $product_id);
                $products[$j++] = $product;
                $product->deleted = 1;


                $amount = ($product->product_quantity * ($invoice_product->product_rate + $invoice_product->making_charges));
                $gst_amount = $amount * $gst_rate / 100;
                $totalAmount += $amount + $gst_amount;

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
                if ($invoice->update()) {
                    CRUD::commit();
                    redirect_to("invoices.php?src=view-invoice&id={$invoice_id}");
                    setStatusAndMsg("success", "Invoice created successfully");
                } else {
                    throw new Exception('Invoice cannot be created, please ensure values are correct.');
                }
            } else {
                CRUD::rollback();
                setStatusAndMsg("error", "Invoice cannot be created, products mismatched");
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
try{
    $inv_no_res = CRUD::query("SELECT invoice_id FROM invoices ORDER BY invoice_id DESC LIMIT 1");
    if($inv_no_res->rowCount() > 0){
        $inv_no = $inv_no_res->fetch()->invoice_id;
    }else{
        $inv_no = 0;
    }
}catch (Exception $e){
    $inv_no = 0;
}
?>
<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <h3>New Invoice - Invoice Details<span class="float-right"><a href="<?php require_once ('helpers/redirect-constants.php'); echo VIEW_ALL_INVOICES; ?>" class='btn btn-info text-white'>View All Invoices <i class='fa fa-eye'></i></a></span></h3>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="invoice_no" data-toggle="tooltip" data-placement="right" title="">Invoice No. <i
                                class="fa fa-question-circle"></i></label>
                    <input type="text" class="form-control" name="invoice_no" id="invoice_no"
                           placeholder="Enter Invoice No. " required value="INVSJ-<?php echo $inv_no+1; ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="invoice_date" data-toggle="tooltip" data-placement="right" title="">Invoice Date <i
                                class="fa fa-question-circle"></i></label>
                    <input type="date" class="form-control" name="invoice_date" id="invoice_date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
            </div>
            <h3>Customer Details</h3>
            <hr>
            <div class="form-group">
                <label for="customer_id" data-toggle="tooltip" data-placement="right" title="">Select Customer <i
                            class="fa fa-question-circle"></i></label>
                <span class="border-left-warning pl-3 pr-3 float-right">
                    New Customer? <a href="customers.php?src=add-customer" class="btn btn-outline-primary ml-2 pl-1 pr-1 pt-0 pb-0">Add Customer</a>
                </span>
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
            require_once('includes/pages/commons/add-product-details-invoice.php');
            ?>
            <button type="submit" name="add_invoice" id="add_invoice" class="btn btn-primary">Add Invoice</button>
        </form>
    </div>
</div>
