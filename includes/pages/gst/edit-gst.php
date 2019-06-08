<?php
require_once('db/models/Category.class.php');
require_once('db/models/GST.class.php');
require_once 'constants.php';
require_once ('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
if(isset($_POST[EDIT_GST])){
    try{
        if(!(empty($_POST['hsn_code']) || empty($_POST['gst_rate']))){
            CRUD::setAutoCommitOn(false);
            $gst_id = $_POST['gst_id'];
            $gst = new GST();
            $gst->hsn_code = $_POST['hsn_code'];
            $gst->gst_rate = $_POST['gst_rate'];
            if(isset($_POST['wef']))
                $gst->wef = $_POST['wef'];
            else
                $gst->wef = date('Y-m-d');
            if($gst->update()){
                $insert_id = CRUD::lastInsertId();
                if(CRUD::query("UPDATE categories SET gst_id = ? WHERE gst_id = ?", $insert_id, $gst_id)){
                    CRUD::commit();
                    setStatusAndMsg("success","GST entry updated successfully");
                    redirect_to(VIEW_ALL_GST);
                }else{
                    CRUD::rollback();
                    setStatusAndMsg("error","Something went wrong 1");
                }
            }else{
                CRUD::rollback();
                setStatusAndMsg("error","Something went wrong 2");
            }
        }
        else{
            CRUD::rollback();
            setStatusAndMsg("error","Fill all the fields");
        }
    } catch(Exception $e){
        CRUD::rollback();
        setStatusAndMsg("error","Something went wrong 3");
    }
    CRUD::setAutoCommitOn(true);
}
if(isset($id)) {
    $gst_to_edit = GST::find("gst_id = ?", $id);
    if ($gst_to_edit) {
        if($gst_to_edit->isLatest()){
        ?>
        <div class="row">
            <div class="offset-1 col-md-10">
                <form action="" method="post" role="form" enctype="multipart/form-data">
                    <h3>Edit GST Entry</h3>
                    <hr>

                    <input type="hidden" name="gst_id" value="<?php echo $gst_to_edit->gst_id; ?>">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="hsn_code" data-toggle="tooltip" data-placement="right" title="HSN Code is a code given to categories" >HSN Code <i class="fa fa-question-circle"></i></label>
                            <input type="number" class="form-control" name="hsn_code" id="hsn_code" readonly
                                   value="<?php echo $gst_to_edit->hsn_code; ?>" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="gst_rate" data-toggle="tooltip" data-placement="right" title="Rate provided for the hsn code" >GST Rate <i class="fa fa-question-circle"></i></label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="gst_rate" id="gst_rate" placeholder="Enter GST rate" aria-describedby="percent" required min="1" max="100" step="any" value="<?php echo $gst_to_edit->gst_rate; ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="percent">%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="wef" data-toggle="tooltip" data-placement="right" title="The date from which the rate for hsn code is effective. Default is current datetime" >With Effect From <i class="fa fa-question-circle"></i></label>
                        <input type="date" class="form-control" name="wef" id="wef"
                               placeholder="Select with effect from"
                               value="<?php echo $gst_to_edit->wef; ?>"
                               min="<?php echo date('Y-m-d', strtotime($gst_to_edit->wef . ' +1 day')); ?>"
                               max="<?php echo date('Y-m-d'); ?>" required >
                    </div>
                    <button type="submit" name="<?php echo EDIT_GST; ?>" id="<?php echo EDIT_GST; ?>"
                            class="btn btn-primary">Edit GST Entry
                    </button>
                </form>
            </div>
        </div>
        <?php

        }else{
            redirect_to("404.php");
        }
    }else{
        redirect_to("404.php");
    }
}else{
    redirect_to("404.php");
}
?>