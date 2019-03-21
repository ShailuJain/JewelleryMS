<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Comp Adminatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sakshi Jewellers - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

</head>
<body>
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

<script src="../../vendor/jquery/jquery.min.js"></script>
<script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src=../../"js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="../../vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="../../js/demo/chart-area-demo.js"></script>
<script src="../../js/demo/chart-pie-demo.js"></script>
</body>
</html>