<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <?php
    include_once ("includes/charts/earnings.php");
    ?>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <?php
        include_once ("includes/charts/earningoverview.php");
        ?>

        <!-- Pie Chart -->
        <?php
        include_once ("includes/charts/revenuesouces.php");
        ?>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <?php
        include_once ("includes/charts/projects.php");
        ?>


    </div>

</div>
<!-- /.container-fluid -->

</div>