<?php
require_once('db/models/Customer.class.php');
require_once('db/models/Invoice.class.php');
require_once('db/models/InvoiceProduct.class.php');

require_once('db/models/Product.class.php');
require_once('db/models/Category.class.php');
require_once 'constants.php';
require_once('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
if(isset($_GET['id'])) {
    try {
        //Starting transactions
        CRUD::setAutoCommitOn(false);
        $totalAmount = 0.0;
        $flag = true;
        $product_flag = true;

        $invoice_id = $_GET['id'];
        //first remove all products previously inserted (this purchase entry)
        $res = InvoiceProduct::select("*", "invoice_id = ?", $invoice_id);
        $invoice_products = $res->fetchAll();
        $invoice_products_count = $res->rowCount();
        $invoice_products_to_be_deleted = array();

        foreach ($invoice_products as $i_p) {
            $product = Product::find("product_id = ?", $i_p->product_id);
            $product->product_quantity += $i_p->product_quantity;
            if (!$product->update()) {
                $product_flag = false;
            }
            $invoice_products_to_be_deleted[$i_p->invoice_id . ',' . $i_p->product_id] = 1;
        }

        if ($product_flag) {
            $invoice = Invoice::find("invoice_id = ?", $invoice_id);
            if ($invoice->delete()) {
                CRUD::commit();
                setStatusAndMsg("success", "Invoice deleted successfully");
                redirect_to(VIEW_ALL_INVOICES);
            } else {
                CRUD::rollback();
                setStatusAndMsg("error", "Invoice cannot be created");
            }
        } else {
            CRUD::rollback();
            setStatusAndMsg("error", "Invoice cannot be created");
        }
    } catch (Exception $ex) {
        CRUD::rollback();
        setStatusAndMsg("error", $ex->getMessage());
    }
    //ending transactions
    CRUD::setAutoCommitOn(true);
}