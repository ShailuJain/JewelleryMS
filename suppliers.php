<?php
if(isset($_GET['src']))
{
    $src = $_GET['src'];
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    $include_page = "pages/suppliers/".$src.".php";
}else{
    $include_page = "pages/suppliers/view-all-suppliers.php";
}
$title = "Suppliers";
require_once ('helpers/static-components.php');