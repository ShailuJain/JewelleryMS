<?php
require_once('db/models/Supplier.class.php');
require_once('db/models/Purchase.class.php');

require_once('db/models/Product.class.php');
require_once('db/models/Category.class.php');
require_once 'constants.php';
require_once('helpers/redirect-helper.php');
if (isset($id)) {
    $purchase_to_edit = Purchase::find("purchase_id = ?", $id);
    ?>
    <div class="row">
        <div class="offset-1 col-md-10">
            <h3>Purchase Details</h3>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="purchase_date" data-toggle="tooltip" data-placement="right" title="">Purchase Date <i
                                class="fa fa-question-circle"></i></label>
                    <input disabled type="date" class="form-control" name="purchase_date" id="purchase_date"
                           value="<?php echo $purchase_to_edit->date_of_purchase; ?>">
                </div>

                <div class="form-group col-md-4 offset-1">
                    <label for="purchase_no" data-toggle="tooltip" data-placement="right" title="">Purchase No. <i
                                class="fa fa-question-circle"></i></label>
                    <input disabled type="text" class="form-control" name="purchase_no" id="purchase_no"
                           placeholder="Enter Purchase No. " value="<?php echo $purchase_to_edit->purchase_no; ?>">
                </div>

                <div class="form-group col-md-3 offset-1">
                    <label for="total_purchase_amount" data-toggle="tooltip" data-placement="right" title="">Total
                        Purchase Amount <i
                                class="fa fa-question-circle"></i></label>
                    <input disabled type="text" class="form-control" name="total_purchase_amount"
                           id="total_purchase_amount"
                           value="&#8377; <?php echo $purchase_to_edit->total_purchase_amount; ?>">
                </div>
            </div>
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="heading" data-toggle="collapse" data-target="#supplierCollapse"
                         aria-expanded="true" aria-controls="supplierCollapse">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button">
                                Supplier Details
                            </button>
                        </h5>
                    </div>
                    <div id="supplierCollapse" class="collapse" aria-labelledby="heading">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">

                                    <label for="supplier_detail" data-toggle="tooltip" data-placement="right" title="">Supplier Name</label>
                                    <?php
                                    echo "<input value='$purchase_to_edit->supplier_detail' disabled type='text' class='form-control' name='supplier_detail' id='supplier_detail'>";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingOne" data-toggle="collapse"
                     data-target="#productCollapse"
                     aria-expanded="true" aria-controls="productCollapse">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button">
                            Product Details
                        </button>
                    </h5>
                </div>
                <?php
                $model_name = "Purchase";
                require_once "db/models/{$model_name}.class.php";
                $rs = Purchase::select();
                //This array will store the table headers for the columns we are selecting from database
                $column_names_as = array(
                    "purchase_quantity" => "Purchased Quantity gm's",
                    "purchase_rate" => "Purchased Rate &#8377;",
                    "total_purchase_amount" => "Total amount &#8377;",
                );
                ?>
                <div id="productCollapse" class="collapse" aria-labelledby="headingOne">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="tables table table-bordered">
                                <thead>
                                <tr>
                                    <?php
                                    foreach ($column_names_as as $column_name_as) {
                                        echo "<th>{$column_name_as}</th>";
                                    }
                                    ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $column_names = array_keys($column_names_as);
                                while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    foreach ($column_names as $column_name) {
                                        echo "<td>$row[$column_name]</td>";
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>