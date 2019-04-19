<?php


class InvoiceTemplate
{
    private $invoice = "";
    private $title = "";
    private $shop_name = "";
    private $shop_address = "";

    private function build()
    {
        $this->invoice = "
                            <!DOCTYPE html>
                            <html>
                            <head>
                                <title>$this->title</title>
                            </head>
                            <body>
                                <div class='shop-details'>
                                    <h1 class='shop-name'>$this->shop_name</h1>
                                    <h4 class='shop-address'>$this->shop_address</h4>
                                </div>
                            </body>
                            </html>
                         ";
    }
    public function createAndReturn()
    {
        $this->build();
        return $this->invoice;
    }
    public function createAndRedirect()
    {

    }
}