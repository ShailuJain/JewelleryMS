<?php
require_once ('db/models/Payment.class.php');
require_once ('db/models/Purchase.class.php');
require_once ('db/models/Udhaari.class.php');
require_once ('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
if(isset($_GET['id']) && isset($_GET['p-of'])) {
    try {
        CRUD::setAutoCommitOn(false);

        //finding category object
        $payment_of = $_GET['p-of'];
        $payment = Payment::find("payment_id = ?", $_GET['id']);
        $payment_of_model = "";
        $payment_of_model_id = "";
        if ($payment_of === "purchases") {
            $payment_of_model = "Purchase";
            $payment_of_table = "purchases";
            $payment_of_model_id = "purchase_id";
            $redirect = VIEW_ALL_PAYMENTS_PURCHASE;
        }else if ($payment_of === "udhaari") {
            $payment_of_model = "Udhaari";
            $payment_of_table = "udhaari";
            $payment_of_model_id = "udhaari_id";
            $redirect = VIEW_ALL_PAYMENTS_UDHAARI;
        }
        $model = $payment_of_model::find("$payment_of_model_id = ?", $payment->fk_id);
        $model->pending_amount += $payment->payment_amount;
        if ($payment) {
            if ($payment->delete() && $model->update()) {
                CRUD::commit();
                setStatusAndMsg("success", "Payment deleted successfully");
                redirect_to($redirect);
            }else{
                setStatusAndMsg("error", "Payment could be deleted.");
            }
        } else {
            setStatusAndMsg("error", "Payment do not exists");
        }
    } catch (Exception $ex) {
        setStatusAndMsg("error", "Something went wrong");
    }
    CRUD::setAutoCommitOn(true);
}