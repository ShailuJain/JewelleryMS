<?php
$model_name = "Payment";
require_once "db/models/{$model_name}.class.php";
$rs = Payment::viewAll();
$column_names_as = array(
    "serial_no" => "Serial No",
    "invoice_no" => "Invoice No",
    "payment_amount" => "Payment Amount",
    "payment_mode" => "Payment Mode",
    "payment_date" => "Payment Date",
);

require_once 'includes/pages/payments/delete-payment.php';
?>
    <div class="row">
        <div class="offset-1 col-md-10">
            <div class="table-responsive">
                <table class="tables table table-bordered">
                    <thead>
                    <tr>
                        <?php
                        foreach ($column_names_as as $column_name_as) {
                            echo "<th>{$column_name_as}</th>";
                        }
                        ?>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $column_names = array_keys($column_names_as);
                    require_once "db/models/{$model_name}.class.php";
                    //    $rs=$model_name::select();
                    while($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        foreach ($column_names as $column_name) {
                            echo "<td>$row[$column_name]</td>";
                        }
                        echo "<td><a class='btn btn-primary text-white' href='payments.php?src=edit-payment&id={$row["payment_id"]}' data-toggle='tooltip' data-html='true' title='Edit this payment'><i class='fa fa-edit'></i></a></td>";
                        echo "<td><a class='btn btn-danger text-white delete' data-toggle='modal' data-target='#deleteModal' data-html='true' title='Delete this payment' data-delete='payments.php?form=delete-payment&id={$row["payment_id"]}'><i class='fa fa-trash'></i></a></td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
include_once 'includes/modal.php';
createModal(DELETE_TITLE, DELETE_MSG, "Delete");