<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-201 9
 * Time: 04:18 PM
 */
require_once 'db/models/Table.class.php';

class Supplier extends Table
{
    public static $table_name = "suppliers";
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
        return CRUD::query("SELECT @sr_no:=@sr_no+1 as serial_no, suppliers.* from suppliers INNER JOIN (SELECT @sr_no:= 0)AS a WHERE suppliers.deleted = 0");
    }
    public function insert()
    {
        return CRUD::insert(self::$table_name, $this->columns_values);
    }

    public function update()
    {
        return CRUD::update(self::$table_name, $this->columns_values, "supplier_id={$this->supplier_id}");
    }

    public function delete()
    {
        return CRUD::delete(self::$table_name, "supplier_id={$this->supplier_id}");
    }
}