<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 21-03-2019
 * Time: 04:18 PM
 */
require_once 'Table.class.php';

class Category extends Table
{
    public static $table_name = "categories";
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
        if(!$this->exists()){
            parent::addCreated();
            return CRUD::insert(self::$table_name, $this->columns_values);
        }
        return false;
    }

    public function update()
    {
        return CRUD::update(self::$table_name, $this->columns_values, "category_id={$this->category_id}");
    }

    public function delete()
    {
        return CRUD::delete(self::$table_name, "category_id={$this->category_id}");
    }
    public function exists()
    {
        $result = self::select("*", 0, "category_name = ? AND gst_id = ?", $this->category_name, $this->gst_id);
        if($result->rowCount() >= 1)
            return true;
        return false;
    }
    /**
     * @return bool: Returns true if this particular entry in used by another table
     */
    public function isUsed()
    {
        $result = CRUD::select("products","*",0, "category_id = ?", $this->category_id);
        if($result){
            if($result->rowCount()>0){
                return true;
            }
        }
        return false;
    }
}