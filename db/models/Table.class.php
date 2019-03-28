<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 21-03-2019
 * Time: 04:31 PM
 */

require_once 'db/core/CRUD.class.php';
require_once 'db/core/mappings.php';
abstract class Table
{
    protected $columns_values;
    public function __construct($result = null)
    {
        $this->resultSetToThis($result);
    }

    private function resultSetToThis($result)
    {
        if($result!=null)
        {
            $keys = array_keys( (array) $result);
            foreach ($keys as $item) {
                $this->$item = $result->$item;
            }
        }
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
    //
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
    public function insert(){}
    public function update(){}
    public function delete(){}
    public function exists(){}

    /**
     * Adding time when the row was created in the table
     */
    public function addCreated()
    {
        try {
            $date = new DateTime();
            $this->created_at = $date->format('Y-m-d H:i:s');
            $this->created_by = 0;
        } catch (Exception $e) {
            print_r($e);
        }
    }

    /**
     * Adding time when the row was deleted in the table
     */
    public function addDeleted()
    {
        try {
            $date = new DateTime();
            $this->deleted_at = $date->format('Y-m-d H:i:s');
            $this->deleted_by = 0;
        } catch (Exception $e) {
            print_r($e);
        }
    }

    /**
     * Adding time when the row was updated in the table
     */
    public function addUpdated()
    {
        try {
            $date = new DateTime();
            $this->updated_at = $date->format('Y-m-d H:i:s');
            $this->updated_by = 0;
        } catch (Exception $e) {
            print_r($e);
        }
    }
}