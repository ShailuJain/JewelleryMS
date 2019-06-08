<?php
require_once('db/models/Payment.class.php');
require_once('db/models/Invoice.class.php');
require_once 'constants.php';
require_once('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
if (isset($_POST[EDIT_PAYMENT])) {
    try {
        $arr = $_POST;
        unset($arr[EDIT_PAYMENT]);
        $arrKeys = array_keys($arr);

        $payment_id = $_GET['id'];
        CRUD::setAutoCommitOn(false);

        //creating a new product object and adding the fields.
        $payment = new Payment();

        $payment = Payment::find("payment_id = ?", $payment_id);
        $invoice = Invoice::find("invoice_id= ?", $arr['invoice_id']);
        $amount =$payment->payment_amount ;
        $invoice->pending_amount += $amount;
        $invoice->update();

        if ($invoice) {
            foreach ($arrKeys as $item) {
                $payment->$item = $arr[$item];

            }
            $flag =0;
            if(!$payment->update()) {
                $flag = 0;
                setStatusAndMsg("error", "payment could not be updated");
            }
            if ($arr['payment_amount'] <= $invoice->pending_amount) {
                $invoice->pending_amount = $invoice->pending_amount - $arr['payment_amount'];
                if($invoice->update())
                    $flag = 1;
                else {
                    $flag = 0;
                    setStatusAndMsg("error", "invoice could not be updated");
                }
            }else{
                $flag = 0;
                setStatusAndMsg("error", "invoice could not be updated");
            }

            if ($flag)
            {
                CRUD::commit();
                setStatusAndMsg("success","Payment added successfully");
            }else
            {
                CRUD::rollback();
                setStatusAndMsg("error","payment could not be inserted");
            }
        } else {
            setStatusAndMsg("error", "Invoice Number does not exists");
        }

    } catch (Exception $ex) {
        setStatusAndMsg("error", "Something went wrong");
    }

    CRUD::setAutoCommitOn(true);
}
if (isset($id)) {
    $payment_to_edit = Payment::find("payment_id = ?", $id);
    ?>
    <div class="row">
        <div class="offset-1 col-md-10">
            <form id="form" action="" method="post" role="form" enctype="multipart/form-data">
                <h3>Edit Payment</h3>
                <hr>
                <input type="hidden" name="payment_id" value="<?php echo $payment_to_edit->payment_id; ?>">
                <div class="form-group">
                    <label for="invoice_id" data-toggle="tooltip" data-placement="right" title="">Invoice Number <i
                                class="fa fa-question-circle"></i></label>
                    <select name="invoice_id" id="invoice_id" class="form-control" required readonly>
                        <?php

                        $invoice = Invoice::find("invoice_id = ?", $payment_to_edit->invoice_id);
                        echo "<option value='$payment_to_edit->invoice_id' selected>$invoice->invoice_no</option>";
                        ?>
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="payment_amount" data-toggle="tooltip" data-placement="right" title="">Payment Amount
                            <i
                                    class="fa fa-question-circle"></i></label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="payment_amount" id="payment_amount" required
                                   maxlength="" aria-describedby="per-rs"
                                   value="<?php echo $payment_to_edit->payment_amount; ?>">
                            <div class="input-group-append">
                                <span class="input-group-text" id="per-rs">₹</span>
                            </div>
                        </div>

                    </div>
                    <div class="form-group col-md-6">
                        <label for="payment_mode" data-toggle="tooltip" data-placement="right" title="">Payment Mode<i
                                    class="fa fa-question-circle"></i></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="payment_mode" id="payment_mode"
                                   placeholder="Enter Payment Mode" required min="0"
                                   value="<?php echo $payment_to_edit->payment_mode; ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="payment_date" data-toggle="tooltip" data-placement="right" title="">Payment Date<i
                                class="fa fa-question-circle"></i></label>
                    <input type="date" class="form-control" name="Payment_date" id="payment_date" required
                           value="<?php echo $payment_to_edit->payment_date; ?>">
                </div>

                <button type="submit" name="edit_payment" id="edit_payment" class="btn btn-primary">Edit Payment</button>
            </form>
        </div>
    </div>
    <?php
}
?>