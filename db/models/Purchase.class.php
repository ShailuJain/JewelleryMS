<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-201 9
 * Time: 04:18 PM
 */
require_once 'db/models/Table.class.php';

class Purchase extends Table
{
    public static $table_name = "purchases";
    public static function select($rows="*", $deleted=0, $condition = 1, ...$params)
    {
        return CRUD::select(self::$table_name, $rows, $deleted, $condition, ...$params);
    }
    public static function find($condition, ...$params)
    {
        return CRUD::find(self::$table_name, $condition, ...$params);
    }
    public function __construct($result = null)
    {
        parent::__construct($result);
    }

    public static function viewProductDetails($purchase_id)
    {
        return CRUD::query("SELECT gst2.gst_id, purchase_product.product_id, gst2.wef, purchases.date_of_purchase, categories.category_name, gst2.gst_rate, gst.hsn_code, products.product_name, purchase_product.product_rate, purchase_product.product_quantity FROM purchases INNER JOIN purchase_product ON purchases.purchase_id = ? AND purchases.purchase_id = purchase_product.purchase_id INNER JOIN products ON products.product_id = purchase_product.product_id INNER JOIN categories ON products.category_id = categories.category_id INNER JOIN gst ON categories.gst_id = gst.gst_id INNER JOIN gst as gst2 ON gst.hsn_code = gst2.hsn_code AND gst2.wef <= purchases.date_of_purchase AND gst2.wef IN (SELECT MAX(gst2.wef) as wef FROM purchases INNER JOIN purchase_product ON purchases.purchase_id = ? AND purchases.purchase_id = purchase_product.purchase_id INNER JOIN products ON purchase_product.product_id = products.product_id INNER JOIN categories ON categories.category_id = products.category_id INNER JOIN gst ON gst.gst_id = categories.gst_id INNER JOIN gst as gst2 ON gst2.hsn_code = gst.hsn_code AND gst2.wef <= purchases.date_of_purchase GROUP BY products.product_id)", $purchase_id, $purchase_id);
    }

    public function insert()
    {
        parent::addCreated();
        return CRUD::insert(self::$table_name, $this->columns_values);
    }

    public function update()
    {
        parent::addUpdated();
        return CRUD::update(self::$table_name, $this->columns_values, "purchase_id={$this->purchase_id}");
    }

    public function delete()
    {
        parent::addDeleted();
//        return CRUD::delete(self::$table_name, "purchase_id={$this->purchase_id}");
        $this->deleted = 1;
        return CRUD::update(self::$table_name, $this->columns_values,"purchase_id={$this->purchase_id}");
    }

    public static function viewAll(){
        return $rs = CRUD::query("SELECT @sr_no:=@sr_no+1 as serial_no, purchases.*, suppliers.supplier_name FROM purchases INNER JOIN suppliers ON purchases.supplier_id=suppliers.supplier_id INNER JOIN (SELECT @sr_no:=0) AS a WHERE purchases.deleted = 0");

    }
}