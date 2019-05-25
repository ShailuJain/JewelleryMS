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
        return CRUD::query("
SELECT invoices.invoice_date, invoices.due_date, products.product_name, invoice_product.product_quantity, categories.category_name, gst.gst_rate FROM invoices, invoice_product, products, gst, categories WHERE invoices.invoice_id = ? AND invoices.deleted = 0 AND invoice_product.product_id = products.product_id AND products.category_id = categories.category_id AND categories.gst_id = gst.gst_id AND invoices.invoice_id = invoice_product.invoice_id", $invoice_id);
    }
    public static function viewPaymentDetails($invoice_id)
    {
        return CRUD::query("SELECT * FROM payments JOIN invoices ON invoices.invoice_id=payments.invoice_id WHERE invoices.invoice_id=? AND invoices.deleted=0 AND payments.deleted=0", $invoice_id);
    }

    public function insert()
    {
        if(!$this->exists())
        {
            parent::addCreated();
            return CRUD::insert(self::$table_name, $this->columns_values);
        }
    }

    public function update()
    {
        parent::addUpdated();
        return CRUD::update(self::$table_name, $this->columns_values, "invoice_id={$this->invoice_id}");
    }

    public function delete()
    {
        $this->addDeleted();
        $this->deleted = 1;
        return CRUD::update(self::$table_name, $this->columns_values, "invoice_id={$this->invoice_id}");
    }
    public static function viewAll(){
        return $rs = CRUD::query("SELECT @sr_no:=@sr_no+1 as serial_no, invoices.*,customers.customer_name,customers.customer_contact FROM invoices JOIN customers ON invoices.customer_id=customers.customer_id INNER JOIN (SELECT @sr_no:=0) AS a WHERE invoices.deleted = 0");
    }

    public static function getPendingAmountCustomers($limit = 5, $offset = 0)
    {
        return $rs = CRUD::query("SELECT customers.customer_name, customers.customer_contact, invoices.* FROM invoices JOIN customers ON invoices.customer_id = customers.customer_id WHERE invoices.deleted = 0 AND invoices.pending_amount > 0 ORDER BY due_date ASC LIMIT $offset,$limit");
    }

    public function exists()
    {
//        $result = CRUD::query("SELECT * FROM (SELECT * FROM products WHERE category_id = ? AND deleted = 0) AS CATEGORY_PRODUCT WHERE product_name = ? AND deleted = 0",$this->category_id, $this->product_name);
        $result = self::select("*",0,"invoice_no = ?", $this->invoice_no);
        if($result->rowCount() >= 1)
            return true;
        return false;
    }
}