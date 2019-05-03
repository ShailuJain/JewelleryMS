<?php
if(isset($_GET['src']))
{
    $src = $_GET['src'];
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    $include_page = "pages/payments/".$src.".php";
}else{
    $include_page = "pages/payments/view-all-payments.php";
}
require_once ('helpers/static-components.php');