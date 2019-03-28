<?php
if(isset($_GET['src']))
{
    $src = $_GET['src'];
    $include_page = "pages/customers/".$src.".php";
    include_once ("includes/core-scripts.php");
    require_once ('helpers/static-components.php');
}