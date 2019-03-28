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
if(isset($_POST['add_product']))
{
    try
    {
        $arr = $_POST;
        unset($arr['add_product']);
        $arrKeys = array_keys($arr);

        //creating a new product object and adding the fields.
        $product = new Product();

        //finding category object
        $category = Category::find("category_id = {$arr['category_id']}");
        if($category){
            foreach ($arrKeys as $item) {
                $product->$item = $arr[$item];
            }
            $category->category_quantity += $product->product_quantity;
            $res = CRUD::query("SET AUTOCOMMIT = OFF");
            if($res){
                CRUD::query("START TRANSACTION");
                if($product->insert() && $category->update()){
                    if(CRUD::query("COMMIT"))
                        echoStatus("success","Product added successfully");
                    else{
                        throw new Exception();
                    }
                }else{
                    CRUD::query("ROLLBACK");
                    echoStatus("error","Product already exists");
                }
            }
        }else{
            echoStatus("error","Category do not exists");
        }
    }catch (Exception $ex){
        echoStatus("error","Something went wrong");
    }
}