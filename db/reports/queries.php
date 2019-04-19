<?php

//queries for general reports
$category_query = "SELECT categories.category_id, categories.category_name, gst.hsn_code, gst.wef, categories.created_at, categories.updated_at, categories.deleted_at, categories.created_by, categories.updated_by, categories.deleted_by FROM categories INNER JOIN (SELECT * FROM gst WHERE deleted = 0) as gst ON categories.gst_id = gst.gst_id WHERE categories.deleted = 0";

$product_query = "SELECT products.product_id, categories.category_name, products.product_name, products.product_quantity, products.additional_specifications, products.created_at, products.updated_at, products.deleted_at, products.created_by, products.updated_by, products.deleted_by FROM `products` INNER JOIN (SELECT * FROM categories WHERE deleted = 0) AS categories ON categories.category_id = products.category_id WHERE products.deleted = 0";

