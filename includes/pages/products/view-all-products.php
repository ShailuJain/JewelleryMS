<?php
$model_name = "Product";
require_once "db/models/{$model_name}.class.php";
$rs = CRUD::query("SELECT @sr_no:=@sr_no+1 as serial_no, products.product_id,products.product_name,products.product_quantity,products.additional_specifications, categories.category_name from products INNER JOIN categories on products.category_id = categories.category_id INNER JOIN (SELECT @sr_no:= 0) AS a WHERE products.deleted = 0");
$column_names_as = array(
    "serial_no" => "Serial No",
    "category_name" => "Category Name",
    "product_name" => "Product Name",
    "product_quantity" => "Product Quantity",
    "additional_specifications" => "Additional Specifications",
);
require_once 'includes/pages/products/delete-product.php';
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
            //    $rs=$model_name::select();
                while($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    foreach ($column_names as $column_name) {
                        echo "<td>$row[$column_name]</td>";
                    }
                    echo "<td><a class='btn btn-primary text-white' href='products.php?src=edit-product&id={$row["product_id"]}' data-toggle='tooltip' data-html='true' title='Edit this product'><i class='fa fa-edit'></i></a></td>";
                    echo "<td><a class='btn btn-danger text-white delete' data-toggle='modal' data-target='#deleteModal' data-html='true' title='Delete this product' data-delete='products.php?form=delete-product&id={$row["product_id"]}'><i class='fa fa-times'></i></a></td>";
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