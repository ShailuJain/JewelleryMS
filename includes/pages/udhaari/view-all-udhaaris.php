<?php
$model_name = "Udhaari";
require_once "db/models/{$model_name}.class.php";
$rs = Udhaari::viewAll();
$column_names_as = array(
    "udhaari_no" => "Udhaari No",
    "customer_name" => "Customer Name",
    "due_date" => "Due Date",
    "udhaari_amount" => "Udhaari Amount",
    "pending_amount" => "Pending Amount",
);

require_once 'includes/pages/udhaari/delete-udhaari.php';
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
                    require_once "db/models/{$model_name}.class.php";
//                        $rs=$model_name::select();
                    while($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        foreach ($column_names as $column_name) {
                            echo "<td>$row[$column_name]</td>";
                        }
                        echo "<td><a class='btn btn-info text-white' data-toggle='tooltip' href='udhaari.php?src=view-udhaari-details&id={$row['udhaari_id']}' data-html='true' title='View Detail'><i class='fa fa-info'></i></a></td>";
                        echo "<td><a class='btn btn-secondary text-white' data-toggle='tooltip' href='payments.php?src=add-payment&p-of=udhaari&id={$row['udhaari_id']}' data-html='true' title='Make udhaari'><i class='fa fa-money-bill-wave'></i></a></td>";
                        echo "<td><a class='btn btn-danger text-white delete' data-toggle='modal' data-target='#deleteModal' data-html='true' title='Delete this udhaari' data-delete='udhaari.php?src=delete-udhaari&id={$row["udhaari_id"]}'><i class='fa fa-trash'></i></a></td>";
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
$body = "<h4>Note: </h4> Please check if all the usages of this particular entry has been deleted or else entry will not be deleted.";
createModal(DELETE_TITLE, $body, "Delete");