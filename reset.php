<!DOCTYPE html>
<html lang="en">
<?php
if (!isset($_GET['token'])) {
    header("Location: login.php");
} else {
    $token = $_GET['token'];
}
include_once("includes/pages/auth/process-reset.php");

?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Forgot Password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/style.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Reset Your Password</h1>
                                </div>
                                <form class="user" method="post"">
                                    <input type="hidden" value=<?php echo "{$token}"; ?> name="token">
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="user_password" name="user_password" aria-describedby="emailHelp" placeholder="Enter New Password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="user_confirm_password" name="user_confirm_password" aria-describedby="emailHelp" placeholder="Confirm Your Password">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block btn-user" name="reset" id="reset">Reset Password</button>
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
<script src="includes/core-scripts.php"></script>

</body>

</html>
