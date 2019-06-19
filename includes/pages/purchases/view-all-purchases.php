<?php
$model_name = "Purchase";
require_once "db/models/{$model_name}.class.php";
$rs = Purchase::viewAll();
//This array will store the table headers for the columns we are selecting from database
$column_names_as = array(
        "serial_no" => "SR.No",
        "purchase_no" => "Purchase No",
        "supplier_detail" => "Supplier",
        "date_of_purchase" => "Date of purchase",
        "total_purchase_amount" => "Total amount &#8377;"
);
require_once 'includes/pages/purchases/delete-purchase.php';
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
                        <th>Detail</th>
                        <th>Payment</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $column_names = array_keys($column_names_as);
                    while($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        foreach ($column_names as $column_name) {
                            echo "<td>$row[$column_name]</td>";
                        }
                        echo "<td><a class='btn btn-info text-white' data-toggle='tooltip' href='purchases.php?src=view-purchase-details&id={$row['purchase_id']}' data-html='true' title='View Detail' data-delete=''><i class='fa fa-info'></i></a></td>";
                        echo "<td><a class='btn btn-secondary text-white' data-toggle='tooltip' href='payments.php?src=add-payment&p-of=purchase&id={$row['purchase_id']}' data-html='true' title='Make payment'><i class='fa fa-money-bill-wave'></i></a></td>";
                        echo "<td><a class='btn btn-danger text-white delete' data-toggle='modal' data-target='#deleteModal' data-html='true' title='Delete' data-delete='purchases.php?src=delete-purchase&id={$row['purchase_id']}'><i class='fa fa-trash'></i></a></td>";
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