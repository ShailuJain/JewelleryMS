<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 26-03-2019
 * Time: 05:07 PM
 */
require_once 'constants.php';
if(isset($_GET['form'])){
    $form = $_GET['form'];
    if(!empty($form)){
        switch ($form){
            case "products/add":
                $operation = ADD_PRODUCT;
                require_once 'includes/pages/products/process-product-form.php';
                break;
            case "products/edit":
                $operation = EDIT_PRODUCT;
                require_once 'includes/pages/products/process-product-form.php';
                break;
            case "products/delete":
                require_once 'includes/pages/products/delete-product.php';
                break;
            case "customers/add":
                $operation = ADD_CUSTOMER;
                require_once 'includes/pages/customers/process-customer-form.php';
                break;
            case "customers/edit":
                $operation = EDIT_CUSTOMER;
                require_once 'includes/pages/customers/process-customer-form.php';
                break;
            case "customers/delete":
                require_once 'includes/pages/customers/delete-customer.php';
                break;
        }

    }
}