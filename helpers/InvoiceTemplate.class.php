<?php

class InvoiceTemplate
{
    public $invoiceTemplate = "";
    public $title = "";
    public $shop;
    public $customer;
    public $invoice;
    public $products;

    // Public calculated variables
    public $total_amount = 0.0;
    public $total_cgst_amount = 0.0;
    public $total_sgst_amount = 0.0;
    public $total_amount_with_gst = 0.0;
    public $total_amount_in_words = "";
    public $product_list = "";
    public $display_total_cgst = 0.0;
    public $display_total_sgst = 0.0;
    public $display_total_amount_with_gst = 0.0;

    // Shop and Customer details
    public $s_name = "";
    public $s_add = "";
    public $s_contact = "";
    public $shop_gst_no = "";
    public $pan_no = "";

    public $c_name = "";
    public $c_add = "";
    public $c_contact = "";

    // Invoice details
    public $i_no = "";
    public $i_date = "";

    /**
     * InvoiceTemplate constructor.
     * @param string $title
     * @param mixed $shop
     * @param mixed $customer
     * @param mixed $invoice
     * @param array $products
     */
    public function __construct(string $title, $shop, $customer, $invoice, array $products)
    {
        $this->title = $title;
        $this->shop = $shop;
        $this->customer = $customer;
        $this->invoice = $invoice;
        $this->products = $products;
    }

    public function build()
    {
        // If shop details exist
        if (!empty($this->shop)) {
            $this->s_name = strtoupper($this->shop->shop_name);
            $this->s_add = $this->shop->shop_address;
            $this->s_contact = $this->shop->shop_contact;
            $this->shop_gst_no = $this->shop->shop_gst_no;
            $this->pan_no = $this->shop->pan_no;
        }

        // If customer details exist
        if (!empty($this->customer)) {
            $this->c_name = $this->customer->customer_name;
            $this->c_add = $this->customer->customer_address;
            $this->c_contact = $this->customer->customer_contact;
        }

        // If invoice details exist
        if (!empty($this->invoice)) {
            $this->i_no = $this->invoice->invoice_no;
            $this->i_date = $this->invoice->invoice_date;
        }

        // Calculating product details
        if (!empty($this->products)) {
            foreach ($this->products as $product) {
                $product_amount = $product->product_quantity * ($product->product_rate + $product->making_charges);

                $sgst_rate = $product->gst_rate / 2;
                $cgst_rate = $product->gst_rate / 2;

                $cgst_amount = $product_amount * $sgst_rate / 100;
                $sgst_amount = $product_amount * $cgst_rate / 100;

                $product_amount_with_gst = $product_amount + $cgst_amount + $sgst_amount;

                $this->total_cgst_amount += $cgst_amount;
                $this->total_sgst_amount += $sgst_amount;
                $this->total_amount += $product_amount;
                $this->total_amount_with_gst += $product_amount_with_gst;

                $display_weight = number_format($product->product_quantity, 3, '.', '');
                $display_cgst = round($cgst_amount, 2);
                $display_sgst = round($sgst_amount, 2);

                $this->display_total_cgst = round($this->total_cgst_amount, 2);
                $this->display_total_sgst = round($this->total_sgst_amount, 2);
                $this->display_total_amount_with_gst = round($this->total_amount_with_gst, 2);

                $this->product_list .= <<<LIST
                <div class="row m-0">
                    <span class="col-md-4 jewellery-item">$product->category_name - $product->product_name, HSN Code : $product->hsn_code</span>
                    <span class="col-md-1 jewellery-item">$display_weight</span>
                    <span class="col-md-1 jewellery-item">&#8377;$product->product_rate</span>
                    <span class="col-md-2 jewellery-item">&#8377;$product_amount</span>
                    <span class="col-md-1 jewellery-item">$display_cgst<br>($cgst_rate %)</span>
                    <span class="col-md-1 jewellery-item">$display_sgst<br>($sgst_rate %)</span>
                    <span class="col-md-2 jewellery-item">&#8377;$product_amount_with_gst</span>
                </div>
LIST;
            }

            require_once('helpers/functions.php');
            $this->total_amount_in_words = ucwords(getIndianCurrency($this->total_amount_with_gst));
        }
    }
}
