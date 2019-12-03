<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-201 9
 * Time: 04:18 PM
 */
require_once 'db/models/Table.class.php';

class UdhaariTransaction extends Table
{
    public static $table_name = "udhaari_transactions";
    public static function select($rows="*", $deleted=0, $condition = 1, ...$params)
    {
        return CRUD::select(self::$table_name, $rows, $deleted, $condition, ...$params);
    }
    public static function findNoDeletedColumn($condition, ...$params)
    {
        return CRUD::findNoDeletedColumn(self::$table_name, $condition, ...$params);
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
        return CRUD::update(self::$table_name, $this->columns_values,"udhaari_id={$this->udhaari_id}");
    }


    public function delete(){
        /**
         * Called the query method because this table was not having column as deleted and the delete function
         * internally updates the deleted column
        */
        return CRUD::query("DELETE FROM udhaari_transactions where udhaari_transaction_id = ?", $this->udhaari_transaction_id);
    }
}