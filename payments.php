<?php
if(isset($_GET['src']))
{
    $src = $_GET['src'];
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    if(isset($_GET['p-of'])){
        $payment_of = $_GET['p-of'];
    }
    $include_page = "pages/payments/".$src.".php";
}else{
    $include_page = "pages/payments/view-all-payments.php";
}
$title = "Payments";
require_once ('helpers/static-components.php');