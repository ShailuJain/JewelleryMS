<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 26-03-2019
 * Time: 04:45 PM
 */
require_once ('db/models/Product.class.php');
require_once ('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
if(isset($_GET['id'])) {
    try {
        $product_id = $_GET['id'];

        //finding category object
        $product = Product::find("product_id = ?", $product_id);
        if ($product) {
            if ($product->delete()) {
                setStatusAndMsg("success", "Product deleted successfully");
                redirect_to(VIEW_ALL_PRODUCTS);
            }
        } else {
            setStatusAndMsg("error", "Product do not exists");
        }
    } catch (Exception $ex) {
        setStatusAndMsg("error", "Something went wrong");
    }
}