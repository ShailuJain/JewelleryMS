<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 21-03-2019
 * Time: 04:31 PM
 */

abstract class Table
{
    protected $table_name;
    protected $columns_values;
    public function __construct($table_name, $result = null)
    {
        $this->table_name = $table_name;
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
        $this->columns_values[$name] = $value;//"Category_id"=>"2"
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
}