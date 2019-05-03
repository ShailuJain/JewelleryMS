<?php
/**
 * Created by PhpStorm.
 * User: Tarun
 * Date: 21-03-201 9
 * Time: 04:18 PM
 */
require_once 'db/models/Table.class.php';

class Invoice extends Table
{
    public static $table_name = "invoices";
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

    public static function viewProductDetails($invoice_id)
    {
        return CRUD::query("SELECT invoices.invoice_date, invoices.due_date, products.product_name, invoice_product.product_quantity, categories.category_name, gst.gst_rate FROM invoices, invoice_product, products, gst, categories WHERE invoices.invoice_id = ? AND invoices.deleted=0 And invoice_product.product_id=products.product_id AND products.category_id = categories.category_id AND categories.gst_id=gst.gst_id", $invoice_id);
    }
    public static function viewPaymentDetails($invoice_id)
    {
        return CRUD::query("SELECT * FROM payments JOIN invoices ON invoices.invoice_id=payments.invoice_id WHERE invoices.invoice_id=? AND invoices.deleted=0 AND payments.deleted=0", $invoice_id);
    }

    public function insert()
    {
        parent::addCreated();
        return CRUD::insert(self::$table_name, $this->columns_values);
    }

    public function update()
    {
        parent::addUpdated();
        return CRUD::update(self::$table_name, $this->columns_values, "invoice_id={$this->invoice_id}");
    }

    public function delete()
    {
        return CRUD::delete(self::$table_name, "invoice_id={$this->invoice_id}");
    }
    public static function viewAll(){
        return $rs = CRUD::query("SELECT @sr_no:=@sr_no+1 as serial_no, invoices.*,customers.customer_name FROM `invoices` JOIN customers ON invoices.customer_id= customers.customer_id INNER JOIN (SELECT @sr_no:=0) AS a WHERE invoices.deleted = 0");
    }
}