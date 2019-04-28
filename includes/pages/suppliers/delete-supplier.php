<?php
/**
 * Created by PhpStorm.
 * User: sanjay
 * Date: 19-03-2019
 * Time: 08:23 PM
 */
require_once ('db/models/Supplier.class.php');
require_once ('helpers/redirect-helper.php');
require_once ('helpers/redirects.php');
if(isset($_GET['id'])) {
    try {
        $supplier_id = $_GET['id'];

        //finding category object
        $supplier = Supplier::find("$supplier_id = ?", $supplier_id);
        if ($supplier) {
            if ($supplier->delete()) {
                setStatusAndMsg("success", "Product deleted successfully");
                redirect_to(VIEW_ALL_CUSTOMERS);
            }
        } else {
            setStatusAndMsg("error", "Product do not exists");
        }
    } catch (Exception $ex) {
        setStatusAndMsg("error", "Something went wrong");
    }
}