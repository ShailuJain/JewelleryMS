<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-201 9
 * Time: 04:18 PM
 */
require_once 'Table.class.php';

class InvoicePending extends Table
{
    public static $table_name = "invoice_pending";
    public static function select($rows="*",$condition = 1, $order = null,$deleted=0)
    {
        CRUD::select(self::$table_name, $rows, $condition, $order, $deleted);
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
        return CRUD::update(self::$table_name, $this->columns_values, "invoice_id={$this->invoice_id}");
    }

    public function delete()
    {
        return CRUD::delete(self::$table_name, "invoice_id={$this->invoice_id}");
    }
}