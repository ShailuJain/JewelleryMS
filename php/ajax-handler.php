<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 22-03-2019
 * Time: 05:46 PM
 */
if(isset($_GET['src'])){
    $src = $_GET['src'];
    include_once ("../".$src);
}