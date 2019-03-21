<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 21-03-2019
 * Time: 07:12 PM
 */
require_once 'CRUD.class.php';
$result = CRUD::select("categories");
for($i = 0; $i<count($result); $i++){
    echo $result[$i]->category_id."<br>";
    echo $result[$i]->category_name."<br>";
    echo $result[$i]->category_quantity."<br>";
    echo $result[$i]->hsn_code."<br>";
    echo $result[$i]->created_at."<br>";
    echo $result[$i]->created_by."<br>";
    echo $result[$i]->deleted_at."<br>";
    echo $result[$i]->deleted_by."<br>";
    echo $result[$i]->updated_at."<br>";
    echo $result[$i]->updated_by."<br>";
}
$result[0]->category_name = "GOLD";
$result[0]->update();