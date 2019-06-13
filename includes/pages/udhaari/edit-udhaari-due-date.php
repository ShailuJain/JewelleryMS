<?php
require_once('db/models/Udhaari.class.php');
require_once('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
require_once('db/models/Payment.class.php');
require_once 'constants.php';
if (isset($_POST[EDIT_UDHAARI])) {
    try {
        $arr = $_POST;
        unset($arr[EDIT_UDHAARI]);
        $arrKeys = array_keys($arr);
        $udhaari_id = $_GET['id'];
        $udhaari = Udhaari::find("udhaari_id = ?", $udhaari_id);

        $udhaari->due_date = $arr['due_date'];
        if ($udhaari->update()) {
            setStatusAndMsg("success", "udhaari due date updated successfully");
            redirect_to(VIEW_ALL_UDHAARIS);
        } else {
            setStatusAndMsg("error", "udhaari due date could not be updated");
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
                <h3>Edit Udhaari - Extend Due date</h3>
                <hr>
                <input type="hidden" name="udhaari_id" value="<?php echo $udhaari_to_edit->udhaari_id; ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="udhaari_no" data-toggle="tooltip" data-placement="right" title="">Udhaari
                            No. <i class="fa fa-question-circle"></i></label>
                        <input type="text" class="form-control" name="udhaari_no" id="udhaari_no" required
                               value="<?php echo $udhaari_to_edit->udhaari_no; ?>" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="due_date" data-toggle="tooltip" data-placement="right" title="">Due Date <i
                                    class="fa fa-question-circle"></i></label>
                        <input type="date" class="form-control" name="due_date" id="due_date"
                               value="<?php echo $udhaari_to_edit->due_date; ?>" required
                               min="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
                <button type="submit" name="edit_udhaari" id="edit_udhaari" class="btn btn-primary">Edit Payment
                </button>
            </form>
        </div>
    </div>
    <?php
}
?>