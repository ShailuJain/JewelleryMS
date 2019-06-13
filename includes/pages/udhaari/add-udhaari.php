<?php
require_once('db/models/Udhaari.class.php');
require_once('db/models/Customer.class.php');
require_once 'constants.php';
require_once('helpers/redirect-helper.php');
if (isset($_POST[ADD_UDHAARI])) {
    try {
        $arr = $_POST;
        unset($arr[ADD_UDHAARI]);
        $arrKeys = array_keys($arr);

        $udhaari = new Udhaari();

        foreach ($arrKeys as $item) {
            $udhaari->$item = $arr[$item];
        }
        if ($udhaari->udhaari_amount > 0) {
            $udhaari->pending_amount = $udhaari->udhaari_amount;
            if ($udhaari->insert()) {
                setStatusAndMsg("success", "Udhaari added successfully");
            } else {
                setStatusAndMsg("error", "udhaari could not be created");
            }
        }else{
            setStatusAndMsg("error", "Amount must be greater than 0.");
        }
    } catch (Exception $ex) {
        setStatusAndMsg("error", "Something went wrong");
    }
}
try {
    $udhaari_no_res = CRUD::query("SELECT udhaari_id FROM udhaari ORDER BY udhaari_id DESC LIMIT 1");
    if ($udhaari_no_res->rowCount() > 0) {
        $udhaari_no = $udhaari_no_res->fetch()->udhaari_id;
    } else {
        $udhaari_no = 0;
    }
} catch (Exception $e) {
    $udhaari_no = 0;
}
?>
<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <h3>New Udhaari<span class="float-right"><a href="<?php require_once('helpers/redirect-constants.php');
                    echo VIEW_ALL_UDHAARIS; ?>" class='btn btn-info text-white'>View All Udhaaris <i
                                class='fa fa-eye'></i></a></span></h3>
            <hr>
            <div class="form-row">

                <div class="form-group col-md-3">
                    <label for="udhaari_date" data-toggle="tooltip" data-placement="right" title="">Udhaari Date <i
                                class="fa fa-question-circle"></i></label>
                    <input type="date" class="form-control" name="udhaari_date" id="udhaari_date"
                           value="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <div class="form-group col-md-4 offset-1">
                    <label for="udhaari_no" data-toggle="tooltip" data-placement="right" title="">Udhaari No. <i
                                class="fa fa-question-circle"></i></label>
                    <input type="text" class="form-control" name="udhaari_no" id="udhaari_no"
                           placeholder="Enter udhaari No. " required value="UDRSJ-<?php echo $udhaari_no + 1; ?>">
                </div>

                <div class="form-group col-md-3 offset-1">
                    <label for="due_date" data-toggle="tooltip" data-placement="right" title="">Due Date <i
                                class="fa fa-question-circle"></i></label>
                    <input type="date" class="form-control" name="due_date" id="due_date" value="" required min="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>


            <div class="form-row mt-3">
                <div class="form-group col-md-8">
                    <label style="width: 100%;" for="customer_id" data-toggle="tooltip" data-placement="right" title="">Select
                        Customer <i class="fa fa-question-circle"></i><span
                                class="border-left-warning pl-3 pr-3 float-right">
                    New Customer? <a href="customers.php?src=add-customer"
                                     class="btn btn-outline-primary ml-2 pl-1 pr-1 pt-0 pb-0">Add Customer</a>
                </span></label>
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
                <div class="form-group col-md-4">
                    <label for="udhaari_amount" data-toggle="tooltip" data-placement="right" title="">Total Udhaari <i
                                class="fa fa-question-circle"></i></label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="udhaari_amount" id="udhaari_amount"
                               placeholder="Enter total udhaari" aria-describedby="rs" required step="any" min="1">
                        <div class="input-group-append">
                            <span class="input-group-text" id="rs">&#8377;</span>
                        </div>
                    </div>
                </div>
                <!--                <div class="form-group col-md-4">-->
                <!--                    <label for="total_purchase_amount" data-toggle="tooltip" data-placement="right" title="" >Total Amount <i class="fa fa-question-circle"></i></label>-->
                <!--                    <input name="total_purchase_amount" id="total_purchase_amount" class="form-control" required placeholder="Enter total purchase amount">-->
                <!--                </div>-->
            </div>
            <button type="submit" name="add_udhaari" id="add_udhaari" class="btn btn-primary">Add udhaari</button>
        </form>
    </div>
</div>
