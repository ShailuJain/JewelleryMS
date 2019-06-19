<?php
if (isset($payment_of)) {
    $model_name = "Payment";
    require_once "db/models/{$model_name}.class.php";
    if ($payment_of === "purchases") {
        $payment_of_table = "purchases";
        $payment_of_table_id = "purchase_id";
        $show_no = "purchase_no";
        $show_no_title = "Purchase No";
    }else if ($payment_of === "udhaari") {
        $payment_of_table = "udhaari";
        $payment_of_table_id = "udhaari_id";
        $show_no = "udhaari_no";
        $show_no_title = "Udhaari No";
    }
    if (isset($id)) {
        $rs = Payment::viewAll($payment_of_table, $payment_of_table_id, $id);
    } else {
        $rs = Payment::viewAll($payment_of_table, $payment_of_table_id);
    }
    $column_names_as = array(
        "serial_no" => "Serial No",
        "$show_no" => $show_no_title,
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
                    while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        foreach ($column_names as $column_name) {
                            echo "<td>$row[$column_name]</td>";
                        }
                        echo "<td><a class='btn btn-primary text-white' href='payments.php?src=edit-payment&id={$row["payment_id"]}' data-toggle='tooltip' data-html='true' title='Edit this payment'><i class='fa fa-edit'></i></a></td>";
                        echo "<td><a class='btn btn-danger text-white delete' data-toggle='modal' data-target='#deleteModal' data-html='true' title='Delete this payment' data-delete='payments.php?src=delete-payment&p-of=$payment_of_table&id={$row["payment_id"]}'><i class='fa fa-trash'></i></a></td>";
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
}