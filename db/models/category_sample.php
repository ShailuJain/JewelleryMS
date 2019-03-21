<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 21-03-2019
 * Time: 07:15 PM
 */

require_once '../core/CRUD.class.php';
//Example of creation and insertion of category in categories table using this Category class
$cat = new Category();
$cat->category_name = "NEW_CATEGORY";
$cat->category_quantity = "100";
$cat->hsn_code = "12345";
echo $cat->insert();

//Example of updating of category
$cat1 = new Category();
$cat1->category_id = 1;
$cat1->category_name = "UPDATE_CATEGORY";
$cat1->hsn_code = "65432";
echo $cat1->update();

//Example of deleting
$cat2 = new Category();
$cat2->category_id = 1;
echo $cat2->delete();