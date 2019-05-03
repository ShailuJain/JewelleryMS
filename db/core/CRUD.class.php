<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 20-03-2019
 * Time: 10:57 AM
 */

require_once 'db/core/constants.php';
require_once 'db/core/functions.php';
class CRUD
{
    protected static $columns;
    private static $pdo;
    private static $dsn = "mysql:host=".HOST.";dbname=".DB;
    private static $isInitialized = false;

    /**
     * This method is the core initialization method. This method must be called before calling any other method of this class.
     * @throws PDOException
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
             throw $ex;
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

    public static function find($tableName, $condition, ...$params)
    {
        if(!self::$isInitialized)
            self::init();
        global $tableMappings;
        $result = self::select($tableName, "*", 0,$condition, ...$params);
        if($result->rowCount() == 1)
            $resultObj = new $tableMappings[$tableName]($result->fetch());
        else
            $resultObj = null;
        return $resultObj;
    }

    public static function findNoDeletedColumn($tableName, $condition, ...$params)
    {
        if(!self::$isInitialized)
            self::init();
        global $tableMappings;
        $result = self::findAll($tableName, "*", $condition, ...$params);
        if($result->rowCount() == 1)
            $resultObj = new $tableMappings[$tableName]($result->fetch());
        else
            $resultObj = null;
        return $resultObj;
    }

    /**
     * executes the provided query if prepared statement
     * @param $query - the query to be executed.
     * @param mixed ...$params - parameters to bind to the prepared statement.
     * @return mixed - returns the result of query.
     */
    public static function query($query, ...$params)
    {
        if(!is_string($query))
            throw new InvalidArgumentException("Query is not string");
        if(!self::$isInitialized)
            self::init();
        if(strpos($query, "?") === false){
            $res = self::$pdo->query($query);
            error_log("query" . implode(",",self::$pdo->errorInfo()) . "\n", 3, "php-error.log");
            return $res;
        }
        return self::executePreparedStatement($query, ...$params);
    }

    /**
     * This method will select rows from the table specified.
     * @param $tableName - the table from which the rows has to be selected
     * @param string $rows the rows to be selected
     * @param int $deleted selects whether non deleted columns are selected or all
     * @param int $condition the condition according to which the rows will be selected
     * @param mixed ...$params params for the prepared statement if the condition is prepared statement type
     * @return mixed - returns the result set
     */
    public static function select($tableName, $rows = "*", $deleted = 0, $condition = 1, ...$params)
    {
        if(!self::$isInitialized)
            self::init();
        if(self::tableExists($tableName)){
            $query = "SELECT {$rows} FROM {$tableName} WHERE deleted={$deleted} AND {$condition}";
            error_log("select" . $query . '\n', 3, "php-error.log");
            if(self::isPreparedStatement($query)){
                return self::executePreparedStatement($query, ...$params);
            }
            return self::query($query);
        }
    }

    /**
     * This method will select rows from the table specified.
     * @param $tableName - the table from which the rows has to be selected
     * @param string $rows the rows to be selected
     * @param int $condition the condition according to which the rows will be selected
     * @param mixed ...$params params for the prepared statement if the condition is prepared statement type
     * @return mixed - returns the result set
     */
    public static function findAll($tableName, $rows = "*", $condition = 1, ...$params)
    {
        if(!self::$isInitialized)
            self::init();
        if(self::tableExists($tableName)){
            $query = "SELECT {$rows} FROM {$tableName} WHERE {$condition}";
            error_log("findAll" . $query . '\n', 3, "php-error.log");
            if(self::isPreparedStatement($query)){
                return self::executePreparedStatement($query, ...$params);
            }
            return self::query($query);
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
        if(!self::$isInitialized)
            self::init();
        if(self::tableExists($tableName))
        {
            $columnStatement = getString($associativeArray, INSERT_QUERY_FORMAT);
            $query = "INSERT INTO {$tableName}{$columnStatement}";
            $pdoStmt = self::$pdo->prepare($query);
            $keys = array_keys($associativeArray);
            for($i = 0; $i<count($associativeArray); $i++)
                $pdoStmt->bindValue($i+1, $associativeArray[$keys[$i]]);
            if($pdoStmt->execute())
                return true;
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
            $columnStatement = getString($associativeArray, UPDATE_QUERY_FORMAT);
            $query = "UPDATE {$tableName} SET {$columnStatement} WHERE {$condition}";
            $pdoStmt = self::$pdo->prepare($query);
            $keys = array_keys($associativeArray);
            for($i = 0; $i<count($associativeArray); $i++)
                $pdoStmt->bindValue($i+1, $associativeArray[$keys[$i]]);
            if($pdoStmt->execute()){
                return true;
            }
            error_log("update : " . $query . "\n", 3, "php-error.log");
            error_log("update : " . implode(",",$pdoStmt->errorInfo()) . "\n", 3, "php-error.log");
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

    public static function setDefaultTimezone($timezone)
    {
        date_default_timezone_set($timezone);
        $now = new DateTime();
        $mins = $now->getOffset() / 60;
        $sgn = ($mins < 0 ? -1 : 1);
        $mins = abs($mins);
        $hrs = floor($mins / 60);
        $mins -= $hrs * 60;
        $offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);
        return self::query("SET time_zone='$offset'");
    }
    private static function isPreparedStatement($query){
        return strpos($query, "?") !== false;
    }
    private static function executePreparedStatement($query, ...$params)
    {
        $query_param_count = substr_count($query, "?");
        $params_count = count($params);
        if($params_count < $query_param_count){
            throw new InvalidArgumentException("less arguments for prepared statement");
        }
        $stmt = self::$pdo->prepare($query);
        $i = 1;
        foreach ($params as $param) {
            $stmt->bindValue($i++, $param);
        }
        $result_bool =  $stmt->execute();
        if($result_bool){
            return $stmt;
        }
        error_log("executePreparedStatement" . implode(",",$stmt->errorInfo()) . "\n", 3, "php-error.log");
    }

    public static function lastInsertId(){
        return self::$pdo->lastInsertId();
    }
    public static function setAutoCommitOn(bool $on)
    {
        if($on)
            self::query("SET AUTOCOMMIT=ON");
        self::query("SET AUTOCOMMIT=OFF");
    }
    public static function commit()
    {
        self::query("COMMIT");
    }
    public static function rollback()
    {
        self::query("ROLLBACK");
    }
}
CRUD::setDefaultTimezone('Asia/Kolkata');