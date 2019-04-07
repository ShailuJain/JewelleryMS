<?php
require_once ('db/models/Customer.class.php');
require_once ('helpers/redirect-helper.php');
require_once ('constants.php');
if(isset($_POST[ADD_CUSTOMER]))
{
    try
    {
        $array = $_POST;//adding the form data to an array
        unset($array[ADD_CUSTOMER]);//unset the submit button that was pressed

        $arrayKeys = array_keys($array);//getting all the filed names that we want to add in db

        $customer = new Customer();

        foreach ($arrayKeys as $item) {
            $customer->$item = $array[$item];
        }
        if($customer->insert()){
            //showing a toast when a customer is successfully added
            setStatusAndMsg("success","Customer added successfully");
        }
        else{
            setStatusAndMsg("error","Customer already exists");
        }
    }catch (Exception $ex){
        setStatusAndMsg("error","Something went wrong");
    }
}
?>
<div class="row">
    <div class="offset-1 col-md-10">
        <form id="form" action="" method="post" role="form" enctype="multipart/form-data">
            <h3>Add New Customer</h3>
            <hr>

            <div class="form-group">
                <label for="customer_name">Customer name</label>
                <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Enter Customer name" required>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="customer_email">Email</label>
                    <input type="email" class="form-control" name="customer_email" id="customer_email" placeholder="Enter email address">
                </div>
                <div class="form-group col-md-6">
                    <label for="customer_contact">Contact Number</label>
                    <input type="number" class="form-control" name="customer_contact" id="customer_contact" placeholder="Enter contact number" required min="10" max="13">
                </div>
            </div>


            <div class="form-group">
                <label for="customer_address">Address</label>
                <textarea class="form-control" name="customer_address" id="customer_address" placeholder="Enter address"></textarea>
            </div>

            <button type="submit" name="add_customer" id="add_customer" class="btn btn-primary">Add Customer</button>
        </form>
    </div>
</div>