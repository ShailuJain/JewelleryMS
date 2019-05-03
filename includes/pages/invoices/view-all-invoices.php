<?php
$model_name = "Invoice";
require_once "db/models/{$model_name}.class.php";
$rs = Invoice::viewAll();
//This array will store the table headers for the columns we are selecting from database
$column_names_as = array(
    "invoice_no" => "Invoice NO",
    "customer_name" => "Customer Name",
    "customer_no" => "Customer No",
    "pending_amount" => "Pending Amount",
    "due_date" => "Due Date",
);
?>
    <div class="row">
        <div class="offset-1 col-md-10">
            <div class="table-responsive">
                <table id="tables" class="table table-bordered">
                    <thead>
                    <tr>
                        <?php
                        foreach ($column_names_as as $column_name_as) {
                            echo "<th>{$column_name_as}</th>";
                        }
                        ?>
                        <th>Detail</th>
                        <th>Payments</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $column_names = array_keys($column_names_as);
                    while($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        foreach ($column_names as $column_name) {
                            if(empty($row[$column_name])) {
                                echo "<td>NULL</td>";
                            }
                            else {
                                echo "<td>$row[$column_name]</td>";
                            }
                        }
                        echo "<td><a class='btn btn-info text-white' data-toggle='tooltip' href='invoices.php?src=view-invoice-details&id={$row['invoice_id']}' data-html='true' title='View Detail'><i class='fa fa-info'></i></a></td>";
                        echo "<td><a class='btn btn-secondary text-white' data-toggle='tooltip' href='payments.php?src=add-payment&id={$row['invoice_id']}' data-html='true' title='Make payment'><i class='fa fa-money-bill-wave'></i></a></td>";
                        echo "<td><a class='btn btn-danger text-white' data-toggle='tooltip' data-target='#deleteModal' data-html='true' title='Delete' data-delete='invoices.php?form=delete-invoice&id={$row['invoice_id']}'><i class='fa fa-times'></i></a></td>";
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
?>