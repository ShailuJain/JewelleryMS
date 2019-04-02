<div class="row">
    <div class="offset-1 col-md-10">
        <form id="form" action="process-form.php?form=customers/add" method="post" role="form" enctype="multipart/form-data">
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



