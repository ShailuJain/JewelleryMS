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
    public function __construct($result = null)
    {
        parent::__construct("customers", $result);
    }

    public function insert()
    {
        return CRUD::insert($this->table_name, $this->columns_values);
    }

    public function update()
    {
        return CRUD::update($this->table_name, $this->columns_values, "customer_id={$this->customer_id}");
    }

    public function delete()
    {
        return CRUD::delete($this->table_name, "customer_id={$this->customer_id}");
    }
}