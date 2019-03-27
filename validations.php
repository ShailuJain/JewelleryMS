<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 26-03-2019
 * Time: 05:07 PM
 */
if(isset($_GET['form'])){
    $form = $_GET['form'];
    if(!empty($form)){
        switch ($form){
            case "products":
                require_once 'includes/pages/products/process-product-form.php';
        }

    }
}