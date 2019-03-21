<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 20-03-2019
 * Time: 10:57 AM
 */

require_once 'constants.php';
require_once '../utils/functions.php';

class Table
{
    private static $pdo;
    private static $dsn = "mysql:host=".HOST.";dbname=".DB;
    private static $isInitialized = false;

    /**
     * This method is the database initialization method. This method must be called before calling any other method of this class.
     */
    public static function init()
    {
        try
        {
            self::$isInitialized = true;
            self::$pdo = new PDO(self::$dsn, USERNAME, PASSWORD);
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        catch (PDOException $ex)
        {
             die("There was an connection error");
        }

    }

    /**
     * This method checks if the init() method was called or not before calling any other method.
     * @return bool returns true if the init() method was called as the first method.
     */
    private static function isInitialized()
    {
        if(!self::$isInitialized)
            throw new BadMethodCallException("init() method must be called first");
        return true;
    }

    /**
     * Checks if the table exists or not in the database.
     * @param $tableName - name of the table to check if it exists or not.
     * @return bool - returns true if exists else false.
     */
    private static function tableExists($tableName)
    {
        if(self::isInitialized())
        {
            $query = "SHOW TABLES FROM ".DB." LIKE '{$tableName}'";
            $tablesInDB = self::$pdo->query($query);
            if($tablesInDB)
            {
                if($tablesInDB->rowCount() == 1){
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * this method inserts into table specified with the respective columns and values provided in the associativeArray
     * @param $tableName - table in which to insert
     * @param $associativeArray - array of columns and values to be inserted
     * @return bool - returns true if insertion was successful
     */
    public static function insert($tableName, $associativeArray)
    {
        if(self::isInitialized() && self::tableExists($tableName))
        {
            $columnStatement = getString($associativeArray, INSERT_QUERY_FORMAT);
            $query = "INSERT INTO {$tableName}{$columnStatement}";
            $pdoStmt = self::$pdo->prepare($query);
            $keys = array_keys($associativeArray);
            for($i = 0; $i<count($associativeArray); $i++)
                $pdoStmt->bindParam($i+1, $associativeArray[$keys[$i]]);
            if($pdoStmt->execute())
                return true;
        }
        return false;
    }

    /**
     * updates the table specified with the respective values provided in the associativeArray
     * @param $tableName - table to update
     * @param $associativeArray - array of columns and values to be updated
     * @return bool - return true if the update query was successfully executed.
     */
    public static function update($tableName, $associativeArray)
    {
        if (self::isInitialized() && self::tableExists($tableName))
        {
            $columnStatement = getString($associativeArray, UPDATE_QUERY_FORMAT);
            $query = "UPDATE {$tableName} SET {$columnStatement}";
            $pdoStmt = self::$pdo->prepare($query);
            $keys = array_keys($associativeArray);
            for($i = 0; $i<count($associativeArray); $i++)
                $pdoStmt->bindParam($i+1, $associativeArray[$keys[$i]]);
            if($pdoStmt->execute())
                return true;
        }
        return false;
    }
    
    public static function delete($tableName, $condition)
    {
        if(self::isInitialized())
        {
            $query = "";
        }
    }
}

Database::init();
//echo Database::insert('products', array("product_name"=>"Gold Ring", "product_quantity"=>"100"));
Database::update('products', array("product_name"=>"Gold Ring", "product_quantity"=>"100"));