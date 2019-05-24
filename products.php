<?php
if(isset($_GET['src']))
{
    $src = $_GET['src'];
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    $include_page = "pages/products/".$src.".php";
}else{
    $include_page = "pages/products/view-all-products.php";
}
$title = "Products";
require_once ('helpers/static-components.php');
