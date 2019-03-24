<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-201 9
 * Time: 04:18 PM
 */
require_once 'Table.class.php';

class Product extends Table
{
    public function __construct($result = null)
    {
        parent::__construct("products", $result);
    }

    public function insert()
    {
        parent::addCreated();
        return CRUD::insert($this->table_name, $this->columns_values);
    }

    public function update()
    {
        parent::addUpdated();
        return CRUD::update($this->table_name, $this->columns_values, "product_id={$this->product_id}");
    }

    public function delete()
    {
        parent::addDeleted();
        return CRUD::delete($this->table_name, "product_id={$this->product_id}");
    }
}