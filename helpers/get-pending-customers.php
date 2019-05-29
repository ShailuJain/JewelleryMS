<?php
function getPendingAmountCustomersHtml($limit = 5, $offset = 0)
{
    require_once ('db/models/Invoice.class.php');

    $html = "";
    $result = Invoice::getPendingAmountCustomers($limit, $offset);
    $customer_invoices = $result->fetchAll();
    foreach ($customer_invoices as $customer_invoice)
    {
        $bg = "";
        $paid_amount = $customer_invoice->total_amount - $customer_invoice->pending_amount;
        $percentage = $paid_amount * 100 / $customer_invoice->total_amount;
        if($percentage<=20)
        {
            $bg = "bg-danger";
        }else if($percentage>20 && $percentage<=40)
        {
            $bg = "bg-warning";
        }else if($percentage>40 && $percentage<=60)
        {
            $bg = "bg-primary";
        }else if($percentage>60 && $percentage<=80)
        {
            $bg = "bg-info";
        }else if($percentage>80 && $percentage<=100)
        {
            $bg = "bg-success";
        }
        $html .= <<<PROGRESS
<h4 class="small font-weight-bold">$customer_invoice->customer_name - $customer_invoice->customer_contact  <a class='btn btn-outline-primary make-payment-btn ml-1' data-toggle='tooltip' href='payments.php?src=add-payment&id=$customer_invoice->invoice_id' data-html='true' title='Make payment'>Make Payment <i class='fa fa-money-bill-wave'></i></a><span class="float-right">Due-Date: $customer_invoice->due_date | Total : &#8377;$customer_invoice->total_amount</span></h4>
            <div class="progress mb-4" data-toggle="tooltip" title="PAID: &#8377; {$paid_amount}<br>PENDING: &#8377; {$customer_invoice->pending_amount}" data-html="true">
                <div class="progress-bar-striped $bg" role="progressbar" style="width: {$percentage}%" aria-valuenow="$paid_amount" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
PROGRESS;
    }
    return $html;
}