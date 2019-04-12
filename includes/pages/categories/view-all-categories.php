<?php
$model_name = "Category";
$column_names_as = array(
        "category_id" => "Category Id",
        "category_name" => "Category Name",
        "gst_id" => "GST Id",
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
                    echo "<td><a class='btn btn-primary text-white' data-toggle='tooltip' href='categories.php?src=edit-category&id={$row["category_id"]}' data-html='true' title='Edit'><i class='fa fa-edit'></i></a></td>";
                    echo "<td><a class='btn btn-danger text-white'  data-toggle='tooltip' data-html='true' title='Delete'  data-delete='categories.php?form=delete-category&id={$row["category_id"]}'><i class='fa fa-times'></i></a></td>";
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