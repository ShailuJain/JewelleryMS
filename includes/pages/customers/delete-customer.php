<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 26-03-2019
 * Time: 04:45 PM
 */
require_once ('db/models/Customer.class.php');
require_once ('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
if(isset($_GET['id'])) {
    try {
        $customer_id = $_GET['id'];

        //finding category object
        $customer = Customer::find("customer_id = ?", $customer_id);
        if ($customer) {
            if ($customer->delete()) {
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