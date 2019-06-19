<?php
$model_name = "Category";
require_once "db/models/{$model_name}.class.php";
$rs = Category::viewAll();
$column_names_as = array(
    "serial_no" => "Serial No",
    "category_name" => "Category Name",
    "total_quantity" => "Category Quantity in gm",
    "hsn_code" => "HSN Code",
    "gst_rate" => "GST Rate"
);

require_once 'includes/pages/categories/delete-category.php';
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
                        echo "<td><a class='btn btn-primary text-white' href='categories.php?src=edit-category&id={$row["category_id"]}' data-toggle='tooltip' data-html='true' title='Edit this product'><i class='fa fa-edit'></i></a></td>";
                        echo "<td><a class='btn btn-danger text-white delete' data-toggle='modal' data-target='#deleteModal' data-html='true' title='Delete this Category' data-delete='categories.php?src=delete-category&id={$row["category_id"]}'><i class='fa fa-trash'></i></a></td>";
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
?>