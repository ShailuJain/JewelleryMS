<?php
require_once ('db/models/Payment.class.php');
require_once ('db/models/Invoice.class.php');
require_once ('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
if(isset($_GET['id'])) {
    try {
        $payment_id = $_GET['id'];
        CRUD::setAutoCommitOn(false);

        //finding category object
        $payment = Payment::find("payment_id = ?", $payment_id);
        $invoice = Invoice::find("invoice_id= ?", $payment->invoice_id);
        $invoice->pending_amount += $payment->payment_amount;
        if ($payment) {
            if ($payment->delete()) {
                CRUD::commit();
                setStatusAndMsg("success", "Payment deleted successfully");
                redirect_to(VIEW_ALL_PAYMENTS);
            }
        } else {
            setStatusAndMsg("error", "Payment do not exists");
        }
    } catch (Exception $ex) {
        setStatusAndMsg("error", "Something went wrong");
    }

    CRUD::setAutoCommitOn(true);
}