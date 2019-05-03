<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-201 9
 * Time: 04:18 PM
 */
require_once 'db/models/Table.class.php';

class PurchaseProduct extends Table
{
    public static $table_name = "purchase_product";
    public static function select($rows="*", $condition = 1, ...$params)
    {
        return CRUD::findAll(self::$table_name, $rows, $condition, ...$params);
    }
    public static function find($condition, ...$params)
    {
        return CRUD::findNoDeletedColumn(self::$table_name, $condition, ...$params);
    }
    public function __construct($result = null)
    {
        parent::__construct($result);
    }

    public function insert()
    {
        return CRUD::insert(self::$table_name, $this->columns_values);
    }

    public function update()
    {
        return CRUD::update(self::$table_name, $this->columns_values, "purchase_id={$this->purchase_id} AND product_id={$this->product_id}");
    }

    public function delete()
    {
        $table_name = self::$table_name;
        $result = CRUD::query("DELETE FROM $table_name WHERE purchase_id={$this->purchase_id} AND product_id={$this->product_id}");
        return $result;
//        return CRUD::delete(self::$table_name, "purchase_id={$this->purchase_id}");
    }
}