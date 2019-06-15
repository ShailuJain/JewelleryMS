<?php
if(isset($_SESSION['user_id'])) {
    if (isset($_GET['src'])) {
        $src = $_GET['src'];
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        $include_page = "pages/udhaari/" . $src . ".php";
    } else {
        $include_page = "pages/udhaari/view-all-udhaaris.php";
    }
    $title = "Udhaari";
    require_once('helpers/static-components.php');
}else{
    header("Location: 404.php");
}