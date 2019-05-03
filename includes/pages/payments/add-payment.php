<?php
require_once ('db/models/Payment.class.php');
require_once ('db/models/Invoice.class.php');
require_once 'constants.php';
require_once ('helpers/redirect-helper.php');
if(isset($_POST[ADD_PAYMENT])) {
    try
    {
        $arr = $_POST;
        unset($arr[ADD_PAYMENT]);
        $arrKeys = array_keys($arr);

        //creating a new payment object and adding the fields.
        $payment = new Payment();
        $invoice = Invoice::find("invoice_id= ?", $arr['invoice_id']);
        if($invoice){
            foreach ($arrKeys as $item) {
                $payment->$item = $arr[$item];
            }
            if($payment->insert()){
                setStatusAndMsg("success","Payment added successfully");
            }
        }else{
            setStatusAndMsg("error","Invoice Number does not exists");
        }

    }
    catch (Exception $ex)
    {
        setStatusAndMsg("error","Something went wrong");
    }
}
?>
<div class="row">
    <div class="offset-1 col-md-10">
        <form id="form" action="" method="post" role="form" enctype="multipart/form-data">
            <h3>Add New Payment</h3>
            <hr>
            <div class="form-group">
                <label for="invoice_id" data-toggle="tooltip" data-placement="right" title="" >Invoice Number <i class="fa fa-question-circle"></i></label>
                <select name="invoice_id" id="invoice_id" class="form-control selectize" required>
                    <option value="">Select Invoice Number</option>
                    <?php
                    $result = Invoice::select();
                    foreach ($result as $pay){
                        echo "<option value='$pay->invoice_id'>$pay->invoice_no</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="payment_amount" data-toggle="tooltip" data-placement="right" title="" >Payment Amount <i class="fa fa-question-circle"></i></label>
                    <div class="input-group-append">
                        <input type="number" class="form-control" name="payment_amount" id="payment_amount" placeholder="Enter Payment Amount" aria-describedby="per-rs" required maxlength="15" pattern="[0-9]" minlength="3">
                        <span class="input-group-text" id="per-rs">₹</span>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="payment_mode" data-toggle="tooltip" data-placement="right" title="" >Payment Mode <i class="fa fa-question-circle"></i></label>
                    <input type="text" class="form-control" name="payment_mode" id="payment_mode" placeholder="Enter Payment Mode"required>
                </div>
            </div>

            <div class="form-group">
                <label for="additional_specifications" data-toggle="tooltip" data-placement="right" title="" >Date of Payment<i class="fa fa-question-circle"></i></label>
                <input type="date" class="form-control" name="Payment_date" id="payment_date" placeholder="Enter Date Of Payment" required>
            </div>

            <button type="submit" name="<?php echo ADD_PAYMENT; ?>" id="<?php echo ADD_PAYMENT; ?>" class="btn btn-primary">Add Payment</button>
        </form>
    </div>
</div>