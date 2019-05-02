<?php
$model_name = "Purchase";
require_once "db/models/{$model_name}.class.php";
$rs = Purchase::viewAll();
//This array will store the table headers for the columns we are selecting from databse
$column_names_as = array(
        "serial_no" => "SR.No",
        "purchase_title" => "Title",
        "date_of_purchase" => "Date of purchase",
        "total_purchase_amount" => "Total amount",
        "supplier_name" => "Supplier"
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
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $column_names = array_keys($column_names_as);
                    while($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        foreach ($column_names as $column_name) {
                            if(empty($row[$column_name]))
                            {
                                echo "<td>NULL</td>";
                            }
                            else
                            {
                                echo "<td>$row[$column_name]</td>";
                            }
                        }
                        echo "<td><a class='btn btn-info text-white' data-toggle='tooltip' data-html='true' title='View Detail' data-delete=''><i class='fa fa-info'></i></a></td>";
                        echo "<td><a class='btn btn-primary text-white' data-toggle='tooltip' href='' data-html='true' title='Edit'><i class='fa fa-edit'></i></a></td>";
                        echo "<td><a class='btn btn-danger text-white' data-toggle='tooltip' data-html='true' title='Delete' data-delete=''><i class='fa fa-times'></i></a></td>";
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