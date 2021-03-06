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

        foreach ($invoice_products as $i_p) {
            $product = Product::findNoDeletedColumn("product_id = ?", $i_p->product_id);
            $product->deleted = 0;
            if (!$product->update()) {
                $product_flag = false;
            }
        }

        if ($product_flag) {
            $invoice = Invoice::find("invoice_id = ?", $invoice_id);
            if ($invoice->delete()) {
                CRUD::commit();
                setStatusAndMsg("success", "Invoice deleted successfully");
                redirect_to(VIEW_ALL_INVOICES);
            } else {
                CRUD::rollback();
                setStatusAndMsg("error", "Invoice contains payments or cannot be deleted");
                redirect_to(VIEW_ALL_INVOICES);
            }
        } else {
            CRUD::rollback();
            setStatusAndMsg("error", "Invoice cannot be deleted due to products");
            redirect_to(VIEW_ALL_INVOICES);
        }
    } catch (Exception $ex) {
        CRUD::rollback();
        setStatusAndMsg("error", $ex->getMessage());
    }
    //ending transactions
    CRUD::setAutoCommitOn(true);
}