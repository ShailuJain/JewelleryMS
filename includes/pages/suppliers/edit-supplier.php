<?php
require_once ('db/models/Supplier.class.php');
require_once ('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
require_once ('constants.php');
if(isset($_POST[EDIT_SUPPLIER]))
{
    try
    {
        $array = $_POST;//adding the form data to an array
        unset($array[EDIT_SUPPLIER]);//unset the submit button that was pressed

        $arrayKeys = array_keys($array);//getting all the filed names that we want to add in db

        $supplier = new Supplier();

        foreach ($arrayKeys as $item) {
            $supplier->$item = $array[$item];
        }
        if($supplier->update()){
            //showing a toast when a customer is successfully updated
            setStatusAndMsg("success","Supplier updated successfully");
            redirect_to(VIEW_ALL_SUPPLIERS);
        }
        else{
            setStatusAndMsg("error","Supplier already exists");
        }
    }catch (Exception $ex){
        setStatusAndMsg("error","Something went wrong");
    }
}
if(isset($id)) {
    $supplier_to_edit = Supplier::find("supplier_id = ?", $id);
    ?>
    <div class="row">
        <div class="offset-1 col-md-10">
            <form id="form" action="" method="post" role="form" enctype="multipart/form-data">
                <h3>Edit Supplier</h3>
                <hr>
                <input type="hidden" name="supplier_id" value="<?php echo $supplier_to_edit->supplier_id; ?>">
                <div class="form-group">
                    <label for="supplier_name">Supplier name</label>
                    <input type="text" class="form-control" name="supplier_name" id="supplier_name"
                           placeholder="Enter Supplier name" value="<?php echo $supplier_to_edit->supplier_name; ?>">
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="supplier_email">Email</label>
                        <input type="email" class="form-control" name="supplier_email" id="supplier_email" placeholder="Enter email address" value="<?php echo $supplier_to_edit->supplier_email; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="supplier_contact">Contact Number</label>
                        <input type="tel" class="form-control" name="supplier_contact" id="supplier_contact" placeholder="Enter contact number" required maxlength="13" minlength="10" pattern="\d*" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Please enter a phone number')" value="<?php echo $supplier_to_edit->supplier_contact; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="supplier_shopname">Supplier Shop Name</label>
                        <input type="text" class="form-control" name="supplier_shopname" id="supplier_shopname" placeholder="Enter supplier shop name" value="<?php echo $supplier_to_edit->supplier_shopname; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="gst_no">GST Number</label>
                        <input type="text" class="form-control" name="gst_no" id="gst_no" placeholder="Enter gst number of supplier" value="<?php echo $supplier_to_edit->gst_no;?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="supplier_address">Address</label>
                    <textarea class="form-control" name="supplier_address" id="supplier_address"
                              placeholder="Enter address"><?php echo $supplier_to_edit->supplier_address; ?></textarea>
                </div>

                <button type="submit" name="edit_supplier" id="edit_supplier" class="btn btn-primary">Edit Supplier
                </button>
            </form>
        </div>
    </div>
    <?php
}
?>