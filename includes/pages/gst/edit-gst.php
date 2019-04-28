<?php
require_once('db/models/Category.class.php');
require_once('db/models/GST.class.php');
require_once 'constants.php';
require_once ('helpers/redirect-helper.php');
if(isset($_POST[EDIT_GST])){
    try{
        if(!empty($_POST['hsn_code']) && !empty($_POST['gst_rate'])){
            $gst = new GST();
            $gst->gst_id = $_POST['gst_id'];
            $gst->hsn_code = $_POST['hsn_code'];
            $gst->gst_rate = $_POST['gst_rate'];
            if(isset($_POST['wef']))
                $gst->wef = $_POST['wef'];
            else
                $gst->wef = date('Y-m-d');
            if($gst->insert()){
                setStatusAndMsg("success","GST entry updated successfully");
            }else{
                setStatusAndMsg("error","GST details invalid");
            }
        }
        else{
            setStatusAndMsg("error","Enter valid details");
        }
    } catch(Exception $e){
        setStatusAndMsg("error","Something went wrong");
    }
}
if(isset($id)) {
    $gst_to_edit = GST::find("gst_id = ?", $id);
    if ($gst_to_edit) {
        if($gst_to_edit->isLatest()){
        ?>
        <div class="row">
            <div class="offset-1 col-md-10">
                <form action="" method="post" role="form" enctype="multipart/form-data">
                    <h3>Add New GST Entry</h3>
                    <hr>

                    <input type="hidden" name="gst_id" value="<?php echo $gst_to_edit->gst_id; ?>">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="hsn_code" data-toggle="tooltip" data-placement="right" title="HSN Code is a code given to categories" >HSN Code <i class="fa fa-question-circle"></i></label>
                            <input type="number" class="form-control" name="hsn_code" id="hsn_code" disabled
                                   value="<?php echo $gst_to_edit->hsn_code; ?>">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="gst_rate" data-toggle="tooltip" data-placement="right" title="Rate provided for the hsn code" >GST Rate <i class="fa fa-question-circle"></i></label>
                            <input type="number" class="form-control" name="gst_rate" id="gst_rate"
                                   placeholder="Enter GST rate" value="<?php echo $gst_to_edit->gst_rate; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="wef" data-toggle="tooltip" data-placement="right" title="The date from which the rate for hsn code is effective. Default is current datetime" >With Effect From <i class="fa fa-question-circle"></i></label>
                        <input type="datetime-local" class="form-control" name="wef" id="wef"
                               placeholder="Select with effect from"
                               value="<?php echo str_replace(' ', 'T', $gst_to_edit->wef); ?>">
                    </div>
                    <button type="submit" name="<?php echo EDIT_GST; ?>" id="<?php echo EDIT_GST; ?>"
                            class="btn btn-primary">Add GST Entry
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