<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 20-03-2019
 * Time: 10:57 AM
 */

require_once 'constants.php';

class Database
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
     * @return bool
     */
    private static function isInitialized()
    {
        if(!self::$isInitialized)
            throw new BadMethodCallException("init() method must be called first");
        return true;

    }
    public static function insert($tableName, $associativeArray)
    {
        if(self::isInitialized())
        {
            $sql = "INSERT INTO {$tableName} ";
            $pdoStmt = self::$pdo->prepare($sql);
        }
    }

    public static function update($tableName, $associativeArray)
    {
        if (self::isInitialized())
        {

        }
    }

    public static function delete($tableName, $condition)
    {
        if(self::isInitialized())
        {
            $sql = "";
        }
    }
}