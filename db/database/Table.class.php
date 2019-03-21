<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 21-03-2019
 * Time: 04:31 PM
 */

require_once 'CRUD.class.php';
class Table
{
    public $table_name;
    public $columns_values;
    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        CRUD::init();
    }

    //MAGIC Functions
    /**
     * Sets the variable to the given value.
     * @param $name - name of the variable 
     * @param $value - value of the variable
     */
    public function __set($name, $value)
    {
        $this->columns_values[$name] = $value;
    }

    /**
     * Returns the value for the variable name
     * @param $name - name of the variable of which the value is wanted
     * @return mixed - returns the value of the variable name.
     */
    public function __get($name)
    {
        return $this->columns_values[$name];
    }
    public function __isset($name)
    {
        return isset($this->columns_values[$name]);
    }
    public function __unset($name)
    {
        unset($this->columns_values[$name]);
    }
}