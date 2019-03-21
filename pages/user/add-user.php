<div class="row">
    <div class="col-md-12">
        <form action="" method="" role="form" enctype="multipart/form-data">
            <legend>Add New User</legend>
            <hr>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
            </div>

            <div class="form-group">
                <label for="confirm_password">Password</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm password">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" id="email" placeholder="Enter email address">
            </div>

            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="number" class="form-control" name="contact" id="contact" placeholder="Enter contact number">
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" name="address" id="address" placeholder="Enter address"></textarea>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control">
                    <option value="0">Select Role</option>
                    <option value="1">Admin</option>
                    <option value="2">Normal</option>
                </select>
            </div>

            <button type="submit" name="add_user" id="add_user" class="btn btn-primary">Add user</button>
        </form>
    </div>
</div>
