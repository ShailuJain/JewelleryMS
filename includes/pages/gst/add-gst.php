<?php
require_once('db/models/Category.class.php');
require_once('db/models/GST.class.php');
require_once 'constants.php';
require_once ('helpers/redirect-helper.php');
if(isset($_POST[ADD_GST])){
    try{
        if(!(empty($_POST['hsn_code']) || empty($_POST['gst_rate']))){
            $gst = new GST();
            $gst->hsn_code = $_POST['hsn_code'];
            $gst->gst_rate = $_POST['gst_rate'];
            if(isset($_POST['wef']))
                $gst->wef = $_POST['wef'];
            else
                $gst->wef = date('Y-m-d');
            if($gst->insert()){
                setStatusAndMsg("success","GST entry inserted successfully");
            }else{
                setStatusAndMsg("error","HSN code already exits");
            }
        }
        else{
            setStatusAndMsg("error","Fill all the fields");
        }
    } catch(Exception $e){
        setStatusAndMsg("error","Something went wrong");
    }
}
?>
<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <h3>Add New GST Entry</h3>
            <hr>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="hsn_code" data-toggle="tooltip" data-placement="right" title="HSN Code is a code given to categories">HSN Code <i class="fa fa-question-circle"></i></label>
                    <input type="number" class="form-control" name="hsn_code" id="hsn_code" placeholder="Enter hsn-code" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="gst_rate" data-toggle="tooltip" data-placement="right" title="Rate provided for the hsn code" >GST Rate % <i class="fa fa-question-circle"></i></label>
                    <input type="number" class="form-control" name="gst_rate" id="gst_rate" placeholder="Enter GST rate" required min="1" max="100">
                </div>
            </div>

            <div class="form-group">
                <label for="wef" data-toggle="tooltip" data-placement="right" title="The date from which the rate for hsn code is effective. Default is current datetime" >With Effect From <i class="fa fa-question-circle"></i></label>
                <input type="date" class="form-control" name="wef" id="wef" placeholder="Select with effect from" value="<?php echo date("Y-m-d")?>" required>
            </div>
            <button type="submit" name="<?php echo ADD_GST; ?>" id="<?php echo ADD_GST; ?>" class="btn btn-primary">Add GST Entry</button>
        </form>
    </div>
</div>
