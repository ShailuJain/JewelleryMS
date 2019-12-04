<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 12/1/2019
 * Time: 10:49 PM
 */
require_once ('db/models/Udhaari.class.php');
require_once ('db/models/UdhaariTransaction.class.php');
require_once ('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
if(isset($_GET['id'])) {
    try {
        $udhaari_transaction_id = $_GET['id'];
        CRUD::setAutoCommitOn(false);
        $udhaari_transaction_row = UdhaariTransaction::findNoDeletedColumn("udhaari_transaction_id = ?", $udhaari_transaction_id);
        $udhaari_id = $udhaari_transaction_row->udhaari_id;
        $udhaari_transaction_amount = $udhaari_transaction_row->udhaari_amount;

        $udhaari = Udhaari::find("udhaari_id = ?", $udhaari_id);

        //udhaari_amount of udhaari table - udhaari_amount of udhaari_transactions table
        $difference = $udhaari->udhaari_amount - $udhaari_transaction_amount;

        //udhaari_amount of udhaari table - udhaari_amount of udhaari_transactions table
        $updated_pending_amount = $udhaari->pending_amount - $udhaari_transaction_amount;


        //total payment made calcualted from udhaari_amount of udhaar table - pending_amount of udhaari_table
        $paymentMade = $udhaari->udhaari_amount - $udhaari->pending_amount;

        if($paymentMade <= $difference){

            //UPDATING THE ROW IN UDHAARI TABLE
            $udhaari->udhaari_amount = $difference;

            //UPDATING THE pending_amount IN UDHAARI TABLE
            $udhaari->pending_amount = $updated_pending_amount;
            $udhaari->update();

            //DELETING THE ROW FROM UDHAARI TRANSACTION
            $udhaari_transaction_row->delete();

            CRUD::commit();
            setStatusAndMsg("success", "Udhaari transaction was successfully deleted.");
            redirect_to(VIEW_UDHAARI_WITH_ID . $udhaari_id);
        }else{
            CRUD::rollback();
            setStatusAndMsg("error", "Udhaari transaction could not be deleted.");
            redirect_to(VIEW_UDHAARI_WITH_ID . $udhaari_id);
        }
    } catch (Exception $ex) {
        setStatusAndMsg("error", "Something went wrong");
        redirect_to(VIEW_ALL_UDHAARIS);
    }

    CRUD::setAutoCommitOn(true);
}