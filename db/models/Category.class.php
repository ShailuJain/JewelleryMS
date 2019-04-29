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
    public static function viewAll(){
        return $rs = CRUD::query("SELECT @sr_no:=@sr_no+1 as serial_no, categories.category_id, categories.category_name, gst.gst_rate, gst.hsn_code FROM categories INNER JOIN gst ON categories.gst_id = gst.gst_id INNER JOIN (SELECT @sr_no:= 0) AS a WHERE categories.deleted = 0");

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

}