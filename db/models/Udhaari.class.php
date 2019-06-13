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
     * Retrieves the customers with pending amount on udhaari.
     * @param int $limit - limit of customers to retrieve
     * @param int $offset - from where to start till the limit
     * @param boolean $dueDatePassed -
     * @return mixed - returns the result of the query i.e the result set for all the pending amount customers
     */
    public static function getPendingAmountCustomers($limit = 5, $offset = 0, $dueDatePassed = false)
    {
        if($dueDatePassed === "true"){
            return $rs = CRUD::query("SELECT customers.customer_name, customers.customer_contact, udhaari.* FROM udhaari JOIN customers ON udhaari.customer_id = customers.customer_id WHERE udhaari.deleted = 0 AND udhaari.pending_amount > 0 and udhaari.due_date <= cast(now() as date) ORDER BY due_date DESC LIMIT $offset,$limit");
        }else{
            return $rs = CRUD::query("SELECT customers.customer_name, customers.customer_contact, udhaari.* FROM udhaari JOIN customers ON udhaari.customer_id = customers.customer_id WHERE udhaari.deleted = 0 AND udhaari.pending_amount > 0 and udhaari.due_date >= cast(now() as date) ORDER BY due_date ASC LIMIT $offset,$limit");
        }
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