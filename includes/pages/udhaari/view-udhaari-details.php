<?php
require_once('db/models/Customer.class.php');
require_once('db/models/Udhaari.class.php');

require_once 'constants.php';
require_once('helpers/redirect-helper.php');
if (isset($id)) {
    $udhaari_to_edit = Udhaari::find("udhaari_id = ?", $id);
    ?>
    <div class="row">
        <div class="offset-1 col-md-10">
            <h3>Udhaari Details <span class="float-right"><a class='btn btn-danger text-white delete' data-toggle='modal' data-target='#deleteModal' data-html='true' title='Delete' data-delete='udhaaris.php?form=delete-udhaari&id=<?php echo $id;?>'>Delete <i class='fa fa-trash'></i></a></span></h3>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="udhaari_date" data-toggle="tooltip" data-placement="right" title="">Udhaari Date <i
                            class="fa fa-question-circle"></i></label>
                    <input disabled type="date" class="form-control" name="udhaari_date" id="udhaari_date"
                           value="<?php echo $udhaari_to_edit->udhaari_date; ?>">
                </div>

                <div class="form-group col-md-4 offset-1">
                    <label for="udhaari_no" data-toggle="tooltip" data-placement="right" title="">Udhaari No. <i
                            class="fa fa-question-circle"></i></label>
                    <input disabled type="text" class="form-control" name="udhaari_no" id="udhaari_no"
                           placeholder="Enter Udhaari No. " value="<?php echo $udhaari_to_edit->udhaari_no; ?>">
                </div>

                <div class="form-group col-md-3 offset-1">
                    <label for="due_date" data-toggle="tooltip" data-placement="right" title="">Due Date <i
                            class="fa fa-question-circle"></i></label>
                    <input disabled type="date" class="form-control" name="due_date" id="due_date"
                           value="<?php echo $udhaari_to_edit->due_date; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="total_amount" data-toggle="tooltip" data-placement="right" title="">Total Amount <i
                            class="fa fa-question-circle"></i></label>
                    <input disabled type="text" class="form-control" name="total_amount" id="total_amount"
                           value="&#8377;<?php echo $udhaari_to_edit->udhaari_amount; ?>">
                </div>
                <div class="form-group col-md-3 offset-1">
                    <label for="pending_amount" data-toggle="tooltip" data-placement="right" title="">Pending Amount <i class="fa fa-question-circle"></i></label>
                    <input disabled type="text" class="form-control" name="pending_amount" id="pending_amount"
                           value="&#8377;<?php echo $udhaari_to_edit->pending_amount; ?>">
                </div>
            </div>

            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="heading" data-toggle="collapse" data-target="#customerCollapse"
                         aria-expanded="true" aria-controls="customerCollapse">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button">
                                Customer Details
                            </button>
                        </h5>
                    </div>
                    <div id="customerCollapse" class="collapse" aria-labelledby="heading">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">

                                    <label for="customer_name" data-toggle="tooltip" data-placement="right" title="">Customer Name</label>
                                    <?php
                                    $customer = Customer::find("customer_id = ?", $udhaari_to_edit->customer_id);
                                    echo "<input value='$customer->customer_name' disabled type='text' class='form-control' name='customer_name' id='customer_name'>";
                                    ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="customer_contact" data-toggle="tooltip" data-placement="right" title="">Customer Contact</label>
                                    <?php
                                    echo "<input value='$customer->customer_contact' disabled type='text' class='form-control' name='customer_contact' id='customer_contact'>";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingTwo" data-toggle="collapse"
                         data-target="#paymentCollapse"
                         aria-expanded="true" aria-controls="paymentCollapse">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button">
                                Payment Details
                            </button>
                        </h5>
                    </div>
                    <?php
                    $rs = Udhaari::viewPaymentDetails($id);
                    //This array will store the table headers for the columns we are selecting from database
                    $column_names_as = array(
                        "payment_id" => "Payment Id",
                        "payment_amount" => "Payment Amount",
                        "payment_date" => "Payment Date",
                        "payment_mode" => "Payment Mode",
                    );
                    ?>
                    <div id="paymentCollapse" class="collapse" aria-labelledby="headingTwo">
                        <div class="card-body">
                            <div class="text-center">
                                <a class='btn btn-primary text-white' data-toggle='tooltip' href='payments.php?src=add-payment&p-of=udhaari&id=<?php echo $id; ?>' data-html='true' title='Make payment'><i class='fa fa-money-bill-wave'></i> Make Payment</a>
                            </div>
                            <div class="table-responsive">
                                <table class="tables table table-bordered">
                                    <thead>
                                    <tr>
                                        <?php
                                        foreach ($column_names_as as $column_name_as) {
                                            echo "<th>{$column_name_as}</th>";
                                        }
                                        ?>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $column_names = array_keys($column_names_as);
                                    while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr>";
                                        foreach ($column_names as $column_name) {
                                            if (empty($row[$column_name])) {
                                                echo "<td>NULL</td>";
                                            } else {
                                                echo "<td>$row[$column_name]</td>";
                                            }
                                        }
                                        echo "<td><a class='btn btn-danger text-white delete' data-toggle='modal' data-target='#deleteModal' data-html='true' title='Delete this payment' data-delete='payments.php?form=delete-payment&id={$row["payment_id"]}'><i class='fa fa-trash'></i></a></td>";
                                        echo "</tr>";
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
    </div>
    <?php
}
include_once 'includes/modal.php';
$body = "<h4>Note: </h4> Please check if all the usages of this particular entry has been deleted or else entry will not be deleted.";
createModal(DELETE_TITLE, $body, "Delete");
?>