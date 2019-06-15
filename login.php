<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    $wrong = "";
    $title = "Login Page";
    include_once("includes/header.php");
    require_once("includes/pages/auth/process-login.php");
    ?>
    <body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-8 offset-2">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" action="login.php" method="post">
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                   name="user_password" id="user_password" placeholder="Password">
                                            <p class="text-danger ml-2"><?php echo $wrong; ?></p>
                                        </div>

                                        <input type="submit" class="btn btn-primary btn-block btn-user" name="login"
                                               id="login" value="Login">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- Bootstrap core JavaScript-->
    <?php
    require_once('includes/core-scripts.php');
    ?>


    </body>

    </html>

    <?php
}else{
    header("Location: index.php");
}