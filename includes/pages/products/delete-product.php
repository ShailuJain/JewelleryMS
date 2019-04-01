<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 26-03-2019
 * Time: 04:45 PM
 */
header('Content-Type: application/json');
require_once ('db/models/Product.class.php');
require_once ('helpers/status-echor.php');
if(isset($_GET['id'])) {
    try {
        $product_id = $_GET['id'];

        //finding category object
        $product = Product::find("product_id = ?", $product_id);
        if ($product) {
            if ($product->delete()) {
                echoStatus("deleted", "Product deleted successfully");
            }
        } else {
            echoStatus("error", "Product do not exists");
        }
    } catch (Exception $ex) {
        echoStatus("error", "Something went wrong");
    }
}