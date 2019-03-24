<?php
if(isset($_GET['src']))
{
    $src = $_GET['src'];
    $include_page = "pages/purchases/".$src.".php";
    require_once ('helpers/static-components.php');
}