<?php
if(isset($_GET['src']))
{
    $src = $_GET['src'];
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    $include_page = "pages/gst/".$src.".php";
}else{
    $include_page = "pages/gst/view-all-gst.php";
}
$title = "GST";
require_once ('helpers/static-components.php');