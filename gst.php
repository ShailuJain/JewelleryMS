<?php
if(isset($_GET['src']))
{
    $src = $_GET['src'];
    if(isset($_GET['hsn_code'])){
        $hsn_code = $_GET['hsn_code'];
    }
    $include_page = "pages/gst/".$src.".php";
}else{
    $include_page = "pages/gst/view-all-gst.php";
}
require_once ('helpers/static-components.php');
