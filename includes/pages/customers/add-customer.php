

<?php
    #cheking if the submit button was pressed
    if(isset($_POST['add_customer'])){

        #requring the customer class for database operations
        require_once ("db/models/Customer.class.php");
        try{
            $array = $_POST;//adding the form data to an array

            unset($array['add_customer']);//unsetting the add_customer field as it is the name of the submit button that was pressed

            $arrayKeys = array_keys($array);//getting all the filed names that we want to add in db

            $customer = new Customer();

            foreach ($arrayKeys as $item) {
                $customer->$item = $array[$item];
            }

            if($customer->insert()){
                //showing a toast when a customer is successfully added
                include_once ("includes/toast/show-toast.php");
                showToast("Customer", "Customer is added successfully");
            }else{
                include_once ("includes/toast/show-toast.php");
                showToast("Customer", "Customer already exists");
            }
        }catch(Exception $ex){
            print_r($ex);
        }
    }

?>

<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <h3>Add New Customer</h3>
            <hr>

            <div class="form-group">
                <label for="customer_name">Customer name</label>
                <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Enter Customer name">
            </div>

            <div class="form-group">
                <label for="customer_email">Email</label>
                <input type="email" class="form-control" name="customer_email" id="customer_email" placeholder="Enter email address">
            </div>

            <div class="form-group">
                <label for="customer_contact">Contact Number</label>
                <input type="number" class="form-control" name="customer_contact" id="customer_contact" placeholder="Enter contact number">
            </div>

            <div class="form-group">
                <label for="customer_address">Address</label>
                <textarea class="form-control" name="customer_address" id="customer_address" placeholder="Enter address"></textarea>
            </div>

            <button type="submit" name="add_customer" id="add_customer" class="btn btn-primary">Add Customer</button>
        </form>
    </div>
</div>



