<?php
require_once('db/models/Purchase.class.php');
require_once('db/models/Supplier.class.php');
require_once('db/models/PurchaseProduct.class.php');
require_once('db/models/Product.class.php');
require_once('db/models/Category.class.php');
require_once 'constants.php';
require_once('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
if (isset($_GET['id'])) {
    try {
        //Starting transactions
        CRUD::setAutoCommitOn(false);
        $totalAmount = 0.0;
        $flag = true;
        $product_flag = true;

        $purchase_id = $_GET['id'];
        //first remove all products previously inserted (this purchase entry)
        $res = PurchaseProduct::select("*", "purchase_id = ?", $purchase_id);
        $purchase_products = $res->fetchAll();
        $purchase_products_count = $res->rowCount();
        $purchase_products_to_be_deleted = array();

        foreach ($purchase_products as $p_p) {
            $product = Product::find("product_id = ?", $p_p->product_id);
            if ($p_p->product_quantity <= $product->product_quantity) {
                $product->product_quantity -= $p_p->product_quantity;
            } else {
                throw new Exception('Purchase could not be deleted, as product quantity is not available');
            }
            if (!$product->update()) {
                $product_flag = false;
            }
            $purchase_products_to_be_deleted[$p_p->purchase_id . ',' . $p_p->product_id] = 1;
        }

        if ($product_flag) {
            $purchase = Purchase::find("purchase_id = ?", $purchase_id);
            if ($purchase->delete()) {
                CRUD::commit();
                setStatusAndMsg("success", "Purchase deleted successfully");
                redirect_to(VIEW_ALL_PURCHASES);
            } else {
                CRUD::rollback();
                setStatusAndMsg("error", "Purchase cannot be deleted");
            }
        } else {
            CRUD::rollback();
            setStatusAndMsg("error", "Purchase cannot be deleted, as products were not updated");
        }
    } catch (Exception $ex) {
        CRUD::rollback();
        setStatusAndMsg("error", $ex->getMessage());
    }
    //ending transactions
    CRUD::setAutoCommitOn(true);
}