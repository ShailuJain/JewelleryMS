<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-201 9
 * Time: 04:18 PM
 */
require_once 'db/models/Table.class.php';

class User extends Table
{
    public static $table_name = "users";
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
        return CRUD::insert(self::$table_name, $this->columns_values);
    }

    public function update()
    {
        return CRUD::update(self::$table_name, $this->columns_values, "user_id={$this->user_id}");
    }

    public function delete()
    {
        return CRUD::delete(self::$table_name, "user_id={$this->user_id}");
    }
}