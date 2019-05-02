<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-2019
 * Time: 04:18 PM
 */
require_once 'db/models/Table.class.php';

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
    public static function viewAll()
    {
        return $rs = CRUD::query("SELECT @sr_no:=@sr_no+1 as serial_no, customers.* from customers INNER JOIN (SELECT @sr_no:= 0)AS a WHERE customers.deleted = 0");
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
            return CRUD::update(self::$table_name, $this->columns_values, "customer_id={$this->customer_id}");
        }
        return false;
    }

    public function delete()
    {
        parent::addDeleted();
//        return CRUD::delete(self::$table_name, "customer_id={$this->customer_id}");
        $this->deleted = 1;
        return CRUD::update(self::$table_name, $this->columns_values,"customer_id={$this->customer_id}");
    }

    public function exists()
    {
        $result = self::select("*",0,"customer_contact = ? OR customer_email = ?",$this->customer_contact, $this->customer_email);
        if($result->rowCount() >= 1){
            return true;
        }
        return false;
    }
    public function existsUpdate()
    {
        $result = self::select("*",0,"customer_contact = ? OR customer_email = ? AND customer_id != ?",$this->customer_contact, $this->customer_email, $this->customer_id);
        if($result->rowCount() >= 1){
            return true;
        }
        return false;
    }
}