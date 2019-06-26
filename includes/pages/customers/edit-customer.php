<?php
require_once ('db/models/Customer.class.php');
require_once ('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
require_once ('constants.php');
if(isset($_POST[EDIT_CUSTOMER]))
{
    try
    {
        $array = $_POST;//adding the form data to an array
        unset($array[EDIT_CUSTOMER]);//unset the submit button that was pressed

        $arrayKeys = array_keys($array);//getting all the filed names that we want to add in db

        $customer = new Customer();

        foreach ($arrayKeys as $item) {
            $customer->$item = $array[$item];
        }
        if($customer->update()){
            //showing a toast when a customer is successfully updated
            setStatusAndMsg("success","Customer updated successfully");
            redirect_to(VIEW_ALL_CUSTOMERS);
        }
        else{
            setStatusAndMsg("error","Customer already exists");
        }
    }catch (Exception $ex){
        setStatusAndMsg("error","Something went wrong");
    }
}
if(isset($id)) {
    $customer_to_edit = Customer::find("customer_id = ?", $id);
    ?>
    <div class="row">
        <div class="offset-1 col-md-10">
            <form id="form" action="" method="post" role="form" enctype="multipart/form-data">
                <h3>Edit Customer</h3>
                <hr>
                <input type="hidden" name="customer_id" value="<?php echo $customer_to_edit->customer_id; ?>">
                <div class="form-group">
                    <label for="customer_name" data-toggle="tooltip" data-placement="right" title="" >Customer name <i class="fa fa-question-circle"></i></label>
                    <input type="text" class="form-control" name="customer_name" id="customer_name"
                           placeholder="Enter Customer name" value="<?php echo $customer_to_edit->customer_name; ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="customer_email" data-toggle="tooltip" data-placement="right" title="" >Email <i class="fa fa-question-circle"></i></label>
                        <input type="email" class="form-control" name="customer_email" id="customer_email" placeholder="Enter email address" value="<?php echo $customer_to_edit->customer_email; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="customer_contact" data-toggle="tooltip" data-placement="right" title="" >Contact Number <i class="fa fa-question-circle"></i></label>
                        <input type="tel" class="form-control" name="customer_contact" id="customer_contact" placeholder="Enter contact number" required maxlength="13" minlength="10" pattern="\d*" oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Please enter a phone number')" value="<?php echo $customer_to_edit->customer_contact; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="customer_address" data-toggle="tooltip" data-placement="right" title="" >Address <i class="fa fa-question-circle"></i></label>
                    <textarea class="form-control" name="customer_address" id="customer_address"
                              placeholder="Enter address"><?php echo $customer_to_edit->customer_address; ?></textarea>
                </div>
                <button type="submit" name="edit_customer" id="edit_customer" class="btn btn-primary">Edit Customer
                </button>
            </form>
        </div>
    </div>
    <?php
}
    ?>