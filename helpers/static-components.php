<!DOCTYPE html>
<html lang="en">
<?php
$title = "Dashboard";
include_once ('constants.php');
include_once ("includes/header.php");
?>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <?php
    include_once ("includes/sidebar.php");
    ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php
            include_once ("includes/navbar.php");
            ?>

            <div id="include">
                <!-- Begin Page Content -->
                <?php
                    include_once ("includes/{$include_page}");
                ?>
                <!-- /.container-fluid -->
            </div>

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php
        include_once ("includes/footer.php");
        ?>

        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->


<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?php
include_once("includes/core-scripts.php")
?>

</body>

</html>
