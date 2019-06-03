<?php
require_once('db/models/Purchase.class.php');
require_once('db/models/Supplier.class.php');
require_once('db/models/Product.class.php');
require_once('db/models/Category.class.php');
require_once 'constants.php';
require_once('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
if (isset($_GET['id'])) {
    try {
        $purchase_id = $_GET['id'];
        $purchase = Purchase::find("purchase_id = ?", $purchase_id);
        if ($purchase->delete()) {
            setStatusAndMsg("success", "Purchase deleted successfully");
            redirect_to(VIEW_ALL_PURCHASES);
        } else {
            setStatusAndMsg("error", "Purchase cannot be deleted");
        }
    } catch (Exception $ex) {
        setStatusAndMsg("error", $ex->getMessage());
    }
}