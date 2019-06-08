<?php
require_once('db/models/Payment.class.php');
require_once('db/models/Invoice.class.php');
require_once 'constants.php';
require_once('helpers/redirect-helper.php');
if (isset($_POST[ADD_PAYMENT])) {
    try {
        $arr = $_POST;
        unset($arr[ADD_PAYMENT]);
        $arrKeys = array_keys($arr);
        CRUD::setAutoCommitOn(false);
        //creating a new payment object and adding the fields.

        $payment = new Payment();
        $payment_of_model = "";
        $payment_of_model_id = "";
        if(isset($arr['purchase_no'])){
            $payment_of_model = "Purchase";
            $payment_of_model_id = "purchase_id";
            unset($arr['purchase_no']);
        }else if (isset($arr['udhaari_no'])){
            $payment_of_model = "Udhaari";
            $payment_of_model_id = "udhaari_id";
            unset($arr['udhaari_no']);
        }
        $payment_of = $payment_of_model::find("$payment_of_model_id = ?", $arr[$payment_of_model_id]);
        if ($payment_of) {
            foreach ($arrKeys as $item) {
                $payment->$item = $arr[$item];
            }
            $flag = 0;
            if ($payment->insert()) {
                $flag = 1;
                if ($arr['payment_amount'] <= $payment_of->pending_amount) {
                    $payment_of->pending_amount = $payment_of->pending_amount - $arr['payment_amount'];
                    if ($payment_of->update())
                        $flag = 1;
                    else {
                        $flag = 0;
                        setStatusAndMsg("error", "$payment_of_model could not be updated");
                    }
                } else {
                    $flag = 0;
                    setStatusAndMsg("error", "Payment amount is greater than pending amount");
                }
            }
            if ($flag) {
                CRUD::commit();
                setStatusAndMsg("success", "Payment added successfully");
            } else {
                CRUD::rollback();
            }
        } else {
            setStatusAndMsg("error", "Invoice Number does not exists");
        }
    } catch (Exception $ex) {
        setStatusAndMsg("error", "Something went wrong");
    }
    CRUD::setAutoCommitOn(true);
}
if (isset($payment_of)) {
    ?>
    <div class="row">
    <div class="offset-1 col-md-10">
    <form id="form" action="" method="post" role="form" enctype="multipart/form-data">
    <h3>Add New Payment</h3>
    <hr>
    <div class="form-group">
    <?php
    if (isset($id)) {
        echo "<input type='hidden' value='$id' name='fk_id'>";
        if ($payment_of === "purchase") {
            require_once ('db/models/Purchase.class.php');
            $value = Purchase::find("purchase_id = ?", $id);
            echo<<<LABEL
        <label for="purchase_no" data-toggle="tooltip" data-placement="right" title="">Purchase Number <i
                    class="fa fa-question-circle"></i></label>
        <input type="text" readonly name="purchase_no" id="purchase_no" class="form-control" required value='$value->purchase_no'>
LABEL;
        }else if ($payment_of === "udhaari") {
            require_once ('db/models/Udhaari.class.php');
            $value = Purchase::find("udhaari_id = ?", $id);
            echo<<<LABEL
        <label for="udhaari_no" data-toggle="tooltip" data-placement="right" title="">Udhaari Number <i
                    class="fa fa-question-circle"></i></label>
        <input type="text" readonly name="udhaari_no" id="udhaari_no" class="form-control" required value='$value->udhaari_no'>
LABEL;

        }
        ?>

        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="payment_amount" data-toggle="tooltip" data-placement="right" title="">Payment Amount <i
                            class="fa fa-question-circle"></i></label>
                <div class="input-group-append">
                    <input type="number" class="form-control" name="payment_amount" id="payment_amount" min="1"
                           placeholder="Enter Payment Amount" aria-describedby="per-rs" required>
                    <span class="input-group-text" id="per-rs">₹</span>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="payment_mode" data-toggle="tooltip" data-placement="right" title="">Payment Mode <i
                            class="fa fa-question-circle"></i></label>
                <input type="text" class="form-control" name="payment_mode" id="payment_mode"
                       placeholder="Enter Payment Mode" required>
            </div>
        </div>

        <div class="form-group">
            <label for="additional_specifications" data-toggle="tooltip" data-placement="right" title="">Date of Payment<i
                        class="fa fa-question-circle"></i></label>
            <input type="date" class="form-control" name="payment_date" id="payment_date"
                   placeholder="Enter Date Of Payment" required>
        </div>

        <button type="submit" name="<?php echo ADD_PAYMENT; ?>" id="<?php echo ADD_PAYMENT; ?>" class="btn btn-primary">
            Add Payment
        </button>
        </form>
        </div>
        </div>
        <?php
    }
}
?>