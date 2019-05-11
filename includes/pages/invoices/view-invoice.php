<?php
try{
    if (isset($id)) {
        require_once ('db/models/Invoice.class.php');
        require_once ('db/models/InvoiceProduct.class.php');
        $invoice_to_create = Invoice::find("invoice_id = ?", $id);
        $invoice_products_to_create = InvoiceProduct::select("*", "invoice_id = ?", $id);

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
            $shop->pan_no = "AIVPP0970D1ZX";
            //bank details :
            $shop->bank_name = "ICIC (GHATKOPAR BRANCH)";
            $shop->account_no = "002605009771";
            $shop->bank_ifsc = "ICIC0000026";

            $products = array();
            $i = 0;
            foreach ($invoice_products_to_create->fetchAll() as $invoice_product){
                $rs = CRUD::query("SELECT gst.hsn_code, gst.gst_rate, categories.category_name, product.product_name FROM categories INNER JOIN gst ON categories.gst_id = gst.gst_id INNER JOIN (SELECT * FROM products WHERE product_id = ?) AS product WHERE categories.category_id = product.category_id", $invoice_product->product_id)->fetch();
                $invoice_product->category_name = $rs->category_name;
                $invoice_product->product_name = $rs->product_name;
                $invoice_product->hsn_code = $rs->hsn_code;
                $invoice_product->gst_rate = $rs->gst_rate;

                $products[$i++] = $invoice_product;
            }

            $inv_temp = new InvoiceTemplate("Invoice - $customer->customer_name", $shop , $customer, $invoice_to_create, $products);
//echo $inv_temp->createAndReturn();
            $inv_temp->createAndRedirect();
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
