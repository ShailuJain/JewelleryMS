<?php
$model_name = "Customer";
require_once "db/models/{$model_name}.class.php";
$rs = Customer::viewAll();
$column_names_as = array(
    "serial_no" => "Serial No",
    "customer_name" => "Customer Name",
    "customer_email" => "Customer Email",
    "customer_contact" => "Customer Contact",
    "customer_address" => "Customer Address",
);
require_once 'includes/pages/customers/delete-customer.php';
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
//                    $rs=$model_name::select();
                    while($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        foreach ($column_names as $column_name) {
                            echo "<td>$row[$column_name]</td>";
                        }
                        echo "<td><a class='btn btn-primary text-white' href='customers.php?src=edit-customer&id={$row["customer_id"]}' data-toggle='tooltip' data-html='true' title='Edit this product'><i class='fa fa-edit'></i></a></td>";
                        echo "<td><a class='btn btn-danger text-white delete' data-toggle='modal' data-target='#deleteModal' data-html='true' title='Delete this product' data-delete='customers.php?form=delete-customer&id={$row["customer_id"]}'><i class='fa fa-times'></i></a></td>";
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
?>