<?php
function getPendingAmountCustomersHtml($limit = 5, $offset = 0, $dueDatePassed = false)
{
    require_once('db/models/Udhaari.class.php');
    $html = "";
    $edit_btn = "";
    $i = 0;
    $result = Udhaari::getPendingAmountCustomers($limit, $offset, $dueDatePassed);
    $customer_udhaaris = $result->fetchAll();
    foreach ($customer_udhaaris as $customer_udhaari) {
        $i++;
        $bg = "";
        $paid_amount = $customer_udhaari->udhaari_amount - $customer_udhaari->pending_amount;
        $percentage = $paid_amount * 100 / $customer_udhaari->udhaari_amount;
        if ($percentage <= 20) {
            $bg = "bg-danger";
        } else if ($percentage > 20 && $percentage <= 40) {
            $bg = "bg-warning";
        } else if ($percentage > 40 && $percentage <= 60) {
            $bg = "bg-primary";
        } else if ($percentage > 60 && $percentage <= 80) {
            $bg = "bg-info";
        } else if ($percentage > 80 && $percentage <= 100) {
            $bg = "bg-success";
        }
        if ($dueDatePassed === "true") {
            $edit_btn = "<a class='btn btn-outline-danger make-payment-btn ' href='udhaari.php?src=edit-udhaari-due-date&id=$customer_udhaari->udhaari_id' data-toggle='tooltip' data-html='true' title='' data-original-title='Edit this udhaari'><i class='fa fa-edit'> Extend Due date</i></a>";
        }
        $html .= <<<PROGRESS
<div id="customer-udhaari-accordion">
    <div class="card">
        <div class="card-header" id="heading-$i" data-toggle="collapse" data-target="#customer-udhaari-collapse-$i" aria-expanded="true">
            <h4 class="small font-weight-bold">
                $customer_udhaari->customer_name - $customer_udhaari->customer_contact 
                    <a class='btn btn-outline-primary make-payment-btn ml-1' 
                    data-toggle='tooltip' 
                    href='payments.php?src=add-payment&p-of=udhaari&id=$customer_udhaari->udhaari_id'
                    data-html='true' 
                    title='Make payment'>
                        Make Payment <i class='fa fa-money-bill-wave'></i>
                    </a> $edit_btn 
                    <span class="float-right">
                        Due-Date: $customer_udhaari->due_date | Total : &#8377;$customer_udhaari->udhaari_amount
                    </span>
            </h4>
            <div 
            class="progress mb-4" 
            data-toggle="tooltip" 
            title="PAID: &#8377; {$paid_amount}<br>
            PENDING: &#8377; {$customer_udhaari->pending_amount}" 
            data-html="true">
                <div 
                class="progress-bar-striped $bg" 
                role="progressbar" 
                style="width: {$percentage}%" 
                aria-valuenow="$paid_amount" 
                aria-valuemin="0" 
                aria-valuemax="100">
                </div>
            </div>
        </div>
        <div id="customer-udhaari-collapse-$i" class="collapse" aria-labelledby="heading-$i" data-parent="#customer-udhaari-accordion">
            <div class="card-body">
            </div>
        </div>
    </div>
</div>
PROGRESS;
    }
    return $html;
}

if (isset($_POST['limit'])) {
    $limit = $_POST['limit'];
} else {
    $limit = 5;
}
if (isset($_POST['offset'])) {
    $offset = $_POST['offset'];
} else {
    $offset = 0;
}
if (isset($_POST['dueDatePassed'])) {
    $dueDatePassed = $_POST['dueDatePassed'];
} else {
    $dueDatePassed = false;
}

echo getPendingAmountCustomersHtml($limit, $offset, $dueDatePassed);