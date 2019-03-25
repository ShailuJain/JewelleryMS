

<?php
require_once 'db/models/Category.class.php';
//$c = new Category();
//$c->category_name="ismeDATA5";
//$c->category_quantity=11;
//$c->hsn_code=7113;
//$c->deleted=0;
//$c->insert();

$rs=CRUD::select("categories");
$rows = array();
while($row = $rs->fetch()) {
    $rows[] = $row;
}

echo json_encode($rows);