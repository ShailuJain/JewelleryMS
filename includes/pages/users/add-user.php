<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="" role="form" enctype="multipart/form-data">
            <h3>Add New User</h3>
            <hr>

            <div class="form-group">
                <label for="username" data-toggle="tooltip" data-placement="right" title="" >Username <i class="fa fa-question-circle"></i></label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
            </div>

            <div class="form-group">
                <label for="password" data-toggle="tooltip" data-placement="right" title="" >Password <i class="fa fa-question-circle"></i></label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
            </div>

            <div class="form-group">
                <label for="confirm_password" data-toggle="tooltip" data-placement="right" title="" >Repeat Password <i class="fa fa-question-circle"></i></label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm password">
            </div>

            <div class="form-group">
                <label for="email" data-toggle="tooltip" data-placement="right" title="" >Email <i class="fa fa-question-circle"></i></label>
                <input type="text" class="form-control" name="email" id="email" placeholder="Enter email address">
            </div>

            <div class="form-group">
                <label for="contact" data-toggle="tooltip" data-placement="right" title="" >Contact Number <i class="fa fa-question-circle"></i></label>
                <input type="number" class="form-control" name="contact" id="contact" placeholder="Enter contact number">
            </div>

            <div class="form-group">
                <label for="address" data-toggle="tooltip" data-placement="right" title="" >Address <i class="fa fa-question-circle"></i></label>
                <textarea class="form-control" name="address" id="address" placeholder="Enter address"></textarea>
            </div>

            <div class="form-group">
                <label for="role" data-toggle="tooltip" data-placement="right" title="" >Role <i class="fa fa-question-circle"></i></label>
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
