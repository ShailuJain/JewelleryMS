<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 20-03-2019
 * Time: 10:57 AM
 */

require_once 'constants.php';
require_once 'functions.php';

class CRUD
{
    protected static $columns;
    private static $pdo;
    private static $dsn = "mysql:host=".HOST.";dbname=".DB;
    private static $isInitialized = false;

    /**
     * This method is the core initialization method. This method must be called before calling any other method of this class.
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
     * Checks if the table exists or not in the core.
     * @param $tableName - name of the table to check if it exists or not.
     * @return bool - returns true if exists else false.
     */
    private static function tableExists($tableName)
    {
        if(!self::$isInitialized) {
            self::init();
        }
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

    public static function findById($tableName)
    {
        global $tableMappings;
        $result = self::select($tableName);
        if($result->rowCount() == 1)
            $resultObj = new $tableMappings[$tableName]($result[0]);
        else
            $resultObj = null;
        return $resultObj;
    }

    /**
     * executes the provided query.
     * @param $query - the query to be executed.
     * @return mixed - returns the result of query.
     */
    public static function query($query)
    {
        return self::$pdo->query($query);
    }
    /**
     * This method will select rows from the table specified.
     * @param $tableName the table from which the rows has to be selected
     * @param string $rows the rows to be selected
     * @param int $condition the condition according to which the rows will be selected
     * @param null $order it specifies the order in which the rows will be selected it will be "asc" or "desc"
     * @return mixed - returns the result set
     */
    public static function select($tableName, $rows = "*", $condition = 1, $order = NULL,$deleted=0)
    {
        if(!self::$isInitialized)
            self::init();
        if(self::tableExists($tableName)){
            try{
                $query = "SELECT ".$rows." FROM ".$tableName." WHERE ".$condition ." AND deleted=".$deleted;
                if($order!=NULL)
                    $query.=" ORDER BY ".$order;
                $result = self::$pdo->query($query);
                if($result)
                {
                    return $result;
                }
            }catch (Exception $e){
                print_r($e);
            }
        }
        return null;
    }

    /**
     * this method inserts into table specified with the respective columns and values provided in the associativeArray
     * @param $tableName - table in which to insert
     * @param $associativeArray - array of columns and values to be inserted
     * @return bool - returns true if insertion was successful
     */
    public static function insert($tableName, $associativeArray)
    {
        if(!self::$isInitialized)
            self::init();
        if(self::tableExists($tableName))
        {
            try{
                $columnStatement = getString($associativeArray, INSERT_QUERY_FORMAT);
                $query = "INSERT INTO {$tableName}{$columnStatement}";
                $pdoStmt = self::$pdo->prepare($query);
                $keys = array_keys($associativeArray);
                for($i = 0; $i<count($associativeArray); $i++)
                    $pdoStmt->bindParam($i+1, $associativeArray[$keys[$i]]);
                if($pdoStmt->execute())
                    return true;
            }catch (Exception $e){
                print_r("Insert Error " . $e);
            }
        }
        return false;
    }

    /**
     * updates the table specified with the respective values provided in the associativeArray
     * @param $tableName - table to update
     * @param $associativeArray - array of columns and values to be updated
     * @param $condition - condition where to be updated
     * @return bool - return true if the update query was successfully executed.
     */
    public static function update($tableName, $associativeArray, $condition)
    {
        if(!self::$isInitialized)
            self::init();
        if (self::tableExists($tableName))
        {
            try{
                $columnStatement = getString($associativeArray, UPDATE_QUERY_FORMAT);
                $query = "UPDATE {$tableName} SET {$columnStatement} WHERE {$condition}";
                $pdoStmt = self::$pdo->prepare($query);
                $keys = array_keys($associativeArray);
                for($i = 0; $i<count($associativeArray); $i++)
                    $pdoStmt->bindParam($i+1, $associativeArray[$keys[$i]]);
                if($pdoStmt->execute())
                    return true;
            }catch (Exception $e){
                print_r("Update Error " . $e);
            }
        }
        return false;
    }

    /**
     * sets the deleted column to true in the tableName
     * @param $tableName - name of the table from which the row is to be deleted
     * @param $condition - condition of rows to be deleted.
     * @return bool - returns true if the operation was successful
     */
    public static function delete($tableName, $condition)
    {
        return self::update($tableName, array("deleted"=>1), $condition);
    }
}