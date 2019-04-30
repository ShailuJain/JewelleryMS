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
     * @param string $shop_name
     * @param string $shop_address
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
        //shop Details to be set in invoice
        $s_name = $this->shop->shop_name;
        $s_add = $this->shop->shop_address;


        //customer details to be set in the invoice
        $c_name = $this->customer->customer_name;
        $c_add = $this->customer->customer_address;

        //invoice details of the invoice
        $i_no = $this->invoice->invoice_no;
        $i_date = $this->invoice->invoice_date;


        //product details of the invoice
        $product_list = "";

        foreach ($this->products as $product) {
            $amount = $product->product_quantity * $product->rate;
            $gst_amount = $amount * $product->gst_rate / 100;
            $total_amount = $amount + $gst_amount;
            $product_list .= <<<LIST
                <div class="row m-0">
                    <span class="col-md-2">$product->hsn_code</span>
                    <span class="col-md-4">$product->category_name - $product->product_name</span>
                    <span class="col-md-1">$product->product_quantity</span>
                    <span class="col-md-2">$product->rate</span>
                    <span class="col-md-1">$product->gst_rate %</span>
                    <span class="col-md-2">$total_amount</span>
                </div>
LIST;
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
    <div class='container p-5'>
        <div class='invoice'>
            <div class='container shop-details p-0 mb-5'>
                <h2 class='shop-name'>$s_name</h2>
                <h6 class='shop-address'>$s_add</h6>
            </div>
            <div class='invoice-header mb-5'>
                <div class='label-bold b-bottom'>Tax Invoice</div>
                <div class='invoice-details'>
                    <div class='row m-0'>
                        <div class='col-md-4 b-bottom p-0'>
                            <div class='label b-bottom'>Invoice No.</div>
                            <div class='label'>$i_no</div>
                        </div>
                        <div class='col-md-4 b-left b-bottom b-right'>
                            
                        </div>
                        <div class='col-md-4 b-bottom p-0'>
                            <div class='label b-bottom'>Invoice Date</div>
                            <div class='label'>$i_date</div>
                        </div>
                    </div>
                </div>
                <div class='container customer-details'>
                    <div class='customer-name'>$c_name</div>
                    <div class='customer-address'>$c_add</div>
                </div>
                    
            </div>
            <div class="invoice-body bord">
                <div class="invoice-body-headings">
                    <div class="columns">
                        <div class="row m-0">
                            <div class="b-right col-md-2"></div>
                            <div class="b-right col-md-4"></div>
                            <div class="b-right col-md-1"></div>
                            <div class="b-right col-md-2"></div>
                            <div class="b-right col-md-1"></div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                    <div class="row b-bottom m-0">
                        <span class="col-md-2">HSN Code</span>
                        <span class="col-md-4">Particulars</span>
                        <span class="col-md-1">Net Wt.</span>
                        <span class="col-md-2">Rate/gm</span>
                        <span class="col-md-1">GST %</span>
                        <span class="col-md-2">Amount</span>
                    </div>
                </div>
                <div class="invoice-body-contents">
                    $product_list
                </div>
                    <div class="invoice-body-footer">
             
                    <div class="row m-0">
              
            
                            <div class="col-md-7">
                            <div class="label">Bank Details</div>
                            <div class="label">Account/No</div>
                            <div class="label">IFSC Code</div>
</div>

</div>
                </div> 
           </div>

        </div>
    </div>
    <script src='vendor/jquery/jquery.min.js'></script>
    <script src='vendor/bootstrap/js/bootstrap.bundle.min.js'></script>
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