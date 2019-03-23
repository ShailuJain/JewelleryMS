<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 21-03-2019
 * Time: 07:15 PM
 */

require_once '../core/CRUD.class.php';
////Example of creation and insertion of category in categories table using this Category class
//$cat = new Category();
//$cat->category_name = "NEW_CATEGORY";//=>"new_CAT"
//$cat->category_quantity = "100";
//$cat->hsn_code = "12345";
//echo $cat->insert();
//
//
////Example of updating of category
//$cat1 = new Category();
//$cat1->category_id = 3;
//$cat1->category_name  = "UPDATE_CATEGORY";
//$cat1->hsn_code = "65432";
//echo $cat1->update();
//
////Example of deleting
//$cat2 = new Category();
//$cat2->category_id = 2;
//echo $cat2->delete();

//$ca = new Customer();
//$ca->customer_name = "NEW_Customer";
//$ca->customer_address= "Ulhasnagar-42123";
//$ca->customer_email= "t@gmail.com";
//$ca->customer_contact= "78994563";
//echo $ca->insert();
//
////Example of updating of category
//$ca = new Customer();
//$ca->customer_id = 1;
//$ca->customer_address  = "UPDATE_CATEGORY";
//$ca->customer_email = "65432";
//$ca->customer_contact= "78994563";
//echo $ca->update();
//
////Example of deleting
//$ca = new Customer();
//$ca->customer_id = 2;
//echo $ca->delete();

$ca = new Invoice();
$ca->invoice_id= "NEW_Customer";
$ca->total_amount= "3000";
$ca->is_amount_pending= "0";
$ca->invoice_date= "22";
$ca->cancelled= "0";
echo $ca->insert();

//Example of updating of category
$ca = new Invoice();
$ca->invoice_id = 1;
$ca->total_amount  = "UPDATE_CATEGORY";
$ca->is_amount_pending = "65432";
$ca->invoice_date= "78994563";
$ca->cancelled= "1";
echo $ca->update();

//Example of deleting
//$ca = new Invoice();
//$ca->cancelled = 0;
//echo $ca->update();

//invoice_id
$ca = new InvoicePending();
$ca->invoice_id= 1;
$ca->last_date_payment= "22:11:2000";
$ca->pending_amount= 100;
echo $ca->insert();

//Example of updating of category
$ca = new InvoicePending();
$ca->invoice_id= 1;
$ca->last_date_payment= "22:11:2022";
$ca->pending_amount= 1000;
echo $ca->update();

//Example of deleting
$ca = new InvoicePending();
$ca->deleted = 1;
echo $ca->delete();
