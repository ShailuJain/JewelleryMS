<?php


class InvoiceTemplate
{
    private $invoiceTemplate = "";
    private $title = "";
    private $shop;
    private $customer;
    private $invoice;
    private $products;


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


    private function build()
    {
        $s_name = "";
        $s_add = "";
        $s_contact = "";

        //bank details
        $bank_name = "";
        $acc_no = "";
        $bank_ifsc = "";

        $shop_gst_no = "";
        $pan_no = "";

        //customer details to be set in the invoice
        $c_name = "";
        $c_add = "";


        //invoice details of the invoice
        $i_no = "";
        $i_date = "";
        if(!empty($this->shop)){
            //shop Details to be set in invoice
            $s_name = strtoupper($this->shop->shop_name);
            $s_add = $this->shop->shop_address;
            $s_contact = $this->shop->shop_contact;

            //bank details
            $bank_name = $this->shop->bank_name;
            $acc_no = $this->shop->account_no;
            $bank_ifsc = $this->shop->bank_ifsc;

            $shop_gst_no = $this->shop->shop_gst_no;
            $pan_no = $this->shop->pan_no;
        }

        if(!empty($this->customer)){
            //customer details to be set in the invoice
            $c_name = $this->customer->customer_name;
            $c_add = $this->customer->customer_address;
            $c_contact = $this->customer->customer_contact;
        }

        if(!empty($this->invoice)){
            //invoice details of the invoice
            $i_no = $this->invoice->invoice_no;
            $i_date = $this->invoice->invoice_date;
        }


        //product details of the invoice
        $product_list = "";
        $total_amount = 0.0;
        $total_cgst_amount = 0.0;
        $total_sgst_amount = 0.0;
        $total_amount_with_gst = 0.0;
        $total_amount_in_words = "";

        if(!empty($this->products)){
            foreach ($this->products as $product) {
                //calculation for single product
                $product_amount = $product->product_quantity * ($product->product_rate + $product->making_charges);

                $sgst_rate = $product->gst_rate / 2;
                $cgst_rate = $product->gst_rate / 2;

                $cgst_amount = $product_amount * $sgst_rate / 100;
                $sgst_amount = $product_amount * $cgst_rate / 100;

                $product_amount_with_gst = $product_amount + $cgst_amount + $sgst_amount;

                $total_cgst_amount += $cgst_amount;
                $total_sgst_amount += $sgst_amount;

                //calculation for all products
                $total_amount += $product_amount;
                $total_amount_with_gst += $product_amount_with_gst;

                $display_weight =  number_format($product->product_quantity, 3, '.', '');
                $display_cgst = round($cgst_amount, 2);
                $display_sgst = round($sgst_amount, 2);

                $display_total_cgst = round($total_cgst_amount, 2);
                $display_total_sgst = round($total_sgst_amount, 2);
                $display_total_amount_with_gst = round($total_amount_with_gst, 2);

                $product_list .= <<<LIST
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
            require_once ('helpers/functions.php');
            $total_amount_in_words = ucwords(getIndianCurrency($total_amount_with_gst));
        }

        //actually building the invoiceTemplate
        $this->invoiceTemplate = <<<TEMPLATE
<!DOCTYPE html>
<html lang="en">
<head>
    <title>$this->title</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i'>
    <link href='css/style.css' rel='stylesheet'>
    <link rel='stylesheet' href='css/invoice-template.css'>
</head>
<body>
    <div class='container-fluid p-5'>
        <div class="buttons text-center">
            <div class="btn btn-primary print-hidden" id="printBtn">PRINT</div>
        </div>
        <div class='label-bold'>GST Invoice</div>
        <div class='invoice'>
            <div class='container-fluid shop-details p-0 mb-5'>
                <div class="detail-header p-2 b-bottom">
                    <div class="bold">Invoice No. : $i_no</div>
                    <div class="bold">Date : $i_date</div>
                </div>
                <div class="shop-detailed b-bottom p-2 text-center">
                    <h5 class='shop-name'>$s_name</h5>
                    <h6 class='shop-address'>Address: $s_add</h6>
                    <h6 class='shop-address'>Mob no.: $s_contact</h6>
                    <h6 class="bold">GSTIN: $shop_gst_no | PAN NO: $pan_no</h6>
                </div>
                <div class='customer-details p-2'>
                    <div class="billed-to bold">Billed To:</div>
                    <div class='customer-name bold'>$c_name</div>
                    <div class='customer-address'>Address: $c_add</div>
                    <div class='customer-address'>Contact: $c_contact</div>
                </div>
            </div>
            <div class="invoice-body bord">
                <div class="invoice-main-body">
                    <div class="invoice-body-heading">
                        <div class="columns">
                            <div class="row m-0">
                                <div class="b-right col-md-4"></div>
                                <div class="b-right col-md-1"></div>
                                <div class="b-right col-md-1"></div>
                                <div class="b-right col-md-2"></div>
                                <div class="b-right col-md-1"></div>
                                <div class="b-right col-md-1"></div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>
                        <div class="row b-bottom m-0 headings">
                            <span class="col-md-4 heading font-weight-bold">Particulars</span>
                            <span class="col-md-1 heading font-weight-bold">Net Wt.<br>(In Grams)</span>
                            <span class="col-md-1 heading font-weight-bold">Rate/gm</span>
                            <span class="col-md-2 heading font-weight-bold">Taxable Value</span>
                            <span class="col-md-1 heading font-weight-bold heading-gst">CGST<br>(Amt & Rate)</span>
                            <span class="col-md-1 heading font-weight-bold heading-gst">SGST<br>(Amt & Rate)</span>
                            <span class="col-md-2 heading font-weight-bold">Amount with GST</span>
                            
                        </div>
                    </div>
                    <div class="invoice-body-contents">
                        $product_list
                    </div>
                </div>
                <div class="invoice-body-footer b-top row m-0 pr-0">
                <div class="col-md-6 bold">Total : </div>
                <div class="col-md-2 b-left total-amount">
                    <span class="text-14 total-amount-content">&#8377;$total_amount</span>
                </div>
                <div class="b-left text-14 col-md-1">&#8377;$display_total_cgst</div>
                <div class="b-left text-14 col-md-1">&#8377;$display_total_sgst</div>
                <div class="gst col-md-2 b-left">
                    <div class="text-14">GRAND TOTAL : &#8377;$display_total_amount_with_gst</div>
                </div>
                </div>
                <div class="amount-in-words b-top row m-0">
                    <span class="col-md-12 bold">Amount in words: $total_amount_in_words</span>
                </div>
           </div>
           <br>
           <br>
           <div class="main-footer row m-0">
               <div class="received-goods col-md-5">
                   <span>RECEIVED ABOVE GOODS E. AND O.E</span>
                   <br>
                   <br>
                   <span>NOTE:- NO E-WAY BILL IS REQUIRED TO BE GENERATED AS THE GOODS COVERED UNDER THIS INVOICE ARE EXEMPTED AS PER SERIAL NO. 4/5 TO THE ANNEXURE TO RULE 138 (14) OF THE CGST RULES OF 2017</span>
                </div>
                <div class="col-md-2 offset-1 bord customer-sign-body p-0">
                        <div class="customer-sign-content b-top">
                            CUSTOMER SIGN
                        </div>
                </div>
                <div class="col-md-4 b-top b-right b-bottom p-0 for-shop">
                            <div class="for-shop-heading text-center b-bottom text-uppercase">
                                FOR $s_name
                            </div>
                            <div class="for-shop-content text-center b-top">
                                <div class="for-shop-main-content">
                                    PROPRIETOR/AUTH.SIGN
                                </div>
                            </div>
                </div>
            </div>
            <div class="offset-8 text-center col-md-4 b-bottom b-right b-left">THANKS</div>
            <br>
            <br>
            <div class="final-footer row m-0">
                <div class="col-md-12 text-center bord p-0">
                    <div class="b-bottom">SUBJECT TO MUMBAI JURISDICTION</div>
                    <div>THIS IS A COMPUTER GENERATED INVOICE</div>
                </div>
            </div>
    </div>
    <script src='vendor/jquery/jquery.min.js'></script>
    <script src='vendor/bootstrap/js/bootstrap.bundle.min.js'></script>
    <script src='js/invoices/print-invoice.js'></script>
</body>
</html>
TEMPLATE;
    }

    public function createAndReturn()
    {
        $this->build();
        return $this->invoiceTemplate;
    }

    public function createAndRedirect()
    {
        $this->build();
        require_once('helpers/redirect-helper.php');
        file_put_contents("new-invoice.php", $this->invoiceTemplate);
        redirect_to('new-invoice.php');
    }
}