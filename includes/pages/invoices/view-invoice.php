<?php
try{
    if (isset($id)) {
        require_once ('db/models/Invoice.class.php');
        require_once ('db/models/InvoiceProduct.class.php');
        $invoice_to_create = Invoice::find("invoice_id = ?", $id);
        $invoice_products_to_create = Invoice::viewProductDetails($id);

        if($invoice_to_create && $invoice_products_to_create){
            require_once('helpers/InvoiceTemplate.class.php');
            require_once ('db/models/Customer.class.php');
            require_once ('db/models/Product.class.php');
            require_once ('db/models/Shop.class.php');
            require_once ('helpers/redirect-helper.php');
            require_once ('helpers/redirect-constants.php');

            //find customer of the invoice
            $customer = Customer::find("customer_id = ?", $invoice_to_create->customer_id);

            $shop = new Shop();
            //shop details :
            $shop->shop_name = "Sakshi Jewellers";
            $shop->shop_owner = "Sunil Jain";
            $shop->shop_contact = "9881617616";
            $shop->shop_address = "Jai Ganesh Shopping Centre, Shop No. 11, Achole Road, Nallasopara (E), 401209.";
            $shop->email = "suniljain853@gmail.com";
            //gst details :
            $shop->shop_gst_no = "27AIVPP0970D1ZX";
            $shop->pan_no = "AIVPP0970D";
            //bank details :
            $shop->bank_name = "ICIC (GHATKOPAR BRANCH)";
            $shop->account_no = "002605009771";
            $shop->bank_ifsc = "ICIC0000026";

            $products = array();
            $i = 0;
            foreach ($invoice_products_to_create->fetchAll() as $invoice_product){
//                $rs = CRUD::query("SELECT gst.hsn_code, gst.gst_rate, categories.category_name, product.product_name FROM categories INNER JOIN gst ON categories.gst_id = gst.gst_id INNER JOIN (SELECT * FROM products WHERE product_id = ?) AS product WHERE categories.category_id = product.category_id", $invoice_product->product_id)->fetch();
//                $invoice_product->category_name = $rs->category_name;
//                $invoice_product->product_name = $rs->product_name;
//                $invoice_product->hsn_code = $rs->hsn_code;
//                $invoice_product->gst_rate = $rs->gst_rate;

                $products[$i++] = $invoice_product;
            }

            $inv_temp = new InvoiceTemplate("Invoice - $customer->customer_name", $shop , $customer, $invoice_to_create, $products);
//echo $inv_temp->createAndReturn();
            $inv_temp->build();
        }else{
            throw new Exception("Cannot view invoice. Something went wrong");
        }
    }else{
        throw new Exception("Cannot view invoice. Something went wrong");
    }
}catch (Exception $ex){
    redirect_to(VIEW_ALL_INVOICES);
    setStatusAndMsg("error",$ex->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $inv_temp->title; echo "-"; echo $inv_temp->i_date; ?></title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i'>
    <link href='css/style.css' rel='stylesheet'>
    <link rel='stylesheet' href='css/invoice-template.css'>
</head>
<body>
    <div class='container-fluid p-5'>
        <div class='label-bold'>GST Invoice</div>
        <div class='invoice'>
            <div class='container-fluid shop-details p-0 mb-5'>
                <div class="detail-header p-2 b-bottom">
                    <div class="bold">Invoice No. : <?php echo $inv_temp->i_no; ?></div>
                    <div class="bold">Date : <?php echo $inv_temp->i_date; ?></div>
                </div>
                <div class="shop-detailed b-bottom p-2 text-center">
                    <h5 class='shop-name'><?php echo $inv_temp->s_name; ?></h5>
                    <h6 class='shop-address'>Address: <?php echo $inv_temp->s_add; ?></h6>
                    <h6 class='shop-address'>Mob no.: <?php echo $inv_temp->s_contact; ?></h6>
                    <h6 class="bold">GSTIN: <?php echo $inv_temp->shop_gst_no; ?> | PAN NO: <?php echo $inv_temp->pan_no; ?></h6>
                </div>
                <div class='customer-details p-2'>
                    <div class="billed-to bold">Billed To:</div>
                    <div class='customer-name bold'><?php echo $inv_temp->c_name; ?></div>
                    <div class='customer-address'>Address: <?php echo $inv_temp->c_add; ?></div>
                    <div class='customer-address'>Contact: <?php echo $inv_temp->c_contact; ?></div>
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
                        <?php echo $inv_temp->product_list; ?>
                    </div>
                </div>
                <div class="invoice-body-footer b-top row m-0 pr-0">
                    <div class="col-md-6 bold">Total : </div>
                    <div class="col-md-2 b-left total-amount">
                        <span class="text-14 total-amount-content">&#8377;<?php echo $inv_temp->total_amount; ?></span>
                    </div>
                    <div class="b-left text-14 col-md-1">&#8377;<?php echo  $inv_temp->display_total_cgst; ?></div>
                    <div class="b-left text-14 col-md-1">&#8377;<?php echo $inv_temp->display_total_sgst; ?></div>
                    <div class="gst col-md-2 b-left">
                        <div class="text-14">GRAND TOTAL : &#8377;<?php echo $inv_temp->display_total_amount_with_gst; ?></div>
                    </div>
                </div>
                <div class="amount-in-words b-top row m-0">
                    <span class="col-md-12 bold">Amount in words: <?php echo $inv_temp->total_amount_in_words; ?></span>
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
                                FOR <?php echo $inv_temp->s_name; ?>
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
    <script type="text/javascript">
        window.print(); 
    </script>
</body>
</html>
