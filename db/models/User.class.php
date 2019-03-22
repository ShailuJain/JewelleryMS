<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-201 9
 * Time: 04:18 PM
 */
require_once 'Table.class.php';

class User extends Table
{
    public function __construct($result = null)
    {
        parent::__construct("users", $result);
    }

    public function insert()
    {
        return CRUD::insert($this->table_name, $this->columns_values);
    }

    public function update()
    {
        return CRUD::update($this->table_name, $this->columns_values, "user_id={$this->user_id}");
    }

    public function delete()
    {
        return CRUD::delete($this->table_name, "user_id={$this->user_id}");
    }
}