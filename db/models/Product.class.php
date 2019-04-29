<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-201 9
 * Time: 04:18 PM
 */
require_once 'Table.class.php';

class Product extends Table
{
    public static $table_name = "products";
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

    public function insert()
    {
        if(!$this->exists()){
            parent::addCreated();
            return CRUD::insert(self::$table_name, $this->columns_values);
        }
        return false;
    }

    public function update()
    {
        if(!$this->existsUpdate()) {
            parent::addUpdated();
            return CRUD::update(self::$table_name, $this->columns_values, "product_id={$this->product_id}");
        }
        return false;
    }

    public function delete()
    {
        parent::addDeleted();
//        return CRUD::delete(self::$table_name, "product_id={$this->product_id}");
        $this->deleted = 1;
        return CRUD::update(self::$table_name, $this->columns_values,"product_id={$this->product_id}");
    }

    public function exists()
    {
        $result = CRUD::query("SELECT * FROM (SELECT * FROM products WHERE category_id = ? AND deleted = 0) AS CATEGORY_PRODUCT WHERE product_name = ? AND deleted = 0",$this->category_id, $this->product_name);
        if($result->rowCount() >= 1)
            return true;
        return false;
    }
    public function existsUpdate()
    {
        $result = CRUD::query("SELECT * FROM (SELECT * FROM products WHERE category_id = ?) AS CATEGORY_PRODUCT WHERE product_name = ?  AND deleted = 0 AND product_id != ?",$this->category_id, $this->product_name, $this->product_id);
        if($result->rowCount() >= 1)
            return true;
        return false;
    }
}