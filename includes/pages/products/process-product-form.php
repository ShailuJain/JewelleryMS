<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 26-03-2019
 * Time: 04:45 PM
 */
header('Content-Type: application/json');
require_once ('db/models/Product.class.php');
require_once ('db/models/Category.class.php');
require_once ('helpers/status-echor.php');
if(isset($_POST[$operation]))
{
    if($operation == ADD_PRODUCT){
        $msg = "added";
        $func = "insert";
    }
    else if($operation == EDIT_PRODUCT){
        $msg = "edited";
        $func = "update";
    }
    try
    {
        $arr = $_POST;
        unset($arr[$operation]);
        $arrKeys = array_keys($arr);

        //creating a new product object and adding the fields.
        $product = new Product();

        //finding category object
        $category = Category::find("category_id = ?", $arr['category_id']);
        if($category){
            foreach ($arrKeys as $item) {
                $product->$item = $arr[$item];
            }
            if($product->$func()){
                echoStatus("success","Product $msg successfully");
            }
            else{
                echoStatus("error","Product already exists");
            }
        }else{
            echoStatus("error","Category do not exists");
        }
    }catch (Exception $ex){
        echoStatus("error","Something went wrong");
    }
}