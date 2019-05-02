<?php
require_once ('db/models/Supplier.class.php');
require_once ('helpers/redirect-helper.php');
require_once ('constants.php');
if(isset($_POST[ADD_SUPPLIER]))
{
    try
    {
        $array = $_POST;//adding the form data to an array
        unset($array[ADD_SUPPLIER]);//unset the submit button that was pressed 

        $arrayKeys = array_keys($array);//getting all the filed names that we want to add in db

        $Supplier = new Supplier();

        foreach ($arrayKeys as $item) {
            $Supplier->$item = $array[$item];
        }
        if($Supplier->insert()){
            //showing a toast when a customer is successfully added
            setStatusAndMsg("success","Supplier added successfully");
        }
        else{
            setStatusAndMsg("error","Supplier already exists");
        }
    }catch (Exception $ex){
        setStatusAndMsg("error","Supplier went wrong");
    }
}
?>


<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <h3>Add New Supplier</h3>
            <hr>

            <div class="form-group">
                <label for="supplier_name">Supplier Name</label>
                <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Enter supplier name" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="supplier_shopname">Supplier Shop Name</label>
                    <input type="text" class="form-control" name="supplier_shopname" id="supplier_shopname" placeholder="Enter supplier shop name"required>
                </div>
                <div class="form-group col-md-6">
                    <label for="gst_no">GST Number</label>
                    <input type="text" class="form-control" name="gst_no" id="gst_no" placeholder="Enter gst number of supplier"required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="supplier_email">Email</label>
                    <input type="email" class="form-control" name="supplier_email" id="supplier_email" placeholder="Enter email address of supplier"required>
                </div>

                <div class="form-group col-md-6">
                    <label for="supplier_contact">Contact Number</label>
                    <input type="number" class="form-control" name="supplier_contact" id="supplier_contact" placeholder="Enter Contact Number of supplier"required>
                </div>
            </div>



            <div class="form-group">
                <label for="supplier_address">Address</label>
                <textarea class="form-control" name="supplier_address" id="supplier_address" placeholder="Enter Address of supplier"required></textarea>
            </div>

            <button type="submit" name="add_supplier" id="add_supplier" class="btn btn-primary">Add supplier</button>
        </form>
    </div>
</div>
