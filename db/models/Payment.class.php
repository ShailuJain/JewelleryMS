<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-201 9
 * Time: 04:18 PM
 */
require_once 'db/models/Table.class.php';

class Payment extends Table
{
    public static $table_name = "payments";
    public static function select($rows="*", $deleted=0, $condition = 1, ...$params)
    {
        return CRUD::select(self::$table_name, $rows, $deleted, $condition, ...$params);
    }
    public static function find($condition, ...$params)
    {
        return CRUD::find(self::$table_name, $condition, ...$params);
    }
    public static function viewAll()
    {
        return CRUD::query("SELECT @sr_no:=@sr_no+1 as serial_no, payments.*, invoices.invoice_no FROM payments INNER JOIN invoices on payments.invoice_id = invoices.invoice_id INNER JOIN (SELECT @sr_no:= 0) AS a WHERE payments.deleted = 0");
    }
    public function __construct($result = null)
    {
        parent::__construct($result);
    }

    public function insert()
    {
        parent::addCreated();
        return CRUD::insert(self::$table_name, $this->columns_values);
    }

    public function update()
    {
        parent::addUpdated();
        return CRUD::update(self::$table_name, $this->columns_values, "payment_id={$this->payment_id}");
    }

    public function delete()
    {
        parent::addDeleted();
        $this->deleted = 1;
        return CRUD::update(self::$table_name, $this->columns_values,"payment_id={$this->payment_id}");
    }
}