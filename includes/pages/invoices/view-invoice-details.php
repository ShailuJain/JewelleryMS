<?php
require_once('db/models/Customer.class.php');
require_once('db/models/Invoice.class.php');
require_once('db/models/InvoiceProduct.class.php');

require_once('db/models/Product.class.php');
require_once('db/models/Category.class.php');
require_once 'constants.php';
require_once('helpers/redirect-helper.php');
if (isset($id)) {
    $invoice_to_edit = Invoice::find("invoice_id = ?", $id);
    $invoice_products_to_edit = InvoiceProduct::select("*", "invoice_id = ?", $id);
    ?>
    <div class="row">
        <div class="offset-1 col-md-10">
            <h3>Invoice Details</h3>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="invoice_date" data-toggle="tooltip" data-placement="right" title="">Invoice Date <i
                                class="fa fa-question-circle"></i></label>
                    <input disabled type="date" class="form-control" name="invoice_date" id="invoice_date"
                           value="<?php echo $invoice_to_edit->invoice_date; ?>">
                </div>

                <div class="form-group col-md-4 offset-1">
                    <label for="invoice_no" data-toggle="tooltip" data-placement="right" title="">Invoice No. <i
                                class="fa fa-question-circle"></i></label>
                    <input disabled type="text" class="form-control" name="invoice_no" id="invoice_no"
                           placeholder="Enter Invoice No. " value="<?php echo $invoice_to_edit->invoice_no; ?>">
                </div>

                <div class="form-group col-md-3 offset-1">
                    <label for="due_date" data-toggle="tooltip" data-placement="right" title="">Due Date <i
                                class="fa fa-question-circle"></i></label>
                    <input disabled type="date" class="form-control" name="due_date" id="due_date"
                           value="<?php echo $invoice_to_edit->due_date; ?>">
                </div>
            </div>

            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="heading" data-toggle="collapse" data-target="#customerCollapse"
                         aria-expanded="true" aria-controls="customerCollapse">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button">
                                Customer Details
                            </button>
                        </h5>
                    </div>
                    <div id="customerCollapse" class="collapse" aria-labelledby="heading">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="customer_name" data-toggle="tooltip" data-placement="right" title="">Customer Name</label>
                                <?php
                                $customer = Customer::find("customer_id = ?", $invoice_to_edit->customer_id);
                                echo "<input value='$customer->customer_name' disabled type='text' class='form-control' name='customer_name' id='customer_name'>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse"
                         data-target="#productCollapse"
                         aria-expanded="true" aria-controls="productCollapse">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button">
                                Product Details
                            </button>
                        </h5>
                    </div>
                    <?php
                    $model_name = "Invoice";
                    require_once "db/models/{$model_name}.class.php";
                    $rs = Invoice::viewProductDetails($id);
                    //This array will store the table headers for the columns we are selecting from database
                    $column_names_as = array(
                        "category_name" => "Category Name",
                        "gst_rate" => "GST Rate",
                        "product_name" => "Product Name",
                        "product_quantity" => "Product Quantity",
                    );
                    ?>
                    <div id="productCollapse" class="collapse" aria-labelledby="headingOne">
                        <div class="card-body">
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
                                    while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr>";
                                        foreach ($column_names as $column_name) {
                                            if (empty($row[$column_name])) {
                                                echo "<td>NULL</td>";
                                            } else {
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
                <div class="card">
                    <div class="card-header" id="headingTwo" data-toggle="collapse"
                         data-target="#paymentCollapse"
                         aria-expanded="true" aria-controls="paymentCollapse">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button">
                                Payment Details
                            </button>
                        </h5>
                    </div>
                    <?php
                    $rs = Invoice::viewPaymentDetails($id);
                    //This array will store the table headers for the columns we are selecting from database
                    $column_names_as = array(
                        "payment_id" => "Payment Id",
                        "payment_amount" => "Payment Amount",
                        "payment_date" => "Payment Date",
                        "payment_mode" => "Payment Mode",
                    );
                    ?>
                    <div id="paymentCollapse" class="collapse" aria-labelledby="headingTwo">
                        <div class="card-body">
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
                                    while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr>";
                                        foreach ($column_names as $column_name) {
                                            if (empty($row[$column_name])) {
                                                echo "<td>NULL</td>";
                                            } else {
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
            </div>
        </div>
    </div>
    <?php
}
?>