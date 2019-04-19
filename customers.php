<?php
if(isset($_GET['src']))
{
    $src = $_GET['src'];
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    $include_page = "pages/customers/".$src.".php";
}else{
    $include_page = "pages/customers/view-all-customers.php";
}
require_once ('helpers/static-components.php');