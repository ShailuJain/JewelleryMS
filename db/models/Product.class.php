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
    public static $table_name = "products";
    public static function select($rows="*",$condition = 1, $order = null,$deleted=0)
    {
        return CRUD::select(self::$table_name, $rows, $condition, $order, $deleted);
    }
    public static function find($condition)
    {
        return CRUD::find(self::$table_name, $condition);
    }
    public function __construct($result = null)
    {
        parent::__construct($result);
    }

    public function insert()
    {
        parent::addCreated();
        return CRUD::insert(self::$table_name, $this->columns_values);
    }

    public function update()
    {
        parent::addUpdated();
        return CRUD::update(self::$table_name, $this->columns_values, "product_id={$this->product_id}");
    }

    public function delete()
    {
        parent::addDeleted();
        return CRUD::delete(self::$table_name, "product_id={$this->product_id}");
    }

    public function exists()
    {
        if(isset($this->product_id))
        {
            $result = CRUD::query("SELECT * FROM (SELECT * FROM products WHERE category_id = $this->category_id) AS CATEGORY_PRODUCT WHERE product_name='$this->product_name'");
        }
        else{
            throw new BadMethodCallException("Please set the primary key first");
        }
    }
}