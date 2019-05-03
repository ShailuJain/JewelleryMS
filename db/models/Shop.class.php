<?php
/* SHOP TABLE STRUCTURE
FIELDS REQUIRED
SHOP ID (PRIMARY KEY)
SHOP NAME
SHOP ADDRESS
SHOP GST NO
SHOP PAN CARD
SHOP BANK NAME
SHOP BANK ACCOUNT NO
SHOP BANK IFSC CODE
*/
require_once 'db/models/Table.class.php';
class Shop extends Table
{
    protected $shop_details;
    public function __set($name, $value)
    {
        $this->shop_details[$name] = $value;
    }

    public function __get($name)
    {
        return $this->shop_details[$name];
    }
    public function __isset($name)
    {
        return isset($this->shop_details[$name]);
    }
    public function __unset($name)
    {
        unset($this->shop_details[$name]);
    }

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
    public static function viewAll()
    {
        return $rs = CRUD::query("SELECT @sr_no:=@sr_no+1 as serial_no, shops.* from shops INNER JOIN (SELECT @sr_no:= 0)AS a WHERE shops.deleted = 0");
    }
    public function insert()
    {
        if(!$this->exists()){
            parent::addCreated();
            return CRUD::insert(self::$table_name, $this->shop_details);
        }
        return false;
    }

    public function update()
    {
        if(!$this->existsUpdate()) {
            parent::addUpdated();
            return CRUD::update(self::$table_name, $this->shop_details, "shop_id={$this->shop_id}");
        }
        return false;
    }

    public function delete()
    {
        parent::addDeleted();
//        return CRUD::delete(self::$table_name, "customer_id={$this->customer_id}");
        $this->deleted = 1;
        return CRUD::update(self::$table_name, $this->shop_details,"customer_id={$this->shop_id}");
    }

    public function exists()
    {
        $result = self::select("*",0,"shop_gst_no = ? OR shop_contact = ?",$this->shop_gst_no, $this->shop_contact);
        if($result->rowCount() >= 1){
            return true;
        }
        return false;
    }
    public function existsUpdate()
    {
        $result = self::select("*",0,"shop_gst_no = ? OR shop_contact = ? AND customer_id != ?",$this->shop_gst_no, $this->shop_contact, $this->customer_id);
        if($result->rowCount() >= 1){
            return true;
        }
        return false;
    }
}
