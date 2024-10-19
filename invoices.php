<?php
if (isset($_GET['src'])) {
    $src = $_GET['src'];
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    if($src === "view-invoice") {
        unset($include_page);
        @include_once ("includes/pages/invoices/".$src.".php");
    } else {
        $include_page = "pages/invoices/".$src.".php";
    }
} else {
    $include_page = "pages/invoices/view-all-invoices.php";
}
if (isset($include_page)) {
    $title = "Invoice";
    require_once('helpers/static-components.php');   
}