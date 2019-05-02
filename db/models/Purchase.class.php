<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-201 9
 * Time: 04:18 PM
 */
require_once 'Table.class.php';

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
        return CRUD::delete(self::$table_name, "purchase_id={$this->purchase_id}");
    }

    public static function viewAll(){
        return $rs = CRUD::query("SELECT @sr_no:=@sr_no+1 as serial_no,purchases.date_of_purchase, purchases.total_purchase_amount, purchases.purchase_title, suppliers.supplier_name FROM purchases INNER JOIN suppliers ON purchases.supplier_id=suppliers.supplier_id INNER JOIN (SELECT @sr_no:=0) AS a WHERE purchases.deleted = 0");

    }
}