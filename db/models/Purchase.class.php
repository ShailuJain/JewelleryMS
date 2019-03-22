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
    public function __construct($result = null)
    {
        parent::__construct("purchases", $result);
    }

    public function insert()
    {
        return CRUD::insert($this->table_name, $this->columns_values);
    }

    public function update()
    {
        return CRUD::update($this->table_name, $this->columns_values, "purchase_id={$this->purchase_id}");
    }

    public function delete()
    {
        return CRUD::delete($this->table_name, "purchase_id={$this->purchase_id}");
    }
}