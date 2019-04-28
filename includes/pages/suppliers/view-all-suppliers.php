<?php
/**
 * Created by PhpStorm.
 * User: sanjay
 * Date: 19-03-2019
 * Time: 08:24 PM
 */

$model_name = "Supplier";
$column_names_as = array(
    "supplier_id" => "Supplier Id",
    "supplier_name" => "Supplier Name",
    "supplier_email" => "Supplier Email",
    "supplier_contact" => "Supplier Contact",
    "supplier_address" => "Supplier Address",
    "supplier_shopname" => "Supplier Shopname",
    "gst_no" => "Supplier GST no"
);
require_once 'includes/pages/suppliers/delete-supplier.php';
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
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $column_names = array_keys($column_names_as);
                    require_once "db/models/{$model_name}.class.php";
                    $rs=$model_name::select();
                    while($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        foreach ($column_names as $column_name) {
                            echo "<td>$row[$column_name]</td>";
                        }
                        echo "<td><a class='btn btn-primary text-white' href='suppliers.php?src=edit-supplier&id={$row["supplier_id"]}' data-toggle='tooltip' data-html='true' title='Edit this Supplier'><i class='fa fa-edit'></i></a></td>";
                        echo "<td><a class='btn btn-danger text-white'  data-toggle='tooltip' data-html='true' title='Delete'  data-delete='suppliers.php?form=delete-supplier&id={$row["supplier_id"]}'><i class='fa fa-times'></i></a></td>";
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
?>