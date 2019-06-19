<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['user_id'])) {
    $include_page = "udhaari_dashboard.php";
    $title = "Udhaari";
    require_once ('helpers/static-components.php');
}else{
    header("Location: 404.php");
}