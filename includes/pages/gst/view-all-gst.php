<?php
$model_name = "GST";
require_once "db/models/{$model_name}.class.php";

$column_names_as = array(
        "serial_no" => "Serial No",
        "hsn_code" => "HSN Code",
        "gst_rate" => "GST Rate",
        "wef" => "With Effect From",
);
require_once 'includes/pages/gst/delete-gst.php';
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

                $rs=$model_name::viewAll();
                while($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    foreach ($column_names as $column_name) {
                        echo "<td>$row[$column_name]</td>";
                    }
                    echo "<td><a class='btn btn-primary text-white' href='gst.php?src=edit-gst&id={$row["gst_id"]}' data-toggle='tooltip' data-html='true' title='Edit this GST entry'><i class='fa fa-edit'></i></a></td>";
                    echo "<td><a class='btn btn-danger text-white delete' data-toggle='modal' data-target='#deleteModal' data-html='true' title='Delete this GST entry' data-delete='gst.php?src=delete-gst&hsn_code={$row["hsn_code"]}'><i class='fa fa-trash'></i></a></td>";
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
?>