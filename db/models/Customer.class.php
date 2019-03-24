<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-2019
 * Time: 04:18 PM
 */
require_once 'Table.class.php';

class Customer extends Table
{
    public static $table_name = "customers";
    public static function select($rows="*",$condition = 1, $order = null,$deleted=0)
    {
        return CRUD::select(self::$table_name, $rows, $condition, $order, $deleted);
    }
    public static function find($condition)
    {
        return CRUD::find(self::$table_name, $condition);
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
        return CRUD::update(self::$table_name, $this->columns_values, "customer_id={$this->customer_id}");
    }

    public function delete()
    {
        return CRUD::delete(self::$table_name, "customer_id={$this->customer_id}");
    }
}