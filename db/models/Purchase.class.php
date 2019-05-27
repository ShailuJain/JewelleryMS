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
        return CRUD::query("SELECT products.product_name,categories.category_name,purchase_product.product_rate,purchase_product.product_quantity,gst.gst_rate FROM (((products JOIN purchase_product on products.product_id=purchase_product.product_id) JOIN categories ON products.category_id=categories.category_id) JOIN gst on categories.gst_id=gst.gst_id) where purchase_product.purchase_id = ? and gst.hsn_code in(SELECT hsn_code FROM gst WHERE gst_id=categories.gst_id) and gst.wef<='2019-5-8' AND gst.deleted=0 ORDER by wef DESC", $purchase_id);
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