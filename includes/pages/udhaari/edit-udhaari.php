<?php
$udhaari_id = $_GET['id'];
require_once('db/models/Udhaari.class.php');
require_once('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
$flag = Udhaari::isUsed($udhaari_id);
echo $flag;
if (!$flag) {
    require_once('db/models/Payment.class.php');
    require_once 'constants.php';
    if (isset($_POST[EDIT_UDHAARI])) {
        try {
            $arr = $_POST;
            unset($arr[EDIT_UDHAARI]);
            $arrKeys = array_keys($arr);
            $udhaari = Udhaari::find("udhaari_id = ?", $udhaari_id);


            $udhaari->due_date = $arr['due_date'];
            $udhaari->udhaari_amount = $arr['udhaari_amount'];
            $udhaari->pending_amount = $udhaari->udhaari_amount;
            if ($udhaari->update()) {
                setStatusAndMsg("success", "udhaari updated successfully");
                redirect_to(VIEW_ALL_UDHAARIS);
            } else {
                setStatusAndMsg("error", "udhaari could not be updated");
            }
        } catch (Exception $ex) {
            setStatusAndMsg("error", "Something went wrong");
        }
    }
    if (isset($id)) {
        $udhaari_to_edit = Udhaari::find("udhaari_id = ?", $id);
        ?>
        <div class="row">
            <div class="offset-1 col-md-10">
                <form id="form" action="" method="post" role="form" enctype="multipart/form-data">
                    <h3>Edit Udhaari</h3>
                    <hr>
                    <input type="hidden" name="udhaari_id" value="<?php echo $udhaari_to_edit->udhaari_id; ?>">
                    <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="udhaari_no" data-toggle="tooltip" data-placement="right" title="">Udhaari
                                    No. <i class="fa fa-question-circle"></i></label>
                                <input type="text" class="form-control" name="udhaari_no" id="udhaari_no" required
                                       value="<?php echo $udhaari_to_edit->udhaari_no; ?>" disabled>
                            </div>
                        <div class="form-group col-md-4">
                            <label for="due_date" data-toggle="tooltip" data-placement="right" title="">Due Date <i
                                        class="fa fa-question-circle"></i></label>
                            <input type="date" class="form-control" name="due_date" id="due_date" value="<?php echo $udhaari_to_edit->due_date; ?>" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="udhaari_amount" data-toggle="tooltip" data-placement="right" title="">Total Udhaari <i
                                        class="fa fa-question-circle"></i></label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="udhaari_amount" id="udhaari_amount" placeholder="Enter total udhaari" aria-describedby="rs" required step="any" value="<?php echo $udhaari_to_edit->udhaari_amount; ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="rs">&#8377;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="edit_udhaari" id="edit_udhaari" class="btn btn-primary">Edit Payment
                    </button>
                </form>
            </div>
        </div>
        <?php
    }
} else {
    redirect_to(VIEW_ALL_UDHAARIS);
    setStatusAndMsg("error", "Udhaari cannot be edited, payments have been made for the udhaari.");
}
?>