<div class="card o-hidden border-0 shadow-lg">
    <div class="card-body p-0">
    <!-- Nested Row within Card Body -->
    <div class="row">
        <div class="offset-2 col-lg-8">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add User</h1>
                </div>

                <form class="user">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <input name="user_email" type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address">
                    </div>
                    <div class="form-group">
                        <input name="user_contact" type="number" class="form-control form-control-user" id="user_contact" placeholder="Contact no">
                    </div>
                    <div class="form-group">
                        <textarea name="user_address" id="user_address" placeholder="Address" class="form-control"></textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input name="password" type="password" class="form-control form-control-user" id="password" placeholder="Password">
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password">
                        </div>
                    </div>
                    <a href="login.php" class="btn btn-primary btn-user btn-block">
                        Add
                    </a>
                    <hr>
                </form>

                <hr>
                <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                </div>
                <div class="text-center">
                    <a class="small" href="login.php">Already have an account? Login!</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>