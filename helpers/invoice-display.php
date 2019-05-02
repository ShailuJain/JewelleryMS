<?php
require_once('helpers/InvoiceTemplate.class.php');
require_once ('db/models/Customer.class.php');
require_once ('db/models/Invoice.class.php');
require_once ('db/models/Product.class.php');
require_once ('db/models/Shop.class.php');

$customer = new Customer();
$customer->customer_name = "Some Customer";
$customer->customer_address = "Some Customer Address, much more big address, more than this can be present here.";

$invoice = new Invoice();
$invoice->invoice_no = "INVSJ-1";
$invoice->invoice_date = date("Y-m-d");

$shop = new Shop();
$shop->shop_name = "Sakshi Jewellers";
$shop->shop_address = "Thane";
$shop->shop_gst_no = "2A7HFPJ1774N1ZX";
$shop_Bank_name = "ICIC (GHATKOPAR BRANCH)";
$shop_email = "jaindinesh@gmail.com";
$shop_Account_no = "002605009771";
$shop_Bank_ifsc = "ICIC0000026";
$shop_pan_no = "AHFPJ1774N";

$product1 = new Product();
$product1->product_name = "Ring";
$product1->category_name = "Gold";
$product1->product_quantity = "80.45";
$product1->hsn_code = "1234";
$product1->rate = "3205";
$product1->gst_rate = "3";

$product2 = new Product();
$product2->product_name = "Bracelet";
$product2->category_name = "Silver";
$product2->product_quantity = "80.45";
$product2->hsn_code = "5678";
$product2->rate = "1920";
$product2->gst_rate = "3";

$products = array($product1, $product2);

$inv_temp = new InvoiceTemplate("Invoice", $shop , $customer, $invoice, $products);
//echo $inv_temp->createAndReturn();
$inv_temp->createAndRedirect();