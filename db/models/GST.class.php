<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-201 9
 * Time: 04:18 PM
 */
require_once 'Table.class.php';
require_once 'db/core/mappings.php';
class GST extends Table
{
    public static $table_name = "gst";

//    public static function getActiveHSN($hsn_code)
//    {
//        global $tableMappings;
////        return CRUD::query("SELECT * FROM gst INNER JOIN (SELECT MAX(wef) as wef, hsn_code from gst GROUP BY hsn_code) as g1 WHERE gst.hsn_code = g1.hsn_code AND gst.wef = g1.wef");
//        $result = CRUD::query("SELECT * FROM gst WHERE hsn_code = ? AND deleted = 0 ORDER BY wef DESC", $hsn_code);
//        if($result->rowCount() > 0)
//            $resultObj = new $tableMappings["gst"]($result->fetch());
//        else
//            $resultObj = null;
//        return $resultObj;
//    }

    public static function select($rows="*", $deleted=0, $condition = 1, ...$params)
    {
        return CRUD::select(self::$table_name, $rows, $deleted, $condition, ...$params);
    }

    /**
     * Returns the unique result set which includes all the hsn codes with the latest rates.
     * @return mixed
     */
    public static function viewAll()
    {
       return $rs = CRUD::query("SELECT @sr_no:=@sr_no+1 as serial_no, gst.* from gst INNER JOIN (SELECT @sr_no:= 0)AS a WHERE gst.deleted = 0");return CRUD::query("SELECT * FROM gst INNER JOIN (SELECT MAX(wef) as wef, hsn_code from gst GROUP BY hsn_code) as g1 WHERE gst.hsn_code = g1.hsn_code AND gst.wef = g1.wef");
       //        return CRUD::query("SELECT * FROM gst INNER JOIN (SELECT MAX(wef) as wef, hsn_code from (SELECT * FROM gst WHERE wef <= CURDATE()) as gst GROUP BY hsn_code) as g1 WHERE gst.hsn_code = g1.hsn_code AND gst.wef = g1.wef");
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
//        return CRUD::update(self::$table_name, $this->columns_values, "hsn_code={$this->hsn_code}");
        parent::addCreated();
        return CRUD::insert(self::$table_name, $this->columns_values);
    }

    public function delete()
    {
        parent::addDeleted();
        $this->deleted = 1;
        return CRUD::update(self::$table_name, $this->columns_values,"gst_id='{$this->gst_id}'");
//        return CRUD::delete(self::$table_name, "hsn_code={$this->hsn_code}");
    }

    public function exists()
    {
//        $result = CRUD::query("SELECT * FROM gst WHERE hsn_code = ?",$this->hsn_code);
        $result = self::select("*", 0, "hsn_code = ?", $this->hsn_code);
        if($result->rowCount() >= 1)
            return true;
        return false;
    }

    /**
     * Retrieves that the current selected entry of the gst table is with the latest date of wef column.
     * @return bool
     */
    public function isLatest(){
        $result = CRUD::query("SELECT * FROM gst WHERE hsn_code = ? AND deleted = 0 ORDER BY wef DESC", $this->hsn_code);
        if($result){
            $latest = $result->fetch();
            if($latest->gst_id == $this->gst_id)
                return true;
        }
        return false;
    }

    /**
     * @return bool: Returns true if this particular entry in used by another table
     */
    public function isUsed()
    {
        $result = CRUD::select("categories","*",0, "gst_id = ?", $this->gst_id);
        if($result){
            if($result->rowCount()>0){
                return true;
            }
        }
        return false;
    }
}