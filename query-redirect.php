<?php
if(isset($_GET['query']))
{
    switch ($_GET['query'])
    {
        case "product":
            require_once('query-redirects/product.php');
            break;
        case "category":
            require_once ('query-redirects/category.php');
            break;
    }
}