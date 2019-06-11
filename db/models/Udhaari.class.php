<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-201 9
 * Time: 04:18 PM
 */
require_once 'db/models/Table.class.php';

class Udhaari extends Table
{
    public static $table_name = "udhaari";
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
        return CRUD::query("SELECT @sr_no:=@sr_no+1 as serial_no, udhaari.*, customers.customer_name FROM udhaari INNER JOIN customers on udhaari.customer_id = customers.customer_id INNER JOIN (SELECT @sr_no:= 0) AS a WHERE udhaari.deleted = 0");
    }
    public static function viewPaymentDetails($udhaari_id)
    {
        require_once ('db/models/Payment.class.php');
        return Payment::viewAll("udhaari", "udhaari_id", $udhaari_id);
    }
    /**
     * @return bool: Returns true if this particular entry in used by another table
     */
    public static function isUsed($udhaari_id)
    {
        $result = self::viewPaymentDetails($udhaari_id);
        if($result){
            if($result->rowCount()>0){
                return true;
            }
        }
        return false;
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
        return CRUD::update(self::$table_name, $this->columns_values, "udhaari_id={$this->udhaari_id}");
    }

    public function delete()
    {
        parent::addDeleted();
        $this->deleted = 1;
        return CRUD::update(self::$table_name, $this->columns_values,"udhaari_id={$this->udhaari_id}");
    }
}