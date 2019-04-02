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
        if(!$this->exists())
            return CRUD::insert(self::$table_name, $this->columns_values);
        return false;
    }

    public function update()
    {
        return CRUD::update(self::$table_name, $this->columns_values, "customer_id={$this->customer_id}");
    }

    public function delete()
    {
        return CRUD::delete(self::$table_name, "customer_id={$this->customer_id}");
    }

    public function exists()
    {
        $result = self::select("*",0,"customer_contact = ? AND customer_name = ?",$this->customer_contact, $this->customer_name);
        if($result->rowCount() >= 1){
            return true;
        }
        return false;
    }
}